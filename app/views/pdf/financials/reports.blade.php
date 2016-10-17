@extends('layouts.ports')
@section('content')
<br/>





<div class="row">
	<div class="col-lg-12">
  <h3> Financial Reports</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-5">

   <form method="post" action="{{URL::to('reports/financials')}}">


      <div class="form-group">
            <label for="username">Report</label>
            <select class="form-control" name="report_type">
                <option value="">select report</option>
                <option>--------------------------</option>
                <option value="balancesheet">Balance Sheet</option>
                <option value="income">Income Statement</option>
                <option value="trialbalance">Trial Balance</option>
            </select>
            
        </div>



        <div class="form-group">
            <label for="username">As at Date </label>
            <div class="right-inner-addon ">
            <i class="glyphicon glyphicon-calendar"></i>
            <input class="form-control datepicker" readonly placeholder="" type="text" name="date" id="date" value="{{date('Y-m-d')}}">
        </div>
        </div>


        <div class="form-actions form-group">
        
        

          <button type="submit" class="btn btn-primary btn-sm">View Report</button> 
        </div>


   </form>

  </div>

</div>
























@stop