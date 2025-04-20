<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Change Email | SIPOLIV – Sistem Presensi Oliv Store</title>

    <!-- Tabler CSS -->
    <link href="<?= base_url('../assets/css/tabler.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('../assets/css/demo.min.css') ?>" rel="stylesheet" />

    <!-- Font & Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('../assets/img/company/logo.png') ?>">

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
            max-width: 450px;
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
            font-size: 1.5rem;
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
            padding: 12px 15px;
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

        .invalid-feedback {
            color: #e53935;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .alert {
            border-radius: 12px;
            font-size: 0.9rem;
        }

        .page-center {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div class="page page-center">
        <div class="wrapper">
            <div class="logo">
                <img src="<?= base_url('../assets/img/company/logo3.png') ?>" alt="O-Present">
            </div>
            <div class="name">Change Email</div>

            <?php if (session()->getFlashdata('berhasil')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('berhasil') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('gagal')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('gagal') ?>
                </div>
            <?php endif; ?>

            <form action="<?= url_to('update-email') ?>" method="post" autocomplete="off" novalidate>
                <?= csrf_field() ?>

                <div class="form-field">
                    <input name="token" type="text" placeholder="<?= lang('Auth.token') ?>" class="<?= validation_show_error('token') ? 'is-invalid' : '' ?>" value="<?= old('token', $token ?? '') ?>">
                </div>
                <?php if (validation_show_error('token')) : ?>
                    <div class="invalid-feedback"><?= validation_show_error('token') ?></div>
                <?php endif ?>

                <div class="form-field">
                    <input name="email" type="email" placeholder="<?= lang('Auth.email') ?>" class="<?= validation_show_error('email') ? 'is-invalid' : '' ?>" value="<?= old('email') ?>">
                </div>
                <?php if (validation_show_error('email')) : ?>
                    <div class="invalid-feedback"><?= validation_show_error('email') ?></div>
                <?php endif ?>

                <div class="form-field">
                    <input name="newEmail" type="email" placeholder="New Email Address" class="<?= validation_show_error('newEmail') ? 'is-invalid' : '' ?>" value="<?= old('newEmail') ?>">
                </div>
                <?php if (validation_show_error('newEmail')) : ?>
                    <div class="invalid-feedback"><?= validation_show_error('newEmail') ?></div>
                <?php endif ?>

                <button type="submit" class="btn-submit mt-2">
                    <i class="fas fa-envelope me-1"></i> Change Email
                </button>
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
