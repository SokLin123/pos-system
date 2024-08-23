<x-app-layout>
    <section class="section">
        <div class="d-flex flex-wrap col-md-12 align-items-center justify-content-between px-4 mb-4">
            <h4 class="mb-3">Users List</h4>
            <div>
                <button class="btn btn-primary icon add-list" id="create" data-original-title="Add Product">
                    <i class="fa-solid fa-plus mr-3"></i>
                </button>
            </div>
        </div>
        <div class="card">
            <div class="d-flex col-md-12 flex-wrap align-items-center mt-2 py-3 px-4 justify-content-between">
                <div class="form-group col-md-4 row">
                    <h3> Users List </h3>
                </div>
                <div class="form-group col-md-3 row">
                    <div class="input-group col-md-12">
                        <input type="text" id="search" class="form-control h-100" name="search" placeholder="Search....">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-striped' id="datatable">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td class="d-flex justify-content-center">
                                <img class="avatar-60 w-auto" style="height:100px" src="{{ $user->photo ? asset('storage/users/'.$user->photo) : asset('assets/images/product/default.webp') }}" alt="Product Image">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="align-item-center"><h2>********</h2></td>
                            <td>
                            </td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <button class="btn icon btn-info me-2 show" data-toggle="tooltip" data-placement="top" data-id="{{ $user->id }}" title="View">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    <button class="btn icon btn-success me-2 edit" data-toggle="tooltip" data-placement="top" data-id="{{ $user->id }}" title="Edit">
                                        <i class="nav-icon fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger icon me-2 delete" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip"  data-id="{{ $user->id }}" data-placement="top" title="Delete">
                                        <i class="ri-delete-bin-line mr-0"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-danger">Data not Found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container z-3 position-fixed top-0" id="editform" style="z-index: 9999;">
            @include('users.edit')
        </div>
        <div class="container z-3 position-fixed top-0" id="showform" style="z-index: 9999;">
            @include('users.show')
        </div>
        <!-- Hidden Create Product Form -->
        <div class="container z-3 position-fixed top-0" id="createform" style="display: none;">
            @include('users.create')
        </div>
    </section>

    <!-- Toggle Button Script -->
    <script>
        $(document).ready(function(){
            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#datatable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
    

</x-app-layout>