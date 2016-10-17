<?php

class Bank extends \Eloquent {

public static $rules = [
		'name' => 'required',
		'code' => 'required'
	];

public static $messages = array(
        'name.required'=>'Please insert bank name!',
        'code.required'=>'Please insert bank code!',
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function members(){

		return $this->hasOne('Member');
	}

	public function bankbranch(){

		return $this->hasOne('BBranch');
	}

}