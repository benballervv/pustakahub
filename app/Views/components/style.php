<style>
    body {
        margin: 0;
        padding: 15px; /* Jarak luar seperti bingkai */
        height: 100vh; /* Kunci tinggi layar */
        overflow: hidden; /* Cegah body ter-scroll */
        background-color: #eeddff; /* Warna ungu muda luar */
        font-family: 'Poppins', sans-serif;
    }

    /* App Container Utama */
    .app-container {
        display: flex;
        height: 100%;
        background-color: #fdfdfe;
        border-radius: 30px; /* Sudut membulat */
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    /* --- SIDEBAR (Fixed) --- */
    .sidebar-wrapper {
        width: 250px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Pisahkan menu atas dan logout di bawah */
        padding: 30px 20px;
        border-right: 1px solid #f0f0f0;
        background: #fff;
    }
    .sidebar-menu { list-style: none; padding: 0; margin-top: 30px; }
    .sidebar-menu li a {
        display: flex; align-items: center; padding: 12px 20px;
        color: #888; text-decoration: none; border-radius: 15px;
        margin-bottom: 5px; font-weight: 500; transition: 0.3s;
    }
    .sidebar-menu li a i { margin-right: 15px; font-size: 20px; }
    .sidebar-menu li a.active {
        background: linear-gradient(135deg, #a66cf8, #d06af9); color: white;
        box-shadow: 0 4px 15px rgba(166, 108, 248, 0.4);
    }
    .sidebar-menu li a:hover:not(.active) { background: #f4f4f4; }
    .sidebar-footer { border-top: 1px solid #eee; padding-top: 20px; }

    /* --- MAIN AREA --- */
    .main-area {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden; /* Kunci area ini, kita buat scroll di anaknya */
    }

    /* Header (Fixed) */
    .header-wrapper {
        flex-shrink: 0; padding: 25px 30px;
        display: flex; justify-content: space-between; align-items: center;
    }
    .search-bar-custom {
        border-radius: 20px; border: 1px solid #eee; padding: 12px 25px;
        width: 350px; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .btn-purple {
        background: linear-gradient(135deg, #a66cf8, #d06af9);
        color: white; border-radius: 15px; padding: 10px 25px; border: none; font-weight: 600;
    }

    /* Area Konten (Scrollable) */
    .content-scrollable {
        flex-grow: 1;
        overflow-y: auto; /* INI YANG MEMBUAT KONTEN BISA DI-SCROLL */
        padding: 0 30px 30px 30px;
        display: flex;
        gap: 30px; /* Jarak antara konten tengah dan panel kanan */
    }
    /* Kustomisasi Scrollbar agar rapi */
    .content-scrollable::-webkit-scrollbar { width: 6px; }
    .content-scrollable::-webkit-scrollbar-thumb { background: #dcdcdc; border-radius: 10px; }

    .content-center { flex-grow: 1; }

    /* Panel Kanan (Sticky) */
    .content-right {
        width: 300px; flex-shrink: 0; position: sticky; top: 0; height: max-content;
    }

    /* --- ELEMEN DASHBOARD --- */
    .welcome-banner { background: linear-gradient(135deg, #8558f7, #d06af9); border-radius: 25px; padding: 40px; color: white; }
    .stat-card { border-radius: 20px; border: 1px solid #f0f0f0; text-align: center; padding: 25px 15px; background: #fff; }
    .stat-card-wrapper { border-top: 4px solid; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.02);}
    .border-blue { border-color: #4e73df; } .border-pink { border-color: #e83e8c; } .border-green { border-color: #1cc88a; }

    /* Recent Activity Table & Custom Table Area */
    .recent-activity-card, .table-card {
        background: #fff; border-radius: 20px; padding: 25px; border: 1px solid #f0f0f0; box-shadow: 0 5px 20px rgba(0,0,0,0.02);
    }
    .table-custom th, table thead th { color: #aaa; font-weight: 600; font-size: 13px; text-transform: uppercase; border-bottom: 2px solid #eee; padding-bottom: 15px;}
    .table-custom td, table tbody td { padding: 15px 0; vertical-align: middle; border-bottom: 1px solid #f8f9fa; font-weight: 500;}
    
    /* --- BADGE & BUTTON KUSTOMISASI (UNTUK BUKU/ANGGOTA) --- */
    .btn-custom {
        background: linear-gradient(135deg, #a66cf8, #d06af9);
        color: white; border-radius: 15px; padding: 10px 22px; border: none; font-weight: 600;
        transition: 0.3s;
    }
    .btn-custom:hover {
        box-shadow: 0 4px 15px rgba(166, 108, 248, 0.3);
        opacity: 0.9;
    }
    .badge-custom, .badge-dipinjam { background: #eef2ff; color: #5c3cf2; padding: 8px 15px; border-radius: 10px; font-size: 12px; font-weight: 600;}
    .badge-dikembalikan { background: #fce8f3; color: #e83e8c; padding: 8px 15px; border-radius: 10px; font-size: 12px; font-weight: 600;}
    .section-title { font-weight: 700; color: #2b2b2b; }
</style>