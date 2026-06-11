@extends('layout.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="fw-bold" style="color: #667eea; font-size: 3rem;">🎵 Guess The Song 🎵</h1>
                <p class="lead text-muted">Challenge yourself with lyrics from my favorite playlist!</p>
            </div>

            <!-- Loading State -->
            <div id="loading-state" class="text-center mb-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Loading songs...</p>
            </div>

            <!-- Game Container -->
            <div id="game-container" style="display: none;">
                <!-- Score & Progress -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <div class="card-body text-center">
                                <h5 class="card-title">Score</h5>
                                <h2 class="fw-bold"><span id="score">0</span> / <span id="total-questions">0</span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                            <div class="card-body text-center">
                                <h5 class="card-title">Progress</h5>
                                <h2 class="fw-bold"><span id="current-question">1</span> / <span id="total-questions">10</span></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question Card -->
                <div class="card shadow-lg border-0 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="card-body p-5">
                        <!-- Lyrics Clue -->
                        <div class="mb-4 p-4" style="background: rgba(255,255,255,0.1); border-radius: 8px; border-left: 4px solid #ffd89b;">
                            <small class="text-uppercase fw-bold">📝 Lyrics Clue:</small>
                            <p class="mt-2 mb-0 fs-5 fst-italic" id="lyrics-clue">Loading...</p>
                        </div>

                        <!-- Audio Preview Button -->
                        <div class="text-center mb-4">
                            <button id="play-preview-btn" class="btn btn-light btn-lg" style="border-radius: 50px;">
                                <i class="fas fa-play me-2"></i> Play Preview (10 sec)
                            </button>
                            <audio id="audio-preview" style="display: none;"></audio>
                        </div>

                        <!-- Answer Options -->
                        <div id="answer-options" class="row g-3">
                            <!-- Dinamis -->
                        </div>
                    </div>
                </div>

                <!-- Next Button -->
                <div class="text-center mb-4">
                    <button id="next-btn" class="btn btn-primary btn-lg" style="border-radius: 50px; padding: 12px 40px; display: none;">
                        Next Question <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>

            <!-- Game Over State -->
            <div id="game-over-state" style="display: none;">
                <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-trophy" style="font-size: 5rem; color: #ffd89b;"></i>
                        </div>

                        <h2 class="fw-bold mb-3">Congratulations! 🎉</h2>

                        <div class="mb-4">
                            <h1 class="fw-bold" style="font-size: 4rem;">
                                <span id="final-score">0</span> / <span id="final-total">10</span>
                            </h1>
                            <p class="fs-5" id="score-message"></p>
                        </div>

                        <button onclick="location.reload()" class="btn btn-light btn-lg" style="border-radius: 50px; padding: 12px 40px;">
                            Play Again <i class="fas fa-redo ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Error State -->
            <div id="error-state" style="display: none;">
                <div class="alert alert-danger text-center py-5" role="alert">
                    <i class="fas fa-exclamation-circle" style="font-size: 3rem; margin-bottom: 10px;"></i>
                    <h4 class="mt-3">Oops! Something went wrong</h4>
                    <p id="error-message">Unable to load songs. Please try again later.</p>
                    <button onclick="location.reload()" class="btn btn-danger mt-3">Reload Page</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .option-btn {
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 12px;
        padding: 15px 20px;
        background: transparent;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
        text-align: left;
    }

    .option-btn:hover:not(:disabled) {
        background: rgba(255,255,255,0.2);
        border-color: rgba(255,255,255,0.6);
        transform: translateX(5px);
    }

    .option-btn.selected {
        background: rgba(255,255,255,0.3);
        border-color: white;
    }

    .option-btn.correct {
        background: #28a745;
        border-color: #28a745;
        color: white;
    }

    .option-btn.wrong {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .option-btn:disabled {
        cursor: not-allowed;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: slideDown 0.6s ease-out;
    }

    #play-preview-btn {
        transition: all 0.3s ease;
    }

    #play-preview-btn:hover {
        transform: scale(1.05);
    }

    #play-preview-btn.playing {
        background-color: #ff6b6b !important;
    }
</style>

<script>
let songs = [];
let currentQuestionIndex = 0;
let score = 0;
let selectedAnswer = null;
let answerSubmitted = false;

async function loadSongs() {
    try {
        const response = await fetch('/api/game/song-data');
        const data = await response.json();

        if (response.ok && data.length > 0) {
            songs = data;
            document.getElementById('total-questions').textContent = Math.min(songs.length, 10);
            initGame();
        } else {
            showError(data.error || 'No songs available');
        }
    } catch (error) {
        console.error('Error loading songs:', error);
        showError('Failed to load songs. Please check your connection.');
    }
}

