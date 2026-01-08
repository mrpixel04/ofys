<?php

namespace App\Support;

use App\Models\User;

class ProfileCompletion
{
    /**
     * Determine if the given user still has mandatory profile fields empty.
     */
    public static function isIncomplete(User $user): bool
    {
        foreach (self::requiredFields() as $field) {
            if (blank(data_get($user, $field))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resolve the profile route that should be used for the provided user role.
     */
    public static function routeFor(User $user): string
    {
        return match (strtoupper($user->role ?? 'CUSTOMER')) {
            'ADMIN' => 'admin.profile',
            'PROVIDER' => 'provider.profile',
            default => 'customer.profile',
        };
    }

    /**
     * Get the named routes that should stay accessible while completing a profile.
     *
     * @return array<int, string>
     */
    public static function allowedRoutes(User $user): array
    {
        return match (strtoupper($user->role ?? 'CUSTOMER')) {
            'ADMIN' => [
                'admin.profile',
                'admin.profile.update',
                'admin.profile.password',
            ],
            'PROVIDER' => [
                'provider.profile',
                'provider.simple-profile',
                'provider.profile.update',
                'provider.password.update',
            ],
            default => [
                'customer.profile',
                'customer.profile.update',
            ],
        };
    }

    /**
     * Required field names that must be captured to mark a profile as complete.
     *
     * @return array<int, string>
     */
    protected static function requiredFields(): array
    {
        return [
            'phone',
            'address',
            'date_of_birth',
            'gender',
        ];
    }
}
