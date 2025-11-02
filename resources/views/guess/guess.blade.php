@extends('layout.main')

@section('content')
<div class="text-center mb-5">
    <h2 class="mb-3">Guess the Song 🎧</h2>
    <p class="lead text-muted">
        Dengarkan potongan lagu dari playlist spesial kita,<br>
        lalu coba tebak judulnya! 💙
    </p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm p-4 text-center">
            <h5 class="mb-3 text-secondary">Siap tebak lagu, Ella? 🎶</h5>

            <audio id="audioPlayer" class="mb-3 w-100" controls></audio>

            <button id="newSongBtn" class="btn btn-gradient mb-4">
                <i class="fas fa-random"></i> Putar Lagu Baru
            </button>

            <div id="guessArea" style="display:none;">
                <input type="text" id="guessInput" class="form-control mb-3 text-center"
                       placeholder="Tulis tebakan judul lagu di sini...">
                <button id="submitGuessBtn" class="btn btn-primary w-100">
                    Kirim Jawaban 💬
                </button>
            </div>

            <div id="resultArea" class="mt-4 fw-bold fs-5 text-purple"></div>
        </div>
    </div>
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
    opacity: 0.85;
    transform: scale(1.02);
}
.text-purple {
    color: #6b1b7e;
}
</style>

<script>
let tracks = [];
let currentTrack = null;

async function loadTracks() {
    const response = await fetch('/api/spotify/tracks');
    tracks = await response.json();
    if (!tracks.length) {
        document.getElementById("resultArea").textContent =
            "Tidak ada lagu yang bisa diputar 😢 (mungkin semua lagu tidak punya preview_url)";
    }
}

async function playRandomSong() {
    if (tracks.length === 0) await loadTracks();

    currentTrack = tracks[Math.floor(Math.random() * tracks.length)];
    document.getElementById("audioPlayer").src = currentTrack.preview_url;
    document.getElementById("audioPlayer").play();
    document.getElementById("guessArea").style.display = "block";
    document.getElementById("resultArea").textContent = "";
    document.getElementById("guessInput").value = "";
}

document.getElementById("newSongBtn").addEventListener("click", playRandomSong);

document.getElementById("submitGuessBtn").addEventListener("click", () => {
    const guess = document.getElementById("guessInput").value.trim().toLowerCase();
    if (!currentTrack) return;

    const correct = currentTrack.name.toLowerCase();
    const result = document.getElementById("resultArea");

    if (guess === correct) {
        result.innerHTML = "💖 Benar banget, Ella! Kamu hafal lagu kita!";
    } else {
        result.innerHTML = `😝 Hampir! Lagu itu adalah: <br><strong>"${currentTrack.name}"</strong> – ${currentTrack.artist}`;
    }

    document.getElementById("guessArea").style.display = "none";
});
</script>
@endsection
