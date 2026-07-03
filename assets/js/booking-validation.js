// assets/js/booking-validation.js

document.addEventListener('DOMContentLoaded', () => {
    const bookingForm = document.getElementById('bookingForm');
    
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            let isValid = true;
            let errorMessage = "";

            const nik = document.getElementById('nik').value;
            const no_hp = document.getElementById('no_hp').value;
            const tgl_pinjam = document.getElementById('tgl_pinjam').value;
            const tgl_kembali = document.getElementById('tgl_kembali').value;
            const bukti = document.getElementById('bukti_bayar').files[0];

            // Validasi NIK (Angka, min 16)
            if (!/^\d{16,}$/.test(nik)) {
                isValid = false;
                errorMessage += "- NIK harus berupa angka minimal 16 digit.\n";
            }

            // Validasi No HP
            if (!/^\d+$/.test(no_hp)) {
                isValid = false;
                errorMessage += "- No. HP harus berupa angka.\n";
            }

            // Validasi Tanggal
            const today = new Date();
            today.setHours(0,0,0,0);
            
            const pinjamDate = new Date(tgl_pinjam);
            const kembaliDate = new Date(tgl_kembali);

            if (pinjamDate <= today) {
                isValid = false;
                errorMessage += "- Tanggal pinjam harus hari depan (tidak boleh hari ini atau sebelumnya).\n";
            }

            const maxPinjam = new Date(today);
            maxPinjam.setDate(today.getDate() + 2);
            if (pinjamDate > maxPinjam) {
                isValid = false;
                errorMessage += "- Tanggal pinjam maksimal 2 hari dari hari ini.\n";
            }

            if (kembaliDate < pinjamDate) {
                isValid = false;
                errorMessage += "- Tanggal kembali tidak boleh lebih awal dari tanggal pinjam.\n";
            }

            // Validasi File
            if (bukti) {
                const allowedExtensions = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
                if (!allowedExtensions.includes(bukti.type)) {
                    isValid = false;
                    errorMessage += "- Format file bukti bayar harus JPG, JPEG, PNG, atau PDF.\n";
                }
                if (bukti.size > 2 * 1024 * 1024) { // 2MB
                    isValid = false;
                    errorMessage += "- Ukuran file bukti bayar maksimal 2 MB.\n";
                }
            } else {
                isValid = false;
                errorMessage += "- Silakan upload bukti pembayaran DP.\n";
            }

            if (!isValid) {
                e.preventDefault();
                alert("Periksa kembali inputan Anda:\n" + errorMessage);
            }
        });

        // Hitung total DP dinamis (Asumsi DP 50% atau sesuai harga sewa x hari)
        const tglPinjamInput = document.getElementById('tgl_pinjam');
        const tglKembaliInput = document.getElementById('tgl_kembali');
        const hargaSewa = parseInt(document.getElementById('hargaSewa').value);
        const displayDp = document.getElementById('displayDp');
        const hiddenDp = document.getElementById('hiddenDp');

        function hitungDp() {
            if (tglPinjamInput.value && tglKembaliInput.value) {
                const start = new Date(tglPinjamInput.value);
                const end = new Date(tglKembaliInput.value);
                if (end >= start) {
                    const diffTime = Math.abs(end - start);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) || 1; // min 1 day
                    const total = hargaSewa * diffDays;
                    displayDp.innerText = "Rp " + total.toLocaleString('id-ID');
                    hiddenDp.value = total;
                }
            }
        }

        tglPinjamInput.addEventListener('change', hitungDp);
        tglKembaliInput.addEventListener('change', hitungDp);
    }
});
