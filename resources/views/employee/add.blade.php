<x-layout>
    <div class="card">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">NIP</label>
                    <input type="text" class="form-control" name="nip">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fullname</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gender</label>
                    <select class="form-control" name="gender">
                        <option value="">Male</option>
                        <option value="">Female</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Office</label>
                    <select class="form-control" name="office">
                        <option value="">Select Office</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control"></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>