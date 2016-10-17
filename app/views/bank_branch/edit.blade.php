
@extends('layouts.organization')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Update Bank Branch</h3>

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

		 <form method="POST" action="{{{ URL::to('bankbranches/update/'.$bbranch->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Bank Branch Code <span style="color:red">*</span></label>
            <input class="form-control" placeholder="" type="text" name="code" id="code" value="{{ $bbranch->branch_code}}">
        </div>

        <div class="form-group">
            <label for="username">Bank Branch Name <span style="color:red">*</span></label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $bbranch->bank_branch_name}}">
        </div>

        <div class="form-group">
                        <label for="username">Banks <span style="color:red">*</span></label>
                        <select name="bank" id="bank" class="form-control">
                            <option></option>
                            @foreach($banks as $bank)
                            <option value="{{ $bank->id }}"<?= ($bbranch->bank_id==$bank->id)?'selected="selected"':''; ?>> {{ $bank->bank_name }}</option>
                            @endforeach
                        </select>
                
                    </div>
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Bank Branch</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>


@stop