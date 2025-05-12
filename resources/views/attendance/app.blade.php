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
    <form method="GET" action="{{ route('attendance') }}">
        <div class="row mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div>
                        <label for="start_date">Start Date:</label>
                        <input class="form-control" type="date" name="start_date" value="{{ old('start_date', $startDate) }}">
                    </div>
                    <div>
                        <label for="end_date">End Date:</label>
                        <input class="form-control" type="date" name="end_date" value="{{ old('end_date', $endDate) }}">
                    </div>
                    <div>
                        <button class="btn btn-primary mt-3" type="submit">Filter</button>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="" class="btn btn-success">Excel</a>
                    <a href="" class="btn btn-danger">PDF</a>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach ($attendances as $date => $records)
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <h4 class="text-dark">
                        {{ \Carbon\Carbon::parse($date)->isToday() ? 'Today' : \Carbon\Carbon::parse($date)->format('d M Y') }}
                    </h4>
                </div>
                <table class="table table-hover">
                    @foreach ($records as $attendance)
                    <tr>
                        <td>{{ $attendance->user->name }}</td>

                        {{-- Check-in --}}
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#checkinModal{{ $attendance->id }}">
                                    <img src="{{ is_null($attendance->checkin_photo) ? '' : asset($attendance->checkin_photo) }}"
                                        alt="image" class="img-fluid avatar-md rounded" />
                                </a>
                                Checkin: {{ $attendance->checkin ?? '--:--' }}
                            </div>
                        </td>

                        {{-- Check-out --}}
                        <td>
                            @if (is_null($attendance->checkout))
                            <span style="color: red;">Not Checked-out Yet</span>
                            @else
                            <div class="d-flex align-items-center gap-3">
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#checkoutModal{{ $attendance->id }}">
                                    <img src="{{ is_null($attendance->checkout_photo) ? '' : asset($attendance->checkout_photo) }}"
                                        alt="image" class="img-fluid avatar-md rounded" />
                                </a>
                                Checkout: {{ $attendance->checkout }}
                            </div>
                            @endif
                        </td>

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
                                        <img src="{{ is_null($attendance->checkin_photo) ? '' : asset($attendance->checkin_photo) }}"
                                            alt="Check-in photo" class="d-block w-100" />
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
                                        <img src="{{ is_null($attendance->checkout_photo) ? '' : asset($attendance->checkout_photo) }}"
                                            alt="Check-out photo" class="d-block w-100" />
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
                            @if (is_null($attendance->checkout))
                            @elseif ($attendance->status == 'present')
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
        @endforeach
    </div>
</x-layout>