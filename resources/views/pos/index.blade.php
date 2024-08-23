<x-app-layout>
    <section class="section p-3">
        <div class="col-md-8">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3>Point of Sale</h3>
                    <p class="text-subtitle text-muted">.</p>
                </div>
                <div class="col-md-6">
                    <nav  class="text-end">
                        <ol class="d-flex breadcrumb">
                            <li class=""><a href="index.html">Dashboard</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
                
        <section class="container pos-container rounded bg-light">
            <div class="w-100 mb-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="customer" class="form-label">Customer</label>
                            <select id="customer"  class="input py-2">
                                <option> Costomer</option>
                                @foreach($customers as $customer)
                                    <option  value="{{$customer->id}}">{{$customer->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="barcode" class="form-label">Enter Product Code</label>
                            <input type="text" class="form-control input" name="barcode" placeholder="Enter Product Code" id="barcode">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="qty" class="form-label">Enter Quantity</label>
                            <input type="number" class="form-control input" name="fqty" id="fqty">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" id="addcart" class="button" style="width: 20%;">Add</button>
                </div>  
                <script>
                        $(document).ready(function() {

                            // Event listener for adding to cart
                            $('#addcart').click(function() {
                                var barcode = $('#barcode').val();
                                var qty = $('#fqty').val();

                                $.ajax({
                                    url: '/pos/cart/add',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        barcode: barcode,
                                        qty: qty
                                    },
                                    success: function(response) {
                                        $('#product').empty();
                                        response.carts.forEach(function(cart) {
                                            var sale_amount=(cart.selling_price - (cart.selling_price * 0.5)) * cart.qty_store;
                                            $('#product').append(`
                                                <tr>
                                                    <td class="d-flex align-items-center justify-content-center">
                                                        <img class="avatar-60 w-auto" style="height: 40px;" src="/storage/products/${cart.product_image}" alt="Product Image">
                                                        <span class="ms-3">${cart.product_name}</span>
                                                    </td>
                                                    <td class="align-items-center text-center">
                                                        <input type="text" class="border-none" style="width:40px" name="qty" value="${cart.qty_store}" id="qty-${cart.id}">
                                                    </td>
                                                    <td class="align-items-center text-center"><span>$${cart.selling_price}</span></td>
                                                    <td class="align-items-center text-center"><span>${cart.discount}%</span></td>
                                                    <td class="align-items-center text-center"><span>$${sale_amount}</span></td>
                                                    <td class="align-items-center justify-content-center">
                                                        <button type="button" class="btn icon btn-primary me-1 bg-danger increment" data-id="${cart.id}"><i class="fa-solid fa-plus"></i></button>
                                                        <button type="button" class="btn icon btn-primary me-1 bg-success decrement" data-id="${cart.id}"><i class="fa-solid fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                            `);
                                        });

                                        // Update the summary fields
                                        $('#subtotal').val("$" + parseFloat(response.subtotal).toFixed(2));
                                        $('#tax').val("$" + parseFloat(response.tax).toFixed(2));
                                        $('#discount').val("$" + parseFloat(response.discount).toFixed(2));
                                        $('#total').val("$" + parseFloat(response.total).toFixed(2));

                                        // Clear the input fields
                                        $('#barcode').val('');
                                        $('#fqty').val('');
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('AJAX Error:', status, error);
                                        alert('An error occurred while processing the request.');
                                    }
                                });
                            });
                        });
                    </script>
            </div>
            <div class="w-100">
                <div class="pos-container">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap border-1 pos-container-table rounded " style="height: 200px;">
                                <thead>
                                    <tr class="text-center">
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Sale Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="pos-container-cart" id="product">  
                                    @foreach ($carts as $cart)
                                    <tr>
                                        <td class="d-flex align-items-center justify-content-center">
                                            <img class="avatar-60 w-auto" style="height: 40px;" src="{{ $cart->product_image ? asset('storage/products/'.$cart->product_image) : asset('assets/images/product/default.webp') }}" alt="Product Image">
                                            <span class="ms-3">{{$cart->product_name}}</span>
                                        </td>
                                        <td class="align-items-center text-center">
                                            <input type="text" class="border-none" style="width:40px" name="qty" value="{{$cart->qty_store}}" id="qty-{{$cart->id}}">
                                        </td>
                                        <td class="align-items-center text-center"><span>${{ $cart->selling_price }}</span></td>
                                        <td class="align-items-center text-center"><span>%{{ $cart->discount }}</span></td>
                                        <td class="align-items-center text-center"><span id="sale_amount">${{ ($cart->selling_price - ($cart->selling_price * 0.5)) * $cart->qty_store }}</span></td>
                                        <td class="align-items-center justify-content-center">
                                            <button type="button" class="btn icon btn-primary me-1 bg-danger increment" data-id="{{$cart->id}}"><i class="fa-solid fa-plus"></i></button>
                                            <button type="button" class="btn icon btn-primary me-1 bg-success decrement" data-id="{{$cart->id}}"><i class="fa-solid fa-minus"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <script>
                                $(document).ready(function() {
                                    $(document).on('change', 'input[name="qty"]', function() {
                                        var id = $(this).attr('id').split('-')[1];
                                        var qty = $(this).val();

                                        $.ajax({
                                            url: '/pos/cart/update/' + id,
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                qty: qty
                                            },
                                            success: function(response) {
                                                if (response.cart.qty_store > 0) {
                                                    var sale_amount=(response.cart.selling_price - (response.cart.selling_price * 0.5)) * response.cart.qty_store;
                                                    $('#qty-' + id).val(response.cart.qty_store);
                                                    $('#subtotal').val("$"+response.subtotal);
                                                    $('#tax').val("$"+response.tax);
                                                    $('#discount').val("$"+response.discount);
                                                    $('#total').val("$"+response.total);
                                                    $('#sale_amount').text("$"+sale_amount);
                                                } else {
                                                    location.reload(); 
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('AJAX Error: ', status, error);
                                                alert('An error occurred while processing the request.');
                                            }
                                        });
                                    });

                                    // Handle increment
                                    $(document).on('click', '.increment', function() {
                                        var id = $(this).data('id');

                                        $.ajax({
                                            url: '/pos/cart/increment/' + id,
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}'
                                            },
                                            success: function(response) {
                                                    var sale_amount=(response.cart.selling_price - (response.cart.selling_price * 0.5)) * response.cart.qty_store;
                                                    $('#qty-' + id).val(response.cart.qty_store);
                                                    $('#subtotal').val("$"+response.subtotal);
                                                    $('#tax').val("$"+response.tax);
                                                    $('#discount').val("$"+response.discount);
                                                    $('#total').val("$"+response.total);
                                                    $('#sale_amount').text("$"+sale_amount);
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('AJAX Error: ', status, error);
                                                alert('An error occurred while processing the request.');
                                            }
                                        });
                                    });

                                    // Handle decrement
                                    $(document).on('click', '.decrement', function() {
                                            var id = $(this).data('id');

                                            $.ajax({
                                                url: '/pos/cart/decrement/' + id,
                                                type: 'POST',
                                                data: {
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                success: function(response) {
                                                    // If the cart item exists and its quantity is greater than 0
                                                    if (response.cart && response.cart.qty_store > 0) {
                                                        var sale_amount = (response.cart.selling_price - (response.cart.selling_price * 0.10)) * response.cart.qty_store;
                                                        $('#qty-' + id).val(response.cart.qty_store);
                                                        $('#subtotal').val("$"+response.subtotal);
                                                        $('#tax').val("$"+response.tax);
                                                        $('#discount').val("$"+response.discount);
                                                        $('#total').val("$"+response.total);
                                                        $('#sale_amount').text("$"+sale_amount);
                                                    } else {
                                                        // If the cart item is removed or quantity is 0, repopulate the product list
                                                        $('#product').empty();
                                                        response.carts.forEach(function(cart) {
                                                            var sale_amount=(cart.selling_price - (cart.selling_price * 0.5)) * cart.qty_store;
                                                            $('#product').append(`
                                                                <tr>
                                                                    <td class="d-flex align-items-center justify-content-center">
                                                                        <img class="avatar-60 w-auto" style="height: 40px;" src="/storage/products/${cart.product_image}" alt="Product Image">
                                                                        <span class="ms-3">${cart.product_name}</span>
                                                                    </td>
                                                                    <td class="align-items-center text-center">
                                                                        <input type="text" class="border-none" style="width:40px" name="qty" value="${cart.qty_store}" id="qty-${cart.id}">
                                                                    </td>
                                                                    <td class="align-items-center text-center"><span>${cart.selling_price}</span></td>
                                                                    <td class="align-items-center text-center"><span>${cart.discount}%</span></td>
                                                                    <td class="align-items-center text-center"><span>${sale_amount}</span></td>
                                                                    <td class="align-items-center justify-content-center">
                                                                        <button type="button" class="btn icon btn-primary me-1 bg-danger increment" data-id="${cart.id}"><i class="fa-solid fa-plus"></i></button>
                                                                        <button type="button" class="btn icon btn-primary me-1 bg-success decrement" data-id="${cart.id}"><i class="fa-solid fa-minus"></i></button>
                                                                    </td>
                                                                </tr>
                                                            `);
                                                        });
                                                        $('#subtotal').val(response.subtotal);
                                                        $('#tax').val(response.tax);
                                                        $('#discount').val(response.discount);
                                                        $('#total').val(response.total);
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('AJAX Error: ', status, error);
                                                    alert('An error occurred while processing the request.');
                                                }
                                            });
                                        });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-around">
                <div class="col-2 fw-light">
                    <h5>Subtotal</h5>
                    <span>
                        <input type="text" class="text-start fw-light w-100 shadow-border px-3" name="subtotal" value="{{ number_format($subtotal, 2) }}" id="subtotal">
                    </span>
                </div>
                <div class="col-2 fw-light">
                    <h5>Discount</h5>
                    <span>
                        <input type="text" class="text-start fw-light w-100 shadow-border px-3" name="discount" value="{{ number_format($discount, 2) }}" id="discount">
                    </span>
                </div>
                <div class="col-2 fw-light">
                    <h5>Tax</h5>
                    <span>
                        <input type="text" class="text-start fw-light w-100 shadow-border px-3" name="tax" value="{{ number_format($tax, 2) }}" id="tax">
                    </span>
                </div>
                <div class="col-2 fw-light">
                    <h5>Total</h5>
                    <span>
                        <input type="text" class="text-start fw-light w-100 shadow-border px-3" name="total" value="{{ number_format($total, 2) }}" id="total">
                    </span>
                </div>
            </div>
            <div class="container d-flex justify-content-end px-1 pe-3 mt-3">
                <div class="col-3">
                    <a href="{{ route('destroy.order') }}" class="btn btn-danger ms-4">Cancel</a>
                    <button id="buying" class="btn btn-success w-50">Buying</button>
                </div>
            </div>
        </section>
        <div class="container z-3 position-fixed top-0" id="invoice" style="z-index: 9999;">
            @include('pos.invoice')
        </div>
    </section>
</x-app-layout>