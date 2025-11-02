@extends('layout.main')

@section('content')
<div class="text-center mb-5">
    <h2 class="mb-3 text-4xl font-bold text-white">✨ Countdown Spesial ✨</h2>
    <p class="lead text-gray-300">
        Hitung mundur menuju momen-momen istimewa kamu 💫
    </p>
</div>

<div id="countdowns" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-2 max-w-5xl mx-auto"></div>

<style>
body {
    background: radial-gradient(circle at top, #1e293b, #0f172a);
    color: white;
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
}
.countdown-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border-radius: 1.5rem;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s;
}
.countdown-card:hover {
    transform: scale(1.05);
}
.time-box {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    padding: 0.75rem 1.25rem;
    min-width: 70px;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const countdowns = [
        {
            name: "Forxa Day 💪",
            date: new Date("2025-11-20T00:00:00"),
            color: "from-sky-400 to-blue-500"
        },
        {
            name: "Natal 🎄",
            date: new Date(new Date().getFullYear(), 11, 25),
            color: "from-green-400 to-emerald-600"
        },
        {
            name: "Tahun Baru 🎆",
            date: new Date(new Date().getFullYear(), 11, 31, 23, 59, 59),
            color: "from-yellow-400 to-orange-500"
        },
        {
            name: "Ulang Tahun 🎂",
            date: new Date(new Date().getFullYear(), 4, 14),
            color: "from-pink-400 to-rose-500"
        },
    ];

    // Auto adjust ke tahun depan kalau sudah lewat
    countdowns.forEach(cd => {
        if (cd.date < new Date()) {
            cd.date.setFullYear(cd.date.getFullYear() + 1);
        }
    });

    const container = document.getElementById('countdowns');

    countdowns.forEach((cd, i) => {
        const card = document.createElement('div');
        card.className = `countdown-card p-6 text-center bg-gradient-to-br ${cd.color}`;
        card.innerHTML = `
            <h2 class="text-2xl font-semibold mb-4">${cd.name}</h2>
            <div id="timer-${i}" class="flex justify-center gap-4 text-xl font-mono"></div>
            <p class="mt-3 text-sm opacity-80">
                ${cd.date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
            </p>
        `;
        container.appendChild(card);
    });

    function updateCountdowns() {
        countdowns.forEach((cd, i) => {
            const now = new Date();
            const diff = cd.date - now;
            const timer = document.getElementById(`timer-${i}`);

            if (diff <= 0) {
                timer.innerHTML = "<span class='text-lg'>✨ Sudah tiba! ✨</span>";
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / (1000 * 60)) % 60);
            const seconds = Math.floor((diff / 1000) % 60);

            timer.innerHTML = `
                <div class="time-box"><div class="text-3xl font-bold">${days}</div><div class="text-xs uppercase">Hari</div></div>
                <div class="time-box"><div class="text-3xl font-bold">${hours}</div><div class="text-xs uppercase">Jam</div></div>
                <div class="time-box"><div class="text-3xl font-bold">${minutes}</div><div class="text-xs uppercase">Menit</div></div>
                <div class="time-box"><div class="text-3xl font-bold">${seconds}</div><div class="text-xs uppercase">Detik</div></div>
            `;
        });
    }

    updateCountdowns();
    setInterval(updateCountdowns, 1000);
});
</script>
@endsection
