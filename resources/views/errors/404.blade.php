@extends('layouts.default')
@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('partials.sidebar-toggle')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Page Not Found</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_not_found.png" alt="">
                                </div>
                                <a href="/">&larr; Back to Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            @include('partials.footer')
        </div>
    </div>
@endsection
