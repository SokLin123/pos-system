<x-app-layout>
    <section class="section">
        <div class="d-flex flex-wrap col-md-12 align-items-center justify-content-between px-4 mb-4">
            <h4 class="mb-3">suppliers List</h4>
            <div>
                <button class="btn btn-primary icon add-list" id="createsupplier" data-original-title="Add supplier">
                    <i class="fa-solid fa-plus mr-3"></i>
                </button>
            </div>
        </div>
        <div class="card">
            <div class="d-flex col-md-12 flex-wrap align-items-center mt-2 py-3 px-4 justify-content-between">
                <div class="form-group col-md-4 row">
                    <h3> suppliers List </h3>
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
                            <th>VANTTIN</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="supplier">
                        @forelse ($suppliers as $index => $supplier)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td class="d-flex justify-content-center">
                                <img class="avatar-60 w-auto" style="height:100px" src=" {{ $supplier->photo ? asset('storage/suppliers/'.$supplier->photo) : asset('assets/images/supplier/default.webp') }}" alt="supplier Image">
                            </td>
                            <td>{{ $supplier->company_name }}</td>
                            <td>{{ $supplier->VANTTIN_num }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>
                                @if ($supplier->status == 1 )
                                    <span class="badge rounded-pill bg-success">Valid</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">Invalid</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <button class="btn icon btn-info me-2 show" data-toggle="tooltip" data-placement="top" data-id="{{ $supplier->id }}" title="View">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    <button class="btn icon btn-success me-2 edit" data-toggle="tooltip" data-placement="top" data-id="{{ $supplier->id }}" title="Edit">
                                        <i class="nav-icon fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger icon me-2 delete" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="ri-delete-bin-line mr-0"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-danger">Data not Found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container z-3 position-fixed top-0" id="showform" style="z-index: 9999;"></div>
    </section>

    <script>
        $(document).ready(function(){
            
            $(document).on('click','.delete',function(){
                var id = $(this).data('id');

                $.ajax({
                    url: 'supliers/delete/'+id,
                    type: 'POST',
                    data: {
                        _token:'{{ csrf_token() }}'
                    }
                })
            });
            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#datatable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            $(document).on('click', '.cancel', function() {
                $('.form').hide();
            });

            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '/suppliers/edit/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', status, error);
                        alert('An error occurred while processing the request.');
                    }
                });
            });

            $(document).on('click','.update', function(){
                var id = $(this).data('id');
                var photo = $('#photo')[0].files[0];
                var company_name = $('#company_name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var address = $('#address').val();
                var note = $('#note').val();
                
                $.ajax({
                    url: '/suppliers/update/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        
                    },
                });
            });

            $(document).on('click', '.show', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/suppliers/show/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#showform').empty();
                        $('#showform').append(`
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <div class="header-title">
                                                    <h4 class="card-title">Barcode</h4>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class=" row align-items-center">
                                                    <div class="form-group col-md-6">
                                                        <label>supplier Code</label>
                                                        <input type="text" class="form-control bg-white" value="${response.supplier.company_name }" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>supplier Barcode</label>
                                                    </div>
                                                </div>
                                                <!-- end: Show Data -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <div class="header-title">
                                                    <h4 class="card-title">Information supplier</h4>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="form-group row align-items-center">
                                                        <div class="profile-img-edit">
                                                            <div class="crm-profile-img-edit">
                                                                <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="${response.supplier.photo || 'asset(\'assets/images/supplier/default.webp\')'}" alt="profile-pic">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class=" row align-items-center">
                                                    <div class="form-group col-md-12">
                                                        <label>supplier Name</label>
                                                        <input type="text" class="form-control bg-white" value="${  response.supplier.company_name }" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Category</label>
                                                        <input type="text" class="form-control bg-white" value="${  response.supplier.email }" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Supplier</label>
                                                        <input type="text" class="form-control bg-white" value="${  response.supplier.phone }" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>supplier Garage</label>
                                                        <input type="text" class="form-control bg-white" value="${  response.supplier.address }" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>supplier Store</label>
                                                        <input type="text" class="form-control bg-white" value="${  response.supplier.note }" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page end  -->
                            </div>
                        `);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', status, error);
                        alert('An error occurred while processing the request.');
                    }
                });
            });
        });
    </script>
    

    <!-- Hidden Create supplier Form -->
    <div class="container z-3 position-fixed top-0" id="create" style="display: none;">
        @include('supplier.create')
    </div>
    <div class="container z-3 position-fixed top-0" id="edit" style="display: none;">
        @include('supplier.edit')
    </div>
</x-app-layout>