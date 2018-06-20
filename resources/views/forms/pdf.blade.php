<!DOCTYPE html>
<html>
<head>
	<title>PDF Download</title>


		<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">

        <style>
        body {
        font-family: 'Miriam Libre', sans-serif;
        font-size: 70%;
        }

        h1,h2,h3,h4,h5,h6{
            font-family: 'Miriam Libre', sans-serif;
        }

    table, th, td {
	   border: 0.50px solid black ! important;
	}

	.borderless, .borderless th, .borderless td {
		border: 0 ! important;
		font-size: 12px;
	}


  
    </style>

</head>
<body>


<table class="table table-bordered">
		<tr>
			<td rowspan="3">
				<img class="logo-logo" src="{{asset('image/lfug-logo.png')}}" 
				style="display:block;  width: 60px; height: auto; padding: 0; margin: 10px 10px 0 30px;">
			</td>
			<td colspan="5" >La Filipina Uy Gongco Group of Companies</td>
		</tr>
		<tr>
			<td> 
			Doc No. <strong>LFQM-F-002</strong>
			</td>
			<td>
			Rev No. <strong>03</strong>
			</td>
			<td>
			Effective Date
			</td>
			<td colspan="2">
			February 27, 2017
			</td>
		</tr>
		<tr>
			<td colspan="5">
			BANK TEMPLATE
			</td>
		</tr>
</table>


<table class="table table-bordered">
    <tr>
        <td>
            {{ $form->bank->name }}
        </td>
        <td>
            {{ $form->company->name }}
		</td>
		<td>
			{{ $form->field1 }}
		</td>
    </tr>
</table>


</body>
</html>