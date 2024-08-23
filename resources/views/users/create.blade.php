
<script>
        $(document).ready(function(){

            $('#create').click(function(){
                $('#createform').toggle(); // Toggles visibility of the layout
            });

            $('#createcancel').click(function(){
                $('#createform').toggle(); // Toggles visibility of the layout
            });

            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#datatable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
</script>
<div class="form col-md-6 col-12 mx-auto mt-3">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">New User</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{ route('user.create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row align-items-center">
                                <div class="profile-img-edit">
                                    <div class="crm-profile-img-edit">
                                        <img class="crm-profile-pic avatar-100 w-25" id="image-preview" src="{{ asset('assets/images/product/default.webp') }}" alt="profile-pic">
                                    </div>
                                </div>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*" onchange="previewImage();">
                                <label class="custom-file-label" for="photo">Choose file</label>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-group has-icon-left">
                                <label for="name">Name</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group has-icon-left">
                                <label for="email">Email</label>
                                <div class="position-relative">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group has-icon-left">
                                <label for="password">Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="off">
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
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
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
                            <button type="reset"  id="createcancel" class="cancel btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage() {
        const file = document.getElementById('photo').files[0];
        const preview = document.getElementById('image-preview');

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>