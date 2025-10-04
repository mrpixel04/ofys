<?php

namespace Tests\Feature\Provider;

use App\Models\ShopInfo;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        $this->artisan('migrate:fresh', ['--database' => 'sqlite']);

        Storage::fake('public');
    }

    public function test_provider_can_update_profile_details_and_avatar(): void
    {
        $provider = User::factory()->create([
            'role' => 'PROVIDER',
            'email_verified_at' => now(),
            'profile_image' => 'profile_images/original-avatar.jpg',
        ]);

        Storage::disk('public')->put($provider->profile_image, 'avatar');

        ShopInfo::create([
            'user_id' => $provider->id,
            'company_name' => 'Adventure Co.',
            'company_email' => 'info@adventure.test',
            'country' => 'Malaysia',
        ]);

        $newAvatar = UploadedFile::fake()->image('new-avatar.jpg');

        $response = $this->actingAs($provider)->post(route('provider.profile.update'), [
            'name' => 'Updated Provider',
            'email' => 'new-provider@example.com',
            'phone' => '+60123456789',
            'profile_image' => $newAvatar,
        ]);

        $response->assertRedirect(route('provider.profile'));
        $response->assertSessionHas('success');

        $provider->refresh();

        $this->assertSame('Updated Provider', $provider->name);
        $this->assertSame('new-provider@example.com', $provider->email);
        $this->assertSame('+60123456789', $provider->phone);
        $this->assertNotNull($provider->profile_image);
        $this->assertTrue(str_starts_with($provider->profile_image, 'profile_images/'));

        Storage::disk('public')->assertExists($provider->profile_image);
        Storage::disk('public')->assertMissing('profile_images/original-avatar.jpg');
    }

    public function test_provider_can_update_password_with_correct_current_password(): void
    {
        $provider = User::factory()->create([
            'role' => 'PROVIDER',
            'email_verified_at' => now(),
            'password' => Hash::make('secret123'),
        ]);

        ShopInfo::create([
            'user_id' => $provider->id,
            'company_name' => 'Adventure Co.',
            'company_email' => 'info@adventure.test',
            'country' => 'Malaysia',
        ]);

        $response = $this->actingAs($provider)->post(route('provider.password.update'), [
            'current_password' => 'secret123',
            'password' => 'SuperSecret456',
            'password_confirmation' => 'SuperSecret456',
        ]);

        $response->assertRedirect(route('provider.profile'));
        $response->assertSessionHas('success');

        $provider->refresh();
        $this->assertTrue(Hash::check('SuperSecret456', $provider->password));
    }
}
