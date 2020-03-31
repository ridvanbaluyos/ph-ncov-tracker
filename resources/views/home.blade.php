@extends('layouts.default')
@section('title', 'Dashboard')
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        @include('partials.sidebar-toggle')
        <div class="container-fluid">
            @if (is_null($data['lastUpdate']))
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
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" target="_blank">
                        <i class="fas fa-code fa-sm text-white-50"></i> View Source
                    </a>
                </div>
                <div class="row">
                    <!-- Confirmed Cases -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-primary text-uppercase mb-1">Confirmed</div>
                                        <div class="h1 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($data['statsByCountry']['confirmed']['value'], 0, '.', ',') }}
                                        </div>
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
                                            {{ number_format($data['statsByCountry']['recovered']['value'], 0, '.', ',') }}
                                            <small>
                                                <h6>({{ round($data['statsByCountry']['recovered']['value'] / $data['statsByCountry']['confirmed']['value'] , 4) * 100}}% Recovery Rate)</h6>
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
                                        <div class="text-lg font-weight-bold text-danger text-uppercase mb-1">Died</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    {{ number_format($data['statsByCountry']['deaths']['value'], 0, '.', ',') }}
                                                    <small>
                                                        <h6>({{ round($data['statsByCountry']['deaths']['value'] / $data['statsByCountry']['confirmed']['value'] , 4) * 100}}% Mortality Rate)</h6>
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
                                        <div class="h1 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format(($data['statsByCountry']['confirmed']['value'] - ($data['statsByCountry']['deaths']['value'] - $data['statsByCountry']['recovered']['value'])), 0, '.', ',') }}
                                        </div>
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
                    <!-- Confirmed vs Active -->
                    <div class="col-xl-6 col-md-6 mb-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Daily Time Series (Confirmed vs Active)</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="daily_time_series_confirmed_active"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deaths vs Recoveries -->
                    <div class="col-xl-6 col-md-6 mb-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Daily Time Series (Deaths vs Recoveries)</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="daily_time_series_deaths_recoveries"></canvas>
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
                                <h6 class="m-0 font-weight-bold text-primary">Daily Time Series (Overall)</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="daily_time_series"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recovery vs Mortality -->
                    <div class="col-xl-6 col-md-6 mb-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Daily Time Series (Recovery vs Mortality)</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="daily_time_series_mortality_recovery"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 mb-12">
                        <small>
                            <i class="fas fa-clock fa-sm text-gray-300"></i>
                            Last update: <span class="text-danger">{{ $data['statsByCountry']['lastUpdate'] }}</span>
                        </small>
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
        @include('partials.footer')
    </div>
</div>
@endsection

@section('js-page-specific')
    @if (!is_null($data['charts']))
        <script src="/vendor/chart.js/Chart.min.js"></script>
        <script type="text/javascript">
          let dailyCountCumulative = document.getElementById('daily_time_series').getContext('2d');
          let dailyCountCumulativeChart = new Chart(dailyCountCumulative, {
            type: 'line',
            data: {
              labels: {!!   $data['charts']['dailyTimeSeriesByCountry']['labels'] !!},
              datasets: [{
                type: 'line',
                label: 'Confirmed',
                data: {!!   $data['charts']['dailyTimeSeriesByCountry']['confirmed'] !!},
                borderColor: '#4e73df',
                fill: false,
              }, {
                type: 'line',
                label: 'Active',
                data: {!!   $data['charts']['dailyTimeSeriesByCountry']['active'] !!},
                borderColor: '#f6c23e',
                fill: false,
              }, {
                type: 'line',
                label: 'Deaths',
                data: {!!   $data['charts']['dailyTimeSeriesByCountry']['deaths'] !!},
                borderColor: '#e74a3b',
                fill: false,
              }, {
                type: 'line',
                label: 'Recoveries',
                data: {!!   $data['charts']['dailyTimeSeriesByCountry']['recoveries'] !!},
                borderColor: '#1cc88a',
                fill: false,
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
                  gridLines: {
                    display: false,
                    drawBorder: false
                  },
                  ticks: {
                    maxTicksLimit: 6
                  },
                }],
                yAxes: [{
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

          let dailyTimeSeriesConfirmedActive = document.getElementById('daily_time_series_confirmed_active').getContext('2d');
          let dailyTimeSeriesConfirmedActiveChart = new Chart(dailyTimeSeriesConfirmedActive, {
            type: 'line',
            data: {
              labels: {!!   $data['charts']['dailyTimeSeriesByCountry']['labels'] !!},
              datasets: [{
                type: 'line',
                label: 'Confirmed',
                data: {!!   $data['charts']['dailyTimeSeriesByCountry']['confirmed'] !!},
                borderColor: '#4e73df',
                fill: false,
              }, {
                type: 'line',
                label: 'Active',
                data: {!!   $data['charts']['dailyTimeSeriesByCountry']['active'] !!},
                borderColor: '#f6c23e',
                fill: false,
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
                  gridLines: {
                    display: false,
                    drawBorder: false
                  },
                  ticks: {
                    maxTicksLimit: 6
                  },
                }],
                yAxes: [{
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

          let dailyTimeSeriesDeathsRecoveries = document.getElementById('daily_time_series_deaths_recoveries').getContext('2d');
          let dailyTimeSeriesDeathsRecoveriesChart = new Chart(dailyTimeSeriesDeathsRecoveries, {
            type: 'line',
            data: {
              labels: {!!   $data['charts']['dailyTimeSeriesByCountry']['labels'] !!},
              datasets: [{
                type: 'line',
                label: 'Deaths',
                data: {!!   $data['charts']['dailyTimeSeriesByCountry']['deaths'] !!},
                borderColor: '#e74a3b',
                fill: false,
              }, {
                type: 'line',
                label: 'Recoveries',
                data: {!!   $data['charts']['dailyTimeSeriesByCountry']['recoveries'] !!},
                borderColor: '#1cc88a',
                fill: false,
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
                  gridLines: {
                    display: false,
                    drawBorder: false
                  },
                  ticks: {
                    maxTicksLimit: 6
                  },
                }],
                yAxes: [{
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

          let dailyTimeSeriesRecoveryMortality = document.getElementById('daily_time_series_mortality_recovery').getContext('2d');
          let dailyTimeSeriesRecoveryMortalityChart = new Chart(dailyTimeSeriesRecoveryMortality, {
            type: 'line',
            data: {
              labels: {!!   $data['charts']['dailyTimeSeriesByCountry']['labels'] !!},
              datasets: [{
                type: 'line',
                label: 'Recovery Rate (%)',
                data: {!!   $data['charts']['dailyTimeSeriesByCountry']['recoveryRate'] !!},
                borderColor: '#1cc88a',
                fill: false,
              }, {
                type: 'line',
                label: 'Mortality Rate (%)',
                data: {!!   $data['charts']['dailyTimeSeriesByCountry']['mortalityRate'] !!},
                borderColor: '#e74a3b',
                fill: false,
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
                  gridLines: {
                    display: false,
                    drawBorder: false
                  },
                  ticks: {
                    maxTicksLimit: 6
                  },
                }],
                yAxes: [{
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
