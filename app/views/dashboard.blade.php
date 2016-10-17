@extends('layouts.main')
@section('content')

<br><br>
		
										<div class="row">
											<div class="col-md-2">
												<a class="btn btn-default btn-icon input-block-level" href="{{ URL::to('members')}}">
													<i class="fa fa-users fa-2x"></i>
													<div>{{{ Lang::get('messages.dashboard.members') }}}</div>
													
												</a>
											</div>																							
											<div class="col-md-2">
												<a class="btn btn-default btn-icon input-block-level" href="{{URL::to('loanproducts')}}">
													<i class="fa fa-barcode fa-2x"></i>
													<div>{{{ Lang::get('messages.dashboard.loans') }}}</div>
													
												</a>
											</div>

											<div class="col-md-2">
												<a class="btn btn-default btn-icon input-block-level" href="{{ URL::to('savingproducts')}}">
													<i class="fa fa-home fa-2x"></i>
													<div>{{{ Lang::get('messages.dashboard.savings') }}}</div>
													
												</a>
											</div>
											
											<div class="col-md-2">
												<a class="btn btn-default btn-icon input-block-level" href="{{ URL::to('shares/show/1')}}">
													<i class="fa fa-home fa-2x"></i>
													<div>{{{ Lang::get('messages.dashboard.shares') }}}</div>
													
												</a>
											</div>


											<div class="col-md-2">
												<a class="btn btn-default btn-icon input-block-level" href="{{ URL::to('accounts')}}">
													<i class="fa fa-home fa-2x"></i>
													<div>{{{ Lang::get('messages.dashboard.accounting') }}}</div>
													
												</a>
											</div>


											<div class="col-md-2">
												<a class="btn btn-default btn-icon input-block-level" href="{{ URL::to('transaudits')}}">
													<i class="fa fa-tasks fa-2x"></i>
													<div>Transactions</div>
													
												</a>
											</div>

											


											
											
										</div>
									



<div class="row">
	
	<div class="col-lg-12">
		<hr>

	</div>
</div>


<div class="row">
	


	<div class="col-lg-12">

@if(Session::get('notice'))
            <div class="alert">{{{ Session::get('notice') }}}</div>
        @endif
	<div class="panel panel-success">
      <div class="panel-heading">
          <h4>{{{ Lang::get('messages.members') }}}</h4>
        </div>
        <div class="panel-body">

		  <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>{{{ Lang::get('messages.table.number') }}}</th>
        <th>{{{ Lang::get('messages.table.name') }}}</th>
        <th>{{{ Lang::get('messages.table.branch') }}}</th>

        <th></th>
         <th></th>
         <th></th>
         <th></th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($members as $member)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $member->membership_no }}</td>
          <td>{{ $member->name }}</td>
          <td>{{ $member->branch->name }}</td>

          <td>
          	 <a href="{{ URL::to('member/savingaccounts/'.$member->id) }}" class="btn btn-info btn-sm">{{{ Lang::get('messages.savings') }}}</a>

                    </td>


                    <td>

                  <a href="{{  URL::to('members/loanaccounts/'.$member->id) }}" class="btn btn-info btn-sm">{{{ Lang::get('messages.loans') }}}</a>

                    </td>

                     <td>
          	 <a href="{{ URL::to('sharetransactions/show/'.$member->shareaccount->id) }}" class="btn btn-info btn-sm">{{{ Lang::get('messages.shares') }}}</a>

                    </td>
          <td>
          	 <a href="{{ URL::to('members/show/'.$member->id) }}" class="btn btn-info btn-sm">{{{ Lang::get('messages.manage') }}}</a>

                    </td>



                     



        </tr>

        <?php $i++; ?>
        @endforeach


      </tbody>


    </table>
</div>
</div>

	</div>	


<div class="row">

	<div class="col-lg-12">
		<hr>
	</div>	

	

	
</div>
@stop
