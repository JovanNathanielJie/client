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
const playlistId = "38QnPhHZa2umQm45xPTo1H";
const clientId = "ISI_CLIENT_ID_MU";
const clientSecret = "ISI_CLIENT_SECRET_MU";

async function getToken() {
    const result = await fetch("https://accounts.spotify.com/api/token", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "Authorization": "Basic " + btoa(clientId + ":" + clientSecret)
        },
        body: "grant_type=client_credentials"
    });
    const data = await result.json();
    return data.access_token;
}

async function getPlaylistTracks(token) {
    const result = await fetch(`https://api.spotify.com/v1/playlists/${playlistId}/tracks`, {
        headers: { "Authorization": "Bearer " + token }
    });
    const data = await result.json();
    return data.items
        .map(item => item.track)
        .filter(track => track.preview_url)
        .map(track => ({
            name: track.name,
            artist: track.artists.map(a => a.name).join(", "),
            preview_url: track.preview_url
        }));
}

let tracks = [];
let currentTrack = null;

document.getElementById("newSongBtn").addEventListener("click", async () => {
    if (tracks.length === 0) {
        const token = await getToken();
        tracks = await getPlaylistTracks(token);
    }
    currentTrack = tracks[Math.floor(Math.random() * tracks.length)];
    document.getElementById("audioPlayer").src = currentTrack.preview_url;
    document.getElementById("audioPlayer").play();
    document.getElementById("guessArea").style.display = "block";
    document.getElementById("resultArea").textContent = "";
    document.getElementById("guessInput").value = "";
});

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
