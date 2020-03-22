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
                                                        <h6>({{ round($data['stats']['status']['died'] / $data['stats']['status']['confirmed'] , 4) * 100}}% Mortaility Rate)</h6>
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
                                        <div class="text-lg font-weight-bold text-warning text-uppercase mb-1">Admitted</div>
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
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">By Status</h6>
                            </div>
                            <!-- Card Body -->
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
                                      <i class="fas fa-circle text-warning"></i> Admitted
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
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">By Sex</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <span id="bySexMaleValue" style="display: none;">{{ $data['stats']['sexes']['M'] }}</span>
                                    <span id="bySexFemaleValue" style="display: none;">{{ $data['stats']['sexes']['F'] }}</span>
                                    <span id="bySexTbaValue" style="display: none;">{{ isset($data['stats']['sexes']['TBA']) ?? 0 }}</span>
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
                                    <span id="byAgeTbaValue" style="display: none;">{{ isset($data['stats']['ages']['tba']) ?? 0 }}</span>
                                    <canvas id="byAgeChart"></canvas>
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
                                        <li><a href="https://ncovtracker.doh.gov.ph" target="_blank"style="text-decoration: none; color: black;">https://ncovtracker.doh.gov.ph</a></li>
                                        <li><a href="https://covid19.mathdro.id/api/countries/PH/og" target="_blank"style="text-decoration: none; color: black;">https://covid19.mathdro.id/api/countries/PH/og</a></li>
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
                                        <li><a href="https://coronavirus-ph-api.now.sh" target="_blank"style="text-decoration: none; color: black;">https://coronavirus-ph-api.now.sh</a></li>
                                        <li><a href="https://www.reddit.com/r/Coronavirus_PH/comments/fehzke/ph_covid19_case_database_is_now_live" target="_blank"style="text-decoration: none; color: black;">https://www.reddit.com/r/Coronavirus_PH/comments/fehzke/ph_covid19_case_database_is_now_live/</a></li>
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
@endsection
