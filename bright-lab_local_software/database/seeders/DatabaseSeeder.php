<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        \App\Models\Customers::factory(50)->create();
        $topping_data = array(
            [
                'topping_name' => "Chocolate Banana",
                'topping_price' => "12",

            ],
            [
                'topping_name' => "Strawberry Banana",
                'topping_price' => "10",
            ],
            [
                'topping_name' => "Vanilla Banana",
                'topping_price' => "15",
            ],
            [
                'topping_name' => "Cheese Banana",
                'topping_price' => "14",
            ],
            [
                'topping_name' => "Banana",
                'topping_price' => "7",
            ],
        );
        foreach($topping_data as $t){
            $new_top = new \App\Models\Toppings;
            $new_top->topping_name = $t['topping_name'];
            $new_top->topping_price = $t['topping_price'];
            $new_top->created_at = now();
            $new_top->updated_at = now();
            $new_top->save();
        }
        \App\Models\Orders::factory(100)->create();
    }
}
