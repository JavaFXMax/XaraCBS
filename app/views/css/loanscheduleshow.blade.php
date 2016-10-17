@extends('layouts.membercss')
@section('content')
<br/>

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

<div class="row">

<div class="col-lg-4">


<table class="table table-hover">

  <tr>
    <td>Member</td><td>{{ $loanaccount->member->name }}</td>
  </tr>
  <tr>
    <td>Loan Account</td><td>{{ $loanaccount->account_number }}</td>
  </tr>

</table>


</div>	

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



<div class="col-lg-5 pull-right">

 <a  class="btn btn-success btn-sm" href="{{ URL::to('memberloanrepayments/create/'.$loanaccount->id) }}"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Repay Loan</a>
 <a  class="btn btn-success btn-sm" href="{{ URL::to('memberloanrepayments/offset/'.$loanaccount->id) }}"> <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Offset Loan</a>

<!--
 <a  class="btn btn-success btn-sm" href="{{ URL::to('loanaccounts/reschedule/'.$loanaccount->id) }}"> <span class="glyphicon glyphicon-random" aria-hidden="true"></span>  Reschedule Loan</a>
-->
 <!-- <a  class="btn btn-success btn-sm" href="{{ URL::to('loanaccounts/topup/'.$loanaccount->id) }}"> <span class="glyphicon glyphicon-download" aria-hidden="true"></span> Top up Loan</a> -->

</div>

</div>



<hr>

<div class="row">




<div class="col-lg-4">

<table class="table table-bordered table-hover">

	<tr>

		<td>Loan Type</td><td>{{ $loanaccount->loanproduct->name}}</td>


	</tr>
	<tr>

		<td>Date Disbursed</td><td>{{ $loanaccount->date_disbursed}}</td>


	</tr>
	<tr>

		<td>Amount Disbursed</td><td>{{ asMoney($loanaccount->amount_disbursed)}}</td>


	</tr>

  @if($loanaccount->is_top_up)
  <tr>

    <td>Top Up Amount</td><td>{{ asMoney($loanaccount->top_up_amount)}}</td>


  </tr>
  @endif

  <!--

	<tr>

		<td>Interest Amount</td><td>{{ asMoney($interest)}}</td>


	</tr>



  <tr>

    <td>Loan Amount</td><td>{{ asMoney($loanaccount->amount_disbursed + $interest)}}</td>


  </tr>
	
-->

</table>


</div>



<div class="col-lg-4">

<table class="table table-bordered table-hover">



	<tr>

		<td>Principal Paid</td><td>{{ asMoney($principal_paid)}}</td>


	</tr>

	<tr>

		<td>Interest Paid</td><td>{{ asMoney($interest_paid)}}</td>


	</tr>

<!--
  <tr>

    <td>Loan Balance </td><td>{{ asMoney($loanbalance)}}</td>


  </tr>
-->

	<tr>

		<td>Principal Balance </td><td>{{ asMoney(Loanaccount::getPrincipalBal($loanaccount))}}</td>


	</tr>
  <!--
	<tr>

		<td>Interest Balance</td><td>{{ asMoney($interest - $interest_paid)}}</td>


	</tr>


-->
	



</table>


</div>



<div class="col-lg-4">

<table class="table table-bordered table-hover">



  <tr>

    <td>Loan Period</td><td>{{ $loanaccount->period." months"}}</td>


  </tr>

  <tr>

    <td>Interest rate</td><td>{{  $loanaccount->interest_rate." %"}}</td>


  </tr>


  <tr>

    <td>Repayment Duration </td><td>{{  $loanaccount->repayment_duration." months"}}</td>


  </tr>

 



  



</table>


</div>


</div>







</div>



<div class="row">
	<div class="col-lg-12">

<hr>

</div>	
</div>






