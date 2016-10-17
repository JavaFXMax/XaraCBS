<?php

class LoanliabilitiesController extends \BaseController {

	/**
	 * Display a listing of loanaccounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$loanaccounts = DB::table('loanaccounts')
						->join('loanguarantors','loanaccounts.id','=','loanguarantors.loanaccount_id')
						->join('members','loanaccounts.member_id','=','members.id')
						->join('loanproducts','loanaccounts.loanproduct_id','=','loanproducts.id')
						->where('members.membership_no','=',Confide::User()->username)				
						->select('loanproducts.name as pname','loanaccounts.application_date as date_disbursed','loanaccounts.amount_applied as amount_disbursed','loanaccounts.repayment_duration as loanperiod','loanguarantors.amount as liability')
						->groupBy('loanaccounts.id')
						->get();					
		return View::make('liabilities.index', compact('loanaccounts'));
	}







}