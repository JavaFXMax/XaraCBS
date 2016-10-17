@extends('layouts.loans')
@section('content')
<br/>
<?php
function asMoney($value) {
  return number_format($value, 2);
}

?>
<div class="row">
	<div class="col-lg-12">
  <h3> Loan Accounts</h3>  
<hr>
</div>
 @if (Session::get('status'))
      <div class="alert alert-error alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('status') }}}</strong>  
    </div>                       
  @endif	
</div>
<div class="row">
	<div class="col-lg-12">
      <div role="tabpanel">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#new" aria-controls="remittance" role="tab" data-toggle="tab">New Applications</a></li>
    <!-- <li role="presentation"><a href="#amended" aria-controls="profile" role="tab" data-toggle="tab">Amended Applications</a></li>
    -->
    <li role="presentation"><a href="#approved" aria-controls="messages" role="tab" data-toggle="tab">Approved Applications</a></li>
    <li role="presentation"><a href="#rejected" aria-controls="messages" role="tab" data-toggle="tab">Rejected Applications</a></li>
   
   <li role="presentation"><a href="#disbursed" aria-controls="messages" role="tab" data-toggle="tab">Disbursed Loans</a></li>
  </ul>



  <!-- Tab panes -->
  <div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="new">
      <br>

      <div class="col-lg-12">


        <div class="panel panel-default">
            
          <div class="panel-heading">
            <p>New Applications</p>

          </div>

        <div class="panel-body">
   
          <table id="users" class="table table-condensed table-hover table-bodered">

            <thead>

              <th>Member</th>
              <th>Loan Type</th>
              <th>Date Applied</th>
              <th>Amount Applied</th>
              <th>Period (months)</th>
              <th>Interest Rate (monthly)</th>
              <th></th>

            </thead>
            <tbody>

              @foreach($loanaccounts as $loanaccount)
              @if($loanaccount->is_new_application)
                <tr>
                  <td>{{ $loanaccount->member->name}}</td>
                  <td>{{ $loanaccount->loanproduct->name}}</td>
                  <td>{{ $loanaccount->date_applied}}</td>
                  <td>{{ asMoney($loanaccount->amount_applied)}}</td>
                  <td>{{ $loanaccount->repayment_duration}}</td>
                  <td>{{ $loanaccount->interest_rate}}</td>
                  <td>

                       <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <!-- <li><a href="{{URL::to('loans/edit/'.$loanaccount->id)}}">Amend</a></li> -->
                    <li><a href="{{URL::to('loans/approve/'.$loanaccount->id)}}">Approve</a></li>
                    <li><a href="{{URL::to('loans/reject/'.$loanaccount->id)}}">Reject</a></li> 
                    
                  </ul>
                  </div>

                  </td>
                </tr>

                @endif
              @endforeach


            </tbody>

          </table>

        </div>


      </div>
    </div>
  </div>
    <div role="tabpanel" class="tab-pane" id="">
      <br>
      <div class="col-lg-12">
        <div class="panel panel-default">            
          <div class="panel-heading">
            <p>Amended Applications</p>
          </div>
        <div class="panel-body">
   
          <table id="" class="table table-condensed table-hover table-bodered">
            <thead>
              <th>Member</th>
              <th>Loan Type</th>
              <th>Date Applied</th>
              <th>Amount Applied</th>
              <th>Period (months)</th>
              <th>Interest Rate (monthly)</th>
              <th></th>

            </thead>
            <tbody>

              @foreach($loanaccounts as $loanaccount)
              @if($loanaccount->is_amended)

                <tr>
                  <td>{{ $loanaccount->member->name}}</td>
                  <td>{{ $loanaccount->loanproduct->name}}</td>
                  <td>{{ $loanaccount->date_applied}}</td>
                  <td>{{ $loanaccount->amount_applied}}</td>
                  <td>{{ $loanaccount->repayment_duration}}</td>
                  <td>{{ $loanaccount->interest_rate}}</td>
                  <td>

                       <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('loans/edit/'.$loanaccount->id)}}">Amend</a></li>
                   
                    <li><a href="{{URL::to('loans/approve/'.$loanaccount->id)}}">Approve</a></li>
                     <li><a href="{{URL::to('loans/reject/'.$loanaccount->id)}}">Reject</a></li>
                    
                  </ul>
                  </div>

                  </td>
                </tr>

                @endif
              @endforeach


            </tbody>

          </table>

        </div>


      </div>
    </div>
  </div>
  <div role="tabpanel" class="tab-pane" id="rejected">
      <br>

      <div class="col-lg-12">


        <div class="panel panel-default">
            
          <div class="panel-heading">
            <p>Rejected Applications</p>

          </div>

        <div class="panel-body">
   
          <table id="rejected" class="table table-condensed table-hover table-bodered">

            <thead>

              <th>Member</th>
              <th>Loan Type</th>
              <th>Date Applied</th>
              <th>Amount Applied</th>
              <th>Period (months)</th>
              <th>Interest Rate (monthly)</th>
              <th>Rejection Reason</th>

            </thead>
            <tbody>

              @foreach($loanaccounts as $loanaccount)
              @if($loanaccount->is_rejected)

                <tr>
                  <td>{{ $loanaccount->member->name}}</td>
                  <td>{{ $loanaccount->loanproduct->name}}</td>
                  <td>{{ $loanaccount->application_date}}</td>
                  <td>{{ $loanaccount->amount_applied}}</td>
                  <td>{{ $loanaccount->repayment_duration}}</td>
                  <td>{{ $loanaccount->interest_rate.' %'}}</td>
                    <td>{{ $loanaccount->rejection_reason}}</td> 
                </tr>

                @endif
              @endforeach


            </tbody>

          </table>

        </div>


      </div>
    </div>
  </div>
