@extends('layouts.ports')
{{ HTML::script('media/js/jquery.js') }}
<script type="text/javascript">
$(document).ready(function() {
$('#memberid').change(function(){
        $.get("{{ url('api/loans')}}", 
        { option: $(this).val() }, 
        function(data) {
            $('#loanaccount_id').empty(); 
            $('#loanaccount_id').append("<option value=''>select Member Loan</option>");
            $('#loanaccount_id').append("<option value=''>--------------------------</option>");
            $.each(data, function(key, element) {
                $('#loanaccount_id').append("<option value='" + key +"'>" + element + "</option>");
            });
        });
    });
});
</script>
@section('content')



<br/>

<div class="row">
  <div class="col-lg-12">
  <h3>Select Member</h3>

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

     <form target="_blank" method="POST" action="{{URL::to('loanapplication/form')}}" accept-charset="UTF-8">
   
    <fieldset>
            <div class="form-group">
                        <label for="username">Select Member:</label>
                        <select name="memberid" id="memberid" class="form-control" required>
                            <option></option>
                            @foreach($members as $member)
                            <option value="{{$member->id }}"> {{ $member->membership_no.' : '.$member->name }}</option>
                            @endforeach

                        </select>
                
        </div>

        <div class="form-group">
                        <label for="username">Select Loan:</label>
                        <select name="loanaccount_id" id="loanaccount_id" class="form-control" required>
                            <option value=''>--------------------------</option>
                           

                        </select>
                
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Select Employee</button>
        </div>

    </fieldset>
</form>
    

  </div>

</div>




@stop