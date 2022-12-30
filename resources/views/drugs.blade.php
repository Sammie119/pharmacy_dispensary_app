@extends('layout.app')

@section('title', 'Pharmacy | Users')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-1">Drugs</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Drugs</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Drugs List
                <button class="btn btn-sm btn-primary float-end create" value="new_drug" data-bs-target="#getModal" data-bs-toggle="modal" title="New User">Add Drug</button>
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
                            <th>Description</th>
                            <th>Insurance Price</th>
                            <th>Non-Insurance Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="employee_table">
                        @forelse ($drugs as $key => $drug)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $drug->description }}</td>
                                <td>{{ $drug->insurance_price }}</td>
                                <td>{{ $drug->non_insurance_price }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-success btn-sm edit" value="{{ $drug->id }}" data-bs-target="#getModal" data-bs-toggle="modal" title="Edit Details">Edit</button>
                                        <button class="btn btn-danger btn-sm delete" value="{{ $drug->id }}" data-bs-toggle="modal" data-bs-target="#comfirm-delete" role="button">Del</button>
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
    @include('modals.medium-modal')
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

                $('#editModal').on('shown.bs.modal', function () {

                });

                $(document).on('click', '.create', function(){
                    $('.modal-title').text('Add New Drug');
                    
                    var createModal=$(this).val();
                    $.get('create-modal/'+createModal, function(result) {
                        
                        $(".modal-body").html(result);

                    })
                });

                $(document).on('click', '.edit', function(){
                    $('.modal-title').text('Edit Drug Details');

                    var editModal=$(this).val();
                    $.get('edit-modal/edit_drug/'+editModal, function(result) {
                        
                        $(".modal-body").html(result);
                        
                    })
                });

                $(document).on('click', '.delete', function(){
                    $('.modal-title').text('Delete Confirmation');
                    
                    var id=$(this).val();
                    $.get('delete-modal/delete_drug/'+id, function(result) {
                        
                        $(".modal-body").html(result);
                        
                    })
                });

            };
            
        </script>
        
    @endpush
@endsection