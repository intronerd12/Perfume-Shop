@extends('backend.layouts.master')

@section('main-content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Import Products</h6>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('product.import.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="excel_file">Excel File</label>
                <input type="file" class="form-control" name="excel_file" required>
                <small class="text-muted">Please upload .xlsx or .xls file</small>
            </div>
            <button type="submit" class="btn btn-primary">Import Products</button>
            <a href="{{ asset('templates/product_import_template.xlsx') }}" class="btn btn-info">
                Download Template
            </a>
        </form>
    </div>
</div>
@endsection
