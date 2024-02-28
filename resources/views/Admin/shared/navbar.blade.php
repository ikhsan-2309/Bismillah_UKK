<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="navbar-brand-wrapper d-flex justify-content-center">
    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
      <a class="navbar-brand brand-logo" href="index.html"><img src="../../images/logo.svg" alt="logo" /></a>
      <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../../images/logo-mini.svg" alt="logo" /></a>
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="typcn typcn-th-menu"></span>
      </button>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <ul class="navbar-nav mr-lg-2">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link" href="#" data-bs-toggle="dropdown" id="profileDropdown">
          <img src="../../images/faces/face5.jpg" alt="profile" />
          <span class="nav-profile-name">{{ Auth()->user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item">
            <i class="typcn typcn-cog-outline text-primary"></i>
            Settings
          </a>
          <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button class="dropdown-item" @click.prevent="$root.submit();">
              <i class="typcn typcn-eject text-primary"></i>
              {{ __('Log Out') }}
            </button>
          </form>

        </div>
      </li>
      <li class="nav-item nav-user-status dropdown">
        @php
          switch (Auth::user()->role) {
              case 0:
                  $roleText = 'Cashier';
                  break;
              case 1:
                  $roleText = 'Admin';
                  break;
              case 2:
                  $roleText = 'Manager';
                  break;
              default:
                  $roleText = 'Unknown Role';
          }
        @endphp
        <p class="mb-0">You are logged in as a {{ $roleText }}</p>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-date dropdown">
        <a class="nav-link d-flex justify-content-center align-items-center" href="javascript:;">
          <i class="typcn typcn-calendar"></i>
          <h6 class="date mb-0">@php echo Carbon\Carbon::now()->format('l, d F Y') @endphp</h6>
        </a>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-toggle="offcanvas">
      <span class="typcn typcn-th-menu"></span>
    </button>
  </div>
</nav>
