<?php
error_reporting(0);
$con = mysqli_connect("localhost","root","","xaracbs");
	
	if (mysqli_connect_errno())
    {
     echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
session_start();

if(isset($_REQUEST['id'])){
	$sql=mysqli_query($con,"SELECT * FROM loanaccounts WHERE id='".$_REQUEST['id']."'") or die(mysqli_error($con));
	$row=mysqli_fetch_array($sql,MYSQLI_ASSOC);
	$total = $row['amount_to_pay'] - $_REQUEST['amount'];
	$db=mysqli_query($con,"UPDATE loanaccounts SET amount_to_pay = '".$total."' WHERE id ='".$_REQUEST['id']."'") or die(mysqli_error($con));
    if($db){
    	header('Location: http://localhost/tacs/memberloanrepayments');
    }
}

?>