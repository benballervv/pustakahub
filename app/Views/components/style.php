<style>
    body {
        margin: 0;
        padding: 15px; /* Jarak luar seperti bingkai */
        height: 100vh; /* Kunci tinggi layar */
        overflow: hidden; /* Cegah body ter-scroll */
        background-color: #eeddff; /* Warna ungu muda luar */
        font-family: 'Poppins', sans-serif;
    }

    .app-container {
        display: flex;
        height: 100%;
        background-color: #fdfdfe;
        border-radius: 30px; /* Sudut membulat */
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    /* =========================================================
    2. SIDEBAR COMPONENTS
    ========================================================= */
    .sidebar-wrapper {
        width: 250px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 30px 20px;
        border-right: 1px solid #f0f0f0;
        background: #fff;
    }

    .sidebar-menu { 
        list-style: none; padding: 0; margin-top: 30px; 
    }

    .sidebar-menu li a {
        display: flex; align-items: center; padding: 12px 20px;
        color: #888; text-decoration: none; border-radius: 15px;
        margin-bottom: 5px; font-weight: 500; transition: 0.3s;
    }

    .sidebar-menu li a i { 
        margin-right: 15px; font-size: 20px; 
    }

    .sidebar-menu li a.active {
        background: linear-gradient(135deg, #a66cf8, #d06af9); 
        color: white;
        box-shadow: 0 4px 15px rgba(166, 108, 248, 0.4);
    }

    .sidebar-menu li a:hover:not(.active) { 
        background: #f4f4f4; 
    }

    .sidebar-footer { 
        border-top: 1px solid #eee; padding-top: 20px; 
    }

    /* =========================================================
    3. MAIN AREA & HEADER
    ========================================================= */
    .main-area {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .header-wrapper {
        flex-shrink: 0; padding: 25px 30px;
        display: flex; justify-content: space-between; align-items: center;
    }

    .search-bar-custom {
        border-radius: 20px; border: 1px solid #eee; padding: 12px 25px;
        width: 350px; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    .content-scrollable {
        flex-grow: 1;
        overflow-y: auto; 
        padding: 0 30px 30px 30px;
        display: flex;
        gap: 30px;
    }

    /* Kustomisasi Scrollbar */
    .content-scrollable::-webkit-scrollbar { width: 6px; }
    .content-scrollable::-webkit-scrollbar-thumb { background: #dcdcdc; border-radius: 10px; }

    .content-center { flex-grow: 1; }

    .content-right {
        width: 300px; flex-shrink: 0; position: sticky; top: 0; height: max-content;
    }

    /* =========================================================
    4. CUSTOM UTILITIES & COLORS (Warna Ungu Seragam)
    ========================================================= */
    .bg-gradient-purple { 
        background: linear-gradient(135deg, #a66cf8, #d06af9); 
        color: white; 
    }
    .text-purple { color: #a66cf8 !important; }
    .text-opacity-90 { opacity: 0.9; }
    .banner-icon { font-size: 3.5rem; }
    .section-title { font-weight: 700; color: #2b2b2b; }

    /* Buttons */
    .btn-custom {
        background: linear-gradient(135deg, #a66cf8, #d06af9);
        color: white; border-radius: 15px; padding: 10px 22px; 
        border: none; font-weight: 600; transition: 0.3s;
    }
    .btn-custom:hover {
        box-shadow: 0 4px 15px rgba(166, 108, 248, 0.4);
        opacity: 0.9;
        color: white;
    }

    /* Badges */
    .badge-purple, .badge-dipinjam { 
        background-color: #f0e6ff; color: #a66cf8; 
        padding: 8px 15px; border-radius: 10px; font-size: 12px; font-weight: 600;
    }
    .badge-dikembalikan { 
        background: #fce8f3; color: #e83e8c; 
        padding: 8px 15px; border-radius: 10px; font-size: 12px; font-weight: 600;
    }

    /* Avatar */
    .avatar-purple { 
        width: 45px; height: 45px; 
        background: linear-gradient(135deg, #a66cf8, #d06af9); 
        color: white; font-weight: bold; font-size: 1.2rem; 
        display: flex; justify-content: center; align-items: center; 
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(166, 108, 248, 0.2); 
    }

    /* =========================================================
    5. CARDS & TABLES
    ========================================================= */
    .stat-card, .recent-activity-card, .table-card {
        background: #fff; border-radius: 20px; padding: 25px; 
        border: 1px solid #f0f0f0; box-shadow: 0 5px 20px rgba(0,0,0,0.02);
    }

    .table-custom th, table thead th { 
        color: #aaa; font-weight: 600; font-size: 13px; 
        text-transform: uppercase; border-bottom: 2px solid #eee; padding-bottom: 15px;
    }
    .table-custom td, table tbody td { 
        padding: 15px 0; vertical-align: middle; 
        border-bottom: 1px solid #f8f9fa; font-weight: 500;
    }

    /* =========================================================
    6. INTERACTIVE CALENDAR
    ========================================================= */
    .btn-cal-nav { 
        background: #f4f4f4; border: none; width: 28px; height: 28px; 
        border-radius: 8px; color: #888; font-weight: 600; 
        cursor: pointer; transition: 0.3s; 
        display: flex; align-items: center; justify-content: center; 
    }
    .btn-cal-nav:hover { 
        background: #f0e6ff; color: #a66cf8; 
    }
    .calendar-weekdays-grid { 
        display: grid; grid-template-columns: repeat(7, 1fr); 
        text-align: center; color: #aaa; font-weight: 600; 
        font-size: 11px; text-transform: uppercase; margin-bottom: 10px; 
    }
    .calendar-days-grid { 
        display: grid; grid-template-columns: repeat(7, 1fr); 
        text-align: center; font-size: 13px; row-gap: 5px; 
    }
    .cal-day { 
        padding: 8px 0; font-weight: 500; color: #444; 
        border-radius: 10px; cursor: pointer; transition: 0.3s; user-select: none; 
    }
    .cal-day:hover:not(.empty) { 
        background: #f4f4f4; color: #a66cf8; 
    }
    .cal-day.active { 
        background: linear-gradient(135deg, #a66cf8, #d06af9); 
        color: white !important; font-weight: 600; 
        box-shadow: 0 4px 10px rgba(166, 108, 248, 0.4); 
    }
    .cal-day.empty { 
        color: transparent; cursor: default; pointer-events: none; 
    }

    /* =========================================================
    7. RESPONSIVE (MEDIA QUERIES) - POIN 8 RUBRIK
    ========================================================= */
    
    /* 1. Perbaikan Global: Ubah lebar search bar agar fleksibel */
    .search-bar-custom {
        width: 100% !important; 
        max-width: 350px;
    }

    /* 2. Layar Medium (Tablet / Layar Split-Screen seperti di foto Anda) */
    @media (max-width: 992px) {
        .sidebar-wrapper { 
            width: 220px; 
            padding: 20px 15px; 
        }
        .header-wrapper { 
            padding: 20px 25px; 
        }
        .content-scrollable { 
            flex-direction: column; /* Konten kanan (kalender) turun ke bawah */
            gap: 20px; 
        }
        .content-right { 
            width: 100%; 
            position: static; /* Matikan sticky agar tidak menabrak */
        }
    }

    /* 3. Layar Kecil (Mobile / Smartphone) */
    @media (max-width: 768px) {
        /* Mengubah sidebar menjadi mode Icon-Only tanpa Javascript */
        .sidebar-wrapper { 
            width: 80px; 
            padding: 20px 10px; 
            align-items: center; 
        }
        
        /* Sembunyikan teks logo "PustakaHub", sisakan ikon buku */
        .sidebar-wrapper .fs-4 span { display: none; }
        .sidebar-wrapper .fs-4::before { content: "📚"; font-size: 24px; }
        
        /* Sembunyikan teks menu, sisakan ikon dan pusatkan */
        .sidebar-menu li a { 
            font-size: 0; 
            justify-content: center; 
            padding: 15px; 
        }
        .sidebar-menu li a i { 
            margin-right: 0; 
            font-size: 22px; 
        }

        /* Rapikan header agar sejajar vertikal */
        .header-wrapper { 
            flex-direction: column; 
            gap: 15px; 
            align-items: flex-start; 
        }
        .search-bar-custom { 
            max-width: 100%; 
        }
        .content-scrollable { 
            padding: 0 15px 15px 15px; 
        }
    }

    /* 4. Layar Sangat Kecil (Mobile Portrait) */
    @media (max-width: 576px) {
        body { 
            padding: 0; /* Hilangkan bingkai ungu luar agar layar HP lebih lega */
        }
        .app-container { 
            border-radius: 0; 
        }
    }
</style>