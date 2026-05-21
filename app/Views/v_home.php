<?= $this->extend('layout_clear') ?>
<?= $this->section('content') ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
    color:#2d3436;
    background:
        radial-gradient(circle at top left, rgba(108,99,255,0.18), transparent 25%),
        radial-gradient(circle at bottom right, rgba(224,86,253,0.18), transparent 25%),
        #f6f4ff;
}

/* WRAPPER */
.dashboard-wrapper{
    min-height:100vh;
    padding:30px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.dashboard-card{
    width:100%;
    max-width:1450px;
    background:rgba(255,255,255,0.92);
    backdrop-filter:blur(10px);
    border-radius:32px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.5);
    box-shadow:
        0 25px 60px rgba(108,99,255,0.15),
        0 10px 25px rgba(224,86,253,0.08);
}

/* SIDEBAR */
.sidebar{
    background:
        linear-gradient(
            180deg,
            rgba(108,99,255,0.04),
            rgba(224,86,253,0.02)
        );
    min-height:100%;
    padding:35px 24px;
    border-right:1px solid #f1f1f1;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.logo{
    font-size: 1.1rem;
    font-weight:700;
    color:#2d3436;
    margin-bottom:40px;
    display:flex;
    align-items:center;
    gap:10px;
    white-space: nowrap;
    overflow: visible;
}

.logo span{
    color:#6C63FF;
}

