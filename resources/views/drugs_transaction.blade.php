@extends('layout.app')

@section('title', 'Pharmacy | Users')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-1">Drugs Transaction</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Drugs Transaction</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Drugs Transaction List
                <button class="btn btn-sm btn-primary float-end create" value="drug_transaction" data-bs-target="#getlargeModal" data-bs-toggle="modal" title="New User">New Transaction</button>
                <form class="d-flex float-end input-group-sm" role="search">
                    <input class="form-control me-2" type="search" id="search" placeholder="Search" aria-label="Search" >
                    <button class="btn btn-sm me-2"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Receipt #</th>
                            <th>Amount</th>
                            <th>Entered By</th>
                            <th>Date/Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="employee_table">
                        @forelse ($transactions as $key => $transaction)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $transaction->receipt_no }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->user->username }}</td>
                                <td>{{ $transaction->updated_at->format('d-m-Y h:i:sa') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-secondary btn-sm" href="click_print_receipt/{{ $transaction->receipt_no }}">Print</a>
                                        <button class="btn btn-success btn-sm edit" value="{{ $transaction->id }}" data-bs-target="#getlargeModal" data-bs-toggle="modal" title="Edit Details">Edit</button>
                                        <button class="btn btn-info btn-sm view" value="{{ $transaction->id }}" data-bs-target="#getlargeModal" data-bs-toggle="modal" title="View Details">View</button>
                                        @if (Auth()->user()->user_level === "Admin")
                                            <button class="btn btn-danger btn-sm delete" value="{{ $transaction->id }}" data-bs-toggle="modal" data-bs-target="#comfirm-delete" role="button">Del</button>
                                        @endif
                                    </div>
                                </td>
                            </tr> 
                        @empty
                            <tr>
                                <td colspan="25">No Data Found</td>
                            </tr> 
                        @endforelse
                                               
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('modals.large-modal')
    @include('modals.confirm-modal')

    @push('scripts')
        <script>
            window.onload = function(){
                $('#search').focus();

            // Table filter
                $('#search').keyup(function(){  
                    search_table($(this).val());  
                });  
                function search_table(value){  
                    $('#employee_table tr').each(function(){  
                        var found = 'false';  
                        $(this).each(function(){  
                            if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0){  
                                found = 'true';  
                            }  
                        });  
                        if(found == 'true'){  
                            $(this).show();  
                        }  
                        else{  
                            $(this).hide();  
                        }  
                    });  
                }  

                $('#getlargeModal').on('shown.bs.modal', function () {

                    $('#drug_1').focus();

                    var executed = false;
                    var price = 0;

                    $("body").on("click",".addRow", function (){ //function addRow () {
                        var price = 0;
                        var drug = $('.drug').val();
                        if(drug === ''){
                            alert("Drug Input Empty!!!");
                        }else {
                            $.ajax({
                                type:'GET',
                                url:"autocomplete_drugs",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    drug
                                    },
                                success:function(data) {
                                    if(data.drug_name === 'No_data'){
                                        alert("Drug does not Exist");
                                    }else{
                                        if($('#insured').is(':checked')) {
                                            price = data.insured_price;
                                        } else {
                                            price = data.non_insured_price;
                                        }
                                    
                                        runIPDDispensary(data.drug_id, data.drug_name, price);
                                        
                                    }
                                    
                                    $('.drug').val('');
                                    $('.drug').focus();

                                }
                            });
                        }

                        executed = false;                           
                    });

                    // function for row entry
                    var runIPDDispensary = (function(drug_id, drug_name, price) {
                        
                        return function(drug_id, drug_name, price) {
                            if (!executed) {
                                executed = true;
                                document.querySelector('#content').insertAdjacentHTML(
                                    'beforeend',
                                    `<div class="row mb-2">
                                        <div class="form-group col-7">
                                            <select class="form-control bg-white" name="drug_name[]"><option value="${drug_name}" style="width: 100%" selected>${drug_name}</option></select>
                                        </div>
                                        <div class="form-group col-1">
                                            <input type="text" name="unit_price[]" value="${price}" class="form-control bg-white price" readonly>
                                        </div>
                                        <div class="form-group col-1">
                                            <input type="number" name="quantity[]" id="" min="1" step="1" placeholder="0" class="form-control quantity" required>
                                        </div>
                                        <div class="form-group col-2">
                                            <input type="text" name="amount[]" class="form-control bg-white sub_total" readonly>
                                        </div>
                                        <div class="form-group col-1">
                                            <input type="button" class="btn btn-danger btn-sm bottn_delete" value="Del">
                                        </div>
                                    </div>`      
                                );
                            }
                        };
                    })();

                    function TotalAmount(){
                        var totalAmount = 0;
                        $('.sub_total').each(function(i, e){
                            var s_total = $(this).val() - 0;
                            totalAmount += s_total;
                        });

                        $('.total_amount').val(totalAmount.toFixed(2));
                    }

                    $('.getTotalAmount').delegate('.quantity', 'keyup', function(){
                        var div = $(this).parent().parent();
                        var qty = div.find('.quantity').val() - 0;
                        var price = div.find('.price').val() - 0;
                        var total = qty * price;
                        div.find('.sub_total').val(total.toFixed(2));
                        TotalAmount();
                        //  alert(total);

                    });

                    // delete row and subtract from total amount
                    $('.getTotalAmount').delegate('.bottn_delete', 'click', function(){
                        var div = $(this).parent().parent();
                        var sub_total = div.find('.sub_total').val() - 0;
                        var total_amount = $('.total_amount').val() - 0;
                        var new_total = total_amount - sub_total;

                        $('.total_amount').val(new_total.toFixed(2));
                        //  alert(price);
                        div.remove();
                    });

                });

                $(document).on('click', '.create', function(){
                    $('.modal-title').text('New Drug Transaction');
                    
                    var createModal=$(this).val();
                    $.get('create-modal/'+createModal, function(result) {
                        
                        $(".modal-body").html(result);

                    })
                });

                $(document).on('click', '.edit', function(){
                    $('.modal-title').text('Edit Drug Transaction Details');

                    var editModal=$(this).val();
                    $.get('edit-modal/edit_drug_transaction/'+editModal, function(result) {
                        
                        $(".modal-body").html(result);
                        
                    })
                });

                $(document).on('click', '.view', function(){
                    $('.modal-title').text('View Drug Transaction Details');

                    var editModal=$(this).val();
                    $.get('view-modal/view_drug_transaction/'+editModal, function(result) {
                        
                        $(".modal-body").html(result);
                        
                    })
                });

                $(document).on('click', '.delete', function(){
                    $('.modal-title').text('Delete Confirmation');
                    
                    var id=$(this).val();
                    $.get('delete-modal/delete_drug_transaction/'+id, function(result) {
                        
                        $(".modal-body").html(result);
                        
                    })
                });

            };
            
        </script>
        
    @endpush
@endsection