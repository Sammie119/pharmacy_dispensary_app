@extends('layout.app')

<style>
    .tetx-head {
        margin: auto;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .footer-number {
        margin: auto;
        font-size: 1.2rem;
    }
</style>

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-1">Pharmacy System Dashboard</h1>
        <ol class="breadcrumb mb-4">
            
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body tetx-head">Total Users</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <label class="footer-number">{{ $results['t_users'] }}</label>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body tetx-head">Total Drugs</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <label class="footer-number">{{ $results['t_drugs'] }}</label>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body tetx-head">Income For {{ Date('F, Y', strtotime(date('d-m-Y'))) }}</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <label class="footer-number">{{ number_format($results['i_month'], 2) }}</label>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body tetx-head">Income For Today ({{ Date('D', strtotime(date('d-m-Y'))) }})</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <label class="footer-number">{{ number_format($results['i_today'], 2) }}</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <label style="font-size: 1.4rem; font-weight: bold">Users List</label> 

                {{-- <input class="form-control float-end" type="text" id="search" style="height: 32px; width: 300px"> --}}
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody id="employee_table">
                        @forelse ($results['users'] as $key => $user)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->user_level }}</td>
                                <td>{{ $user->username }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="40">No data Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{-- <script>
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

    };
</script> --}}
