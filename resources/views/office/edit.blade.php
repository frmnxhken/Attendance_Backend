<x-layout>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('office.update', $office->id) }}" class="row g-2">
                @csrf
                @method('PUT')

                <div class="col-md-12">
                    <label class="form-label">Name Office</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $office->name) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Longitude Coordinate</label>
                    <input type="text" class="form-control" name="long" value="{{ old('long', $office->long) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Latitude Coordinate</label>
                    <input type="text" class="form-control" name="lat" value="{{ old('lat', $office->lat) }}">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Radius</label>
                    <input type="text" class="form-control" name="radius" value="{{ old('radius', $office->radius) }}">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control">{{ old('address', $office->address) }}</textarea>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
