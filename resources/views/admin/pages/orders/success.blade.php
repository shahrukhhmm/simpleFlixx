@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-5">
    <div class="container text-center">
        <h2>Order Submitted Successfully!</h2>
        <p>Thank you for your order. We will process it soon.</p>
        {{-- <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a> --}}
    </div>
</div>
@endsection
