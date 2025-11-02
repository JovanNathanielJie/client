@extends('layout.main')

@section('content')
<div class="text-center mb-5">
    <h2 class="mb-3">✨ Countdown for Ella ✨</h2>
    <p class="lead text-muted mx-auto" style="max-width: 700px; font-family: 'Poppins', sans-serif;">
        Kadang waktu berjalan terlalu cepat, tapi aku ingin mengingat tiap detiknya bersamamu.
        Di sini, setiap hitungan mundur bukan sekadar angka — tapi jejak momen indah yang akan datang.
        Semoga kita selalu punya alasan untuk menanti hari-hari bahagia berikutnya 💫
    </p>
</div>

<div class="row justify-content-center">
    <!-- Forxa -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm text-center p-4 h-100 border-0" style="background: #fef6e4;">
            <h5 class="mb-3 text-dark">Forxa</h5>
            <div id="forxa-countdown" class="fw-bold fs-4 mb-3"></div>
            <p class="text-muted small">20 November 2025 — momen istimewa yang kita nantikan ✨</p>
        </div>
    </div>

    <!-- Natal -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm text-center p-4 h-100 border-0" style="background: #e8f9fd;">
            <h5 class="mb-3 text-success">🎄 Natal</h5>
            <div id="christmas-countdown" class="fw-bold fs-4 mb-3"></div>
            <p class="text-muted small">25 Desember — penuh damai, hangat, dan cinta 💚</p>
        </div>
    </div>

    <!-- New Year -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm text-center p-4 h-100 border-0" style="background: #fff3e2;">
            <h5 class="mb-3 text-danger">🎆 New Year's Eve</h5>
            <div id="newyear-countdown" class="fw-bold fs-4 mb-3"></div>
            <p class="text-muted small">31 Desember — lembar baru, harapan baru 🌟</p>
        </div>
    </div>

    <!-- Birthday -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm text-center p-4 h-100 border-0" style="background: #fceef5;">
            <h5 class="mb-3 text-pink">🎂 Ulang Tahun Ella</h5>
            <div id="birthday-countdown" class="fw-bold fs-4 mb-3"></div>
            <p class="text-muted small">14 Mei — hari di mana dunia jadi lebih indah karena kamu 💖</p>
        </div>
    </div>

</div>

        <!-- Pesan Penutup -->
        <div class="card shadow-lg my-5 border-0" style="border-radius: 20px; background: #fff;">
            <div class="card-body p-4">
                <h3 class="text-center fw-bold mb-4 gradient-text">Hello, Orang Lucu!</h3>
                <p class="fst-italic text-secondary" style="font-size: 1.1rem; line-height: 1.8;">
                    “Setiap waktu bersamamu seperti hitungan menit di dalam lagu yang indah.<br>
            Aku membuat halaman ini agar nanti kita bisa tertawa,<br>
            saat menghitung lagi semua momen kecil yang ternyata begitu besar bagi hati ini.” 💖
                </p>
            </div>
        </div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

.text-pink { color: #e75480; }
.card {
    border-radius: 16px;
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const events = [
        { id: "forxa-countdown", date: new Date("November 20, 2025 00:00:00"), repeat: false },
        { id: "christmas-countdown", date: nextDate(12, 25), repeat: true },
        { id: "newyear-countdown", date: nextDate(12, 31), repeat: true },
        { id: "birthday-countdown", date: nextDate(5, 14), repeat: true },
    ];

    function nextDate(month, day) {
        const now = new Date();
        let target = new Date(now.getFullYear(), month - 1, day);
        if (now > target) target.setFullYear(target.getFullYear() + 1);
        return target;
    }

    events.forEach(event => {
        updateCountdown(event);
        setInterval(() => updateCountdown(event), 1000);
    });

    function updateCountdown(event) {
        const now = new Date();
        const distance = event.date - now;
        const countdownEl = document.getElementById(event.id);

        if (distance <= 0) {
            if (event.repeat) {
                event.date.setFullYear(event.date.getFullYear() + 1);
            } else {
                countdownEl.textContent = "🎉 Sudah tiba! 🎉";
                return;
            }
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((distance / (1000 * 60)) % 60);
        const seconds = Math.floor((distance / 1000) % 60);

        countdownEl.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
    }
});
</script>
@endsection
