@extends('layout.app')

@section('title', 'Pharmacy | Users')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-1">Drugs Payments</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Drugs Bills</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Drugs Transaction List
                {{-- <button class="btn btn-sm btn-primary float-end create" value="drug_transaction" data-bs-target="#getlargeModal" data-bs-toggle="modal" title="New User">New Transaction</button> --}}
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
                                        <a class="btn btn-secondary btn-sm" href="click_print_receipt_2/{{ $transaction->receipt_no }}">Print</a>
                                        <button class="btn btn-info btn-sm view" value="{{ $transaction->id }}" data-bs-target="#getlargeModal" data-bs-toggle="modal" title="View Details">View</button>
                                        <button class="btn btn-success btn-sm refund" value="{{ $transaction->receipt_no }}" data-bs-toggle="modal" data-bs-target="#comfirm-delete" role="button">Refund</button>
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

                $(document).on('click', '.view', function(){
                    $('.modal-title').text('View Drug Transaction Details');

                    var editModal=$(this).val();
                    $.get('view-modal/view_drug_transaction/'+editModal, function(result) {
                        
                        $(".modal-body").html(result);
                        
                    })
                });

                $(document).on('click', '.refund', function(){
                    $('.modal-title').text('Refund Confirmation');
                    
                    var receipt_no=$(this).val();
                    $.get('payment-modal/refund_bill/'+receipt_no, function(result) {
                        
                        $(".modal-body").html(result);
                        
                    })
                });

            };
            
        </script>
        
    @endpush
@endsection