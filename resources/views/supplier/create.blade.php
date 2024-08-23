<div class=" col-md-6 col-12 mx-auto mt-3" id="createform">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">New Product</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
            <form method="POST" action="{{ route('supplier.create') }}" enctype="multipart/form-data">
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
                                <div class="form-group">
                                        <label for="product_image">Product Image</label>
                                        <input type="file" class="form-control @error('product_image') is-invalid @enderror" name="photo" id="photo">
                                        @error('product_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <script>
                                $(document).ready(function(){
                                    $('#photo').change(function(event){
                                        var input = event.target;
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            
                                            reader.onload = function(e) {
                                                $('#image-preview').attr('src', e.target.result).show();
                                            } 
                                            reader.readAsDataURL(input.files[0]); 
                                        }
                                    });
                                });
                            </script>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="company_name">Name</label>
                                    <div class="position-relative">
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" id="company_name" value="{{ old('company_name') }}" required autofocus>
                                        @error('company_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" required>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" required>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="note">Note</label>
                                    <input type="text" class="form-control @error('note') is-invalid @enderror" name="note" id="note" required>
                                    @error('note')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                                <button type="reset" id="createcancel" class=" btn btn-light-secondary me-1 mb-1">Reset</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
