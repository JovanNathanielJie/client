@extends('layout.main')

@section('content')
<div class="container text-center py-5">
    <h2 class="fw-bold text-gradient mb-3">🎧 Guess the Song 🎶</h2>
    <p class="text-muted mb-4">
        Dengarkan potongan lagu dari playlist spesial kita,<br>
        lalu coba tebak judulnya! Setiap lagu diambil dari playlist kita 💙
    </p>

    <div class="card shadow-lg border-0 p-4 mx-auto" style="max-width: 700px;">
        <h5 class="mb-3 text-secondary">Siap tebak lagu, Ella? 🌸</h5>

        <audio id="audioPlayer" class="w-100 mb-4" controls></audio>

        <button id="newSongBtn" class="btn btn-gradient mb-3">
            <i class="fas fa-random"></i> Putar Lagu Baru
        </button>

        <div id="guessArea" style="display:none;">
            <input type="text" id="guessInput" class="form-control mb-3 text-center"
                placeholder="Tulis tebakan judul lagunya di sini...">
            <button id="submitGuessBtn" class="btn btn-primary w-100">
                Kirim Jawaban 💬
            </button>
        </div>

        <div id="resultArea" class="mt-4 fw-bold fs-5 text-purple"></div>
    </div>

    <p class="text-muted small mt-4">
        🎵 Lagu akan berbeda tiap kali kamu klik tombol "Putar Lagu Baru" atau me-refresh halaman 💫
    </p>
</div>

<style>
    .btn-gradient {
        background: linear-gradient(90deg, #a18cd1, #fbc2eb);
        color: white;
        font-weight: 500;
        border: none;
        border-radius: 12px;
        transition: 0.3s;
    }
    .btn-gradient:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }
    .text-gradient {
        background: linear-gradient(90deg, #a18cd1, #fbc2eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .text-purple {
        color: #6b1b7e;
    }
</style>

<script>
let tracks = [];
let currentTrack = null;

// Ambil lagu dari backend Laravel
async function loadTracks() {
    const res = await fetch('/api/spotify/tracks');
    tracks = await res.json();

    if (!tracks.length) {
        document.getElementById("resultArea").textContent =
            "Tidak ada lagu yang bisa diputar 😢 (mungkin tidak ada preview_url di playlist)";
    }
}

// Putar lagu acak dari playlist
async function playRandomSong() {
    if (tracks.length === 0) await loadTracks();

    currentTrack = tracks[Math.floor(Math.random() * tracks.length)];
    const player = document.getElementById("audioPlayer");

    player.src = currentTrack.preview_url;
    player.play().catch(() => {
        document.getElementById("resultArea").textContent =
            "🎧 Lagu tidak bisa diputar otomatis — klik tombol play di atas ya!";
    });

    document.getElementById("guessArea").style.display = "block";
    document.getElementById("resultArea").textContent = "";
    document.getElementById("guessInput").value = "";
}

// Cek tebakan
document.getElementById("submitGuessBtn").addEventListener("click", () => {
    const guess = document.getElementById("guessInput").value.trim().toLowerCase();
    const result = document.getElementById("resultArea");

    if (!currentTrack) return;

    const correct = currentTrack.name.toLowerCase();
    if (guess === correct) {
        result.innerHTML = "💖 Benar banget, Ella! Kamu hafal lagu kita! 🎵";
    } else {
        result.innerHTML = `😝 Hampir! Lagu itu adalah:<br><strong>"${currentTrack.name}"</strong> – ${currentTrack.artist}`;
    }

    document.getElementById("guessArea").style.display = "none";
});

// Event tombol lagu baru
document.getElementById("newSongBtn").addEventListener("click", playRandomSong);

// Muat lagu saat halaman pertama kali dibuka
loadTracks();
</script>
@endsection
