<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            // Entertainment 
            [
                'name' => 'Entertainment',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Home and Garden
            [
                'name' => 'Home and Garden',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Personal Growth
            [
                'name' => 'Personal Growth',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        $this->category->insert($categories);
    }
}
