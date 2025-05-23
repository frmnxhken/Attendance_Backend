<x-layout>

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
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            {{ $excuse->user->nip }}
                        </li>
                        <li class="list-group-item">
                            {{ $excuse->user->name }}
                        </li>
                        <li class="list-group-item">
                            {{ $excuse->reason }}
                        </li>
                        <li class="list-group-item">
                            {{ $excuse->date }}
                        </li>
                    </ul>
                    @if($excuse->status !== "approve")
                    <form action="{{ route("approve", $excuse->id) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Start</label>
                                <input name="start" type="date" value="<?= date('Y-m-d') ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">end</label>
                                <input name="end" type="date" class="form-control">
                            </div>
                            <button class="btn btn-success mt-4">Approve</button>
                        </div>
                    </form>
                    <form action="{{ route("cancel", $excuse->id) }}" method="post">
                        @csrf
                        <div class="row">
                            <button class="btn btn-outline-dark mt-1">Cancel</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <img
                        style="width: 100%; aspect-ratio: 1; object-fit: cover;"
                        class="rounded"
                        src="{{ asset($excuse->proof ) }}"
                        </div>
                </div>
            </div>
        </div>
</x-layout>