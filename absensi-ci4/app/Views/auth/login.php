<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login | SIPOLIV – Sistem Presensi Oliv Store</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('../assets/img/company/logo.png') ?>">

    <!-- Custom Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">

    <!-- Bootstrap (jika diperlukan) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

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
            max-width: 350px;
            min-height: 500px;
            margin: 80px auto;
            padding: 40px 30px;
            background-color: #ecf0f3;
            border-radius: 15px;
            box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
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
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .form-field {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-left: 10px;
            border-radius: 20px;
            box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
        }

        .form-field input {
            width: 100%;
            border: none;
            outline: none;
            background: none;
            font-size: 1.2rem;
            color: #666;
            padding: 10px 15px;
        }

        .form-field .fas, .form-field .far {
            color: #555;
        }

        .btn-login {
            width: 100%;
            height: 40px;
            background-color: #03A9F4;
            color: #fff;
            border: none;
            border-radius: 25px;
            box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            background-color: #039BE5;
        }

        .text-center.fs-6 a {
            text-decoration: none;
            font-size: 0.8rem;
            color: #03A9F4;
        }

        .text-center.fs-6 a:hover {
            color: #039BE5;
        }

        .invalid-feedback {
            font-size: 0.8rem;
            color: red;
            padding-left: 5px;
        }

        @media(max-width: 400px) {
            .wrapper {
                margin: 30px 15px;
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="logo">
            <img src="<?= base_url('../assets/img/company/logo3.png') ?>" alt="SIPOLIV">
        </div>
        <div class="name">
            SIPOLIV – Presensi Oliv Store
        </div>

        <!-- Message Block -->
        <?= view('Myth\Auth\Views\_message_block') ?>

        <!-- FORM -->
        <form action="<?= url_to('login') ?>" method="post" class="p-3 mt-3" autocomplete="off">
            <?= csrf_field() ?>

            <!-- Login Field -->
            <div class="form-field">
                <span class="far fa-user p-2"></span>
                <input type="<?= $config->validFields === ['email'] ? 'email' : 'text' ?>" name="login" placeholder="<?= $config->validFields === ['email'] ? lang('Auth.email') : lang('Auth.emailOrUsername') ?>" class="<?= session('errors.login') ? 'is-invalid' : '' ?>" value="<?= old('login') ?>">
            </div>
            <?php if (session('errors.login')) : ?>
                <div class="invalid-feedback"><?= session('errors.login') ?></div>
            <?php endif; ?>

            <!-- Password Field -->
            <div class="form-field">
                <span class="fas fa-key p-2"></span>
                <input type="password" name="password" placeholder="<?= lang('Auth.password') ?>" class="<?= session('errors.password') ? 'is-invalid' : '' ?>">
            </div>
            <?php if (session('errors.password')) : ?>
                <div class="invalid-feedback"><?= session('errors.password') ?></div>
            <?php endif; ?>

            <!-- Remember Me -->
            <?php if ($config->allowRemembering) : ?>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php if (old('remember')) : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="remember"><?= lang('Auth.rememberMe') ?></label>
                </div>
            <?php endif; ?>

            <!-- Submit -->
            <button type="submit" class="btn btn-login mt-3"><?= lang('Auth.loginAction') ?></button>
        </form>

        <!-- Links -->
        <div class="text-center fs-6 mt-3">
            <?php if ($config->activeResetter) : ?>
                <a href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
            <?php endif; ?>
            <?php if ($config->allowRegistration) : ?>
                or <a href="<?= url_to('register') ?>"><?= lang('Auth.needAnAccount') ?></a>
            <?php endif; ?>
        </div>
    </div>

    <!-- JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>
