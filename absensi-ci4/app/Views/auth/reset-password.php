<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Reset Password | SIPOLIV – Sistem Presensi Oliv Store</title>

    <!-- Tabler CSS -->
    <link href="<?= base_url('../assets/css/tabler.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('../assets/css/demo.min.css') ?>" rel="stylesheet" />

    <!-- Custom Fonts & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #ecf0f3;
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

        .wrapper .name {
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
            <div class="name">Reset Password</div>

            <?= view('Myth\Auth\Views\_message_block') ?>

            <form action="<?= url_to('reset-password') ?>" method="post" autocomplete="off" novalidate>
                <?= csrf_field() ?>

                <div class="form-field">
                    <input name="token" type="text" class="<?= session('errors.token') ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.token') ?>" value="<?= old('token', $token ?? '') ?>" autocomplete="off">
                </div>
                <?php if (session('errors.token')) : ?>
                    <div class="invalid-feedback"><?= session('errors.token') ?></div>
                <?php endif ?>

                <div class="form-field">
                    <input name="email" type="email" class="<?= session('errors.email') ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" autocomplete="off">
                </div>
                <?php if (session('errors.email')) : ?>
                    <div class="invalid-feedback"><?= session('errors.email') ?></div>
                <?php endif ?>

                <div class="form-field">
                    <input name="password" type="password" class="<?= session('errors.password') ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.newPassword') ?>" autocomplete="off">
                </div>
                <?php if (session('errors.password')) : ?>
                    <div class="invalid-feedback"><?= session('errors.password') ?></div>
                <?php endif ?>

                <div class="form-field">
                    <input name="pass_confirm" type="password" class="<?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>" placeholder="<?= lang('Auth.newPasswordRepeat') ?>" autocomplete="off">
                </div>
                <?php if (session('errors.pass_confirm')) : ?>
                    <div class="invalid-feedback"><?= session('errors.pass_confirm') ?></div>
                <?php endif ?>

                <button type="submit" class="btn-submit mt-3"><?= lang('Auth.resetPassword') ?></button>
            </form>

            <div class="form-footer text-center mt-3">
                <a href="<?= url_to('login') ?>">Back to login</a>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
