
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const expenseId = button.getAttribute('data-id');
            const description = button.getAttribute('data-description');
            const category = button.getAttribute('data-category');
            const amount = button.getAttribute('data-amount');

            document.getElementById('expense_id').value = expenseId;
            document.getElementById('description').value = description;
            document.getElementById('category').value = category;
            document.getElementById('amount').value = amount;

   
            const expenseModal = new bootstrap.Modal(document.getElementById('expenseModal'));
            expenseModal.show();
        });
    });
});