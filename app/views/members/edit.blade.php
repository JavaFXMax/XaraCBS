@extends('layouts.member')
@section('content')

<style>

#ncontainer table{border-collapse:collapse;border-radius:25px;width:900px;}
table, td, th{border:1px solid #00BB64;}
#ncontainer input[type=checkbox]{height:30px;width:10px;border:1px solid #fff;}
tr,#ncontainer input,#ncontainer textarea,#fdate,#edate{height:30px;width:170px;border:1px solid #fff;}
#ncontainer textarea{height:50px; width:180px;border:1px solid #fff;}
#dcontainer #fdate,#edate{height:30px; width:230px;border:1px solid #fff;background: #EEE}
#ncontainer input:focus,#dcontainer input#fdate:focus,#dcontainer input#edate:focus,#ncontainer textarea:focus{border:1px solid yellow;} 
.space{margin-bottom: 2px;}
#ncontainer{margin-left:0px;}
.but{width:270px;background:#00BB64;border:1px solid #00BB64;height:40px;border-radius:3px;color:white;margin-top:10px;margin:0px 0px 0px 290px;}
</style>

  <style>

#dcontainer table{border-collapse:collapse;border-radius:25px;width:500px;}
table, td, th{border:1px solid #00BB64;}
#dcontainer input[type=checkbox]{height:30px;width:10px;border:1px solid #fff;}
tr,#dcontainer input,#dcontainer textarea{height:30px;width:180px;border:1px solid #fff;}
#f{width:200px;}
#dcontainer textarea{height:50px; width:100px;border:1px solid #fff;}
#dcontainer input:focus,#dcontainer input:focus{border:1px solid yellow;} 
.space{margin-bottom: 2px;}
#dcontainer{margin-left:0px;}
.but{width:270px;background:#00BB64;border:1px solid #00BB64;height:40px;border-radius:3px;color:white;margin-top:10px;margin:0px 0px 0px 290px;}
</style>

  <style>
    label, input#cname, input#ename { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em;}
    .validateTips, .validateTips1, .validateTips2, .validateTips3, .validateTips4, .validateTips5, .validateTips6, .validateTips7, .validateTips8{ border: 1px solid transparent; padding: 0.3em; }
    .ui-dialog 
    {
    position: fixed;
    margin-bottom: 850px;
    }


    .ui-dialog-titlebar-close {
  background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_888888_256x240.png'); }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
  border: medium none;
}
.ui-dialog-titlebar-close:hover {
  background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_222222_256x240.png'); }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
}
    
  </style>


<script type="text/javascript">
  $(document).ready(function(){
  
    $('#bank_id').change(function(){
        $.get("{{ url('api/dropdown')}}", 
        { option: $(this).val() }, 
        function(data) {
            $('#bbranch_id').empty(); 
            $('#bbranch_id').append("<option>----------------select Bank Branch--------------------</option>");
            $.each(data, function(key, element) {
            $('#bbranch_id').append("<option value='" + key +"'>" + element + "</option>");
            });
        });
    });
});
</script>

<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Update Member</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

		 <form method="POST" action="{{{ URL::to('members/update/'.$member->id) }}}" accept-charset="UTF-8" enctype="multipart/form-data">

            <div class="row">
            <div class="col-lg-4">

                 <fieldset>
                    <div class="form-group">
                        <label for="username">Member Branch</label>
                        <select name="branch_id" class="form-control">
                            @if($member->branch != null)
                            <option value="{{ $member->branch->id }}">{{ $member->branch->name }}</option>
                            @endif
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"> {{ $branch->name }}</option>
                            @endforeach

                        </select>
                
                    </div>


                     <div class="form-group">
                        <label for="username">Member Groups</label>

                        <select name="group_id" class="form-control">
                             @if($member->group != null)
                             <option value="{{ $member->group->id }}">{{ $member->group->name }}</option>
                             @endif
                            @foreach($groups as $group)
                            <option value="{{$group->id }}"> {{ $group->name }}</option>
                            @endforeach

                        </select>
                
                    </div>
                </fieldset>

            </div>


            <div class="col-lg-3">

                 <fieldset>
                    <div class="form-group">
                        <img src="{{ asset('public/uploads/photos/'.$member->photo)}}" width="50px">
                        <label for="username">Member Photo</label>
                        <input type="file" name="photo" id="photo" value="{{ $member->photo}}">
                    </div>


                     <div class="form-group">
                        <img src="{{ asset('public/uploads/photos/'.$member->signature)}}" width="50px">
                        <label for="username">Member Signature</label>
                        <input placeholder="" type="file" name="signature" id="signature" value="{{ $member->signature }}">
                    </div>
                </fieldset>

            </div>


            <div class="col-lg-4">

                 <fieldset>
                   

                    <div class="form-group">
                        <label for="username">Membership Number</label>
                        <input class="form-control" placeholder="" type="text" name="membership_no" id="membership_no" value="{{$member->membership_no}}" >
                    </div>


                </fieldset>

            </div>
</div>


<div class="row">


             <div class="col-lg-12"><hr></div></div>

<div class="row">


             <div class="col-lg-4">

                 <fieldset>
                    <div class="form-group">
                        <label for="username">Member Names</label>
                        <input class="form-control" placeholder="" type="text" name="mname" id="mname" value="{{$member->name}}" required>
                    </div>

                    <div class="form-group">
                        <label for="username">ID Number</label>
                        <input class="form-control" placeholder="" type="text" name="mid_number" id="mid_number" value="{{$member->id_number}}" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Gender</label><br>
                        @if($member->gender === 'M')
                        <input class=""  type="radio" name="gender" id="gender" value="M" checked> Male
                        <input class=""  type="radio" name="gender" id="gender" value="F"> Female
                        @endif

                         @if($member->gender === 'F')
                        <input class=""  type="radio" name="gender" id="gender" value="M" > Male
                        <input class=""  type="radio" name="gender" id="gender" value="F" checked> Female
                        @endif

                        @if($member->gender === '')
                        <input class=""  type="radio" name="gender" id="gender" value="M" > Male
                        <input class=""  type="radio" name="gender" id="gender" value="F"> Female
                        @endif
                    </div>





                </fieldset>


             </div>


             <div class="col-lg-4">

                 <fieldset>
                    <div class="form-group">
                        <label for="username">Phone Number</label>
                        <input class="form-control" placeholder="" type="text" name="phone" id="phone" value="{{ $member->phone }}">
                    </div>

                    <div class="form-group">
                        <label for="username">Email Address</label>
                        <input class="form-control" placeholder="" type="text" name="email" id="email" value="{{ $member->email }}">
                    </div>

                     <div class="form-group">
                        <label for="username">Address</label>
                        <textarea class="form-control"  name="address" id="address">{{ $member->address }}</textarea>
                    </div>
                    </fieldset>


                     </div>


             <div class="col-lg-4">
                <fieldset>

                    

                    <div class="form-group">
                        <label for="username">Monthly Remmitance Amount</label>
                        <input class="form-control" placeholder="" type="text" name="monthly_remittance_amount" id="monthly_remittance_amount" value="{{ $member->monthly_remittance_amount }}">
                    </div>

                     <div class="form-group">
                        <label for="username">Bank</label>
                        <select name="bank_id" id="bank_id" class="form-control">
                            <option></option>
                            @foreach($banks as $bank)
                            <option value="{{ $bank->id }}"<?= ($member->bank_id==$bank->id)?'selected="selected"':''; ?>> {{ $bank->bank_name }}</option>
                            @endforeach

                        </select>
                
                    </div>
                      
                     <div class="form-group">
                        <label for="username">Bank Branch</label>
                        <select name="bbranch_id" id="bbranch_id" class="form-control">
                            @foreach($bbranches as $bbranch)
                            <option value="{{$bbranch->id }}"<?= ($member->bank_branch_id==$bbranch->id)?'selected="selected"':''; ?>> {{ $bbranch->bank_branch_name }}</option>
                            @endforeach
                        </select>
                
                    </div>

                    <div class="form-group">
                        <label for="username">Bank Account Number</label>
                        <input class="form-control" placeholder="" type="text" name="bank_acc" id="bank_acc" value="{{$member->bank_account_number}}">
                    </div>


                </fieldset>


             </div>
</div>



<div class="row">


             <div class="col-lg-12"><hr></div></div>

             <div class="col-lg-12">

             <div class="form-group">
                        
                        <table id="users" class="table table-condensed table-bordered table-responsive table-hover">
                         <thead>
                         <th>#</th>
                         <th>Document</th>
                         <th>Action</th>
                         </thead>
                         <tbody>
                        <?php $j=1;?>
                        @foreach($documents as $document)
                        <tr class="del<?php echo $document->id; ?>"><td>{{$j}}</td><td>{{$document->path}}</td><td><a class="btn btn-danger delbtn" id="<?php echo $document->id; ?>">Delete</a></td></tr>
                        <?php $j++;?>
                        @endforeach
                       
                    </tbody>
                        </table>
                    </div>
                 
                    <div class="form-group">
                    <a name="docs" href="#docs" style="background-color:green;border-radius:3px;color:white;padding:10px;text-decoration:none;" id="add">Add Documents</a><br><br>
                    <div id="items"></div>
                    </div>

                    <script type="text/javascript">
$(document).ready(function(){
  $("body").on("click", "#add", function (e) {
 //Append a new row of code to the "#items" div
 $("#items").append('<div><input name="path[]" type="file" /><button type="button" style="background-color:green;color:white" id="add">Add </button>&nbsp;&nbsp;|&nbsp;&nbsp;<button class="delete btn-danger">Remove</button></div>'); 
});

$("body").on("click", ".delete", function (e) {
    $(this).parent("div").remove();
});

});
</script>

</div>


<div class="row">


             <div class="col-lg-12"><hr></div></div>

<div class="col-lg-12">
<h4 align="center"><strong>Next of Kin</strong></h4>
<div id='ncontainer'>
<table id="nextkin" border="1" cellspacing="0">
  <tr>
    <th><input class='ncheck_all' type='checkbox' onclick="select_all()"/></th>
    <th>#</th>
    <th>Name</th>
    <th>Goodwill (%)</th>
    <th>ID Number</th>
    <th>Relationship</th>
    <th>Contact</th>
  </tr>
 
  @if($countk == 0)

  <tr>
    <td><input type='checkbox' class='ncase'/></td>
    <td><span id='nsnum'>1.</span></td>
    <td><input class="kindata" type='text' id='name' name='name[0]' value="{{{ Input::old('kin_first_name[0]') }}}"/></td>
    <td><input class="kindata" type='text' id='goodwill' name='goodwill[0]' value="{{{ Input::old('goodwill[0]') }}}"/></td>
    <td><input class="kindata" type='text' id='id_number' name='id_number[0]' value="{{{ Input::old('id_number[0]') }}}"/> </td>
    <td><input class="kindata" type='text' id='relationship' name='relationship[0]' value="{{{ Input::old('relationship[0]') }}}"/></td>
    <td><textarea class="kindata" name="contact[0]" id="contact">{{{ Input::old('contact[0]') }}}</textarea></td>
  </tr>

  @else
  <?php $i = 1; ?>
  @foreach($kins as $kin)
  <tr>
    <td><input type='checkbox' class='ncase'/></td>
    <td><span id='nsnum'>{{$i}}.</span></td>
    <td><input class="kindata" type='text' id='name' name='name[{{$i-1}}]' value="{{$kin->name}}"/></td>
    <td><input class="kindata" type='text' id='goodwill' name='goodwill[{{$i-1}}]' value="{{$kin->goodwill}}"/></td>
    <td><input class="kindata" type='text' id='id_number' name='id_number[{{$i-1}}]' value="{{$kin->id_number}}"/> </td>
    <td><input class="kindata" type='text' id='relationship' name='relationship[{{$i-1}}]' value="{{$kin->rship}}"/></td>
    <td><textarea class="kindata" name="contact[{{$i-1}}]" id="contact">{{$kin->contact}}</textarea></td>
  </tr>
  <?php $i++; ?>
  @endforeach
  @endif
</table>

<button type="button" class='ndelete'>- Delete</button>
<button type="button" class='naddmore'>+ Add More</button>
</div>
<script>
$(".ndelete").on('click', function() {
  if($('.ncase:checkbox:checked').length > 0){
  if (window.confirm("Are you sure you want to delete this kin detail(s)?"))
      {
  $('.ncase:checkbox:checked').parents("#nextkin tr").remove();
    $('.ncheck_all').prop("checked", false); 
  check();
}else{
  $('.ncheck_all').prop("checked", false); 
  $('.ncase').prop("checked", false); 
}
}
});
var i=2;
$(".naddmore").on('click',function(){
  count=$('#nextkin tr').length;
    var data="<tr><td><input type='checkbox' class='ncase'/></td><td><span id='nsnum"+i+"'>"+count+".</span></td>";
    data +="<td><input class='kindata' type='text' id='name"+i+"' name='name["+(i-1)+"]' value='{{{ Input::old('name["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='goodwill"+i+"' name='goodwill["+(i-1)+"]' value='{{{ Input::old('goodwill["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='id_number"+i+"' name='id_number["+(i-1)+"]' value='{{{ Input::old('id_number["+(i-1)+"]') }}}'/></td><td><input class='kindata' type='text' id='relationship"+i+"' name='relationship["+(i-1)+"]' value='{{{ Input::old('relationship["+(i-1)+"]') }}}'/></td><td><textarea class='kindata' name='contact["+(i-1)+"]' id='contact"+i+"'>{{{ Input::old('contact["+(i-1)+"]') }}}</textarea></td>";
  $('#nextkin').append(data);
  i++;
});

function select_all() {
  $('input[class=ncase]:checkbox').each(function(){ 
    if($('input[class=ncheck_all]:checkbox:checked').length == 0){ 
      $(this).prop("checked", false); 
    } else {
      $(this).prop("checked", true); 
    } 
  });
}

function check(){
  obj=$('#nextkin tr').find('span');
  $.each( obj, function( key, value ) {
  id=value.id;
  $('#'+id).html(key+1);
  });
  }

</script>

</div>


<div class="row">


             <div class="col-lg-12"><hr></div></div>



<div class="row">


             <div class="col-lg-4 pull-right">
   
                <fieldset>
        
      
        
                        <div class="form-actions form-group">
        
                            <button type="submit" class="btn btn-primary btn-sm">Update Member</button>
                        </div>

                </fieldset>
            </div>

        </div>
</form>
		

  </div>

</div>



<script type="text/javascript">
        $(document).ready(function() {
        $('.delbtn').click( function() {
        
                var id = $(this).attr("id");
         
                if(confirm("Are you sure you want to delete this document?")){
                    $.ajax({
                        type: "POST",
                        url: "{{URL::to('deldoc')}}",
                        data: {'id': id},
                        cache: false,
                        success: function(s){
                            if(s == 0){
                              $(".del"+id).fadeOut('slow');
                            } 
                        } 
                    }); 
                }else{
                    return false;
                }
            });             
        });
        </script>




















@stop