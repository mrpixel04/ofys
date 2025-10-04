<?php

namespace Tests\Feature\Provider;

use App\Models\Activity;
use App\Models\ActivityLot;
use App\Models\ShopInfo;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ActivityManagementTest extends TestCase
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

    public function test_provider_can_update_activity_and_manage_lots_and_images(): void
    {
        $provider = User::factory()->create([
            'role' => 'PROVIDER',
            'email' => 'provider@example.com',
            'email_verified_at' => now(),
        ]);

        $shop = ShopInfo::create([
            'user_id' => $provider->id,
            'company_name' => 'Adventure Co.',
            'company_email' => 'info@adventure.test',
            'country' => 'Malaysia',
        ]);

        $existingImage = 'activity_images/original.jpg';
        Storage::disk('public')->put($existingImage, 'dummy');

        $activity = Activity::create([
            'shop_info_id' => $shop->id,
            'activity_type' => 'camping',
            'name' => 'Forest Camping',
            'description' => 'Original description',
            'location' => 'Forest Site',
            'state' => 'Johor',
            'requirements' => 'Basic fitness',
            'min_participants' => 2,
            'max_participants' => 6,
            'duration_minutes' => 720,
            'price' => 120,
            'price_type' => 'per_person',
            'includes_gear' => false,
            'included_items' => ['tent'],
            'excluded_items' => ['food'],
            'amenities' => ['wifi'],
            'rules' => ['no_smoking'],
            'images' => [$existingImage],
            'is_active' => true,
        ]);

        $lot = ActivityLot::create([
            'activity_id' => $activity->id,
            'provider_id' => $provider->id,
            'name' => 'Lot A',
            'capacity' => 2,
            'description' => 'Shaded area',
            'is_available' => true,
        ]);

        $newImage = UploadedFile::fake()->image('new-image.jpg');

        $response = $this->actingAs($provider)
            ->put(route('provider.activities.update', $activity->id), [
                'activity_type' => 'camping',
                'name' => 'Updated Forest Camping',
                'description' => 'Updated description of the activity.',
                'location' => 'Updated Forest Site',
                'state' => 'Pahang',
                'requirements' => 'Good fitness level',
                'min_participants' => 3,
                'max_participants' => 8,
                'duration_days' => 1,
                'duration_hours' => 6,
                'price' => 199.50,
                'price_type' => 'per_person',
                'includes_gear' => 1,
                'included_items' => ['tent', 'sleeping_bag'],
                'excluded_items' => ['food', 'transport'],
                'amenities' => ['wifi', 'restroom'],
                'rules' => ['no_smoking', 'quiet_hours'],
                'remove_images' => [$existingImage],
                'images' => [$newImage],
                'lots' => [
                    ['id' => $lot->id, 'name' => 'Lot A+', 'capacity' => 5, 'description' => 'Improved lot'],
                    ['name' => 'Lot B', 'capacity' => 3, 'description' => 'New riverside lot'],
                ],
            ]);

        $response->assertRedirect(route('provider.activities.view', $activity->id));
        $response->assertSessionHas('success');

        $activity->refresh();

        $this->assertSame('Updated Forest Camping', $activity->name);
        $this->assertSame('Updated description of the activity.', $activity->description);
        $this->assertEquals(199.50, (float) $activity->price);
        $this->assertTrue($activity->includes_gear);
        $this->assertContains('sleeping_bag', $activity->included_items);
        $this->assertContains('transport', $activity->excluded_items);
        $this->assertContains('restroom', $activity->amenities);
        $this->assertContains('quiet_hours', $activity->rules);

        $this->assertCount(1, $activity->images);
        $newStoredImage = $activity->images[0];
        Storage::disk('public')->assertExists($newStoredImage);
        Storage::disk('public')->assertMissing($existingImage);

        $this->assertCount(2, $activity->lots);
        $this->assertDatabaseHas('activity_lots', [
            'id' => $lot->id,
            'name' => 'Lot A+',
            'capacity' => 5,
        ]);
        $this->assertDatabaseHas('activity_lots', [
            'activity_id' => $activity->id,
            'name' => 'Lot B',
            'capacity' => 3,
        ]);

        $this->get(route('provider.activities.view', $activity->id))
            ->assertOk()
            ->assertSee('Available Lots')
            ->assertSee('Lot A+')
            ->assertSee('Lot B');
    }
}
