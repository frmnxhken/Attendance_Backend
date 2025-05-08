<x-layout>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <h4 class="text-dark">Excuse</h4>
                </div>
                <ul class="list-group">
                    @forelse ($excuses as $excuse)
                        <li class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between">
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
                            </div>
                        </li>
                    @empty
                        Data tidak ada
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-layout>
