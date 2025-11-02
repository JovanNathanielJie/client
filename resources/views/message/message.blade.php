@extends('layout.main')

@section('content')
<div class="container text-center py-5">

    <h2 class="mb-4 fw-bold text-pink">💖 Message Generator 💖</h2>
    <p class="text-muted mb-5">
        Tiap pesan di sini muncul secara acak — berbeda setiap kali kamu menekan tombol atau me-refresh halaman.<br>
        Kadang kamu cuma perlu seseorang yang ngerti tanpa perlu banyak kata. <br>
        Jadi aku siapin beberapa tombol di bawah — tinggal pilih aja yang paling kamu rasain hari ini 💗 <br>
        Aku menulis semuanya khusus buatmu, agar tiap momen terasa sedikit lebih hangat 💫
    </p>

    <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
        <button class="btn btn-outline-danger emotion-btn" data-emotion="semangat">Aku butuh semangat 💪</button>
        <button class="btn btn-outline-success emotion-btn" data-emotion="seneng">Aku seneng banget hari ini 😄</button>
        <button class="btn btn-outline-secondary emotion-btn" data-emotion="cape">Aku lagi cape banget 😴</button>
        <button class="btn btn-outline-info emotion-btn" data-emotion="kurang">Hari ini rasanya kayak ada yang kurang 🤔</button>
        <button class="btn btn-outline-primary emotion-btn" data-emotion="cerita">Aku mau ceritaa 🥺</button>
    </div>

    <div id="messageBox" class="card shadow-lg border-0 mx-auto text-center" style="max-width: 600px; background: linear-gradient(145deg, #fff0f6, #ffe6f2); border-radius: 20px;">
    <div class="card-header border-0 bg-transparent">
        <h5 id="messageTitle" class="fw-bold text-pink mb-0">💌 Pesan Untukmu</h5>
    </div>
    <div class="card-body py-4">
        <p id="messageText" class="fs-5 text-dark" style="min-height: 80px;">Klik salah satu tombol di atas untuk dapat pesan manis 💖</p>
    </div>
</div>

    <audio id="popSound" src="https://cdn.pixabay.com/download/audio/2022/03/15/audio_3f9d3a9ed5.mp3" preload="auto"></audio>
</div>

