@extends('layouts.accounting')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Loan Application</h3>

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


       

		 <form method="POST" action="{{{ URL::to('loans/apply') }}}" accept-charset="UTF-8">
   
    <fieldset>


        <input class="form-control" placeholder="" type="hidden" name="member_id" id="member_id" value="{{$member->id}}">

         <div class="form-group">
            <label for="username">Loan Product</label>
            <select class="form-control" name="loanproduct_id">
                <option value="">select product</option>
                <option>--------------------------</option>
                @foreach($loanproducts as $loanproduct)
                <option value="{{$loanproduct->id}}">{{ $loanproduct->name }}</option>
                @endforeach
            </select>
            
        </div>



        <div class="form-group">
            <label for="username">Application Date </label>
            <div class="right-inner-addon ">
            <i class="glyphicon glyphicon-calendar"></i>
            <input class="form-control datepicker" readonly placeholder="" type="text" name="application_date" id="application_date" value="{{{ Input::old('application_date') }}}">
        </div>
        </div>


        <div class="form-group">
            <label for="username">Amount Applied</label>
            <input class="form-control" placeholder="" type="text" name="amount_applied" id="amount_applied" value="{{{ Input::old('amount_applied') }}}">
        </div>





         <div class="form-group">
            <label for="username">Repayment Period(months)</label>
            <input class="form-control" placeholder="" type="text" name="repayment_duration" id="repayment_duration" value="{{{ Input::old('repayment_duration') }}}">
        </div>
        


        
      
        
        <div class="form-actions form-group">
        
        

          <button type="submit" class="btn btn-primary btn-sm">Submit Application</button> 
        </div>

    </fieldset>
</form>

  	

  </div>

</div>











<!-- organizations Modal -->
<div class="modal fade" id="schedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Loan Schedule</h4>
      </div>
      <div class="modal-body">


        
        



        
      </div>
      <div class="modal-footer">
        
        <div class="form-actions form-group">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        
        </div>

      </div>
    </div>
  </div>
</div>














@stop