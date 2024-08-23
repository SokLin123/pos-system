<script>
        $(document).on('click', '.edit', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/suppliers/show/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                    $('#edktform').empty();
                    $('#edktform').append(`
                        <div class=" col-md-6 col-12 mx-auto mt-3" id="editform">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Edit supplier</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical" method="POST" action="/supplier/update/${response.supplier.id}" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="form-group row align-items-center">
                                                                <div class="profile-img-edit">
                                                                    <div class="crm-profile-img-edit">
                                                                        <img class="crm-profile-pic avatar-100 w-25" id="image-preview" src="${response.supplier.photo || 'asset(\'assets/images/supplier/default.webp\')'}" alt="profile-pic">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input photo" id="photo" accept="image/*" onchange="previewImage();">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="company_name">Supplier Name</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" placeholder="supplier Name" id="company_name"  required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="email">Email</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" id="email"  required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="phone">Phone Number</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" id="phone" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="address">Address</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" id="address" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="note">Note</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" id="note" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary me-1 mb-1 update" data-id="" >Submit</button>
                                                            <button type="reset" class=" btn btn-light-secondary me-1 mb-1" id>Reset</button>
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

</script>


