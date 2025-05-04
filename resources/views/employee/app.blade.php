<x-layout>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Fullname</th>
                            <th scope="col">Email</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Office</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>282392</td>
                            <td>Karina</td>
                            <td>karina@aespa.com</td>
                            <td>Female</td>
                            <td>Imersa Ofc1</td>
                            <td>
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/0/08/Aespa_Karina_2024_MMA_2.jpg"
                                    alt="profile"
                                    class="rounded"
                                    style="width: 56px; height: 56px; object-fit: cover;" />
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a class="text-white text-sm bg-success border-0 px-2 rounded" href="/">Edit</a>
                                    <form>
                                        <button class="text-white bg-primary border-0 px-2 rounded" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>