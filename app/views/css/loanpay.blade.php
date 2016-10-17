@extends('layouts.membercss')
@section('content')

<br/>

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

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


       <table class="table table-condensed table-bordered">


        <tr>

          <td>Member</td><td>{{$loanaccount->member->name}}</td>
        </tr>
        <tr>

          <td>Loan Account</td><td>{{$loanaccount->account_number}}</td>
        </tr>

        <tr>

          <td>Loan Amount</td><td>{{ asMoney($loanaccount->amount_disbursed + $interest) }}</td>
        </tr>

        <tr>

          <td>Loan Balance</td><td>{{ asMoney($loanbalance) }}</td>
        </tr>
       

       </table> 
       

		 <form method="POST" action="{{{ URL::to('loanpayment/'.$loanaccount->id) }}}" accept-charset="UTF-8">
   
    <fieldset>


       <table class="table table-condensed table-bordered">


        <tr>

          <td>Principal Due</td><td>{{ asMoney($principal_due) }}</td>
        </tr>
        
        <tr>

          <td>Interest Due</td><td>{{ asMoney($interest_due) }}</td>
        </tr>


       

          <td>Duration Due</td><td>{{ asMoney(Loanaccount::getTotalDue($loanaccount))}}</td>
        </tr>
        </table>

        <input class="form-control" placeholder="" type="hidden" name="loanaccount_id" id="loanaccount_id" value="{{ $loanaccount->id }}">
        <input class="form-control" style="width:200px" placeholder="" type="hidden" name="mid" id="mid" value="{{$loanaccount->member->id}}">
        <input class="form-control" style="width:200px" placeholder="" type="hidden" name="mname" id="mname" value="{{$loanaccount->member->name}}">
        <input class="form-control" style="width:200px" placeholder="" type="hidden" name="phone" id="phone" value="{{$loanaccount->member->phone}}">
 

         <div class="form-group">
                        <label for="username">Repayment Date <span style="color:red">*</span></label>
                        <input required class="form-control" readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{date('Y-m-d')}}">
              
       </div>


        <div class="form-group">
            <label for="username">Amount</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}">
        </div>


         
        


        
      
        
        <div class="form-actions form-group">
        
        

          <button type="submit" class="btn btn-primary btn-sm">Submit Payment</button> 
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