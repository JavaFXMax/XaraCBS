@extends('layouts.savings')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
        <h3>Update {{$loanproduct->name}}</h3>

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

         <form method="POST" action="{{ URL::to('loanproducts/update/'.$loanproduct->id) }}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Product Name</label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $loanproduct->name }}" required>
        </div>
        
      

        <div class="form-group">
            <label for="username">Product Short Name</label>
            <input class="form-control" placeholder="" type="text" name="short_name" id="short_name" value="{{ $loanproduct->short_name }}" required>
        </div>

         <div class="form-group">
            <label for="username">Currency</label>
            <select class="form-control" name="currency" required>
                <option value="{{ $loanproduct->currency }}"> {{ $loanproduct->currency}}</option>

                @foreach($currencies as $currency)
                <option value="{{ $currency->shortname }}"> {{ $currency->name }}</option>
                @endforeach
               


            </select>
        </div>


         <div class="form-group">
            <label for="username">Interest rate (Monthly)</label>
            <input class="form-control" placeholder="" type="text" name="interest_rate" id="interest_rate" value="{{ $loanproduct->interest_rate }}" required>
        </div>

        <div class="form-group">
            <label for="username">Period (Months)</label>
            <input class="form-control" placeholder="" type="text" name="period" id="period" value="{{ $loanproduct->period }}" required>
        </div>


         <div class="form-group">
            <label for="username">Interest Formula</label>
            <select class="form-control" name="formula" required>
                
                    <option value="{{$loanproduct->formula}}" selected> 
                       @if($loanproduct->formula == 'SL') 
                         Straight Line (SL)
                       @endif

                       @if($loanproduct->formula == 'RB') 
                         Reducing Balance (RB)
                       @endif

                    </option> 

              

                 
                <option>--------------------------------</option>
                <option value="SL"> Straight Line (SL)</option>
                <option value="RB"> Reducing Balance (RB)</option>


            </select>
        </div>



         <div class="form-group">
            <label for="username">Amortization Method</label>
            <select class="form-control" name="amortization" required>
                
                @if($loanproduct->amortization == 'EI')

                    <option value="{{$loanproduct->amortization}}"> Equal Installments</option> 

                @endif

                 @if($loanproduct->amortization == 'EP')
                    <option value="{{$loanproduct->amortization}}"> Equal Principals</option> 

                @endif


                <option>--------------------------------</option>
                
                <option value="EI"> Equal Installments</option>
                <option value="EP"> Equal Principals</option>


            </select>
        </div>

         <div class="form-group">
            <label for="username">Auto Loan Limit</label>

            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            <input class="form-control" placeholder="" type="text" name="autoloanlimit" id="autoloanlimit" value="{{$loanproduct->auto_loan_limit}}">
            </div>
            </div>


    </div>















        

















        





    </div>



</div>


<div class="row">
    <div class="col-lg-12"><hr></div>

</div>






<div class="row">

    <div class="col-lg-10">

            <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm pull-centre">Update Product</button>
        </div>

    </fieldset>
</form>

    </div>

</div>



















@stop