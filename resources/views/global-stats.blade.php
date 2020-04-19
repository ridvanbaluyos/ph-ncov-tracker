@extends('layouts.default')
@section('title', 'Global Statistics')
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('partials.sidebar-toggle')
            <div class="container-fluid">
                @if (empty($data['stats']['world']))
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
                        <h1 class="h3 mb-0 text-gray-800">Global Statistics</h1>
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
                                                {{ number_format($data['stats']['world']['confirmed'], 0, '.', ',') }}
                                                <small>
                                                    <h6 class="text-primary">(+{{ number_format($data['stats']['world']['todayCases'], 0, '.', ',') }})</h6>
                                                </small>
                                                <small>
                                                    <h6>
                                                        <i class="fas fa-street-view fa-sm"></i>
                                                        <span class="text-info">{{ number_format($data['stats']['world']['casesPerOneMillion'], 0, '.', ',') }}</span> cases per 1 million
                                                    </h6>
                                                </small>
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
                                                {{ number_format($data['stats']['world']['recovered'], 0, '.', ',') }}
                                                    <h6>
                                                        <i class="fas fa-book-medical fa-sm"></i>
                                                        <span class="text-info">{{ round($data['stats']['world']['recovered'] / $data['stats']['world']['confirmed'] , 4) * 100}}%</span> recovery rate
                                                    </h6>
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
                                                        {{ number_format($data['stats']['world']['deaths'], 0, '.', ',') }}
                                                        <small>
                                                            <h6 class="text-danger">
                                                                (+{{ number_format($data['stats']['world']['todayDeaths'], 0, '.', ',') }})
                                                            </h6>
                                                        </small>
                                                        <small>
                                                            <h6>
                                                                <i class="fas fa-book-dead fa-sm"></i>
                                                                <span class="text-info">{{ round($data['stats']['world']['deaths'] / $data['stats']['world']['confirmed'], 4) * 100}}%</span> mortality rate
                                                            </h6>
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
                                                {{ number_format($data['stats']['world']['active'], 0, '.', ',') }}
                                                <h6>
                                                    <i class="fas fa-procedures dfa-sm"></i>
                                                    <span class="text-info">{{ number_format($data['stats']['world']['critical'], 0, '.', ',') }}</span> critical condition
                                                </h6>
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
                        <div class="col-lg-12 mb-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Country Statistics</h6>
                                </div>
                                <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table hover" id="countryRankingsTable" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">Rank</th>
                                            <th scope="col" class="text-center">Country/Region</th>
                                            <th scope="col" class="text-right">Total Cases</th>
                                            <th scope="col" class="text-right">New Cases</th>
                                            <th scope="col" class="text-right">Total Deaths</th>
                                            <th scope="col" class="text-right">New Deaths</th>
                                            <th scope="col" class="text-right">Recovered</th>
                                            <th scope="col" class="text-right">Active</th>
                                            <th scope="col" class="text-right">Critical</th>
                                            <th scope="col" class="text-right">Cases/1M</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data['stats']['countries'] as $country)
                                            <tr>
                                                <th class="text-center">{{ $loop->iteration }}</th>
                                                <td>
                                                    <img class="img-responsive" style="max-width: 25px;" src="{{ $country['countryInfo']['flag'] }}" alt="{{ $country['country'] }}" />
                                                    {{ $country['country'] }} ({{ $country['countryCode'] ?? '' }}) </td>
                                                <td class="text-right text-primary">
                                                    {{ number_format($country['confirmed'], 0, '.', ',') }}
                                                </td>
                                                <td class="text-right">
                                                    @if ($country['todayCases'] > 0)
                                                        <span class="text-info">+{{ number_format($country['todayCases'], 0, '.', ',') }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-right text-danger">
                                                    {{ number_format($country['deaths'], 0, '.', ',') }}</td>

                                                <td class="text-right">
                                                    @if ($country['todayDeaths'] > 0)
                                                        <span class="text-info">+{{ number_format($country['todayDeaths'], 0, '.', ',') }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-right text-success">{{ number_format($country['recovered'], 0, '.', ',') }}</td>
                                                <td class="text-right text-warning">{{ number_format($country['active'], 0, '.', ',') }}</td>
                                                <td class="text-right">{{ number_format($country['critical'], 0, '.', ',') }}</td>
                                                <td class="text-right">{{ number_format($country['casesPerOneMillion'], 0, '.', ',') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!--
                    <div class="row">
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
                    -->
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
            @include('partials.footer')
        </div>
@endsection

@section('js-page-specific')
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
      // Call the dataTables jQuery plugin
      $(document).ready(function() {
        let table = $('#countryRankingsTable').DataTable({
          'lengthMenu': [
            [50, 100, 200, -1],
            [50, 100, 200, 'All']
          ]
        });
      });
    </script>

@endsection