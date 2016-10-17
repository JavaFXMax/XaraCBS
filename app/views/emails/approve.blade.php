<p>
Hello {{$name}}, 
</p>

<p>Member {{$mname}} has approved your loan for Ksh. {{$amount_applied}} for loan product {{$product}} and has agreed to be your guarantor. </p>
<p>Please wait for final approval from the managements of the sacco so as to get the loan.</p>
<br><br>
<p>Regards,</p>
<?php $orgname=Organization::find(1)->pluck('name'); ?>
<p>{{$orgname}}</p>