.menu-links{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.menu-item{
    text-decoration:none;
    color:#8c8c8c;
    font-size:14px;
    font-weight:500;
    padding:14px 18px;
    border-radius:16px;
    transition:0.3s;
    display:flex;
    align-items:center;
    gap:14px;
}

.menu-item:hover{
    transform:translateX(5px);
    background:
        linear-gradient(
            90deg,
            rgba(108,99,255,0.08),
            rgba(224,86,253,0.06)
        );
    color:#6C63FF;
}

.menu-active{
    background:linear-gradient(135deg,#6C63FF,#E056FD);
    color:white !important;
    box-shadow:0 10px 25px rgba(108,99,255,0.25);
}

.logout-btn{
    margin-top:40px;
    padding-top:20px;
    border-top:1px solid #f1f1f1;
}

/* MAIN CONTENT */
.main-content{
    padding:35px 40px;
    background:#fafaff;
    min-height:100%;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.search-box{
    width:380px;
    padding:14px 20px;
    border-radius:16px;
    border:1px solid #ececec;
    background:white;
    font-size:14px;
    outline:none;
    transition:0.3s;
    box-shadow:0 4px 14px rgba(0,0,0,0.03);
}

.search-box:focus{
    border-color:#6C63FF;
    box-shadow:0 0 0 4px rgba(108,99,255,0.1);
}

.btn-custom{
    border:none;
    padding:12px 24px;
    border-radius:16px;
    color:white;
    font-size:14px;
    font-weight:600;
    background:linear-gradient(135deg,#6C63FF,#E056FD);
    box-shadow:0 10px 20px rgba(108,99,255,0.2);
    transition:0.3s;
}

.btn-custom:hover{
    transform:translateY(-2px);
    box-shadow:0 15px 25px rgba(108,99,255,0.3);
}

/* BANNER */
.welcome-banner{
    position:relative;
    overflow:hidden;
    border-radius:28px;
    padding:45px;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(135deg,#6C63FF,#E056FD);
    box-shadow:0 20px 45px rgba(108,99,255,0.25);
}

.welcome-banner::before{
    content:'';
    position:absolute;
    width:260px;
    height:260px;
    border-radius:50%;
    background:rgba(255,255,255,0.12);
    top:-120px;
    right:-70px;
}

.welcome-banner::after{
    content:'';
    position:absolute;
    width:180px;
    height:180px;
    border-radius:50%;
    background:rgba(255,255,255,0.08);
    bottom:-80px;
    left:-40px;
}

.welcome-text{
    position:relative;
    z-index:2;
    max-width:60%;
}

.welcome-text h2{
    font-size:32px;
    font-weight:700;
    margin-bottom:12px;
}

.welcome-text p{
    font-size:14px;
    opacity:0.9;
}

.banner-illustration{
    position:relative;
    z-index:2;
    font-size:90px;
    transform:rotate(8deg);
}

/* SECTION */
.section-title-container{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:35px;
    margin-bottom:20px;
}

.section-title{
    font-size:18px;
    font-weight:700;
    color:#2d3436;
}

.view-all-link{
    text-decoration:none;
    color:#6C63FF;
    font-size:13px;
    font-weight:600;
}

/* MINI CARD */
.mini-card{
    position:relative;
    overflow:hidden;
    background:white;
    border-radius:24px;
    padding:24px;
    text-align:center;
    border:1px solid #f1f1f1;
    transition:0.3s;
    box-shadow:0 5px 20px rgba(0,0,0,0.03);
}

.mini-card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(108,99,255,0.08);
}

.mini-card::before{
    content:'';
    position:absolute;
    left:0;
    top:0;
    width:100%;
    height:5px;
}

.col-md-3:nth-child(1) .mini-card::before{
    background:linear-gradient(90deg,#6C63FF,#8E7CFF);
}

.col-md-3:nth-child(2) .mini-card::before{
    background:linear-gradient(90deg,#E056FD,#FF8CCF);
}

.col-md-3:nth-child(3) .mini-card::before{
    background:linear-gradient(90deg,#4FACFE,#00F2FE);
}

.col-md-3:nth-child(4) .mini-card::before{
    background:linear-gradient(90deg,#43E97B,#38F9D7);
}

.icon-wrapper{
    width:60px;
    height:60px;
    border-radius:18px;
    margin:0 auto 16px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:26px;
    box-shadow:0 8px 18px rgba(0,0,0,0.05);
}

.col-md-3:nth-child(1) .icon-wrapper{
    background:rgba(108,99,255,0.12);
}

.col-md-3:nth-child(2) .icon-wrapper{
    background:rgba(224,86,253,0.12);
}

.col-md-3:nth-child(3) .icon-wrapper{
    background:rgba(79,172,254,0.12);
}

.col-md-3:nth-child(4) .icon-wrapper{
    background:rgba(67,233,123,0.12);
}

.mini-card h5{
    font-size:15px;
    font-weight:700;
    margin-bottom:5px;
}

.mini-card p{
    font-size:13px;
    color:#8c8c8c;
}

/* TABLE */
.table-card{
    background:white;
    border-radius:24px;
    padding:25px;
    border:1px solid #f5f5f7;
    box-shadow:0 4px 20px rgba(0,0,0,0.02);
}

.table{
    margin-bottom:0;
}

.table th{
    border-bottom:1px solid #f5f5f7 !important;
    color:#b5b5c3;
    font-size:12px;
    text-transform:uppercase;
    padding:16px 10px;
}

.table td{
    padding:18px 10px;
    vertical-align:middle;
    border-bottom:1px solid #f8f8fa;
}

.table tbody tr{
    transition:0.3s;
}

.table tbody tr:hover{
    background:rgba(108,99,255,0.04);
}

.badge-custom{
    display:inline-block;
    padding:7px 15px;
    border-radius:14px;
    font-size:12px;
    font-weight:600;
    color:#6C63FF;
    background:
        linear-gradient(
            135deg,
            rgba(108,99,255,0.18),
            rgba(108,99,255,0.08)
        );
}

.badge-return{
    color:#E056FD;
    background:
        linear-gradient(
            135deg,
            rgba(224,86,253,0.18),
            rgba(224,86,253,0.08)
        );
}

/* RIGHT PANEL */
.right-panel{
    padding:35px 25px;
    background:
        linear-gradient(
            180deg,
            rgba(255,255,255,1),
            rgba(250,245,255,1)
        );
    min-height:100%;
}

.profile-box{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:35px;
}

.avatar{
    width:52px;
    height:52px;
    border-radius:16px;
    background:linear-gradient(135deg,#6C63FF,#E056FD);
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
    font-weight:700;
    box-shadow:0 10px 20px rgba(108,99,255,0.25);
}

.calendar-container{
    margin-bottom:35px;
}

.calendar-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
}

.calendar-days-grid{
    display:flex;
    justify-content:space-between;
    padding:15px 10px;
    border-radius:20px;
    background:
        linear-gradient(
            135deg,
            rgba(108,99,255,0.04),
            rgba(224,86,253,0.03)
        );
}

.cal-day{
    width:45px;
    padding:10px;
    border-radius:14px;
    text-align:center;
}

.cal-day span:first-child{
    display:block;
    font-size:11px;
    color:#b5b5c3;
}

.cal-day span:last-child{
    font-size:14px;
    font-weight:700;
}

.cal-day.active{
    background:#6C63FF;
    box-shadow:0 6px 15px rgba(108,99,255,0.3);
}

.cal-day.active span{
    color:white;
}

/* ACTIVITY */
.activity-list{
    display:flex;
    flex-direction:column;
    gap:15px;
}

.activity-card{
    padding:12px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    transition:0.3s;
}

.activity-card:hover{
    background:rgba(108,99,255,0.05);
}

.member-info{
    display:flex;
    align-items:center;
    gap:12px;
}

.small-avatar{
    width:42px;
    height:42px;
    border-radius:12px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-weight:700;
    background:rgba(108,99,255,0.1);
    color:#6C63FF;
}

.small-avatar.alt-color{
    background:rgba(224,86,253,0.1);
    color:#E056FD;
}

.member-details .name{
    font-size:13px;
    font-weight:600;
}

.member-details .status-text{
    font-size:11px;
    color:#b5b5c3;
}

/* SCROLLBAR */
::-webkit-scrollbar{
    width:8px;
}

::-webkit-scrollbar-thumb{
    background:linear-gradient(#6C63FF,#E056FD);
    border-radius:10px;
}
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-card">
        <div class="row g-0">

            <div class="col-md-3 col-lg-2">
                <div class="sidebar">
                    <div>
                        <div class="logo" style="white-space: nowrap;">
                            📚 <span>Pustaka</span>Hub
                        </div>

                        <div class="menu-links">
                            <a href="<?= base_url('/') ?>" class="menu-item menu-active">🏠 Dashboard</a>
                            <a href="<?= base_url('buku') ?>" class="menu-item">📚 Buku</a> 
                            <a href="<?= base_url('anggota') ?>" class="menu-item">👤 Anggota</a>
                            <a href="<?= base_url('peminjaman') ?>" class="menu-item">📖 Peminjaman</a>
                            <a href="#" class="menu-item">📊 Laporan</a>
                        </div>
                    </div>

                    <div class="logout-btn">
                        <a href="<?= base_url('logout') ?>" class="menu-item text-danger">🚪 Logout</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-7">
                <div class="main-content">

                    <div class="topbar">
                        <input type="text" class="search-box" placeholder="Search something...">
                        <button class="btn-custom">+ Add New</button>
                    </div>

                    <div class="welcome-banner">
                        <div class="welcome-text">
                            <h2>Good Morning, <?= session()->get('nama') ?? 'User' ?> 👋</h2>
                            <p>Welcome back to PustakaHub dashboard. Manage books and members easily today.</p>
                        </div>
                        <div class="banner-illustration">👩‍💻</div>
                    </div>

                    <div class="section-title-container">
                        <h5 class="section-title">Quick Stats</h5>
                        <a href="#" class="view-all-link">View All</a>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="mini-card">
                                <div class="icon-wrapper">📚</div>
                                <h5>Total Buku</h5>
                                <p><?= number_format($total_buku) ?> Buku</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="mini-card">
                                <div class="icon-wrapper">👤</div>
                                <h5>Anggota</h5>
                                <p><?= number_format($total_anggota) ?> Member</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('peminjaman') ?>" style="text-decoration: none; color: inherit;">
                                <div class="mini-card">
                                    <div class="icon-wrapper">📖</div>
                                    <h5>Peminjaman</h5>
                                    <p>120 Aktif</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="mini-card">
                                <div class="icon-wrapper">📊</div>
                                <h5>Laporan</h5>
                                <p>20 Bulan Ini</p>
                            </div>
                        </div>
                    </div>

                    <div class="section-title-container">
                        <h5 class="section-title">Recent Activity</h5>
                        <a href="#" class="view-all-link">View All</a>
                    </div>

                    <div class="table-card">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Buku</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">Destian</td>
                                    <td>Algoritma & Pemrograman</td>
                                    <td><span class="badge-custom">Dipinjam</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Fahruul</td>
                                    <td>Basis Data</td>
                                    <td><span class="badge-custom badge-return">Dikembalikan</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Raka</td>
                                    <td>Machine Learning</td>
                                    <td><span class="badge-custom">Dipinjam</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="right-panel">

                    <div class="profile-box">
                        <div class="avatar">
                            <?= strtoupper(substr(session()->get('nama') ?? 'U', 0, 1)) ?>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold"><?= session()->get('nama') ?? 'User' ?></h6>
                            <small class="text-muted"><?= session()->get('role') ?? 'Member' ?></small>
                        </div>
                    </div>

                    <div class="calendar-container">
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        $month_name = date('F');
                        $start_date = strtotime('monday this week');
                        ?>
                        
                        <div class="calendar-header">
                            <h6 class="fw-bold mb-0">Schedule Calendar</h6>
                            <span class="text-muted"><?= $month_name ?></span>
                        </div>
                        
                        <div class="calendar-days-grid">
                            <?php
                            for ($i = 0; $i < 5; $i++) {
                                $current_time = strtotime("+$i days", $start_date);
                                $day_name = date('D', $current_time);
                                $day_num = date('d', $current_time);
                                $is_today = (date('Y-m-d', $current_time) == date('Y-m-d')) ? 'active' : '';
                            ?>
                                <div class="cal-day <?= $is_today ?>">
                                    <span><?= $day_name ?></span><span><?= $day_num ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="activity-section">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Active Members</h6>
                            <a href="#" class="view-all-link">View All</a>
                        </div>

                        <div class="activity-list">
                            <div class="activity-card">
                                <div class="member-info">
                                    <div class="small-avatar">D</div>
                                    <div class="member-details">
                                        <div class="name">Destian</div>
                                        <div class="status-text">Sedang Meminjam</div>
                                    </div>
                                </div>
                                <div>•••</div>
                            </div>

                            <div class="activity-card">
                                <div class="member-info">
                                    <div class="small-avatar alt-color">F</div>
                                    <div class="member-details">
                                        <div class="name">Fahruul</div>
                                        <div class="status-text">Online</div>
                                    </div>
                                </div>
                                <div>•••</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>