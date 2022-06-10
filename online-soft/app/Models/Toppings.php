<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toppings extends Model
{
    use HasFactory;

    protected $table = 'toppings';
	public $timestamps = true;

    protected $fillable = [
		'topping_name', 'topping_price',
	];
}
