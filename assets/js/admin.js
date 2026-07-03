// assets/js/admin.js

document.addEventListener('DOMContentLoaded', () => {
    // Confirm delete
    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if(!confirm('Yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });

    // Confirm approve/reject
    const confirmBtns = document.querySelectorAll('.confirm-btn');
    confirmBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if(!confirm('Lanjutkan aksi ini?')) {
                e.preventDefault();
            }
        });
    });
});
