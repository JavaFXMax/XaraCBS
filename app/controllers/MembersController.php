<?php

class MembersController extends \BaseController {




	/**
	 * Display a listing of members
	 *
	 * @return Response
	 */
	public function index()
	{
		$members = Member::all();

		

		return View::make('members.index', compact('members'));
	}


	public function members(){

		//$members = Member::all();

		$pdf = PDF::loadView('pdf.blank')->setPaper('a4')->setOrientation('potrait');
 	
		return $pdf->stream('MemberList.pdf');
		
	}

	
	/**
	 * Show the form for creating a new member
	 *
	 * @return Response
	 */
	public function create()
	{
		
		$this->beforeFilter('limit');
        $count = DB::table('members')->count();
        $mno   =  001;
        if($count > 0){
          $member = Member::orderBy('id', 'DESC')->first();
          $m = preg_replace('/\D/', '', $member->membership_no);
          $mno   =  sprintf("%03d",$m+1);
        }else{
          $mno   =  001;
        }
		$banks = Bank::all();
		$bbranches = BBranch::all();
		$branches = Branch::all();
		$groups = Group::all();
		$savingproducts = Savingproduct::all();

		return View::make('members.create', compact('branches', 'mno', 'banks', 'bbranches', 'groups', 'savingproducts'));
	}

