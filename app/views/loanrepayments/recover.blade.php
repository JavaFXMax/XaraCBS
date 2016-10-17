@extends('layouts.member')
@section('content')

<br/>
<?php
function asMoney($value) {
  return number_format($value, 2);
}
?>

<div class="row">
  <div class="col-lg-6">
  @if(Session::has('deposits'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('deposits') }}}</strong> 
      </div>      
   @endif  
  @if(Session::has('done'))
        <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('done') }}}</strong> 
      </div>      
   @endif  
  @if(Session::has('balance'))
        <div class="alert alert-info alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('balance') }}}</strong> 
      </div>      
   @endif  
   @if(Session::has('none'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('none') }}}</strong> 
      </div>      
   @endif  
   </div>
	<div class="col-lg-12">
  <h3>Recovering Loan from Guarantor</h3>
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
		 <form method="POST" action="{{{ URL::to('loanrepayments/recover/complete') }}}" accept-charset="UTF-8">
    <fieldset>
       <table class="table table-condensed table-bordered">
        <tr>
          <td>Principal Due</td><td>{{ asMoney($principal_due) }}</td>
        </tr>
        <tr>
          <td>Interest Due</td><td>{{ asMoney($interest_due) }}</td>
        </tr>
          <td>Amount Due</td><td>{{ asMoney(Loanaccount::getTotalDue($loanaccount))}}</td>
        </tr>
        </table>  
        <h4 style="text-decoration: underline;">The Guarantors</h4>      
        <input class="form-control" placeholder="" type="hidden" name="loanaccount_id"
         value="{{ $loanaccount->id }}">
        <input class="form-control" placeholder="" type="hidden" name="loanaccount_balance"
         value="{{ $loanbalance }}">
        <input class="form-control" placeholder="" type="hidden" name="amount"
         value="{{ $loanaccount->amount_disbursed + $interest }}">
        <input class="form-control" placeholder="" type="hidden" name="date"
         value="{{ date('Y-m-d') }}">
        @if(isset($loanguarantors)&& count($loanguarantors)>0)  
                @foreach($loanguarantors as $rst) 
        <input type="hidden" name="member_id" value="{{$rst->mid}}" class="form-control"> 
        <div class="form-group" >                   
             <div class="form-group">            
            <input type="text" name="member_name" value="{{$rst->mname}}" class="form-control">
             </div> 
             <!--<div class=" col-lg-4">
                <a href="{{ URL::to('loanrepayments/recover/notify/'.$rst->mid) }}" class="btn btn-sm btn-warning"><i class="fa fa-bell"></i>Send Notification</a>
            </div> -->     
        </div>
                @endforeach
        @endif 
        <input type="submit" class="btn btn-success btn-sm" value="Recover Loan">
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