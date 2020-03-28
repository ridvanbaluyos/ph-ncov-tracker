@extends('layouts.default')
@section('title', 'Dashboard')
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('partials.sidebar-toggle')
        <div class="container-fluid">
            @if (is_null($data['stats']))
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
                <div class="row">
                    <!-- Confirmed Cases -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Confirmed</div>
                                        <div class="h1 mb-0 font-weight-bold text-gray-800">{{ $data['stats']['status']['confirmed'] }}</div>
                                        <small>
                                            <h6>
                                                (+{{ $data['stats']['dates'][date('Y-m-d', strtotime('- 1 day'))] }} cases)
                                            </h6>
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recovered -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-success text-uppercase mb-1">Recovered</div>
                                        <div class="h1 mb-0 font-weight-bold text-gray-800">
                                            {{ $data['stats']['status']['recovered'] }}
                                            <small>
                                                <h6>({{ round($data['stats']['status']['recovered'] / $data['stats']['status']['confirmed'] , 4) * 100}}% Recovery Rate)</h6>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deaths -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-danger text-uppercase mb-1">Died</small></div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    {{ $data['stats']['status']['died'] }}
                                                    <small>
                                                        <h6>({{ round($data['stats']['status']['died'] / $data['stats']['status']['confirmed'] , 4) * 100}}% Mortality Rate)</h6>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-minus fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-warning text-uppercase mb-1">Active</div>
                                        <div class="h1 mb-0 font-weight-bold text-gray-800">{{ $data['stats']['status']['admitted'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-clock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- By Status -->
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

                    <!-- By Sex -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">By Sex</h6>
                            </div>
                            <!-- Card Body -->
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

                    <!-- By Age -->
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
                                    <canvas id="by_age_graph"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Daily Cumulative -->
                    <div class="col-xl-6 col-md-6 mb-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Daily Count (Cumulative) of Confirmed Cases</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="daily_count_cumulative"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Deaths and Recoveries -->
                    <div class="col-xl-6 col-md-6 mb-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Daily Count (Cumulative) of Deaths and Recoveries</h6>
                            </div>
                            <div class="card-body">
{{--                                <div class="chart-bar">--}}
{{--                                    <canvas id="daily_count_deaths_recoveries"></canvas>--}}
{{--                                </div>--}}
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_under_construction.png" alt="" />
                                    <h4>This information is still under development.</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-secondary text-white shadow">
                            <div class="card-body">
                                Compare data with:
                                <div class="text-white-50 small">
                                    <ul>
                                        <li><a href="https://ncovtracker.doh.gov.ph" target="_blank"style="text-decoration: none; color: black;">Department of Health, Philippines</a></li>
                                        <li><a href="https://coronavirus.jhu.edu/map.html" target="_blank"style="text-decoration: none; color: black;">John Hopkins University & Medicine</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-secondary text-white shadow">
                            <div class="card-body">
                                Data Source:
                                <div class="text-white-50 small">
                                    <ul>
                                        <li><a href="https://coronavirus-ph-api.now.sh" target="_blank"style="text-decoration: none; color: black;">coronavirus-ph (API)</a></li>
                                        <li><a href="https://www.reddit.com/r/Coronavirus_PH/comments/fehzke/ph_covid19_case_database_is_now_live" target="_blank"style="text-decoration: none; color: black;">https://www.reddit.com/r/Coronavirus_PH</a></li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
        </div>
        @include('partials.footer')
    </div>
</div>
@endsection

@section('js-page-specific')
    <script src="/vendor/chart.js/Chart.min.js"></script>
    <script src="/js/charts.js"></script>
    <script type="text/javascript">
        let byAgeGender = document.getElementById('by_age_graph').getContext('2d');
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
                  max: 300,
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

        let dailyCountCumulative = document.getElementById('daily_count_cumulative').getContext('2d');
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
                  max: 1200,
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

@endsection