	/**
	 * Store a newly created member in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Member::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


		$member = new Member;

		if(Input::get('branch_id') != null){

			$branch = Branch::findOrFail(Input::get('branch_id'));
			$member->branch()->associate($branch);
		}
		
		if(Input::get('group_id') != null){

			$group = Group::findOrFail(Input::get('group_id'));
			$member->group()->associate($group);
		}

		

		

		


		if(Input::hasFile('photo')){

			$destination = public_path().'/uploads/photos';

			$filename = str_random(12);

			$ext = Input::file('photo')->getClientOriginalExtension();
			$photo = $filename.'.'.$ext;
			
			
			Input::file('photo')->move($destination, $photo);

			
			$member->photo = $photo;
			
		}


		if(Input::hasFile('signature')){

			$destination = public_path().'/uploads/photos';

			$filename = str_random(12);

			$ext = Input::file('signature')->getClientOriginalExtension();
			$photo = $filename.'.'.$ext;
			
			
			Input::file('signature')->move($destination, $photo);

			
			$member->signature = $photo;
			
		}


		$member->name = Input::get('mname');
		$member->id_number = Input::get('mid_number');
		$member->membership_no = Input::get('membership_no');
		$member->phone = Input::get('phone');
		$member->email = Input::get('email');
		$member->address = Input::get('address');
		$member->bank_id = Input::get('bank_id');
		$member->bank_branch_id = Input::get('bbranch_id');
		$member->bank_account_number = Input::get('bank_acc');
		$member->monthly_remittance_amount = Input::get('monthly_remittance_amount');
		$member->gender = Input::get('gender');
		if(Input::get('active') == '1'){

			

			$member->is_active = TRUE;
		} else {

			$member->is_active = FALSE;
		}

		$member->save();


		$member_id = $member->id;


		

		
		//if(Input::get('share_account') == '1'){

			

			Shareaccount::createAccount($member_id);
		//}

        $insertedId = $member->id;

        Kin::where('member_id', $insertedId)->delete();
        for ($i=0; $i <count(Input::get('name')) ; $i++) { 
        # code...
        
        if((Input::get('name')[$i] != '' || Input::get('name')[$i] != null)){
        $kin = new Kin;
        $kin->member_id=$insertedId;
        $kin->name = Input::get('name')[$i];
        $kin->goodwill = Input::get('goodwill')[$i];
        $kin->rship = Input::get('relationship')[$i];
        $kin->contact = Input::get('contact')[$i];
        $kin->id_number = Input::get('id_number')[$i];

        $kin->save();

       }
     }

		$files = Input::file('path');
        $j = 0;

        if($files != '' || $files != null){

       foreach($files as $file){
       
       if ( Input::hasFile('path')){
        $document= new Document;
        
        $document->member_id = $insertedId;
        $name = $file->getClientOriginalName();
            $file = $file->move('public/uploads/documents/', $name);
            $input['file'] = '/public/uploads/documents/'.$name;
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document->path = $name;
        $document->save();
        $j=$j+1;
       }
       }

	   }

	
		Audit::logAudit(date('Y-m-d'), Confide::user()->username, 'member creation', 'Member', '0');


		return Redirect::route('members.index');
	}

	/**
	 * Display the specified member.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$member = Member::findOrFail($id);

		$documents = Document::where('member_id',$id)->get();

		$savingaccounts = $member->savingaccounts;
		$shareaccount = $member->shareaccount;

        if(Confide::user()->user_type == 'member'){
        	return View::make('css.showmembercss', compact('member', 'savingaccounts', 'shareaccount'));
        }else{

		return View::make('members.show', compact('member', 'documents', 'savingaccounts', 'shareaccount'));
	}
	}

	/**
	 * Show the form for editing the specified member.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$member = Member::find($id);
		$branches = Branch::all();
		$kins = Kin::where('member_id',$id)->get();
		$banks = Bank::all();
		$bbranches = BBranch::where('bank_id',$member->bank_id)->get();
		$documents = Document::where('member_id',$id)->get();
		$count = Document::where('member_id',$id)->count();
		$countk = Kin::where('member_id',$id)->count();
		$groups = Group::all();

		if(Confide::user()->user_type == 'member'){
        	return View::make('css.editmembercss', compact('member', 'countk', 'kins','banks', 'bbranches','count', 'documents', 'branches', 'groups'));
        }else{
        
		return View::make('members.edit', compact('member', 'countk', 'kins','banks', 'bbranches','count', 'documents', 'branches', 'groups'));
	}
	}


	/**
	 * Update the specified member in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$member = Member::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Member::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		if(Input::get('branch_id') != null){

			$branch = Branch::findOrFail(Input::get('branch_id'));
			$member->branch()->associate($branch);
		}
		
		if(Input::get('group_id') != null){

			$group = Group::findOrFail(Input::get('group_id'));
			$member->group()->associate($group);
		}

		//$member->photo = Input::get('photo');
		//$member->signature = Input::get('signature');

		if(Input::hasFile('photo')){

			$destination = public_path().'/uploads/photos';

			$filename = str_random(12);

			$ext = Input::file('photo')->getClientOriginalExtension();
			$photo = $filename.'.'.$ext;
			
			
			Input::file('photo')->move($destination, $photo);

			
			$member->photo = $photo;

			
			
		}


		if(Input::hasFile('signature')){

			$destination = public_path().'/uploads/photos';

			$filename = str_random(12);

			$ext = Input::file('signature')->getClientOriginalExtension();
			$photo = $filename.'.'.$ext;
			
			
			Input::file('signature')->move($destination, $photo);

			
			$member->signature = $photo;
			
		}

		
		$member->name = Input::get('mname');
		$member->id_number = Input::get('mid_number');
		$member->membership_no = Input::get('membership_no');
		$member->phone = Input::get('phone');
		$member->email = Input::get('email');
		$member->address = Input::get('address');
		$member->bank_id = Input::get('bank_id');
		$member->bank_branch_id = Input::get('bbranch_id');
		$member->bank_account_number = Input::get('bank_acc');
		$member->monthly_remittance_amount = Input::get('monthly_remittance_amount');
		$member->gender = Input::get('gender');
		$member->update();

		$insertedId = $member->id;

        
        Kin::where('member_id', $insertedId)->delete();
        for ($i=0; $i <count(Input::get('name')) ; $i++) { 
        # code...
        
        if((Input::get('name')[$i] != '' || Input::get('name')[$i] != null)){
        $kin = new Kin;
        $kin->member_id=$insertedId;
        $kin->name = Input::get('name')[$i];
        $kin->goodwill = Input::get('goodwill')[$i];
        $kin->rship = Input::get('relationship')[$i];
        $kin->contact = Input::get('contact')[$i];
        $kin->id_number = Input::get('id_number')[$i];

        $kin->save();

       }
     }


		$files = Input::file('path');
        $j = 0;

        if($files != '' || $files != null){

       foreach($files as $file){
       
       if ( Input::hasFile('path')){
        $document= new Document;
        
        $document->member_id = $insertedId;
        $name = $file->getClientOriginalName();
            $file = $file->move('public/uploads/documents/', $name);
            $input['file'] = '/public/uploads/documents/'.$name;
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document->path = $name;
        $document->save();
        $j=$j+1;
       }
       }

	   }

        if(Confide::user()->user_type == 'member'){
        return Redirect::to('/member')->withFlashMessage('You have successfully updated your membership details!');
        }else{
		return Redirect::route('members.index');
	}

	}

	
	/**
	 * Remove the specified member from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Member::destroy($id);

		return Redirect::route('members.index');
	}



	public function loanaccounts($id)
	{
		$member = Member::findOrFail($id);

		return View::make('members.loanaccounts', compact('member'));
	}


	public function activateportal($id){

		$member = Member::find($id);
		$organization = Organization::find(1);


		$password = strtoupper(Str::random(8));

		

        $email = $member->email;
        $phone = $member->phone;
        $name = $member->name;

      //  if($phone != null){

        /*include(app_path() . '\views\AfricasTalkingGateway.php');
    // Specify your login credentials
    $username   = "kenkode";
    $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = $phone;
    // And of course we want our recipients to know what we really do
    $message    = "Hello ".$name.",
    Your self service portal account has been activated 
    Below is your login credentials:
    1. Username - ".$member->membership_no."
    2. Password - ".$password."
    Regards,
    ".$organization->name;
    // Create a new instance of our awesome gateway class
    $gateway    = new AfricasTalkingGateway($username, $apikey);
    // Any gateway error will be captured by our custom Exception class below, 
    // so wrap the call in a try-catch block
    try 
    { 
      // Thats it, hit send and we'll take care of the rest. 
      $results = $gateway->sendMessage($recipients, $message);
      DB::table('users')->insert(
	  array('email' => $member->email,
	  'phone' => $member->phone, 
	  'username' => $member->membership_no,
	  'password' => Hash::make($password),
	  'user_type'=>'member',
	  'confirmation_code'=> md5(uniqid(mt_rand(), true)),
	  'confirmed'=> 1
		)
);
            

        $member->is_css_active = true;
		$member->update();

       return Redirect::back()->with('notice', 'Member has been activated and login credentials sent to their phone number');

      /*foreach($results as $result) {
        // status is either "Success" or "error message"
        echo " Number: " .$result->number;
        echo " Status: " .$result->status;
        echo " MessageId: " .$result->messageId;
        echo " Cost: "   .$result->cost."\n";
      }*/
   /* }
    catch ( AfricasTalkingGatewayException $e )
    {
      echo "Encountered an error while sending: ".$e->getMessage();
    }*/

