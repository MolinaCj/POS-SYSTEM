<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

            $categories = ['noodles', 'bread', 'hygiene', 'canned_goods']; 
            $numberOfRecords = 20000;

            for ($i = 0; $i < $numberOfRecords; $i++) {
                // Randomly select a category
                $category = $faker->randomElement($categories);
        
                // Generate the barcode based on category
                switch ($category) {
                    case 'noodles':
                        $barcode = 'noodles' . str_pad($faker->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT); // noodles00000
                        break;
                    case 'hygiene':
                        $barcode = 'hygiene' . str_pad($faker->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT); // hygiene0000
                        break;
                    case 'canned goods':
                        $barcode = 'cannedg' . str_pad($faker->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT); // cannedg00000
                        break;
                    case 'bread':
                        $barcode = 'bread' . str_pad($faker->numberBetween(1, 9999999), 7, '0', STR_PAD_LEFT); // bread0000000
                        break;
                }
        

                // Log or debug output
                Log::info("Inserting product: {$category} with barcode: {$barcode}");
                DB::table('products')->insert([
                    'barcode' => $barcode,  // Category-based barcode
                    'item_name' => $faker->word(),  // Random product name
                    'stocks' => $faker->numberBetween(1, 500),  // Random stock quantity between 1 and 500
                    'quantity' => 1,  // Always set quantity to 1
                    'price' => $faker->randomFloat(2, 1, 2000),  // Random price between 1 and 2000
                    'category' => $category,  // Randomly selected category
                    'created_at' => Carbon::now(),  // Set created_at timestamp
                    'updated_at' => Carbon::now(),  // Set updated_at timestamp
                ]);
            }
    }
}

//  $table->string('barcode', 12)->unique();
// $table->string('item_name');
// $table->integer('quantity');
// $table->float('price');
// $table->timestamps();