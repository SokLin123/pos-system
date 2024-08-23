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
                url: '/products/edit/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#editform').empty();
                    $('#editform').append(`
                        <div id="editform" class=" col-md-6 col-12 mx-auto mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Edit Product</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical" method="POST" action="/products/update/${response.product.id}" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group row align-items-center">
                                                            <div class="profile-img-edit">
                                                                <div class="crm-profile-img-edit">
                                                                    <img class="crm-profile-pic avatar-100 w-25" id="image-preview" src="/storage/products/${response.product.product_image || 'assets/images/product/default.webp'}"  alt="profile-pic">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input product_image" name="product_image" accept="image/*" onchange="previewImage();">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group has-icon-left">
                                                            <label for="product_name">Product Name</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" placeholder="Product Name" name="product_name" value="${response.product.product_name}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group has-icon-left">
                                                            <label for="category_id">Category <span class="text-danger">*</span></label>
                                                            <select class="form-control" name="category_id" required>
                                                                <option value="${response.product.category.id}">${response.product.category.name}</option>
                                                                ${response.categories.map(category => `<option value="${category.id}">${category.name}</option>`).join('')}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group has-icon-left">
                                                            <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                                                            <select class="form-control" name="supplier_id" required>
                                                                <option value="${response.product.supplier.id}">${response.product.supplier.company_name}</option>
                                                                ${response.suppliers.map(supplier => `<option value="${supplier.id}">${supplier.company_name}</option>`).join('')}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group has-icon-left">
                                                            <label for="garage_id">Garage <span class="text-danger">*</span></label>
                                                            <select class="form-control" name="garage_id" required>
                                                                <option value="${response.product.garage.id}">${response.product.garage.name}</option>
                                                                ${response.garages.map(garage => `<option value="${garage.id}">${garage.name}</option>`).join('')}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group ">
                                                            <label for="unit_id">Product Unit <span class="text-danger">*</span></label>
                                                            <select class="form-control" name="unit_id" required>
                                                                <option value="${response.product.units.id}">${response.product.units.name}</option>
                                                                ${response.units.map(unit => `<option value="${unit.id}">${unit.name}</option>`).join('')}
                                                            </select>   
                                                            @error('unit_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group has-icon-left">
                                                            <label for="expire_date">Expire Date</label>
                                                            <div class="position-relative">
                                                                <input type="date" class="form-control" name="expire_date" value="${response.product.expire_date}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group has-icon-left">
                                                            <label for="buying_price">Buying Price</label>
                                                            <div class="position-relative">
                                                                <input type="number" step="0.01" class="form-control" name="buying_price" value="${response.product.buying_price}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group has-icon-left">
                                                            <label for="selling_price">Selling Price</label>
                                                            <div class="position-relative">
                                                                <input type="number" step="0.01" class="form-control" name="selling_price" value="${response.product.selling_price}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-success me-1 mb-1">Submit</button>
                                                        <button type="reset" id="editcancel" class="btn btn-danger me-1 mb-1">Reset</button>
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