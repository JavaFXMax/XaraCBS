<?php

class SavingtransactionsController extends \BaseController {

	/**
	 * Display a listing of savingtransactions
	 *
	 * @return Response
	 */
	public function index()
	{
		$savingtransactions = Savingtransaction::all();

		return View::make('savingtransactions.index', compact('savingtransactions'));
	}

	/**
	 * Show the form for creating a new savingtransaction
	 *
	 * @return Response
	 */
	public function create($id)
	{

		$savingaccount = Savingaccount::findOrFail($id);

		$credit = DB::table('savingtransactions')->where('savingaccount_id', '=', $savingaccount->id)->where('type', '=', 'credit')->sum('amount');
		$debit = DB::table('savingtransactions')->where('savingaccount_id', '=', $savingaccount->id)->where('type', '=', 'debit')->sum('amount');

		$balance = $credit - $debit;

		$member = $savingaccount->member;

		
        if(Confide::user()->user_type == 'member'){
		return View::make('css.membersavings', compact('savingaccount', 'member', 'balance'));
	    }else{
        return View::make('savingtransactions.create', compact('savingaccount', 'member', 'balance'));
	    }

	}

	/**
	 * Store a newly created savingtransaction in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Savingtransaction::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$date = Input::get('date');
		$transAmount = Input::get('amount');

		$savingaccount = Savingaccount::findOrFail(Input::get('account_id'));
		$date = Input::get('date');
		$amount = Input::get('amount');
		$type = Input::get('type');
		$description = Input::get('description');
		$transacted_by = Input::get('transacted_by');


		Savingtransaction::transact($date, $savingaccount, $amount, $type, $description, $transacted_by);

		
		return Redirect::to('savingtransactions/show/'.$savingaccount->id);
	}

	/**
	 * Display the specified savingtransaction.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$account = Savingaccount::findOrFail($id);

		$credit = DB::table('savingtransactions')->where('savingaccount_id', '=', $account->id)->where('type', '=', 'credit')->sum('amount');
		$debit = DB::table('savingtransactions')->where('savingaccount_id', '=', $account->id)->where('type', '=', 'debit')->sum('amount');

		$balance = $credit - $debit;

		return View::make('savingtransactions.show', compact('account', 'balance'));
	}

	/**
	 * Show the form for editing the specified savingtransaction.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$savingtransaction = Savingtransaction::find($id);

		return View::make('savingtransactions.edit', compact('savingtransaction'));
	}

	/**
	 * Update the specified savingtransaction in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$savingtransaction = Savingtransaction::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Savingtransaction::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$savingtransaction->update($data);

		return Redirect::route('savingtransactions.index');
	}

	/**
	 * Remove the specified savingtransaction from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Savingtransaction::destroy($id);

		return Redirect::route('savingtransactions.index');
	}


	public function receipt($id){

		$transaction = Savingtransaction::findOrFail($id);

		$organization = Organization::findOrFail(1);

		$pdf = PDF::loadView('pdf.receipt', compact('transaction', 'organization'))->setPaper('a6')->setOrientation('potrait');;
 	
		return $pdf->stream('receipt.pdf');


	}


	public function statement($id){

		$account = Savingaccount::findOrFail($id);

		$transactions = $account->transactions;


		$credit = DB::table('savingtransactions')->where('savingaccount_id', '=', $account->id)->where('type', '=', 'credit')->sum('amount');
		$debit = DB::table('savingtransactions')->where('savingaccount_id', '=', $account->id)->where('type', '=', 'debit')->sum('amount');

		$balance = $credit - $debit;

		$organization = Organization::findOrFail(1);

		$pdf = PDF::loadView('pdf.statement', compact('transactions', 'organization', 'account', 'balance'))->setPaper('a4')->setOrientation('potrait');;
 	
		return $pdf->stream('statement.pdf');


	}


	public function import(){

		if(Input::hasFile('saving')){

			$destination = public_path().'/uploads/savings/';

			$filename = date('Y-m-d');

			$ext = Input::file('saving')->getClientOriginalExtension();
			$photo = $filename.'.csv';
			
			
			$file = Input::file('saving')->move($destination, $photo);

			//$file = public_path().'/uploads/savings/'.$filename;


			
			
			
			$row = 1;

			$saving = array();
			
if (($handle = fopen(public_path().'/uploads/savings/'.$photo, "r")) !== FALSE) {
    
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        	echo '<pre>';

        	$saving[] = array('date'=>$data[0], 'member'=>$data[1], 'account'=>$data[2], 'amount'=>$data[3]);
    }

   $i = 1;

   for ($i=1; $i < count($saving); $i++) { 
   		
   		$member = $saving[$i]['member'];
   		$account = $saving[$i]['account'];
   		$amount = $saving[$i]['amount'];
   		$date = $saving[$i]['date'];

   		$member_no = DB::table('members')->where('membership_no', '=', $member)->get();

		if(empty($member_no)){

			return Redirect::to('import')->with('error', 'The member does not exist');
		}

   		$account_no = DB::table('savingaccounts')->where('account_number', '=', $account)->get();


		if(empty($account_no)){

			return Redirect::to('import')->with('error', 'The saving account does not exist');
		}

		

   		Savingtransaction::importSavings($member_no, $date, $account_no, $amount);
   }
    
    fclose($handle);
}
		
			
		}

 return Redirect::to('/')->with('notice', 'Member savings successfully imported');
 

	}



	public function void($id){

		Savingtransaction::destroy($id);

		 return Redirect::back()->with('notice', ' transaction has been successfully voided');
	}



}
