<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Spread;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
    	'name','types','company','uid'
    ];

    public function spread()
    {
    	return $this->hasMany(Spread::class,'cid','id');
    }

    public function admin()
    {
    	return $this->belongsTo(Admin::class,'uid','id');
    }

}
