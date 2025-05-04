<x-layout>
    <div class="card">
        <div class="card-body">
            <form class="row g-2">
                <div class="col-md-12">
                    <label class="form-label">Name Office</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Longtitude Coordinate</label>
                    <input type="text" class="form-control" name="long">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Latitude Coordinate</label>
                    <input type="text" class="form-control" name="lat">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" id="" class="form-control"></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>