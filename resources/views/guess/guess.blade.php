@extends('layout.main')

@section('content')
<div class="text-center mb-5">
    <h2 class="mb-3">🎧 Guess the Song 💕</h2>
    <p class="lead text-muted">
        Dengerin potongan lagunya, lalu coba tebak judulnya!<br>
        Siapa tahu kamu hafal semua lagu spesial kita 🎶
    </p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 p-4 text-center" style="border-radius: 20px;">
            <h5 class="mb-3 text-secondary">Kamu siap tebak lagu hari ini, Ella? 🎶</h5>

            <audio id="audioPlayer" class="mb-3 w-100" controls preload="auto">
                <source src="" type="audio/mpeg">
                Browser kamu tidak mendukung pemutar audio.
            </audio>

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
    transform: scale(1.05);
}
.text-purple { color: #6b1b7e; }
.card {
    background: linear-gradient(135deg, #fff 0%, #fdf2ff 100%);
}
</style>

<script>
// Daftar lagu manual (bisa diganti dengan hasil dari Spotify API nanti)
const localTracks = [
    { name: "Perfect", artist: "Ed Sheeran", preview_url: "https://p.scdn.co/mp3-preview/5b54a1f1e891e4abf8125a404edcccbfcf178a6a?cid=774b29d4f13844c495f206cafdad9c86" },
    { name: "Lover", artist: "Taylor Swift", preview_url: "https://p.scdn.co/mp3-preview/22dd481f0d678345ef7c9022cf7e309baf0a7d4b?cid=774b29d4f13844c495f206cafdad9c86" },
    { name: "Let Her Go", artist: "Passenger", preview_url: "https://p.scdn.co/mp3-preview/7acbe13cc8e89ad3e52ec5cb7b8ce14e77a94909?cid=774b29d4f13844c495f206cafdad9c86" },
    { name: "All of Me", artist: "John Legend", preview_url: "https://p.scdn.co/mp3-preview/f271d2817cd010b428de66dcd8de1c68f85ddabf?cid=774b29d4f13844c495f206cafdad9c86" },
    { name: "Beautiful Girls", artist: "Sean Kingston", preview_url: "https://p.scdn.co/mp3-preview/3b662cf0f414f229f51663a54186dbb76d4ac469?cid=774b29d4f13844c495f206cafdad9c86" }
];

let tracks = localTracks;
let currentTrack = null;

function playRandomSong() {
    const availableTracks = tracks.filter(t => t.preview_url);
    if (!availableTracks.length) {
        document.getElementById("resultArea").textContent = "Tidak ada lagu dengan preview tersedia 😢";
        return;
    }

    currentTrack = availableTracks[Math.floor(Math.random() * availableTracks.length)];
    const player = document.getElementById("audioPlayer");

    player.src = currentTrack.preview_url;
    player.play().catch(() => {
        document.getElementById("resultArea").textContent = "🎵 Gagal memutar audio, coba klik ulang tombol ya";
    });

    document.getElementById("guessArea").style.display = "block";
    document.getElementById("resultArea").innerHTML = "";
    document.getElementById("guessInput").value = "";
}

document.getElementById("newSongBtn").addEventListener("click", playRandomSong);

document.getElementById("submitGuessBtn").addEventListener("click", () => {
    const guess = document.getElementById("guessInput").value.trim().toLowerCase();
    if (!currentTrack) return;

    const correct = currentTrack.name.toLowerCase();
    const result = document.getElementById("resultArea");

    if (guess === correct) {
        result.innerHTML = `<span class="text-success">💖 Benar banget, Ella! Kamu hafal banget lagu <em>${currentTrack.name}</em>! 🎵</span>`;
    } else {
        result.innerHTML = `😝 Hampir! Lagu itu adalah:<br><strong>"${currentTrack.name}"</strong> – ${currentTrack.artist}`;
    }

    document.getElementById("guessArea").style.display = "none";
});
</script>
@endsection
