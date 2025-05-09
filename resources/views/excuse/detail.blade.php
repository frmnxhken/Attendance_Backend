<x-layout>
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
                            {{ $excuse->description }}
                        </li>
                    </ul>
                    <div class="d-flex gap-2">
                        <form action="{{ route("approve", $excuse->id) }}" method="post">
                            @csrf
                            <button class="btn btn-success">Approve</button>
                        </form>
                        <form action="{{ route("cancel", $excuse->id) }}" method="post">
                            @csrf
                            <button class="btn btn-danger">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <img 
                        style="width: 100%; aspect-ratio: 1; object-fit: cover;"
                        class="rounded"
                        src="https://akcdn.detik.net.id/visual/2025/03/07/jiwoo-hearts2hearts-1741339867633_43.jpeg?w=1200" alt="preview">
                </div>
            </div>
        </div>
    </div>
</x-layout>