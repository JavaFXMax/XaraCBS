@extends('layouts.loans')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Loan Products</h3>

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
          <a class="btn btn-info btn-sm" href="{{ URL::to('loanproducts/create')}}">new Loan product</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Product Name</th>
        <th>Short name</th>
        <th>Formula</th>
        <th>Interest Rate</th>
         <th>Period</th>
         <th>Currency</th>
        <th></th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($loanproducts as $product)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->short_name }}</td>
          <td>{{ $product->formula }}</td>
          <td>{{ $product->interest_rate }} % monthly</td>
          <td>{{ $product->period }} Months</td> 
          <td>{{$product->currency}}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('loanproducts/show/'.$product->id)}}">View</a></li>
                    <li><a href="{{URL::to('loanproducts/edit/'.$product->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('loanproducts/delete/'.$product->id)}}">Delete</a></li>
                    
                  </ul>
              </div>

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