<x-layout>
    <div class="col-md-6">

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('special.store') }}" class="row g-2">
                    @csrf

                    <div class="col-md-12">
                        <label for="name" class="form-label">Day</label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="name" class="form-label">Description</label>
                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>