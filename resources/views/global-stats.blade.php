@extends('layouts.default')
@section('title', 'Global Statistics')
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('partials.sidebar-toggle')
            <div class="container-fluid">
                @if (empty($data['global']))
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
                                            <div class="h1 mb-0 font-weight-bold text-gray-800">
                                                {{ number_format($data['global']['confirmed']['value'], 0, '.', ',') }}
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
                                                {{ number_format($data['global']['recovered']['value'], 0, '.', ',') }}
                                                <small>
                                                    <h6>({{ round($data['global']['recovered']['value'] / $data['global']['confirmed']['value'] , 4) * 100}}% Recovery Rate)</h6>
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
                                                        {{ number_format($data['global']['deaths']['value'], 0, '.', ',') }}
                                                        <small>
                                                            <h6>({{ round($data['global']['deaths']['value'] / $data['global']['confirmed']['value'] , 4) * 100}}% Mortality Rate)</h6>
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
                                                {{ number_format(
                                                    ($data['global']['confirmed']['value'] - ($data['global']['recovered']['value'] + $data['global']['deaths']['value'])),
                                                    0,
                                                    '.',
                                                    ','
                                                    )
                                                }}
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
                        <div class="col-lg-3 mb-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Regions</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Country/Region</th>
                                            <th scope="col">Count</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data['top_countries']['confirmed'] as $country)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ $country['combinedKey'] }}</td>
                                                <td>
                                                    {{ number_format($country['confirmed'], 0, '.', ',') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Regions</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Country/Region</th>
                                            <th scope="col">Count</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data['top_countries']['recoveries'] as $country)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ $country['combinedKey'] }}</td>
                                                <td>
                                                    {{ number_format($country['recovered'], 0, '.', ',') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Regions</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Country/Region</th>
                                            <th scope="col">Count</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data['top_countries']['deaths'] as $country)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ $country['combinedKey'] }}</td>
                                                <td>
                                                    {{ number_format($country['deaths'], 0, '.', ',') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Daily Cumulative -->
                        <div class="col-xl-12 col-md-12 mb-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Daily Time Series</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar">
                                        <canvas id="daily_time_series"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card bg-secondary text-white shadow">
                                <div class="card-body">
                                    Last Updated:
                                    <div class="text-white-50 small">
                                        <ul>
                                            <li>{{ $data['global']['lastUpdate'] }}</li>
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
                                            <li><a href="https://covid19.mathdro.id/api" target="_blank"style="text-decoration: none; color: black;">Serving data from John Hopkins University CSSE as a JSON API</a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-12">
                            <small>
                                <i class="fas fa-clock fa-sm text-gray-300"></i>
                                Last update from source: <span class="text-danger">{{ $data['global']['lastUpdate'] }}</span>
                            </small>
                            <p>
                                <small>
                                    <i class="fas fa-stopwatch fa-sm text-gray-300"></i>
                                    Syncs every <span class="text-danger">30 minutes</span> from:
                                    <span><a href="https://covid19.mathdro.id/api" target="_blank">https://covid19.mathdro.id/api</a></span>
                                </small>
                            </p>
                        </div>
                    </div>
                @endif
            </div>
            @include('partials.footer')
        </div>
@endsection



@section('js-page-specific')
    @if (!is_null($data['charts']))
        <script src="/vendor/chart.js/Chart.min.js"></script>
        <script type="text/javascript">
        </script>
    @endif
@endsection
