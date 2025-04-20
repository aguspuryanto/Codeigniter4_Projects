<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Forgot Password | SIPOLIV – Sistem Presensi Oliv Store</title>

    <!-- Tabler CSS -->
    <link href="<?= base_url('../assets/css/tabler.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('../assets/css/demo.min.css') ?>" rel="stylesheet" />

    <!-- Google Fonts & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #ecf0f3;
            margin: 0;
        }

        .wrapper {
            max-width: 400px;
            margin: 80px auto;
            padding: 40px 30px;
            background-color: #ecf0f3;
            border-radius: 15px;
            box-shadow: 13px 13px 20px #cbced1,
                        -13px -13px 20px #fff;
        }

        .logo {
            width: 80px;
            margin: auto;
        }

        .logo img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0px 0px 3px #5f5f5f,
                        0px 0px 0px 5px #ecf0f3,
                        8px 8px 15px #a7aaa7,
                        -8px -8px 15px #fff;
        }

        .name {
            font-weight: 600;
            font-size: 1.4rem;
            letter-spacing: 1.3px;
            color: #555;
            text-align: center;
            margin-top: 15px;
            margin-bottom: 25px;
        }

        .form-field {
            position: relative;
            margin-bottom: 20px;
            border-radius: 20px;
            box-shadow: inset 8px 8px 8px #cbced1,
                        inset -8px -8px 8px #fff;
        }

        .form-field input {
            width: 100%;
            border: none;
            outline: none;
            background: none;
            padding: 10px 15px;
            font-size: 1rem;
            color: #333;
            border-radius: 20px;
        }

        .btn-submit {
            width: 100%;
            height: 45px;
            background-color: #03A9F4;
            color: white;
            border: none;
            border-radius: 25px;
            box-shadow: 3px 3px 3px #b1b1b1,
                        -3px -3px 3px #fff;
            transition: 0.3s;
            font-weight: 500;
        }

        .btn-submit:hover {
            background-color: #0288D1;
        }

        .form-footer a {
            color: #03A9F4;
            font-size: 0.85rem;
        }

        .form-footer a:hover {
            color: #0288D1;
            text-decoration: underline;
        }

        .invalid-feedback {
            color: #e53935;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .page-center {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
    </style>

    <link rel="icon" type="image/png" href="<?= base_url('../assets/img/company/logo3.png') ?>">
</head>

<body>
    <div class="page page-center">
        <div class="wrapper">
            <div class="logo">
                <img src="<?= base_url('../assets/img/company/logo3.png') ?>" alt="O-Present">
            </div>
            <div class="name">Forgot Password</div>

            <?= view('Myth\Auth\Views\_message_block') ?>

            <form action="<?= url_to('forgot') ?>" method="post" autocomplete="off" novalidate>
                <?= csrf_field() ?>

                <div class="form-field">
                    <input name="email" type="email" placeholder="<?= lang('Auth.email') ?>" class="<?= session('errors.email') ? 'is-invalid' : '' ?>">
                </div>
                <?php if (session('errors.email')) : ?>
                    <div class="invalid-feedback"><?= session('errors.email') ?></div>
                <?php endif ?>

                <button type="submit" class="btn-submit mt-3">
                    <i class="fas fa-paper-plane me-1"></i> <?= lang('Auth.sendInstructions') ?>
                </button>
            </form>

            <div class="form-footer text-center mt-3">
                <a href="<?= base_url('login') ?>">Send me back to the sign in screen</a>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
