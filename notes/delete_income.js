// Mendapatkan semua tombol delete income
document.querySelectorAll('.remove-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        // Mengambil ID income yang akan dihapus
        var id = this.getAttribute('data-id');

        // Menampilkan konfirmasi
        var confirmation = confirm("Apakah Anda yakin ingin menghapus pemasukan ini?");
        if (confirmation) {

            var form = document.createElement("form");
            form.method = "POST";
            form.action = "../form/delete_income.php"; 

            // Menambahkan input hidden untuk ID
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "delete_id";
            input.value = id;
            form.appendChild(input);

            // Kirim form
            document.body.appendChild(form);
            form.submit();
        }
    });
});
