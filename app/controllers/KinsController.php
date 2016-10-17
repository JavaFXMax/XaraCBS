<?php

class KinsController extends \BaseController {

	/**
	 * Display a listing of kins
	 *
	 * @return Response
	 */
	public function index()
	{
		$kins = Kin::all();

		return View::make('kins.index', compact('kins'));
	}

	/**
	 * Show the form for creating a new kin
	 *
	 * @return Response
	 */
	public function create($id)
	{

		$member = Member::findOrFail($id);
		return View::make('kins.create', compact('member'));
	}

	/**
	 * Store a newly created kin in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Kin::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


		$member = Member::findOrFail(Input::get('member_id'));


		$kin = new Kin;

		$kin->member()->associate($member);
		$kin->name = Input::get('name');
		$kin->rship = Input::get('rship');
		$kin->goodwill = Input::get('goodwill');
		$kin->id_number = Input::get('id_number');
		$kin->contact = Input::get('contact');
		$kin->save();

		return Redirect::to('members/show/'.$member->id);
	}

	/**
	 * Display the specified kin.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$kin = Kin::findOrFail($id);

		return View::make('kins.show', compact('kin'));
	}

	/**
	 * Show the form for editing the specified kin.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$kin = Kin::find($id);

		return View::make('kins.edit', compact('kin'));
	}

	/**
	 * Update the specified kin in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$kin = Kin::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Kin::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$member = Member::findOrFail(Input::get('member_id'));


		

		$kin->member()->associate($member);
		$kin->name = Input::get('name');
		$kin->rship = Input::get('rship');
		$kin->goodwill = Input::get('goodwill');
		$kin->id_number = Input::get('id_number');
        $kin->contact = Input::get('contact');

		$kin->update();

		return Redirect::to('members/show/'.$member->id);
	}

	/**
	 * Remove the specified kin from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Kin::destroy($id);

		return Redirect::route('kins.index');
	}

}
