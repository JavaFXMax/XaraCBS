<p>
Hello {{$name}}, 
</p>

<p>Member {{$mname}} has rejected to guarentee your loan for Ksh. {{$amount_applied}} for loan product {{$product}}. </p>
<br><br>
<p>Regards,</p>
<?php $orgname=Organization::find(1)->pluck('name'); ?>
<p>{{$orgname}}</p>