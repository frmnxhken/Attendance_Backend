<x-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-bold">Weekly</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item">Schedules</li>
                    <li class="breadcrumb-item active">Weekly</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <a href="{{ route('weekly.create')}}" class="btn btn-primary">Add</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('fail'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('fail') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>Day name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($weeklies as $index => $weekly)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $weekly->day }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('weekly.edit', $weekly->id) }}" class="text-white text-sm bg-success border-0 px-2 rounded" href="/">Edit</a>
                                <form method="post" action="{{ route('weekly.destroy', $weekly->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        onclick="return confirm('Are you sure ?')"
                                        class="text-white bg-primary border-0 px-2 rounded" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</x-layout>