<div role="tabpanel" class="tab-pane" id="approved">
      <br>
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <p>Approved Applications</p>
          </div>
        <div class="panel-body">
          <table id="mobile" class="table table-condensed table-hover table-bodered">
            <thead>
              <th>Member</th>
              <th>Loan Type</th>
              <th>Date Applied</th>
              <th>Amount Applied</th>
              <th>Period (months)</th>
              <th>Interest Rate (monthly)</th>
              <th></th>

            </thead>
            <tbody>

              @foreach($loanaccounts as $loanaccount)
              @if($loanaccount->is_approved and !$loanaccount->is_disbursed )

                <tr>
                  <td>{{ $loanaccount->member->name}}</td>
                  <td>{{ $loanaccount->loanproduct->name}}</td>
                  <td>{{ $loanaccount->date_applied}}</td>
                  <td>{{ asMoney($loanaccount->amount_applied)}}</td>
                  <td>{{ $loanaccount->repayment_duration}}</td>
                  <td>{{ $loanaccount->interest_rate}}</td>
                  <td>

                       <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('loans/disburse/'.$loanaccount->id)}}">Disburse</a></li>
                   
                    
                    
                  </ul>
                  </div>

                  </td>
                </tr>

                @endif
              @endforeach


            </tbody>

          </table>

        </div>


      </div>
    </div>
  </div>





<div role="tabpanel" class="tab-pane" id="disbursed">
      <br>

      <div class="col-lg-12">


        <div class="panel panel-default">
            
          <div class="panel-heading">
            <p>Disbursed Loans</p>

          </div>

        <div class="panel-body">
   
          <table id="rejected" class="table table-condensed table-hover table-bodered">

            <thead>

              <th>Member</th>
              <th>Loan Type</th>
              <th>Date Applied</th>
              <th>Amount Applied</th>
              <th>Period (months)</th>
              <th>Interest Rate (monthly)</th>
              <th></th>

            </thead>
            <tbody>

              @foreach($loanaccounts as $loanaccount)
              @if($loanaccount->is_disbursed)

                <tr>
                  <td>{{ $loanaccount->member->name}}</td>
                  <td>{{ $loanaccount->loanproduct->name}}</td>
                  <td>{{ $loanaccount->date_applied}}</td>
                  <td>{{ asMoney($loanaccount->amount_applied)}}</td>
                  <td>{{ $loanaccount->repayment_duration}}</td>
                  <td>{{ $loanaccount->interest_rate}}</td>
                  <td>

                       <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('loans/show/'.$loanaccount->id)}}">Manage</a></li>
                   
                    
                    
                  </ul>
                  </div>

                  </td>
                </tr>

                @endif
              @endforeach


            </tbody>

          </table>

        </div>


      </div>
    </div>
  </div>









    </div>


















  </div>














  </div>

</div>
























@stop