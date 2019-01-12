<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\Product;
use App\Models\CountPeople;
use Illuminate\Database\Eloquent\Model;

class Spread extends Model
{
	protected $fillable = [
		'cid','peopel','pid'
	]; 


	public function product()
	{
		return $this->belongsTo(Product::class,'pid','id');
	}

	public function countPeople()
	{
		return $this->hasMany(CountPeople::class);
	}

	public function admin()
    {
        return $this->belongsTo(Admin::class,'uid','id');
    }

	public function productPage()
    {
        return $this->belongsToMany(ProductPage::class,'page_spreads','spread_id','page_id');
    }

    public function user()
    {
        return $this->hasMany(User::class,'sid','id');
    }
}
