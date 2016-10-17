<?php

class LoanaccountsController extends \BaseController {

	/**
	 * Display a listing of loanaccounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$loanaccounts = Loanaccount::all();

		return View::make('loanaccounts.index', compact('loanaccounts'));
	}

	public function guarantor()
	{
		$member = Member::where('membership_no',Confide::user()->username)->first();
		//$loanaccounts = Loanaccount::where('member_id',$member->id)->get();
        $loanaccounts = DB::table('loanaccounts')
		               ->join('loanguarantors', 'loanaccounts.id', '=', 'loanguarantors.loanaccount_id')
		               ->join('loanproducts', 'loanaccounts.loanproduct_id', '=', 'loanproducts.id')
		               ->join('members', 'loanaccounts.member_id', '=', 'members.id')
		               ->where('loanguarantors.member_id',$member->id)		              
		               ->select('loanaccounts.id','members.name as mname','loanproducts.name as pname','application_date',
		               	'amount_applied','repayment_duration','loanaccounts.interest_rate')
		               ->get();
		               //return $loanaccounts;
		if(empty($loanaccounts)){
			$prompt='There are no available guarantors to approve';
			return View::make('css.loanindex')->withPrompt($prompt)->with('loanaccounts',$loanaccounts);
		}else{			
			return View::make('css.loanindex', compact('loanaccounts'));
		}	               		
	}

	/**
	 * Show the form for creating a new loanaccount
	 *
	 * @return Response
	 */
	public function apply($id)
	{

		$member = Member::find($id);
		$guarantors = Member::where('id','!=',$id)->get();
		$loanproducts = Loanproduct::all();
		return View::make('loanaccounts.create', compact('member', 'guarantors', 'loanproducts'));
	}



	public function apply2($id){

		$member = Member::find($id);
        $guarantors = Member::where('id','!=',$id)->get();
		$loanproducts = Loanproduct::all();

		return View::make('css.loancreate', compact('member', 'guarantors', 'loanproducts'));
	}

	/**
	 * Store a newly created loanaccount in storage.
	 *
	 * @return Response
	 */
	public function doapply()
	{
		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Loanaccount::submitApplication($data);

		$id = array_get($data, 'member_id');

		return Redirect::to('loans');
	}



	public function doapply2()
	{
		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		//Gather the guarantors details
		$g1 = array_get($data, 'guarantor_id1');
		$g2 = array_get($data, 'guarantor_id2');
		$g3 = array_get($data, 'guarantor_id3');		
		//Loan Amount applied
		$appliedamount= array_get($data, 'amount_applied');
		$eachliability= round(($appliedamount/3),2);
		//Query if the guarantors have guaranteed other loans previously: Maximum guaranteeing limit of 2 loans
		$checknumber1=DB::table('loanguarantors')->where('member_id','=',$g1)->count();
		$checknumber2=DB::table('loanguarantors')->where('member_id','=',$g2)->count();
		$checknumber3=DB::table('loanguarantors')->where('member_id','=',$g3)->count();
		//Check guarantors
		if($g1==$g2 || $g1==$g3 || $g2==$g3){
			return Redirect::back()->withComplain('The guarantors cannot be the same.');
		}else{
				//Check if previously guaranteed other loans 
				if($checknumber1>=3){
					return Redirect::back()->withMax1('Guarantor 1 reached maximum guaranteeing limit');	
				}else if($checknumber2>=3){
					return Redirect::back()->withMax2('Guarantor 2 reached maximum guaranteeing limit');	
				}else if($checknumber3>=3){
					return Redirect::back()->withMax3('Guarantor 3 reached maximum guaranteeing limit');	
				}else{
					//First Guarantor Vetting:Checking the deposits volume
						$savings_amountg1=DB::table('savingtransactions')
										->join('savingaccounts','savingtransactions.savingaccount_id','=','savingaccounts.id')
										->where('savingaccounts.member_id','=',$g1)
										->where('savingtransactions.type','=','credit')
										->sum('savingtransactions.amount');
						
						$shares_amountg1=DB::table('sharetransactions')
										->join('shareaccounts','sharetransactions.shareaccount_id','=','shareaccounts.id')
										->where('shareaccounts.member_id','=',$g1)
										->where('sharetransactions.type','=','credit')
										->sum('sharetransactions.amount');		
						$contr_g1=$shares_amountg1 + $savings_amountg1;

						//SecondGuarantor Vetting:Checking the deposits volume
						$savings_amountg2=DB::table('savingtransactions')
										->join('savingaccounts','savingtransactions.savingaccount_id','=','savingaccounts.id')
										->where('savingaccounts.member_id','=',$g2)
										->where('savingtransactions.type','=','credit')
										->sum('savingtransactions.amount');
						
						$shares_amountg2=DB::table('sharetransactions')
										->join('shareaccounts','sharetransactions.shareaccount_id','=','shareaccounts.id')
										->where('shareaccounts.member_id','=',$g2)
										->where('sharetransactions.type','=','credit')
										->sum('sharetransactions.amount');		
						$contr_g2=$shares_amountg2 + $savings_amountg2;
						
						//Third Guarantor Vetting:Checking the deposits volume
						$savings_amountg3=DB::table('savingtransactions')
										->join('savingaccounts','savingtransactions.savingaccount_id','=','savingaccounts.id')
										->where('savingaccounts.member_id','=',$g3)
										->where('savingtransactions.type','=','credit')
										->sum('savingtransactions.amount');
						
						$shares_amountg3=DB::table('sharetransactions')
										->join('shareaccounts','sharetransactions.shareaccount_id','=','shareaccounts.id')
										->where('shareaccounts.member_id','=',$g3)
										->where('sharetransactions.type','=','credit')
										->sum('sharetransactions.amount');		
						$contr_g3=$shares_amountg3 + $savings_amountg3;	
						//Determining whether the guarantor can shoulder the loan as a liability
						if($contr_g1 <$eachliability){
							return Redirect::back()->withDismiss('The guarantor 1 has less contributions to guarantee your loan.');
						}else if($contr_g2 <$eachliability){
							return Redirect::back()->withReject('The guarantor 2 has less contributions to guarantee your loan.');
						}else if($contr_g3 <$eachliability){
							return Redirect::back()->withRepel('The guarantor 3 has less contributions to guarantee your loan.');
						}else{
							//Checking if the total guaranteeing amount is less than, more than or equal to loan amount					
						Loanaccount::submitApplication($data);
						$id = array_get($data, 'member_id');
						return Redirect::to('memberloans')->withMessage('Loan successfully applied!');									
					}
			}
		}		
	}


public function shopapplication()
	{

		$data =Input::all();
		Loanaccount::submitShopApplication($data);

		//$id = array_get($data, 'member_id');

		return Redirect::to('memberloans');
	}

