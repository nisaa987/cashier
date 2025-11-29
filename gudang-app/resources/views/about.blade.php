@extends('layouts.app')

@section('title', 'Tentang Saya')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .about-wrapper {
        font-family: 'Poppins', sans-serif;
        max-width: 900px;
        margin: 60px auto;
        padding: 40px 30px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        color: #2e2e2e;
        animation: fadeIn 1s ease;
        text-align: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .profile-pic {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #f0f0f0;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        margin-bottom: 20px;
        transition: transform 0.3s ease;

        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .profile-pic:hover {
        transform: scale(1.05);
    }

    .about-header h1 {
        font-size: 30px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .about-header p {
        font-style: italic;
        color:rgb(10, 9, 15);
        font-size: 14px;
        margin-top: 5px;
    }

    .about-section {
        margin-top: 35px;
    }

    .about-section h2 {
        font-size: 18px;
        margin-bottom: 10px;
        font-weight: 600;
        color: #444;
    }

    .about-section p,
    .about-section ul {
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 16px;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .about-section ul {
        list-style: none;
        padding: 0;
    }

    .about-section ul li::before {
        content: '✓';
        margin-right: 8px;
        color: #8e77f5;
    }

    .social-links {
        margin-top: 30px;
    }

    .social-links a {
        margin: 0 10px;
        color: #8e77f5;
        font-size: 20px;
        transition: color 0.3s;
    }

    .social-links a:hover {
        color: #6a57e0;
    }

    @media (max-width: 600px) {
        .about-wrapper {
            padding: 30px 20px;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
        }
    }
</style>

<div class="about-wrapper">
    <img src="{{ asset('images/nisa.jpeg') }}" alt="Foto Annisa" class="profile-pic">

    <div class="about-header">
        <h1>Annisa Bulan Agustina</h1>
        <p>"Bukan tentang seberapa cepat kamu sampai, tapi seberapa kuat kamu bertahan dan terus melangkah."</p>
    </div>

    <div class="about-section">
        <h2>Tentang Saya</h2>
        <p>Saya Annisa Bulan Agustina, siswi SMK Pusdikhubad Cimahi yang saat ini sedang menempuh pendidikan di program keahlian Rekayasa Perangkat Lunak. Saya lahir di Cimahi pada tanggal 9 Agustus 2007.</p>
        <p>RPL awalnya bukan jurusan yang saya pilih, namun seiring waktu saya mulai mengenal dunia teknologi, pemrograman, dan pengembangan perangkat lunak. Ternyata, bidang ini sangat menantang dan menarik. Dari pengalaman belajar yang saya jalani, saya banyak mempelajari hal baru, seperti coding, desain UI/UX, hingga manajemen database.</p>
    </div>

    <div class="about-section">
        <h2>Keahlian</h2>
        <ul>
            <li>HTML, CSS, JavaScript (Vanilla & Alpine.js)</li>
            <li>Laravel & PHP OOP</li>
            <li>UI/UX Design (Figma)</li>
            <li>Database: MySQL & SQLite</li>
        </ul>
    </div>

    <div class="about-section">
        <h2>Kontak</h2>
        <p>Email: <a href="mailto:annisa@example.com">annisa@example.com</a></p>
        <p>GitHub: <a href="https://github.com/annisabulan" target="_blank">github.com/annisabulan</a></p>
        <p>Instagram: <a href="https://instagram.com/annisabulan" target="_blank">@annisabulan</a></p>
    </div>

    <div class="social-links">
        <a href="mailto:annisa@example.com" title="Email"><i class="fas fa-envelope"></i></a>
        <a href="https://github.com/annisabulan" target="_blank" title="GitHub"><i class="fab fa-github"></i></a>
        <a href="https://instagram.com/annisabulan" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
    </div>
</div>
@endsection
