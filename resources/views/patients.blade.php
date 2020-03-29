@extends('layouts.default')
@section('title', 'Patients Database')
@section('content')
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        @include('partials.sidebar-toggle')
        <div class="container-fluid">
            @if (is_null($data['patients']))
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Server Unavailable</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_server_down.png" alt="">
                                </div>
                                <p>There seems to be some problem with the data source. </p>
                                <p>Please visit the <a href="https://ncovtracker.doh.gov.ph/">Department of Health</a> website.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Patient Database</h1>
                    <a href="https://docs.google.com/spreadsheets/d/1wdxIwD0b58znX4UrH6JJh_0IhnZP0YWn23Uqs7lHB6Q/edit?usp=sharing" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" target="_blank">
                        <i class="fas fa-eye fa-sm text-white-50"></i> View Spreadsheet
                    </a>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cases in the Philippines</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Status</label>
                                <div id="filterByStatus"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Nationality</label>
                                <div id="filterByNationality"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Sex</label>
                                <div id="filterBySex"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Travel History</label>
                                <div id="filterByTravelHistory"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Hospital</label>
                                <div id="filterByHospital"></div>
                            </div>
                        </div>
                        <hr />
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Case</th>
                                    <th>Date</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Nationality</th>
                                    <th>Hospital</th>
                                    <th>Travel History</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Case</th>
                                    <th>Date</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Nationality</th>
                                    <th>Hospital</th>
                                    <th>Travel History</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($data['patients'] as $patient)
                                        <tr>
                                            <td>PH{{ $patient['case'] }}</td>
                                            <td>{{ $patient['date'] }}</td>
                                            <td>{{ $patient['age'] }}</td>
                                            <td>{{ $patient['sex'] }}</td>
                                            <td>{{ $patient['nationality'] }}</td>
                                            <td>{{ $patient['hospital'] }}</td>
                                            <td>{{ $patient['travel_history'] }}</td>
                                            <td>{{ $patient['status'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 mb-12">
                        <small>
                            <i class="fas fa-stopwatch fa-sm text-gray-300"></i>
                            Syncs every <span class="text-danger">30 minutes</span> from:
                            <a href="https://coronavirus-ph-api.now.sh/cases" target="_blank">https://coronavirus-ph-api.now.sh/cases</a>
                        </small>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('partials.footer')
@endsection

@section('js-page-specific')
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="/js/datatables.js"></script>
@endsection
