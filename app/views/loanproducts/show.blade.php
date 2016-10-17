@extends('layouts.loans')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>{{$loanproduct->name}}</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-7">

      <table class="table table-bordered table-condensed table-hover table-stripped">

          <tr>
            <td>Loan Product Name</td><td>{{$loanproduct->name}}</td>

          </tr>
          <tr>
            <td>Short Name</td><td>{{$loanproduct->short_name}}</td>

          </tr>
          <tr>
            <td>Interest Rate</td><td>{{$loanproduct->interest_rate}} % monthly</td>

          </tr>
          <tr>
            <td>Period</td><td>{{$loanproduct->period}} Months</td>

          </tr>
          <tr>
            <td>Interest Formula</td>
            <td>
              @if($loanproduct->formula == 'SL')Straight Line (SL) @endif
              @if($loanproduct->formula == 'RB')Reducing Balance (RB) @endif
            </td>

          </tr>
          <tr>
            <td>Amortization Method</td>
            <td>
              @if($loanproduct->amortization == 'EI') Equal Installments @endif
              @if($loanproduct->amortization == 'EP') Equal Principal @endif
            </td>

          </tr>

          <tr>
            <td>Auto Loan Limit</td><td>{{number_format($loanproduct->auto_loan_limit,2)}}</td>

          </tr>

      </table>

  </div>
</div>
























@stop