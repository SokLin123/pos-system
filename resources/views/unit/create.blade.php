<div class="form col-md-6 col-12 mx-auto mt-3">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">New unit</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
            <form method="POST" action="{{ route('units.create') }}" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="unit_name">Unit Name</label>
                                    <div class="position-relative">
                                    <input type="text" class="form-control @error('unit_name') is-invalid @enderror" name="unit_name" required autofocus>
                                        @error('unit_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="abbreviation">Abbreviation</label>
                                    <input type="text" class="form-control @error('abbreviation') is-invalid @enderror" name="abbreviation"  required>
                                        @error('abbreviation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="note">Note</label>
                                    <textarea name="note" class="form-control @error('node') is-invalid @enderror" rows="4" cols="50"></textarea>
                                    @error('node')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
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
