@extends('components.app')

@section('title', 'Menus')
@section('content')
<div class="container mt-4">

    @if(session('success'))

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">✅ Berhasil</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus <strong id="foodName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 text-success fw-bold">Master Menu</h1>
            <p class="lead text-muted">Kelola data menu makanan/minuman</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-4">Menu List</h5>

            <div>
                <a href="{{ route('admin.foods.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add Menu
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No.</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th class="text-end">Price</th>
                            <th width="15%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($foods as $food)
                        <tr>
                            <td>{{ $food->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($food->image)
                                    <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}"
                                        class="rounded me-3" width="40" height="40">
                                    @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                        style="width:40px;height:40px;">
                                        <i class="fas fa-utensils text-muted"></i>
                                    </div>
                                    @endif
                                    <span>{{ $food->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $food->category->name }}
                                </span>
                            </td>
                            <td class="text-end">
                                <span class="fw-semibold">
                                    {{ $food->formatted_price }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.foods.edit', $food->id) }}"
                                        class="btn btn-sm btn-outline-primary d-flex align-items-center"
                                        title="Edit">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>

                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-delete"
                                        data-id="{{ $food->id }}"
                                        data-name="{{ $food->name }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No food items found. <a href="{{ route('admin.foods.create') }}">Create one</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($foods->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">

                        @if ($foods->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $foods->previousPageUrl() }}" rel="prev">&laquo;</a>
                        </li>
                        @endif

                        @foreach ($foods->links()->elements[0] as $page => $url)
                        <li class="page-item {{ $page == $foods->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                        @endforeach

                        @if ($foods->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $foods->nextPageUrl() }}" rel="next">&raquo;</a>
                        </li>
                        @else
                        <li class="page-item disabled">
                            <span class="page-link">&raquo;</span>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        const foodNameSpan = document.getElementById('foodName');
        const deleteForm = document.getElementById('deleteForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const foodId = button.getAttribute('data-id');
                const foodName = button.getAttribute('data-name');

                foodNameSpan.textContent = foodName;

                deleteForm.action = `/admin/foods/${foodId}`;
            });
        });
    });
</script>
@endpush