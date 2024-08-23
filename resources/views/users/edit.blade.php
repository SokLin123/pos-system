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
        $(document).on('click','#editcancel', function(){
            $('#editform').empty();
        });

        $(document).on('click', '.edit', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/user/edit/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#editform').empty();
                        $('#editform').append(`
                            <div class="form col-md-6 col-12 mx-auto mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Edit User</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-vertical" method="POST" action="/user/update/${response.user.id}" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="form-group row align-items-center">
                                                                <div class="profile-img-edit">
                                                                    <div class="crm-profile-img-edit">
                                                                        <img class="crm-profile-pic avatar-100 w-25" id="image-preview" src="/storage/users/${response.user.photo || 'assets/images/product/default.webp'}" alt="product-pic">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*" onchange="previewImage();">
                                                                <label class="custom-file-label" for="photo">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mt-3">
                                                            <div class="form-group has-icon-left">
                                                                <label for="name">Name</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="${response.user.name}" required>
                                                                    @error('name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mt-3">
                                                            <div class="form-group has-icon-left">
                                                                <label for="email">Email</label>
                                                                <div class="position-relative">
                                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="${response.user.email}" required>
                                                                    @error('email')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="password">Password</label>
                                                                <div class="position-relative">
                                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="${response.user.password}" required autocomplete="off">
                                                                    @error('password')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="password_confirmation">Confirm Password</label>
                                                                <div class="position-relative">
                                                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="${response.user.password}" required>
                                                                    @error('password_confirmation')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ __('Submit') }}
                                                            </button>
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
    });
</script>