<x-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-bold">Special</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item">Schedules</li>
                    <li class="breadcrumb-item active">Special</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <a href="{{ route('special.create')}}" class="btn btn-primary">Add</a>
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
                    <th>Date</th>
                    <th>Description</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($hollidays as $index => $holliday)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $holliday->date }}</td>
                        <td>{{ $holliday->description }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('special.edit', $holliday->id) }}" class="text-white text-sm bg-success border-0 px-2 rounded" href="/">Edit</a>
                                <form method="post" action="{{ route('special.destroy', $holliday->id) }}">
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