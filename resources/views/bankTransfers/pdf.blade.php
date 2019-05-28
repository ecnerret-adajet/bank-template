<!DOCTYPE html>
<html>
<head>
    <title>PDF Download</title>

    <style>
        @page { margin-bottom: 100px 25px; }
        header { position: fixed; top: -60px; left: 0px; right: 0px; background-color: lightblue; height: 50px; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 100px; }

        body {
        font-size: 80%;
        font-family: 'Miriam Libre', sans-serif;
        }

        h1,h2,h3,h4,h5,h6{
            font-family: 'Miriam Libre', sans-serif;
        }

        table {
            width: 100%;
        }

        table, th, td {
        border: 0.50px solid black ! important;
        }

        .borderless, .borderless th, .borderless td {
            border: 0 ! important;
            /* font-size: 12px; */
        }

    </style>

</head>
<body>

    <footer>
      <table class="borderless" style="margin-top: 5em">
        <tr>
            <td style="text-align: center">
                <span>This form is only for bank use and is valid only if signed by the authorized signatories.</span>
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                <span style="font-size: 80%; color: #8795A1">Created By: {{ $x->user->name }}</span>
            </td>
        </tr>
    </table>
  </footer>
    <table class="borderless" style="margin-top: 5em">
        <tr>
            <td>
                <img style="width: 100px; height: auto;" src="{{asset('/storage/'. $img)}}">
            </td>
        </tr>
        <tr>
            <td width="50%">
                <strong>
                {{ date('F d, Y',strtotime($x->created_at)) }}
                </strong>
            </td>
            <td width="50%" align="right">
                <p>
                {{ $x->ref_num }}
                </p>
            </td>
        </tr>
    </table>

    <table class="borderless">
        <tr>
            <td>
                <strong>
                {{ $x->manager->full_name }}
                </strong> <br/>
                <span>
                    Branch Manager
                </span> <br/>
                <span>

                </span>

            </td>
        </tr>
    </table>

    <table class="borderless" style="margin-top: 1em">
        <tr>
            <td>
                <strong>
                <span>
                {{ $x->manager->bank->name }}
                </span> <br/>
                <span>
                    {{ $x->manager->bank->branch }}
                </span> <br/>
                <span>
                    {{ $x->manager->bank->location }}
                </span>
                </strong>
            </td>
        </tr>
    </table>

    @php
        $tempNum = explode( '.' , $x->amount);

        $convertedNumber = count($tempNum) > 1 ?
                           strtoUpper($f->format($tempNum[0])) . ' AND ' . strtoUpper($f->format(strlen($tempNum[1]) == 1 ? $tempNum[1].'0' : $tempNum[1]) . ' CENTAVOS ') :
                           strtoUpper($f->format($tempNum[0]));

    @endphp

    <table class="borderless" style="margin-top: 1em">
        <tr>
            <td>
                <p>
                    Dear {{ $x->manager->title }} {{ $x->manager->last_name }},
                </p>

                <p>
                    This is to authorize your bank to transfer from <strong>{{ strtoUpper($x->from_company) }}</strong> ACCT NO. <strong>{{ strtoUpper($x->from_account) }}</strong> the
                    amount of  <strong>PHILIPPINE PESOS {{ $convertedNumber }} ONLY. (PHP {{ number_format($x->amount, 2, '.', ',') }})</strong> to <strong>{{ strtoUpper($x->to_company) }}</strong> ACCT NO. <strong>{{ $x->to_account }}</strong>.
                </p>

                <p style="margin-top: 1em">
                    Thank you.
                </p>

                <p>
                    Sincerely,
                </p>

                <p class="margin-bottom: 1em; margin-top: 1em">
                    {{ strtoUpper($x->from_company) }}
                </p>

                @foreach($x->signatories as $signatory)
                    @if($signatory['name'])
                    <p style="margin-top: 2em">
                        {{ strtoUpper($signatory['name']) }} <br/>
                        <i>Authorized signatory</i>
                    </p>
                    @endif
                @endforeach

            </td>
        </tr>
    </table>


</body>
</html>
