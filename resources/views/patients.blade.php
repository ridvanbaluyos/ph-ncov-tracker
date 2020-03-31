@extends('layouts.default')
@section('title', 'Patients Database')
@section('content')
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        @include('partials.sidebar-toggle')
        <div class="container-fluid">
            @if (empty($data))
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
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">By Status</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <span id="byStatusRecoveredValue" style="display: none;">{{ $data['stats']['status']['recovered'] }}</span>
                                    <span id="byStatusDiedValue" style="display: none;">{{ $data['stats']['status']['died'] }}</span>
                                    <span id="byStatusAdmittedValue" style="display: none;">{{ $data['stats']['status']['admitted'] }}</span>
                                    <span id="byStatusTbaValue" style="display: none;">{{ $data['stats']['status']['tba'] }}</span>
                                    <canvas id="byStatusChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                      <i class="fas fa-circle text-warning"></i> Active
                                    </span>
                                    <span class="mr-2">
                                      <i class="fas fa-circle text-success"></i> Recovered
                                    </span>
                                    <span class="mr-2">
                                      <i class="fas fa-circle text-danger"></i> Died
                                    </span>
                                    <span class="mr-2">
                                      <i class="fas fa-circle" style="color: #dfdfdf;"></i> TBA
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">By Sex</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <span id="bySexMaleValue" style="display: none;">{{ $data['stats']['sexes']['M'] }}</span>
                                    <span id="bySexFemaleValue" style="display: none;">{{ $data['stats']['sexes']['F'] }}</span>
                                    <span id="bySexTbaValue" style="display: none;">{{ isset($data['stats']['sexes']['TBA']) ? $data['stats']['sexes']['TBA'] : 0 }}</span>
                                    <canvas id="bySexChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                      <i class="fas fa-circle" style="color: #007DD9"></i> Male
                                    </span>
                                    <span class="mr-2">
                                      <i class="fas fa-circle" style="color: #F964A3"></i> Female
                                    </span>
                                    <span class="mr-2">
                                      <i class="fas fa-circle" style="color: #dfdfdf"></i> TBA
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">By Age</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <span id="byAge0Value" style="display: none;">{{ $data['stats']['ages']['~17'] }}</span>
                                    <span id="byAge1Value" style="display: none;">{{ $data['stats']['ages']['18-30'] }}</span>
                                    <span id="byAge2Value" style="display: none;">{{ $data['stats']['ages']['31-45'] }}</span>
                                    <span id="byAge3Value" style="display: none;">{{ $data['stats']['ages']['46-60'] }}</span>
                                    <span id="byAge4Value" style="display: none;">{{ $data['stats']['ages']['61~'] }}</span>
                                    <span id="byAgeTbaValue" style="display: none;">{{ isset($data['stats']['ages']['tba']) ? $data['stats']['ages']['tba'] : 0 }}</span>
                                    <canvas id="byAgeGender"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 mb-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Daily Count (Cumulative) of Confirmed Cases</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="dailyCountCumulative"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 mb-12">
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 mb-12">
                        <p>
                            <small>
                                <i class="fas fa-stopwatch fa-sm text-gray-300"></i>
                                Syncs every: <span class="text-danger">30 minutes</span> from source.
                            </small>
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('partials.footer')
@endsection

