<x-layout>
    <div class="col-md-6">

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('weekly.update',  $holiday->id)}}" class="row g-2">
                    @csrf
                    @method('PUT')
                    <!-- Hidden ID -->
                    <input type="hidden" name="id" value="{{ $holiday->id }}">

                    <div class="col-md-12">
                        <label for="day" class="form-label">Day</label>
                        <select class="form-select @error('day') is-invalid @enderror" name="day" required>
                            <option disabled>Select a day</option>
                            @foreach ($days as $day)
                                <option value="{{ $day }}" {{ $holiday->name === $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                        @error('day')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
