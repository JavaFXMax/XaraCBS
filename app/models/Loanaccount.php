<?php

class Loanaccount extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'loanproduct_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];



	public function loanproduct(){

		return $this->belongsTo('Loanproduct');
	}


	public function member(){

		return $this->belongsTo('Member');
	}


	public function loanrepayments(){

		return $this->hasMany('Loanaccount');
	}

    public static function Loans($id){
        
		return Loanaccount::where('member_id',$id)->get();
	}


	public function loantransactions(){

		return $this->hasMany('Loantransaction');
	}

	public function guarantors(){

		return $this->hasMany('Loanguarantor');
	}



	public static function submitApplication($data){

		$member_id = array_get($data, 'member_id');
		$loanproduct_id = array_get($data, 'loanproduct_id');

		$member = Member::findorfail($member_id);

		$loanproduct = Loanproduct::findorfail($loanproduct_id);

		$application = new Loanaccount;


		$application->member()->associate($member);
		$application->loanproduct()->associate($loanproduct);
		$application->application_date = array_get($data, 'application_date');
		$application->amount_applied = array_get($data, 'amount_applied');
		$application->interest_rate = $loanproduct->interest_rate;
		$application->period = $loanproduct->period;
		$application->repayment_duration = array_get($data, 'repayment_duration');
		
		$application->save();

		if(array_get($data, 'amount_applied')<=$loanproduct->auto_loan_limit){

		$loanaccount = Loanaccount::findorfail($application->id);

		$loanaccount->date_approved = array_get($data, 'application_date');
		$loanaccount->amount_approved = array_get($data, 'amount_applied');
		//$loanaccount->amount_to_pay = (array_get($data, 'amount_approved')*array_get($data, 'interest_rate')/100)+array_get($data, 'amount_approved');
		$loanaccount->interest_rate = $loanproduct->interest_rate;
		$loanaccount->period = $loanproduct->period;
		$loanaccount->is_approved = TRUE;
		$loanaccount->is_new_application = FALSE;

        $amount = array_get($data, 'amount_applied');
		$date = array_get($data, 'application_date');

		$loanaccount->date_disbursed = $date;
		$loanaccount->amount_disbursed = $amount;
		$loanaccount->repayment_start_date = array_get($data, 'application_date');
		$loanaccount->account_number = Loanaccount::loanAccountNumber($loanaccount);
		$loanaccount->is_disbursed = TRUE;
		
		$loanaccount->update();

		$loanamount = $amount + Loanaccount::getInterestAmount($loanaccount);
		Loantransaction::disburseLoan($loanaccount, $loanamount, $date);

	   }

        include(app_path() . '\views\AfricasTalkingGateway.php');

		if(array_get($data, 'guarantor_id1') != null || array_get($data, 'guarantor_id1') != ''){

		$mem_id = array_get($data, 'guarantor_id1');
		$amount= array_get($data, 'amount_applied');		

		$member1 = Member::findOrFail($mem_id);

		$loanaccount = Loanaccount::findOrFail($application->id);


		$guarantor = new Loanguarantor;

		$guarantor->member()->associate($member1);
		$guarantor->loanaccount()->associate($loanaccount);
		$guarantor->save();

		$admins=DB::table('users')->where('user_type','=','admin')->get();
		foreach ($admins as $adm) {
			$mail=$adm->email;
			if($mail != null){
		        Mail::send( 'emails.admin', array('name'=>$adm->username,'mname'=>$member->name, 'id'=>$member->id_number, 'amount_applied'=>array_get($data, 'amount_applied'),'product'=>$loanproduct->name,'application_date'=>array_get($data, 'application_date')), function( $message ) use ($adm)
		        {

		         $message->to($adm->email)->subject( 'Loan Approval and Disursement' );
		        });
		      }
		}

        if($member1->email != null){
        Mail::send( 'emails.guarantor', array('name'=>$member1->name,'mname'=>$member->name, 'id'=>$member->id_number, 'amount_applied'=>array_get($data, 'amount_applied'),'product'=>$loanproduct->name,'application_date'=>array_get($data, 'application_date')), function( $message ) use ($member1)
        {
         $message->to($member1->email )->subject( 'Guarantor Approval' );
        });
        }
		
    // Specify your login credentials
    $username   = "kenkode";
    $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = $member1->phone;
    // And of course we want our recipients to know what we really do
    $message    = $member->name." ID ".$member->id_number." has borrowed a loan of ksh. ".array_get($data, 'amount_applied')." for loan product ".$loanproduct->name." on ".array_get($data, 'application_date')." and has selected you as his/her guarantor for amount of ".array_get($data, 'g1amount')."
    Please login and approve or reject
    Thank you!";
    // Create a new instance of our awesome gateway class
    $gateway    = new AfricasTalkingGateway($username, $apikey);
    // Any gateway error will be captured by our custom Exception class below, 
    // so wrap the call in a try-catch block
    try 
    { 
      // Thats it, hit send and we'll take care of the rest. 
      //$results = $gateway->sendMessage($recipients, $message);
                
      /*foreach($results as $result) {
        // status is either "Success" or "error message"
        echo " Number: " .$result->number;
        echo " Status: " .$result->status;
        echo " MessageId: " .$result->messageId;
        echo " Cost: "   .$result->cost."\n";
      }*/
    }
    catch ( AfricasTalkingGatewayException $e )
    {
      echo "Encountered an error while sending: ".$e->getMessage();
    }

    }if(array_get($data, 'guarantor_id2') != null || array_get($data, 'guarantor_id2') != ''){

		$mem_id1 = array_get($data, 'guarantor_id2');
		$amount= array_get($data, 'amount_applied');

		$member2 = Member::findOrFail($mem_id1);

		$loanaccount = Loanaccount::findOrFail($application->id);


		$guarantor = new Loanguarantor;

		$guarantor->member()->associate($member2);
		$guarantor->loanaccount()->associate($loanaccount);		
		$guarantor->save();

		if($member2->email != null){
        Mail::send( 'emails.guarantor', array('name'=>$member2->name,'mname'=>$member->name, 'id'=>$member->id_number, 'amount_applied'=>array_get($data, 'amount_applied'),'product'=>$loanproduct->name,'application_date'=>array_get($data, 'application_date')), function( $message ) use ($member2)
        {
         $message->to($member2->email )->subject( 'Guarantor Approval' );
        });
        }

    // Specify your login credentials
    $username   = "kenkode";
    $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = $member2->phone;
    // And of course we want our recipients to know what we really do
    $message    = $member->name." ID ".$member->id_number." has borrowed a loan of ksh. ".array_get($data, 'amount_applied')." for loan product ".$loanproduct->name." on ".array_get($data, 'application_date')." and has selected you as his/her guarantor.
   Please login and approve or reject
    Thank you!";
    // Create a new instance of our awesome gateway class
    $gateway    = new AfricasTalkingGateway($username, $apikey);
    // Any gateway error will be captured by our custom Exception class below, 
    // so wrap the call in a try-catch block
    try 
    { 
      // Thats it, hit send and we'll take care of the rest. 
      //$results = $gateway->sendMessage($recipients, $message);
                
      /*foreach($results as $result) {
        // status is either "Success" or "error message"
        echo " Number: " .$result->number;
        echo " Status: " .$result->status;
        echo " MessageId: " .$result->messageId;
        echo " Cost: "   .$result->cost."\n";
      }*/
    }
    catch ( AfricasTalkingGatewayException $e )
    {
      echo "Encountered an error while sending: ".$e->getMessage();
    }

    }if(array_get($data, 'guarantor_id3') != null || array_get($data, 'guarantor_id3') != ''){

		$mem_id3 = array_get($data, 'guarantor_id3');
		$amount= array_get($data, 'amount_applied');		

		$member3 = Member::findOrFail($mem_id3);

		$loanaccount = Loanaccount::findOrFail($application->id);


		$guarantor = new Loanguarantor;

		$guarantor->member()->associate($member3);
		$guarantor->loanaccount()->associate($loanaccount);		
		$guarantor->save();

		if($member3->email != null){
        Mail::send( 'emails.guarantor', array('name'=>$member3->name,'mname'=>$member->name, 'id'=>$member->id_number, 'amount_applied'=>array_get($data, 'amount_applied'),'product'=>$loanproduct->name,'application_date'=>array_get($data, 'application_date')), function( $message ) use ($member3)
        {
         $message->to($member3->email )->subject( 'Guarantor Approval' );
        });
        }

    // Specify your login credentials
    $username   = "kenkode";
    $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = $member3->phone;
    // And of course we want our recipients to know what we really do
    $message    = $member->name." ID ".$member->id_number." has borrowed a loan of ksh. ".array_get($data, 'amount_applied')." for loan product ".$loanproduct->name." on ".array_get($data, 'application_date')." and has selected you as his/her guarantor.
    Please login and approve or reject
    Thank you!";
    // Create a new instance of our awesome gateway class
    $gateway    = new AfricasTalkingGateway($username, $apikey);
    // Any gateway error will be captured by our custom Exception class below, 
    // so wrap the call in a try-catch block
    try 
    { 
      // Thats it, hit send and we'll take care of the rest. 
      // $results = $gateway->sendMessage($recipients, $message);
                
      /*foreach($results as $result) {
        // status is either "Success" or "error message"
        echo " Number: " .$result->number;
        echo " Status: " .$result->status;
        echo " MessageId: " .$result->messageId;
        echo " Cost: "   .$result->cost."\n";
      }*/
    }
    catch ( AfricasTalkingGatewayException $e )
    {
      echo "Encountered an error while sending: ".$e->getMessage();
    }

    }
	Audit::logAudit(date('Y-m-d'), Confide::user()->username, 'loan application', 'Loans', array_get($data, 'amount_applied'));
	}

	public static function submitShopApplication($data){

		$mem = array_get($data, 'member');

		$member_id = DB::table('members')->where('membership_no', '=', $mem)->pluck('id');
		$loanproduct_id = array_get($data, 'loanproduct');


		$member = Member::findorfail($member_id);

		$product = Product::findorfail(array_get($data, 'product'));

		$loanproduct = Loanproduct::findorfail($loanproduct_id);


		$application = new Loanaccount;


		$application->member()->associate($member);
		$application->loanproduct()->associate($loanproduct);
		$application->application_date = date('Y-m-d');

		$application->amount_applied = array_get($data, 'amount');
		$application->interest_rate = $loanproduct->interest_rate;
		$application->period = array_get($data, 'repayment');
		$application->repayment_duration = array_get($data, 'repayment');
		$application->loan_purpose = array_get($data, 'purpose');
		$application->save();


		Order::submitOrder($product, $member);
	}



	public static function loanAccountNumber($loanaccount){

		
		$member = Member::find($loanaccount->member->id);

		$count = count($member->loanaccounts);
		$count = $count + 1;

		//$count = DB::table('loanproducts')->where('member_id', '=', $loanaccount->member->id)->count();

		$loanno = $loanaccount->loanproduct->short_name."-".$loanaccount->member->membership_no."-".$count;

		return $loanno;

	}



	public static function intBalOffset($loanaccount){


		$principal = Loanaccount::getPrincipalBal($loanaccount);

		$rate = $loanaccount->interest_rate/100;

		$time = $loanaccount->repayment_duration;

		$formula = $loanaccount->loanproduct->formula;

		if($formula == 'SL'){

			$interest_amount = $principal * $rate;

		}


		if($formula == 'RB'){

			
    		
    		
   			$principal_bal = $principal;
    		
    		$interest_amount = $principal_bal * $rate;

          
		}


		return $interest_amount;


	}


	public static function getEMPTacsix($loanaccount){

		 
		$principal = $loanaccount->amount_disbursed;
		$rate = $loanaccount->interest_rate/100;
		$time = $loanaccount->repayment_duration;

		$interest = $principal * $rate * $time;
		$amount = $principal + $interest;

		$amt = $amount/$time;

		return $amt;

	}



	public static function getInterestAmount($loanaccount){


		$principal = Loanaccount::getPrincipalBal($loanaccount);

		$rate = $loanaccount->interest_rate/100;

		$time = $loanaccount->repayment_duration;

		$formula = $loanaccount->loanproduct->formula;

		if($formula == 'SL'){

			$interest_amount = $principal * $rate * $time;

		}


		if($formula == 'RB'){

			
    		
    		
   			$principal_bal = $principal;
    		$interest_amount = 0;
    		$principal_pay = $principal/$time;

    		for($i=1; $i<=$time; $i++){


        		$interest_amount = ($interest_amount + ($principal_bal * $rate));

        		$principal_bal = $principal_bal - $principal_pay;

        		
    		}

          
		}


		return $interest_amount;
	}


	public static function hasAccount($member, $loanproduct){

		foreach ($member->loanaccounts as $loanaccount) {
			
			if($loanaccount->loanproduct->name == $loanproduct->name){

				return true;
			}
			else {
				return false;
			}
		}
	}


	public static function getTotalDue($loanaccount){

		$balance = Loantransaction::getLoanBalance($loanaccount);

		if($balance > 1 ){

			$principal = Loantransaction::getPrincipalDue($loanaccount);
			$interest = Loantransaction::getInterestDue($loanaccount);

			$total = $principal + $interest;

			return $total;
		}else {

			return 0;
		}

		
	}


	public static function getDurationAmount($loanaccount){

		$interest = Loanaccount::getInterestAmount($loanaccount);
		$principal = $loanaccount->amount_disbursed;

		$total =$principal + $interest;

		if($loanaccount->repayment_duration != null){

			$amount = $total/$loanaccount->repayment_duration;
		} else {

			$amount = $total/$loanaccount->period;

		}

		return $amount;

		
	}


	public static function getLoanAmount($loanaccount){

		$interest_amount = Loanaccount::getInterestAmount($loanaccount);
		$principal = $loanaccount->amount_disbursed;
		$topup = $loanaccount->top_up_amount;

		$amount = $principal + $interest_amount + $topup;

		return $amount;
	}


	public static function getEMP($loanaccount){

		$loanamount = Loanaccount::getLoanAmount($loanaccount);

		if($loanaccount->repayment_duration > 0){
			$period = $loanaccount->repayment_duration;
		}
		else {

			$period = $loanaccount->period;
		}

		if($loanaccount->loanproduct->amortization == 'EP'){

			if($loanaccount->loanproduct->formula == 'RB'){

				$principal = $loanaccount->amount_disbursed + $loanaccount->top_up_amount;

				$principal = $principal/$period;

				$interest = (Loantransaction::getLoanBalance($loanaccount) * ($loanaccount->loanproduct->rate/100));

				$mp = $principal + $interest;

			}

			if($loanaccount->loanproduct->formula == 'SL'){
				 $mp = $loanamount/$period;
			}
				
	
		}

		if($loanaccount->loanproduct->amortization == 'EI'){

			$mp = $loanamount / $loanaccount->repayment_duration;
			
		}

		

		return $mp;
	}



	public static function getInterestBal($loanaccount){

		$interest_amount = Loanaccount::getInterestAmount($loanaccount);

		$interest_paid = Loanrepayment::getInterestPaid($loanaccount);

		$interest_bal = $interest_amount - $interest_paid;

		return $interest_bal;
	}



	public static function getPrincipalBal($loanaccount){

		$principal_amount = $loanaccount->amount_disbursed + $loanaccount->top_up_amount;

		$principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);

		$principal_bal = $principal_amount - $principal_paid;

		return $principal_bal;
	}


	public static function getDeductionAmount($loanaccount, $date){

		$transactions = DB::table('loantransactions')->where('loanaccount_id', '=', $loanaccount->id)->get();

		$amount = 0;
		foreach ($transactions as $transaction) {

			$period = date('m-Y', strtotime($transaction->date));

			if($date == $period){

				if($transaction->type == 'credit'){
					$amount = $transaction->amount;
				}
				
			} 
			
		}


		return $amount;
	}
	
}