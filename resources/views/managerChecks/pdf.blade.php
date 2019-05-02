<!DOCTYPE html>
<html>
<head>
    <title>PDF Download</title>

    <style>
        body {
        font-family: 'Miriam Libre', sans-serif;
        }

        h1,h2,h3,h4,h5,h6{
            font-family: 'Miriam Libre', sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid #ddd;
            /* text-align: left; */
        }

        .pad {
            padding: 8px;
        }

        .borderless, .borderless th, .borderless td {
            border: 0 ! important;
            /* font-size: 12px; */
        }

    </style>

</head>
<body>

    <table class="borderless" style="margin-top: 1em">
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
         <tr>
             <td>
                <p>
                    <strong>
                        RE: {{ $x->company }} Check Issuance
                    </strong>
                </p>
             </td>
        </tr>
        <tr>
            <td>
                <p>
                    Dear {{ $x->manager->title }} {{ $x->manager->last_name }},
                </p>

                <p>
                    Please issue Manager's Check in favor of the following payees:
                </p>

            </td>
        </tr>
    </table>

    <table style="margin-top: 1em">
        <thead>
            <tr class="pad">
                <th class="pad">Payee</th>
                <th class="pad">Nature</th>
                <th class="pad">Reference</th>
                <th class="pad">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($x->payees as $payee)
                <tr class="pad">
                    <td class="pad">{{ $payee->name }}</td>
                    <td class="pad">{{ $payee->nature }}</td>
                    <td class="pad">{{ $payee->ref_num }}</td>
                    <td class="pad">{{ number_format($payee->amount, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="borderless" style="margin-top: 1em; text-align: right">
        <tr style="text-align: right">
            <td>
               <strong style="margin-right: 10px;"> MC COST: </strong> PHP {{ number_format($x->mc_cost, 2, '.', ',')  }}
            </td>
        </tr>
        <tr style="text-align: right">
            <td>
               <strong style="margin-right: 10px;">  TOTAL: </strong>  PHP {{ number_format($x->grand_total, 2, '.', ',')  }}
            </td>
        </tr>
    </table>

    <table class="borderless" style="margin-top: 1em">
        <tr>
            <td>
                Please debit to BPI account no. {{ $x->account_number }}
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin-top: 1em">
                    Thank you.
                </p>

                <p>
                    Sincerely,
                </p>

                <p class="margin-bottom: 1em; margin-top: 1em">
                    {{ strtoUpper($x->company) }}
                </p>



                @foreach($x->signatories as $signatory)
                    <p style="margin-top: 2em">
                        {{ strtoUpper($signatory['name']) }} <br/>
                        <i>Authorized signatory</i>
                    </p>
                @endforeach



            </td>
        </tr>
    </table>

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

</body>
</html>
