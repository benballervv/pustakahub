<?= $this->extend('layout_clear') ?>
<?= $this->section('content') ?>

<?php
$username = [
    'name'        => 'username',
    'class'       => 'form-control custom-input',
    'placeholder' => 'Enter your email',
    'required'    => true
];

$password = [
    'name'        => 'password',
    'class'       => 'form-control custom-input',
    'placeholder' => 'Enter your password',
    'required'    => true
];
?>

<style>
/* Reset dasar untuk memastikan tidak ada margin/padding default yang mengganggu */
body, html {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    background-color: #f4f6fb;
    font-family: 'Poppins', sans-serif;
}

/* WRAPPER UTAMA */
.login-wrapper {
    position: relative;
    min-height: 100vh;
    width: 100%;
    overflow: hidden; 
}

/* BACKGROUND GRADIENT */
.login-bg-gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 55vh;
    background: linear-gradient(135deg, #6a5af9, #ff6ec7);
    border-top-left-radius: 120px;
    z-index: 1;
}

/* HEADER NAVIGATION */
.top-bar {
    position: absolute;
    top: 30px;
    left: 40px;
    font-weight: 700;
    font-size: 1.2rem;
    color: #333;
    z-index: 10;
}

.signup-link {
    position: absolute;
    top: 30px;
    right: 40px;
    font-weight: 500;
    z-index: 10;
}

.signup-link a {
    color: #6a5af9;
    text-decoration: none;
    font-weight: 600;
}

/* ========================================= */
/* CONTAINER UNTUK MEMBUAT FORM KE TENGAH    */
/* ========================================= */
.center-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh; /* Memastikan tinggi 100% layar */
    width: 100%;
    position: relative;
    z-index: 5; /* Harus lebih tinggi dari background gradient */
}

/* LOGIN CARD */
.login-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 40px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
    margin: 0 20px; /* Margin agar tidak mentok di layar HP */
}

.login-card h3 {
    font-weight: 700;
    color: #222;
    text-align: center;
    margin-bottom: 25px;
}

/* INPUT STYLING */
.mb-3, .mb-4 {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 500;
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 8px;
}

.custom-input {
    width: 100%;
    box-sizing: border-box;
    border-radius: 12px;
    padding: 14px 16px;
    border: 1px solid #e0e0e0;
    background-color: #fcfcfc;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.custom-input:focus {
    border-color: #6a5af9;
    background-color: #ffffff;
    box-shadow: 0 0 0 4px rgba(106, 90, 249, 0.1);
    outline: none;
}

/* BUTTONS */
.w-100 {
    width: 100%;
}

.btn-login {
    background: linear-gradient(135deg, #6a5af9, #7f6cff);
    color: white;
    border-radius: 12px;
    padding: 14px;
    border: none;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: 0.3s;
}

.btn-login:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(106, 90, 249, 0.3);
}

.btn-google {
    background: #ffffff;
    border: 1px solid #dcdcdc;
    border-radius: 12px;
    padding: 12px;
    font-weight: 500;
    color: #555;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
    cursor: pointer;
    box-sizing: border-box;
}

.btn-google:hover {
    background: #f9f9f9;
    border-color: #ccc;
    color: #333;
}

.divider-text {
    font-size: 0.85rem;
    color: #999;
    text-align: center;
    margin: 20px 0;
}

.alert-danger {
    background-color: #fee2e2;
    color: #991b1b;
    padding: 12px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 20px;
    border: 1px solid #fecaca;
    font-size: 0.9rem;
}
</style>

<div class="login-wrapper">
    <div class="top-bar">📚 PustakaHub</div>
    <div class="signup-link">
        Don't have an account? <a href="<?= base_url('register') ?>">Sign up</a>
    </div>

    <div class="login-bg-gradient"></div> 

    <div class="center-container">
        
        <div class="login-card">
            <h3>Welcome back!</h3>

            <?php if (session()->getFlashdata('failed')): ?>
                <div class="alert-danger">
                    <?= session()->getFlashdata('failed') ?>
                </div>
            <?php endif; ?>

            <?= form_open('login/process') ?>
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <?= form_input($username) ?>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <?= form_password($password) ?>
            </div>

            <button type="submit" class="btn-login w-100">Log In</button>

            <?= form_close() ?>

            <div class="divider-text">
                or login with
            </div>

            <a href="<?= base_url('auth/google') ?>" class="btn-google w-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48">
                    <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                    <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                    <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                    <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                </svg>
                Google
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>