@extends('components.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Our Menu</h1>

    
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('guest.foods.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        placeholder="Search food..." value="{{ request('search') }} ">
                    <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <form action="{{ route('guest.foods.index') }}" method="GET">
                @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div class="input-group">
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}"
                            {{ request('category') == $cat->slug ? 'selected' :   '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success" type="submit">Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

   
    <div class="row">
        @forelse($foods as $food)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" style="height: 200px; object-fit: cover;" class="card-img-top" alt="{{ $food->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $food->name }}</h5>
                    <p class="card-text">{{ Str::limit($food->description, 100) }}</p>
                    <p class="card-text"><strong>Rp {{ number_format($food->price, 0, ',', '.') }}</strong></p>
                </div>
                <div class="card-footer bg-white border-0">
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Order Now
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                No food found.
            </div>
        </div>
        @endforelse
    </div>

 
    <div class="d-flex justify-content-center">
        {{ $foods->links() }}
    </div>
</div>
@endsection