<x-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-bold">Office</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Office</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('office.create')  }}" class="btn btn-primary">Add</a>
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
            @foreach ($offices as $office)
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <h4 class="text-dark">{{ $office->name }}</h4>
                        <p>{{ $office->address }}</p>
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                            <div class="d-flex justify-content-between gap-3">
                                <p class="mb-0">{{ $office->long }}</p>
                                <p class="mb-0">{{ $office->lat }}</p>
                            </div>
                            <div class="d-flex justify-content-between gap-3">
                                <p class="mb-0">{{ $office->arrival }}</p>
                                <p class="mb-0">{{ $office->leave }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <a
                                href="{{ route('office.edit', $office->id) }}"
                                class="text-white text-sm bg-success border-0 px-2 rounded" href="/">Edit</a>
                            <form method="post" action="{{ route('office.destroy', $office->id) }}">
                                @CSRF
                                @method('DELETE')
                                <button
                                    onclick="return confirm('Are you sure?')"
                                    class="text-white bg-primary border-0 px-2 rounded" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layout>