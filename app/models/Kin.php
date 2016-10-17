<?php

class Kin extends \Eloquent {

	// Add your validation rules here
	

	// Don't forget to fill this array
	protected $fillable = [];


	public function member(){

		return $this->belongsTo('Kin');
	}

}