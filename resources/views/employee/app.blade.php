<x-layout>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-dark">List Employee</h4>
                    <a href="{{ route('employee.create')  }}" class="btn btn-primary">Add</a>
                </div>
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
                                    src="{{ is_null($employee->photo) ? 'https://upload.wikimedia.org/wikipedia/commons/0/08/Aespa_Karina_2024_MMA_2.jpg' : asset($employee->photo) }}"
                                    alt="profile"
                                    class="rounded"
                                    style="width: 56px; height: 56px; object-fit: cover;" />
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('employee.edit', $employee->id) }}" class="text-white text-sm bg-success border-0 px-2 rounded" href="/">Edit</a>
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
    </div>
</x-layout>