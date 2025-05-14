<x-layout>
    <h4>Special Holliday</h4>
    <a href="{{ route('special.create')}}" class="btn btn-primary">Add</a>
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