<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

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

            $numberOfRecords = 10;

            for($i = 0; $i<$numberOfRecords; $i++){
                DB::table('products')->insert([
                    'barcode' => str_random(12),
                    'item_name' => $faker->word(),
                    'quantity' => $faker->numberBetween(1, 500),
                    'price' => $faker->randomFloat(2, 1, 1000),
                    'created_at' => Carbon::now(), // Set created_at timestamp
                    'updated_at' => Carbon::now(),
                ]);
            }
    }
}

//  $table->string('barcode', 12)->unique();
// $table->string('item_name');
// $table->integer('quantity');
// $table->float('price');
// $table->timestamps();