<?= $this->extend('templates/index'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        background: linear-gradient(135deg, #3a7bd5, #3a6073);
        overflow: hidden;
        position: relative;
        font-family: 'Nunito', sans-serif;
    }

    .bubble {
        position: absolute;
        bottom: -100px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 50%;
        animation: rise linear infinite;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        opacity: 0.6;
    }

    @keyframes rise {
        0% {
            transform: translateY(0) scale(1);
            opacity: 0.6;
        }

        100% {
            transform: translateY(-1200px) scale(1.5);
            opacity: 0;
        }
    }

    .login-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        color: white;
        max-width: 520px;
        margin: 0 auto;
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .brand-title {
        text-align: center;
        font-size: 2.2rem;
        font-weight: 900;
        background: linear-gradient(to right, #ffffff, #d1e3ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
        margin-bottom: 10px;
        animation: fadeInDown 1s ease-in-out;
    }

    .login-title {
        text-align: center;
        font-weight: 600;
        margin-bottom: 25px;
        color: #fff;
        animation: fadeInUp 1.2s ease-in-out;
    }

    .form-control-user {
        border-radius: 30px;
        padding: 15px 20px;
        border: none;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        transition: box-shadow .2s ease, transform .05s ease, background .2s ease;
    }

    .form-control-user:focus {
        outline: none;
        box-shadow: 0 0 0 .2rem rgba(209, 227, 255, .25);
        background: rgba(255, 255, 255, 0.25);
    }

    /* password toggle */
    .password-wrap {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: rgba(255, 255, 255, .85);
        padding: 6px;
        line-height: 1;
        cursor: pointer;
    }

    .password-toggle:focus {
        outline: none;
        box-shadow: 0 0 0 .2rem rgba(209, 227, 255, .18);
        border-radius: 10px;
    }

    .password-toggle:hover {
        color: #fff;
    }

    /* kasih ruang biar icon tidak nutup text */
    #passwordInput {
        padding-right: 46px;
    }

    .btn-user {
        border-radius: 30px;
        padding: 12px;
        font-weight: 600;
    }

    .btn-user:hover {
        transform: translateY(-1px);
    }

    .alert {
        border-radius: 14px;
    }

    a.small {
        color: #eee !important;
    }

    a.small:hover {
        text-decoration: underline;
    }

    @keyframes fadeInDown {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- Bubble elements -->
<?php for ($i = 0; $i < 25; $i++): ?>
    <?php
    $left = rand(0, 100);
    $width = rand(15, 50);
    $height = rand(15, 50);
    $duration = rand(8, 18);
    $delay = rand(0, 15);
    ?>
    <div class="bubble" style="
        left: <?= $left ?>%;
        width: <?= $width ?>px;
        height: <?= $height ?>px;
        animation-duration: <?= $duration ?>s;
        animation-delay: <?= $delay ?>s;">
    </div>
<?php endfor; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="login-card">
            <h1 class="brand-title">AKA Laundry</h1>
            <h2 class="brand-title">Login</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form class="user" action="/login/action" method="post" autocomplete="on">
                <div class="form-group">
                    <input type="text"
                           name="username"
                           class="form-control form-control-user"
                           placeholder="Enter Username"
                           required
                           autocomplete="username">
                </div>

                <div class="form-group password-wrap">
                    <input type="password"
                           id="passwordInput"
                           name="password"
                           class="form-control form-control-user"
                           placeholder="Password"
                           required
                           autocomplete="current-password"
                           aria-describedby="togglePasswordBtn">
                    <button type="button"
                            id="togglePasswordBtn"
                            class="password-toggle"
                            aria-label="Tampilkan password"
                            aria-pressed="false">
                        <i id="togglePasswordIcon" class="fas fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="btn btn-light btn-user btn-block">Login</button>
            </form>

            <hr style="background: rgba(255,255,255,0.3);">
            <div class="text-center">
                <a>Ngga punya Akun? tanya admin lah</a>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const input = document.getElementById('passwordInput');
        const btn = document.getElementById('togglePasswordBtn');
        const icon = document.getElementById('togglePasswordIcon');
        if (!input || !btn || !icon) return;

        function setState(visible) {
            input.type = visible ? 'text' : 'password';
            btn.setAttribute('aria-pressed', visible ? 'true' : 'false');
            btn.setAttribute('aria-label', visible ? 'Sembunyikan password' : 'Tampilkan password');
            icon.className = visible ? 'fas fa-eye-slash' : 'fas fa-eye';
        }

        btn.addEventListener('click', function () {
            setState(input.type === 'password');
            input.focus();
        });

        // default
        setState(false);
    })();
</script>

<?= $this->endSection(); ?>