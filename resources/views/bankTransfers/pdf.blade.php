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

    <table class="borderless" style="margin-top: 5em">
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

    <table class="borderless" style="margin-top: 1em">
        <tr>
            <td>
                <p>
                    Dear {{ $x->manager->title }} {{ $x->manager->last_name }},
                </p>

                <p>
                    This is to authorize your bank to transfer from <strong>{{ strtoUpper($x->from_company) }}</strong> ACCT NO. <strong>{{ strtoUpper($x->from_account) }}</strong> the 
                    amount of  <strong>PHILIPPINE PESOS {{ strtoUpper($f->format($x->amount)) }} ONLY. (PHP {{ number_format($x->amount, 2, '.', ',') }})</strong> to <strong>{{ strtoUpper($x->to_company) }}</strong> ACCT NO. <strong>{{ $x->to_account }}</strong>.
                </p>

                <p style="margin-top: 1em">
                    Thank you.
                </p>

                <p>
                    Sincerely,
                </p>


                <p style="margin-top: 2em">
                    {{ strtoUpper($x->signatory->full_name) }}
                </p>

                <p>
                    <i>Authorized signatory</i><br/>
                    {{ strtoUpper($x->from_company) }}
                </p>
            </td>
        </tr>
    </table>

</body>
</html>