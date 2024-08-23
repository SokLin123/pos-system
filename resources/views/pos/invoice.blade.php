
        <script>
            $(document).ready(function() {
                $('#buying').on('click', function() {
                    $.ajax({
                        url: '/pos/order',
                        type: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            $('#invoice').empty();
                            $('#invoice').append(`
                                <div class=" cotainer top-0 z-4 form h-auto pt-2" style="z-index: 9999; backdrop-filter: blur(10px);">
                                    <div class="card col-8 m-auto">
                                        <div class="card-body">
                                            <div class="container mb-5 mt-3">
                                            <div class="row d-flex align-items-baseline">
                                                <div class="col-md-8">
                                                    <p style="color: #7e8d9f;font-size: 20px;">Invoice >> <strong>ID: ${response.invoice_no}</strong></p>
                                                </div>
                                                <div class="col-md-4 d-flex float-end">
                                                    <a data-mdb-ripple-init class="btn btn-light d-flex justify-content-around bg-dark text-capitalize border-0" data-mdb-ripple-color="dark"><i
                                                        class="fas fa-print text-primary"></i> Print</a>
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xl-8">
                                                        <ul class="list-unstyled">
                                                        <li class="text-muted">To: <span style="color:#5d9fc5 ;">John Lorem</span></li>
                                                        <li class="text-muted">Street, City</li>
                                                        <li class="text-muted">State, Country</li>
                                                        <li class="text-muted"><i class="fas fa-phone"></i> 123-456-789</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <ul class="list-unstyled">
                                                            <li class="text-muted">Invoice</li>
                                                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                                                class="fw-bold">ID:</span>${response.invoice_no}</li>
                                                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                                                class="fw-bold">Creation Date: </span>${new Date().toLocaleDateString()}</li>
                                                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                                                class="me-1 fw-bold">Status:</span><span class="badge bg-warning text-black fw-bold">
                                                                Unpaid</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="row my-2 mx-1 justify-content-center">
                                                    <table class="table table-striped table-borderless"  style="height: 200px;">
                                                        <thead style="background-color:#84B0CA ;" class="text-white">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Description</th>
                                                                <th scope="col">Qty</th>
                                                                <th scope="col">Unit Price</th>
                                                                <th scope="col">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody> 
                                                            ${response.carts.map((cart, index) => `
                                                                <tr>
                                                                    <th scope="row">${index + 1}</th>
                                                                    <td>${cart.product_name}</td>
                                                                    <td>${cart.qty_store}</td>
                                                                    <td>$${cart.selling_price}</td>
                                                                    <td>$${cart.selling_price * cart.qty_store}</td>
                                                                </tr>
                                                            `).join('')}
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                <div class="col-md-6">
                                                    <p class="ms-3">Add additional notes and payment information</p>

                                                </div>
                                                <div class="col-md-5">
                                                    <ul class="list-unstyled">
                                                    <li class="text-muted ms-3"><span class="text-black me-4">SubTotal</span>$${response.subtotal}</li>
                                                    <li class="text-muted ms-3 mt-2"><span class="text-black me-4">Tax(15%)</span>$${response.total}</li>
                                                    <li class="text-muted ms-3 mt-2"><span class="text-black me-4">Discont</span>$${response.discount}</li>
                                                    </ul>
                                                    <p class="text-black float-start text-nowrap"><span class="text-black me-3"> Total Amount</span><span
                                                        style="font-size: 20px;">${response.total}</span></p>
                                                </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                <div class="col-md-8">
                                                    <a data-mdb-ripple-init class="btn btn-light w-25 d-flex justify-content-around bg-dark text-capitalize border-0" data-mdb-ripple-color="dark"><i
                                                        class="fas fa-print text-primary"></i> Print</a>
                                                </div>
                                                <div class="col-md-4">
                                                        <button type="reset" id="cancel" class="btn btn-danger me-1 mb-1">Reset</button>
                                                        <a  href="/pos/comfirm" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary text-capitalize"
                                                        style="width: 140px; background-color:#60bdf3 ;">Pay Now</a>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        }
                    });
                });
                $(document).on('click','#cancel', function(){
                    $('#invoice').empty();
                });
            });
        </script>