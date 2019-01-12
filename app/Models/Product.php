<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
		'name','saleman'
	];

    public function spread()
    {
    	return $this->hasMany(Spread::class,'pid','id');
    }

    public function productPage()
    {
        return $this->hasMany(ProductPage::class,'pid','id');
    }
}
