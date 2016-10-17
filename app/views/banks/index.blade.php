@extends('layouts.organization')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Banks</h3>

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
          <a class="btn btn-info btn-sm" href="{{ URL::to('banks/create')}}">new bank</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning btn-sm" href="{{ URL::to('banksimport')}}">Import</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Bank Code</th>
        <th>Bank Name</th>
        <th>Action</th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($banks as $bank)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $bank->bank_code }}</td>
          <td>{{ $bank->bank_name }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('banks/edit/'.$bank->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('banks/delete/'.$bank->id)}}" onclick="return (confirm('Are you sure you want to delete this bank?'))">Delete</a></li>
                    
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