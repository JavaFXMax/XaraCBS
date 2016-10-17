@extends('layouts.organization')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Update Bank</h3>

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

		 <form method="POST" action="{{{ URL::to('banks/update/'.$bank->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Bank Name <span style="color:red">*</span></label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $bank->bank_name}}">
        </div>

        <div class="form-group">
            <label for="username">Bank Code <span style="color:red">*</span></label>
            <input class="form-control" placeholder="" type="text" name="code" id="code" value="{{ $bank->bank_code}}">
        </div>

        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Bank</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>


@stop