<div class="row">


	<div class="col-lg-12">




		<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#remittance" aria-controls="remittance" role="tab" data-toggle="tab">Loan Schedule</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Loan Transactions</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Loan Guarantors</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="remittance">
    	<br>

    	<div class="col-lg-12"> 

        <div class="panel panel-default">
            <div class="panel-heading">
               <p>Loan Schedule</p>
             <!-- <a href="{{URL::to('loans/schedule/'.$loanaccount->id)}}" class="btn btn-success btn-sm"> <i class="glyphicon glyphicon-file"> </i> Print Schedule</a>
-->
            </div>
        <div class="panel-body">

    		
        <table class="table table-condensed table-hover">

          <thead>

            <th>Instalment #</th>
            <th>Date </th>
            <th>Principal </th>
            <th>Interest </th>
            <th>Total </th>
            <th>Loan Balance </th>
            <th>Monthly Payment </th>

          </thead>
          <tbody>


            <tr>

              <td>0</td>
              <td>
<?php 

            $date = date("d-M-Y", strtotime($loanaccount->date_disbursed));
            ?>

                {{ $date }}</td>
              <td>{{ asMoney($loanaccount->amount_disbursed + $loanaccount->top_up_amount)}}</td>
              <td>{{ asMoney(Loanaccount::getInterestAmount($loanaccount))}}</td>
              <td>{{ asMoney(Loanaccount::getLoanAmount($loanaccount))  }}</td>
              <td>{{ asMoney(Loanaccount::getLoanAmount($loanaccount))  }}</td>
              <td>{{ asMoney(0)  }}</td>
            </tr>


            <?php 

                $date = date("d-M-Y", strtotime($loanaccount->repayment_start_date));

                $interest = Loanaccount::getInterestAmount($loanaccount);

                
                
                $principal = $loanaccount->amount_disbursed + $loanaccount->top_up_amount;
                
                $balance = Loanaccount::getLoanAmount($loanaccount);
                $days = 30;
                $totalint =0;


                if($loanaccount->repayment_duration !=null){

                    $period = $loanaccount->repayment_duration;

                } else {

                  $period = $loanaccount->period;
                }


                $principal_amount =$loanaccount->amount_disbursed/ $period;

                $total_principal = 0;

            for($i=1; $i<=$period; $i++) { ?> 


              
            <tr>

             

              <td>{{ $i }}</td>
              <td>
      
                {{ $date  }}

              </td>

              <td> 

<?php $total_principal = $total_principal + $principal_amount; ?>
                {{ asMoney($principal_amount)}} </td>
              <td> 
                <?php 

                if($loanaccount->loanproduct->formula == 'SL'){

                  $interest_amount = $interest/$period;
                }

                if($loanaccount->loanproduct->formula == 'RB'){

                  $interest_amount =((($principal - $total_principal) * ($loanaccount->interest_rate/100)));

                }

                

                ?>

                {{ asMoney($interest_amount)}} </td>
              <td> 
                <?php $total = ($principal_amount + $interest_amount); 


                  $totalint = $totalint + $total;
                ?>

                {{ asMoney($total)}} </td>
              <td>
             

                {{ asMoney($balance - $total)}}

              </td>

               <td>
             
@if($loanaccount->loanproduct->amortization == 'EI')
                {{ asMoney(Loanaccount::getEMP($loanaccount))}}
@endif

@if($loanaccount->loanproduct->amortization == 'EP')
                {{ asMoney($total)}}
@endif

              </td>

            </tr>




            <?php
              $balance = $balance - $total; 
              

            
              $days = $days + 30;

         


               
                //$date = date('Y-m-d', strtotime($date) + $days);

                $date = date('d-M-Y', strtotime($date. ' + 30 days'));

                  //$date = date('Y-m-d', $date);
                

          } ?>

         

          </tbody>


        </table>




