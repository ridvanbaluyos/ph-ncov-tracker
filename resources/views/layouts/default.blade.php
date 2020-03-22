<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A website built for tracking nCov-19 information in the Philippines.">
    <meta name="author" content="Ridvan Baluyos">
    <meta name="keywords" content="covid, covid19, covid-19, ncov, ncov19, ncov-19, covid philippines, ncov philippines, corona virus, coronavirus philippines" />

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title', 'nCov-19 Tracker - Philippines')" />
    <meta property="og:description" content="A website built for tracking and visualizing nCov-19 information in the Philippines.')" />
    <meta property="og:url" content="@yield('og-url', 'https://ncov.gundamserver.com/')" />
    <meta property="og:site_name" content="nCov-19 Tracker - Philippines" />
    <meta property="og:image" content="@yield('og-image', 'https://ncov.gundamserver.com/img/undraw_social_distancing.png')" />
    <meta property="og:image:width" content="1149" />
    <meta property="og:image:height" content="938" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="A website built for tracking and visualizing nCov-19 information in the Philippines." />
    <meta name="twitter:title" content="nCov-19 Tracker - Philippines" />
    <meta name="twitter:site" content="@ridvanbaluyos" />
    <meta name="twitter:image" content="https://ncov.gundamserver.com/img/undraw_social_distancing.png" />

    <title>nCov-19 Tracker - Philippines - @yield('title', 'Home')</title>

    <link href="{{ mix('/css/all.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar Menu -->
        @include('partials.sidebar-menu')

        <!-- Page Content -->
        @yield('content')
    </div>
    <!-- Scrollback to Top -->
    @include('partials.scroll-to-top')

    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/js/sb-admin-2.min.js"></script>

    <!-- Page Specific JS -->
    @yield('js-page-specific')
</body>
</html>
