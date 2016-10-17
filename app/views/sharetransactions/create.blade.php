@extends('layouts.main')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <strong>Member: {{ $member->name }}</strong><br>
  <strong>Member #: {{ $member->membership_no }}</strong><br>
<strong>Share Account #: {{ $shareaccount->account_number }}</strong><br>
<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-4">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

		 <form method="POST" action="{{{ URL::to('sharetransactions') }}}" accept-charset="UTF-8">



   
    <fieldset>
        <div class="form-group">
            <label for="username">Transaction </label>
           <select name="type" class="form-control" required>
            <option></option>
            <option value="credit"> Purchase</option>
           
           </select>
        </div>
        
        
        
         <input type="hidden" name="account_id" value="{{ $shareaccount->id}}">
        

        <div class="form-group">
            <label for="username"> Date</label>
            <div class="right-inner-addon ">
            <i class="glyphicon glyphicon-calendar"></i>
            <input class="form-control datepicker" placeholder="" readonly type="text" name="date" id="date" value="{{{ Input::old('date') }}}" required>
        </div>
        </div>


        <div class="form-group">
            <label for="username"> Amount</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}" required>
        </div>


         <div class="form-group">
            <label for="username"> Description</label>
            <textarea class="form-control" name="description">{{{ Input::old('description') }}}</textarea>
            
        </div>



        
      
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop