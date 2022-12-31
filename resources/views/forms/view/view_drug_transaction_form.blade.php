    @php
        $total_drug = \App\Models\DrugTransaction::select('amount')->where('id', $drugs->last()->drug_trans_id)->first();
    @endphp
    <table class="table">
        <thead>
            <tr>
                <th colspan="3">Entered By: {{ $drugs->last()->user->name }}</th>
                <th colspan="2">Receipt #: {{ $drugs->last()->receipt_no }}</th>
            </tr>
            <tr>
                <th>#</th>
                <th>Drug</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drugs as $key => $drug)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $drug->drug_name }}</td>
                    <td>{{ $drug->unit_price }}</td>
                    <td>{{ $drug->quantity }}</td>
                    <td>{{ number_format($drug->unit_price * $drug->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th>{{ number_format($total_drug->amount, 2) }}</th>
            </tr>
        </tfoot>
    </table>
    
    <hr width="103%" style="margin-left: -15px; background: #bbb">

    <div class="mt-4 mb-0">
        <div class="d-grid"><button type="button" class="btn btn-block btn-secondary" data-bs-dismiss="modal">Close</button></div>
    </div>