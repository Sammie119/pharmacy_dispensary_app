<link href="{{ asset('public/assets/bootstrap/bootstrap_5.2.1.min.css') }}" rel="stylesheet" id="bootstrap-css">
<style>
    @media print {
			.noprint, #back{
				visibility: hidden;
			}
		}
</style>
@php
    $total_amount = 0;
    $total_quantity = 0;
@endphp

<div id="back"><a href="{{ url()->previous() }}">Back</a></div>
@switch($report['report_type'])
    @case('users')
        <div style="font-size: 20px; text-align: center; padding-top: 30px">USERS INCOME REPORT</div>
        <div style="font-size: 16px; text-align: center; padding-top: 10px">Report Range: {{ $report['date_from'] }} to {{ $report['date_to'] }}</div>
        {{-- {{ dd($query) }} --}}
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($query as $key => $user)
                    @php
                        $total_amount += $user->amount;
                    @endphp
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $user->user->name }}</td>
                        <td>{{ number_format($user->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th>{{ number_format($total_amount, 2) }}</th>
                </tr>
            </tfoot>
        </table>
        @break

    @case('drugs')
        <div style="font-size: 20px; text-align: center; padding-top: 30px">DRUGS INCOME REPORT</div>
        <div style="font-size: 16px; text-align: center; padding-top: 10px">Report Range: {{ $report['date_from'] }} to {{ $report['date_to'] }}</div>
        {{-- {{ dd($query) }} --}}
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Drug Name</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($query as $key => $drug)
                    @php
                        $total_amount += $drug->amount;
                        $total_quantity += $drug->quantity;
                    @endphp
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $drug->drug_name }}</td>
                        <td>{{ $drug->quantity }}</td>
                        <td>{{ number_format($drug->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th>{{ $total_quantity }}</th>
                    <th>{{ number_format($total_amount, 2) }}</th>
                </tr>
            </tfoot>
        </table>
        @break
@endswitch

<button class="noprint btn btn-primary" onclick="print_1()">Print</button>

<script type="text/javascript">
    function print_1(){
        window.print();
        window.location = "{{ url()->previous() }}";
    }
</script>
