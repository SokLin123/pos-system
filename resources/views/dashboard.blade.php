<x-app-layout>
    <section  class="container">
        <div>
            @if (session()->has('success'))
            <div class="alert text-white bg-success" role="alert">
                <div class="iq-alert-text">{{ session('success') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            @endif
        </div>
        <div class="content-header">
            <h3>Dashboard</h3>
        </div>
        <section  class="content" >
            <div class="row mb-2">
                <div class="col-6 col-sm-6 col-md-3 py-2">
                    <div class="info-box mb-3">
                    <span class="info-box-icon rounded-circle" style="background: rgba(253, 126, 20, 0.3); color: orange;"><i class="fas fa-money-bill-1-wave fs-5"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-number">${{ $total_sele_due }}</span>
                        <span class="info-box-text">Total Sele Due</span>
                    </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-3 py-2">
                    <div class="info-box mb-3">
                        <span class="info-box-icon rounded-circle" style="background: rgba(1, 255, 112, 0.3); color: green;"><i class="fab fa-shopify fs-5"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-number">${{ $total_purchase_due }}</span>
                            <span class="info-box-text">Total Purchase Due</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-3 py-2">
                    <div class="info-box mb-3">
                    <span class="info-box-icon rounded-circle" style="background: rgba(23, 162, 184, 0.3); color: #007bff;"><i class="fas fa-money-check-dollar fs-5"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-number">${{ $total_sele }}</span>
                        <span class="info-box-text">Total Sele Amount</span>
                    </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-3 py-2">
                    <div class="info-box mb-3">
                    <span class="info-box-icon rounded-circle" style="background: rgba(216, 27, 96, 0.3); color: red;"><i class="fas fa-money-bill-1 fs-5"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-number">${{ $total_expense }}</span>
                        <span class="info-box-text">Total Expense Amount</span>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$customer}}</h3>
                            <p>Costomer</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-group"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $supplier }}</h3>
                        <p>Supplier</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$purchase}}</h3>
                        <p>Purchase Invoice</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $sale }}</h3>
                        <p>Sale Invoice</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-11 mx-auto">
                    <!-- BAR CHART -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Bar Chart</h3>

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
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Orders Today</h4>
                            <div class="d-flex ">
                                <i data-feather="download"></i>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="table-responsive">
                                <table class='table mb-0' id="table1">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>City</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Graiden</td>
                                            <td>vehicula.aliquet@semconsequat.co.uk</td>
                                            <td>076 4820 8838</td>
                                            <td>Offenburg</td>
                                            <td>
                                                <span class="badge bg-success">Active</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            $(document).ready(function (){
                var areaChartData = {
                    labels  : ['Jan', 'Feb', 'Mar', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label               : 'Sale',
                            backgroundColor     : 'rgba(60,141,188,0.9)',
                            borderColor         : 'rgba(60,141,188,0.8)',
                            pointRadius          : false,
                            pointColor          : '#3b8bba',
                            pointStrokeColor    : 'rgba(60,141,188,1)',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data                :  <?php echo json_encode($sale_p_year->pluck('payments')->all(), JSON_NUMERIC_CHECK); ?>
                        },
                        {
                            label               : 'Purchase',
                            backgroundColor     : 'rgba(210, 214, 222, 1)',
                            borderColor         : 'rgba(210, 214, 222, 1)',
                            pointRadius         : false,
                            pointColor          : 'rgba(210, 214, 222, 1)',
                            pointStrokeColor    : '#c1c7d1',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data                : <?php echo json_encode($purchase_p_year->pluck('payments')->all(), JSON_NUMERIC_CHECK); ?>
                        },
                    ]
                }


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
                });
            });
        </script>
    </section>
</x-app-layout>