	/**
	 * Display the specified loanaccount.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$loanaccount = Loanaccount::where('id','=',$id)->get()->first();
		if(empty($loanaccount)){
			return Redirect::back()->withCaution('No records available for the loan. Therefore loan schedule can neither be printed nor previewed.');
		}
		$interest = Loanaccount::getInterestAmount($loanaccount);
		$loanbalance = Loantransaction::getLoanBalance($loanaccount);
		$principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);
		$interest_paid = Loanrepayment::getInterestPaid($loanaccount);
		$loanguarantors = $loanaccount->guarantors;

		$loantransactions = DB::table('loantransactions')->where('loanaccount_id', '=', $id)->orderBy('id', 'DESC')->get();
		if(Confide::user()->user_type == 'member'){
		return View::make('css.loanscheduleshow', compact('loanaccount', 'loanguarantors', 'interest', 'principal_paid', 'interest_paid', 'loanbalance', 'loantransactions'));
		}else{
			return View::make('loanaccounts.show', compact('loanaccount', 'loanguarantors', 'interest', 'principal_paid', 'interest_paid', 'loanbalance', 'loantransactions'));
		}
	}




	public function show2($id)
	{
		$loanaccount = Loanaccount::findOrFail($id);
		$interest = Loanaccount::getInterestAmount($loanaccount);
		$loanbalance = Loantransaction::getLoanBalance($loanaccount);
		$principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);
		$interest_paid = Loanrepayment::getInterestPaid($loanaccount);
		$loanguarantors = $loanaccount->guarantors;
		
		return View::make('css.loanshow', compact('loanaccount', 'loanguarantors', 'interest', 'principal_paid', 'interest_paid', 'loanbalance'));
	}

	/**
	 * Show the form for editing the specified loanaccount.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$loanaccount = Loanaccount::find($id);

		return View::make('loanaccounts.edit', compact('loanaccount'));
	}

	/**
	 * Update the specified loanaccount in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$loanaccount = Loanaccount::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$loanaccount->update($data);

		return Redirect::route('loanaccounts.index');
	}

	/**
	 * Remove the specified loanaccount from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Loanaccount::destroy($id);

		return Redirect::route('loanaccounts.index');
	}




	public function approve($id)
	{
		$loanaccount = Loanaccount::find($id);

		return View::make('loanaccounts.approve', compact('loanaccount'));
	}

	/**
	 * Update the specified loanaccount in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function doapprove($id)
	{
		//$loanaccount =  new Loanaccount;
		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		//$loanaccount->approve($data);


		$loanaccount_id = array_get($data, 'loanaccount_id');

		$loanguarantors=DB::table('loanguarantors')
						->join('members','loanguarantors.member_id','=','members.id')
						->join('loanaccounts','loanguarantors.loanaccount_id','=','loanaccounts.id')
						->where('loanguarantors.loanaccount_id','=',$loanaccount_id)
						->select('members.name as mname','members.id as mid','loanguarantors.amount as mamount','loanguarantors.has_approved as approved')
						->get();	
		
		if(empty($loanguarantors)){
				$loanaccount = Loanaccount::findorfail($loanaccount_id);

				$loanaccount->date_approved = array_get($data, 'date_approved');
				$loanaccount->amount_approved = array_get($data, 'amount_approved');
				//$loanaccount->amount_to_pay = (array_get($data, 'amount_approved')*array_get($data, 'interest_rate')/100)+array_get($data, 'amount_approved');
				$loanaccount->interest_rate = array_get($data, 'interest_rate');
				$loanaccount->period = array_get($data, 'period');
				$loanaccount->is_approved = TRUE;
				$loanaccount->is_new_application = FALSE;
				$loanaccount->update();

				return Redirect::route('loans.index');
		}else{
			foreach($loanguarantors as $lguara){
				$check_if_agreed=$lguara->approved;
				switch($check_if_agreed){
					case 0:
						return Redirect::back()->withStatus('The available guarantors have not agreed to act as guarantors for the loan.');
					break;
					case 1:
						$loanaccount = Loanaccount::findorfail($loanaccount_id);

						$loanaccount->date_approved = array_get($data, 'date_approved');
						$loanaccount->amount_approved = array_get($data, 'amount_approved');
						//$loanaccount->amount_to_pay = (array_get($data, 'amount_approved')*array_get($data, 'interest_rate')/100)+array_get($data, 'amount_approved');
						$loanaccount->interest_rate = array_get($data, 'interest_rate');
						$loanaccount->period = array_get($data, 'period');
						$loanaccount->is_approved = TRUE;
						$loanaccount->is_new_application = FALSE;
						$loanaccount->update();

						return Redirect::route('loans.index');
					break;
				}
			}
		}		
	}

	public function guarantorapprove($id){
		//$loanaccount =  new Loanaccount;
		$validator = Validator::make($data = Input::all(), loanguarantor::$rules);

		if ($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		}
		//$loanaccount->approve($data);
		$member = Member::where('membership_no',Confide::user()->username)->first();

		$loanguarantor = loanguarantor::where('loanaccount_id',$id)
						->where('member_id',$member->id)
						->first();

		$lg = loanguarantor::findOrFail($loanguarantor->id);
        $lg->has_approved = Input::get('status');
        //$lg->date = date('Y-m-d');
		$lg->update();


        include(app_path() . '\views\AfricasTalkingGateway.php');
		$mem_id = array_get($data, 'mid');

		$member1 = Member::findOrFail($mem_id);

		
    // Specify your login credentials
    $username   = "kenkode";
    $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = $member1->phone;
    // And of course we want our recipients to know what we really do
    $message    = "Hello ".$member1->name."!  Member ".$member->name." has approved your loan for Ksh. ".array_get($data, 'amount_applied')." for loan product ".array_get($data, 'pname')." and has agreed to be your guarantor and has guranteed an amount of Ksh. ".array_get($data, 'amount').".
    Please wait for final approval from the managements of the sacco so as to get the loan.
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

    if($member1->email != null){
    	if(Input::get('status') == 'approved'){
    		Mail::send( 'emails.approve', array('name'=>$member1->name,'mname'=>$member->name, 'id'=>$member->id_number, 'amount_applied'=>array_get($data, 'amount_applied'),'product'=>array_get($data, 'pname')), function( $message ) use ($member1)
        {
         $message->to($member1->email )->subject( 'Guarantor Approval' );
        });
    	}else{
           Mail::send( 'emails.reject', array('name'=>$member1->name,'mname'=>$member->name, 'id'=>$member->id_number, 'amount_applied'=>array_get($data, 'amount_applied'),'product'=>array_get($data, 'pname')), function( $message ) use ($member1)
        {
         $message->to($member1->email )->subject( 'Guarantor Approval' );
        });
        }
    }

        if(Input::get('status') == 'approved'){
		return Redirect::to('/guarantorapproval')->withFlashMessage('You have successfully approved member loan!');
	    }else{
        return Redirect::to('/guarantorapproval')->withDeleteMessage('You have successfully rejected member loan!');
	    }
	}

    public function guarantorreject($id)
	{
		//$loanaccount =  new Loanaccount;

		$validator = Validator::make($data = Input::all(), loanguarantor::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		//$loanaccount->approve($data);


		$member = Member::where('membership_no',Confide::user()->username)->first();

		$loanguarantor = loanguarantor::where('loanaccount_id',$id)->where('member_id',$member->id)->first();
		$lg = loanguarantor::findOrFail($loanguarantor->id);
        $lg->is_approved = 'rejected';
        $lg->date = date('Y-m-d');
		$lg->update();


        include(app_path() . '\views\AfricasTalkingGateway.php');
		$mem_id = array_get($data, 'mid1');

		$member1 = Member::findOrFail($mem_id);

		
    // Specify your login credentials
    $username   = "kenkode";
    $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = $member1->phone;
    // And of course we want our recipients to know what we really do
    $message    = "Hello ".$member1->name."!  Member ".$member->name." has rejected your loan for Ksh. ".array_get($data, 'amount_applied1')." for loan product ".array_get($data, 'pname1').".
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

    if($member1->email != null){
        Mail::send( 'emails.guarantor', array('name'=>$member1->name,'mname'=>$member->name, 'id'=>$member->id_number, 'amount_applied'=>array_get($data, 'amount_applied'),'product'=>array_get($data, 'pname')), function( $message ) use ($member1)
        {
         $message->to($member1->email )->subject( 'Guarantor Approval' );
        });
        }


		return Redirect::to('/guarantorapproval')->withDeleteMessage('You have successfully rejected member loan!');
	}

	public function reject($id)
	{
		$loanaccount = Loanaccount::find($id);

		return View::make('loanaccounts.reject', compact('loanaccount'));
	}


	public function rejectapplication()
	{
		
		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

	

		$loanaccount_id = array_get($data, 'loanaccount_id');

		

		$loanaccount = Loanaccount::findorfail($loanaccount_id);

		$loanaccount->rejection_reason = array_get($data, 'reasons');
		$loanaccount->is_rejected = TRUE;
		$loanaccount->is_approved = FALSE;
		$loanaccount->is_new_application = FALSE;
		$loanaccount->update();

		return Redirect::route('loans.index');
	}





	public function disburse($id)
	{
		$loanaccount = Loanaccount::find($id);

		return View::make('loanaccounts.disburse', compact('loanaccount'));
	}

	/**
	 * Update the specified loanaccount in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function dodisburse($id)
	{
		//$loanaccount =  new Loanaccount;

		$validator = Validator::make($data = Input::all(), Loanaccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		//$loanaccount->approve($data);


		$loanaccount_id = array_get($data, 'loanaccount_id');

		

		$loanaccount = Loanaccount::findorfail($loanaccount_id);


		$amount = array_get($data, 'amount_disbursed');
		$date = array_get($data, 'date_disbursed');

		$loanaccount->date_disbursed = $date;
		$loanaccount->amount_disbursed = $amount;
		$loanaccount->repayment_start_date = array_get($data, 'repayment_start_date');
		$loanaccount->account_number = Loanaccount::loanAccountNumber($loanaccount);
		$loanaccount->is_disbursed = TRUE;
		
	
		$loanaccount->update();

		$loanamount = $amount + Loanaccount::getInterestAmount($loanaccount);
		Loantransaction::disburseLoan($loanaccount, $loanamount, $date);

		return Redirect::route('loans.index');
	}



	public function gettopup($id){

		$loanaccount = Loanaccount::findOrFail($id);


		return View::make('loanaccounts.topup', compact('loanaccount'));
	}



	public function topup($id){

		
		$data = Input::all();
		
		$date =  Input::get('top_up_date');
		$amount = Input::get('amount');

	
		$loanaccount = Loanaccount::findOrFail($id);



		$loanaccount->is_top_up = true;
		$loanaccount->top_up_amount = $amount;
		//$loanaccount->top_up_date = $date;
		$loanaccount->update();

		Loantransaction::topupLoan($loanaccount, $amount, $date);


		 return Redirect::to('loans/show/'.$loanaccount->id);

		

		
	}

	public function member(){

		$members = Member::all();

		return View::make('pdf.members', compact('members'));


	}

	public function application(){
        $id = Input::get('loanaccount_id');
        
		$transaction = Loanaccount::findOrFail($id);

		$guarantors = Loanguarantor::where('loanaccount_id',$id)->get();

		$organization = Organization::findOrFail(1);

		$pdf = PDF::loadView('pdf.loanreports.loanapplicationform', compact('transaction','guarantors', 'organization'))->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream('Loan Application.pdf');


	}


}
