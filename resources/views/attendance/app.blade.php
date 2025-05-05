<x-layout>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <h4 class="text-dark">Attendance Today</h4>
                </div>
                <table class="table table-hover">
                    @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->user->name }}</td>
                            <td>Checkin: 
                                {{ $attendance->checkin ? $attendance->checkin : '--:--' }}
                            </td>
                            <td>Checkout: 
                                {{ $attendance->checkout ? $attendance->checkout : '-- : --' }}
                            </td>
                            <td>
                                @if($attendance->status == 'present')
                                    <span class="badge bg-success">Present</span>
                                @elseif($attendance->status == 'present')
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
</x-layout>