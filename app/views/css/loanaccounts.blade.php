@extends('layouts.membercss')
@section('content')
<br/>
<?php
function asMoney($value) {
  return number_format($value, 2);
}
?>
<div class="row">
  <div class="col-lg-8">
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('message') }}}</strong> 
      </div>      
   @endif        
  </div>
	<div class="col-lg-12">
  <h3>{{$member->name}} Loan Accounts</h3>
  <hr>
</div>	
</div>
<div class="row">
	<div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
          <a class="btn btn-info btn-sm" href="{{ URL::to('loans/application/'.$member->id)}}">New Loan Application</a>
        </div>
        <div class="panel-body">
      <table id="users" class="table table-condensed table-bordered table-responsive table-hover">
      <thead>
        <th>#</th>
        <th>Loan Type</th>
        <th>Loan Amount</th>
        <th>Status </th>
        <th></th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($member->loanaccounts as $loan)
        <tr>
          <td> {{ $i }}</td>
          <td>{{ $loan->loanproduct->name }} - {{$loan->loan_purpose}}</td>
          <td>{{ asMoney($loan->amount_applied) }}</td>
          <td>

            @if($loan->is_new_application == true)
              new application 
            @endif
            
            @if($loan->is_approved)
              approved 
            @endif

            @if($loan->is_rejected)
              rejected 
            @endif

            @if($loan->is_disbursed)
              disbursed 
            @endif

            @if($loan->is_amended)
               amended 
            @endif

            </td>
          
          <td>
            @if($loan->is_disbursed)
             <a href="{{ URL::to('memloans/'.$loan->id) }}" class="btn btn-info btn-sm">Manage</a>
             @endif

          </td>
                    

        </tr>

        <?php $i++; ?>

        
        @endforeach


      </tbody>


    </table>
  </div>


  </div>

</div>
























@stop