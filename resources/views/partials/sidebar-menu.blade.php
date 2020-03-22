<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-biohazard"></i>
        </div>
        <div class="sidebar-brand-text mx-3">COVID<sup>19</sup> Tracker PH</div>
    </a>

    <hr class="sidebar-divider">

    <li @if (Request::is('/')) class="nav-item active" @else class="nav-item" @endif>
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span>
        </a>
    </li>

    <li @if (Request::is('patient-database')) class="nav-item active" @else class="nav-item" @endif>
        <a class="nav-link" href="/patient-database">
            <i class="fas fa-fw fa-table"></i>
            <span>Patient Database</span>
        </a>
    </li>

    <li @if (Request::is('global-stats')) class="nav-item active" @else class="nav-item" @endif>
        <a class="nav-link" href="/global-stats">
            <i class="fas fa-fw fa-globe"></i>
            <span>Global Stats</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <li @if (Request::is('data-sources')) class="nav-item active" @else class="nav-item" @endif>
        <a class="nav-link" href="/data-sources">
            <i class="fas fa-fw fa-database"></i>
            <span>Data Sources</span>
        </a>
    </li>

    <li @if (Request::is('credits')) class="nav-item active" @else class="nav-item" @endif>
        <a class="nav-link" href="/credits">
            <i class="fas fa-fw fa-thumbs-up"></i>
            <span>Credits</span>
        </a>
    </li>

    <li @if (Request::is('about')) class="nav-item active" @else class="nav-item" @endif>
        <a class="nav-link" href="/about">
            <i class="fas fa-fw fa-cat"></i>
            <span>About</span>
        </a>
    </li>
</ul>
