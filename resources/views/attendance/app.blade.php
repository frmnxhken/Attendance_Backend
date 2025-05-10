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
    <div class="row">
        @foreach($attendances as $date => $records)
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <h4 class="text-dark">
                            {{ \Carbon\Carbon::parse($date)->isToday() ? 'Today' : \Carbon\Carbon::parse($date)->format('d M Y') }}
                        </h4>
                    </div>
                    <table class="table table-hover">
                        @foreach($records as $attendance)
                            <tr>
                                <td>{{ $attendance->user->name }}</td>
                                <td>Checkin: {{ $attendance->checkin ?? '--:--' }}</td>
                                <td>Checkout: {{ $attendance->checkout ?? '--:--' }}</td>
                                <td>
                                    @if($attendance->status == 'present')
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
