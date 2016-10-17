@extends('layouts.remittance')
@section('content')
<br/>
<div class="row">
	<div class="col-lg-12">
  <h3>Monthly Remittance Management</h3>
<hr>
</div>	
</div>
<div class="row">
	<div class="col-lg-5">
    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">
      <tr>
        <td>Amount </td><td>{{$remittance->monthly_remittance_amount}}</td>
      </tr>
      <tr>
        <td><a href="{{URL::to('monthlyremittances/edit/'.$remittance->id)}}">Update</a></td>
      </tr>
    </table>
  </div>
</div>
























@stop