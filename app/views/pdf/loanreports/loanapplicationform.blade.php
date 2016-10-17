
<?php


function asMoney($value) {
  return number_format($value, 2);
}

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

?>
<html>
  <head>
   <style type="text/css">

table {
  max-width: 100%;
  background-color: transparent;
}
th {
  text-align: left;
}
.table {
  width: 100%;
  margin-bottom: 2px;
}
hr {
  margin-top: 1px;
  margin-bottom: 2px;
  border: 0;
  border-top: 2px dotted #eee;
}

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 1.428571429;
  color: #333;
  background-color: #fff;
}

@page { margin: 170px 30px; }
     .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
     .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
     .footer .page:after { content: counter(page, upper-roman); }

</style>



  <body>


    
   <div class="header">
     <table >

      <tr>


       
        <td style="width:150px">

            <img src="{{ '../images/logo.png' }}" alt="{{ $organization->logo }}" width="150px"/>
    
        </td>

        <td>
        <strong>
          {{ strtoupper($organization->name)}}<br>
          </strong>
          {{ $organization->phone}} |
          {{ $organization->email}} |
          {{ $organization->website}}<br>
          {{ $organization->address}}
       

        </td>
        
        

      </tr>


      <tr>

        <hr>
      </tr>



    </table>
   </div>
   <div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>
   <div class="content">
    <div style="margin-top:-80px;"><h2>MOTO LOAN APPLICATION FORM</h2> <span>LOAN No : {{$transaction->account_number}}</span></div>

   

    <table class="table table-bordered">

      <tr>
      <td colspan="2"> <p>Important: LOAN APPLICATION FORM SHOULD BE SUBMITTED AND RECEIVED ON THE SOCIETY`S OFFICE ON OR BEFORE THE 10TH DAY OF THE MONTH. LATE APPLICATION WILL BE CONSIDERED IN THE SUCCEEDING MONTH. ATTACH THE LATEST 2 PAYSLIPS.</p></td>
      </tr>
      <tr>

        <td><u><strong>1. To be completed by the participant</strong></u></td>

        </tr>
      <tr>
      <td colspan="2"> <p>I, Mr./Mrs./Miss <u>{{ $transaction->member->name}}</u> hereby apply for a loan of Ksh. <u>{{asMoney($transaction->amount_applied,2)}}</u> shillings <u>{{convert_number_to_words($transaction->amount_applied)}} kenyan shillings only</u> to be repaid in <u>{{$transaction->Period}}</u> months
      instalments at Kshs. <u>{{asMoney($transaction->amount_disbursed/$transaction->period,2)}}</u> per month w.e.f. ..........................................................................the purpose of the loan is (in case of several uses of the loan; state the exact amount of each use).<br>
      a)........................................................................................&nbsp;&nbsp;&nbsp; Kshs. ....................................................................................<br>
      b)........................................................................................&nbsp;&nbsp;&nbsp; Kshs. ....................................................................................<br>
      c)........................................................................................&nbsp;&nbsp;&nbsp; Kshs. ....................................................................................<br>
      I am offering the following security for the loan:- (e.g. Guarantors, Society Deposit Final Dues etc.)<br>
      1. .......................................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. .................................................................................<br>
      3. .......................................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. .................................................................................<br>
      </p></td>
      </tr>

      <tr>
      <td colspan="2">My personal information is :-</td>
      </tr>
      <tr>
      
      <td width="260">a)&nbsp;&nbsp;Name in full <u>{{$transaction->member->name}}</u></td><td>ID No. <u>{{$transaction->member->id_number}}</u></td>
      
      </tr>
      <tr>
      
      <td width="260">b)&nbsp;&nbsp;Department ..................................................</td><td>c)&nbsp;&nbsp;Term of service ......................................................</td>
      
      </tr>

      <tr>
      
      <td width="260">d)&nbsp;&nbsp;Payroll/Est/Personal No. ..............................</td><td>e)&nbsp;&nbsp;Membership Number <u>{{$transaction->member->membership_no}}</u></td>
      
      </tr>

      <tr>
      
      <td width="260">f)&nbsp;&nbsp;Position in Employment ................................</td><td>g)&nbsp;&nbsp;Position in Society ...................................................</td>
      
      </tr>

      <tr>
      
      <td width="260">h)&nbsp;&nbsp;Present Net Income per month ....................</td><td>i)&nbsp;&nbsp;Monthly Expenditure Kshs. .......................................</td>
      
      </tr>
      
      <tr>
      
      <td colspan="2">j)&nbsp;&nbsp;Do you have a bank account? Yes/No. Bank
        @if($transaction->member->bank_id == 0)
        ...............................................................
        @else
        <u>{{Member::getBank($transaction->member->bank_id)}}</u>
        @endif
        A/C No. .......................................</td>
      
      </tr>

     <tr>
      
      <td colspan="2">k)&nbsp;&nbsp;Date of enrolment with society ........................Next of kin ...........................................Relationship:................................</td>
      
      </tr>

      <tr>
      
      <td colspan="2">l)&nbsp;&nbsp;Total deposits contribution to date: ....................................................................................................................................</td>
      
      </tr>

      <tr>
      
      <td colspan="2">m)&nbsp;&nbsp;Balance of previous Loan granted(if any) ........................................................................................................................</td>
      
      </tr>

      <tr>
      
      <td colspan="2">n)&nbsp;&nbsp;Date of birth: .............................................month .....................................Year................................Age..........................</td>
      
      </tr>

      <tr>
      <td colspan="2"> <p>I hereby declare that the foregoing particulars are true to the best of my knowledge and belief to abide by the by-laws of the Society, the loan policy, and any variations by the credit
      committee in respect of loan. I hereby authorize (1) OCIL to make the necessary deductions, including one percent(1%) interest monthly,to be made from my
      </p></td>
      </tr>

    </table>



<br><br>
     
     <p style="page-break-before: always;"></p>
   </div>
 </body>
 </html>