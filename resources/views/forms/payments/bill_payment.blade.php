<form action="{{ route('bill_payment', [$receipt_no]) }}" method="get">

    <p>Are you sure you have collected the money from the Patient?</p>

    <hr width="106.5%" style="margin-left: -15px; background: #bbb">

    <div class="float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Cancel</button>
        <button type="submit" class="btn btn-success">Yes, Continue</button>
    </div>
</form>