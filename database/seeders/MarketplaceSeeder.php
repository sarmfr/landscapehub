<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::query()->orderBy('id')->take(2)->get();

        if ($vendors->count() < 2) {
            return;
        }

        $plants = $this->findCategory('plants-flowers');
        $tools = $this->findCategory('garden-tools');
        $irrigation = $this->findCategory('irrigation');
        $design = $this->findCategory('garden-design');
        $maintenance = $this->findCategory('maintenance');
        $landscaping = $this->findCategory('landscaping');

        if (!$plants || !$tools || !$irrigation || !$design || !$maintenance || !$landscaping) {
            return;
        }

        $this->createProduct($plants->id, $vendors[0]->id, 'Desert Rose (Adenium)', 1500, 'https://images.unsplash.com/photo-1591857177580-dc82b9ac4e17?auto=format&fit=crop&q=80&w=800');
        $this->createProduct($plants->id, $vendors[1]->id, 'Snake Plant (Sansevieria)', 1200, 'https://images.unsplash.com/photo-1593482815574-3236873528b8?auto=format&fit=crop&q=80&w=800');
        $this->createProduct($tools->id, $vendors[0]->id, 'Ergonomic Hand Trowel', 850, 'https://images.unsplash.com/photo-1622383563227-04401ab4e5ea?auto=format&fit=crop&q=80&w=800');
        $this->createProduct($tools->id, $vendors[1]->id, 'Professional Bypass Secateurs', 2200, 'https://images.unsplash.com/photo-1599406082404-585641753760?auto=format&fit=crop&q=80&w=800');
        $this->createProduct($irrigation->id, $vendors[0]->id, 'Smart Wi-Fi Sprinkler Controller', 14500, 'https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&q=80&w=800');
        $this->createProduct($irrigation->id, $vendors[1]->id, 'Drip Irrigation Starter Kit', 5800, 'https://images.unsplash.com/photo-1558905619-1af0816fb892?auto=format&fit=crop&q=80&w=800');

        $this->createService($design->id, $vendors[0]->id, '3D Landscape Visualization', 15000, 'fixed', 'https://images.unsplash.com/photo-1458245201577-fc8a130b8829?auto=format&fit=crop&q=80&w=800');
        $this->createService($design->id, $vendors[1]->id, 'Sustainable Garden Consultation', 5000, 'fixed', 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&q=80&w=800');
        $this->createService($maintenance->id, $vendors[0]->id, 'Premium Lawn Mowing', 2500, 'fixed', 'https://images.unsplash.com/photo-1592419044706-39796d40f98c?auto=format&fit=crop&q=80&w=800');
        $this->createService($maintenance->id, $vendors[1]->id, 'Full Garden Cleaning & Weeding', 0, 'quote', 'https://images.unsplash.com/photo-1598902108854-10e335adac99?auto=format&fit=crop&q=80&w=800');
        $this->createService($landscaping->id, $vendors[0]->id, 'Stone Patio Installation', 0, 'quote', 'https://images.unsplash.com/photo-1590333746438-283fd2152520?auto=format&fit=crop&q=80&w=800');
        $this->createService($landscaping->id, $vendors[1]->id, 'Retaining Wall Construction', 0, 'quote', 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&q=80&w=800');
    }

    private function createProduct(int $categoryId, int $vendorId, string $name, float $price, string $imageUrl): void
    {
        $product = Product::query()->updateOrCreate(
            ['slug' => Str::slug($name)],
            [
                'category_id' => $categoryId,
                'vendor_id' => $vendorId,
                'name' => $name,
                'description' => 'High quality ' . $name . ' for your landscaping needs. Durable and reliable.',
                'price' => $price,
                'stock' => 50,
                'status' => 'active',
            ]
        );

        ProductImage::query()->updateOrCreate(
            [
                'product_id' => $product->id,
                'is_primary' => true,
            ],
            [
                'image_path' => $imageUrl,
            ]
        );
    }

    private function createService(int $categoryId, int $vendorId, string $name, float $price, string $pricingType, string $imageUrl): void
    {
        Service::query()->updateOrCreate(
            ['slug' => Str::slug($name)],
            [
                'category_id' => $categoryId,
                'vendor_id' => $vendorId,
                'name' => $name,
                'description' => 'Professional ' . $name . ' provided by experts with years of experience.',
                'price' => $price,
                'pricing_type' => $pricingType,
                'status' => 'active',
                'image_path' => $imageUrl,
            ]
        );
    }

    private function findCategory(string $slug): ?Category
    {
        return Category::query()->where('slug', $slug)->first();
    }
}
