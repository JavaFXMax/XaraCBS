@extends('layouts.savings')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
        <h3>New Loan Product</h3>

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

         <form method="POST" action="{{ URL::to('loanproducts') }}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Product Name</label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ Input::old('name') }}}" required>
        </div>
        
      

        <div class="form-group">
            <label for="username">Product Short Name</label>
            <input class="form-control" placeholder="" type="text" name="short_name" id="short_name" value="{{{ Input::old('short_name') }}}" required>
        </div>


        <div class="form-group">
            <label for="username">Currency</label>
            <select class="form-control" name="currency" required>

                @foreach($currencies as $currency)
                <option value="{{ $currency->shortname }}"> {{ $currency->name }}</option>
                @endforeach
               


            </select>
        </div>


         <div class="form-group">
            <label for="username">Interest rate (Monthly)</label>
            <input class="form-control" placeholder="" type="text" name="interest_rate" id="interest_rate" value="{{{ Input::old('interest_rate') }}}" required>
        </div>

        <div class="form-group">
            <label for="username">Period (Months)</label>
            <input class="form-control" placeholder="" type="text" name="period" id="period" value="{{{ Input::old('period') }}}" required>
        </div>


         <div class="form-group">
            <label for="username">Interest Formula</label>
            <select class="form-control" name="formula" required>

                <option value="SL"> Straight Line (SL)</option>
                <option value="RB"> Reducing Balance (RB)</option>


            </select>
        </div>



         <div class="form-group">
            <label for="username">Amortization Method</label>
            <select class="form-control" name="amortization" required>

                <option value="EI"> Equal Instalments</option>
                <option value="EP"> Equal Principals</option>


            </select>
        </div>


    </div>




    <div class="col-lg-8">



        <div class="row">

                ASSETS
                <hr>

            <div class="col-lg-4">


    
            <div class="form-group ">
            <label for="username">Cash Account</label>
            <select class="form-control" name="cash_account" required>

                <option></option>
                @foreach($accounts as $account)
                @if($account->category == 'ASSET')
                <option value="{{ $account->id }}">{{ $account->name."(".$account->code.")" }}</option>
                @endif
                @endforeach


            </select>
            </div>

            </div>


            <div class="col-lg-4">

                <div class="form-group ">
            <label for="username">Portfolio Account</label>
            <select class="form-control" name="portfolio_account" required>

                <option></option>
                @foreach($accounts as $account)
                @if($account->category == 'ASSET')
                <option value="{{ $account->id }}">{{ $account->name."(".$account->code.")" }}</option>
                @endif
                @endforeach


            </select>
            </div>

            </div>




        </div>








         <div class="row">

                INCOME
                <hr>

            <div class="col-lg-4">


    
            <div class="form-group ">
            <label for="username">Interest Account</label>
            <select class="form-control" name="loan_interest" required>

                <option></option>
                @foreach($accounts as $account)
                @if($account->category == 'INCOME')
                <option value="{{ $account->id }}">{{ $account->name."(".$account->code.")" }}</option>
                @endif
                @endforeach


            </select>
            </div>

            </div>


            <div class="col-lg-4">

                <div class="form-group ">
            <label for="username">Fees Account</label>
            <select class="form-control" name="loan_fees" required>

                <option></option>
                @foreach($accounts as $account)
                @if($account->category == 'INCOME')
                <option value="{{ $account->id }}">{{ $account->name."(".$account->code.")" }}</option>
                @endif
                @endforeach


            </select>
            </div>

            </div>



            <div class="col-lg-4">

                <div class="form-group ">
            <label for="username">Penalties Account</label>
            <select class="form-control" name="loan_penalty" required>

                <option></option>
                @foreach($accounts as $account)
                @if($account->category == 'INCOME')
                <option value="{{ $account->id }}">{{ $account->name."(".$account->code.")" }}</option>
                @endif
                @endforeach


            </select>
            </div>

            </div>




        </div>




<?php $currency = Currency::find(1); ?>



        <div class="row">

              

            <div class="col-lg-4">

                  EXPENSE
                <hr>
    
            <div class="form-group ">
            <label for="username">Losses Written Off</label>
            <select class="form-control" name="loan_write_off" required>

                <option></option>
                @foreach($accounts as $account)
                @if($account->category == 'EXPENSE')
                <option value="{{ $account->id }}">{{ $account->name."(".$account->code.")" }}</option>
                @endif
                @endforeach


            </select>
            </div>
            <div class="form-group">
            <label for="username">Auto Loan Limit</label>

            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            <input class="form-control" placeholder="" type="text" name="autoloanlimit" id="autoloanlimit" value="{{{ Input::old('autoloanlimit') }}}">
            </div>
            </div>



            </div>


           
           <div class="col-lg-4">

  LIABILITY
                <hr>
    
            <div class="form-group ">
            <label for="username">Loan Over payments</label>
            <select class="form-control" name="loan_overpayment" required>

                <option></option>
                @foreach($accounts as $account)
                @if($account->category == 'LIABILITY')
                <option value="{{ $account->id }}">{{ $account->name."(".$account->code.")" }}</option>
                @endif
                @endforeach


            </select>
            </div>

            </div>
            <div class="col-lg-5">

            <div class="form-group" >
            <label for="username">Application Form</label>
            <select class="form-control" name="appform" >
                <option value=""> </option>
                <option value="Loan Application Form"> Loan Application Form</option>
                <option value="Quick Advance Application Form"> Quick Advance Application Form</option>

            </select>
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

                <table class="table table-bordered table-condensed">
                    <thead>
                        <th></th>
                        <th>Charge Name</th>
                        <th>Calculation Method</th>
                        <th>Payment Method</th>
                        <th>Amount</th>

                    </thead>

                    @foreach($charges as $charge)

                    <tr>

                        <td>
                            <input type="checkbox" name="charge[]"  value="{{$charge->id}}"/>

                        </td>
                        <td>{{ $charge->name}}</td>
                        <td>{{ $charge->calculation_method}}</td>
                        <td>{{ $charge->payment_method}}</td>
                        <td>{{ $charge->amount}}</td>

                    </tr>
                    @endforeach


                </table>

            </div>

        </div>

     

<div class="row">

    <div class="col-lg-10">

            <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm pull-centre">Create Product</button>
        </div>

    </fieldset>
</form>

    </div>

</div>


@stop