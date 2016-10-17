@extends('layouts.membercss')
@section('content')
<br/>
<?php
function asMoney($value) {
  return number_format($value, 2);
}
?>
@if(Session::has('prompt'))
      <div class="alert alert-danger alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>{{{ Session::get('prompt') }}}</strong> 
    </div>      
 @endif   
<div class="row">
	<div class="col-lg-12">  
  <h3> Loan Accounts</h3>
<hr>
</div>	
</div>
<div class="row">
	<div class="col-lg-12">      
        @if (Session::has('flash_message'))
          <div class="alert alert-success">
          {{ Session::get('flash_message') }}
         </div>
        @endif
         @if (Session::has('delete_message'))
          <div class="alert alert-danger">
          {{ Session::get('delete_message') }}
         </div>
        @endif
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
                <tr>
                  <td>{{ $loanaccount->mname}}</td>
                  <td>{{ $loanaccount->pname}}</td>
                  <td>{{ $loanaccount->application_date}}</td>
                  <td>{{ asMoney($loanaccount->amount_applied)}}</td>
                  <td>{{ $loanaccount->repayment_duration}}</td>
                  <td>{{ $loanaccount->interest_rate}}</td>
                  <td>
                  <div class="btn-group">
                <a href="{{URL::to('memberloanshow/'.$loanaccount->id)}}"><button type="button" class="btn btn-info btn-sm">
                    Show 
                  </button></a>
                  </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@stop