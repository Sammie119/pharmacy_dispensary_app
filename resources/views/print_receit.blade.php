<head>
	<title>Receipt</title>
	<style type="text/css">
		body{
			width: 330px;
		}

		table { border-collapse: collapse; }
		th {
			border-top: solid thin; 
			border-bottom: solid thin;
		}

		#main {
			border: solid 1px;
			border-radius: 10px;
		}

		#logo img{
			width: 70px;
			height: 50px;
			float: left;	
		}

		.mov {
			margin: 5px;
			text-transform: uppercase;
		}

		hr {
			border-color: #000;
		}
		button {
		   float: right;
		   padding: 10px 25px;
  
		  font-family: 'Bree Serif', serif;
		  font-weight: 200;
		  font-size: 18px;
		  color: #fff;
		  text-shadow: 0px 1px 0 rgba(0,0,0,0.25);
		  
		  background: #56c2e1;
		  border: 1px solid #46b3d3;
		  border-top-left-radius: 20px;
		  border-bottom-right-radius: 20px;
		  cursor: pointer;
		  
		  box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
		  -moz-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
		  -webkit-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
		}

		button:hover{
		  background: #3f9db8;
		  border: 1px solid rgba(256,256,256,0.75);
		  border-top-right-radius: 20px;
		  border-bottom-left-radius: 20px;
		  
		  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
		  -moz-box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
		  -webkit-box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
		}

		@media print {
			.noprint{
				visibility: hidden;
			}
		}
	</style>

	<script type="text/javascript">
		function print_1(){
			window.print();			
			window.close();
		}
		
	</script>
</head>
<body id="breaker">
<div id = "main">
	<!--<div id = "logo"  class = "mov"><img src = "../js/img/img_logo2.png"/></div>-->
	<div style="padding-top: 5px">
		<div align = "center" style="text-transform: uppercase"><b>ST. EDWARD'S HOSPITAL<br>
			P.O.Box 29<br>
			Dwinyama.<br>
		Mobile No.: 0249666318</b>
		</div>
	</div>

	<hr class = "mov">

    <div class = "mov">
		<table border="0" class="mov">
			<tr>
				<td style="padding: 2px 2px 5px 0px; font-weight: bold">Date:</td>
				<td>{{ $transaction->first()->updated_at->format('d-m-Y h:i:sa') }}</td>
			</tr>
			<tr>
				<td style="padding: 2px 2px 5px 0px; font-weight: bold">Receipt No.:</td>
				<td>{{ $transaction->first()->receipt_no }}</td>
			</tr>
		</table>
	</div>

	<hr class = "mov">

	<div class = "mov">
		<div align = "center"><u><b>Drugs Bill</b></u></div>
		<div>
			<table border = "0" class = "mov">
				<thead>
					<th style="width: 80%">Description</th>
					<th style="width: 20%">Qty</th>
					<th style="width: 20%">Amt</th>
				</thead>
				<tbody>
                    @php
                        $total_drug = \App\Models\DrugTransaction::select('amount')->where('id', $transaction->last()->drug_trans_id)->first();
                    @endphp
					@forelse ($transaction as $trans)
						<tr>
							<td STYLE = "text-align: left; padding-left: 3px;">{{ $trans->drug_name }}</td>
							<td STYLE = "text-align: center;">{{ $trans->quantity }}</td>
							{{-- <td STYLE = "text-align: center;">{{ number_format($bills->sum('amount'), 2) }}</td> --}}
							<td STYLE = "text-align: center;">{{ number_format($trans->quantity * $trans->unit_price, 2) }}</td>
						</tr>
					@empty
						<tr>
							<td colspan="23" STYLE = "text-align: left; padding-left: 3px;">No Data Found</td>
						</tr>
					@endforelse						
				</tbody>
				<tfoot>
					<th colspan = "2">Amount Paid: GH&cent;</th>
					<th>{{ number_format($total_drug->amount, 2) }}</th>
				</tfoot>
			</table>
		</div>
		
	</div>
	
	<div align = "center"><b>Stay Blessed.......</b></div>

	{{-- <div class = "mov">Cashier: {{ $bills->last()->updated_user }}</div> --}}
	
</div>
<div align = "center"><b><i>Created and Designed by: Sammav IT Services <br> 0248376160/0556226864</i></b></div>
	<div class = "mov noprint">
		<button onClick = "print_1()">Print</button>
	</div>
</body>

<script type="text/javascript">
	window.onload = function(){
		document.getElementById("breaker").style.pageBreakAfter = "always";
	};
</script>
