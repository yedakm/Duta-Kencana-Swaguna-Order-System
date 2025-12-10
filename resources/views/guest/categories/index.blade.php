@extends('components.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Categories</h1>

    <div class="row">
        @foreach($categories as $category)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fas fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">{{ $category->name }}</h5>
                    <p class="card-text">{{ $category->foods_count }} items</p>
                    <a href="{{ route('guest.categories.show', $category->id) }}" class="btn btn-outline-success">View Foods</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    
    <div class="d-flex justify-content-center">
        {{ $categories->links() }}
    </div>
</div>
@endsection