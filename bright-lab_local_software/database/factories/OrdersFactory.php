<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customers = \App\Models\Customers::pluck('id');
        $toppings = \App\Models\Toppings::pluck('id');
        $topping_id = $this->faker->randomElement($toppings);
        $topping_qty = $this->faker->numberBetween($min = 10, $max = 100);
        $top = \App\Models\Toppings::find($topping_id);
        $topping_price = $top->topping_price;
        $total = $topping_price * $topping_qty;
        return [
            'customer_id' => $this->faker->randomElement($customers),
            'topping_id' => $topping_id,
            'quantity' => $topping_qty,
            'total' => $total,
        ];
    }
}
