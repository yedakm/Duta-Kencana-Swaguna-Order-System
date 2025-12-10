<h4 class="mb-3">🍽️ Top 10 Produk Paling Sering Dipesan</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Jumlah Terjual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foods as $index => $food)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $food->name }}</td>
                <td>{{ $food->total_sold }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>