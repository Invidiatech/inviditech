<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seo\Seo;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeoSeeder extends Seeder
{

    public function run(): void
    {
        // Full list of SEO permissions
        $permissions = [
            // General
            'seo view dashboard',
            'seo edit settings',
            'seo manage team',
            'seo view analytics',
            'seo generate reports',
            'seo manage keywords',
            'seo optimize content',
            'seo technical audit',
            'seo manage backlinks',
            'seo invite members',
            'seo manage settings',

            // Pages
            'Create Pages',
            'View Pages',
            'Edit Pages',
            'Delete Pages',

            // Blogs
            'Create Blogs',
            'View Blogs',
            'Edit Blogs',
            'Delete Blogs',

            // Collection
            'Create Collection',
            'View Collection',
            'Edit Collection',
            'Delete Collection',

            // Schema Markup
            'Create Schema Markup',
            'View Schema Markup',
            'Edit Schema Markup',
            'Delete Schema Markup',

            // Sitemap
            'Create Sitemap',
            'View Sitemap',
            'Edit Sitemap',
            'Delete Sitemap',

            // Robots
            'Create Robots',
            'View Robots',
            'Edit Robots',
            'Delete Robots',

            // Redirect Manager
            'Create Redirect Manager',
            'View Redirect Manager',
            'Edit Redirect Manager',
            'Delete Redirect Manager',

            // 404 Suggestions
            'Create 404 Suggestion',
            'View 404 Suggestion',
            'Edit 404 Suggestion',
            'Delete 404 Suggestion',
        ];

        // Create each permission (if not exists)
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'seo'
            ]);
        }

        // Create SEO Head role and assign all permissions
        $seoHead = Role::firstOrCreate([
            'name' => 'seo-head',
            'guard_name' => 'seo'
        ]);
        $seoHead->givePermissionTo($permissions);
        $head = Seo::firstOrCreate(
            ['email' => 'seo.head@techsolutionpro.com'],
            [
                'name' => 'SEO Head',
                'password' => Hash::make('seohead1234'),
                'email_verified_at' => now(),
            ]
        );
        $head->assignRole('seo-head');

        $this->command->info('SEO users, roles, and permissions seeded successfully!');
    }
}
