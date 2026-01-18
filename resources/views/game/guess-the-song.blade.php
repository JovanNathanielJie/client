@extends('layout.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-music" style="font-size: 4rem; opacity: 0.9;"></i>
                    </div>

                    <h2 class="fw-bold mb-3">🎵 Guess The Song Coming Soon! 🎵</h2>

                    <p class="lead mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                        We're preparing an exciting song guessing game featuring tracks from my favorite playlist!
                    </p>

                    <div class="text-start mb-4" style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 8px;">
                        <h5 class="fw-bold mb-3">What to Expect:</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check-circle me-2"></i>
                                Guess songs from my playlist
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle me-2"></i>
                                Multiple choice questions
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle me-2"></i>
                                Challenge your knowledge
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle me-2"></i>
                                Track your score
                            </li>
                            <li>
                                <i class="fas fa-check-circle me-2"></i>
                                Fun surprises along the way
                            </li>
                        </ul>
                    </div>

                    <p class="text-muted mb-4" style="font-size: 0.95rem;">
                        Check back soon! In the meantime, feel free to explore the other pages on the website. ✨
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<style>
    @media (prefers-reduced-motion: no-preference) {
        .card {
            animation: slideDown 0.6s ease-out;
        }
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
</style>

