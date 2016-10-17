<?php

class Loanproduct extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function loanpostings(){

		return $this->hasMany('Loanposting');
	}


	public function loanaccounts(){

		return $this->hasMany('Loanaccount');
	}


	public function charges(){

		return $this->belongsToMany('Charge');
	}








	public static function submit($data){


		//$charges = Input::get('charge');

		$loanproduct = new Loanproduct;


		$loanproduct->name = array_get($data, 'name');
		$loanproduct->short_name = array_get($data, 'short_name');
		$loanproduct->interest_rate = array_get($data, 'interest_rate');
		$loanproduct->formula = array_get($data, 'formula');
		$loanproduct->amortization = array_get($data, 'amortization');
		$loanproduct->currency = array_get($data, 'currency');
		$loanproduct->period = array_get($data, 'period');
		$loanproduct->auto_loan_limit = array_get($data, 'autoloanlimit');
		$loanproduct->application_form = array_get($data, 'appform');
		$loanproduct->save();

		Audit::logAudit(date('Y-m-d'), Confide::user()->username, 'loan product creation', 'Loans', '0');


		$loan_id = $loanproduct->id;

		Loanposting::submit($loan_id, $data);
		

		/*
		foreach($charges as $charge){

			$loanproduct->charges()->attach($charge);
		}

		*/

	}

}