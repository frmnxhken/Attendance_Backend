<x-layout>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('office.store') }}" class="row g-2">
                @csrf

                <div class="col-md-12">
                    <label for="name" class="form-label">Name Office</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="long" class="form-label">Longitude Coordinate</label>
                    <input type="text" id="long" name="long" class="form-control @error('long') is-invalid @enderror" value="{{ old('long') }}">
                    @error('long')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="lat" class="form-label">Latitude Coordinate</label>
                    <input type="text" id="lat" name="lat" class="form-control @error('lat') is-invalid @enderror" value="{{ old('lat') }}">
                    @error('lat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="lat" class="form-label">Radius</label>
                    <input type="text" id="radius" name="radius" class="form-control @error('radius') is-invalid @enderror" value="{{ old('radius') }}">
                    @error('radius')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
