@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div style="background-color: #0081C9;" class="small-box">
                        <div class="inner">
                            <h3>{{ count($user) }}</h3>
                            <p>User</p>
                        </div>
                        <div class="icon">
                            <i  class="fas fa-user"></i>
                        </div>
                        <a href="{{ route('user.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div style="background-color: #5BC0F8;" class="small-box">
                        <div class="inner">
                            <h3>{{ count($role) }}</h3>
                            <p>Role</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <a href="{{ route('role.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div style="background-color: #86E5FF;" class="small-box">
                        <div class="inner">
                            <h3>{{ count($permission) }}</h3>
                            <p>Permission</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-unlock"></i>
                        </div>
                        <a href="{{ route('permission.index') }}" class="small-box-footer"> More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div style="background-color: #FF6B6B;" class="info-box">
                            <span class="info-box-icon"><i class="fas fa-business-time"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Perjalanan Dinas</span>
                                <span class="info-box-number">{{ count($perjadin) }}</span>
                                <span class="progress-description">
                                    Jumlah Perjalanan Dinas
                                </span>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div style="background-color: #FFD93D;" class="info-box">
                            <span class="info-box-icon"><i class="fas fa-file-pdf"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Surat</span>
                                <span class="info-box-number">{{ count($surat) }}</span>
                                <span class="progress-description">
                                    Jumlah Surat yang telah dibuat
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div style="background-color: #6BCB77;" class="info-box">
                            <span class="info-box-icon"><i class="fas fa-money-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Kuitansi</span>
                                <span class="info-box-number">{{ count($kuitansi) }}</span>
                                <span class="progress-description">
                                    Jumlah Kuitansi yang telah dibuat
                                </span>
                            </div>
                        </div>
                    </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div style="background-color: #4D96FF;" class="info-box">
                                <span class="info-box-icon"><i class="fas fa-comments"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Biaya</span>
                                    <span class="info-box-number">Rp. {{ number_format($kuitansi->sum('cost_total'), 0, ',', '.') }}</span>
                                <span class="progress-description">
                                    Total Biaya yang telah dikeluarkan
                                </span>
                            </div>
                        </div>         
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Perjadin</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('js')

<script>
    var areaChartData = {
      labels  : ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
      datasets: [
        {
          label               : 'Jumlah orang yang mengikuti Perjadin',
          backgroundColor     : 'rgba(0, 173, 181,0.9)',
          borderColor         : 'rgba(0,173, 181,0.8)',
          pointRadius         : false,
          pointColor          : 'rgba(0, 173, 181,1)',
          pointStrokeColor    : '#3b8bba',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(0, 183, 181,1)',
          data                : [10, 15, 12, 11, 16, 9, 19, 5, 5, 5, 5, 5]
        },
        {
          label               : 'Jumlah Perjadin',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [2, 2, 3, 4, 5, 6, 7, 8, 10, 1, 2, 3]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }
//-------------
//- BAR CHART -
//-------------
var barChartCanvas = $('#barChart').get(0).getContext('2d')
var barChartData = $.extend(true, {}, areaChartData)
var temp0 = areaChartData.datasets[0]
var temp1 = areaChartData.datasets[1]
barChartData.datasets[0] = temp1
barChartData.datasets[1] = temp0

var barChartOptions = {
  responsive              : true,
  maintainAspectRatio     : false,
  datasetFill             : false
}

new Chart(barChartCanvas, {
  type: 'bar',
  data: barChartData,
  options: barChartOptions
})

</script>
@endsection
