<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
	//

	protected $guarded = [];
	//public $timestamps = false;

	public function users(){
		return $this->hasMany('App\User');
	}




}