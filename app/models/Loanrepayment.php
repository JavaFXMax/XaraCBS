<?php

class Loanrepayment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function loanaccount(){

		return $this->belongsTo('Loanaccount');
	}


	public static function getPrincipalPaid($loanaccount){


			$paid = DB::table('loanrepayments')->where('loanaccount_id', '=', $loanaccount->id)->sum('principal_paid');

			return $paid;
	}


	public static function getInterestPaid($loanaccount){


			$paid = DB::table('loanrepayments')->where('loanaccount_id', '=', $loanaccount->id)->sum('interest_paid');

			
			return $paid;
	}
	public static function repayLoan($data){

		$loanaccount_id = array_get($data, 'loanaccount_id');

		$loanaccount = Loanaccount::findorfail($loanaccount_id);

		$amount = array_get($data, 'amount');
		$date = array_get($data, 'date');


		$principal_due = Loantransaction::getPrincipalDue($loanaccount);
		$interest_due = Loantransaction::getInterestDue($loanaccount);

		$total_due = $principal_due + $interest_due;

		$payamount = $amount;
	 	if($payamount < $total_due){

				//pay interest first
				Loanrepayment::payInterest($loanaccount, $date, $interest_due);

				$payamount = $payamount - $interest_due;

				if($payamount > 0){
					Loanrepayment::payPrincipal($loanaccount, $date, $payamount);
				}
		}


		if($payamount >= $total_due){

			//pay interest first 
			Loanrepayment::payInterest($loanaccount, $date, $interest_due);
			$payamount = $payamount - $interest_due;

			//pay principal with the remaining amount

			Loanrepayment::payPrincipal($loanaccount, $date, $payamount);
		}
		/*
		do {

			if($payamount >= $principal_due ){

				Loanrepayment::payPrincipal($loanaccount, $date, $principal_due);
				$payamount = $payamount - $principal_due;


				if($payamount >= $interest_due ){

				Loanrepayment::payInterest($loanaccount, $date, $interest_due);
				$payamount = $payamount - $interest_due;

				} 

				elseif($payamount > 0 && $payamount < $interest_due) {

					Loanrepayment::payInterest($loanaccount, $date, $payamount);
					$payamount = $payamount - $payamount;
				}

			}

			elseif(($payamount > 0) and ($payamount < $principal_due) ) {

				Loanrepayment::payInterest($loanaccount, $date, $interest_due);
				$payamount = $payamount - $interest_due;


				if($payamount > 0) {

					Loanrepayment::payPrincipal($loanaccount, $date, $payamount);
					$payamount = $payamount - $payamount;

				}
			}

			
			


		} while($payamount > 0);

	*/


		
		Loantransaction::repayLoan($loanaccount, $amount, $date);


		



	}



	public static function offsetLoan($data){

		$loanaccount_id = array_get($data, 'loanaccount_id');

		$loanaccount = Loanaccount::findorfail($loanaccount_id);

		$amount = array_get($data, 'amount');
		$date = array_get($data, 'date');


		$principal_bal = Loanaccount::getPrincipalBal($loanaccount);
		$interest_bal = Loanaccount::getInterestBal($loanaccount);

		

		//pay principal

 		Loanrepayment::payPrincipal($loanaccount, $date, $principal_bal);

 		//pay interest
 		Loanrepayment::payInterest($loanaccount, $date, $interest_bal);
		Loantransaction::repayLoan($loanaccount, $amount, $date);

	}




	public static function payPrincipal($loanaccount, $date, $principal_due){

		$repayment = new Loanrepayment;


		$repayment->loanaccount()->associate($loanaccount);
		$repayment->date = $date;
		$repayment->principal_paid = $principal_due;
		$repayment->save();


		$account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'principal_repayment');

		$data = array(
			'credit_account' =>$account['credit'] , 
			'debit_account' =>$account['debit'] ,
			'date' => $date,
			'amount' => $principal_due,
			'initiated_by' => 'system',
			'description' => 'principal repayment'

			);


		$journal = new Journal;


		$journal->journal_entry($data);

	}


	public static function payInterest($loanaccount, $date, $interest_due){

		$repayment = new Loanrepayment;


		$repayment->loanaccount()->associate($loanaccount);
		$repayment->date = $date;
		$repayment->interest_paid = $interest_due;
		$repayment->save();



		$account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'interest_repayment');

		$data = array(
			'credit_account' =>$account['credit'] , 
			'debit_account' =>$account['debit'] ,
			'date' => $date,
			'amount' => $interest_due,
			'initiated_by' => 'system',
			'description' => 'interest repayment'

			);


		$journal = new Journal;


		$journal->journal_entry($data);

	}

}