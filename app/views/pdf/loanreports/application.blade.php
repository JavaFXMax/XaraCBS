
<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<html>
  <head>
   <style type="text/css">

table {
  max-width: 100%;
  background-color: transparent;
}
th {
  text-align: left;
}
.table {
  width: 100%;
  margin-bottom: 2px;
}
hr {
  margin-top: 1px;
  margin-bottom: 2px;
  border: 0;
  border-top: 2px dotted #eee;
}

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 1.428571429;
  color: #333;
  background-color: #fff;
}

@page { margin: 170px 30px; }
     .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
     .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
     .footer .page:after { content: counter(page, upper-roman); }

</style>



  <body>


    
   <div class="header">
     <table >

      <tr>


       
        <td style="width:150px">

            <img src="{{ '../images/logo.png' }}" alt="{{ $organization->logo }}" width="150px"/>
    
        </td>

        <td>
        <strong>
          {{ strtoupper($organization->name)}}<br>
          </strong>
          {{ $organization->phone}} |
          {{ $organization->email}} |
          {{ $organization->website}}<br>
          {{ $organization->address}}
       

        </td>
        
        

      </tr>


      <tr>

        <hr>
      </tr>



    </table>
   </div>
   <div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>
   <div class="content">


    <table class="table table-bordered" style="margin-top:-80px">

      <tr>


       
        <td>Member:</td><td> {{ $transaction->member->name}}</td>
      </tr>
      <tr>

        <td>Member #:</td><td> {{ $transaction->member->membership_no}}</td>

        </tr>
      <tr>
        
        <td>Account :</td><td> {{ $transaction->account_number}}</td>

      </tr>


      <tr>
        
        <td>Branch :</td><td> {{ $transaction->member->branch->name}}</td>

      </tr>


      <tr>

        <hr>
      </tr>



    </table>

<br>

     <table class="table table-bordered">

      <tr>

        <td >Loan Type</td>
        <td >{{ $transaction->loanproduct->name }}</td>
      </tr>
        <tr>

        <td >Date Applied</td>
        <td >{{ $transaction->application_date }}</td>
      </tr>
      
      <tr>

        <td >Amount Applied</td>
        <td >{{ asMoney($transaction->amount_applied,2) }}</td>
      </tr>

      <tr>

        <td >Period</td>
        <td >{{ $transaction->Period }} months</td>
      </tr>

      <tr>

        <td >Interest Rate</td>
        <td >{{ $transaction->interest_rate }}%</td>
      </tr>

      <tr>

        <td >Approval Status</td>
        @if($transaction->is_approved==1)
        <td >Approved</td>
        @endif
        @if($transaction->is_rejected==1)
        <td >Rejected</td>
        @endif

        @if($transaction->is_new_application==1)
        <td >New</td>
        @endif
       
      </tr>

      <tr>

        <hr>
      </tr>

      </table>

      <br>

      <table class="table table-bordered">

     <tr>     
        <td>GUARANTORS</td>
      </tr>

      @foreach($guarantors as $guarantor)
      @if($guarantor->is_approved == 1)
      <tr>     
        <td >{{$guarantor->member->name}}</td>
          @if($guarantor->member->signature != null || $guarantor->member->signature != "") 
          <td>
          <img src="{{ asset('public/uploads/photos/'.$guarantor->member->signature)}}" width="50px">
           </td>  
          @else
          <td></td>
          @endif
         
      </tr>
      @endif

      @endforeach

      <tr>

        <hr>
      </tr>



    </table>
     <br>

    <table class="table table-bordered">


      <tr>

        <td style="width:80px;"> Served By </td>
        <td>  {{Confide::user()->username}} </td>
        

      </tr>

     
      


      <tr>

        <hr>


      </tr>



    </table>
    <br>

 <p>Thank you for saving with us</p>


<br><br>
     
     <p style="page-break-before: always;"></p>
   </div>
 </body>
 </html>