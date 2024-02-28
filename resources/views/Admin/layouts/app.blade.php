<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laraten - Admin</title>
  @include('Admin.shared.css')
  @stack('css')
  <!-- base:css -->
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include('admin.shared.navbar')
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close typcn typcn-times"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-light-theme">
            <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
          </div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme">
            <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
          </div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      @include('Admin.shared.sidebar')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="d-flex justify-content-between mb-3">
            <h5 class="mb-0 text-titlecase">{{ $page_title }}</h5>
            <ul class="navbar-nav mr-lg-2">
              <li class="nav-item">
                <div class="d-flex align-items-baseline">
                  @foreach ($breadcrumb_items as $item)
                    @if ($loop->last)
                      <p class="mb-0">{{ $item['label'] }}</p>
                    @else
                      <a class="mb-0 text-decoration-none" style="color: #844fc1;"
                        href="{{ route($item['link']) }}">{{ $item['label'] }}</a>
                      <i class="typcn typcn-chevron-right"></i>
                    @endif
                  @endforeach
                </div>
              </li>
            </ul>
          </div>
          @yield('content')
        </div>
        @include('admin.shared.footer')
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    @include('Admin.shared.js');
    @stack('scripts')

    <!-- endinject -->
</body>

</html>
