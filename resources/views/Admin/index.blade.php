@extends('admin.layouts.app')
@push('css')
  <style>
    .stats-icon {
      width: 3rem;
      height: 3rem;
      border-radius: 0.5rem;
      background-color: #000;
      float: right;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .stats-icon i {
      color: #fff;
      font-size: 1.7rem;
    }

    .stats-icon.purple {
      background-color: #9694ff;
    }

    .stats-icon.blue {
      background-color: #57caeb;
    }

    .stats-icon.red {
      background-color: #ff7976;
    }

    .stats-icon.green {
      background-color: #5ddab4;
    }
  </style>
@endpush
@section('content')
  <div class="row">
    <div class="col-6 col-lg-3 col-md-6 mb-2">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row text-center">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center ">
              <div class="stats-icon purple mb-2">
                <i class="fa-solid fa-tags"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Categories</h6>
              <h6 class="font-extrabold mb-0">{{ $kategori }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6 mb-2">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row text-center">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center ">
              <div class="stats-icon blue mb-2">
                <i class="fa-solid fa-box"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Products</h6>
              <h6 class="font-extrabold mb-0">{{ $produk }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6 mb-2">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row text-center">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center ">
              <div class="stats-icon green mb-2">
                <i class="fa-solid fa-truck"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Suppliers</h6>
              <h6 class="font-extrabold mb-0">{{ $supplier }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6 mb-2">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row text-center">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center ">
              <div class="stats-icon red mb-2">
                <i class="fa-solid fa-users"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Members</h6>
              <h6 class="font-extrabold mb-0">{{ $member }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12 grid-margin stretch-card flex-column">
      <div class="row h-100">
        <div class="col-md-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                  <h6>Grafik Pendapatan {{ tanggal_indonesia($tanggal_awal, false) }} s/d
                    {{ tanggal_indonesia($tanggal_akhir, false) }}</h6>
                </div>
                <div id="income-chart-legend" class="d-flex flex-wrap mt-1 mt-md-0"></div>
              </div>
              <canvas id="chart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    $(function() {
      // Get context with jQuery - using jQuery's .get() method.
      var salesChartCanvas = $('#chart').get(0).getContext('2d');

      // Extract data from first script
      const extractedLabels = {{ json_encode($data_tanggal) }};
      const extractedData = {{ json_encode($data_pendapatan) }};

      // Create new chart with extracted data
      const salesChart = new Chart(salesChartCanvas, {
        type: 'line', // Change to 'line' for line chart
        data: {
          labels: extractedLabels,
          datasets: [{
            label: 'Pendapatan',
            fillColor: 'rgba(60,141,188,0.9)', // Adjust transparency (opacity) for line fill
            strokeColor: 'rgba(60,141,188,0.8)', // Adjust line color
            pointRadius: 5, // Adjust point size
            pointBackgroundColor: '#3b8bba', // Adjust point color
            pointBorderColor: 'rgba(60,141,188,1)', // Adjust point border color
            pointBorderWidth: 1, // Adjust point border width
            pointHoverRadius: 8, // Adjust point size on hover
            pointHoverBackgroundColor: '#fff', // Adjust point color on hover
            pointHoverBorderColor: 'rgba(60,141,188,1)', // Adjust point border color on hover
            data: extractedData
          }]
        },
        options: {
          pointDot: false, // Remove dots if desired (set to true for dots)
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      // Define actions for changing point style
      const actions = [{
          name: 'pointStyle: circle (default)',
          handler: (chart) => {
            chart.data.datasets.forEach(dataset => {
              dataset.pointStyle = 'circle';
            });
            chart.update();
          }
        },
        // You can add additional actions for other point styles here
      ];

      // Add a button or other element to trigger the action
      // This example creates a simple button
      const button = document.createElement('button');
      button.textContent = 'Change to Circle Points';
      button.addEventListener('click', () => actions[0].handler(salesChart));
      document.body.appendChild(button);

      // You can also trigger actions based on other events or interactions
    });
  </script>
@endpush