</div>
</div>

    	</div>
    	
    </div>










    <div role="tabpanel" class="tab-pane" id="profile">

    	<br>

    	<div class="col-lg-12">

    <div class="panel panel-default">
      <div class="panel-heading">
         <p>Loan Transactions

          <a  href="{{ URL::to('loantransactions/statement/'.$loanaccount->id)}}" target="_blank" class="pull-right"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Loan Statements</a>
       

         </p>

        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Date</th>

         <th>Description</th>
         <th>Cr</th>
         
           <th>Dr</th>
           <!-- <th>Balance</th> -->
        <th></th>

      </thead>
      <tbody>

        <?php $i = 2;

        $balance = $loanaccount->amount_disbursed + Loanaccount::getInterestAmount($loanaccount);


         ?>

         <tr>

          <td> 1</td>
          <td>

            <?php 

            $date = date("d-M-Y", strtotime($loanaccount->date_disbursed));
            ?>

            {{ $date}}</td>
          <td>Loan disbursement</td>
          
          <td> 0.00</td>
          <td >{{ asMoney($loanaccount->amount_disbursed)}}</td>
          <td>
<!--
<a  href="{{ URL::to('loantransactions/receipt/')}}" target="_blank"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Receipt</a>
-->

          </td> 


         </tr>


        @foreach($loantransactions as $transaction)

        @if($transaction->description != 'loan disbursement')
        <tr>

          <td> {{ $i }}</td>
          <td>

            <?php 

            $date = date("d-M-Y", strtotime($transaction->date));
            ?>

            {{ $date }}</td>
          <td>{{ $transaction->description }}</td>
          
          

       

           @if( $transaction->type == 'debit')
            <td>

              <?php $creditamount = 0; ?>

              0.00</td>
          <td >{{ asMoney($transaction->amount)}}</td>
         
          @endif


          @if( $transaction->type == 'credit')
          
          <td>
              <?php $creditamount = $transaction->amount; ?>

            {{ asMoney($transaction->amount) }}</td>
            <td>0.00</td>
          @endif

          <!--
          <td>
            <?php $balance = $balance - $creditamount; ?>
            {{ asMoney($balance) }}

          </td>
        -->

         <td>

<a  href="{{ URL::to('loantransactions/receipt/'.$transaction->id)}}" target="_blank"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Receipt</a>


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



    <div role="tabpanel" class="tab-pane" id="messages">


          <br>

      <div class="col-lg-12">

    <div class="panel panel-default">
      <div class="panel-heading">
         <a href="{{URL::to('memberloanguarantors/create/'.$loanaccount->id)}}" class="btn btn-primary">New Guarantor</a>

        </div>
        <div class="panel-body">


    <table id="mobile" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Member</th>

         <th>Loan Account</th>
         
           
        <th></th>

      </thead>
      <tbody>

        <?php $i=1; ?>


        @foreach($loanguarantors as $guarantor)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $guarantor->member->name }}</td>
          <td>{{ $guarantor->loanaccount->account_number }}</td>
         

        <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                   
                    <li><a href="{{URL::to('loanguarantors/delete/'.$guarantor->id)}}">Remove</a></li>
                    
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




    </div>



    <div role="tabpanel" class="tab-pane" id="settings">

      <br>
        <div class="row">
          <div class="col-lg-12">

            <div class="panel panel-default">
              <div class="panel-heading">
             

            </div>
            
            <div class="panel-body">


                <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


                  <thead>

                    <th>#</th>
                   
                    <th>Member </th>
                    <th>Branch </th>
         
                    <th></th>

                  </thead>
                  
                  <tbody>

                      <?php $i = 1; ?>
                    
                 

                    <tr>

                      <td> </td>
                    
                      <td></td>
                      <td></td>
                      <td></td>
                      <td> <a href="" class="btn btn-primary btn-sm">View </a></td>
                    </tr>

                      <?php $i++; ?>
                   


                  </tbody>


                </table>
            </div>


          </div>

        </div>
    </div>







   



  </div>







 





  

</div>


	</div>





</div>



















@stop