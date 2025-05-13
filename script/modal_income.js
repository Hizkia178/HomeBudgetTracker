
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const incomeId = button.getAttribute('data-id');
            const description = button.getAttribute('data-description');
            const category = button.getAttribute('data-category');
            const amount = button.getAttribute('data-amount');

            document.getElementById('income_id').value = incomeId;
            document.getElementById('description').value = description;
            document.getElementById('category').value = category;
            document.getElementById('amount').value = amount;

            const incomeModal = new bootstrap.Modal(document.getElementById('incomeModal'));
            incomeModal.show();
        });
    });
});
