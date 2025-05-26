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
                <div class="table-responsive">

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
                                <td class="text-nowrap text-decoration-underline">
                                    <a href="{{ route('employee.show', $employee->id) }}">
                                        {{ $employee->name }}
                                    </a>
                                </td>
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
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $employee->id }}" class="text-white text-sm bg-warning border-0 px-2 rounded" href="/">Balance</a>
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

                            <!-- Edit modal -->
                            <div class="modal fade" id="edit{{ $employee->id }}" tabindex="-1"
                                aria-labelledby="editLabel{{ $employee->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Edit | {{ $employee->name }}</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('updateBalance', $employee->id) }}" method="post">
                                                @CSRF
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Balance</label>
                                                        <input value="{{ $employee->balance->total_minutes }}" type="text" id="total_minutes" name="total_minutes" class="form-control @error('total_minutes') is-invalid @enderror" value="{{ old('total_minutes') }}">
                                                    </div>
                                                    <div class="mt-3">
                                                        <button class="btn btn-primary" type="submit">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{ $employees->links() }}

    </div>
</x-layout>