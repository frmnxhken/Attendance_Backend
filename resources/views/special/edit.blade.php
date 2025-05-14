<x-layout>
    <div class="col-md-6">

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('special.update', $holliday->id) }}" class="row g-2">
                    @csrf
                    @method('PUT')
                    
                    <div class="col-md-12">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" value="{{ old('date', $holliday->date) }}" class="form-control @error('date') is-invalid @enderror">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description" value="{{ old('description', $holliday->description) }}" class="form-control @error('description') is-invalid @enderror">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