@section('js-page-specific')
    @if (!empty($data))
        <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="/vendor/chart.js/Chart.min.js"></script>
        <script src="/js/datatables.js"></script>
        <script type="text/javascript">
          // By Status Chart
          let byStatus = document.getElementById('byStatusChart');
          let byStatusChart = new Chart(byStatus, {
            type: 'pie',
            data: {
              labels: ['Active', 'Recovered', 'Died', 'TBA'],
              datasets: [{
                data: [
                  $('#byStatusAdmittedValue')[0].innerHTML,
                  $('#byStatusRecoveredValue')[0].innerHTML,
                  $('#byStatusDiedValue')[0].innerHTML,
                  $('#byStatusTbaValue')[0].innerHTML,
                ],
                backgroundColor: ['rgba(246, 194, 62)', 'rgb(28, 200, 138)', 'rgb(231, 74, 59)', '#dfdfdf'],
                hoverBorderColor: 'rgba(234, 236, 244, 1)',
              }],
            },
            options: {
              maintainAspectRatio: false,
              tooltips: {
                backgroundColor: 'rgb(255,255,255)',
                bodyFontColor: '#858796',
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
              },
              legend: {
                display: false
              },
            },
          });

          // By Sex Chart
          let bySex = document.getElementById('bySexChart');
          let bySexChart = new Chart(bySex, {
            type: 'pie',
            data: {
              labels: ['Male', 'Female', 'TBA'],
              datasets: [{
                data: [
                  $('#bySexMaleValue')[0].innerHTML,
                  $('#bySexFemaleValue')[0].innerHTML,
                  $('#bySexTbaValue')[0].innerHTML,
                ],
                backgroundColor: ['#007DD9', '#F964A3', '#dfdfdf'],
                hoverBorderColor: 'rgba(234, 236, 244, 1)',
              }],
            },
            options: {
              maintainAspectRatio: false,
              tooltips: {
                backgroundColor: 'rgb(255,255,255)',
                bodyFontColor: '#858796',
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
              },
              legend: {
                display: false
              },
            },
          });

          let byAgeGender = document.getElementById('byAgeGender').getContext('2d');
          let byAgeGenderGraph = new Chart(byAgeGender, {
            type: 'bar',
            data: {
              labels: {!!   $data['charts']['chartAgeGender']['labels'] !!},
              datasets: [{
                type: 'bar',
                label: 'Male',
                backgroundColor: '#007DD9',
                data: {!!   $data['charts']['chartAgeGender']['maleData'] !!},
              }, {
                type: 'bar',
                label: 'Female',
                backgroundColor: '#F964A3',
                data: {!!   $data['charts']['chartAgeGender']['femaleData'] !!},
              }, {
                type: 'bar',
                label: 'TBA',
                backgroundColor: '#DFDFDF',
                data: {!!   $data['charts']['chartAgeGender']['tbaData'] !!},
              }]
            },
            options: {
              maintainAspectRatio: false,
              layout: {
                padding: {
                  left: 10,
                  right: 25,
                  top: 25,
                  bottom: 0
                }
              },
              scales: {
                xAxes: [{
                  stacked: true,
                  gridLines: {
                    display: false,
                    drawBorder: false
                  },
                  ticks: {
                    maxTicksLimit: 6
                  },
                }],
                yAxes: [{
                  stacked: true,
                  ticks: {
                    min: 0,
                    maxTicksLimit: 15,
                    padding: 10,
                  },
                  gridLines: {
                    color: 'rgb(234, 236, 244)',
                    zeroLineColor: 'rgb(234, 236, 244)',
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                  }
                }]
              }
            }
          });

          let dailyCountCumulative = document.getElementById('dailyCountCumulative').getContext('2d');
          let dailyCountCumulativeChart = new Chart(dailyCountCumulative, {
            type: 'bar',
            data: {
              labels: {!!   $data['charts']['chartCasesDates']['labels'] !!},
              datasets: [{
                type: 'line',
                label: 'Cumulative',
                data: {!!   $data['charts']['chartCasesDates']['cumulative'] !!},
                borderColor: 'black',
              }, {
                type: 'bar',
                label: 'Confirmed Cases',
                backgroundColor: '#f964a3',
                data: {!!   $data['charts']['chartCasesDates']['dates'] !!},
              }]
            },
            options: {
              maintainAspectRatio: false,
              responsive: true,
              layout: {
                padding: {
                  left: 10,
                  right: 25,
                  top: 25,
                  bottom: 0
                }
              },
              scales: {
                xAxes: [{
                  stacked: true,
                  gridLines: {
                    display: false,
                    drawBorder: false
                  },
                  ticks: {
                    maxTicksLimit: 6
                  },
                }],
                yAxes: [{
                  stacked: true,
                  ticks: {
                    min: 0,
                    maxTicksLimit: 15,
                    padding: 10,
                  },
                  gridLines: {
                    color: 'rgb(234, 236, 244)',
                    zeroLineColor: 'rgb(234, 236, 244)',
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                  }
                }]
              }
            }
            });
        </script>
    @endif
@endsection
