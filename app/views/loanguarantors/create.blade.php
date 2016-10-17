@extends('layouts.accounting')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Loan Guarantor</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-5">
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

         @if (Session::get('null'))
            <div class="alert alert-error alert-danger alert-dismissible fade in" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>{{{ Session::get('null') }}}</strong>  
          </div>                       
        @endif
        @if (Session::get('bang'))
            <div class="alert alert-error alert-info alert-dismissible fade in" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>{{{ Session::get('bang') }}}</strong>  
          </div>                       
        @endif
<form method="POST" action="{{{ URL::to('loanguarantors') }}}" accept-charset="UTF-8">
    <fieldset>
     <input class="form-control" placeholder="" type="hidden" name="loanaccount_id" id="loanaccount_id" value="{{$loanaccount->id}}">
         <div class="form-group">
            <label for="username">Member </label>
            <select class="form-control borderless" name="member_id">
                <option value="">select member</option>
                <option>--------------------------</option>
                @foreach($members as $member)
                <option value="{{$member->id}}">{{ $member->membership_no  }} {{ $member->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary btn-sm">Add Guarantor</button> 
        </div>

    </fieldset>
</form>

  	

  </div>

</div>























@stop