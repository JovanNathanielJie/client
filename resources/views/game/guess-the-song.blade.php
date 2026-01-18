@extends('layout.main')

@section('content')
<div id="confetti-container"></div>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-gradient">🎵 Guess The Song 🎵</h2>
        <p class="text-muted">Listen to the preview and guess the song from my playlist!</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Game Container -->
            <div id="gameContainer" class="card game-card shadow-lg p-5">
                <!-- Loading State -->
                <div id="loadingState" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading songs...</p>
                </div>

                <!-- Game State -->
                <div id="gameState" style="display: none;">
                    <!-- Lyrics Display -->
                    <div class="text-center mb-4">
                        <div class="lyrics-box p-4 bg-light rounded">
                            <p id="lyricsDisplay" class="lead text-dark" style="font-style: italic; line-height: 1.8; min-height: 100px;">
                                <!-- Lyrics will be displayed here -->
                            </p>
                        </div>
                    </div>

                    <div class="text-center mb-3">
                        <p class="text-muted text-sm">Guess the song title from these lyrics! 🎵</p>
                    </div>

                    <!-- Game Info -->
                    <div class="text-center mb-4">
                        <p class="text-muted">
                            <span id="currentQuestion">Question 1</span> of <span id="totalQuestions">10</span>
                        </p>
                        <div class="progress game-progress" style="height: 8px;">
                            <div id="progressBar" class="progress-bar progress-animated" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Score -->
                    <div class="text-center mb-4">
                        <h5 class="score-display">Score: <span id="score">0</span></h5>
                    </div>

                    <!-- Answer Options -->
                    <div id="optionsContainer" class="mb-4">
                        <!-- Options will be generated here -->
                    </div>

                    <!-- Next Button -->
                    <div class="text-center">
                        <button id="nextBtn" class="btn btn-primary btn-lg next-btn" onclick="nextQuestion()" style="display: none;">
                            Next Question ➜
                        </button>
                    </div>

                    <!-- Answer Feedback -->
                    <div id="feedbackContainer" class="mt-4" style="display: none;">
                        <div id="feedbackMessage" class="alert alert-animated" role="alert"></div>
                    </div>
                </div>

                <!-- Game Over State -->
                <div id="gameOverState" style="display: none;" class="text-center">
                    <h3 class="mb-4 game-over-title">🎉 Game Over!</h3>
                    <h2 class="text-gradient mb-4 final-score-display">
                        Final Score: <span id="finalScore">0</span>
                    </h2>
                    <p class="text-muted mb-4" id="scoreMessage"></p>
                    <button class="btn btn-primary btn-lg play-again-btn" onclick="location.reload()">
                        Play Again 🎮
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

    .game-card {
        border: none;
        border-radius: 20px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        transition: all 0.3s ease;
    }

    .game-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.15) !important;
    }

    .album-art {
        animation: slideDown 0.6s ease-out;
        border: 8px solid white;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .play-button {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
        animation: pulseGlow 2s infinite;
    }

    .play-button:hover {
        transform: scale(1.1);
        box-shadow: 0 0 30px rgba(102, 126, 234, 0.6);
    }

    @keyframes pulseGlow {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
        }
        50% {
            box-shadow: 0 0 0 15px rgba(102, 126, 234, 0);
        }
    }

    .game-progress {
        border-radius: 10px;
        background-color: #e9ecef;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transition: width 0.4s ease;
    }

    .progress-animated {
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }

    .score-display {
        font-size: 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    .hints-section {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .hint-btn {
        transition: all 0.3s ease;
        border-radius: 20px;
        padding: 8px 16px;
    }

    .hint-btn:hover:not(:disabled) {
        background-color: #667eea;
        color: white;
        border-color: #667eea;
        transform: translateY(-2px);
    }

    .option-btn {
        width: 100%;
        padding: 15px;
        margin-bottom: 12px;
        border: 2px solid #e9ecef;
        background: white;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: left;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .option-btn:hover:not(:disabled) {
        border-color: #667eea;
        background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
    }

    .option-btn.selected {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        transform: scale(1.02);
    }

    .option-btn.correct {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border-color: #28a745;
        animation: correctPulse 0.5s ease;
    }

    .option-btn.incorrect {
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        color: white;
        border-color: #dc3545;
        animation: shake 0.4s ease;
    }

    @keyframes correctPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.03);
        }
    }

    @keyframes shake {
        0%, 100% {
            transform: translateX(0);
        }
        25% {
            transform: translateX(-5px);
        }
        75% {
            transform: translateX(5px);
        }
    }

    .option-btn:disabled {
        cursor: not-allowed;
    }

    .next-btn {
        border-radius: 20px;
        padding: 12px 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        animation: slideUp 0.4s ease-out;
    }

    .next-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-animated {
        animation: slideInDown 0.4s ease-out;
        border-radius: 12px;
        border: none;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .game-over-title {
        font-size: 2rem;
        animation: bounce 0.6s ease-out;
    }

    .final-score-display {
        font-size: 2.5rem;
        animation: slideDown 0.6s ease-out;
    }

    .play-again-btn {
        border-radius: 20px;
        padding: 15px 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .play-again-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    @keyframes bounce {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }
        50% {
            opacity: 1;
        }
        100% {
            transform: scale(1);
        }
    }

    /* Confetti styles */
    #confetti-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 9999;
    }

    .confetti-piece {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #667eea;
        pointer-events: none;
    }

    audio {
        border-radius: 8px;
    }
