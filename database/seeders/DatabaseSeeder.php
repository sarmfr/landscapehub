<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUsersAndVendors();
        $this->seedCategories();

        $this->call(MarketplaceSeeder::class);
    }

    private function seedUsersAndVendors(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@landscapehub.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+254700000001',
                'is_verified' => true,
            ]
        );

        $vendorUserA = User::query()->updateOrCreate(
            ['email' => 'vendor1@landscapehub.com'],
            [
                'name' => 'Green Haven Supplies',
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'phone' => '+254700000101',
                'is_verified' => true,
            ]
        );

        $vendorUserB = User::query()->updateOrCreate(
            ['email' => 'vendor2@landscapehub.com'],
            [
                'name' => 'Urban Earth Landscapers',
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'phone' => '+254700000102',
                'is_verified' => true,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'customer@landscapehub.com'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '+254700000201',
                'is_verified' => true,
            ]
        );

        Vendor::query()->updateOrCreate(
            ['user_id' => $vendorUserA->id],
            [
                'business_name' => 'Green Haven Supplies',
                'description' => 'Indoor and outdoor plants, tools, and expert garden care support.',
                'location' => 'Nairobi',
                'approval_status' => 'approved',
                'commission_rate' => 10,
                'profile_image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&q=80&w=800',
                'business_phone' => '+254700000101',
                'business_address' => 'Westlands, Nairobi',
            ]
        );

        Vendor::query()->updateOrCreate(
            ['user_id' => $vendorUserB->id],
            [
                'business_name' => 'Urban Earth Landscapers',
                'description' => 'Landscape design, irrigation planning, and full-service maintenance.',
                'location' => 'Kiambu',
                'approval_status' => 'approved',
                'commission_rate' => 12,
                'profile_image' => 'https://images.unsplash.com/photo-1512428813834-c702c7702b78?auto=format&fit=crop&q=80&w=800',
                'business_phone' => '+254700000102',
                'business_address' => 'Ruiru, Kiambu',
            ]
        );
    }

    private function seedCategories(): void
    {
        $categories = [
            [
                'name' => 'Plants & Flowers',
                'slug' => 'plants-flowers',
                'type' => 'product',
                'description' => 'Decorative plants, flowers, and hardy greenery for homes and compounds.',
                'icon' => 'leaf',
            ],
            [
                'name' => 'Garden Tools',
                'slug' => 'garden-tools',
                'type' => 'product',
                'description' => 'Essential gardening tools for planting, pruning, and maintenance.',
                'icon' => 'wrench',
            ],
            [
                'name' => 'Irrigation Systems',
                'slug' => 'irrigation',
                'type' => 'product',
                'description' => 'Smart irrigation equipment and water management kits.',
                'icon' => 'droplet',
            ],
            [
                'name' => 'Garden Design',
                'slug' => 'garden-design',
                'type' => 'service',
                'description' => 'Planning, visualization, and design services for outdoor spaces.',
                'icon' => 'palette',
            ],
            [
                'name' => 'Maintenance',
                'slug' => 'maintenance',
                'type' => 'service',
                'description' => 'Routine and seasonal garden care services.',
                'icon' => 'shield',
            ],
            [
                'name' => 'Landscaping',
                'slug' => 'landscaping',
                'type' => 'service',
                'description' => 'Build, install, and transform residential and commercial outdoor areas.',
                'icon' => 'building',
            ],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
