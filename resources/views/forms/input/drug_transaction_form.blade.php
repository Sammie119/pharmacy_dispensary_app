<form action="{{ route('store_drug_transaction') }}" method="POST" autocomplete="off">
    @csrf
    @isset($drugs)
        <input type="hidden" name="id" value="{{ $drugs->last()->drug_trans_id }}" />
        @php
            $total_drug = \App\Models\DrugTransaction::select('amount')->where('id', $drugs->last()->drug_trans_id)->first();
        @endphp
    @endisset
    <div class="row mb-3" style="margin-left: 35%; margin-right: 35%">
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="insurance" value="1" id="insured" checked>
                <label class="form-check-label" for="insured">
                  Insured
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="insurance" value="0" id="non_insured">
                <label class="form-check-label" for="non_insured">
                    Not Insured
                </label>
            </div>
        </div>
    </div>

    <hr width="103%" style="margin-left: -15px; background: #bbb">

    <div class="col-md-12">
        <div class="row ">
            <div class="form-group col-md-6">
                <label for="recipient-name" class="control-label">Enter Description</label>
                <input type="text" class="form-control form-control-border drug" list="drugsList" id="drug_1" placeholder="Enter Drug"/>
            </div>
            <datalist id="drugsList">
                <select id = "drugsListSel">
                    @foreach (\App\Models\Drug::orderBy('description')->get() as $drug)
                        <option value='{{ $drug->description }}'>
                    @endforeach
                </select>
            </datalist>
            <div class="form-group col-md-2">
                <label for="recipient-name" class="control-label">Action</label>
                <a class="form-control btn btn-success addRow">Add Drug</a>
            </div>
        </div>
    </div>

    <hr width="103%" style="margin-left: -15px; background: #bbb">

   <div class="form-group">
        <div class="row mb-2" style="border-bottom: 1px solid #000">
            <div class="col-7">
                <label for="recipient-name" class="control-label">Drug</label>
            </div>
            <div class="col-1">
                <label for="recipient-name" class="control-label">Price</label>
            </div>
            <div class="col-1">
                <label for="recipient-name" class="control-label">Qty</label>
            </div>
            <div class="col-2">
                <label for="recipient-name" class="control-label">Amt</label>
            </div>
            <div class="col-1">
                <label for="recipient-name" class="control-label">Action</label>
            </div>
        </div>
        @isset($drugs)
            <div class="row getTotalAmount" id="content">
                @foreach ($drugs as $drug)
                    <div class="row mb-2">
                        <div class="form-group col-7">
                            <select class="form-control bg-white" name="drug_name[]"><option value="{{ $drug->drug_name }}" style="width: 100%" selected>{{ $drug->drug_name }}</option></select>
                        </div>
                        <div class="form-group col-1">
                            <input type="text" name="unit_price[]" value="{{ $drug->unit_price }}" class="form-control bg-white price" readonly>
                        </div>
                        <div class="form-group col-1">
                            <input type="number" name="quantity[]" id="" min="1" step="1" value="{{ $drug->quantity }}" class="form-control quantity" required>
                        </div>
                        <div class="form-group col-2">
                            <input type="text" name="amount[]" value="{{ number_format($drug->unit_price * $drug->quantity, 2) }}" class="form-control bg-white sub_total" readonly>
                        </div>
                        <div class="form-group col-1">
                            <input type="button" class="btn btn-danger btn-sm bottn_delete" value="Del">
                        </div>
                    </div>
                @endforeach                                
            </div>
        @else
            <div class="row getTotalAmount" id="content">
                                                    
            </div>
        @endisset
        <div class="row">
            <div class="col-9">
                <input type="text" class="form-control bg-white" value="Total" style="padding: 1px; border: none; font-weight: bolder; font-size: 20px; text-align: center" readonly>
            </div>
            <div class="col-2">
                <input type="text" class="form-control bg-white total_amount" @isset($drugs) value="{{ $total_drug->amount }}" @else placeholder="0.00" @endisset style="padding: 1px; border: none; font-weight: bolder; font-size: 20px; text-align: right" readonly>
            </div>
        </div>
    </div>
    
    <hr width="103%" style="margin-left: -15px; background: #bbb">

    <div class="mt-4 mb-0">
        <div class="d-grid"><button type="submit" class="btn btn-block btn-primary">Submit</button></div>
    </div>
</form>