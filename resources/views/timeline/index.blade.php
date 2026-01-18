@extends('layout.main')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-gradient">💫 Our Timeline 💫</h2>
        <p class="text-muted">Milestones of our beautiful journey together</p>
    </div>

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

<style>
    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

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
    }
</style>
@endsection
