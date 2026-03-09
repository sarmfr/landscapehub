<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Service;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Support\Str;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::all();
        if ($vendors->isEmpty()) return;

        $categories = Category::all();

        // 1. Plants & Flowers (ID 1)
        $this->createProduct(1, $vendors[0]->id, 'Desert Rose (Adenium)', 1500, 'https://images.unsplash.com/photo-1591857177580-dc82b9ac4e17?auto=format&fit=crop&q=80&w=800');
        $this->createProduct(1, $vendors[1]->id, 'Snake Plant (Sansevieria)', 1200, 'https://images.unsplash.com/photo-1593482815574-3236873528b8?auto=format&fit=crop&q=80&w=800');

        // 2. Garden Tools (ID 2)
        $this->createProduct(2, $vendors[0]->id, 'Ergonomic Hand Trowel', 850, 'https://images.unsplash.com/photo-1622383563227-04401ab4e5ea?auto=format&fit=crop&q=80&w=800');
        $this->createProduct(2, $vendors[1]->id, 'Professional Bypass Secateurs', 2200, 'https://images.unsplash.com/photo-1599406082404-585641753760?auto=format&fit=crop&q=80&w=800');

        // 3. Irrigation Systems (ID 3)
        $this->createProduct(3, $vendors[0]->id, 'Smart Wi-Fi Sprinkler Controller', 14500, 'https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&q=80&w=800');
        $this->createProduct(3, $vendors[1]->id, 'Drip Irrigation Starter Kit', 5800, 'https://images.unsplash.com/photo-1558905619-1af0816fb892?auto=format&fit=crop&q=80&w=800');

        // 4. Garden Design (ID 4 - Service)
        $this->createService(4, $vendors[0]->id, '3D Landscape Visualization', 15000, 'fixed', 'https://images.unsplash.com/photo-1458245201577-fc8a130b8829?auto=format&fit=crop&q=80&w=800');
        $this->createService(4, $vendors[1]->id, 'Sustainable Garden Consultation', 5000, 'fixed', 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&q=80&w=800');

        // 5. Maintenance (ID 5 - Service)
        $this->createService(5, $vendors[0]->id, 'Premium Lawn Mowing', 2500, 'fixed', 'https://images.unsplash.com/photo-1592419044706-39796d40f98c?auto=format&fit=crop&q=80&w=800');
        $this->createService(5, $vendors[1]->id, 'Full Garden Cleaning & Weeding', 0, 'quote', 'https://images.unsplash.com/photo-1598902108854-10e335adac99?auto=format&fit=crop&q=80&w=800');

        // 6. Landscaping (ID 6 - Service)
        $this->createService(6, $vendors[0]->id, 'Stone Patio Installation', 0, 'quote', 'https://images.unsplash.com/photo-1590333746438-283fd2152520?auto=format&fit=crop&q=80&w=800');
        $this->createService(6, $vendors[1]->id, 'Retaining Wall Construction', 0, 'quote', 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&q=80&w=800');
    }

    private function createProduct($catId, $vendorId, $name, $price, $imageUrl)
    {
        $product = Product::create([
            'category_id' => $catId,
            'vendor_id' => $vendorId,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => 'High quality ' . $name . ' for your landscaping needs. Durable and reliable.',
            'price' => $price,
            'stock' => 50,
            'status' => 'active',
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $imageUrl,
            'is_primary' => true,
        ]);
    }

    private function createService($catId, $vendorId, $name, $price, $type, $imageUrl)
    {
        Service::create([
            'category_id' => $catId,
            'vendor_id' => $vendorId,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => 'Professional ' . $name . ' provided by experts with years of experience.',
            'price' => $price,
            'pricing_type' => $type,
            'status' => 'active',
            'image_path' => $imageUrl,
        ]);
    }
}
