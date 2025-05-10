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
    <div class="row">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    @forelse ($excuses as $excuse)
                        <tr>
                            <td class="d-flex justify-content-between">
                                <div>
                                    <p><a href="/excuse/detail/{{ $excuse->id }}">{{ $excuse->user->name }}</a></p>
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
                                <p>{{ $excuse->created_at }}</p>
                            </td>
                        </tr>
                    @empty
                        Data tidak ada
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</x-layout>
