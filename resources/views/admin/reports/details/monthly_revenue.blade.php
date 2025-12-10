<h4 class="mb-3">💰 Pendapatan Per Bulan ({{ now()->year }})</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Bulan</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenues as $rev)
            <tr>
                <td>{{ DateTime::createFromFormat('!m', $rev->month)->format('F') }}</td>
                <td>Rp {{ number_format($rev->revenue, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>