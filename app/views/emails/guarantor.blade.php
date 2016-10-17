<p>
Hello {{$name}}, 
</p>

<p>{{$mname}} ID {{$id}} has borrowed a loan of ksh. {{$amount_applied}} for loan product {{$product}} on {{$application_date}} and has selected you as his/her guarantor. </p>
<p>Please login and approve or reject</p>
<br><br>
<p>Regards,</p>
<?php $orgname=Organization::find(1)->pluck('name'); ?>
<p>{{$orgname}}</p>