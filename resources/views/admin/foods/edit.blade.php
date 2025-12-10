@extends('components.app')
@section('title', 'Edit Food')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0">
                <i class="fas fa-edit me-2 text-warning"></i>Edit Food Item
            </h4>
        </div>

        <div class="card-body">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.foods.update', $food->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Food Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $food->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $food->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $food->price) }}" min="0" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description (optional)</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $food->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Image</label><br>
                    @if ($food->image)
                    <img src="{{ asset('storage/' . $food->image) }}" alt="Food Image" class="rounded mb-2" width="100">
                    @else
                    <p class="text-muted">No image uploaded</p>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Change Image (optional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.foods.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i> Update Food
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection