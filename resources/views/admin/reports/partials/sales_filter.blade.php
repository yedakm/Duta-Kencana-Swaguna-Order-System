<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 text-primary fw-bold">🔍 Filter Penjualan Berdasarkan Tanggal</h5>
    </div>
    <div class="card-body">
        <form id="filterForm">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="start_date" class="form-label fw-bold">Dari Tanggal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="end_date" class="form-label fw-bold">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i> Tampilkan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="sales-result-container"></div>

<script>
    $(document).ready(function() {
        $('#filterForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();

            if(!startDate || !endDate) {
                alert('Harap pilih rentang tanggal awal dan akhir!');
                return;
            }

            // Tampilkan animasi loading
            $('#sales-result-container').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">Sedang mengambil data penjualan...</p>
                </div>
            `);

            // Kirim request ke Controller
            $.ajax({
                url: "{{ route('admin.reports.filter-sales') }}", // Pastikan route ini ada di web.php
                type: "GET",
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    // Masukkan hasil tabel ke dalam container
                    $('#sales-result-container').hide().html(response).fadeIn();
                },
                error: function(xhr) {
                    console.error(xhr);
                    let msg = 'Terjadi kesalahan saat memuat data.';
                    if(xhr.status === 404) msg = 'Route tidak ditemukan. Cek web.php';
                    if(xhr.status === 500) msg = 'Terjadi error di server (500). Cek Log.';
                    
                    $('#sales-result-container').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i> ${msg}
                        </div>
                    `);
                }
            });
        });
    });
</script>