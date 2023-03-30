<form action="{{ route('refund_bill', [$receipt_no]) }}" method="post">
    @csrf
    <p>Kindly enter Refund Amount</p>
    <p>Receipt Number: <strong>{{ $receipt_no }}</strong></p>
    <div class="row">
        <div class="col-4">
            Amount:
        </div>
        <div class="col-8">
            <input type="hidden" name="receipt_no" value="{{ $receipt_no }}">
            <input class="form-control" type="number" name="amount" min="0.01" step="0.01" required autofocus>
        </div>
    </div>

    <hr width="106.5%" style="margin-left: -15px; background: #bbb">

    <div class="float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Cancel</button>
        <button type="submit" class="btn btn-success">Yes, Continue</button>
    </div>
</form>