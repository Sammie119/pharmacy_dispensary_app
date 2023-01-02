@extends('layout.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-1">Report</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Report</li>
        </ol>
        <div class="row">
            <section class="content">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="float-left">Report</h5>
                                </div>
                                <div class="card-body" style="margin: 1rem 8rem 2rem 8rem">
                                    <form action="{{ route('get_report') }}" method="POST" autocomplete="off">
                                        @csrf
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="recipient-name" class="control-label">Report Type:</label>
                                                <select name="report_type" id="report_type" class="form-control form-control-border" required>
                                                    <option value="" selected disabled>Select Report Type</option>
                                                    <option value="users">Users Income Report</option>
                                                    <option value="drugs">Drugs Income Report</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="recipient-name" class="control-label">Reporting Date From:</label>
                                                <input type="date" max="{{ date('Y-m-d') }}" name="report_from" id="report_from" class="form-control form-control-border" required>
                                            </div>
                                            <div class="col-4">
                                                <label for="recipient-name" class="control-label">Reporting Date To:</label>
                                                <input type="date" max="{{ date('Y-m-d') }}" name="report_to" id="report_to" class="form-control form-control-border" required>
                                            </div>
                                        </div>
        
                                        <div class="row mt-4">
                                            <button type="submit" style="margin-left: auto;" class="btn btn-primary float-right load">Submit</button>
                                        </div>
                                    </form>
                                    <div class="d-flex justify-content-center">
                                        <ul class="list-group list-group-flush" id="gif_load" style="display: none">
                                            <li class="list-group-item d-flex justify-content-center"><img src="{{ asset('public/assets/images/loading.gif') }}" id="gif_load" height="100px" alt="Loading"></li>
                                            <li class="list-group-item d-flex justify-content-center"><h4 style="font-weight: bolder;" id="lab">Report Loading....</h4></li>
                                            <li class="list-group-item d-flex justify-content-center"><small style="font-weight: bolder;" id="lab">This will take about 5 minutes</small></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
    </div>
@endsection

@push('scripts')
    <script>
        $('.load').click(function () {
            if(document.getElementById('report_from').value == '' && document.getElementById('report_to').value == '' && document.getElementById('report_type').value == ''){
                document.getElementById('gif_load').style.display = 'none';
            }
            else{
                document.getElementById('gif_load').style.display = 'block';
            }
        });
    </script>
@endpush