		if($email != null){

		DB::table('users')->insert(
	array('email' => $member->email, 
	  'username' => $member->membership_no,
	  'password' => Hash::make($password),
	  'user_type'=>'member',
	  'confirmation_code'=> md5(uniqid(mt_rand(), true)),
	  'confirmed'=> 1
		)
);

		$member->is_css_active = true;
		$member->update();





	Mail::send( 'emails.password', array('password'=>$password, 'name'=>$name), function( $message ) use ($member)
{
    $message->to($member->email )->subject( 'Self Service Portal Credentials' );
});


       return Redirect::back()->with('notice', 'Member has been activated and login credentials sent to their email address');



		

}

else{

	return Redirect::back()->with('notice', 'Member has not been activated kindly update phone number');

}





		

	}



	public function deactivateportal($id){

		
		$member = Member::find($id);

		DB::table('users')->where('username', '=', $member->membership_no)->delete();

		$member->is_css_active = false;
		$member->update();


	/*if($member->phone != null){

    include(app_path() . '\views\AfricasTalkingGateway.php');
    // Specify your login credentials
    $username   = "kenkode";
    $apikey     = "7876fef8a4303ec6483dfa47479b1d2ab1b6896995763eeb620b697641eba670";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $recipients = $phone;
    // And of course we want our recipients to know what we really do
    $message    = "Hello ".$name.",
    Your self service portal account has been deactivated 
    Regards,
    ".$organization->name;
    // Create a new instance of our awesome gateway class
    $gateway    = new AfricasTalkingGateway($username, $apikey);
    // Any gateway error will be captured by our custom Exception class below, 
    // so wrap the call in a try-catch block
    try 
    { 
      // Thats it, hit send and we'll take care of the rest. 
      $results = $gateway->sendMessage($recipients, $message);

       return Redirect::back()->with('notice', 'Member has been successfully deactivated');

      /*foreach($results as $result) {
        // status is either "Success" or "error message"
        echo " Number: " .$result->number;
        echo " Status: " .$result->status;
        echo " MessageId: " .$result->messageId;
        echo " Cost: "   .$result->cost."\n";
      }*/
   /* }
    catch ( AfricasTalkingGatewayException $e )
    {
      echo "Encountered an error while sending: ".$e->getMessage();
    }
*/
		/*if($email != null){

		DB::table('users')->insert(
	array('email' => $member->email, 
	  'username' => $member->membership_no,
	  'password' => Hash::make($password),
	  'user_type'=>'member',
	  'confirmation_code'=> md5(uniqid(mt_rand(), true)),
	  'confirmed'=> 1
		)
);

		$member->is_css_active = true;
		$member->update();





	Mail::send( 'emails.password', array('password'=>$password, 'name'=>$name), function( $message ) use ($member)
{
    $message->to($member->email )->subject( 'Self Service Portal Credentials' );
});*/


	return Redirect::back()->with('notice', 'Member has been successfully deactivated');


}
	public function savingtransactions($acc_id){
		 $account = Savingaccount::findorfail($acc_id);
		 $balance = Savingaccount::getAccountBalance($account);
    	return View::make('css.savingtransactions', compact('account', 'balance'));
	}
	public function loanaccounts2(){
		$mem = Confide::user()->username;
		$id = DB::table('members')->where('membership_no', '=', $mem)->pluck('id');
		$member = Member::findOrFail($id);
		return View::make('css.loanaccounts', compact('member'));
	}
	public function reset($id){
		//$id = DB::table('members')->where('membership_no', '=', $mem)->pluck('id');
		$member = Member::findOrFail($id);
		$user_id = DB::table('users')->where('username', '=', $member->membership_no)->pluck('id');
		
		$user = User::findOrFail($user_id);
		
		$user->password = Hash::make('tacsix123');
		$user->update();
		
		return Redirect::back();
		
	}
     
    public function deletedoc(){
		
		//$id = DB::table('members')->where('membership_no', '=', $mem)->pluck('id');\

        Document::destroy(Input::get('id'));

		return 0;
		
	}
	


	

}
