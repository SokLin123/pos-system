<x-app-layout>
    <section class="section">
        <div class="d-flex flex-wrap col-md-12 align-items-center justify-content-between px-4 mb-4">
            <h4 class="mb-3">Units List</h4>
            <div>
                <button class="btn btn-primary icon add-list" id="toggleButton" data-original-title="Add unit">
                    <i class="fa-solid fa-plus mr-3"></i>
                </button>
            </div>
        </div>
        <div class="card">
            <div class="d-flex col-md-12 flex-wrap align-items-center mt-2 py-3 px-4 justify-content-between">
                <div class="form-group col-md-4 row">
                    <h3> Units List </h3>
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
                            <th>Name</th>
                            <th>Abbreviation</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($units as $index => $unit)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->abbreviation }}</td>
                            <td>{{ $unit->note }}</td>
                            <td class="d-flex justify-content-center">
                                <div class="d-flex align-items-center list-action">
                                    <button class="btn icon btn-success me-2 edit" data-toggle="tooltip" data-placement="top" data-id="{{ $unit->id }}" title="Edit">
                                        <i class="nav-icon fas fa-edit"></i>
                                    </button>
                                    <button type="submit" class="btn btn-danger icon me-2" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="ri-delete-bin-line mr-0"></i>
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
        <div class="container z-3 position-fixed top-0" id="editform" style="z-index: 9999;"></div>
    </section>

    <!-- Toggle Button Script -->
    <script>
        $(document).ready(function(){
            $('#toggleButton').click(function(){
                $('#create').toggle(); // Toggles visibility of the layout
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

            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/units/edit/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#editform').empty();
                        $('#editform').append(`
                            <div class=" form col-md-6 col-12 mx-auto mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Edit unit</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-vertical" method="POST" action="/units/update/${response.unit.id}" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="form-body">
                                                    <div class="row">
                                                        
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="unit_name">unit Name</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" placeholder="unit Name" name="unit_name" value="${response.unit.name}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="expire_date">Expire Date</label>
                                                                <div class="position-relative">
                                                                    <input type="date" class="form-control" name="expire_date" value="${response.unit.abbreviation}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group has-icon-left">
                                                                <label for="buying_price">Buying Price</label>
                                                                <div class="position-relative">
                                                                    <input type="number" step="0.01" class="form-control" name="buying_price" value="${response.unit.node}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                                            <button type="reset" class="cancel btn btn-light-secondary me-1 mb-1">Reset</button>
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
    

    <!-- Hidden Create unit Form -->
    <div class="container z-3 position-fixed top-0" id="create" style="display: none;">
        @include('unit.create')
    </div>
</x-app-layout>