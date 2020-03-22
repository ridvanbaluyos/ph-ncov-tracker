@extends('layouts.default')
@section('title', 'Credits')
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('partials.sidebar-toggle')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Credits</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_technology_stack.png" alt="">
                                </div>
                                <div class="text-left">
                                    This website is made with the ff. technology stack:
                                    <ul>
                                        <li>
                                            <a href="https://laravel.com/" target="_blank">Laravel</a>
                                        </li>
                                        <li>
                                            <a href="https://getbootstrap.com/" target="_blank">Bootstrap</a>
                                        </li>
                                        <li>
                                            <a href="https://fontawesome.com" target="_blank">Font Awesome</a>
                                        </li>
                                        <li>
                                            <a href="https://www.chartjs.org" target="_blank">Chart.js</a>
                                        </li>
                                        <li>
                                            <a href="https://undraw.co" target="_blank">unDraw</a>
                                        </li>
                                        <li>
                                            <a href="https://mycolor.space/" target="_blank">ColorSpace</a>
                                        </li>
                                        <li>
                                            <a href="https://www.digitalocean.com/" target="_blank">Digital Ocean</a>
                                        </li>
                                        <li>
                                            <a href="https://www.cloudflare.com/" target="_blank">Cloudflare</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('partials.footer')
            </div>
        </div>
@endsection
