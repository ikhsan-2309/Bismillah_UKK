</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laraten - Admin</title>
  @include('Admin.shared.css')
  @stack('css')
</head>

<body>
  <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
  <div id="app">
    @include('Admin.shared.sidebar')
    <div id="main" class='layout-navbar navbar-fixed'>
      @include('admin.shared.navbar')
      <div id="main-content">
        <div class="page-heading">
          <div class="page-title">
            <div class="row">
              <div class="col-12 col-md-6 order-md-1 order-first mb-2">
                <h3>{{ $page_title }}</h3>
              </div>
              <div class="col-12 col-md-6 order-md-2 order-last">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-sm-start float-lg-end">
                  <ol class="breadcrumb">
                    @foreach ($breadcrumb_items as $item)
                      @if ($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                      @else
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ $item['label'] }}</a></li>
                      @endif
                    @endforeach
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          @yield('content')
        </div>

      </div>
      @include('admin.shared.footer')
    </div>
  </div>
  @include('Admin.shared.js');
  @stack('scripts')
</body>

</html>
