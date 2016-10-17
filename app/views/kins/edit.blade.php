@extends('layouts.member')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Update Kin</h3>

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

		 <form method="POST" action="{{{ URL::to('kins/update/'.$kin->id) }}}" accept-charset="UTF-8">
   
    <fieldset>

        <input class="form-control" placeholder="" type="hidden" name="member_id" id="member_id" value="{{ $kin->member_id }}">
        <div class="form-group">
            <label for="username">Kin Name</label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $kin->name }}">
        </div>

        <div class="form-group">
            <label for="username">ID Number</label>
            <input class="form-control" placeholder="" type="text" name="id_number" id="id_number" value="{{ $kin->id_number }}">
        </div>
        
        <div class="form-group">
            <label for="username">Relationship </label>
            <input class="form-control" placeholder="" type="text" name="rship" id="rship" value="{{ $kin->rship }}">
        </div>

         <div class="form-group">
            <label for="username">Goodwill % </label>
            <input class="form-control" placeholder="" type="text" name="goodwill" id="goodwill" value="{{ $kin->goodwill }}">
        </div>
        

        <div class="form-group">
            <label for="username">Contact</label>
            <textarea class="kindata" name="contact" id="contact">{{ $kin->contact }}</textarea>
        </div>

      
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Kin</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop