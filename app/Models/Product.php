<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\Spread;
use App\Models\ProductPage;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
		'name','saleman'
	];

    public function spread()
    {
    	return $this->hasMany(Spread::class);
    }

    public function productPage()
    {
        return $this->hasMany(ProductPage::class,'pid','id');
    }
}
