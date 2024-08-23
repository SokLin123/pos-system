<x-app-layout>
    <section class="section">
        <div class="d-flex flex-wrap col-md-12 align-items-center justify-content-start px-4 mb-4">
            <h4 class="mb-3">Products List</h4>
        </div>
        <div class="card">
            <div class="d-flex col-md-12 flex-wrap align-items-center mt-2 py-3 px-4 justify-content-between">
                <div class="form-group col-md-4 row">
                    <h3> Products List </h3>
                </div>
                <div class="form-group col-md-3 row">
                    <div class="input-group col-md-12">
                        <input type="text" id="search" class="form-control h-100" name="search" placeholder="Search....">
                    </div>
                </div>
            </div>
            <div class="card-body" >
                <table class='table table-striped w-100 overflow-x-scroll' id="datatable">
                <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Invoice</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Order Date</th>
                            <th>Locatioin</th>
                            <th>Payment</th>
                            <th>Delevery</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $index => $order)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $order->invoice_no }}</td>
                            <td>{{ $order->customers->company_name }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>{{ $order->locatioin }}</td>
                            <td>${{ $order->delevery }}</td>
                            <td>${{ $order->salary }}</td>
                            <td>
                                @if ($order->status == 1 )
                                    <span class="badge rounded-pill bg-success">Success</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">Invalid</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <button class="btn icon btn-info me-2 show" data-toggle="tooltip" data-placement="top" data-id="{{ $order->id }}" title="View">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    <button class="btn icon btn-success me-2 edit" data-toggle="tooltip" data-placement="top" data-id="{{ $order->id }}" title="Edit">
                                        <i class="nav-icon fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger icon me-2 delete" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="ri-delete-bin-line mr-0"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-danger">Data not Found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>