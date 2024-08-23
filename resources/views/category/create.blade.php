<div class="form col-md-6 col-12 mx-auto mt-3">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">New Category</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
            <form method="POST" action="{{ route('category.create') }}" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <div class="position-relative">
                                    <input type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" id="category_name" value="{{ old('category_name') }}" required autofocus>
                                        @error('category_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" required>
                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group ">
                                    <label for="node">Note</label>
                                    <textarea   name="note" rows="4" cols="50">
                                    </textarea>
                                    @error('note')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
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
