{{-- =========================================================
resources/views/dashboard/bank-sampah.blade.php

KARSA NIRMALA - BANK SAMPAH GIS
FIX MAP ONLY
- Konsep, fitur, sidebar, dan desain utama dipertahankan.
- Leaflet hanya satu library.
- Tanpa GeoJSON.
- API /api/bank-sampah hanya sekali.
- Map diinisialisasi sebelum proses lain.
- CDN Leaflet menggunakan jsDelivr tanpa integrity yang salah.
- Container map mempunyai height stabil.
- invalidateSize dijalankan setelah layout siap dan saat resize.
- Overlay "Lokasi aktif • Akurasi..." di dalam map tidak digunakan.
========================================================= --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bank Sampah - Karsa Nirmala</title>

    {{-- Leaflet CSS: satu-satunya library peta --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">

    <style>
        :root {
            --primary:#79d20a;
            --primary-dark:#55ad00;
            --primary-soft:#effbdc;
            --green:#16a34a;
            --green-soft:#dcfce7;
            --yellow:#eab308;
            --yellow-soft:#fef9c3;
            --red:#ef4444;
            --red-soft:#fee2e2;
            --blue:#2563eb;
            --blue-soft:#dbeafe;
            --text:#172033;
            --text-secondary:#6f7a8d;
            --border:#e7ebef;
            --background:#f6f8f7;
            --white:#ffffff;
            --sidebar-width:288px;
            --shadow-sm:0 4px 16px rgba(20,32,43,.05);
            --shadow-md:0 12px 32px rgba(20,32,43,.08);
        }

        *{box-sizing:border-box}

        html{scroll-behavior:smooth}

        body{
            margin:0;
            font-family:Inter,ui-sans-serif,system-ui,-apple-system,
                BlinkMacSystemFont,"Segoe UI",sans-serif;
            color:var(--text);
            background:
                linear-gradient(180deg,#fff 0%,#f7faf8 45%,#f4f8f5 100%);
            overflow-x:hidden;
        }

        button,input,select{font:inherit}
        button{cursor:pointer}

        /* =====================================================
           SIDEBAR - DIPERTAHANKAN SESUAI ARAHAN
        ====================================================== */
        .sidebar{
            position:fixed;
            left:0;
            top:0;
            bottom:0;
            width:var(--sidebar-width);
            background:#fff;
            border-right:1px solid #dfe5eb;
            z-index:5000;
            overflow-y:auto;
            box-shadow:0 4px 18px rgba(20,32,43,.04);
        }

        .sidebar-header{
            height:76px;
            border-bottom:1px solid #dfe5eb;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 20px;
        }

        .sidebar-brand{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .sidebar-brand-icon{
            width:44px;
            height:44px;
            border-radius:50%;
            background:var(--primary);
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 7px 16px rgba(121,210,10,.22);
        }

        .sidebar-brand-icon svg{
            width:22px;
            height:22px;
        }

        .sidebar-brand-text{
            display:flex;
            flex-direction:column;
        }

        .sidebar-brand-text strong{
            font-size:22px;
            line-height:1;
            font-weight:900;
            color:#101828;
        }

        .sidebar-brand-text span{
            margin-top:5px;
            color:#667085;
            font-size:11px;
            line-height:1.3;
            max-width:150px;
        }

        .sidebar-close{
            display:none;
            border:0;
            background:#f1f5f9;
            color:#475569;
            width:38px;
            height:38px;
            border-radius:12px;
            font-size:24px;
        }

        .sidebar-content{
            padding:18px 14px 24px;
        }

        .sidebar-section-title{
            margin:0 8px 14px;
            color:#94a3b8;
            font-size:12px;
            font-weight:900;
            text-transform:uppercase;
            letter-spacing:.03em;
        }

        .sidebar-menu{
            display:flex;
            flex-direction:column;
            gap:8px;
        }

        .sidebar-link{
            width:100%;
            min-height:62px;
            display:flex;
            align-items:center;
            gap:13px;
            padding:8px 7px;
            border-radius:15px;
            color:#101828;
            background:transparent;
            border:0;
            text-decoration:none;
            font-size:16px;
            font-weight:500;
            transition:background .18s ease,color .18s ease;
            text-align:left;
        }

        .sidebar-link:hover,
        .sidebar-link.active{
            background:#f4fae9;
            color:#4d9900;
        }

        .sidebar-link.active{font-weight:700}

        .sidebar-link-icon{
            width:46px;
            height:46px;
            flex:0 0 46px;
            border-radius:15px;
            background:#f0f4f8;
            color:#53667f;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .sidebar-link-icon svg{
            width:21px;
            height:21px;
        }

        .sidebar-link.active .sidebar-link-icon{
            background:#ecf9d5;
            color:#61ad08;
        }

        .sidebar-link.logout{color:#ef3340}
        .sidebar-link.logout:hover{background:#fff1f2;color:#ef3340}
        .sidebar-link.logout .sidebar-link-icon{
            color:#ff3042;
            background:#f5f7fa;
        }

        .sidebar-overlay{
            display:none;
            position:fixed;
            inset:0;
            background:rgba(15,23,42,.42);
            backdrop-filter:blur(2px);
            z-index:4999;
        }

        /* =====================================================
           HEADER
        ====================================================== */
        .top-header{
            position:sticky;
            top:0;
            z-index:3000;
            height:76px;
            background:rgba(255,255,255,.96);
            border-bottom:1px solid #dfe5eb;
            margin-left:var(--sidebar-width);
        }

        .header-inner{
            width:min(calc(100% - 40px),1480px);
            height:100%;
            margin:0 auto;
            display:flex;
            align-items:center;
            gap:14px;
        }

        .hamburger-button{
            width:42px;
            height:42px;
            display:none;
            align-items:center;
            justify-content:center;
            border:0;
            border-radius:12px;
            background:#f1f5f9;
        }

        .hamburger-lines{
            display:flex;
            flex-direction:column;
            gap:4px;
        }

        .hamburger-lines span{
            width:18px;
            height:2px;
            background:#475569;
            border-radius:10px;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:10px;
            color:var(--text);
            text-decoration:none;
        }

        .brand-logo{
            width:40px;
            height:40px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:var(--primary);
            color:#fff;
            font-size:20px;
            box-shadow:0 6px 14px rgba(121,210,10,.20);
        }

        .brand-text{
            display:flex;
            flex-direction:column;
        }

        .brand-text strong{
            font-size:18px;
            line-height:1;
            font-weight:900;
        }

        .brand-text span{
            margin-top:4px;
            color:#7a8799;
            font-size:11px;
        }

        .user-area{
            margin-left:auto;
            display:flex;
            align-items:center;
            gap:10px;
        }

        .notification-button{
            width:40px;
            height:40px;
            border:0;
            background:transparent;
            color:#64748b;
            font-size:20px;
        }

        .avatar{
            width:40px;
            height:40px;
            border-radius:50%;
            background:#edf0f3;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#475569;
            font-size:13px;
            font-weight:700;
        }

        .user-info{
            display:flex;
            flex-direction:column;
        }

        .user-info strong{font-size:13px}
        .user-info span{font-size:11px;color:#94a3b8;margin-top:2px}

        /* =====================================================
           MAIN
        ====================================================== */
        .main-content{
            margin-left:var(--sidebar-width);
            min-height:calc(100vh - 76px);
        }

        .page-container{
            width:min(1480px,calc(100% - 48px));
            margin:0 auto;
            padding:36px 0 60px;
        }

        .page-heading{margin-bottom:20px}

        .eyebrow{
            display:inline-flex;
            align-items:center;
            gap:7px;
            padding:8px 12px;
            border:1px solid #dff0c2;
            background:#f8fdea;
            color:#4d9700;
            border-radius:999px;
            font-size:11px;
            font-weight:800;
        }

        .page-heading h1{
            margin:14px 0 7px;
            font-size:34px;
            line-height:1.1;
            font-weight:900;
            letter-spacing:-.03em;
        }

        .page-heading h1 span{color:var(--primary-dark)}

        .page-heading p{
            margin:0;
            max-width:760px;
            color:var(--text-secondary);
            font-size:13px;
            line-height:1.7;
        }

        /* =====================================================
           LOCATION STATUS DI LUAR MAP
           Popup kiri "Lokasi aktif • Akurasi..." tidak dibuat.
        ====================================================== */
        .location-status{
            min-height:54px;
            margin-bottom:18px;
            padding:12px 16px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:18px;
            border:1px solid #e4e9ee;
            border-radius:16px;
            background:#fff;
            box-shadow:var(--shadow-sm);
        }

        .location-status-left{
            display:flex;
            align-items:center;
            gap:9px;
            font-size:12px;
            color:#667085;
            font-weight:600;
        }

        .location-status-dot{
            width:9px;
            height:9px;
            border-radius:50%;
            background:#cbd5e1;
            flex:0 0 9px;
        }

        .location-status-dot.active{background:#22c55e}
        .location-status-dot.error{background:#ef4444}
        .location-status-dot.waiting{
            background:#eab308;
            box-shadow:0 0 0 4px rgba(234,179,8,.12);
        }

        .nearest-info{
            text-align:right;
            color:#667085;
            font-size:12px;
        }

        .nearest-info strong{color:#334155}

        /* =====================================================
           STATISTICS
        ====================================================== */
        .stats-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:16px;
            margin-bottom:22px;
        }

        .stat-card{
            background:#fff;
            border:1px solid var(--border);
            border-radius:18px;
            padding:18px 20px;
            box-shadow:var(--shadow-sm);
        }

        .stat-label{
            color:#7a8799;
            font-size:11px;
            font-weight:700;
        }

        .stat-value{
            margin-top:8px;
            font-size:28px;
            line-height:1;
            font-weight:900;
        }

        .stat-value.green{color:var(--green)}
        .stat-value.red{color:var(--red)}

        /* =====================================================
           FILTER
        ====================================================== */
        .filter-card{
            background:#fff;
            border:1px solid var(--border);
            border-radius:18px;
            padding:18px;
            margin-bottom:22px;
            box-shadow:var(--shadow-sm);
        }

        .filter-grid{
            display:grid;
            grid-template-columns:minmax(0,1fr) 260px auto;
            gap:14px;
            align-items:end;
        }

        .field{
            display:flex;
            flex-direction:column;
            gap:7px;
        }

        .field label{
            font-size:11px;
            color:#667085;
            font-weight:700;
        }

        .input,.select{
            width:100%;
            height:44px;
            border:1px solid #dce1e7;
            border-radius:11px;
            padding:0 13px;
            outline:none;
            background:#fff;
            color:var(--text);
            font-size:13px;
        }

        .input:focus,.select:focus{
            border-color:var(--primary);
            box-shadow:0 0 0 3px rgba(121,210,10,.12);
        }

        .reset-button{
            height:44px;
            padding:0 17px;
            border:1px solid #dce1e7;
            background:#fff;
            border-radius:11px;
            font-size:12px;
            font-weight:700;
            color:#475467;
        }

        .reset-button:hover{background:#f8fafc}

        /* =====================================================
           MAP - FIX UTAMA
        ====================================================== */
        .map-card{
            position:relative;
            width:100%;
            height:540px;
            margin-bottom:26px;
            overflow:hidden;
            border:1px solid var(--border);
            border-radius:22px;
            background:#e9eef0;
            box-shadow:var(--shadow-md);
            isolation:isolate;
        }

        #bankSampahMap{
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            min-height:0;
            background:#e9eef0;
        }

        /*
         * Jangan paksa ukuran semua img Leaflet.
         * Yang perlu dibatasi hanya tile.
         */
        #bankSampahMap .leaflet-tile{
            max-width:none !important;
            max-height:none !important;
            width:256px !important;
            height:256px !important;
        }

        #bankSampahMap .leaflet-container{
            width:100%;
            height:100%;
            background:#e9eef0;
            font-family:inherit;
        }

        .map-loading{
            position:absolute;
            inset:0;
            z-index:2000;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#eef1f4;
            color:#667085;
            font-size:12px;
            pointer-events:none;
            transition:opacity .15s ease;
        }

        .map-loading.hidden{
            opacity:0;
            visibility:hidden;
        }

        .map-overlay{
            position:absolute;
            z-index:1200;
            top:16px;
            right:16px;
            pointer-events:none;
        }

        .map-location-button{
            pointer-events:auto;
            display:inline-flex;
            align-items:center;
            gap:8px;
            min-height:44px;
            padding:0 16px;
            border:1px solid rgba(226,232,240,.95);
            border-radius:13px;
            background:rgba(255,255,255,.97);
            box-shadow:0 10px 25px rgba(15,23,42,.13);
            color:#344054;
            font-size:12px;
            font-weight:800;
            transition:.2s ease;
        }

        .map-location-button:hover{
            transform:translateY(-1px);
            background:var(--primary-soft);
            border-color:#d9efb4;
        }

        .map-location-button:disabled{
            opacity:.6;
            cursor:wait;
        }

        .location-button-icon{
            width:25px;
            height:25px;
            border-radius:8px;
            background:var(--primary-soft);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:14px;
        }

        /* =====================================================
           RECYCLE MARKER
        ====================================================== */
        .recycle-marker-wrapper{
            background:transparent !important;
            border:0 !important;
        }

        .recycle-marker{
            position:relative;
            width:46px;
            height:54px;
            display:flex;
            align-items:center;
            justify-content:center;
            filter:drop-shadow(0 4px 6px rgba(15,23,42,.22));
        }

        .recycle-marker::before{
            content:"";
            position:absolute;
            width:42px;
            height:42px;
            left:2px;
            top:0;
            border-radius:50% 50% 50% 0;
            transform:rotate(-45deg);
            background:var(--marker-color);
            border:3px solid #fff;
        }

        .recycle-marker-icon{
            position:relative;
            z-index:2;
            width:26px;
            height:26px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:19px;
            font-weight:900;
        }

        .recycle-marker-tail{
            position:absolute;
            left:20px;
            bottom:1px;
            width:6px;
            height:9px;
            background:var(--marker-color);
            transform:rotate(45deg);
            z-index:1;
        }

        /* =====================================================
           USER MARKER = TITIK BIRU
        ====================================================== */
        .user-location-marker{
            width:18px;
            height:18px;
            border-radius:50%;
            background:#2563eb;
            border:3px solid #fff;
            box-shadow:
                0 0 0 4px rgba(37,99,235,.20),
                0 3px 12px rgba(15,23,42,.25);
        }

        /* =====================================================
           POPUP
        ====================================================== */
        .leaflet-popup-content-wrapper{
            border-radius:14px;
        }

        .leaflet-popup-content{
            margin:13px 14px;
            min-width:220px;
            font-family:inherit;
        }

        .popup-title{
            font-size:14px;
            font-weight:900;
            color:#172033;
            margin-bottom:7px;
        }

        .popup-address{
            font-size:11px;
            line-height:1.55;
            color:#667085;
            margin-bottom:8px;
        }

        .popup-status{
            display:inline-flex;
            padding:5px 8px;
            border-radius:999px;
            font-size:10px;
            font-weight:800;
            margin-bottom:8px;
        }

        .status-open,.popup-status.green{
            background:#dcfce7;
            color:#15803d;
        }

        .status-closed,.popup-status.red{
            background:#fee2e2;
            color:#dc2626;
        }

        .status-unknown,.popup-status.yellow{
            background:#fef9c3;
            color:#a16207;
        }

        .popup-info{
            font-size:11px;
            color:#667085;
            line-height:1.55;
            margin:4px 0;
        }

        .popup-buttons{
            display:flex;
            flex-wrap:wrap;
            gap:6px;
            margin-top:10px;
        }

        .popup-button{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:7px 9px;
            border-radius:8px;
            text-decoration:none;
            font-size:10px;
            font-weight:800;
        }

        .google-button{
            background:#eff6ff;
            color:#1d4ed8;
        }

        .popup-whatsapp{
            background:#dcfce7;
            color:#15803d;
        }

        /* =====================================================
           LIST
        ====================================================== */
        .section-heading{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:15px;
            margin-bottom:13px;
        }

        .section-heading h2{
            margin:0;
            font-size:18px;
            font-weight:900;
        }

        .result-count{
            color:#7a8799;
            font-size:11px;
            font-weight:700;
        }

        .loading-state{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            min-height:120px;
            color:#667085;
            font-size:12px;
        }

        .spinner{
            width:18px;
            height:18px;
            border:2px solid #e5e7eb;
            border-top-color:var(--primary);
            border-radius:50%;
            animation:spin .7s linear infinite;
        }

        @keyframes spin{to{transform:rotate(360deg)}}

        .bank-grid{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:16px;
        }

        .bank-card{
            background:#fff;
            border:1px solid var(--border);
            border-radius:18px;
            padding:17px;
            box-shadow:var(--shadow-sm);
            cursor:pointer;
            transition:.2s ease;
        }

        .bank-card:hover{
            transform:translateY(-2px);
            box-shadow:var(--shadow-md);
            border-color:#cfe8a8;
        }

        .bank-card.active{
            border-color:var(--primary);
            box-shadow:0 0 0 3px rgba(121,210,10,.12);
        }

        .bank-card.nearest{
            border-color:#86efac;
            background:#fbfffa;
        }

        .card-top{
            display:flex;
            align-items:flex-start;
            gap:11px;
        }

        .card-icon{
            width:42px;
            height:42px;
            flex:0 0 42px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#ecfdf5;
            color:#16a34a;
            font-size:20px;
        }

        .card-title-wrap{min-width:0}

        .card-title{
            margin:0;
            font-size:14px;
            line-height:1.35;
            font-weight:800;
            color:#172033;
        }

        .status-badge{
            display:inline-flex;
            margin-top:6px;
            padding:5px 8px;
            border-radius:999px;
            font-size:10px;
            font-weight:800;
        }

        .card-address{
            margin:13px 0 7px;
            color:#667085;
            font-size:11px;
            line-height:1.55;
        }

        .card-meta{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
        }

        .card-distance{
            color:#2563eb;
            font-size:11px;
            font-weight:800;
        }

        .card-type{
            color:#7a8799;
            font-size:10px;
        }

        .bank-hours{
            margin-top:12px;
            padding-top:11px;
            border-top:1px solid #eef1f4;
        }

        .bank-hours-title{
            font-size:10px;
            font-weight:800;
            color:#475467;
            margin-bottom:6px;
        }

        .bank-hour-row{
            display:flex;
            justify-content:space-between;
            gap:10px;
            font-size:10px;
            line-height:1.5;
            color:#7a8799;
        }

        .bank-hour-day{font-weight:700;color:#475467}
        .bank-actions{
            display:flex;
            gap:7px;
            margin-top:13px;
        }

        .card-action{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            flex:1;
            min-height:34px;
            border-radius:9px;
            text-decoration:none;
            font-size:10px;
            font-weight:800;
        }

        .card-google{
            background:#eff6ff;
            color:#2563eb;
        }

        .card-whatsapp{
            background:#ecfdf5;
            color:#16a34a;
        }

        .empty-state{
            display:none;
            text-align:center;
            padding:50px 20px;
            color:#667085;
        }

        .empty-state.show{display:block}

        .empty-icon{
            font-size:30px;
            margin-bottom:8px;
        }

        /* =====================================================
           LOCATION PERMISSION PROMPT
        ====================================================== */
        .location-modal{
            position:fixed;
            inset:0;
            z-index:9000;
            display:flex;
            align-items:flex-start;
            justify-content:center;
            padding:22px 16px;
            background:rgba(15,23,42,.45);
            backdrop-filter:blur(5px);
            opacity:0;
            visibility:hidden;
            pointer-events:none;
            transition:.2s ease;
        }

        .location-modal.show{
            opacity:1;
            visibility:visible;
            pointer-events:auto;
        }

        .location-modal-card{
            width:min(470px,100%);
            margin-top:4vh;
            padding:26px;
            border-radius:22px;
            background:#fff;
            box-shadow:0 25px 70px rgba(15,23,42,.22);
        }

        .location-modal-icon{
            width:52px;
            height:52px;
            border-radius:16px;
            background:#effbdc;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            margin-bottom:15px;
        }

        .location-modal-card h3{
            margin:0 0 9px;
            font-size:20px;
            font-weight:900;
        }

        .location-modal-card p{
            margin:0;
            color:#718096;
            font-size:12px;
            line-height:1.7;
        }

        .location-permission-info{
            margin-top:15px;
            padding:12px 13px;
            border-radius:12px;
            background:#f7f9fb;
            color:#718096;
            font-size:11px;
            line-height:1.55;
        }

        .location-permission-actions{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:10px;
            margin-top:17px;
        }

        .location-permission-btn{
            min-height:44px;
            border:0;
            border-radius:11px;
            font-size:12px;
            font-weight:800;
        }

        .location-permission-btn.allow{
            background:#16a34a;
            color:#fff;
        }

        .location-permission-btn.later{
            background:#f1f5f9;
            color:#64748b;
        }

        /* =====================================================
           RESPONSIVE
        ====================================================== */
        @media(max-width:1200px){
            .bank-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
        }

        @media(max-width:900px){
            :root{--sidebar-width:0px}

            .sidebar{
                width:288px;
                transform:translateX(-100%);
                transition:transform .22s ease;
            }

            .sidebar.open{transform:translateX(0)}
            .sidebar-overlay.open{display:block}
            .sidebar-close{display:flex;align-items:center;justify-content:center}

            .top-header,.main-content{margin-left:0}
            .hamburger-button{display:flex}

            .header-inner,.page-container{
                width:min(calc(100% - 28px),1480px)
            }

            .stats-grid{grid-template-columns:1fr}
            .filter-grid{grid-template-columns:1fr}
            .map-card{height:460px}
            .bank-grid{grid-template-columns:1fr}
        }

        @media(max-width:600px){
            .top-header{height:68px}
            .brand-text span,.user-info{display:none}
            .page-container{padding-top:30px}
            .location-status{
                align-items:flex-start;
                flex-direction:column;
            }
            .nearest-info{text-align:left}
            .map-card{height:400px;border-radius:18px}
            .map-location-button{
                top:12px;
                right:12px;
                min-height:42px;
                padding:0 12px;
            }
            .location-modal{padding:14px}
            .location-modal-card{
                margin-top:2vh;
                padding:21px;
                border-radius:20px;
            }
            .location-permission-actions{grid-template-columns:1fr}
        }
    </style>
</head>

<body>

{{-- =========================================================
     SIDEBAR OVERLAY
========================================================= --}}
<div id="sidebarOverlay" class="sidebar-overlay"></div>

{{-- =========================================================
     SIDEBAR
     SESUAI STRUKTUR MENU YANG SUDAH ADA
========================================================= --}}
<aside id="sidebar" class="sidebar" aria-label="Sidebar navigasi">

    <div class="sidebar-header">
        <div class="sidebar-brand">

            <div class="sidebar-brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M12 2L3 7l9 5 9-5-9-5z"/>
                    <path d="M3 17l9 5 9-5"/>
                    <path d="M3 12l9 5 9-5"/>
                </svg>
            </div>

            <div class="sidebar-brand-text">
                <strong>WISE</strong>
                <span>Waste Identification & Sustainability</span>
            </div>

        </div>

        <button type="button"
                id="sidebarClose"
                class="sidebar-close"
                aria-label="Tutup menu">×</button>
    </div>

    <div class="sidebar-content">

        <p class="sidebar-section-title">Main Menu</p>

        <nav class="sidebar-menu">

            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <span class="sidebar-link-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 10 9-7 9 7"/>
                        <path d="M5 9v11h14V9"/>
                        <path d="M9 20v-6h6v6"/>
                    </svg>
                </span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('scanner') }}" class="sidebar-link">
                <span class="sidebar-link-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="5" width="16" height="15" rx="2"/>
                        <path d="M9 5V3h6v2"/>
                        <path d="M9 10h6"/>
                        <path d="M12 10v6"/>
                    </svg>
                </span>
                <span>AI Scanner</span>
            </a>

            <a href="{{ route('scanner.history') }}" class="sidebar-link">
                <span class="sidebar-link-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6h16"/>
                        <path d="M4 12h16"/>
                        <path d="M4 18h16"/>
                    </svg>
                </span>
                <span>History Scan</span>
            </a>

            <a href="{{ route('education') }}" class="sidebar-link">
                <span class="sidebar-link-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H18"/>
                        <path d="M18 6.5A2.5 2.5 0 0 0 15.5 4H6.5A2.5 2.5 0 0 0 4 6.5v11A2.5 2.5 0 0 0 6.5 20H18"/>
                        <path d="M8 4v16"/>
                    </svg>
                </span>
                <span>Education</span>
            </a>

            <a href="{{ route('chatbot') }}" class="sidebar-link">
                <span class="sidebar-link-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </span>
                <span>AI Chatbot</span>
            </a>

            <a href="{{ route('profile') }}" class="sidebar-link">
                <span class="sidebar-link-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>
                <span>Profile</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link logout">
                    <span class="sidebar-link-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </span>
                    <span>Logout</span>
                </button>
            </form>

        </nav>
    </div>
</aside>

{{-- =========================================================
     TOP HEADER
========================================================= --}}
<header class="top-header">
    <div class="header-inner">

        <button type="button"
                id="sidebarToggle"
                class="hamburger-button"
                aria-label="Buka menu"
                aria-expanded="false">
            <span class="hamburger-lines">
                <span></span><span></span><span></span>
            </span>
        </button>

        <a href="{{ route('dashboard') }}" class="brand">
            <div class="brand-logo">♻</div>
            <div class="brand-text">
                <strong>WISE</strong>
                <span>Waste Identification and Sustainability Education</span>
            </div>
        </a>

        <div class="user-area">
            <button type="button" class="notification-button" aria-label="Notifikasi">♧</button>
            <div class="avatar">RA</div>
            <div class="user-info">
                <strong>{{ auth()->user()->name ?? 'ramadani' }}</strong>
                <span>Member</span>
            </div>
        </div>

    </div>
</header>

{{-- =========================================================
     MAIN
========================================================= --}}
<div class="main-content">
<main class="page-container">

    <section class="page-heading">
        <div class="eyebrow">♻️ Smart Waste Network</div>
        <h1>Bank <span>Sampah</span></h1>
        <p>
            Temukan bank sampah di sekitar Surabaya berdasarkan lokasi,
            status operasional, jenis sampah, dan informasi layanan.
        </p>
    </section>

    {{-- Status lokasi TETAP di luar peta --}}
    <div class="location-status">
        <div class="location-status-left">
            <span id="locationStatusDot" class="location-status-dot waiting"></span>
            <span id="locationStatus">Menunggu izin lokasi...</span>
        </div>

        <div id="nearestInfo" class="nearest-info">
            Bank sampah terdekat:
            <strong>Belum tersedia</strong>
        </div>
    </div>

    <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Bank Sampah</div>
            <div id="totalBank" class="stat-value">0</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Sedang Buka</div>
            <div id="openBank" class="stat-value green">0</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Tutup / Tidak Diketahui</div>
            <div id="closedBank" class="stat-value red">0</div>
        </div>
    </section>

    <section class="filter-card">
        <div class="filter-grid">

            <div class="field">
                <label for="bankSearch">Cari Bank Sampah</label>
                <input id="bankSearch"
                       class="input"
                       type="search"
                       placeholder="Cari nama atau alamat..."
                       autocomplete="off">
            </div>

            <div class="field">
                <label for="bankStatusFilter">Status</label>
                <select id="bankStatusFilter" class="select">
                    <option value="all">Semua Status</option>
                    <option value="Buka">Buka</option>
                    <option value="Tutup">Tutup</option>
                    <option value="unknown">Tidak Diketahui</option>
                </select>
            </div>

            <button type="button" id="resetFilter" class="reset-button">
                Reset Filter
            </button>
        </div>
    </section>

    {{-- =====================================================
         MAP
    ====================================================== --}}
    <section id="mapSection" class="map-card">

        <div id="bankSampahMap">
            <div id="mapLoading" class="map-loading">
                Memuat peta...
            </div>
        </div>

        <div class="map-overlay">
            <button type="button"
                    id="myLocationButton"
                    class="map-location-button">
                <span class="location-button-icon">📍</span>
                <span>Lokasi Saya</span>
            </button>
        </div>

    </section>

    <div class="section-heading">
        <div><h2>Daftar Bank Sampah</h2></div>
        <span id="resultCount" class="result-count">Memuat data...</span>
    </div>

    <div id="loadingState" class="loading-state">
        <div class="spinner"></div>
        Memuat data bank sampah...
    </div>

    <div id="bankGrid" class="bank-grid"></div>

    <div id="emptyState" class="empty-state">
        <div class="empty-icon">🔎</div>
        <h3>Bank sampah tidak ditemukan</h3>
        <p>Coba gunakan kata kunci atau filter lainnya.</p>
    </div>

</main>
</div>

{{-- =========================================================
     LOCATION PERMISSION PROMPT
========================================================= --}}
<div id="locationModal"
     class="location-modal"
     role="dialog"
     aria-modal="true"
     aria-hidden="true"
     aria-labelledby="locationModalTitle">

    <div class="location-modal-card">

        <div class="location-modal-icon">📍</div>

        <h3 id="locationModalTitle">Location Permission Prompt</h3>

        <p>
            Izinkan Karsa Nirmala mengakses lokasi Anda untuk
            menampilkan posisi Anda pada peta dan menemukan bank
            sampah terdekat secara realtime.
        </p>

        <div class="location-permission-info">
            🔒 Lokasi digunakan hanya untuk fitur peta,
            perhitungan jarak, dan pencarian bank sampah terdekat.
        </div>

        <div class="location-permission-actions">
            <button type="button"
                    id="allowLocationButton"
                    class="location-permission-btn allow">
                📍 Izinkan Lokasi
            </button>

            <button type="button"
                    id="laterLocationButton"
                    class="location-permission-btn later">
                Nanti
            </button>
        </div>

    </div>
</div>

{{-- Leaflet JS: satu library peta --}}
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /* =====================================================
       CONFIG
    ====================================================== */
    const API_URL = '/api/bank-sampah';

    const DEFAULT_CENTER = [-7.2575, 112.7521];
    const DEFAULT_ZOOM = 12;

    const GEO_OPTIONS = {
        enableHighAccuracy: true,
        maximumAge: 5000,
        timeout: 20000
    };

    const LOCATION_UI_INTERVAL = 1500;

    /* =====================================================
       STATE
    ====================================================== */
    let banks = [];
    let filteredBanks = [];
    let map = null;
    let mapInitialized = false;

    let userMarker = null;
    let userAccuracyCircle = null;
    let userPosition = null;
    let nearestBank = null;

    let watchId = null;
    let lastLocationUIUpdate = 0;
    let locationRequestInProgress = false;

    const bankMarkers = new Map();

    /* =====================================================
       DOM
    ====================================================== */
    const $ = id => document.getElementById(id);

    const sidebar = $('sidebar');
    const sidebarOverlay = $('sidebarOverlay');
    const sidebarToggle = $('sidebarToggle');
    const sidebarClose = $('sidebarClose');

    const locationModal = $('locationModal');
    const allowLocationButton = $('allowLocationButton');
    const laterLocationButton = $('laterLocationButton');

    const bankSearch = $('bankSearch');
    const bankStatusFilter = $('bankStatusFilter');
    const resetFilter = $('resetFilter');

    const bankGrid = $('bankGrid');
    const emptyState = $('emptyState');
    const loadingState = $('loadingState');
    const resultCount = $('resultCount');

    const totalBank = $('totalBank');
    const openBank = $('openBank');
    const closedBank = $('closedBank');

    const locationStatusDot = $('locationStatusDot');
    const locationStatus = $('locationStatus');
    const nearestInfo = $('nearestInfo');

    const mapLoading = $('mapLoading');
    const myLocationButton = $('myLocationButton');
    const mapSection = $('mapSection');

    /* =====================================================
       SAFE CHECK
       ====================================================== */
    function requiredElementsExist() {
        const required = [
            sidebar, sidebarOverlay, sidebarToggle, sidebarClose,
            locationModal, allowLocationButton, laterLocationButton,
            bankSearch, bankStatusFilter, resetFilter, bankGrid,
            emptyState, loadingState, resultCount, totalBank,
            openBank, closedBank, locationStatusDot, locationStatus,
            nearestInfo, mapLoading, myLocationButton,
            $('bankSampahMap')
        ];

        return required.every(Boolean);
    }

    /* =====================================================
       SIDEBAR
    ====================================================== */
    function openSidebar() {
        sidebar.classList.add('open');
        sidebarOverlay.classList.add('open');
        sidebarToggle.setAttribute('aria-expanded', 'true');
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        sidebarOverlay.classList.remove('open');
        sidebarToggle.setAttribute('aria-expanded', 'false');
    }

    sidebarToggle.addEventListener('click', openSidebar);
    sidebarClose.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);

    /* =====================================================
       UTILS
    ====================================================== */
    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function getStatusType(bank) {
        const status = String(bank.status ?? '').trim().toLowerCase();

        if (
            status.includes('buka') ||
            status.includes('open') ||
            status.includes('operasional') ||
            status.includes('24 jam')
        ) return 'open';

        if (
            status.includes('tutup') ||
            status.includes('closed')
        ) return 'closed';

        return 'unknown';
    }

    function getStatusLabel(bank) {
        const type = getStatusType(bank);
        if (type === 'open') return 'Buka';
        if (type === 'closed') return 'Tutup';
        return 'Tidak diketahui';
    }

    function getStatusClass(bank) {
        const type = getStatusType(bank);
        if (type === 'open') return 'status-open';
        if (type === 'closed') return 'status-closed';
        return 'status-unknown';
    }

    function normalizeBank(raw) {
        let operatingHours =
            raw.operating_hours ??
            raw.operatingHours ??
            [];

        if (
            operatingHours &&
            !Array.isArray(operatingHours) &&
            Array.isArray(operatingHours.data)
        ) {
            operatingHours = operatingHours.data;
        }

        if (!Array.isArray(operatingHours)) {
            operatingHours = [];
        }

        return {
            ...raw,
            id: raw.id,
            name: raw.name ?? 'Bank Sampah',
            address: raw.address ?? 'Alamat belum tersedia',
            latitude: parseFloat(raw.latitude),
            longitude: parseFloat(raw.longitude),
            whatsapp: raw.whatsapp ?? '',
            status: raw.status ?? 'Tidak diketahui',
            waste_type:
                raw.waste_type ??
                raw.wasteType ??
                raw.jenis_sampah ??
                'Tidak diketahui',
            operatingHours
        };
    }

    function formatTime(value) {
        if (!value) return '-';
        return String(value).substring(0, 5);
    }

    function getDayName(item) {
        return item.day_name ??
            item.day ??
            item.hari ??
            item.dayName ??
            '-';
    }

    function calculateDistance(lat1, lng1, lat2, lng2) {
        const R = 6371000;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;

        const a =
            Math.sin(dLat / 2) ** 2 +
            Math.cos(lat1 * Math.PI / 180) *
            Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLng / 2) ** 2;

        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    function formatDistance(distance) {
        if (!Number.isFinite(distance)) return '-';

        if (distance < 1000) {
            return Math.round(distance) + ' m';
        }

        return (distance / 1000).toFixed(2) + ' km';
    }

    function googleMapsUrl(bank) {
        const lat = Number(bank.latitude);
        const lng = Number(bank.longitude);

        if (Number.isFinite(lat) && Number.isFinite(lng)) {
            return 'https://www.google.com/maps/dir/?api=1&destination=' +
                encodeURIComponent(lat + ',' + lng);
        }

        return 'https://www.google.com/maps/search/?api=1&query=' +
            encodeURIComponent(
                [bank.name, bank.address].filter(Boolean).join(', ')
            );
    }

    function whatsappUrl(bank) {
        if (!bank.whatsapp) return '';

        let phone = String(bank.whatsapp).replace(/[^0-9]/g, '');

        if (phone.startsWith('0')) {
            phone = '62' + phone.substring(1);
        }

        if (!phone) return '';

        const message = encodeURIComponent(
            'Halo ' + bank.name +
            ', saya ingin mendapatkan informasi mengenai bank sampah.'
        );

        return 'https://wa.me/' + phone + '?text=' + message;
    }

    /* =====================================================
       RECYCLE ICON
       HIJAU = BUKA
       KUNING = TIDAK DIKETAHUI
       MERAH = TUTUP
    ====================================================== */
    function createRecycleIcon(bank) {
        let color = '#eab308';
        const type = getStatusType(bank);

        if (type === 'open') color = '#16a34a';
        if (type === 'closed') color = '#ef4444';

        return L.divIcon({
            className: 'recycle-marker-wrapper',
            html: `
                <div class="recycle-marker" style="--marker-color:${color}">
                    <div class="recycle-marker-icon">♻</div>
                    <div class="recycle-marker-tail"></div>
                </div>
            `,
            iconSize: [46, 54],
            iconAnchor: [23, 54],
            popupAnchor: [0, -50]
        });
    }

    /* =====================================================
       USER ICON = TITIK BIRU
    ====================================================== */
    function createUserIcon() {
        return L.divIcon({
            className: '',
            html: '<div class="user-location-marker"></div>',
            iconSize: [18, 18],
            iconAnchor: [9, 9],
            popupAnchor: [0, -9]
        });
    }

    /* =====================================================
       POPUP
    ====================================================== */
    function createPopup(bank) {
        const statusLabel = getStatusLabel(bank);
        const statusClass = getStatusClass(bank);
        const googleUrl = googleMapsUrl(bank);
        const waUrl = whatsappUrl(bank);

        const distanceHtml =
            Number.isFinite(bank._distance)
                ? `<div class="popup-info">
                    <strong>Jarak:</strong>
                    ${formatDistance(bank._distance)}
                   </div>`
                : '';

        const waHtml = waUrl
            ? `<a href="${waUrl}"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="popup-button popup-whatsapp"
                  onclick="event.stopPropagation()">
                    💬 WhatsApp
               </a>`
            : '';

        return `
            <div>
                <div class="popup-title">
                    ${escapeHtml(bank.name)}
                </div>

                <div class="popup-address">
                    📍 ${escapeHtml(bank.address)}
                </div>

                <div class="popup-status ${statusClass}">
                    ${escapeHtml(statusLabel)}
                </div>

                <div class="popup-info">
                    <strong>Jenis sampah:</strong>
                    ${escapeHtml(bank.waste_type)}
                </div>

                ${bank.whatsapp ? `
                    <div class="popup-info">
                        <strong>WhatsApp:</strong>
                        ${escapeHtml(bank.whatsapp)}
                    </div>
                ` : ''}

                ${distanceHtml}

                <div class="popup-buttons">
                    <a href="${googleUrl}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="popup-button google-button"
                       onclick="event.stopPropagation()">
                        🗺 Google Maps
                    </a>
                    ${waHtml}
                </div>
            </div>
        `;
    }

    /* =====================================================
       MAP INITIALIZATION
       FIX:
       - Map dibuat lebih awal.
       - Tidak menunggu API/GPS.
       - Leaflet CDN valid.
       - Container height stabil.
       - Loading ditutup setelah map benar-benar dibuat.
    ====================================================== */
    function initializeMap() {
        if (mapInitialized) return;

        const mapElement = $('bankSampahMap');

        if (!mapElement) {
            console.error('Element #bankSampahMap tidak ditemukan.');
            return;
        }

        if (typeof window.L === 'undefined') {
            console.error('Leaflet gagal dimuat dari CDN.');
            mapLoading.textContent = 'Leaflet gagal dimuat. Periksa koneksi internet.';
            return;
        }

        try {
            map = L.map(mapElement, {
                zoomControl: true,
                attributionControl: true,
                preferCanvas: true,
                zoomAnimation: false,
                fadeAnimation: false,
                markerZoomAnimation: false,
                inertia: false,
                worldCopyJump: false
            });

            map.setView(DEFAULT_CENTER, DEFAULT_ZOOM, {
                animate: false
            });

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    minZoom: 10,
                    maxZoom: 18,
                    updateWhenIdle: true,
                    updateWhenZooming: false,
                    keepBuffer: 0,
                    detectRetina: false,
                    attribution: '&copy; OpenStreetMap contributors'
                }
            ).addTo(map);

            mapInitialized = true;

            requestAnimationFrame(() => {
                map.invalidateSize(false);
                if (mapLoading) mapLoading.classList.add('hidden');
            });

            setTimeout(() => {
                if (map) map.invalidateSize(false);
            }, 250);

        } catch (error) {
            console.error('Leaflet initialization error:', error);
            if (mapLoading) {
                mapLoading.textContent = 'Peta gagal diinisialisasi.';
            }
        }
    }

    /* =====================================================
       MARKERS
    ====================================================== */
    function renderBankMarkers() {
        if (!map) return;

        banks.forEach(bank => {
            if (
                !Number.isFinite(bank.latitude) ||
                !Number.isFinite(bank.longitude)
            ) return;

            const id = String(bank.id);

            if (bankMarkers.has(id)) {
                const marker = bankMarkers.get(id);
                marker.setIcon(createRecycleIcon(bank));
                marker.setPopupContent(createPopup(bank));
                return;
            }

            const marker = L.marker(
                [bank.latitude, bank.longitude],
                {
                    icon: createRecycleIcon(bank),
                    keyboard: false
                }
            );

            marker.bindPopup(createPopup(bank), {
                autoPan: true,
                autoPanPadding: [20, 20]
            });

            marker.on('click', () => {
                highlightCard(bank.id);
            });

            marker.addTo(map);
            bankMarkers.set(id, marker);
        });

        updateMarkerVisibility();
    }

    function updateMarkerVisibility() {
        if (!map) return;

        const visibleIds = new Set(
            filteredBanks.map(bank => String(bank.id))
        );

        bankMarkers.forEach((marker, id) => {
            if (visibleIds.has(id)) {
                if (!map.hasLayer(marker)) marker.addTo(map);
            } else {
                if (map.hasLayer(marker)) map.removeLayer(marker);
            }
        });
    }

    function updateMarkerIcons() {
        bankMarkers.forEach((marker, id) => {
            const bank = banks.find(item => String(item.id) === String(id));

            if (!bank) return;

            marker.setIcon(createRecycleIcon(bank));

            if (marker.isPopupOpen()) {
                marker.setPopupContent(createPopup(bank));
            }
        });
    }

    /* =====================================================
       FILTER + CARD
    ====================================================== */
    function getFilteredBanks() {
        const keyword = bankSearch.value.trim().toLowerCase();
        const status = bankStatusFilter.value;

        return banks.filter(bank => {
            const text =
                (bank.name + ' ' + bank.address).toLowerCase();

            const matchSearch =
                !keyword || text.includes(keyword);

            let matchStatus = true;

            if (status === 'Buka') {
                matchStatus = getStatusType(bank) === 'open';
            }

            if (status === 'Tutup') {
                matchStatus = getStatusType(bank) === 'closed';
            }

            if (status === 'unknown') {
                matchStatus = getStatusType(bank) === 'unknown';
            }

            return matchSearch && matchStatus;
        });
    }

    function createBankCard(bank) {
        const statusClass = getStatusClass(bank);
        const statusLabel = getStatusLabel(bank);
        const isNearest =
            nearestBank &&
            String(nearestBank.id) === String(bank.id);

        const distance =
            userPosition
                ? calculateDistance(
                    userPosition.lat,
                    userPosition.lng,
                    bank.latitude,
                    bank.longitude
                  )
                : null;

        bank._distance = distance;

        const googleUrl = googleMapsUrl(bank);
        const waUrl = whatsappUrl(bank);

        let hoursHtml = '';

        if (
            Array.isArray(bank.operatingHours) &&
            bank.operatingHours.length
        ) {
            hoursHtml = `
                <div class="bank-hours">
                    <div class="bank-hours-title">🕒 Jam Operasional</div>
                    <div class="bank-hours-list">
                        ${bank.operatingHours.map(hour => {
                            const day = getDayName(hour);
                            const open = formatTime(
                                hour.open_time ??
                                hour.open ??
                                hour.opening_time ??
                                hour.start
                            );
                            const close = formatTime(
                                hour.close_time ??
                                hour.close ??
                                hour.closing_time ??
                                hour.end
                            );
                            const closed =
                                hour.is_closed ??
                                hour.closed ??
                                false;

                            return `
                                <div class="bank-hour-row">
                                    <span class="bank-hour-day">
                                        ${escapeHtml(day)}
                                    </span>
                                    <span>
                                        ${closed ? 'Tutup' : escapeHtml(open + ' - ' + close)}
                                    </span>
                                </div>
                            `;
                        }).join('')}
                    </div>
                </div>
            `;
        }

        return `
            <article class="bank-card ${isNearest ? 'nearest' : ''}"
                     data-bank-id="${escapeHtml(bank.id)}"
                     tabindex="0"
                     role="button">

                <div class="card-top">
                    <div class="card-icon">♻</div>

                    <div class="card-title-wrap">
                        <h3 class="card-title">
                            ${escapeHtml(bank.name)}
                        </h3>

                        <span class="status-badge ${statusClass}">
                            ${escapeHtml(statusLabel)}
                        </span>
                    </div>
                </div>

                <div class="card-address">
                    📍 ${escapeHtml(bank.address)}
                </div>

                <div class="card-meta">
                    <span class="card-type">
                        ${escapeHtml(bank.waste_type)}
                    </span>

                    <span class="card-distance">
                        ${distance !== null ? '📏 ' + formatDistance(distance) : ''}
                    </span>
                </div>

                ${hoursHtml}

                <div class="bank-actions">
                    <a href="${googleUrl}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="card-action card-google"
                       onclick="event.stopPropagation()">
                        🗺 Google Maps
                    </a>

                    ${waUrl ? `
                        <a href="${waUrl}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="card-action card-whatsapp"
                           onclick="event.stopPropagation()">
                            💬 WhatsApp
                        </a>
                    ` : ''}
                </div>
            </article>
        `;
    }

    function renderBankCards() {
        filteredBanks = getFilteredBanks();

        if (userPosition) {
            filteredBanks.sort((a, b) => {
                const da = calculateDistance(
                    userPosition.lat,
                    userPosition.lng,
                    a.latitude,
                    a.longitude
                );

                const db = calculateDistance(
                    userPosition.lat,
                    userPosition.lng,
                    b.latitude,
                    b.longitude
                );

                a._distance = da;
                b._distance = db;

                return da - db;
            });
        }

        resultCount.textContent = filteredBanks.length + ' lokasi';

        if (!filteredBanks.length) {
            bankGrid.innerHTML = '';
            emptyState.classList.add('show');
            updateMarkerVisibility();
            return;
        }

        emptyState.classList.remove('show');

        bankGrid.innerHTML =
            filteredBanks.map(createBankCard).join('');

        document.querySelectorAll('.bank-card').forEach(card => {
            card.addEventListener('click', event => {
                if (event.target.closest('a')) return;
                focusBank(card.dataset.bankId);
            });

            card.addEventListener('keydown', event => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    focusBank(card.dataset.bankId);
                }
            });
        });

        updateMarkerVisibility();
    }

    function highlightCard(bankId) {
        document.querySelectorAll('.bank-card').forEach(card => {
            card.classList.remove('active');
        });

        const selected = document.querySelector(
            `.bank-card[data-bank-id="${CSS.escape(String(bankId))}"]`
        );

        if (selected) selected.classList.add('active');
    }

    /* =====================================================
       CARD -> MAP
    ====================================================== */
    function focusBank(bankId) {
        const bank = banks.find(
            item => String(item.id) === String(bankId)
        );

        if (!bank || !map) return;

        highlightCard(bankId);

        const marker = bankMarkers.get(String(bankId));

        if (mapSection) {
            mapSection.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        setTimeout(() => {
            if (!map) return;

            map.invalidateSize(false);

            map.setView(
                [bank.latitude, bank.longitude],
                16,
                { animate: false }
            );

            if (marker) {
                marker.openPopup();
            }
        }, 350);
    }

    /* =====================================================
       GPS
    ====================================================== */
    function updateUserMarker(position) {
        if (!map) return;

        const lat = Number(position.coords.latitude);
        const lng = Number(position.coords.longitude);
        const accuracy =
            Number(position.coords.accuracy) || 0;

        if (
            !Number.isFinite(lat) ||
            !Number.isFinite(lng)
        ) return;

        userPosition = {
            lat,
            lng,
            accuracy
        };

        const latLng = [lat, lng];

        if (!userMarker) {
            userMarker = L.marker(latLng, {
                icon: createUserIcon(),
                zIndexOffset: 3000,
                keyboard: false
            }).addTo(map);

            userMarker.bindPopup(
                '<strong>📍 Lokasi Saya</strong>'
            );
        } else {
            userMarker.setLatLng(latLng);
        }

        if (!userAccuracyCircle) {
            userAccuracyCircle = L.circle(latLng, {
                radius: Math.max(accuracy, 5),
                color: '#2563eb',
                fillColor: '#2563eb',
                fillOpacity: .06,
                weight: 1,
                interactive: false
            }).addTo(map);
        } else {
            userAccuracyCircle.setLatLng(latLng);
            userAccuracyCircle.setRadius(
                Math.max(accuracy, 5)
            );
        }

        locationStatus.textContent = 'Lokasi aktif';
        locationStatusDot.className =
            'location-status-dot active';

        calculateNearestBank();
    }

    function handleLocationSuccess(position) {
        const now = Date.now();

        userPosition = {
            lat: Number(position.coords.latitude),
            lng: Number(position.coords.longitude),
            accuracy: Number(position.coords.accuracy) || 0
        };

        if (
            now - lastLocationUIUpdate <
            LOCATION_UI_INTERVAL
        ) {
            if (userMarker) {
                userMarker.setLatLng([
                    userPosition.lat,
                    userPosition.lng
                ]);
            }

            if (userAccuracyCircle) {
                userAccuracyCircle.setLatLng([
                    userPosition.lat,
                    userPosition.lng
                ]);
                userAccuracyCircle.setRadius(
                    Math.max(userPosition.accuracy, 5)
                );
            }

            return;
        }

        lastLocationUIUpdate = now;
        updateUserMarker(position);
    }

    function handleLocationError(error) {
        console.warn('GPS error:', error);

        locationStatusDot.className =
            'location-status-dot error';

        if (error && error.code === 1) {
            locationStatus.textContent =
                'Akses lokasi ditolak';
        } else if (error && error.code === 2) {
            locationStatus.textContent =
                'Lokasi tidak tersedia';
        } else if (error && error.code === 3) {
            locationStatus.textContent =
                'Permintaan lokasi timeout';
        } else {
            locationStatus.textContent =
                'Lokasi belum tersedia';
        }

        nearestInfo.innerHTML =
            'Bank sampah terdekat: <strong>Belum diketahui</strong>';

        myLocationButton.disabled = false;
        allowLocationButton.disabled = false;
        locationRequestInProgress = false;
    }

    function startLocationTracking() {
        if (!navigator.geolocation) {
            handleLocationError({code: 2});
            return;
        }

        if (watchId !== null) {
            navigator.geolocation.clearWatch(watchId);
        }

        watchId = navigator.geolocation.watchPosition(
            handleLocationSuccess,
            handleLocationError,
            GEO_OPTIONS
        );
    }

    function requestUserLocation() {
        if (locationRequestInProgress) return;

        if (!navigator.geolocation) {
            handleLocationError({code: 2});
            return;
        }

        locationRequestInProgress = true;
        myLocationButton.disabled = true;
        allowLocationButton.disabled = true;

        locationStatus.textContent =
            'Meminta lokasi perangkat...';

        locationStatusDot.className =
            'location-status-dot waiting';

        hideLocationPermissionPrompt();

        navigator.geolocation.getCurrentPosition(
            position => {
                handleLocationSuccess(position);
                startLocationTracking();

                locationRequestInProgress = false;
                myLocationButton.disabled = false;
                allowLocationButton.disabled = false;

                if (map && userPosition) {
                    map.setView(
                        [userPosition.lat, userPosition.lng],
                        15,
                        {animate: false}
                    );
                }
            },
            error => {
                handleLocationError(error);
                startLocationTracking();
            },
            GEO_OPTIONS
        );
    }

    function calculateNearestBank() {
        if (!userPosition || !banks.length) {
            nearestBank = null;
            nearestInfo.innerHTML =
                'Bank sampah terdekat: <strong>Belum tersedia</strong>';
            return;
        }

        let closest = null;
        let closestDistance = Infinity;

        banks.forEach(bank => {
            if (
                !Number.isFinite(bank.latitude) ||
                !Number.isFinite(bank.longitude)
            ) return;

            const distance = calculateDistance(
                userPosition.lat,
                userPosition.lng,
                bank.latitude,
                bank.longitude
            );

            bank._distance = distance;

            if (distance < closestDistance) {
                closestDistance = distance;
                closest = bank;
            }
        });

        nearestBank = closest;

        if (!closest) return;

        nearestInfo.innerHTML =
            'Bank sampah terdekat: <strong>' +
            escapeHtml(closest.name) +
            '</strong> — ' +
            formatDistance(closestDistance);

        updateMarkerIcons();
        renderBankCards();
    }

    /* =====================================================
       LOCATION BUTTON
    ====================================================== */
    myLocationButton.addEventListener('click', () => {
        if (!userPosition) {
            showLocationPermissionPrompt();
            return;
        }

        if (!map) return;

        map.invalidateSize(false);

        map.setView(
            [userPosition.lat, userPosition.lng],
            16,
            {animate: false}
        );

        if (userMarker) {
            userMarker.openPopup();
        }
    });

    /* =====================================================
       LOCATION PROMPT
    ====================================================== */
    function showLocationPermissionPrompt() {
        locationModal.classList.add('show');
        locationModal.setAttribute('aria-hidden', 'false');

        const previousOverflow = document.body.style.overflow;
        locationModal.dataset.previousOverflow = previousOverflow;
        document.body.style.overflow = 'hidden';
    }

    function hideLocationPermissionPrompt() {
        locationModal.classList.remove('show');
        locationModal.setAttribute('aria-hidden', 'true');

        document.body.style.overflow =
            locationModal.dataset.previousOverflow || '';
    }

    allowLocationButton.addEventListener(
        'click',
        requestUserLocation
    );

    laterLocationButton.addEventListener(
        'click',
        () => {
            hideLocationPermissionPrompt();
            locationStatusDot.className =
                'location-status-dot waiting';
            locationStatus.textContent =
                'Lokasi belum diaktifkan';
        }
    );

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            closeSidebar();
            hideLocationPermissionPrompt();
        }
    });

    /* =====================================================
       SEARCH / FILTER
    ====================================================== */
    bankSearch.addEventListener(
        'input',
        renderBankCards
    );

    bankStatusFilter.addEventListener(
        'change',
        renderBankCards
    );

    resetFilter.addEventListener('click', () => {
        bankSearch.value = '';
        bankStatusFilter.value = 'all';
        renderBankCards();
    });

    /* =====================================================
       API
    ====================================================== */
    async function loadBanks() {
        loadingState.style.display = 'flex';

        try {
            const response = await fetch(API_URL, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                cache: 'default'
            });

            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }

            const result = await response.json();

            let rawData = [];

            if (Array.isArray(result)) {
                rawData = result;
            } else if (
                result &&
                Array.isArray(result.data)
            ) {
                rawData = result.data;
            }

            banks = rawData
                .map(normalizeBank)
                .filter(bank =>
                    Number.isFinite(bank.latitude) &&
                    Number.isFinite(bank.longitude)
                );

            const open = banks.filter(
                bank => getStatusType(bank) === 'open'
            ).length;

            const closed = banks.filter(
                bank => getStatusType(bank) === 'closed'
            ).length;

            totalBank.textContent = banks.length;
            openBank.textContent = open;
            closedBank.textContent = banks.length - open;

            renderBankMarkers();
            renderBankCards();

            if (userPosition) {
                calculateNearestBank();
            }

        } catch (error) {
            console.error('Bank Sampah API Error:', error);

            bankGrid.innerHTML = `
                <div style="
                    grid-column:1/-1;
                    text-align:center;
                    padding:40px;
                    color:#dc2626;
                ">
                    <strong>Gagal memuat data bank sampah.</strong>
                    <br><br>
                    <span style="font-size:12px;color:#667085">
                        Pastikan endpoint /api/bank-sampah tersedia.
                    </span>
                </div>
            `;
        } finally {
            loadingState.style.display = 'none';
        }
    }

    /* =====================================================
       START
       PENTING: MAP DIBUAT TERLEBIH DAHULU.
    ====================================================== */
    if (!requiredElementsExist()) {
        console.error(
            'Elemen halaman bank sampah tidak lengkap.'
        );
        return;
    }

    if (typeof window.L === 'undefined') {
        console.error(
            'Leaflet belum tersedia ketika DOMContentLoaded.'
        );
        mapLoading.textContent =
            'Leaflet belum tersedia. Muat ulang halaman.';
        return;
    }

    initializeMap();

    /*
     * API hanya satu kali.
     */
    loadBanks();

    /*
     * Prompt custom tetap muncul di atas viewport,
     * tidak melakukan scroll ke peta.
     */
    setTimeout(() => {
        showLocationPermissionPrompt();
    }, 350);

    /* =====================================================
       RESIZE
    ====================================================== */
    window.addEventListener('resize', () => {
        if (map) {
            requestAnimationFrame(() => {
                map.invalidateSize(false);
            });
        }
    });

    /*
     * Ketika tab kembali aktif, perbaiki ukuran map
     * tanpa reload tile secara berlebihan.
     */
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden && map) {
            requestAnimationFrame(() => {
                map.invalidateSize(false);
            });
        }
    });

    /* =====================================================
       CLEANUP
    ====================================================== */
    window.addEventListener('beforeunload', () => {
        if (watchId !== null && navigator.geolocation) {
            navigator.geolocation.clearWatch(watchId);
            watchId = null;
        }
    });
});
</script>

</body>
</html>
