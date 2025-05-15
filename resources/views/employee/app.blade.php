<x-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-bold">Employee</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Employee</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <a href="{{ route('employee.create')  }}" class="btn btn-primary">Add</a>
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
    

    <div class="row">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Fullname</th>
                            <th scope="col">Email</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Office</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $index => $employee)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $employee->nip }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->gender }}</td>
                            <td>{{ $employee->office->name }}</td>
                            <td>
                                <img
                                    src="{{ is_null($employee->photo) ? 'https://akcdn.detik.net.id/visual/2021/09/08/karina-aespa-4_43.jpeg?w=720&q=90' : asset($employee->photo) }}"
                                    alt="profile"
                                    class="rounded"
                                    style="width: 56px; height: 56px; object-fit: cover;" />
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('employee.edit', $employee->id) }}" class="text-white text-sm bg-success border-0 px-2 rounded" href="/">Edit</a>
                                    <a href="{{ route('employee.show', $employee->id) }}" class="text-white text-sm bg-warning border-0 px-2 rounded" href="/">Detail</a>
                                    <form method="post" action="{{ route('employee.destroy', $employee->id) }}">
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

        {{ $employees->links() }}

    </div>
</x-layout>