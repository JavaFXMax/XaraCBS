@extends('layouts.membercss')
@section('content')
<br/>

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

<div class="row">
	<div class="col-lg-5">
 
 <table class="table table-condensed table-bordered table-hover">

 
<tr>
    <td>Account No:</td><td>{{ $account->account_number}}</td>
</tr>

<tr>
    <td>Account Balance:</td><td>{{ asMoney($balance)}}</td>
</tr>

 </table>


</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    
		
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
          
          <a  href="{{ URL::to('savingtransactions/statement/'.$account->id)}}" target="_blank" > <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Saving Statements</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-striped table-responsive table-hover">


      <thead>

        
        <th>Date</th>
        <th>Description</th>
        <th>Debit (DR)</th>
         <th>Credit (CR)</th>
         <th></th>
       
     

      </thead>
      <tbody>

      
        @foreach($account->transactions as $transaction)

        <tr>

         
          <td>{{ $transaction->date }}</td>
          <td>{{ $transaction->description }}</td>

          @if( $transaction->type == 'debit')
          <td >{{ asMoney($transaction->amount)}}</td>
          <td>0.00</td>
          @endif

       @if( $transaction->type == 'credit')
       <td>0.00</td>
          <td>{{ asMoney($transaction->amount) }}</td>
          @endif

          <td>

<a  href="{{ URL::to('savingtransactions/receipt/'.$transaction->id)}}" target="_blank"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Receipt</a>


          </td> 



        </tr>

       
        @endforeach


      </tbody>


    </table>
  </div>


  </div>

</div>


@stop