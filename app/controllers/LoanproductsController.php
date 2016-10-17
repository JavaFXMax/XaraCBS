<?php

class LoanproductsController extends \BaseController {

	/**
	 * Display a listing of loanproducts
	 *
	 * @return Response
	 */
	public function index()
	{
		$loanproducts = Loanproduct::all();

		return View::make('loanproducts.index', compact('loanproducts'));
	}

	/**
	 * Show the form for creating a new loanproduct
	 *
	 * @return Response
	 */
	public function create()
	{

		$accounts = Account::all();
		$currencies = Currency::all();
		$charges = DB::table('charges')->where('category', '=', 'loan')->get();
		
		return View::make('loanproducts.create', compact('accounts', 'charges', 'currencies'));
	}

	/**
	 * Store a newly created loanproduct in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Loanproduct::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Loanproduct::submit($data);

		return Redirect::route('loanproducts.index')->withFlashMessage('Loan Product successfully created!');
	}

	/**
	 * Display the specified loanproduct.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$loanproduct = Loanproduct::findOrFail($id);

		return View::make('loanproducts.show', compact('loanproduct'));
	}

	public function memberloanshow($id)
	{
		/*$loanproduct = DB::table('loanaccounts')
		          ->join('loanproducts', 'loanaccounts.loanproduct_id', '=', 'loanaccounts.id')
		          ->join('members', 'loanaccounts.member_id', '=', 'member.id')
		          ->where('loanaccounts','=',$id)
		          ->select('members.name as mname','loanproducts.name as name','short_name','interest_rate','period','formula','amortization')
		          ->first();*/
		$loanaccount = loanaccount::findOrFail($id);

		return View::make('css.memberloanshow', compact('loanaccount'));
	}

	/**
	 * Show the form for editing the specified loanproduct.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$loanproduct = Loanproduct::find($id);

		$currencies = Currency::all();

		return View::make('loanproducts.edit', compact('loanproduct', 'currencies'));
	}

	/**
	 * Update the specified loanproduct in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$loanproduct = Loanproduct::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Loanproduct::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$loanproduct->name = Input::get('name');
		$loanproduct->short_name = Input::get('short_name');
		$loanproduct->interest_rate = Input::get('interest_rate');
		$loanproduct->amortization = Input::get('amortization');
		$loanproduct->formula = Input::get('formula');
		$loanproduct->period = Input::get('period');
		$loanproduct->currency = array_get($data, 'currency');
		$loanproduct->auto_loan_limit = array_get($data, 'autoloanlimit');
		$loanproduct->update();

		return Redirect::route('loanproducts.index')->withFlashMessage('Loan Product successfully updated!');
	}

	/**
	 * Remove the specified loanproduct from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Loanproduct::destroy($id);

		return Redirect::route('loanproducts.index');
	}

}
