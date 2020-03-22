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
                                <h6 class="m-0 font-weight-bold text-primary">About</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_welcome_cats.png" alt="">
                                </div>
                                <div class="text-left">
                                    <p>The nCov<sup>19</sup> Tracker PH is a side-project by <a href="https://ridvanbaluyos.com" target="_blank">Ridvan Baluyos</a>.</p>
                                    <p>
                                        So what makes this one unique from other trackers? Nothing really. I use the same data
                                        source as everyone else. If you think this website can help you visualize the situation,
                                        then it has served its purpose. This website is under the <a href="https://opensource.org/licenses/MIT" target="_blank">MIT License</a>.
                                    </p>
                                    <p>
                                        For any inconsistencies, please feel free to <a href="mailto:ridvan@baluyos.net">contact me</a>.
                                    </p>
                                    <p>
                                        Stay safe and healthy, my friends!
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
