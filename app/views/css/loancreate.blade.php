@extends('layouts.membercss')

@section('content')

{{ HTML::script('js/jquery-1.10.2.js') }}

<script type="text/javascript">
$(document).ready(function() {
$('#loanproduct_id').change(function(){
  if($(this).val() != ""){
        $.get("{{ url('api/label')}}", 
        { option: $(this).val() }, 
        function(data) {
           $( "label#amt" ).replaceWith( '<label for="username" id="amt">Amount Applied (Instant Loan amount '+data+') <span style="color:red">*</span></label>');
        });
      }else{
        $( "label#amt" ).replaceWith( '<label for="username" id="amt">Amount Applied</label>');
      }
    });
});
</script>
<br/>

<div class="row">
	<div class="col-lg-6">
  @if(Session::has('max1'))
        <div class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('max1') }}}</strong> 
      </div>      
   @endif  
   @if(Session::has('max2'))
        <div class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('max2') }}}</strong> 
      </div>      
   @endif  
   @if(Session::has('max3'))
        <div class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('max3') }}}</strong> 
      </div>      
   @endif  
   @if(Session::has('less'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('less') }}}</strong> 
      </div>      
   @endif   
    @if(Session::has('more'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('more') }}}</strong> 
      </div>      
   @endif   
   @if(Session::has('complain'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('complain') }}}</strong> 
      </div>      
   @endif   
   @if(Session::has('dismiss'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('dismiss') }}}</strong> 
      </div>      
   @endif   
   @if(Session::has('reject'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('reject') }}}</strong> 
      </div>      
   @endif 
   @if(Session::has('repel'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{{ Session::get('repel') }}}</strong> 
      </div>      
   @endif         
  @if (Session::has('delete_message'))
    <div class="alert alert-danger">
    {{ Session::get('delete_message') }}
   </div>
  @endif
  <h3>Loan Application</h3>
<hr>
</div>	
</div>
<div class="row">
	<div class="col-lg-5">
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif
		 <form method="POST" action="{{{ URL::to('loans/application') }}}" accept-charset="UTF-8">
    <fieldset>
        <input class="form-control" placeholder="" type="hidden" name="member_id" id="member_id" value="{{$member->id}}">
         <div class="form-group">
            <label for="username">Loan Product <span style="color:red">*</span></label>
            <select class="form-control" name="loanproduct_id" id="loanproduct_id">
                <option value="">select product</option>
                <option value="">--------------------------</option>
                @foreach($loanproducts as $loanproduct)
                <option value="{{$loanproduct->id}}">{{ $loanproduct->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="username">Application Date <span style="color:red">*</span></label>
            <div class="right-inner-addon">
            <i class="glyphicon glyphicon-calendar"></i>
            <input class="form-control datepicker" readonly placeholder="" type="date" name="application_date" id="application_date" value="{{ date('Y-m-d')}}">
        </div>
        </div>
        <div class="form-group">
            <label for="username" id="amt">Amount Applied <span style="color:red">*</span></label>
            <input class="form-control" placeholder="" type="text" name="amount_applied" id="amount_applied" value="{{{ Input::old('amount_applied') }}}">
        </div>
         <div class="form-group">
            <label for="username">Repayment Period(months) <span style="color:red">*</span></label>
            <input class="form-control" placeholder="" type="text" name="repayment_duration" id="repayment_duration" value="{{{ Input::old('repayment_duration') }}}">
        </div>
        <div class="form-group">
          <label for="username">Loan Guarantor 1</label>
            <select name="guarantor_id1" id="guarantor_id" class="form-control">
              <option></option>
                @foreach($guarantors as $guarantor)
                <option value="{{$guarantor->id }}"> {{ $guarantor->name }}</option>
                @endforeach
              </select>                  
        </div>        
         <div class="form-group">
              <label for="username">Loan Guarantor 2</label>
              <select name="guarantor_id2" id="guarantor_id" class="form-control">
                <option></option>
                  @foreach($guarantors as $guarantor1)
                  <option value="{{$guarantor1->id }}"> {{ $guarantor1->name }}</option>
                  @endforeach
                </select>                  
         </div>        
         <div class="form-group">
              <label for="username">Loan Guarantor 3</label>
              <select name="guarantor_id3" id="guarantor_id" class="form-control">
              <option></option>
                @foreach($guarantors as $guarantor2)
                <option value="{{$guarantor2->id }}"> {{ $guarantor2->name }}</option>
                @endforeach
              </select>
         </div>         
        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary btn-sm">Submit Application</button> 
        </div>
    </fieldset>
</form>
  </div>
</div>
<!-- organizations Modal -->
<div class="modal fade" id="schedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Loan Schedule</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">        
        <div class="form-actions form-group">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>        
        </div>

      </div>
    </div>
  </div>
</div>














@stop