function initGame() {
    document.getElementById('loading-state').style.display = 'none';
    document.getElementById('game-container').style.display = 'block';
    currentQuestionIndex = 0;
    score = 0;
    songs = songs.slice(0, 10); // Limit to 10 songs
    loadQuestion();
}

function loadQuestion() {
    if (currentQuestionIndex >= songs.length) {
        showGameOver();
        return;
    }

    const song = songs[currentQuestionIndex];
    selectedAnswer = null;
    answerSubmitted = false;

    // Update progress
    document.getElementById('current-question').textContent = currentQuestionIndex + 1;
    document.getElementById('total-questions').textContent = songs.length;

    // Show lyrics clue
    document.getElementById('lyrics-clue').textContent = song.lyrics || 'Listen to the preview!';

    // Set up audio
    const audioElement = document.getElementById('audio-preview');
    audioElement.src = ''; // Reset

    // Create answer options
    const allSongs = songs.slice(0);
    const options = [song];

    // Add 3 random wrong answers
    const wrongAnswers = allSongs.filter(s => s.id !== song.id).sort(() => 0.5 - Math.random()).slice(0, 3);
    options.push(...wrongAnswers);

    // Shuffle options
    options.sort(() => 0.5 - Math.random());

    // Render options
    const optionsContainer = document.getElementById('answer-options');
    optionsContainer.innerHTML = '';

    options.forEach((option, index) => {
        const col = document.createElement('div');
        col.className = 'col-md-6';
        col.innerHTML = `
            <button class="option-btn w-100" onclick="selectAnswer(${index}, '${option.id}', '${song.id}')">
                <strong>${option.name}</strong>
                <br>
                <small>${option.artist}</small>
            </button>
        `;
        optionsContainer.appendChild(col);
    });

    document.getElementById('next-btn').style.display = 'none';
    document.getElementById('play-preview-btn').style.display = 'inline-block';
}

function selectAnswer(index, selectedSongId, correctSongId) {
    if (answerSubmitted) return;

    selectedAnswer = index;
    const buttons = document.querySelectorAll('.option-btn');
    buttons.forEach((btn, i) => {
        if (i === index) {
            btn.classList.add('selected');
        } else {
            btn.classList.remove('selected');
        }
    });

    // Submit immediately
    submitAnswer(selectedSongId === correctSongId);
}

function submitAnswer(isCorrect) {
    answerSubmitted = true;
    const buttons = document.querySelectorAll('.option-btn');

    if (isCorrect) {
        score++;
        buttons[selectedAnswer].classList.add('correct');
    } else {
        buttons[selectedAnswer].classList.add('wrong');
        // Show correct answer
        const song = songs[currentQuestionIndex];
        buttons.forEach((btn, index) => {
            if (index !== selectedAnswer && songs[currentQuestionIndex].id === song.id) {
                // Find the correct button
            }
        });
    }

    buttons.forEach(btn => btn.disabled = true);

    document.getElementById('score').textContent = score;
    document.getElementById('next-btn').style.display = 'block';
}

function playPreview() {
    const btn = document.getElementById('play-preview-btn');
    const audio = document.getElementById('audio-preview');

    // You can add Spotify preview URL if available
    // For now, just show feedback
    btn.classList.add('playing');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Playing...';

    setTimeout(() => {
        btn.classList.remove('playing');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-play me-2"></i> Play Preview (10 sec)';
    }, 10000);
}

document.getElementById('play-preview-btn').addEventListener('click', playPreview);

document.getElementById('next-btn').addEventListener('click', () => {
    currentQuestionIndex++;
    loadQuestion();
});

function showGameOver() {
    document.getElementById('game-container').style.display = 'none';
    document.getElementById('game-over-state').style.display = 'block';

    const percentage = Math.round((score / songs.length) * 100);
    document.getElementById('final-score').textContent = score;
    document.getElementById('final-total').textContent = songs.length;

    let message = '';
    if (percentage === 100) {
        message = "Perfect score! You know my music taste perfectly! 🎵";
    } else if (percentage >= 80) {
        message = "Awesome! You're a true music fan! 🌟";
    } else if (percentage >= 60) {
        message = "Good job! You got most of them right! 👏";
    } else if (percentage >= 40) {
        message = "Not bad! Want to try again? 💪";
    } else {
        message = "Keep trying! You'll get better! 🎶";
    }

    document.getElementById('score-message').textContent = `${percentage}% - ${message}`;
}

function showError(message) {
    document.getElementById('loading-state').style.display = 'none';
    document.getElementById('error-state').style.display = 'block';
    document.getElementById('error-message').textContent = message;
}

// Load songs on page load
loadSongs();
</script>
@endsection

