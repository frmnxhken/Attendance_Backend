<x-layout>
    <div class="col-md-6">

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('weekly.store') }}" class="row g-2">
                    @csrf

                    <div class="col-md-12">
                        <label for="name" class="form-label">Day</label>
                        <select class="form-select @error('day') is-invalid @enderror" name="day" required>
                            <option disabled selected>Select a day</option>
                            @foreach ($days as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                        @error('day')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>