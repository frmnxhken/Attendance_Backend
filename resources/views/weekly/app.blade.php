<x-layout>
    <h4>Weekly</h4>
    <a href="{{ route('weekly.create')}}" class="btn btn-primary">Add</a>
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