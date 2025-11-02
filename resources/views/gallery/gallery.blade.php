@extends('layout.main')

@section('content')
<div class="container py-5 text-center">
    <h2 class="fw-bold mb-3 text-pink">📸 Our Gallery</h2>
    <p class="text-muted mb-5">
        Every photo tells a story, of laughter, of quiet moments, and of all the little things that make us <strong>us</strong>.<br>
        This gallery is a place where memories will live, frozen in light and time.<br>
        For now, it waits for the moments we’ll soon capture together. 💫
    </p>

    <!-- Horizontal Scroll Gallery -->
    <div class="gallery-scroll d-flex flex-row overflow-auto justify-content-start align-items-center gap-4 p-4 shadow-sm rounded-4"
         style="background: #fffafc; border: 1px solid #ffe4ec; min-height: 250px;">
        <!-- Placeholder: no images yet -->
        <div class="w-100 text-center py-5">
            <i class="fas fa-camera-retro fa-3x text-pink mb-3"></i>
            <h5 class="text-muted">No memories here yet... but they’re coming soon 🌷</h5>
            <p class="text-secondary small">Once we add photos, you’ll be able to scroll through our story like a gentle timeline.</p>
        </div>
    </div>

    <!-- Optional parallax placeholder section -->
    <div class="parallax-section mt-5">
        <div class="parallax-overlay d-flex flex-column justify-content-center align-items-center text-white text-center">
            <h3 class="fw-bold mb-2">“Some moments deserve to be seen twice — once in time, once in memory.”</h3>
            <p class="fst-italic">Soon, this space will hold the snapshots of our favorite days together.</p>
        </div>
    </div>
</div>

<style>
.text-pink {
    color: #ff5c8d;
}
.gallery-scroll::-webkit-scrollbar {
    height: 10px;
}
.gallery-scroll::-webkit-scrollbar-thumb {
    background: #ffb6c1;
    border-radius: 10px;
}
.parallax-section {
    background-image: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1600&q=80');
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
    border-radius: 20px;
    min-height: 300px;
    position: relative;
    overflow: hidden;
}
.parallax-overlay {
    background: rgba(0, 0, 0, 0.45);
    height: 100%;
    width: 100%;
    border-radius: 20px;
    padding: 3rem;
}
</style>
@endsection
