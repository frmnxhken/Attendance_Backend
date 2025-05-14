<x-layout>
    <!-- ========== Page Title Start ========== -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-bold">Home</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">BrandUI</a></li>
                    <li class="breadcrumb-item active">Home</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- ========== Page Title End ========== -->

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <iconify-icon icon="solar:shield-user-bold" class="fs-36 text-info"></iconify-icon>
                    <h3 class="mb-0 fw-bold mt-3 mb-1">
                        {{ $statistic['users'] }}
                    </h3>
                    <p class="text-muted">Total Employee</p>
                    <i class='ri-global-line widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <iconify-icon icon="solar:clipboard-check-bold" class="fs-36 text-success"></iconify-icon>
                    <h3 class="mb-0 fw-bold mt-3 mb-1">
                        {{ $statistic['presents'] }}
                    </h3>
                    <p class="text-muted">Presents today</p>
                    <i class='ri-file-chart-line widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <iconify-icon icon="solar:ghost-bold" class="fs-36 text-primary"></iconify-icon>
                    <h3 class="mb-0 fw-bold mt-3 mb-1">
                        {{ $statistic['lates'] }}
                    </h3>
                    <p class="text-muted">Lates today</p>
                    <i class='ri-drag-move-line widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <iconify-icon icon="solar:clipboard-remove-bold" class="fs-36 text-danger"></iconify-icon>
                    <h3 class="mb-0 fw-bold mt-3 mb-1">
                        {{ $statistic['absents'] }}
                    </h3>
                    <p class="text-muted">Absents today</p>
                    <i class='ri-hand-heart-line widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body p-0">
                    <div class="pt-3 px-3">
                        <h5 class="card-title mb-3">Recent Attendance</h5>
                    </div>
                    <div class="mb-3" data-simplebar>
                        <div class="table-responsive table-centered table-nowrap px-3">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead> <!-- end thead -->
                                <tbody>
                                    @foreach($recents as $recent)
                                    <tr>
                                        <td>{{ $recent->user->name }}</td>
                                        <td>
                                            <span class="badge 
                                                    @if($recent->status == 'present') bg-success
                                                    @elseif($recent->status == 'absent') bg-danger
                                                    @else bg-warning
                                                    @endif">
                                                {{ $recent->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody> <!-- end tbody -->
                            </table> <!-- end table -->
                        </div> <!-- end table responsive -->
                    </div>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <div class="col-md-8">
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Monthly Performance</h4>
                </div> <!-- end card-title-->

                <div dir="ltr">
                    <canvas id="attendanceChart" class="apex-charts"></canvas>
                </div>
            </div>
        </div> <!-- end right chart card -->
    </div> <!-- end row -->


    <script>
        const dates = @json($dates);
        const lates = @json($latesData);
        const extras = @json($extrasData);

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                            label: 'Late Arrivals',
                            data: lates,
                            borderColor: 'rgba(3,206,164,0.8)',
                            tension: 0.1,
                            fill: false,
                            pointRadius: 3,
                            pointHoverRadius: 10
                        },
                        {
                            label: 'Extra Minutes',
                            data: extras,
                            borderColor: 'rgba(43,89,195,0.8)',
                            tension: 0.1,
                            fill: false,
                            pointRadius: 3,
                            pointHoverRadius: 10
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: "#000"
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'people'
                            }
                        }
                    }
                }
            });
        });
    </script>


</x-layout>