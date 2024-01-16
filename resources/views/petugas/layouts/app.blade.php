</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laraten - petugas</title>
  @include('petugas.shared.css')
</head>

<body>
  <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
  <div id="app">
    @include('petugas.shared.sidebar')
    <div id="main" class='layout-navbar navbar-fixed'>
      @include('petugas.shared.navbar')
      <div id="main-content">
        <div class="page-heading">
          <div class="page-title">
            <div class="row">
              <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $page_title }}</h3>
              </div>
              <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                  <ol class="breadcrumb">
                    @foreach ($breadcrumb_items as $item)
                      @if ($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                      @else
                        <li class="breadcrumb-item"><a href="{{ route('petugas') }}">{{ $item['label'] }}</a></li>
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
      @include('petugas.shared.footer')
    </div>
  </div>
  @include('petugas.shared.js');
  @stack('scripts')
</body>

</html>
