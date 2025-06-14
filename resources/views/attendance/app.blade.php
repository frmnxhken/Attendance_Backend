<x-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-bold">Attendance</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Attendance</li>
                </ol>
            </div>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
            <form method="GET" action="{{ route('attendance') }}" class="w-100">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">
                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 w-100">
                        <label for="start_date" class="form-label mb-0 text-nowrap">Start Date:</label>
                        <input class="form-control" type="date" name="start_date" value="{{ old('start_date', $startDate) }}">
                    </div>
                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 w-100">
                        <label for="end_date" class="form-label mb-0 text-nowrap">End Date:</label>
                        <input class="form-control" type="date" name="end_date" value="{{ old('end_date', $endDate) }}">
                    </div>
                    <button class="btn btn-primary mt-2 mt-md-0" type="submit">Filter</button>
                </div>
            </form>

            <div class="d-flex flex-wrap flex-md-nowrap gap-2">
                <form method="post" action="{{ route('checkUp') }}">
                    @csrf
                    <button onclick="return confirm('Are you sure?')" class="btn btn-warning w-100 w-sm-auto text-nowrap" type="submit">Check Up</button>
                </form>

                <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle text-nowrap" data-bs-toggle="dropdown" aria-expanded="false">
                        Excel
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('/attendance/export/1-week') }}">1 Week</a></li>
                        <li><a class="dropdown-item" href="{{ url('/attendance/export/1-month') }}">1 Month</a></li>
                        <li><a class="dropdown-item" href="{{ url('/attendance/export/3-month') }}">3 Month</a></li>
                        <li><a class="dropdown-item" href="{{ url('/attendance/export/6-month') }}">6 Month</a></li>
                        <li><a class="dropdown-item" href="{{ url('/attendance/export/1-year') }}">1 Year</a></li>
                        <li><a class="dropdown-item" href="{{ url('/attendance/export/all') }}">All</a></li>
                    </ul>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle text-nowrap" data-bs-toggle="dropdown" aria-expanded="false">
                        Reset
                    </button>
                    <ul class="dropdown-menu">
                        <form action="{{ route('resetPhoto') }}" method="POST">
                            @csrf
                            <button onclick="return confirm('Are you sure removing photos?')" class="dropdown-item text-danger" type="submit">Reset Photo Only</button>
                        </form>
                        <form action="{{ route('resetAll') }}" method="POST">
                            @csrf
                            <button onclick="return confirm('Are you sure resetting attendances?')" class="dropdown-item text-danger" type="submit">Reset All Attendance</button>
                        </form>
                        <form action="{{ route('resetBalance') }}" method="POST">
                            @csrf
                            <button onclick="return confirm('Are you sure resetting balances?')" class="dropdown-item text-danger" type="submit">Reset All Balance</button>
                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($attendances as $date => $records)
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <h4 class="text-dark">
                        {{ \Carbon\Carbon::parse($date)->isToday() ? 'Today' : \Carbon\Carbon::parse($date)->format('d M Y') }}
                    </h4>
                </div>
                <div class="table-responsive">

                    <table class="table table-hover">
                        @foreach ($records as $attendance)
                        <tr>
                            <td class="text-nowrap">
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $attendance->id }}">
                                    {{ $attendance->user->name }}
                            </td>
                            </a>

                            {{-- Check-in --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#checkinModal{{ $attendance->id }}">
                                        in: {{ $attendance->checkin ? \Carbon\Carbon::parse($attendance->checkin)->format('H:i') : '--:--' }}
                                        | {{ $attendance->checkin_distance.'m' ?? '' }}
                                    </a>
                                </div>
                            </td>

                            {{-- Check-out --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#checkoutModal{{ $attendance->id }}">
                                        out: {{ $attendance->checkout ? \Carbon\Carbon::parse($attendance->checkout)->format('H:i') : '--:--' }}
                                        | {{ $attendance->checkout_distance.'m' ?? '' }}
                                    </a>
                                </div>
                            </td>

                            <!-- Edit modal -->
                            <div class="modal fade" id="edit{{ $attendance->id }}" tabindex="-1"
                                aria-labelledby="editLabel{{ $attendance->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Edit | {{ $attendance->user->name }}</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('updateAttendance', $attendance->id) }}" method="post">
                                                @CSRF
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Checkin</label>
                                                        <input value="{{ $attendance->checkin }}" type="text" id="checkin" name="checkin" class="form-control @error('checkin') is-invalid @enderror" value="{{ old('checkin') }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Checkout</label>
                                                        <input value="{{ $attendance->checkout }}" type="text" id="checkout" name="checkout" class="form-control @error('checkout') is-invalid @enderror" value="{{ old('checkout') }}">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="name" class="form-label">Status</label>
                                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                                            <option disabled value="" {{ $attendance->status ? '' : 'selected' }}>Select status</option>
                                                            <option value="Present" {{ $attendance->status == 'Present' ? 'selected' : '' }}>Present</option>
                                                            <option value="Excuse" {{ $attendance->status == 'Excuse' ? 'selected' : '' }}>Excuse</option>
                                                            <option value="Absent" {{ $attendance->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                                                        </select>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button class="btn btn-primary" type="submit">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Check-in Modal --}}
                            <div class="modal fade" id="checkinModal{{ $attendance->id }}" tabindex="-1"
                                aria-labelledby="checkinModalLabel{{ $attendance->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="checkinModalLabel{{ $attendance->id }}">
                                                Check-in: {{ $attendance->checkin ?? '--:--' }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if(is_null($attendance->checkin_photo))
                                            <p>No photo</p>
                                            @else
                                            <img src="{{ is_null($attendance->checkin_photo) ? '' : asset($attendance->checkin_photo) }}"
                                                alt="Check-in photo" class="d-block w-100" />
                                            @endif
                                            <div class="d-flex justify-content-between">
                                                <p>Latt: {{ $attendance->checkin_lat }}</p>
                                                <p>Long: {{ $attendance->checkin_long }}</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Check-out Modal --}}
                            @if (!is_null($attendance->checkout))
                            <div class="modal fade" id="checkoutModal{{ $attendance->id }}" tabindex="-1"
                                aria-labelledby="checkoutModalLabel{{ $attendance->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="checkoutModalLabel{{ $attendance->id }}">
                                                Check-out: {{ $attendance->checkout }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if(is_null($attendance->checkout_photo))
                                            <p>No photo</p>
                                            @else
                                            <img src="{{ is_null($attendance->checkout_photo) ? '' : asset($attendance->checkout_photo) }}"
                                                alt="Check-out photo" class="d-block w-100" />
                                            @endif
                                            <div class="d-flex justify-content-between">
                                                <p>Latt: {{ $attendance->checkin_lat }}</p>
                                                <p>Long: {{ $attendance->checkin_long }}</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Status --}}
                            <td>
                                @if ($attendance->status == 'present')
                                <span class="badge bg-success">Present</span>
                                @elseif($attendance->status == 'excuse')
                                <span class="badge bg-warning">Excuse</span>
                                @else
                                <span class="badge bg-danger">Absent</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
        @endforeach

        <nav>
            <ul class="pagination justify-content-center">

                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}" tabindex="-1">Previous</a>
                </li>

                @for($page = 1; $page <= $totalPages; $page++)
                    <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $page]) }}">{{ $page }}</a>
                    </li>
                    @endfor

                    <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}">Next</a>
                    </li>

            </ul>
        </nav>

    </div>
</x-layout>