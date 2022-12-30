<form action="{{ route('store_drug') }}" method="POST" autocomplete="off">
    @csrf
    @isset($drug)
        <input type="hidden" name="id" value="{{ $drug->id }}" />
    @endisset
    <div class="form-floating mb-3">
        <input class="form-control" value="{{ (isset($drug)) ? $drug->description : null }}" name="description" type="text" required placeholder=" " />
        <label>Drug Description</label>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-floating mb-3 mb-md-0">
                <input class="form-control" value="{{ (isset($drug)) ? $drug->insurance_price : null }}" name="insurance_price" type="number" step="0.01" min="0.01" required placeholder=" " />
                <label>Insurance Price</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating mb-3 mb-md-0">
                <input class="form-control" value="{{ (isset($drug)) ? $drug->non_insurance_price : null }}" name="non_insurance_price" type="number" step="0.01" min="0.01" required placeholder=" " />
                <label>Non Insurance Price</label>
            </div>
        </div>
    </div>

    <hr width="104%" style="margin-left: -15px; background: #bbb">

    <div class="mt-4 mb-0">
        <div class="d-grid"><button type="submit" class="btn btn-block btn-primary">Submit</button></div>
    </div>
</form>