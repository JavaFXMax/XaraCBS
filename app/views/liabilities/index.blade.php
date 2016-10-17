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
  <h3> Loans Guaranteed</h3>
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
            <p>Member Loan Liabilities</p>
          </div>
        <div class="panel-body">
          <table id="users" class="table table-condensed table-hover table-bodered">
            <thead>             
              <th>Loan Type</th>
              <th>Date Disbursed</th>
              <th>Amount Disbursed</th>
              <th>Duration(Months)</th>
              <th>Current Liability</th>
            </thead>
            <tbody>
              @foreach($loanaccounts as $loanaccount)
                <tr>
                  <td>{{ $loanaccount->pname}}</td>
                  <td>{{ $loanaccount->date_disbursed}}</td>                  
                  <td>{{ asMoney($loanaccount->amount_disbursed)}}</td>
                  <td>{{ $loanaccount->loanperiod}}</td>
                  <td>{{ $loanaccount->liability}}</td>                  
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@stop