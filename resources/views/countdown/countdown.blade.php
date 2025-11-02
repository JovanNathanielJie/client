@extends('layout.main')

@section('content')
<div class="text-center mb-5">
    <h2 class="mb-3">✨ Countdown Hari Spesial ✨</h2>
    <p class="lead text-muted">
        Hitung mundur menuju momen-momen istimewa kamu, Ella 💫<br>
        Setiap tanggal punya cerita indah tersendiri 🌷
    </p>
</div>

<div class="row justify-content-center">
    <!-- Forxa Day -->
    <div class="col-md-6 col-lg-5 mb-4">
        <div class="card p-4 text-center shadow-sm h-100">
            <h5 class="mb-3">Forxa Day 💪</h5>
            <div id="forxa" class="countdown text-purple fw-semibold"></div>
        </div>
    </div>

    <!-- Natal -->
    <div class="col-md-6 col-lg-5 mb-4">
        <div class="card p-4 text-center shadow-sm h-100">
            <h5 class="mb-3">Natal 🎄</h5>
            <div id="natal" class="countdown text-purple fw-semibold"></div>
        </div>
    </div>

    <!-- Tahun Baru -->
    <div class="col-md-6 col-lg-5 mb-4">
        <div class="card p-4 text-center shadow-sm h-100">
            <h5 class="mb-3">Tahun Baru 🎆</h5>
            <div id="newyear" class="countdown text-purple fw-semibold"></div>
        </div>
    </div>

    <!-- Ulang Tahun -->
    <div class="col-md-6 col-lg-5 mb-4">
        <div class="card p-4 text-center shadow-sm h-100">
            <h5 class="mb-3">Ulang Tahun 🎂</h5>
            <div id="birthday" class="countdown text-purple fw-semibold"></div>
        </div>
    </div>
</div>

<style>
.text-purple {
    color: #6b1b7e;
}
.countdown {
    font-size: 1.8rem;
    letter-spacing: 1px;
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.countdown div {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.countdown span {
    font-size: 0.85rem;
    color: #a47cc3;
}

/* Card hover */
.card {
    border: none;
    border-radius: 16px;
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(107, 27, 126, 0.15);
}

/* Gradient background to match playlist */
body {
    background: linear-gradient(120deg, #a18cd1 0%, #fbc2eb 100%);
}
</style>

<script>
function updateCountdown(id, targetDate) {
    const element = document.getElementById(id);
    const now = new Date();
    const distance = targetDate - now;

    if (distance <= 0) {
        element.innerHTML = "<div>✨ Sudah tiba! ✨</div>";
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((distance / (1000 * 60)) % 60);
    const seconds = Math.floor((distance / 1000) % 60);

    element.innerHTML = `
        <div>${days}<span>hari</span></div>
        <div>${hours}<span>jam</span></div>
        <div>${minutes}<span>menit</span></div>
        <div>${seconds}<span>detik</span></div>
    `;
}

function initCountdowns() {
    const year = new Date().getFullYear();

    const events = {
        forxa: new Date("2025-11-20T00:00:00"),
        natal: new Date(`${year}-12-25T00:00:00`),
        newyear: new Date(`${year}-12-31T00:00:00`),
        birthday: new Date(`${year}-05-14T00:00:00`)
    };

    setInterval(() => {
        updateCountdown("forxa", events.forxa);
        updateCountdown("natal", events.natal);
        updateCountdown("newyear", events.newyear);
        updateCountdown("birthday", events.birthday);
    }, 1000);
}

initCountdowns();
</script>
@endsection
