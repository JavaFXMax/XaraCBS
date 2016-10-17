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
  <h3> Loan Repayments</h3>

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
            <p>Applied Loans</p>

          </div>

        <div class="panel-body">
   
          <table id="users" class="table table-condensed table-hover table-bodered">

            <thead>
              <th>#</th>
              <th>Loan Type</th>
              <th>Loan Number</th>
              <th>Loan Amount</th>
              <th>Loan Balance</th>
              <th>Action</th>

            </thead>
            <tbody>
              <?php $i = 1; ?>
              @foreach($member->loanaccounts as $loanaccount)

              @if($loanaccount->is_disbursed == TRUE)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{ $loanaccount->loanproduct->name }}</td>
                  <td>{{ $loanaccount->account_number }}</td>
                  <td>{{ asMoney($loanaccount->amount_applied) }}</td>
                  @if(asMoney($loanaccount->amount_applied) == asMoney(Loanaccount::getLoanAmount($loanaccount)))
                  <td>{{ asMoney(0) }}</td>
                  @else
                  <td>{{ asMoney(Loanaccount::getLoanAmount($loanaccount)) }}</td>
                  @endif
                
                  <td>
                   <a href="{{ URL::to('memberloan/show/'.$loanaccount->id) }}" class="btn btn-info btn-sm">View</a>
                  </td>
                </tr>
                <?php $i++; ?>
                @endif
              @endforeach


            </tbody>

          </table>

        </div>


      </div>
    </div>
  </div>

@stop