</style>

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

    // Initialize game
    document.addEventListener('DOMContentLoaded', function() {
        loadSongs();
    });

    function loadSongs() {
        fetch('/api/game/song-data')
            .then(response => {
                console.log('API Response Status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP error status: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('API Response Data:', data);
                if (data.error) {
                    showError('Error: ' + data.error);
                } else if (!Array.isArray(data)) {
                    showError('Invalid response format from server');
                    console.error('Invalid data format:', data);
                } else {
                    allSongs = data;
                    console.log('Loaded ' + allSongs.length + ' songs');
                    if (allSongs.length < 4) {
                        showError('Not enough songs in the playlist to play the game. Found only ' + allSongs.length + ' songs with previews.');
                    } else {
                        startGame();
                    }
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                showError('Network error: ' + error.message + '. Please check your connection and refresh.');
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

        document.getElementById('feedbackContainer').style.display = 'none';

        // Select random song
        const randomIndex = Math.floor(Math.random() * allSongs.length);
        currentQuestion = allSongs[randomIndex];

        // Update UI
        document.getElementById('currentQuestion').textContent = currentQuestionIndex + 1;
        document.getElementById('lyricsDisplay').textContent = currentQuestion.lyrics;

        // Update progress
        const progress = ((currentQuestionIndex) / QUESTIONS_COUNT) * 100;
        document.getElementById('progressBar').style.width = progress + '%';

        // Generate options
        generateOptions();

        // Reset button states
        document.getElementById('nextBtn').style.display = 'none';
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
            createConfetti();
        } else if (percentage >= 80) {
            message = 'Excellent! You\'re a true fan! 🎵';
            createConfetti();
        } else if (percentage >= 60) {
            message = 'Good job! Not bad! 😊';
        } else if (percentage >= 40) {
            message = 'Keep listening! You\'ll get better! 🎧';
        } else {
            message = 'Time to explore the playlist more! 🎶';
        }

        document.getElementById('scoreMessage').textContent = message;
    }

    function createConfetti() {
        const container = document.getElementById('confetti-container');
        const colors = ['#667eea', '#764ba2', '#ffc93c', '#ff6b6b', '#4ecdc4'];

        for (let i = 0; i < 50; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti-piece';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.top = '-10px';
            confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.opacity = Math.random();
            confetti.style.width = Math.random() * 10 + 5 + 'px';
            confetti.style.height = confetti.style.width;
            confetti.style.borderRadius = '50%';

            container.appendChild(confetti);

            const duration = Math.random() * 2 + 2;
            const distance = Math.random() * 300 + 200;
            const angle = Math.random() * 360;

            confetti.animate([
                {
                    transform: 'translate(0, 0) rotate(0deg)',
                    opacity: 1
                },
                {
                    transform: `translate(${Math.cos(angle * Math.PI / 180) * distance}px, ${distance}px) rotate(360deg)`,
                    opacity: 0
                }
            ], {
                duration: duration * 1000,
                easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
            });

            setTimeout(() => confetti.remove(), duration * 1000);
        }
    }

    function showError(message) {
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('errorState').style.display = 'block';
        document.getElementById('errorState').textContent = message;
    }
</script>
@endsection
