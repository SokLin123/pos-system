<div class="form col-md-6 col-12 mx-auto mt-3">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">New Employee</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{ route('employee.create') }}" enctype="multipart/form-data">
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
                                <label for="photo">Product Image</label>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" id="photo">
                                @error('photo')
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
                                <label for="name">Name</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
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
                            <div class="form-group">
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
                            <div class="form-group">
                                <label for="experience">Experience (years)</label>
                                <select class="form-control @error('experience') is-invalid @enderror" name="experience" id="experience" required>
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
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" name="position" id="position" required>
                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="salary">Salary</label>
                                <input type="number" class="form-control @error('salary') is-invalid @enderror" name="salary" id="salary" min="0" max="1000000" required>
                                @error('salary')
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
                            <button type="reset" class="cancel btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
