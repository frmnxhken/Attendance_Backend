<x-layout>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-bold">Excuse</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Excuse</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="d-flex justify-content-between align-items-center">

            <div class="col-md-4">
                <form action="/excuse" method="get">
                    <div class="input-group">
                        <select name="filter" class="form-control">
                            <option value="">Filter status</option>
                            <option>approve</option>
                            <option>pending</option>
                            <option>cancel</option>
                        </select>
                        <button class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Reset
                </button>
                <ul class="dropdown-menu">
                    <form action="{{ route('resetPhotoExcuse') }}" method="POST">
                        @csrf
                        <button onclick="return confirm('Yakin ingin reset foto?')" class="dropdown-item text-danger" type="submit">Reset Photo Only</button>
                    </form>
                    <form action="{{ route('resetAllExcuse') }}" method="POST">
                        @csrf
                        <button onclick="return confirm('Yakin ingin reset semua?')" class="dropdown-item text-danger" type="submit">Reset All Data</button>
                    </form>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    @forelse ($excuses as $excuse)
                    <tr>
                        <td class="d-flex flex-column flex-md-row justify-content-between">
                            <div>
                                <p><a href="/excuse/detail/{{ $excuse->id }}">{{ $excuse->user->name }}</a></p>
                                <p>{{ $excuse->reason }}</p>
                                @php
                                $badgeClass = match ($excuse->status) {
                                'approve' => 'bg-success',
                                'pending' => 'bg-warning',
                                'cancel' => 'bg-danger',
                                default => 'bg-warning',
                                };
                                @endphp

                                <span class="badge {{ $badgeClass }}">{{ ucfirst($excuse->status) }}</span>
                            </div>
                            <p class="fs-6 mt-4 mt-md-0">{{ $excuse->date }}</p>
                        </td>
                    </tr>
                    @empty
                    Nothing excuse
                    @endforelse
                </table>
            </div>
        </div>

        {{ $excuses->appends(['filter' => request('filter')])->links() }}

    </div>
</x-layout>