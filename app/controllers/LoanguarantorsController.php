<?php

class LoanguarantorsController extends \BaseController {

	/**
	 * Display a listing of loanguarantors
	 *
	 * @return Response
	 */
	public function index()
	{
		$loanguarantors = Loanguarantor::all();

		return View::make('loanguarantors.index', compact('loanguarantors'));
	}

	/**
	 * Show the form for creating a new loanguarantor
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$loanaccount = Loanaccount::findOrFail($id);

		
		if(Confide::user()->user_type == 'member'){
			$members = DB::table('members')
			->where('is_active', '=', TRUE)
			->where('membership_no', '!=', Confide::user()->username)
			->whereNotIn('id', function($q){
             $q->select('member_id')
            ->from('loanguarantors');
            // more where conditions
      })->get();
			
        return View::make('css.guarantorcreate', compact('members', 'loanaccount'));
		}else{
			$members = DB::table('members')
			->where('is_active', '=', TRUE)
			->whereNotIn('id', function($q){
             $q->select('member_id')
            ->from('loanguarantors');
            // more where conditions
      })->get();
		return View::make('loanguarantors.create', compact('members', 'loanaccount'));
	}
	}


	public function csscreate($id)
	{
		$loanaccount = Loanaccount::findOrFail($id);
		$members = DB::table('members')->where('is_active', '=', TRUE)->get();
		return View::make('css.guarantors', compact('members', 'loanaccount'));
	}

	/**
	 * Store a newly created loanguarantor in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Loanguarantor::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$mem_id = Input::get('member_id');

		$member1 = Member::findOrFail($mem_id);

		$loanaccount = Loanaccount::findOrFail(Input::get('loanaccount_id'));
		$member = Member::findOrFail($loanaccount->member->id);


		$guarantor = new Loanguarantor;

		$guarantor->member()->associate($member1);
		$guarantor->loanaccount()->associate($loanaccount);
		$guarantor->save();
		
		include(app_path() . '\views\AfricasTalkingGateway.php');
        $username   = "kenkode";
        $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
	    // Specify the numbers that you want to send to in a comma-separated list
	    // Please ensure you include the country code (+254 for Kenya in this case)
	    $recipients = $member1->phone;
	    // And of course we want our recipients to know what we really do
	    $message    = $member->name." ID ".$member->id_number." has borrowed a loan of ksh. ".$loanaccount->amount_applied." for loan product ".$loanaccount->loanproduct->name." on ".$loanaccount->application_date." and has selected you as his/her guarantor.
	    Please login and approve or reject
	    Thank you!";
	    // Create a new instance of our awesome gateway class
	    $gateway    = new AfricasTalkingGateway($username, $apikey);
	    // Any gateway error will be captured by our custom Exception class below, 
	    // so wrap the call in a try-catch block
	    try 
	    { 
	      // Thats it, hit send and we'll take care of the rest. 
	      $results = $gateway->sendMessage($recipients, $message);
	                
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

		return Redirect::to('loans/show/'.$loanaccount->id);
	}

	/**
	 * Display the specified loanguarantor.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$loanguarantor = Loanguarantor::findOrFail($id);

		return View::make('loanguarantors.show', compact('loanguarantor'));
	}

	/**
	 * Show the form for editing the specified loanguarantor.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$loanguarantor = Loanguarantor::find($id);
		$members = DB::table('members')->where('is_active', '=', TRUE)->get();

		return View::make('loanguarantors.edit', compact('loanguarantor', 'members'));
	}


	public function cssedit($id)
	{
		$loanguarantor = Loanguarantor::find($id);
		$members = DB::table('members')->where('is_active', '=', TRUE)->get();

		return View::make('css.editguarantors', compact('loanguarantor', 'members'));
	}


	/**
	 * Update the specified loanguarantor in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		$mem_id = Input::get('member_id');

		$member1 = Member::findOrFail($mem_id);

		$loanaccount = Loanaccount::findOrFail(Input::get('loanaccount_id'));

		$member = Member::findOrFail($loanaccount->member->id);

		$guarantor = Loanguarantor::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Loanguarantor::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}



		$guarantor->member()->associate($member1);
		$guarantor->loanaccount()->associate($loanaccount);
		$guarantor->update();

		include(app_path() . '\views\AfricasTalkingGateway.php');
        $username   = "kenkode";
        $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = $member1->phone;
    // And of course we want our recipients to know what we really do
    $message    = $member->name." ID ".$member->id_number." has borrowed a loan of ksh. ".$loanaccount->amount_applied." for loan product ".$loanaccount->loanproduct->name." on ".$loanaccount->application_date." and has selected you as his/her guarantor.
    Please login and approve or reject
    Thank you!";
    // Create a new instance of our awesome gateway class
    $gateway    = new AfricasTalkingGateway($username, $apikey);
    // Any gateway error will be captured by our custom Exception class below, 
    // so wrap the call in a try-catch block
    try 
    { 
      // Thats it, hit send and we'll take care of the rest. 
      $results = $gateway->sendMessage($recipients, $message);
                
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

		return Redirect::to('loans/show/'.$loanaccount->id);
	}


	public function cssupdate($id)
	{
		//Begin guarantor vetting process
		$mem_id = Input::get('member_id');
		$member = Member::findOrFail($mem_id);

		$loanaccount = Loanaccount::findOrFail(Input::get('loanaccount_id'));
		
		$guarantor = Loanguarantor::findOrFail($id);
		
		$validator = Validator::make($data = Input::all(), Loanguarantor::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$guarantor->member()->associate($member);
		$guarantor->loanaccount()->associate($loanaccount);
		$guarantor->amount = Input::get('amount');
		$guarantor->save();

		return Redirect::to('memloans/'.$loanaccount->id);
	}

	/**
	 * Remove the specified loanguarantor from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Loanguarantor::destroy($id);

		return Redirect::back()->withAlert('The guarantor successfully removed from the list of your guarantors.');
	}


	public function cssdestroy($id)
	{

		$guarantor = Loanguarantor::findOrFail($id);


		Loanguarantor::destroy($id);

		 return Redirect::to('memloans/'.$guarantor->loanaccount->id);
	}

}
