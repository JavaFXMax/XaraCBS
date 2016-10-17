@extends('layouts.ports')
@section('content')
<br/>





<div class="row">
	<div class="col-lg-12">
  <h3> Loan Reports</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    <ul>

      <li>

        <a href="{{ URL::to('loanapplication/member') }}" target="_blank"> Loan Application Form</a>

      </li>

      <li>

        <a href="{{ URL::to('reports/loanlisting') }}" target="_blank"> Loan Listing report</a>

      </li>

      @foreach($loanproducts as $loanproduct)

       <li>

        <a href="{{ URL::to('reports/loanproduct/'.$loanproduct->id)}}" target="_blank"> {{ $loanproduct->name}} report</a>

      </li>
      @endforeach


      



    </ul>

  </div>

</div>
























@stop