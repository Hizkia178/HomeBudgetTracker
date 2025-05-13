<div class="quick-actions" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
    <div class="row">
        <div class="col-6 col-md-3">
            <a href="../form/index.php" class="text-decoration-none text-dark">
                <div class="quick-action-btn">
                    <i class='bx bx-plus-circle quick-action-icon' data-bs-toggle="tooltip" title="Click to add new expense"></i>
                    <div>Add Expense</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="../form/income_index.php" class="text-decoration-none">
                <div class="quick-action-btn">
                    <i class='bx bx-dollar-circle quick-action-icon' data-bs-toggle="tooltip" title="Click to add income"></i>
                    <div>Add Income</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none text-dark" onclick="showReportNotice(event)">
                <div class="quick-action-btn">
                    <i class='bx bx-bar-chart-alt-2 quick-action-icon' data-bs-toggle="tooltip" title="View financial reports"></i>
                    <div>View Reports</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none text-dark" onclick="showSettingsNotice(event)">
                <div class="quick-action-btn">
                    <i class='bx bx-cog quick-action-icon' data-bs-toggle="tooltip" title="Manage settings"></i>
                    <div>Settings</div>
                </div>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showReportNotice(event) {
        event.preventDefault();
        Swal.fire({
            icon: 'info',
            title: 'Maaf bro, data-nya masih data dummy',
            text: 'Data keuangan yang tampil saat ini masih berupa data dummy. Harap bersabar! 📊',
            confirmButtonText: 'Oke, mantap!'
        });
    }



    function showSettingsNotice(event) {
        event.preventDefault();
        Swal.fire({
            icon: 'info',
            title: 'Pengaturan Belum Tersedia',
            text: 'Fitur ini masih dalam tahap pengembangan. Mohon bersabar ya ⚙️',
            confirmButtonText: 'Oke, sip!'
        });
    }
</script>