<style>
    .heart {
        position: fixed;
        color: #ff4d6d;
        font-size: 1.5rem;
        animation: floatUp 2s ease-in forwards;
        pointer-events: none;
        z-index: 9999;
    }
    @keyframes floatUp {
        0% { transform: translateY(0) scale(1); opacity: 1; }
        100% { transform: translateY(-150px) scale(1.5); opacity: 0; }
    }
    .text-pink {
        color: #ff5c8d;
    }
    .card {
    transition: transform 0.2s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 30px rgba(255, 105, 180, 0.2);
    }
    .card-header h5 {
        font-family: 'Poppins', sans-serif;
        letter-spacing: 0.5px;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const messages = {
        semangat: [
            "Kamu hebat banget, jangan ragu sama diri sendiri 💪✨",
            "Tenang, kamu udah sejauh ini. Aku bangga banget sama kamu 🌟",
            "Istirahat bentar gak apa-apa, kamu pantas dapat waktu tenang 💖",
            "Ayo semangat, dunia masih butuh senyum kamu hari ini 🌞",
            "Kamu itu cahaya buat orang sekitar, jangan padam ya 🔥",
            "Langkah kecilmu hari ini tetap berarti, jangan berhenti 💫",
            "Gagal itu cuma tanda kamu lagi belajar jadi luar biasa 💪",
            "Aku percaya kamu bisa, kayak biasanya 💖",
            "Senyum dikit yuk — biar hatimu ikut hangat 😊",
            "Jangan lupa tersenyum ya, itu senjata paling kuat kamu hari ini 😊",
            "Setiap badai pasti berlalu, tapi kamu tetep indah di tengah hujan 🌧️💗",
            "Aku tahu kamu kuat, bahkan di saat kamu ngerasa enggak 💫",
            "Kamu nggak perlu terburu-buru, cukup terus jalan, aku ikut di belakang 💕",
            "Gagal hari ini bukan akhir, cuma tanda kamu masih berani nyoba ✨",
            "Istirahat sebentar boleh, tapi jangan lupa bangkit lagi, aku percaya kamu banget 🌟"
        ],
        seneng: [
            "Aku ikut seneng juga dengarnya! Kamu pantas bahagia 🤩",
            "Yeay! Hari ini cerah banget karena kamu senyum 😍",
            "Bagus banget! Semoga kebahagiaan ini nular terus ya 🌈",
            "Kamu kayak matahari hari ini — hangat dan bercahaya ☀️",
            "Terus simpan momen indah ini, aku suka liat kamu bahagia 💖",
            "Jangan lupa berbagi senyum ke dunia 🌸",
            "Bahagia kamu itu bikin hari-hariku juga lebih baik ✨",
            "Gak ada yang lebih manis dari kamu yang bahagia 🍬",
            "Kamu lagi bahagia? Dunia juga ikut cerah, sumpah 😍",
            "Kamu lucu banget kalo lagi semangat gini 😆💗",
            "Teruslah bersinar ya, happiness looks good on you 🌟",
            "Kebahagiaan kamu itu candu, jangan berhenti nularin ya 😊"
        ],
        cape: [
            "Peluk virtual dulu 🤗 kamu udah berjuang keras hari ini.",
            "Istirahat yuk, kamu berhak tenang sejenak 💖",
            "Capek gak apa-apa, asal jangan menyerah ya 🌙",
            "Kamu kuat banget, tapi bahkan pahlawan juga perlu rehat 💤",
            "Tarik napas, hembuskan perlahan. Dunia masih nunggu senyum kamu 🌸",
            "Aku tau hari ini berat, tapi kamu gak sendirian 💞",
            "Tidur yang cukup ya, biar besok lebih ringan ☁️",
            "Kamu gak harus selalu produktif, cukup jadi damai dulu 💫",
            "Kamu tetap luar biasa meski lagi lelah 🌷",
            "Semoga mimpi malam ini penuh hal indah buat kamu 🌙✨",
            "Kamu capek karena kamu peduli. Itu cantik banget, tahu nggak? 💖",
            "Kamu udah keren banget hari ini. Sekarang waktunya rebahan 😴"
        ],
        kurang: [
            "Mungkin yang kurang itu cuma peluk dariku 🤗",
            "Kadang hati rindu sesuatu yang gak bisa dijelaskan 💭",
            "Mungkin hari ini terasa kosong, tapi esok akan lebih hangat 🌅",
            "Gak apa-apa, kadang hati juga butuh diam sebentar 💗",
            "Mungkin kamu cuma perlu denger: kamu cukup 💫",
            "Ada hal kecil yang belum kamu sadari — kamu dicintai 🍃",
            "Kadang rasa ‘kurang’ cuma pengingat kalau kamu butuh istirahat ☕",
            "Hari ini mungkin terasa aneh, tapi kamu gak sendirian 🌙",
            "Senyum dikit yuk, siapa tau itu yang hilang hari ini 😊",
            "Aku yakin besok hatimu bakal lebih tenang 🌸",
            "Kamu nggak kehilangan arah kok, cuma lagi nyari napas tenang sebentar 🌙",
            "Kadang hati kosong bukan karena nggak ada apa-apa, tapi karena terlalu banyak dirasa 🫶"
        ],
        cerita: [
            "Aku dengerin kok, cerita aja semuanya ya 🥺💖",
            "Kamu gak sendirian, aku di sini buat dengerin 🌙",
            "Cerita kamu selalu berharga, jangan disimpan sendiri 💫",
            "Gak apa-apa nangis sedikit, itu tandanya kamu masih punya hati 🌷",
            "Aku pengen tau semuanya, mulai dari hal kecil sampai yang kamu simpen 💞",
            "Cerita kamu itu bagian dari perjalanan indah kamu ✨",
            "Tenang aja, aku gak akan ninggalin kamu di tengah cerita 💕",
            "Kadang cerita itu cuma butuh telinga yang tulus mendengar 👂💗",
            "Aku suka banget tiap kali kamu cerita jujur gini 🥹",
            "Cerita kamu bikin aku makin sayang sama kamu 💖",
            "Cerita kamu itu berharga, bahkan kalau kamu pikir kecil pun 💖",
            "Kapan pun kamu butuh ruang buat ngomong, aku pengen jadi ruang itu 🤍"
        ]
    };

    const messageBox = document.getElementById("messageText");
    const popSound = document.getElementById("popSound");

    document.querySelectorAll(".emotion-btn").forEach(btn => {
        btn.addEventListener("click", e => {
            const emotion = e.target.dataset.emotion;
            const msgList = messages[emotion];
            const randomMsg = msgList[Math.floor(Math.random() * msgList.length)];

            // Ganti pesan dengan animasi
            messageBox.style.opacity = 0;
            setTimeout(() => {
                messageBox.textContent = randomMsg;
                messageBox.style.opacity = 1;
            }, 200);

            // Bunyi lembut
            popSound.currentTime = 0;
            popSound.play();

            // Hati kecil
            const heart = document.createElement("div");
            heart.classList.add("heart");
            heart.textContent = "❤️";
            document.body.appendChild(heart);

            heart.style.left = `${e.pageX}px`;
            heart.style.top = `${e.pageY}px`;

            setTimeout(() => heart.remove(), 2000);
        });
    });
});
</script>
@endsection
