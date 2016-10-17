<?php

class Member extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'name' => 'required',
		 'membership_no' => 'required',
		 'branch_id' => 'required',
		 'phone' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function branch(){

		return $this->belongsTo('Branch');
	}

	public static function getBank($id){
	  if($id == 0){
      return '';
	  }else{
      return Bank::find($id)->pluck('name');
      }
	}

	public function bank(){

		return $this->belongsTo('Bank');
	}

	public function group(){

		return $this->belongsTo('Group');
	}

	public function kins(){

		return $this->hasMany('Kin');
	}


	public function savingaccounts(){

		return $this->hasMany('Savingaccount');
	}


	public function shareaccount(){

		return $this->hasOne('Shareaccount');
	}



	public function loanaccounts(){

		return $this->hasMany('Loanaccount');
	}

	public function documents(){

		return $this->hasMany('Document');
	}


	public function guarantors(){

		return $this->hasMany('Loanguarantor');
	}



	public static function getMemberAccount($id){

		$account_id = DB::table('savingaccounts')->where('member_id', '=', $id)->pluck('id');

		$account = Savingaccount::find($account_id);

		return $account;
	}
}