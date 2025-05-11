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
                    <i class='ri-global-line widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <img src="{{ asset('assets/icons/Excuse.svg') }}" alt="Excuse" class="w-6 h-6">
                    <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $excuses->count() }}</h3>
                    <p class="text-muted">Pending Leave</p>
                    <i class="ri-mail-open-line widget-icon"></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <img src="{{ asset('assets/icons/present.svg') }}" alt="persent" class="w-6 h-6">
                    <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $totalCheckins }}</h3>
                    <p class="text-muted">Present Today</p>
                    <i class="ri-arrow-right-down-line widget-icon"></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <img src="{{ asset('assets/icons/Late.svg') }}" alt="Late" class="w-6 h-6">
                    <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $totalLateCheckins }}</h3>
                    <p class="text-muted">Late Days</p>
                    <i class="ri-time-line widget-icon"></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <img src="{{ asset('assets/icons/Absent.svg') }}" alt="Absent" class="w-6 h-6">
                    <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $totalNotCheckedIn }}</h3>
                    <p class="text-muted">Not Checked in yet</p>
                    <i class="ri-survey-line widget-icon"></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-lg-7 border-start border-5">
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Attendance Overview</h4>
                    <div id="chart-filter-buttons">
                        <button type="button" class="btn btn-sm btn-outline-light active" data-range="1Y">1Y</button>
                        <button type="button" class="btn btn-sm btn-outline-light" data-range="6M">6M</button>
                        <button type="button" class="btn btn-sm btn-outline-light" data-range="1M">1M</button>
                        <button type="button" class="btn btn-sm btn-outline-light" data-range="ALL">ALL</button>
                    </div>
                </div> <!-- end card-title-->

     
                <div dir="ltr">
                        <div id="dash-performance-chart" class="apex-charts">
                            
                        </div>
                        <script>
                            const attendanceData = {
                                labels: @json($chartLabels),
                                attendances: @json($chartAttendances),
                                lates: @json($chartLates),
                            };
                        </script>
                </div>
            </div>
        </div> <!-- end right chart card -->
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body ">
                    <div class="dropdown float-end">
                        <a href="/attendance">
                            View All
                        </a>
                    </div>
                    <h5 class="card-title mb-3">Today Attendances</h5>

                    <div class="mb-3" data-simplebar style="max-height: 324px;">
                        <div class="table-responsive table-centered table-nowrap px-3">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Status</th>
                                    </tr>
                                </thead> <!-- end thead -->
                                <tbody>
                                    @forelse($todayAttendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->user->name }}</td>
                                            <td>{{ $attendance->checkin }}</td>
                                            <td>{{ $attendance->checkout ?? '-' }}</td>
                                            <td>
                                                @if ($attendance->checkout)
                                                    <span style="color: green;">Already Checked-out</span>
                                                @else
                                                    <span style="color: red;">Not Checked-out Yet</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No one has checked in today.</td>
                                        </tr>
                                    @endforelse
                                </tbody> <!-- end tbody -->
                            </table> <!-- end table -->
                        </div> <!-- end table responsive -->
                    </div>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->
</x-layout>
