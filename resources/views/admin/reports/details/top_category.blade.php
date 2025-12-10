<h4 class="mb-3">🏷️ Top 10 Kategori Makanan Favorit</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Total Pesanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $index => $cat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->total_orders }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>