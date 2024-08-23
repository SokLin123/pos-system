<x-app-layout>
    <section class="section">
        <div class="d-flex flex-wrap col-md-12 align-items-center justify-content-between px-4 mb-4">
            <h4 class="mb-3"><span><i class="far fa-file-alt fs-4 me-1"></i></span>Sale</h4>
            
        </div>
        <div class="card">
            <div class="d-flex col-md-12 flex-wrap align-items-center mt-2 py-3 px-4 justify-content-between">
                <div class="form-group col-md-4 row">
                    <h3><span><i class="far fa-file-alt fs-4 me-1"></i></span> Sale List </h3>
                </div>
                <div class="form-group col-md-3 row">
                    <div class="input-group col-md-12">
                        <input type="text" id="search" class="form-control h-100" name="search" placeholder="Search....">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-striped' id="datatable">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Invoice No</th>
                            <th>Reference</th>
                            <th>Sell Date</th>
                            <th>Payment</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $index => $sale)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $sale->invoice_no }}</td>
                            <td>{{ $sale->sell_date }}</td>
                            <td>{{ $sale->total_payment }}</td>
                            <td>{{ $sale->note }}</td>
                            <td>
                                @if ($supplier->status == 1 )
                                    <span class="badge rounded-pill bg-success">Paid</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <button class="btn icon btn-success me-2 edit" data-toggle="tooltip" data-placement="top" data-id="{{ $supplier->id }}" title="Edit">
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
        <div class="container z-3 position-fixed top-0" id="editform" style="z-index: 9999;"></div>
        <div class="container z-3 position-fixed top-0" id="showform" style="z-index: 9999;"></div>
    </section>

    <script>
        $(document).ready(function(){
            
            $(document).on('click','.delete',function(){
                var id = $(this).data('id');

                $.ajax({
                    url: 'sale/delete/'+id,
                    type: 'POST',
                    data: {
                        _token:'{{ csrf_token() }}'
                    }
                })
            });

            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#datatable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            $(document).on('click', '.cancel', function() {
                $('.form').hide();
            });

        });
    </script>
    
    <!-- Hidden Create supplier Form -->
    <div class="container z-3 position-fixed top-0" id="create" style="display: none;">
        @include('supplier.create')
    </div>
</x-app-layout>