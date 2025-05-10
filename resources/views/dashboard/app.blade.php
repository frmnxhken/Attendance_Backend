<x-layout>
    <!-- ========== Page Title Start ========== -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-bold">Home</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
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
                    <iconify-icon icon="solar:asteroid-bold-duotone" class="fs-36 text-info"></iconify-icon>
                    <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $users->count() }}</h3>
                    <p class="text-muted">Total Employees</p>
                    <span class="badge fs-12 badge-soft-success"><i class="ti ti-arrow-badge-up"></i> 8.72%</span>
                    <i class='ri-global-line widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <iconify-icon icon="solar:black-hole-line-duotone" class="fs-36 text-success"></iconify-icon>
                    <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $excuses->count() }}</h3>
                    <p class="text-muted">Pending Leave</p>
                    <span class="badge fs-12 badge-soft-danger"><i class="ti ti-arrow-badge-down"></i> 3.28%</span>
                    <i class='ri-file-chart-line widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <iconify-icon icon="solar:leaf-bold-duotone" class="fs-36 text-primary"></iconify-icon>
                    <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $late->count() }}</h3>
                    <p class="text-muted">Late Days</p>
                    <span class="badge fs-12 badge-soft-danger"><i class="ti ti-arrow-badge-down"></i> 5.69%</span>
                    <i class='ri-drag-move-line widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <iconify-icon icon="solar:crown-star-bold-duotone" class="fs-36 text-danger"></iconify-icon>
                    <h3 class="mb-0 fw-bold mt-3 mb-1">$11.3k</h3>
                    <p class="text-muted">Savings</p>
                    <span class="badge fs-12 badge-soft-success"><i class="ti ti-arrow-badge-up"></i> 10.58%</span>
                    <i class='ri-hand-heart-line widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <iconify-icon icon="solar:cpu-bolt-line-duotone" class="fs-36 text-warning"></iconify-icon>
                    <h3 class="mb-0 fw-bold mt-3 mb-1">$5.5k</h3>
                    <p class="text-muted">Profits</p>
                    <span class="badge fs-12 badge-soft-success"><i class="ti ti-arrow-badge-up"></i> 2.25%</span>
                    <i class='ri-stack-line widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body p-0">
                    <div class="pt-3 px-3">
                        <div class="float-end">
                            <a href="javascript:void(0);" class="text-primary">Export
                                <i class="ri-export-line ms-1"></i>
                            </a>
                        </div>
                        <h5 class="card-title mb-3">Recent Project Summary</h5>
                    </div>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body ">
                    <div class="dropdown float-end">
                        <a href="/attendance">
                            View All
                        </a>
                    </div>
                    <h5 class="card-title mb-3">Recent Attendances</h5>
                    
                    <div class="mb-3" data-simplebar style="max-height: 324px;">
                        <div class="table-responsive table-centered table-nowrap px-3">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Client</th>
                                        <th>Team</th>
                                    </tr>
                                </thead> <!-- end thead -->
                                <tbody>
                                    <tr>
                                        <td>Zelogy</td>
                                        <td>Daniel Olsen</td>
                                        <td>12 April 2024</td>
                                    </tr>
                                </tbody> <!-- end tbody -->
                            </table> <!-- end table -->
                        </div> <!-- end table responsive -->
                    </div>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-lg-4">
                            <div class="p-3">
                                <h5 class="card-title">Conversions</h5>
                                <div id="conversions" class="apex-charts mb-2 mt-n2"></div>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <p class="text-muted mb-2">This Week</p>
                                        <h3 class="text-dark mb-3">23.5k</h3>
                                    </div> <!-- end col -->
                                    <div class="col-6">
                                        <p class="text-muted mb-2">Last Week</p>
                                        <h3 class="text-dark mb-3">41.05k</h3>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                                <div class="text-center">
                                    <button type="button" class="btn btn-light shadow-none w-100">View
                                        Details</button>
                                </div> <!-- end row -->
                            </div>
                        </div> <!-- end left chart card -->
                        <div class="col-lg-8 border-start border-5">
                            <div class="p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Performance</h4>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-light">ALL</button>
                                        <button type="button" class="btn btn-sm btn-outline-light">1M</button>
                                        <button type="button" class="btn btn-sm btn-outline-light">6M</button>
                                        <button type="button" class="btn btn-sm btn-outline-light active">1Y</button>
                                    </div>
                                </div> <!-- end card-title-->

                                <div class="alert alert-info mt-3 text text-truncate mb-0" role="alert">
                                    We regret to inform you that our server is currently experiencing technical
                                    difficulties.
                                </div>

                                <div dir="ltr">
                                    <div id="dash-performance-chart" class="apex-charts"></div>
                                </div>
                            </div>
                        </div> <!-- end right chart card -->
                    </div> <!-- end chart card -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col-->
    </div> <!-- end row-->
</x-layout>
