<x-app-layout>
    <section class="section container">
        <div class="d-flex flex-wrap col-md-12 align-items-center justify-content-between px-4 mb-4">
            <h4 class="mb-3">Employee List</h4>
            <div>
                <button class="btn btn-primary icon add-list" id="toggleButton" data-original-title="Add employee">
                    <i class="fa-solid fa-plus mr-3"></i>
                </button>
            </div>
        </div>
        <div class="card">
            <div class="d-flex col-md-12 flex-wrap align-items-center mt-2 py-3 px-4 justify-content-between">
                <div class="form-group col-md-4 row">
                    <h3> Employee List </h3>
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
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Position</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $index => $employee)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td class="d-flex justify-content-center">
                                <img class="avatar-60 w-auto" style="height:100px" src=" {{ $employee->photo ? asset('storage/employee/'.$employee->photo) : asset('assets/images/employee/default.webp') }}" alt="employee Image">
                            </td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>${{ $employee->salary }}</td>
                            <td>
                                @if ($employee->status == 1 )
                                    <span class="badge rounded-pill bg-success">Valid</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">Invalid</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <button class="btn icon btn-info me-2 show" data-toggle="tooltip" data-placement="top" data-id="{{ $employee->id }}" title="View">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    <button class="btn icon btn-success me-2 edit" data-toggle="tooltip" data-placement="top" data-id="{{ $employee->id }}" title="Edit">
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
        <div class="container z-3 position-fixed top-0" id="editform" style="z-index: 9999;"></div>
        <div class="container z-3 position-fixed top-0" id="showform" style="z-index: 9999;"></div>
    </section>

    <script>
        $(document).ready(function(){
            
            $(document).on('click','.delete',function(){
                var id = $(this).data('id');

                $.ajax({
                    url: 'employees/delete/'+id,
                    type: 'POST',
                    data: {
                        _token:'{{ csrf_token() }}'
                    }
                })
            });

            $('#toggleButton').click(function(){
                $('#create').toggle();
            });

            $('#showp').click(function(){
                $('#show').toggle();
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

            
            $(document).on('change','.photo', function(event){
                                        var input = event.target;
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            
                                            reader.onload = function(e) {
                                                $('#image-preview').attr('src', e.target.result).show();
                                            } 
                                            reader.readAsDataURL(input.files[0]); 
                                        }
                                    });

            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/employees/edit/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#editform').empty();
                        $('#editform').append(`
                            <div class=" form col-md-6 col-12 mx-auto mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Edit employee</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-vertical" method="POST" action="/employees/update/${response.employee.id}" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="form-group row align-items-center">
                                                                <div class="profile-img-edit">
                                                                    <div class="crm-profile-img-edit">
                                                                        <img class="crm-profile-pic avatar-100 w-25" id="image-preview" src="/storage/employee/${response.employee.photo || 'assets/images/product/default.webp'}" alt="profile-pic">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input photo" name="photo" accept="image/*" onchange="previewImage();">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="company_name">employee Name</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" placeholder="employee Name" id="name" name="name" value="${response.employee.name}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="email">Email</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" name="email" id="email" value="${response.employee.email}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="phone">Phone Number</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" name="phone" id="phone" value="${response.employee.phone}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="address">Address</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" name="address" id="address" value="${response.employee.address}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="experience">Experience (years)</label>
                                                                <select class="form-control @error('experience') is-invalid @enderror" name="experience" id="experience" required>
                                                                    <option value="${response.employee.experience}">${response.employee.experience} year</option>
                                                                    <option value="1" {{ old('experience') == 1 ? 'selected' : '' }}>1 year</option>
                                                                    <option value="2" {{ old('experience') == 2 ? 'selected' : '' }}>2 years</option>
                                                                    <option value="3" {{ old('experience') == 3 ? 'selected' : '' }}>3 years</option>
                                                                    <option value="4" {{ old('experience') == 4 ? 'selected' : '' }}>4 years</option>
                                                                    <option value="5" {{ old('experience') == 5 ? 'selected' : '' }}>5 years</option>
                                                                </select>
                                                                @error('experience')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="note">Note</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" name="position" id="position" value="${response.employee.position}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="note">Note</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" name="salary" id="salary" value="${response.employee.salary}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                                            <button type="reset" class="cancel btn btn-light-secondary me-1 mb-1">Reset</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', status, error);
                        alert('An error occurred while processing the request.');
                    }
                });
            });

            $(document).on('click', '.show', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/employees/show/' + id,
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
                                                        <label>employee Code</label>
                                                        <input type="text" class="form-control bg-white" value="${response.employee.company_name }" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>employee Barcode</label>
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
                                                    <h4 class="card-title">Information employee</h4>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="form-group row align-items-center">
                                                        <div class="profile-img-edit">
                                                            <div class="crm-profile-img-edit">
                                                                <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="${response.employee.photo || 'asset(\'assets/images/employee/default.webp\')'}" alt="profile-pic">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class=" row align-items-center">
                                                    <div class="form-group col-md-12">
                                                        <label>employee Name</label>
                                                        <input type="text" class="form-control bg-white" value="${  response.employee.company_name }" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Category</label>
                                                        <input type="text" class="form-control bg-white" value="${  response.employee.email }" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>employee</label>
                                                        <input type="text" class="form-control bg-white" value="${  response.employee.phone }" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>employee Garage</label>
                                                        <input type="text" class="form-control bg-white" value="${  response.employee.address }" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>employee Store</label>
                                                        <input type="text" class="form-control bg-white" value="${  response.employee.note }" readonly>
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
    

    <!-- Hidden Create employee Form -->
    <div class="container z-3 position-fixed top-0" id="create" style="display: none;">
        @include('employee.create')
    </div>
</x-app-layout>