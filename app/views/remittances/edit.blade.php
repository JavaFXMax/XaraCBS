@extends('layouts.remittance')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Monthly Remittance Management</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-4">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

        

		 <form method="POST" action="{{ URL::to('monthlyremittances/update/'.$remittance->id) }}" accept-charset="UTF-8">
   
    <fieldset>

        <div class="form-group">
            <label for="username">Amount</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{ $remittance->amount }}" required>
        </div>

        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">update</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop