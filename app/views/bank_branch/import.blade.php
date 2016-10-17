@extends('layouts.organization')
@section('content')

<br><br>
		
				



<div class="row">
	
	<div class="col-lg-12">
  DATA MIGRATION
		<hr>

    @if (Session::get('notice'))
            <div class="alert alert-success">{{ Session::get('notice') }}</div>
        @endif


<!-- ############################################################  -->

<div class="col-lg-12">
<p><strong>Migrate Bank Branches</strong></p>
    <p>&nbsp;</p>


    <form method="post" action="{{URL::to('import/bankBranches')}}" accept-charset="UTF-8" enctype="multipart/form-data">

      <div class="form-group">

        <label>Upload Bank Branches (excel)</label>
        <input type="file" class="" name="bbranches" value="{{asset('/Excel/')}}" />

    </div>


      <button type="submit" class="btn btn-primary">Import Bank Branch</button>

    </form>
</div>

    <!-- ############################################################  -->



<div class="col-lg-12">
    <hr>
  </div>

  </div>
</div>


@stop