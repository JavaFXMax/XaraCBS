<p>
Hello {{$name}}, 
</p>
<p>{{$mname}} ID {{$id}} has borrowed a loan of ksh. {{$amount_applied}} for loan product {{$product}} on {{$application_date}}. </p>
<p>Please login and approve or reject the loan application, 
and then disburse the loan application.</p>
<br><br>
<p>Regards,</p>
<?php $orgname=Organization::find(1)->pluck('name'); ?>
<p>{{$orgname}}</p>