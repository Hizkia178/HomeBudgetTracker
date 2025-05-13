  // Mendapatkan semua tombol delete
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        // Mengambil ID data yang akan dihapus
        var id = this.getAttribute('data-id');

        // Menampilkan konfirmasi
        var confirmation = confirm("Apakah Anda yakin ingin menghapus pengeluaran ini?");
        if (confirmation) {
            // Membuat form penghapusan
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "../form/delete_expense.php"; // Ganti dengan nama file PHP yang sesuai

            // Menambahkan input untuk id pengeluaran
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "delete_id";
            input.value = id;
            form.appendChild(input);

            // Mengirim form untuk penghapusan
            document.body.appendChild(form);
            form.submit();
        }
    });
});