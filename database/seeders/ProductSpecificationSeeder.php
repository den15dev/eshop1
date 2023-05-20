<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Specification;
use Database\Seeders\data\ProductSpecificationList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $category_id = Category::where('slug', 'cpu')->first()->id; // CPUs
        $category_id = Category::where('slug', 'hdd')->first()->id; // HDD

        $products = Product::where('category_id', $category_id)->get();
        $specs = Specification::where('category_id', $category_id)->orderBy('id')->get();

        $first_spec_id = $specs->pluck('id')[0];

        $prod_spec_list = ProductSpecificationList::getData();

        foreach ($products as $product) {
            foreach ($specs as $spec) {

                $spec_block = $prod_spec_list[$spec->id - $first_spec_id];
                $value = $spec_block[array_rand($spec_block)];

                DB::table('product_specification')->insert([
                    'product_id' => $product->id,
                    'specification_id' => $spec->id,
                    'spec_value' => $value,
                ]);

            }
        }
    }
}
