@extends('layouts.default')
@section('title', 'Data Sources')
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('partials.sidebar-toggle')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Data Sources</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_data_sources.png" alt="Data Sources">
                                </div>
                                <div class="text-left">
                                    <p>The COVID<sup>19</sup> Tracker PH uses several APIs for fetching information.</p>
                                    <p>
                                        The data extracted from these sources are believed to be reliable, no warranty, expressed or implied,
                                        is made regarding accuracy, adequacy, completeness, legality, reliability or usefulness of
                                        any information. The information is provided on an "as is" basis<sup><a href="https://infotrek.er.usgs.gov/doc/wdnr_biology/Public_Stocking/disclaimer.htm" target="_blank">[1]</a></sup>,
                                        and may not be used for commercial purposes<sup><a href="https://systems.jhu.edu/research/public-health/ncov/" target="_blank">[2]</a></sup>. </small>
                                    </p>
                                    <p>
                                        For patients database and PH statistics:
                                        <ul>
                                            <li>
                                                <a href="https://coronavirus-ph-api.now.sh" target="_blank">https://coronavirus-ph-api.now.sh</a>
                                            </li>
                                            <li>
                                                <a href="https://www.reddit.com/r/Coronavirus_PH/comments/fehzke/ph_covid19_case_database_is_now_live/" target="_blank">https://www.reddit.com/r/Coronavirus_PH/comments/fehzke/ph_covid19_case_database_is_now_live/</a>
                                            </li>
                                        </ul>
                                        For global statistics:
                                        <ul>
                                            <li><a href="https://github.com/mathdroid/covid-19-api" target="_blank">https://github.com/mathdroid/covid-19-api</a></li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('partials.footer')
            </div>
        </div>
@endsection
