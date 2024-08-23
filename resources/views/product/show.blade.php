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
                url: '/products/show/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#showform').empty();
                    $('#showform').append(`
                        <div class="container form mt-4 mb-3 z-4 vh-100 backdrop-filter: blur(10px)">
                            <div class="row px-3">
                                <div class="col-lg-4 card-profile mb-5 h-50">
                                    <div class="card card-block card-stretch card-height mb-5">
                                        <div class="card-body">
                                            <div class="align-items-center mb-3">
                                                <div class="profile-img w-100 d-flex justofy-content-center position-relative">
                                                    <img  src="/storage/products/${response.product.product_image || 'assets/images/product/default.webp'}" class="img-fluid avatar-10 w-100 h-auto" " alt="profile-image">
                                                </div>
                                                <ul class="list-inline mt-3 w-100 ps-4 p-0 m-0">
                                                    <h4 class="mb-1">${  response.product.product_name }</h4>
                                                    <li class="mb-2">
                                                        <div class="d-flex align-items-center">
                                                            
                                                            <p class="mb-0">${  response.product.category.name }</p>
                                                        </div>
                                                    </li>
                                                    <li class="mb-2">
                                                        <div class="d-flex align-items-center">
                                                            
                                                            <p class="mb-0">${  response.product.selling_price }</p>
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
                                                <h4 class="card-title">Product Information</h4>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <ul class="list-inline p-0 mb-0">
                                                <li class="col-lg-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-3 col-4">
                                                            <label class="col-form-label">Product Name</label>
                                                        </div>
                                                        <div class="col-sm-9 col-8">
                                                            <input type="text" class="form-control border-0 bg-white" value="${response.product.product_name}" readonly>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="col-lg-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-3 col-4">
                                                            <label class="col-form-label">Category</label>
                                                        </div>
                                                        <div class="col-sm-9 col-8">
                                                            <input type="text" class="form-control bg-white" value="${response.product.category.name}" readonly>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="col-lg-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-3 col-4">
                                                            <label class="col-form-label">Supplier</label>
                                                        </div>
                                                        <div class="col-sm-9 col-8">
                                                            <input type="text" class="form-control bg-white" value="${  response.product.supplier.company_name }" readonly>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="col-lg-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-3 col-4">
                                                            <label class="col-form-label">Garages</label>
                                                        </div>
                                                        <div class="col-sm-9 col-8">
                                                            <input type="text" class="form-control bg-white" value="${  response.product.garage.name }" readonly>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="col-lg-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-3 col-4">
                                                            <label class="col-form-label">Product Store</label>
                                                        </div>
                                                        <div class="col-sm-9 col-8">
                                                            <input type="text" class="form-control bg-white" value="${  response.product.qty_store  }" readonly>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="col-lg-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-3 col-4">
                                                            <label class="col-form-label">Expire Date</label>
                                                        </div>
                                                        <div class="col-sm-9 col-8">
                                                            <input type="text" class="form-control bg-white" value="${ response.product.expire_date }" readonly>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="col-lg-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-3 col-4">
                                                            <label class="col-form-label">Buying Price</label>
                                                        </div>
                                                        <div class="col-sm-9 col-8">
                                                            <input type="text" class="form-control bg-white" value="${ response.product.buying_price }" readonly>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="col-lg-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-3 col-4">
                                                            <label class="col-form-label">Selling Price</label>
                                                        </div>
                                                        <div class="col-sm-9 col-8">
                                                            <input type="text" class="form-control bg-white" value="${ response.product.selling_price }" readonly>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            
                                            <div class="ml-3 d-flex">
                                                <button class="btn btn-success me-2 edit" data-toggle="tooltip" data-placement="top" data-id="${response.product.id}" title="Edit">Edit</button>
                                                <button type="reset" id="showcancel" class="btn btn-danger me-1">Reset</button>
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