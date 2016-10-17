@extends('layouts.membercss')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Saving Accounts</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    

    <div class="panel panel-default">
      <div class="panel-heading">
         Saving Accounts
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        
        <th>Savings Product</th>
        <th>Account Number</th>
         
        <th></th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($member->savingaccounts as $saving)

        <tr>

          <td> {{ $i }}</td>
        
          <td>{{ $saving->savingproduct->name }}</td>
          <td>{{ $saving->account_number }}</td>
         
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('memtransactions/'.$saving->id)}}">Views</a></li>     
                    <li><a href="{{ URL::to('membersavingtransactions/create/'.$saving->id)}}" >Transact </a></li> 
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