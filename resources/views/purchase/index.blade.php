<x-app-layout>
    <section class="section">
        <div class="d-flex flex-wrap col-md-12 align-items-center justify-content-between px-4 mb-4 mt-2">
            <h4 class="mb-3"><span></span>Purchases</h4>
            <div>
                <button class="btn btn-primary icon add-list" type="button" id="create" data-original-title="Add Purchase">
                    <i class="fa-solid fa-plus mr-3 me-1"></i>Add Purchase
                </button>
            </div>
        </div>
        <div class="card">
            <div class="d-flex col-md-12 flex-wrap align-items-center mt-2 py-3 px-4 justify-content-between">
                <div class="form-group col-md-4 row">
                    <h3><span><i class="far fa-file-alt fs-4 me-1"></i></span> Purchases List </h3>
                </div>
                <div class="form-group col-md-3 row">
                    <div class="input-group col-md-12">
                        <input type="text" id="search" class="form-control h-100" name="search" placeholder="Search....">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-head-fixed text-nowrap' id="datatable">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Invoice No</th>
                            <th>Reference</th>
                            <th>Purchase Date</th>
                            <th>Payment</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchases as $index => $purchase)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $purchase->invoice_no }}</td>
                            <td>{{ $purchase->sell_date }}</td>
                            <td>{{ $purchase->total_payment }}</td>
                            <td>{{ $purchase->note }}</td>
                            <td>
                                @if ($purchase->status == 1 )
                                    <span class="badge rounded-pill bg-success">Paid</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <button class="btn icon btn-success me-2 edit" data-toggle="tooltip" data-placement="top" data-id="{{ $purchase->id }}" title="Edit">
                                        <i class="nav-icon fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-danger">Data not Found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function(){

            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#datatable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
            $('#create').click(function(){
                $('#createform').toggle(); // Toggles visibility of the layout
            });

            $('#createcancel').click(function(){
                $('#createform').toggle(); // Toggles visibility of the layout
            });

        });
    </script>
    
        <div class="container z-3 position-fixed top-10" id="createform" style="display: none; z-index: 999; backdrop-filter: blur(10px);">
            @include('purchase.add')
        </div>
</x-app-layout>