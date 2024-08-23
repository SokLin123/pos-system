<script>
    $(document).ready(function(){
        $(document).on('change','.product_image', function(event){
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#image-preview').attr('src', e.target.result).show();
                    } 
                    reader.readAsDataURL(input.files[0]); 
                }
            });
        $(document).on('click','#showcancel', function(){
            $('#showform').empty();
        });

        $(document).on('click', '.show', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/users/show/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#showform').empty();
                        $('#showform').append(`
                            <div class="container form mt-4 mb-3">
                                <div class="row px-3">
                                    <div class="col-lg-4 card-profile mb-5 h-50">
                                        <div class="card card-block card-stretch card-height mb-5">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="profile-img w-50 d-flex justofy-content-center position-relative">
                                                        <img  src="/storage/users/${response.user.photo || 'assets/images/product/default.webp'}" class="img-fluid avatar-10 h-auto" style="width:80px;" alt="profile-image">
                                                    </div>
                                                    <ul class="list-inline w-50 p-0 m-0">
                                                        <h4 class="mb-1">${response.user.name}</h4>
                                                        <li class="mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <svg class="svg-icon mr-3" height="16" width="16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                </svg>
                                                                <p class="mb-0">${response.user.email}</p>
                                                            </div>
                                                        </li>
                                                        <li class="mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <svg class="svg-icon mr-3" height="16" width="16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                                </svg>
                                                                <p class="mb-0">admin</p>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 card-profile">
                                        <div class="card card-block card-stretch mb-0">
                                            <div class="card-header px-3">
                                                <div class="header-title">
                                                    <h4 class="card-title">Supplier Information</h4>
                                                </div>
                                            </div>
                                            <div class="card-body p-3">
                                                <ul class="list-inline p-0 mb-0">
                                                    <li class="col-lg-12">
                                                        <div class="form-group row">
                                                            <div class="col-sm-3 col-4">
                                                                <label class="col-form-label">Name</label>
                                                            </div>
                                                            <div class="col-sm-9 col-8">
                                                                <input type="text" class="form-control bg-white" value="${response.user.name}" readonly>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="col-lg-12">
                                                        <div class="form-group row">
                                                            <div class="col-sm-3 col-4">
                                                                <label class="col-form-label">Email</label>
                                                            </div>
                                                            <div class="col-sm-9 col-8">
                                                                <input type="text" class="form-control bg-white" value="${response.user.email}" readonly>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="col-lg-12">
                                                        <div class="form-group row">
                                                            <div class="col-sm-3 col-4">
                                                                <label class="col-form-label">Role</label>
                                                            </div>
                                                            <div class="col-sm-9 col-8">
                                                                <input type="text" class="form-control bg-white" value="admin" readonly>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                
                                                <div class="ml-3 d-flex">
                                                    <button class="btn btn-success me-2 edit" data-toggle="tooltip" data-placement="top" data-id="${response.user.id}" title="Edit">Edit</button>
                                                    <button type="reset" class="cancel btn btn-danger me-1">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end: Right Detail Employee -->
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
    });
</script>