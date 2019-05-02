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
                       {{ strtoUpper($x->type->name) }}
                    </strong>
                </p>
                <p>
                    Dear {{ $x->manager->title }} {{ $x->manager->last_name }},
                </p>

                <p>
                    This is to request to your good office to endorse our new employee to corresponding BPI Branch for
                    his/her application for payroll ATM account.
                </p>

            </td>
        </tr>
    </table>

    <table style="margin-top: 1em">
        <thead>
            <tr class="pad">
                <th class="pad">Employee Name</th>
                <th class="pad">BPI Branch</th>
            </tr>
        </thead>
        <tbody>
            @foreach($x->applicants as $applicant)
                <tr class="pad">
                    <td class="pad">{{ $applicant->name }}</td>
                    <td class="pad">{{ $applicant->branch }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="borderless" style="margin-top: 1em">
        <tr>
            <td>
                Furthermore this is to certify that the above-mentioned employee is an active employee of respective company
                under the umbrella of the La Filipina Uy Gongco Group of Companies (LFUG-GOC).
            </td>
        </tr>
        <tr>
            <td>
                Hope you could assist us on this. Thank you
            </td>
        </tr>
        <tr>
            <td>

                <p class="margin-bottom: 1em; margin-top: 1em">
                    {{ strtoUpper($x->company->name) }}
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
