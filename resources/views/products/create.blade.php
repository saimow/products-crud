@extends('layouts.app')

@section('content')
    <div>
        <div class="mb-4">
            <a class="btn btn-outline-secondary rounded-0" href="{{route('products')}} ">
                <i class="bi bi-chevron-double-left"></i>
                Back
            </a>
        </div>
        <div class="mt-4">
            <h3 class="mb-4">Create Product</h3>
            <div class="" id="app">
                <product-create></product-create>
            </div>
        </div>
    </div>
@endsection
