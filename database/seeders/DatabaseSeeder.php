<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\data\Categories;
use Database\Seeders\data\Brands;
use Database\Seeders\data\Promos;
use Database\Seeders\data\Products;
use Database\Seeders\data\Specifications;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


//        $this->seedModel(Brands::getData(), 'brands');
//        $this->seedModel(Promos::getData(), 'promos');
//        $this->seedModel(Categories::getData(), 'categories');
     //   $this->seedModel(Specifications::getData(), 'specifications');

        $this->call([
      //      ProductSeeder::class,
//            ProductSpecificationSeeder::class,
            ReactionSeeder::class,
        ]);



        // --------- Truncation -------------

//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//
//        DB::table('reviews')->truncate();
//        DB::table('product_specification')->truncate();
//        DB::table('products')->truncate();
//        DB::table('specifications')->truncate();
//
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }



    public function seedModel(array $model_data, string $table): void
    {
        foreach ($model_data as $item) {
            DB::table($table)->insert($item);
        }
    }
}
