<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - PustakaHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Gradient Ungu khas PustakaHub */
        .bg-shape {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 55vh;
            background: linear-gradient(135deg, #6b4ce6 0%, #d558c8 100%);
            border-top-left-radius: 100px;
            z-index: -1;
        }

        /* Navbar Header */
        .header {
            display: flex;
            justify-content: space-between;
            padding: 20px 40px;
            align-items: center;
        }
        .header .logo { font-weight: bold; font-size: 1.2rem; }
        .header .login-link { color: #555; text-decoration: none; }
        .header .login-link a { color: #6b4ce6; text-decoration: none; font-weight: 600; }

        /* Card Form */
        .register-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            margin-top: 5vh;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e1e1e1;
            margin-bottom: 15px;
        }
        .form-control:focus {
            border-color: #6b4ce6;
            box-shadow: 0 0 0 0.25rem rgba(107, 76, 230, 0.1);
        }

        .btn-primary-custom {
            background-color: #6b4ce6;
            border: none;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            font-weight: 600;
            color: white;
            margin-top: 10px;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover { background-color: #583bb4; color: white;}

        .btn-google {
            background-color: white;
            border: 1px solid #e1e1e1;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            font-weight: 500;
            color: #555;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="bg-shape"></div>

    <div class="header">
        <div class="logo">📚 PustakaHub</div>
        <div class="login-link">
            Already have an account? <a href="<?= base_url('login') ?>">Log in</a>
        </div>
    </div>

    <div class="container">
        <div class="register-card">
            <h3 class="text-center fw-bold mb-4">Create an account</h3>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger" style="border-radius: 10px; font-size: 0.9em;">
                    <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <form action="<?= base_url('auth/process_register') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label class="form-label text-muted" style="font-size: 0.9em;">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" value="<?= old('nama') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted" style="font-size: 0.9em;">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="example@email.com" value="<?= old('email') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted" style="font-size: 0.9em;">No. Telepon</label>
                    <input type="text" name="no_telp" class="form-control" placeholder="0812xxxxxxx" value="<?= old('no_telp') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted" style="font-size: 0.9em;">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Buat password (min. 6 karakter)" required>
                </div>

                <button type="submit" class="btn-primary-custom">Sign Up</button>
                
                <div class="text-center mt-3 mb-3 text-muted" style="font-size: 0.85em;">or sign up with</div>
                
                <button type="button" class="btn-google">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google" width="18" class="me-2"> Google
                </button>
            </form>
        </div>
    </div>

</body>
</html>