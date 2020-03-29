@extends('layouts.default')
@section('title', 'About')
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('partials.sidebar-toggle')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Be an Ambassador!</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 50rem;" src="img/mbru_ambassador.png" alt="">
                                </div>
                                <div class="text-left">
                                    <p>I am now an <a href="https://twitter.com/hashtag/MBRUCommunityImmunity?src=hashtag_click" target="_blank">#MBRUCommunityImmunity</a> Ambassador.</p>
                                    <p>
                                        I am responsible to protect myself and my community from COVID-19.
                                    </p>
                                    <p>
                                        I challenge you to take the course: <a href="https://learn.mbru.ac.ae/courses/covid19" target="_blank">https://learn.mbru.ac.ae/courses/covid19</a>
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
