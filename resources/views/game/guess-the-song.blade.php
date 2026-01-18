@extends('layout.main')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-gradient">🎵 Guess The Song 🎵</h2>
        <p class="text-muted">Listen to the preview and guess the song from my playlist!</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Game Container -->
            <div id="gameContainer" class="card shadow-lg p-5">
                <!-- Loading State -->
                <div id="loadingState" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading songs...</p>
                </div>

                <!-- Game State -->
                <div id="gameState" style="display: none;">
                    <!-- Song Album Art -->
                    <div class="text-center mb-4">
                        <img id="albumArt" src="" alt="Album Art" class="img-fluid rounded shadow-sm" style="max-width: 300px; height: auto;">
                    </div>

                    <!-- Play Button -->
                    <div class="text-center mb-4">
                        <button id="playBtn" class="btn btn-lg btn-primary rounded-circle" onclick="playAudio()" style="width: 80px; height: 80px;">
                            <i class="fas fa-play" style="font-size: 32px;"></i>
                        </button>
                    </div>

                    <!-- Audio Player -->
                    <div class="mb-4">
                        <audio id="audioPlayer" class="w-100">
                            <source id="audioSource" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>

                    <!-- Game Info -->
                    <div class="text-center mb-4">
                        <p class="text-muted">
                            <span id="currentQuestion">Question 1</span> of <span id="totalQuestions">10</span>
                        </p>
                        <div class="progress" style="height: 8px;">
                            <div id="progressBar" class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Score -->
                    <div class="text-center mb-4">
                        <h5>Score: <span id="score">0</span></h5>
                    </div>

                    <!-- Hints -->
                    <div id="hintsContainer" class="mb-4">
                        <button class="btn btn-sm btn-outline-secondary me-2" id="artistHintBtn" onclick="showHint('artist')">
                            👤 Artist Hint
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" id="titleHintBtn" onclick="showHint('title')">
                            📝 Title Hint
                        </button>
                        <p id="hintText" class="mt-2 text-info" style="display: none;"></p>
                    </div>

                    <!-- Answer Options -->
                    <div id="optionsContainer" class="mb-4">
                        <!-- Options will be generated here -->
                    </div>

                    <!-- Next Button -->
                    <div class="text-center">
                        <button id="nextBtn" class="btn btn-primary" onclick="nextQuestion()" style="display: none;">
                            Next Question
                        </button>
                    </div>

                    <!-- Answer Feedback -->
                    <div id="feedbackContainer" class="mt-4" style="display: none;">
                        <div id="feedbackMessage" class="alert" role="alert"></div>
                    </div>
                </div>

                <!-- Game Over State -->
                <div id="gameOverState" style="display: none;" class="text-center">
                    <h3 class="mb-4">🎉 Game Over!</h3>
                    <h2 class="text-gradient mb-4">
                        Final Score: <span id="finalScore">0</span>
                    </h2>
                    <p class="text-muted mb-4" id="scoreMessage"></p>
                    <button class="btn btn-primary btn-lg" onclick="location.reload()">
                        Play Again
                    </button>
                </div>

                <!-- Error State -->
                <div id="errorState" style="display: none;" class="alert alert-danger" role="alert"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .option-btn {
        width: 100%;
        padding: 12px;
        margin-bottom: 10px;
        border: 2px solid #e9ecef;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: left;
    }

    .option-btn:hover {
        border-color: #667eea;
        background: #f8f9fa;
    }

    .option-btn.selected {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    .option-btn.correct {
        background: #28a745;
        color: white;
        border-color: #28a745;
    }

    .option-btn.incorrect {
        background: #dc3545;
        color: white;
        border-color: #dc3545;
    }

    .option-btn:disabled {
        cursor: not-allowed;
    }

    audio {
        border-radius: 8px;
    }
</style>

<script>
    let allSongs = [];
    let currentQuestionIndex = 0;
    let score = 0;
    const QUESTIONS_COUNT = 10;
    let currentQuestion = null;
    let hintsUsed = { artist: false, title: false };

    // Initialize game
    document.addEventListener('DOMContentLoaded', function() {
        loadSongs();
    });

    function loadSongs() {
        fetch('/api/game/song-data')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showError(data.error);
                } else {
                    allSongs = data;
                    if (allSongs.length < 4) {
                        showError('Not enough songs in the playlist to play the game.');
                    } else {
                        startGame();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Failed to load songs. Please refresh and try again.');
            });
    }

    function startGame() {
        currentQuestionIndex = 0;
        score = 0;
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('gameState').style.display = 'block';
        document.getElementById('totalQuestions').textContent = QUESTIONS_COUNT;
        loadQuestion();
    }

    function loadQuestion() {
        if (currentQuestionIndex >= QUESTIONS_COUNT) {
            endGame();
            return;
        }

        // Reset hints
        hintsUsed = { artist: false, title: false };
        document.getElementById('hintText').style.display = 'none';
        document.getElementById('feedbackContainer').style.display = 'none';

        // Select random song
        const randomIndex = Math.floor(Math.random() * allSongs.length);
        currentQuestion = allSongs[randomIndex];

        // Update UI
        document.getElementById('currentQuestion').textContent = currentQuestionIndex + 1;
        document.getElementById('albumArt').src = currentQuestion.image;
        document.getElementById('audioSource').src = currentQuestion.preview_url;
        document.getElementById('audioPlayer').load();

        // Update progress
        const progress = ((currentQuestionIndex) / QUESTIONS_COUNT) * 100;
        document.getElementById('progressBar').style.width = progress + '%';

        // Generate options
        generateOptions();

        // Reset button states
        document.getElementById('nextBtn').style.display = 'none';
        document.getElementById('artistHintBtn').disabled = false;
        document.getElementById('titleHintBtn').disabled = false;
    }

    function generateOptions() {
        // Get correct answer
        const correctSong = currentQuestion;

        // Get 3 random wrong answers
        let wrongSongs = allSongs
            .filter(song => song.id !== correctSong.id)
            .sort(() => Math.random() - 0.5)
            .slice(0, 3);

        // Combine and shuffle
        let options = [correctSong, ...wrongSongs].sort(() => Math.random() - 0.5);

        // Render options
        const container = document.getElementById('optionsContainer');
        container.innerHTML = '';
        options.forEach((song, index) => {
            const btn = document.createElement('button');
            btn.className = 'option-btn';
            btn.textContent = song.name + ' - ' + song.artists;
            btn.onclick = () => selectAnswer(song, btn, correctSong);
            container.appendChild(btn);
        });
    }

    function selectAnswer(selectedSong, button, correctSong) {
        // Disable all buttons
        document.querySelectorAll('.option-btn').forEach(btn => btn.disabled = true);

        const isCorrect = selectedSong.id === correctSong.id;

        if (isCorrect) {
            button.classList.add('correct');
            score++;
            document.getElementById('score').textContent = score;
            showFeedback('✅ Correct!', 'success');
        } else {
            button.classList.add('incorrect');
            document.querySelectorAll('.option-btn').forEach(btn => {
                if (btn.textContent.includes(correctSong.name)) {
                    btn.classList.add('correct');
                }
            });
            showFeedback('❌ Wrong! The correct answer is: ' + correctSong.name, 'danger');
        }

        document.getElementById('nextBtn').style.display = 'block';
    }

    function showFeedback(message, type) {
        const container = document.getElementById('feedbackContainer');
        const messageDiv = document.getElementById('feedbackMessage');
        messageDiv.className = 'alert alert-' + type;
        messageDiv.textContent = message;
        container.style.display = 'block';
    }

    function showHint(type) {
        if (hintsUsed[type]) {
            alert('Hint already used!');
            return;
        }

        hintsUsed[type] = true;
        const hintText = document.getElementById('hintText');
        let hint = '';

        if (type === 'artist') {
            const artists = currentQuestion.artists.split(', ');
            hint = '👤 Artist hint: ' + artists[0].substring(0, 3) + '...';
            document.getElementById('artistHintBtn').disabled = true;
        } else if (type === 'title') {
            const titleChars = Math.ceil(currentQuestion.name.length / 2);
            hint = '📝 Title hint: ' + currentQuestion.name.substring(0, titleChars) + '...';
            document.getElementById('titleHintBtn').disabled = true;
        }

        hintText.textContent = hint;
        hintText.style.display = 'block';
    }

    function playAudio() {
        const player = document.getElementById('audioPlayer');
        player.currentTime = 0;
        player.play();
    }

    function nextQuestion() {
        currentQuestionIndex++;
        loadQuestion();
    }

    function endGame() {
        document.getElementById('gameState').style.display = 'none';
        document.getElementById('gameOverState').style.display = 'block';
        document.getElementById('finalScore').textContent = score + '/' + QUESTIONS_COUNT;

        let message = '';
        const percentage = (score / QUESTIONS_COUNT) * 100;

        if (percentage === 100) {
            message = 'Perfect! You know Ella\'s playlist by heart! 💜';
        } else if (percentage >= 80) {
            message = 'Excellent! You\'re a true fan! 🎵';
        } else if (percentage >= 60) {
            message = 'Good job! Not bad! 😊';
        } else if (percentage >= 40) {
            message = 'Keep listening! You\'ll get better! 🎧';
        } else {
            message = 'Time to explore the playlist more! 🎶';
        }

        document.getElementById('scoreMessage').textContent = message;
    }

    function showError(message) {
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('errorState').style.display = 'block';
        document.getElementById('errorState').textContent = message;
    }
</script>
@endsection
