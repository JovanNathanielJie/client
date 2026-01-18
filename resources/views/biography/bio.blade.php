@extends('layout.main')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-gradient">🌷 About Ella 🌷</h2>
        <p class="text-muted">
            A small tribute page written with warmth, admiration, and a little bit of magic. ✨
        </p>
    </div>

    <div class="row align-items-center justify-content-center">
        <div class="col-md-4 mb-4 mb-md-0 text-center">
            <img src="{{ asset('img/ella.jpg') }}" alt="Ella" class="img-fluid rounded-circle shadow-lg" style="width: 250px; height: 250px; object-fit: cover;">
        </div>
        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4">
                <div class="card-body">
                    <h4 class="text-gradient mb-3">✨ Her Story ✨</h4>
                    <p class="text-muted">
                        Her name is Marcella Herlyne Basri, but to me, she will always be Ella,
                        a name that feels as gentle and beautiful as she is. <br>
                        She was born on May 14, 2008, in the vibrant city of Palembang, Indonesia.
                    </p>
                    <p class="text-muted">
                        The first time I met her was in 2022, during a very random encounter. I would never in a million years
                        have guessed that this chance meeting would lead to something so meaningful. From that moment on,
                        Ella has become a constant source of light in my life.
                    </p>
                    <p class="text-muted">
                        It all began with endless conversations about “Sore: Istri dari Masa Depan.”
                        What started as small talks about a movie slowly turned into deeper exchanges, about dreams, love, and life itself.
                        Somewhere between laughter and quiet moments, we realized we just… clicked.
                        From that day on, everything felt a little lighter, a little warmer, like we had known each other far longer than time could explain.
                    </p>
                    <p class="text-muted">
                        Ella is the kind of person whose presence feels like a melody. Soft, sincere, and quietly unforgettable.
                        She carries warmth in her words and a calm spark in her eyes, making the ordinary feel a little more beautiful.
                        Every laugh, every glance, feels like a verse of a song that stays in your heart long after the music fades.
                    </p>
                    <p class="text-muted">
                        She isn’t perfect, and that’s what makes her real. She loves deeply, dreams freely, and believes in kindness
                        even when the world forgets to be gentle. Ella is both the calm after the storm and the sunlight before the rain.
                        To know her is to understand what it means to feel at home, even without a place.
                    </p>
                    <p class="text-muted">
                        Sometimes, when I think about her, it feels like the world slows down just a little.
                        Her laughter has a way of turning ordinary moments into something I want to remember forever.
                        There’s a certain comfort in her presence, like the first warmth of sunlight after a long night.
                        I could listen to her talk for hours, and still feel like every word is something I’ve been waiting to hear.
                    </p>
                    <p class="text-muted">
                        She’s not just someone I care about. She’s the quiet inspiration behind every smile I wear,
                        the thought that lingers before I sleep, and the reason I want to be a little better every day.
                        There’s something timeless about the way she makes me feel,
                        like every version of the future somehow finds her name written in it.
                    </p>
                    <p class="text-muted">
                        And maybe that’s what love truly is, not fireworks or grand gestures,
                        but the gentle certainty that no matter where life takes us,
                        I’ll always be grateful for the days, the laughter, and the quiet nights we’ve shared.
                        Because somewhere between all of that… she became home.
                    </p>
                    <p class="text-muted">
                        This page is a quiet reminder of how one person can inspire so much just by being themselves. 💖
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Section -->
    <div class="mt-5 pt-5 border-top">
        <h2 class="fw-bold text-gradient text-center mb-5">💫 Our Timeline 💫</h2>
        <p class="text-center text-muted mb-5">Milestones of our beautiful journey together</p>

        <div class="timeline-container">
            <!-- Timeline Item 1 -->
            <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <h4 class="timeline-title">2022 - The Beginning</h4>
                    <p class="timeline-date">First Meeting</p>
                    <p class="text-muted">A random encounter that changed everything. I would never have guessed that this chance meeting would lead to something so meaningful.</p>
                </div>
            </div>

            <!-- Timeline Item 2 -->
            <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <h4 class="timeline-title">Movie Talks</h4>
                    <p class="timeline-date">Endless Conversations</p>
                    <p class="text-muted">It all began with conversations about "Sore: Istri dari Masa Depan." What started as small talks slowly turned into deeper exchanges about dreams, love, and life.</p>
                </div>
            </div>

            <!-- Timeline Item 3 -->
            <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <h4 class="timeline-title">The Click Moment</h4>
                    <p class="timeline-date">Special Realization</p>
                    <p class="text-muted">Somewhere between laughter and quiet moments, we realized we just… clicked. From that day on, everything felt lighter and warmer.</p>
                </div>
            </div>

            <!-- Timeline Item 4 -->
            <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <h4 class="timeline-title">Every Day Together</h4>
                    <p class="timeline-date">Forever & Always</p>
                    <p class="text-muted">Ella became a constant source of light. Her presence feels like home, and every moment with her is one I want to remember forever. 💖</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-gradient {
    background: linear-gradient(90deg, #ff9a9e, #fad0c4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: inline-block;
}
.card {
    border-radius: 1rem;
    transition: all 0.3s ease;
}
.card:hover {
    transform: scale(1.01);
    box-shadow: 0 8px 24px rgba(255, 182, 193, 0.4);
}

/* Timeline Styles */
.timeline-container {
    position: relative;
    padding: 20px 0;
    max-width: 600px;
    margin: 0 auto;
}

.timeline-container::before {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}

.timeline-item {
    display: flex;
    margin-bottom: 50px;
    position: relative;
}

.timeline-item:nth-child(odd) .timeline-content {
    margin-left: 0;
    margin-right: auto;
    padding-right: 50px;
    text-align: right;
}

.timeline-item:nth-child(even) .timeline-content {
    margin-left: auto;
    margin-right: 0;
    padding-left: 50px;
    text-align: left;
}

.timeline-marker {
    position: absolute;
    left: 50%;
    top: 20px;
    transform: translateX(-50%);
    width: 20px;
    height: 20px;
    background: white;
    border: 4px solid #667eea;
    border-radius: 50%;
    z-index: 10;
    transition: all 0.3s ease;
}

.timeline-item:hover .timeline-marker {
    width: 28px;
    height: 28px;
    top: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
}

.timeline-content {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    width: 45%;
}

.timeline-item:hover .timeline-content {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
}

.timeline-title {
    color: #667eea;
    font-weight: 700;
    margin-bottom: 5px;
}

.timeline-date {
    color: #764ba2;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.timeline-content p {
    margin: 0;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .timeline-container::before {
        left: 20px;
    }

    .timeline-marker {
        left: 20px;
    }

    .timeline-item:nth-child(odd) .timeline-content,
    .timeline-item:nth-child(even) .timeline-content {
        margin-left: 60px;
        margin-right: 0;
        padding-left: 25px;
        padding-right: 25px;
        text-align: left;
        width: 100%;
    }
