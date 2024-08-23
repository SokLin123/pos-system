
    <!-- Toggle Button Script -->
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
            <h4 class="card-title">New Product</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
            <form method="POST" action="{{ route('products.create') }}" enctype="multipart/form-data">
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
                                        <input type="file" class="form-control @error('product_image') is-invalid @enderror" name="product_image" id="product_image">
                                        @error('product_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <script>
                                $(document).ready(function(){
                                    $('#product_image').change(function(event){
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
                                    <label for="product_name">Product Name</label>
                                    <div class="position-relative">
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" id="product_name" value="{{ old('product_name') }}" required autofocus>
                                        @error('product_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="category_id" required>
                                        <option value="" disabled selected>-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                                    <select class="form-control @error('supplier_id') is-invalid @enderror" name="supplier_id" id="supplier_id" required>
                                        <option value="" disabled selected>-- Select Supplier --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="garages_id">Product Garage <span class="text-danger">*</span></label>
                                    <select class="form-control @error('garage_id') is-invalid @enderror" name="garage_id" id="garage_id" required>
                                        <option value="" disabled selected>-- Select Garage --</option>
                                        @foreach($garages as $garage)
                                            <option value="{{ $garage->id }}">{{ $garage->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('garage_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="unit_id">Product Unit <span class="text-danger">*</span></label>
                                    <select class="form-control @error('unit_id') is-invalid @enderror" name="unit_id" id="unit_id" required>
                                        <option value="" disabled selected>-- Select Unit --</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="expire_date">Expire Date</label>
                                    <input type="date" class="form-control @error('expire_date') is-invalid @enderror" name="expire_date" id="expire_date" required>
                                    @error('expire_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="buying_price">Buying Price</label>
                                    <input type="number" step="0.01" class="form-control @error('buying_price') is-invalid @enderror" name="buying_price" id="buying_price" required>
                                    @error('buying_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="selling_price">Selling Price</label>
                                    <input type="number" step="0.01" class="form-control @error('selling_price') is-invalid @enderror" name="selling_price" id="selling_price" required>
                                    @error('selling_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">
                                    {{ __('Submit') }}
                                </button>
                                <button type="reset" id="createcancel" class=" btn btn-danger me-1 ">Reset</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
