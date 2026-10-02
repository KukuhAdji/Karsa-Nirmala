{{-- =========================================================
resources/views/dashboard/bank-sampah.blade.php

KARSA NIRMALA - BANK SAMPAH GIS

FINAL VERSION
---------------------------------------------------------
FITUR TETAP:
1. Leaflet CDN
2. Tanpa GeoJSON
3. API /api/bank-sampah
4. Semua marker bank sampah
5. Marker recycle berdasarkan status
6. Marker lokasi user berupa titik biru
7. GPS realtime menggunakan watchPosition
8. Location Permission Prompt
9. Deteksi bank sampah terdekat
10. Update jarak realtime
11. Google Maps
12. WhatsApp
13. Popup detail
14. Search
15. Filter status
16. Klik card fokus ke marker
17. Klik card otomatis menuju peta
18. Button Lokasi Saya
19. Hamburger menu
20. Sidebar
21. Optimized Leaflet tile loading
22. Marker tidak dibuat ulang ketika GPS berubah
23. Popup "Lokasi aktif • Akurasi..." di peta tidak digunakan

REVISI TERBARU:
- Sidebar menggunakan desain Karsa Nirmala.
- Logo Karsa Nirmala diperbesar.
- Sidebar dibuka menggunakan hamburger.
- Tidak ada tombol X.
- Hamburger dapat membuka dan menutup sidebar.
========================================================= --}}

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Bank Sampah - Karsa Nirmala
    </title>


    {{-- =====================================================
    TAILWIND (dibutuhkan component sidebar)
    Preflight dimatikan agar tampilan halaman lain tidak berubah.
    Jika project sudah memakai Tailwind via Vite, ganti blok ini dengan:
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    ====================================================== --}}

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { corePlugins: { preflight: false } };
    </script>


    {{-- =====================================================
    LEAFLET CSS
    ====================================================== --}}

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">


    <style>
        /* =====================================================
           ROOT
        ====================================================== */

        :root {

            --primary:
                #79d20a;

            --primary-dark:
                #55ad00;

            --primary-soft:
                #effbdc;

            --green:
                #16a34a;

            --green-soft:
                #dcfce7;

            --yellow:
                #eab308;

            --yellow-soft:
                #fef9c3;

            --red:
                #ef4444;

            --red-soft:
                #fee2e2;

            --blue:
                #2563eb;

            --blue-soft:
                #dbeafe;

            --text:
                #172033;

            --text-secondary:
                #6f7a8d;

            --border:
                #e7ebef;

            --background:
                #f6f8f7;

            --white:
                #ffffff;

            --sidebar-width:
                325px;

            --shadow-sm:
                0 4px 16px rgba(20, 32, 43, .05);

            --shadow-md:
                0 12px 32px rgba(20, 32, 43, .08);

            --shadow-sidebar:
                12px 0 45px rgba(15, 23, 42, .14);

        }


        /* =====================================================
           RESET
        ====================================================== */

        * {
            box-sizing:
                border-box;
        }


        html {
            scroll-behavior:
                smooth;
        }


        body {

            margin:
                0;

            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            color:
                var(--text);

            background:
                linear-gradient(180deg,
                    #ffffff 0%,
                    #f7faf8 45%,
                    #f4f8f5 100%);

            overflow-x:
                hidden;

        }


        button,
        input,
        select {

            font:
                inherit;

        }


        button {

            cursor:
                pointer;

        }


        a {

            text-decoration:
                none;

        }


        /* =====================================================
           SIDEBAR OVERLAY
        ====================================================== */

        .sidebar-overlay {

            position:
                fixed;

            inset:
                0;

            background:
                rgba(15,
                    23,
                    42,
                    .38);

            backdrop-filter:
                blur(2px);

            -webkit-backdrop-filter:
                blur(2px);

            opacity:
                0;

            visibility:
                hidden;

            pointer-events:
                none;

            transition:
                opacity .22s ease,
                visibility .22s ease;

            z-index:
                4999;

        }


        .sidebar-overlay.open {

            opacity:
                1;

            visibility:
                visible;

            pointer-events:
                auto;

        }


        /* =====================================================
           SIDEBAR (DRAWER)

           Isi sidebar diambil dari component sidebar.blade.php.
           Wrapper ini hanya mengatur posisi & animasi buka/tutup
           lewat hamburger. Tidak ada tombol X.
        ====================================================== */

        .sidebar {
            position: fixed;
            top: 8px;
            left: 2px;
            bottom: 8px;
            width: var(--sidebar-width);
            max-width: calc(100vw - 22px);
            transform: translateX(calc(-100% - 30px));
            opacity: 0;
            visibility: hidden;
            transition: transform .25s ease, opacity .2s ease, visibility .25s ease;
            z-index: 5000;
        }

        .sidebar.open {
            transform: translateX(0);
            opacity: 1;
            visibility: visible;
        }

        /* <aside> dari component dibuat mengisi wrapper drawer */
        .sidebar > aside {
            position: static;
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: none;
            height: 100%;
            min-height: 0;
        }

        .sidebar > aside > .sidebar-scroll {
            flex: 1 1 auto;
            min-height: 0;
        }

        /* Pengganti Tailwind preflight (preflight dimatikan agar CSS halaman tidak berubah) */
        :where(.sidebar) *,
        :where(.sidebar) ::before,
        :where(.sidebar) ::after {
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb;
        }

        :where(.sidebar) h2,
        :where(.sidebar) p {
            margin: 0;
        }

        :where(.sidebar) button {
            background: transparent;
            color: inherit;
        }

        :where(.sidebar) a {
            color: inherit;
        }

        :where(.sidebar) img,
        :where(.sidebar) svg {
            display: block;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }


        /* =====================================================
           TOP HEADER
        ====================================================== */

        .top-header {

            position:
                sticky;

            top:
                0;

            z-index:
                3000;

            height:
                76px;

            background:
                rgba(255,
                    255,
                    255,
                    .96);

            border-bottom:
                1px solid #dfe5eb;

            box-shadow:
                0 2px 12px rgba(15,
                    23,
                    42,
                    .025);

        }


        .header-inner {

            width:
                min(calc(100% - 40px),
                    1480px);

            height:
                100%;

            margin:
                0 auto;

            display:
                flex;

            align-items:
                center;

            gap:
                14px;

        }


        /* =====================================================
           HAMBURGER
           
           SELALU ADA.
           TIDAK ADA X.
        ====================================================== */

        .hamburger-button {

            width:
                46px;

            height:
                46px;

            flex:
                0 0 46px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border:
                1px solid #e2e8f0;

            border-radius:
                15px;

            background:
                #f1f5f9;

            color:
                #475569;

            cursor:
                pointer;

            box-shadow:
                0 3px 10px rgba(15,
                    23,
                    42,
                    .05);

            transition:
                background .18s ease,
                transform .18s ease;

        }


        .hamburger-button:hover {

            background:
                #e8f7d2;

            color:
                #4d9900;

        }


        .hamburger-button:active {

            transform:
                scale(.96);

        }


        .hamburger-lines {

            width:
                20px;

            display:
                flex;

            flex-direction:
                column;

            gap:
                4px;

        }


        .hamburger-lines span {

            display:
                block;

            width:
                20px;

            height:
                2px;

            background:
                #475569;

            border-radius:
                10px;

        }


        .hamburger-button:hover .hamburger-lines span {

            background:
                #4d9900;

        }


        /* =====================================================
           HEADER BRAND
        ====================================================== */

        .brand {

            display:
                flex;

            align-items:
                center;

            gap:
                10px;

            color:
                var(--text);

            min-width:
                0;

        }


        .brand-logo {

            width:
                42px;

            height:
                42px;

            flex:
                0 0 42px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                13px;

            background:
                var(--primary);

            color:
                #ffffff;

            font-size:
                22px;

            box-shadow:
                0 5px 14px rgba(121,
                    210,
                    10,
                    .22);

        }


        .brand-text {

            min-width:
                0;

            display:
                flex;

            flex-direction:
                column;

        }


        .brand-text strong {

            color:
                #172033;

            font-size:
                18px;

            line-height:
                1.05;

            font-weight:
                900;

        }


        .brand-text span {

            margin-top:
                4px;

            color:
                #718096;

            font-size:
                10px;

            line-height:
                1.3;

        }


        /* =====================================================
           USER AREA
        ====================================================== */

        .user-area {

            margin-left:
                auto;

            display:
                flex;

            align-items:
                center;

            gap:
                10px;

        }


        .notification-button {

            width:
                42px;

            height:
                42px;

            border:
                0;

            border-radius:
                50%;

            background:
                #f1f5f9;

            color:
                #64748b;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            font-size:
                18px;

        }


        .avatar {

            width:
                42px;

            height:
                42px;

            border-radius:
                50%;

            background:
                #eef5e6;

            color:
                #456b15;

            border:
                1px solid #d9ebc1;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            font-weight:
                800;

            font-size:
                13px;

        }


        .user-info {

            display:
                flex;

            flex-direction:
                column;

            gap:
                2px;

        }


        .user-info strong {

            font-size:
                13px;

            color:
                #172033;

        }


        .user-info span {

            font-size:
                10px;

            color:
                #7b8798;

        }


        /* =====================================================
           MAIN CONTENT
        ====================================================== */

        .main-content {

            width:
                100%;

        }


        .page-container {

            width:
                min(1480px,
                    calc(100% - 48px));

            margin:
                0 auto;

            padding:
                38px 0 60px;

        }


        /* =====================================================
           PAGE HEADING
        ====================================================== */

        .page-heading {

            margin-bottom:
                24px;

        }


        .eyebrow {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                7px;

            padding:
                7px 12px;

            border-radius:
                999px;

            background:
                var(--primary-soft);

            color:
                var(--primary-dark);

            font-size:
                11px;

            font-weight:
                800;

        }


        .page-heading h1 {

            margin:
                13px 0 7px;

            color:
                #172033;

            font-size:
                clamp(30px,
                    4vw,
                    46px);

            line-height:
                1.05;

            font-weight:
                900;

            letter-spacing:
                -.9px;

        }


        .page-heading h1 span {

            color:
                #62b800;

        }


        .page-heading p {

            max-width:
                760px;

            margin:
                0;

            color:
                var(--text-secondary);

            font-size:
                14px;

            line-height:
                1.65;

        }


        /* =====================================================
           LOCATION STATUS
        ====================================================== */

        .location-status {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                18px;

            margin-bottom:
                20px;

            padding:
                14px 17px;

            background:
                #ffffff;

            border:
                1px solid var(--border);

            border-radius:
                16px;

            box-shadow:
                var(--shadow-sm);

        }


        .location-status-left {

            display:
                flex;

            align-items:
                center;

            gap:
                9px;

            color:
                #53667f;

            font-size:
                12px;

            font-weight:
                600;

        }


        .location-status-dot {

            width:
                9px;

            height:
                9px;

            border-radius:
                50%;

            background:
                #cbd5e1;

        }


        .location-status-dot.active {

            background:
                #16a34a;

            box-shadow:
                0 0 0 4px rgba(22,
                    163,
                    74,
                    .1);

        }


        .location-status-dot.error {

            background:
                #ef4444;

        }


        .nearest-info {

            color:
                #667085;

            font-size:
                12px;

            text-align:
                right;

        }


        .nearest-info strong {

            color:
                #172033;

        }


        /* =====================================================
           STATISTICS
        ====================================================== */

        .stats-grid {

            display:
                grid;

            grid-template-columns:
                repeat(3,
                    minmax(0,
                        1fr));

            gap:
                16px;

            margin-bottom:
                20px;

        }


        .stat-card {

            padding:
                19px 20px;

            background:
                #ffffff;

            border:
                1px solid var(--border);

            border-radius:
                18px;

            box-shadow:
                var(--shadow-sm);

        }


        .stat-label {

            color:
                #7b8798;

            font-size:
                11px;

            font-weight:
                700;

        }


        .stat-value {

            margin-top:
                7px;

            color:
                #172033;

            font-size:
                30px;

            line-height:
                1;

            font-weight:
                900;

        }


        .stat-value.green {

            color:
                #16a34a;

        }


        .stat-value.red {

            color:
                #ef4444;

        }


        /* =====================================================
           FILTER
        ====================================================== */

        .filter-card {

            padding:
                18px;

            margin-bottom:
                20px;

            background:
                #ffffff;

            border:
                1px solid var(--border);

            border-radius:
                18px;

            box-shadow:
                var(--shadow-sm);

        }


        .filter-grid {

            display:
                grid;

            grid-template-columns:
                minmax(0,
                    1fr) 310px auto;

            gap:
                14px;

            align-items:
                end;

        }


        .field {

            min-width:
                0;

        }


        .field label {

            display:
                block;

            margin:
                0 0 7px 2px;

            color:
                #526177;

            font-size:
                11px;

            font-weight:
                800;

        }


        .input,
        .select {

            width:
                100%;

            height:
                46px;

            padding:
                0 13px;

            border:
                1px solid #dce3ea;

            border-radius:
                12px;

            background:
                #ffffff;

            color:
                #172033;

            outline:
                none;

            font-size:
                12px;

            transition:
                border-color .18s ease,
                box-shadow .18s ease;

        }


        .input:focus,
        .select:focus {

            border-color:
                #9bdc42;

            box-shadow:
                0 0 0 3px rgba(121,
                    210,
                    10,
                    .1);

        }


        .reset-button {

            height:
                46px;

            padding:
                0 17px;

            border:
                1px solid #dce3ea;

            border-radius:
                12px;

            background:
                #ffffff;

            color:
                #53667f;

            font-size:
                12px;

            font-weight:
                800;

        }


        .reset-button:hover {

            border-color:
                #b7d982;

            background:
                #f7fceF;

            color:
                #4d9900;

        }


        /* =====================================================
           MAP
        ====================================================== */

        .map-card {

            position:
                relative;

            height:
                560px;

            overflow:
                hidden;

            border:
                1px solid var(--border);

            border-radius:
                22px;

            background:
                #edf2f1;

            box-shadow:
                var(--shadow-md);

        }


        #bankSampahMap {

            width:
                100%;

            height:
                100%;

            min-height:
                560px;

        }


        .map-loading {

            position:
                absolute;

            inset:
                0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                #edf2f1;

            color:
                #718096;

            font-size:
                13px;

            z-index:
                500;

            pointer-events:
                none;

            transition:
                opacity .2s ease;

        }


        .map-loading.hidden {

            opacity:
                0;

            visibility:
                hidden;

        }


        .map-overlay {

            position:
                absolute;

            top:
                16px;

            right:
                16px;

            z-index:
                1000;

            pointer-events:
                none;

        }


        .map-location-button {

            min-height:
                44px;

            padding:
                0 16px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                8px;

            border:
                0;

            border-radius:
                13px;

            background:
                rgba(255,
                    255,
                    255,
                    .96);

            color:
                #344054;

            box-shadow:
                0 8px 22px rgba(15,
                    23,
                    42,
                    .14);

            font-size:
                12px;

            font-weight:
                800;

            pointer-events:
                auto;

            backdrop-filter:
                blur(7px);

            -webkit-backdrop-filter:
                blur(7px);

        }


        .map-location-button:hover {

            background:
                #f5fce8;

            color:
                #4d9900;

        }


        .location-button-icon {

            width:
                24px;

            height:
                24px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                8px;

            background:
                #effbdc;

            font-size:
                13px;

        }


        /* =====================================================
           RECYCLE MARKER
        ====================================================== */

        .recycle-marker-wrapper {

            background:
                transparent !important;

            border:
                0 !important;

        }


        .recycle-marker {

            position:
                relative;

            width:
                46px;

            height:
                54px;

            display:
                flex;

            align-items:
                flex-start;

            justify-content:
                center;

            filter:
                drop-shadow(0 4px 6px rgba(15,
                        23,
                        42,
                        .22));

        }


        .recycle-marker-icon {

            width:
                40px;

            height:
                40px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border:
                3px solid #ffffff;

            border-radius:
                50%;

            background:
                var(--marker-color);

            color:
                #ffffff;

            font-size:
                22px;

            line-height:
                1;

            font-weight:
                900;

            box-shadow:
                0 3px 8px rgba(15,
                    23,
                    42,
                    .18);

        }


        .recycle-marker-tail {

            position:
                absolute;

            left:
                18px;

            bottom:
                4px;

            width:
                10px;

            height:
                10px;

            background:
                var(--marker-color);

            transform:
                rotate(45deg);

            border-right:
                2px solid #ffffff;

            border-bottom:
                2px solid #ffffff;

        }


        /* =====================================================
           USER LOCATION
           
           TETAP TITIK BIRU.
        ====================================================== */

        .user-location-marker {

            width:
                18px;

            height:
                18px;

            border:
                3px solid #ffffff;

            border-radius:
                50%;

            background:
                #2563eb;

            box-shadow:
                0 0 0 5px rgba(37,
                    99,
                    235,
                    .18),
                0 3px 10px rgba(37,
                    99,
                    235,
                    .35);

        }


        /* =====================================================
           LEAFLET POPUP
        ====================================================== */

        .leaflet-popup-content-wrapper {

            border-radius:
                15px;

            box-shadow:
                0 10px 30px rgba(15,
                    23,
                    42,
                    .16);

        }


        .leaflet-popup-content {

            margin:
                14px;

            min-width:
                220px;

        }


        .popup-title {

            margin-bottom:
                6px;

            color:
                #172033;

            font-size:
                15px;

            line-height:
                1.25;

            font-weight:
                900;

        }


        .popup-address {

            margin-bottom:
                8px;

            color:
                #667085;

            font-size:
                11px;

            line-height:
                1.5;

        }


        .popup-status {

            display:
                inline-flex;

            padding:
                5px 9px;

            margin-bottom:
                9px;

            border-radius:
                999px;

            font-size:
                10px;

            font-weight:
                800;

        }


        .status-open {

            background:
                #dcfce7;

            color:
                #166534;

        }


        .status-closed {

            background:
                #fee2e2;

            color:
                #991b1b;

        }


        .status-unknown {

            background:
                #fef9c3;

            color:
                #854d0e;

        }


        .popup-info {

            margin:
                5px 0;

            color:
                #667085;

            font-size:
                11px;

            line-height:
                1.45;

        }


        .popup-info strong {

            color:
                #344054;

        }


        .popup-buttons {

            display:
                flex;

            gap:
                7px;

            margin-top:
                12px;

        }


        .popup-button {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            min-height:
                34px;

            padding:
                0 9px;

            border-radius:
                9px;

            font-size:
                10px;

            font-weight:
                800;

        }


        .google-button {

            background:
                #eef2ff;

            color:
                #334155;

        }


        .whatsapp-button {

            background:
                #dcfce7;

            color:
                #166534;

        }


        /* =====================================================
           BANK LIST
        ====================================================== */

        .section-heading {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                15px;

            margin:
                27px 0 14px;

        }


        .section-heading h2 {

            margin:
                0;

            color:
                #172033;

            font-size:
                20px;

            line-height:
                1.2;

            font-weight:
                900;

        }


        .result-count {

            color:
                #7b8798;

            font-size:
                11px;

            font-weight:
                700;

        }


        .loading-state {

            min-height:
                90px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                10px;

            color:
                #7b8798;

            font-size:
                12px;

        }


        .spinner {

            width:
                20px;

            height:
                20px;

            border:
                2px solid #dfe7d7;

            border-top-color:
                #79d20a;

            border-radius:
                50%;

            animation:
                spin .7s linear infinite;

        }


        @keyframes spin {

            to {

                transform:
                    rotate(360deg);

            }

        }


        .bank-grid {

            display:
                grid;

            grid-template-columns:
                repeat(3,
                    minmax(0,
                        1fr));

            gap:
                17px;

        }


        .bank-card {

            padding:
                18px;

            background:
                #ffffff;

            border:
                1px solid var(--border);

            border-radius:
                18px;

            box-shadow:
                var(--shadow-sm);

            cursor:
                pointer;

            transition:
                transform .18s ease,
                border-color .18s ease,
                box-shadow .18s ease;

        }


        .bank-card:hover {

            transform:
                translateY(-2px);

            border-color:
                #b9dc82;

            box-shadow:
                0 10px 25px rgba(15,
                    23,
                    42,
                    .08);

        }


        .bank-card.nearest {

            border-color:
                #79d20a;

            box-shadow:
                0 0 0 2px rgba(121,
                    210,
                    10,
                    .08);

        }


        .bank-card-title {

            display:
                flex;

            align-items:
                flex-start;

            justify-content:
                space-between;

            gap:
                12px;

        }


        .bank-card-name {

            margin:
                0;

            color:
                #172033;

            font-size:
                15px;

            line-height:
                1.35;

            font-weight:
                900;

        }


        .status-badge {

            flex:
                0 0 auto;

            display:
                inline-flex;

            padding:
                5px 9px;

            border-radius:
                999px;

            font-size:
                10px;

            line-height:
                1;

            font-weight:
                800;

        }


        .bank-card-address {

            margin-top:
                9px;

            color:
                #7b8798;

            font-size:
                11px;

            line-height:
                1.55;

        }


        .bank-card-meta {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                10px;

            margin-top:
                13px;

        }


        .bank-card-type {

            color:
                #667085;

            font-size:
                10px;

            font-weight:
                700;

        }


        .bank-card-distance {

            color:
                #4d9900;

            font-size:
                10px;

            font-weight:
                800;

        }


        .bank-card-divider {

            height:
                1px;

            margin:
                14px 0;

            background:
                #eef1f4;

        }


        .bank-hours-title {

            margin-bottom:
                7px;

            color:
                #526177;

            font-size:
                10px;

            font-weight:
                800;

        }


        .bank-hours {

            display:
                flex;

            flex-direction:
                column;

            gap:
                3px;

            height:
                auto;

            max-height:
                none;

            overflow:
                visible;

        }


        .bank-hour-row {

            display:
                flex;

            justify-content:
                space-between;

            gap:
                10px;

            color:
                #7b8798;

            font-size:
                9px;

        }


        .bank-hour-row strong {

            color:
                #526177;

            font-weight:
                800;

        }


        .bank-card-actions {

            display:
                grid;

            grid-template-columns:
                1fr 1fr;

            gap:
                7px;

            margin-top:
                14px;

        }


        .card-action {

            min-height:
                36px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                9px;

            font-size:
                10px;

            font-weight:
                800;

        }


        .card-google {

            background:
                #eef2ff;

            color:
                #334155;

        }


        .card-whatsapp {

            background:
                #dcfce7;

            color:
                #166534;

        }


        .empty-state {

            display:
                none;

            padding:
                45px 20px;

            text-align:
                center;

            color:
                #94a3b8;

        }


        .empty-icon {

            font-size:
                28px;

            margin-bottom:
                8px;

        }


        .empty-state h3 {

            margin:
                0 0 5px;

            color:
                #475569;

            font-size:
                15px;

        }


        .empty-state p {

            margin:
                0;

            font-size:
                12px;

        }


        /* =====================================================
           LOCATION MODAL
           
           FIXED.
           TIDAK MELAKUKAN SCROLL KE MAP.
        ====================================================== */

        .location-modal {

            position:
                fixed;

            inset:
                0;

            z-index:
                10000;

            display:
                flex;

            align-items:
                flex-start;

            justify-content:
                center;

            padding:
                78px 20px 20px;

            background:
                rgba(15,
                    23,
                    42,
                    .43);

            backdrop-filter:
                blur(5px);

            -webkit-backdrop-filter:
                blur(5px);

            opacity:
                0;

            visibility:
                hidden;

            pointer-events:
                none;

            transition:
                opacity .2s ease,
                visibility .2s ease;

        }


        .location-modal.show {

            opacity:
                1;

            visibility:
                visible;

            pointer-events:
                auto;

        }


        .location-modal-card {

            width:
                min(100%,
                    520px);

            padding:
                27px;

            background:
                #ffffff;

            border-radius:
                22px;

            box-shadow:
                0 25px 70px rgba(15,
                    23,
                    42,
                    .2);

        }


        .location-modal-icon {

            width:
                46px;

            height:
                46px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                14px;

            background:
                #effbdc;

            margin-bottom:
                13px;

        }


        .location-modal-card h3 {

            margin:
                0;

            color:
                #172033;

            font-size:
                20px;

            font-weight:
                900;

        }


        .location-modal-card p {

            margin:
                10px 0 15px;

            color:
                #718096;

            font-size:
                12px;

            line-height:
                1.7;

        }


        .location-permission-info {

            padding:
                12px 13px;

            border-radius:
                12px;

            background:
                #f8fafc;

            color:
                #718096;

            font-size:
                11px;

            line-height:
                1.55;

        }


        .location-permission-actions {

            display:
                grid;

            grid-template-columns:
                1fr 1fr;

            gap:
                9px;

            margin-top:
                16px;

        }


        .location-permission-btn {

            min-height:
                46px;

            border:
                0;

            border-radius:
                12px;

            font-size:
                12px;

            font-weight:
                800;

        }


        .location-permission-btn.allow {

            background:
                #16a34a;

            color:
                #ffffff;

        }


        .location-permission-btn.allow:hover {

            background:
                #15803d;

        }


        .location-permission-btn.later {

            background:
                #f1f5f9;

            color:
                #64748b;

        }


        .location-permission-btn.later:hover {

            background:
                #e2e8f0;

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media(max-width:1200px) {

            .bank-grid {

                grid-template-columns:
                    repeat(2,
                        minmax(0,
                            1fr));

            }

        }


        @media(max-width:900px) {

            .header-inner {

                width:
                    min(calc(100% - 28px),
                        1480px);

            }


            .page-container {

                width:
                    min(calc(100% - 28px),
                        1480px);

            }


            .stats-grid {

                grid-template-columns:
                    1fr;

            }


            .filter-grid {

                grid-template-columns:
                    1fr;

            }


            .map-card {

                height:
                    460px;

            }


            #bankSampahMap {

                min-height:
                    460px;

            }


            .bank-grid {

                grid-template-columns:
                    1fr;

            }


            .brand-text span {

                display:
                    none;

            }


            .user-info {

                display:
                    none;

            }

        }


        @media(max-width:600px) {

            .top-header {

                height:
                    68px;

            }


            .header-inner {

                width:
                    calc(100% - 24px);

            }


            .hamburger-button {

                width:
                    42px;

                height:
                    42px;

                flex-basis:
                    42px;

            }


            .brand-logo {

                width:
                    38px;

                height:
                    38px;

                flex-basis:
                    38px;

                font-size:
                    19px;

            }


            .brand-text strong {

                font-size:
                    16px;

            }


            .page-container {

                padding:
                    25px 0 45px;

            }


            .location-status {

                align-items:
                    flex-start;

                flex-direction:
                    column;

            }


            .nearest-info {

                text-align:
                    left;

            }


            .map-card {

                height:
                    400px;

                border-radius:
                    18px;

            }


            #bankSampahMap {

                min-height:
                    400px;

            }


            .map-location-button {

                top:
                    12px;

                right:
                    12px;

                min-height:
                    42px;

                padding:
                    0 12px;

            }


            .location-modal {

                padding:
                    70px 14px 14px;

            }


            .location-modal-card {

                padding:
                    21px;

                border-radius:
                    20px;

            }


            .location-permission-actions {

                grid-template-columns:
                    1fr;

            }

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

    TIDAK ADA BUTTON X.
    SIDEBAR DIBUKA/TUTUP MELALUI HAMBURGER.
    ========================================================= --}}

    <div id="sidebar" class="sidebar" role="dialog" aria-label="Sidebar navigasi" aria-hidden="true">

        <aside
            class="w-full max-w-xs lg:w-72 lg:flex-none
                   bg-white/90
                   border border-slate-200/80
                   rounded-[32px]
                   min-h-screen
                   lg:sticky top-5
                   shadow-[0_26px_60px_rgba(15,23,42,0.06)]
                   backdrop-blur-xl
                   overflow-hidden"
        >

            <!-- ========================================================= -->
            <!-- SIDEBAR HEADER -->
            <!-- ========================================================= -->

            <div class="h-28 border-b border-slate-200/80 px-5 flex items-center">

                <div class="flex items-center gap-3 w-full">

                    <!-- LOGO -->
                    <div class="w-16 h-16 flex items-center justify-center shrink-0">

                        <img
                            src="{{ asset('images/karsa-nirmala-logo.png') }}"
                            alt="Karsa Nirmala logo"
                            class="w-16 h-16 object-contain scale-[1.8] drop-shadow-sm"
                        >

                    </div>


                    <!-- BRAND -->
                    <div class="min-w-0 flex-1">

                        <h2
                            class="font-black
                                   text-[1.45rem]
                                   leading-none
                                   tracking-tight
                                   text-slate-900
                                   whitespace-nowrap"
                        >
                            Karsa Nirmala
                        </h2>

                        <p
                            class="mt-1
                                   text-[0.65rem]
                                   text-slate-500
                                   leading-snug
                                   font-medium"
                        >
                            Sistem Cerdas Pengelolaan Sampah | Ekonomi Sirkular
                        </p>

                    </div>

                </div>

            </div>


            <!-- ========================================================= -->
            <!-- SIDEBAR CONTENT -->
            <!-- ========================================================= -->

            @php
                $isDashboard = request()->routeIs('dashboard');
                $isScanner = request()->routeIs(['scanner', 'scanner.history']);
                $isBankSampah = request()->routeIs('bank-sampah');
                $isMarketplace = request()->routeIs('marketplace');
                $isMarketplaceCatalog = request()->routeIs('admin.bank-sampah.catalog.*');
                $isBankSampahAdmin = auth()->user()?->role === 'admin_bank_sampah';
            @endphp

            <div class="p-4 sidebar-scroll overflow-y-auto min-h-[calc(100vh-7rem)]">

                <!-- MAIN MENU -->
                <p class="text-xs uppercase font-bold text-slate-400 px-3 mb-3">
                    Main Menu
                </p>


                <nav class="space-y-2">
                    @if ($isBankSampahAdmin)
                        <a href="{{ route('admin.bank-sampah.dashboard') }}"
                            class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-3 text-slate-700 transition-colors duration-200 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-600 shadow-sm">⚙</span>
                            <span class="font-semibold">Kelola Bank Sampah</span>
                        </a>
                        <a href="{{ route('admin.bank-sampah.catalog.index') }}"
                            class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-3 text-slate-700 transition-colors duration-200 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-600 shadow-sm">🛒</span>
                            <span class="font-semibold">Kelola Marketplace</span>
                        </a>
                        <a href="{{ route('chatbot') }}"
                            class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-3 text-slate-700 transition-colors duration-200 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-600 shadow-sm">💬</span>
                            <span class="font-semibold">AI Chatbot</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-3 rounded-2xl border border-slate-200 bg-white p-3 text-left text-slate-700 transition-colors duration-200 hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-red-500 shadow-sm">↪</span>
                                <span class="font-semibold">Logout</span>
                            </button>
                        </form>
                    @endif

                    @unless ($isBankSampahAdmin)
                    <!-- ================================================= -->
                    <!-- DASHBOARD -->
                    <!-- ================================================= -->

                    @if (!$isBankSampahAdmin)
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 p-3 rounded-2xl
                               {{ $isDashboard ? 'bg-lime-50 text-lime-700 border border-lime-200 shadow-sm' : 'hover:bg-slate-50 hover:text-lime-700' }}
                               transition-colors duration-200"
                    >

                        <span
                            class="w-10 h-10 rounded-2xl
                                   bg-white
                                   flex items-center justify-center
                                   text-lime-600
                                   shadow-sm
                                   shrink-0"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M3 9.5L12 3l9 6.5v11a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V15H10v6.5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-11z" />

                            </svg>

                        </span>

                        <span class="font-semibold">
                            Dashboard
                        </span>

                    </a>
                    @endif


                    <!-- ================================================= -->
                    <!-- AI SCANNER -->
                    <!-- ================================================= -->

                    <a
                        href="{{ route('scanner') }}"
                        class="flex items-center gap-3 p-3 rounded-2xl
                               {{ $isScanner ? 'bg-lime-50 text-lime-700 border border-lime-200 shadow-sm' : 'hover:bg-slate-50 hover:text-lime-700' }}
                               transition-colors duration-200"
                    >

                        <span
                            class="w-10 h-10 rounded-2xl
                                   bg-slate-100
                                   flex items-center justify-center
                                   text-slate-600
                                   shrink-0"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <rect
                                    x="3"
                                    y="7"
                                    width="18"
                                    height="13"
                                    rx="2"
                                    ry="2"
                                />

                                <path
                                    d="M16 3H8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"
                                />

                                <path d="M12 11v6" />

                            </svg>

                        </span>

                        <span class="font-semibold">
                            AI Scanner
                        </span>

                    </a>


                    <!-- ================================================= -->
                    <!-- HISTORY -->
                    <!-- ================================================= -->

                    <a
                        href="{{ route('scanner.history') }}"
                        class="flex items-center gap-3 p-3 rounded-2xl
                               hover:bg-lime-50
                               hover:text-lime-600
                               transition-colors duration-200"
                    >

                        <span
                            class="w-10 h-10 rounded-2xl
                                   bg-slate-100
                                   flex items-center justify-center
                                   text-slate-600
                                   shrink-0"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M4 19h16" />
                                <path d="M4 12h16" />
                                <path d="M4 5h16" />

                            </svg>

                        </span>

                        <span class="font-semibold">
                            History Scan
                        </span>

                    </a>

                    @endunless

                    @if (!$isBankSampahAdmin)
                    <!-- ================================================= -->
                    <!-- GIS -->
                    <!-- ================================================= -->

                    <a
                        href="{{ route('bank-sampah') }}"
                        class="flex items-center gap-3 p-3 rounded-2xl
                               {{ $isBankSampah ? 'bg-lime-50 text-lime-700 border border-lime-200 shadow-sm' : 'hover:bg-lime-50 hover:text-lime-600' }}
                               transition-colors duration-200"
                    >

                        <span
                            class="w-10 h-10 rounded-2xl
                                   bg-slate-100
                                   flex items-center justify-center
                                   text-slate-600
                                   shrink-0"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path d="M3 6l4-1 5 2 5-2 4 1v12l-4 1-5-2-5 2-4-1V6z" />
                                <path d="M8 5v12" />
                                <path d="M13 7v10" />
                                <circle cx="12" cy="12" r="1.5" fill="currentColor" />

                            </svg>

                        </span>

                        <span class="font-semibold">
                            GIS
                        </span>

                    </a>

                    <!-- ================================================= -->
                    <!-- MARKETPLACE -->
                    <!-- ================================================= -->

                    <a
                        href="{{ route('marketplace') }}"
                        class="flex items-center gap-3 p-3 rounded-2xl
                               {{ $isMarketplace ? 'bg-lime-50 text-lime-700 border border-lime-200 shadow-sm' : 'hover:bg-lime-50 hover:text-lime-600' }}
                               transition-colors duration-200"
                    >

                        <span
                            class="w-10 h-10 rounded-2xl
                                   bg-slate-100
                                   flex items-center justify-center
                                   text-slate-600
                                   shrink-0"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>

                            </svg>

                        </span>

                        <span class="font-semibold">
                            Marketplace
                        </span>

                    </a>
                    @endif

                    <!-- ================================================= -->
                    <!-- AI CHATBOT -->
                    <!-- ================================================= -->

                    <a
                        href="{{ route('chatbot') }}"
                        class="flex items-center gap-3 p-3 rounded-2xl
                               hover:bg-lime-50
                               hover:text-lime-600
                               transition-colors duration-200"
                    >

                        <span
                            class="w-10 h-10 rounded-2xl
                                   bg-slate-100
                                   flex items-center justify-center
                                   text-slate-600
                                   shrink-0"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path
                                    d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"
                                />

                            </svg>

                        </span>

                        <span class="font-semibold">
                            AI Chatbot
                        </span>

                    </a>

                    @unless ($isBankSampahAdmin)
                    <!-- ================================================= -->
                    <!-- PROFILE -->
                    <!-- ================================================= -->

                    <a
                        href="{{ route('profile') }}"
                        class="flex items-center gap-3 p-3 rounded-2xl
                               hover:bg-lime-50
                               hover:text-lime-600
                               transition-colors duration-200"
                    >

                        <span
                            class="w-10 h-10 rounded-2xl
                                   bg-slate-100
                                   flex items-center justify-center
                                   text-slate-600
                                   shrink-0"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >

                                <path
                                    d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                                />

                                <circle
                                    cx="12"
                                    cy="7"
                                    r="4"
                                />

                            </svg>

                        </span>

                        <span class="font-semibold">
                            Profile
                        </span>

                    </a>


                    <!-- ================================================= -->
                    <!-- LOGOUT -->
                    <!-- ================================================= -->

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="w-full text-left
                                   flex items-center gap-3 p-3 rounded-2xl
                                   text-red-500
                                   hover:bg-red-50
                                   transition-colors duration-200"
                        >

                            <span
                                class="w-10 h-10 rounded-2xl
                                       bg-slate-100
                                       flex items-center justify-center
                                       text-red-500
                                       shrink-0"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >

                                    <path
                                        d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"
                                    />

                                    <polyline points="16 17 21 12 16 7" />

                                    <line
                                        x1="21"
                                        y1="12"
                                        x2="9"
                                        y2="12"
                                    />

                                </svg>

                            </span>

                            <span class="font-semibold">
                                Logout
                            </span>

                        </button>

                    </form>
                    @endunless

                </nav>

            </div>

        </aside>

    </div>


    {{-- =========================================================
    TOP HEADER
    ========================================================= --}}

    <header class="top-header">

        <div class="header-inner">


            {{-- =================================================
            HAMBURGER

            TIDAK BERUBAH MENJADI X.
            ================================================== --}}

            <button type="button" id="sidebarToggle" class="hamburger-button" aria-label="Buka menu"
                aria-expanded="false" aria-controls="sidebar">

                <span class="hamburger-lines">

                    <span></span>
                    <span></span>
                    <span></span>

                </span>

            </button>


            {{-- =================================================
            BRAND HEADER
            ================================================== --}}

            <a href="{{ route('dashboard') }}" class="brand">

                <div class="brand-logo">
                    ♻
                </div>

                <div class="brand-text">

                    <strong>
                        Karsa Nirmala
                    </strong>

                    <span>
                        Sistem Cerdas Pengelolaan Sampah | Ekonomi Sirkular
                    </span>

                </div>

            </a>


            {{-- =================================================
            USER AREA
            ================================================== --}}

            <div class="user-area">

                <button type="button" class="notification-button" aria-label="Notifikasi">
                    ♧
                </button>

                <div class="avatar">
                    RA
                </div>

                <div class="user-info">

                    <strong>
                        {{ auth()->user()->name ?? 'ramadani' }}
                    </strong>

                    <span>
                        Member
                    </span>

                </div>

            </div>

        </div>

    </header>


    {{-- =========================================================
    MAIN CONTENT
    ========================================================= --}}

    <div class="main-content">

        <main class="page-container">


            {{-- =====================================================
            PAGE HEADING
            ====================================================== --}}

            <section class="page-heading">

                <div class="eyebrow">
                    ♻️
                    Smart Waste Network
                </div>


                <h1>
                    Bank
                    <span>
                        Sampah
                    </span>
                </h1>


                <p>
                    Temukan bank sampah di sekitar Surabaya berdasarkan
                    lokasi, status operasional, jenis sampah, dan informasi
                    layanan.
                </p>

            </section>


            {{-- =====================================================
            LOCATION STATUS
            ====================================================== --}}

            <div class="location-status">

                <div class="location-status-left">

                    <span id="locationStatusDot" class="location-status-dot"></span>

                    <span id="locationStatus">
                        Menunggu izin lokasi...
                    </span>

                </div>


                <div id="nearestInfo" class="nearest-info">

                    Bank sampah terdekat:
                    <strong>
                        Belum tersedia
                    </strong>

                </div>

            </div>


            {{-- =====================================================
            STATISTICS
            ====================================================== --}}

            <section class="stats-grid">


                <div class="stat-card">

                    <div class="stat-label">
                        Total Bank Sampah
                    </div>

                    <div id="totalBank" class="stat-value">
                        0
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-label">
                        Sedang Buka
                    </div>

                    <div id="openBank" class="stat-value green">
                        0
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-label">
                        Tutup / Tidak Diketahui
                    </div>

                    <div id="closedBank" class="stat-value red">
                        0
                    </div>

                </div>


            </section>


            {{-- =====================================================
            FILTER
            ====================================================== --}}

            <section class="filter-card">

                <div class="filter-grid">


                    <div class="field">

                        <label for="bankSearch">
                            Cari Bank Sampah
                        </label>

                        <input type="text" id="bankSearch" class="input" placeholder="Cari nama atau alamat...">

                    </div>


                    <div class="field">

                        <label for="bankStatusFilter">
                            Status
                        </label>

                        <select id="bankStatusFilter" class="select">

                            <option value="all">
                                Semua Status
                            </option>

                            <option value="open">
                                Buka
                            </option>

                            <option value="closed">
                                Tutup
                            </option>

                            <option value="unknown">
                                Tidak Diketahui
                            </option>

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

                    <button type="button" id="myLocationButton" class="map-location-button">

                        <span class="location-button-icon">
                            📍
                        </span>

                        <span>
                            Lokasi Saya
                        </span>

                    </button>

                </div>

            </section>


            {{-- =====================================================
            BANK LIST HEADER
            ====================================================== --}}

            <div class="section-heading">

                <div>

                    <h2>
                        Daftar Bank Sampah
                    </h2>

                </div>


                <span id="resultCount" class="result-count">
                    Memuat data...
                </span>

            </div>


            {{-- =====================================================
            LOADING
            ====================================================== --}}

            <div id="loadingState" class="loading-state">

                <div class="spinner"></div>

                Memuat data bank sampah...

            </div>


            {{-- =====================================================
            BANK GRID
            ====================================================== --}}

            <div id="bankGrid" class="bank-grid"></div>


            {{-- =====================================================
            EMPTY
            ====================================================== --}}

            <div id="emptyState" class="empty-state">

                <div class="empty-icon">
                    🔎
                </div>


                <h3>
                    Bank sampah tidak ditemukan
                </h3>


                <p>
                    Coba gunakan kata kunci atau filter lainnya.
                </p>

            </div>


        </main>

    </div>


    {{-- =========================================================
    LOCATION PERMISSION PROMPT

    TETAP ADA.
    FIXED DI ATAS VIEWPORT.
    ========================================================= --}}

    <div id="locationModal" class="location-modal" role="dialog" aria-modal="true" aria-hidden="true"
        aria-labelledby="locationModalTitle">

        <div class="location-modal-card">

            <div class="location-modal-icon">
                📍
            </div>


            <h3 id="locationModalTitle">
                Location Permission Prompt
            </h3>


            <p>
                Izinkan Karsa Nirmala mengakses lokasi Anda untuk
                menampilkan posisi Anda pada peta dan menemukan bank
                sampah terdekat secara realtime.
            </p>


            <div class="location-permission-info">

                🔒 Lokasi digunakan hanya untuk fitur peta,
                perhitungan jarak, dan pencarian bank sampah
                terdekat.

            </div>


            <div class="location-permission-actions">

                <button type="button" id="allowLocationButton" class="location-permission-btn allow">
                    📍 Izinkan Lokasi
                </button>


                <button type="button" id="laterLocationButton" class="location-permission-btn later">
                    Nanti
                </button>

            </div>

        </div>

    </div>


    {{-- =========================================================
    LEAFLET JS
    ========================================================= --}}

    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>


    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                'use strict';


                /* =====================================================
                   CONFIG
                ====================================================== */

                const API_URL =
                    '/api/bank-sampah';


                const DEFAULT_CENTER = [
                    -7.2575,
                    112.7521
                ];


                const DEFAULT_ZOOM =
                    12;


                const GEO_OPTIONS = {

                    enableHighAccuracy:
                        true,

                    maximumAge:
                        5000,

                    timeout:
                        20000

                };


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

                let locationRequestInProgress = false;


                const bankMarkers =
                    new Map();


                /* =====================================================
                   DOM
                ====================================================== */

                const $ =
                    id => document.getElementById(id);


                const sidebar =
                    $('sidebar');

                const sidebarOverlay =
                    $('sidebarOverlay');

                const sidebarToggle =
                    $('sidebarToggle');


                const locationModal =
                    $('locationModal');

                const allowLocationButton =
                    $('allowLocationButton');

                const laterLocationButton =
                    $('laterLocationButton');


                const bankSearch =
                    $('bankSearch');

                const bankStatusFilter =
                    $('bankStatusFilter');

                const resetFilter =
                    $('resetFilter');


                const bankGrid =
                    $('bankGrid');

                const emptyState =
                    $('emptyState');

                const loadingState =
                    $('loadingState');

                const resultCount =
                    $('resultCount');


                const totalBank =
                    $('totalBank');

                const openBank =
                    $('openBank');

                const closedBank =
                    $('closedBank');


                const locationStatusDot =
                    $('locationStatusDot');

                const locationStatus =
                    $('locationStatus');

                const nearestInfo =
                    $('nearestInfo');


                const mapLoading =
                    $('mapLoading');

                const myLocationButton =
                    $('myLocationButton');

                const mapSection =
                    $('mapSection');


                /* =====================================================
                   SIDEBAR
                   
                   HANYA HAMBURGER.
                   TIDAK ADA SIDEBAR CLOSE BUTTON.
                ====================================================== */

                function openSidebar() {

                    sidebar.classList.add(
                        'open'
                    );

                    sidebarOverlay.classList.add(
                        'open'
                    );

                    sidebar.setAttribute(
                        'aria-hidden',
                        'false'
                    );

                    sidebarToggle.setAttribute(
                        'aria-expanded',
                        'true'
                    );

                }


                function closeSidebar() {

                    sidebar.classList.remove(
                        'open'
                    );

                    sidebarOverlay.classList.remove(
                        'open'
                    );

                    sidebar.setAttribute(
                        'aria-hidden',
                        'true'
                    );

                    sidebarToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                }


                function toggleSidebar() {

                    if (
                        sidebar.classList.contains(
                            'open'
                        )
                    ) {

                        closeSidebar();

                    } else {

                        openSidebar();

                    }

                }


                sidebarToggle.addEventListener(
                    'click',
                    toggleSidebar
                );


                sidebarOverlay.addEventListener(
                    'click',
                    closeSidebar
                );


                /*
                 * Jika user memilih menu,
                 * sidebar otomatis ditutup.
                 */

                sidebar
                    .querySelectorAll(
                        'a'
                    )
                    .forEach(
                        function (link) {

                            link.addEventListener(
                                'click',
                                function () {

                                    closeSidebar();

                                }
                            );

                        }
                    );


                /*
                 * Tidak ada tombol X.
                 *
                 * Escape hanya menutup sidebar.
                 */

                document.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Escape'
                        ) {

                            closeSidebar();

                        }

                    }
                );


                /* =====================================================
                   SAFE CHECK
                ====================================================== */

                function requiredElementsExist() {

                    const required = [

                        sidebar,

                        sidebarOverlay,

                        sidebarToggle,

                        locationModal,

                        allowLocationButton,

                        laterLocationButton,

                        bankSearch,

                        bankStatusFilter,

                        resetFilter,

                        bankGrid,

                        emptyState,

                        loadingState,

                        resultCount,

                        totalBank,

                        openBank,

                        closedBank,

                        locationStatusDot,

                        locationStatus,

                        nearestInfo,

                        mapLoading,

                        myLocationButton,

                        $('bankSampahMap')

                    ];


                    return required.every(
                        Boolean
                    );

                }


                /* =====================================================
                   ESCAPE HTML
                ====================================================== */

                function escapeHtml(
                    value
                ) {

                    return String(
                        value ?? ''
                    )

                        .replace(
                            /&/g,
                            '&amp;'
                        )

                        .replace(
                            /</g,
                            '&lt;'
                        )

                        .replace(
                            />/g,
                            '&gt;'
                        )

                        .replace(
                            /"/g,
                            '&quot;'
                        )

                        .replace(
                            /'/g,
                            '&#039;'
                        );

                }


                /* =====================================================
                   STATUS
                ====================================================== */

                function getStatusType(
                    bank
                ) {

                    const status =
                        String(
                            bank.status ?? ''
                        )
                            .trim()
                            .toLowerCase();


                    if (

                        status.includes(
                            'buka'
                        )

                        ||

                        status.includes(
                            'open'
                        )

                        ||

                        status.includes(
                            'operasional'
                        )

                        ||

                        status.includes(
                            '24 jam'
                        )

                    ) {

                        return 'open';

                    }


                    if (

                        status.includes(
                            'tutup'
                        )

                        ||

                        status.includes(
                            'closed'
                        )

                    ) {

                        return 'closed';

                    }


                    return 'unknown';

                }


                function getStatusLabel(
                    bank
                ) {

                    const type =
                        getStatusType(
                            bank
                        );


                    if (
                        type === 'open'
                    ) {

                        return 'Buka';

                    }


                    if (
                        type === 'closed'
                    ) {

                        return 'Tutup';

                    }


                    return 'Tidak diketahui';

                }


                function getStatusClass(
                    bank
                ) {

                    const type =
                        getStatusType(
                            bank
                        );


                    if (
                        type === 'open'
                    ) {

                        return 'status-open';

                    }


                    if (
                        type === 'closed'
                    ) {

                        return 'status-closed';

                    }


                    return 'status-unknown';

                }


                /* =====================================================
                   NORMALIZE BANK
                ====================================================== */

                function normalizeBank(
                    raw
                ) {

                    let operatingHours =
                        raw.operating_hours ??
                        raw.operatingHours ??
                        [];


                    if (

                        operatingHours &&

                        !Array.isArray(
                            operatingHours
                        )

                        &&

                        Array.isArray(
                            operatingHours.data
                        )

                    ) {

                        operatingHours =
                            operatingHours.data;

                    }


                    if (
                        !Array.isArray(
                            operatingHours
                        )
                    ) {

                        operatingHours =
                            [];

                    }


                    return {

                        ...raw,

                        id:
                            raw.id,

                        name:
                            raw.name ??
                            'Bank Sampah',

                        address:
                            raw.address ??
                            'Alamat belum tersedia',

                        latitude:
                            parseFloat(
                                raw.latitude
                            ),

                        longitude:
                            parseFloat(
                                raw.longitude
                            ),

                        whatsapp:
                            raw.whatsapp ??
                            '',

                        status:
                            raw.status ??
                            'Tidak diketahui',

                        waste_type:
                            raw.waste_type ??
                            raw.wasteType ??
                            raw.jenis_sampah ??
                            'Tidak diketahui',

                        operatingHours:
                            operatingHours

                    };

                }


                /* =====================================================
                   FORMAT TIME
                ====================================================== */

                function formatTime(
                    value
                ) {

                    if (
                        !value
                    ) {

                        return '-';

                    }


                    return String(
                        value
                    ).substring(
                        0,
                        5
                    );

                }


                function getDayName(
                    item
                ) {

                    return (

                        item.day_name ??

                        item.day ??

                        item.hari ??

                        item.dayName ??

                        '-'

                    );

                }


                /* =====================================================
                   GOOGLE MAPS
                   
                   MENGGUNAKAN NAMA + ALAMAT.
                ====================================================== */

                function googleMapsUrl(
                    bank
                ) {

                    const query =
                        [
                            bank.name,
                            bank.address
                        ]
                            .filter(
                                Boolean
                            )
                            .join(
                                ', '
                            );


                    return (
                        'https://www.google.com/maps/search/?api=1&query='
                        +
                        encodeURIComponent(
                            query
                        )
                    );

                }


                /* =====================================================
                   WHATSAPP
                ====================================================== */

                function whatsappUrl(
                    bank
                ) {

                    if (
                        !bank.whatsapp
                    ) {

                        return '';

                    }


                    let phone =
                        String(
                            bank.whatsapp
                        )
                            .replace(
                                /[^0-9]/g,
                                ''
                            );


                    if (
                        phone.startsWith(
                            '0'
                        )
                    ) {

                        phone =
                            '62' +
                            phone.substring(
                                1
                            );

                    }


                    if (
                        !phone
                    ) {

                        return '';

                    }


                    const message =
                        encodeURIComponent(
                            'Halo ' +
                            bank.name +
                            ', saya ingin mendapatkan informasi mengenai bank sampah.'
                        );


                    return (
                        'https://wa.me/' +
                        phone +
                        '?text=' +
                        message
                    );

                }


                /* =====================================================
                   DISTANCE
                ====================================================== */

                function calculateDistance(
                    lat1,
                    lng1,
                    lat2,
                    lng2
                ) {

                    const R =
                        6371000;


                    const dLat =
                        (
                            lat2 -
                            lat1
                        )
                        *
                        Math.PI /
                        180;


                    const dLng =
                        (
                            lng2 -
                            lng1
                        )
                        *
                        Math.PI /
                        180;


                    const a =

                        Math.sin(
                            dLat / 2
                        )
                        *
                        Math.sin(
                            dLat / 2
                        )

                        +

                        Math.cos(
                            lat1 *
                            Math.PI /
                            180
                        )

                        *

                        Math.cos(
                            lat2 *
                            Math.PI /
                            180
                        )

                        *

                        Math.sin(
                            dLng / 2
                        )
                        *
                        Math.sin(
                            dLng / 2
                        );


                    return (

                        R *

                        2 *

                        Math.atan2(
                            Math.sqrt(
                                a
                            ),
                            Math.sqrt(
                                1 - a
                            )
                        )

                    );

                }


                function formatDistance(
                    distance
                ) {

                    if (
                        !Number.isFinite(
                            distance
                        )
                    ) {

                        return '-';

                    }


                    if (
                        distance < 1000
                    ) {

                        return (
                            Math.round(
                                distance
                            )
                            +
                            ' m'
                        );

                    }


                    return (

                        (
                            distance /
                            1000
                        )
                            .toFixed(
                                2
                            )
                        +
                        ' km'

                    );

                }


                /* =====================================================
                   RECYCLE ICON
                   
                   HIJAU = BUKA
                   KUNING = TIDAK DIKETAHUI
                   MERAH = TUTUP
                ====================================================== */

                function createRecycleIcon(
                    bank
                ) {

                    let color =
                        '#eab308';


                    const type =
                        getStatusType(
                            bank
                        );


                    if (
                        type === 'open'
                    ) {

                        color =
                            '#16a34a';

                    }


                    if (
                        type === 'closed'
                    ) {

                        color =
                            '#ef4444';

                    }


                    return L.divIcon({

                        className:
                            'recycle-marker-wrapper',

                        html:
                            `
                    <div
                        class="recycle-marker"
                        style="--marker-color:${color}"
                    >

                        <div
                            class="recycle-marker-icon"
                        >
                            ♻
                        </div>

                        <div
                            class="recycle-marker-tail"
                        ></div>

                    </div>
                    `,

                        iconSize:
                            [
                                46,
                                54
                            ],

                        iconAnchor:
                            [
                                23,
                                54
                            ],

                        popupAnchor:
                            [
                                0,
                                -50
                            ]

                    });

                }


                /* =====================================================
                   USER ICON
                   
                   TETAP TITIK BIRU.
                ====================================================== */

                function createUserIcon() {

                    return L.divIcon({

                        className:
                            '',

                        html:
                            `
                    <div
                        class="user-location-marker"
                    ></div>
                    `,

                        iconSize:
                            [
                                18,
                                18
                            ],

                        iconAnchor:
                            [
                                9,
                                9
                            ],

                        popupAnchor:
                            [
                                0,
                                -9
                            ]

                    });

                }


                /* =====================================================
                   POPUP
                ====================================================== */

                function createPopup(
                    bank
                ) {

                    const statusLabel =
                        getStatusLabel(
                            bank
                        );


                    const statusClass =
                        getStatusClass(
                            bank
                        );


                    const googleUrl =
                        googleMapsUrl(
                            bank
                        );


                    const waUrl =
                        whatsappUrl(
                            bank
                        );


                    const distanceHtml =

                        Number.isFinite(
                            bank._distance
                        )

                            ?

                            `
                    <div class="popup-info">

                        <strong>
                            Jarak:
                        </strong>

                        ${formatDistance(
                                bank._distance
                            )}

                    </div>
                    `

                            :

                            '';


                    const waHtml =

                        waUrl

                            ?

                            `
                    <a
                        href="${waUrl}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="popup-button whatsapp-button"
                        onclick="event.stopPropagation();"
                    >
                        💬 WhatsApp
                    </a>
                    `

                            :

                            '';


                    return `

                <div>

                    <div class="popup-title">

                        ${escapeHtml(
                        bank.name
                    )}

                    </div>


                    <div class="popup-address">

                        📍
                        ${escapeHtml(
                        bank.address
                    )}

                    </div>


                    <div
                        class="
                            popup-status
                            ${statusClass}
                        "
                    >

                        ${escapeHtml(
                        statusLabel
                    )}

                    </div>


                    <div class="popup-info">

                        <strong>
                            Jenis sampah:
                        </strong>

                        ${escapeHtml(
                        bank.waste_type
                    )}

                    </div>


                    ${bank.whatsapp

                            ?

                            `
                        <div class="popup-info">

                            <strong>
                                WhatsApp:
                            </strong>

                            ${escapeHtml(
                                bank.whatsapp
                            )}

                        </div>
                        `

                            :

                            ''
                        }


                    ${distanceHtml}


                    <div class="popup-buttons">

                        <a
                            href="${googleUrl}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="
                                popup-button
                                google-button
                            "
                            onclick="event.stopPropagation();"
                        >
                            🗺 Google Maps
                        </a>


                        ${waHtml}

                    </div>

                </div>

            `;

                }


                /* =====================================================
                   MAP INITIALIZATION
                ====================================================== */

                function initializeMap() {

                    if (
                        mapInitialized
                    ) {

                        return;

                    }


                    const mapElement =
                        $('bankSampahMap');


                    if (
                        !mapElement
                    ) {

                        return;

                    }


                    map =
                        L.map(
                            mapElement,
                            {

                                zoomControl:
                                    true,

                                attributionControl:
                                    true,

                                preferCanvas:
                                    true,

                                zoomAnimation:
                                    false,

                                fadeAnimation:
                                    false,

                                markerZoomAnimation:
                                    false,

                                inertia:
                                    false,

                                worldCopyJump:
                                    false

                            }
                        );


                    map.setView(
                        DEFAULT_CENTER,
                        DEFAULT_ZOOM,
                        {
                            animate:
                                false
                        }
                    );


                    const tileLayer =
                        L.tileLayer(
                            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                            {

                                minZoom:
                                    11,

                                maxZoom:
                                    18,

                                updateWhenIdle:
                                    true,

                                updateWhenZooming:
                                    false,

                                keepBuffer:
                                    0,

                                detectRetina:
                                    false,

                                attribution:
                                    '&copy; OpenStreetMap contributors'

                            }
                        );


                    tileLayer.addTo(
                        map
                    );


                    mapInitialized =
                        true;


                    requestAnimationFrame(
                        function () {

                            if (
                                map
                            ) {

                                map.invalidateSize(
                                    false
                                );

                            }

                        }
                    );


                    setTimeout(
                        function () {

                            if (
                                map
                            ) {

                                map.invalidateSize(
                                    false
                                );

                            }

                            if (
                                mapLoading
                            ) {

                                mapLoading.classList.add(
                                    'hidden'
                                );

                            }

                        },
                        250
                    );

                }


                /* =====================================================
                   RENDER BANK MARKERS
                   
                   MARKER DIBUAT SATU KALI.
                ====================================================== */

                function renderBankMarkers() {

                    if (
                        !map
                    ) {

                        return;

                    }


                    banks.forEach(
                        function (
                            bank
                        ) {

                            if (

                                !Number.isFinite(
                                    bank.latitude
                                )

                                ||

                                !Number.isFinite(
                                    bank.longitude
                                )

                            ) {

                                return;

                            }


                            const markerId =
                                String(
                                    bank.id
                                );


                            if (
                                bankMarkers.has(
                                    markerId
                                )
                            ) {

                                return;

                            }


                            const marker =
                                L.marker(
                                    [
                                        bank.latitude,
                                        bank.longitude
                                    ],
                                    {

                                        icon:
                                            createRecycleIcon(
                                                bank
                                            ),

                                        keyboard:
                                            false

                                    }
                                );


                            marker.bindPopup(
                                createPopup(
                                    bank
                                ),
                                {

                                    autoPan:
                                        true,

                                    autoPanPadding:
                                        [
                                            20,
                                            20
                                        ]

                                }
                            );


                            marker.on(
                                'click',
                                function () {

                                    focusBankOnMap(
                                        bank,
                                        false
                                    );

                                }
                            );


                            marker.addTo(
                                map
                            );


                            bankMarkers.set(
                                markerId,
                                marker
                            );

                        }
                    );

                }


                /* =====================================================
                   UPDATE MARKER ICONS
                ====================================================== */

                function updateMarkerIcons() {

                    bankMarkers.forEach(
                        function (
                            marker,
                            id
                        ) {

                            const bank =
                                banks.find(
                                    function (
                                        item
                                    ) {

                                        return (
                                            String(
                                                item.id
                                            ) ===
                                            String(
                                                id
                                            )
                                        );

                                    }
                                );


                            if (
                                bank
                            ) {

                                marker.setIcon(
                                    createRecycleIcon(
                                        bank
                                    )
                                );


                                marker.setPopupContent(
                                    createPopup(
                                        bank
                                    )
                                );

                            }

                        }
                    );

                }


                /* =====================================================
                   FOCUS BANK
                   
                   Card → otomatis ke bagian map.
                ====================================================== */

                function focusBankOnMap(
                    bank,
                    scrollToMap = true
                ) {

                    if (
                        !map ||
                        !bank
                    ) {

                        return;

                    }


                    const marker =
                        bankMarkers.get(
                            String(
                                bank.id
                            )
                        );


                    if (
                        scrollToMap
                    ) {

                        mapSection.scrollIntoView(
                            {

                                behavior:
                                    'smooth',

                                block:
                                    'start'

                            }
                        );

                    }


                    setTimeout(
                        function () {

                            map.invalidateSize(
                                false
                            );


                            map.flyTo(
                                [
                                    bank.latitude,
                                    bank.longitude
                                ],
                                16,
                                {

                                    animate:
                                        true,

                                    duration:
                                        .65

                                }
                            );


                            if (
                                marker
                            ) {

                                setTimeout(
                                    function () {

                                        marker.openPopup();

                                    },
                                    550
                                );

                            }

                        },
                        scrollToMap
                            ? 350
                            : 50
                    );

                }


                /* =====================================================
                   RENDER OPERATING HOURS
                ====================================================== */

                function renderOperatingHours(
                    bank
                ) {

                    const hours =
                        bank.operatingHours;


                    if (
                        !Array.isArray(
                            hours
                        ) ||
                        hours.length === 0
                    ) {

                        return `
                    <div class="bank-hour-row">
                        <span>
                            Jam operasional
                        </span>

                        <strong>
                            Tidak tersedia
                        </strong>
                    </div>
                `;

                    }


                    return hours
                        .slice(
                            0,
                            7
                        )
                        .map(
                            function (
                                item
                            ) {

                                const day =
                                    getDayName(
                                        item
                                    );


                                const open =
                                    item.open_time ??
                                    item.open ??
                                    item.jam_buka ??
                                    '';


                                const close =
                                    item.close_time ??
                                    item.close ??
                                    item.jam_tutup ??
                                    '';


                                const value =
                                    open &&
                                        close

                                        ?

                                        `${formatTime(open)} - ${formatTime(close)}`

                                        :

                                        (
                                            item.is_closed
                                                ?

                                                'Tutup'

                                                :

                                                'Tidak tersedia'
                                        );


                                return `

                            <div
                                class="bank-hour-row"
                            >

                                <span>
                                    ${escapeHtml(
                                    day
                                )}
                                </span>

                                <strong>
                                    ${escapeHtml(
                                    value
                                )}
                                </strong>

                            </div>

                        `;

                            }
                        )
                        .join('');

                }


                /* =====================================================
                   RENDER BANK CARDS
                ====================================================== */

                function renderBankCards() {

                    const keyword =
                        String(
                            bankSearch.value ??
                            ''
                        )
                            .trim()
                            .toLowerCase();


                    const statusFilter =
                        bankStatusFilter.value;


                    filteredBanks =
                        banks.filter(
                            function (
                                bank
                            ) {

                                const name =
                                    String(
                                        bank.name ??
                                        ''
                                    )
                                        .toLowerCase();


                                const address =
                                    String(
                                        bank.address ??
                                        ''
                                    )
                                        .toLowerCase();


                                const matchKeyword =

                                    !keyword

                                    ||

                                    name.includes(
                                        keyword
                                    )

                                    ||

                                    address.includes(
                                        keyword
                                    );


                                const type =
                                    getStatusType(
                                        bank
                                    );


                                const matchStatus =

                                    statusFilter ===
                                    'all'

                                    ||

                                    (
                                        statusFilter ===
                                        'open' &&
                                        type ===
                                        'open'
                                    )

                                    ||

                                    (
                                        statusFilter ===
                                        'closed' &&
                                        type ===
                                        'closed'
                                    )

                                    ||

                                    (
                                        statusFilter ===
                                        'unknown' &&
                                        type ===
                                        'unknown'
                                    );


                                return (
                                    matchKeyword &&
                                    matchStatus
                                );

                            }
                        );


                    resultCount.textContent =
                        filteredBanks.length +
                        ' bank';


                    if (
                        filteredBanks.length ===
                        0
                    ) {

                        bankGrid.innerHTML =
                            '';

                        emptyState.style.display =
                            'block';

                        return;

                    }


                    emptyState.style.display =
                        'none';


                    bankGrid.innerHTML =

                        filteredBanks
                            .map(
                                function (
                                    bank
                                ) {

                                    if (
                                        userPosition
                                    ) {

                                        bank._distance =
                                            calculateDistance(
                                                userPosition.lat,
                                                userPosition.lng,
                                                bank.latitude,
                                                bank.longitude
                                            );

                                    }


                                    const googleUrl =
                                        googleMapsUrl(
                                            bank
                                        );


                                    const waUrl =
                                        whatsappUrl(
                                            bank
                                        );


                                    const nearestClass =

                                        nearestBank &&

                                            String(
                                                nearestBank.id
                                            ) ===
                                            String(
                                                bank.id
                                            )

                                            ?

                                            'nearest'

                                            :

                                            '';


                                    const distanceHtml =

                                        Number.isFinite(
                                            bank._distance
                                        )

                                            ?

                                            `
                                    <span
                                        class="bank-card-distance"
                                    >
                                        ${formatDistance(
                                                bank._distance
                                            )}
                                    </span>
                                    `

                                            :

                                            '';


                                    return `

                                <article
                                    class="
                                        bank-card
                                        ${nearestClass}
                                    "
                                    data-bank-id="${escapeHtml(
                                        bank.id
                                    )}"
                                >

                                    <div
                                        class="bank-card-title"
                                    >

                                        <h3
                                            class="bank-card-name"
                                        >
                                            ${escapeHtml(
                                        bank.name
                                    )}
                                        </h3>


                                        <span
                                            class="
                                                status-badge
                                                ${getStatusClass(
                                        bank
                                    )}
                                            "
                                        >
                                            ${escapeHtml(
                                        getStatusLabel(
                                            bank
                                        )
                                    )}
                                        </span>

                                    </div>


                                    <div
                                        class="bank-card-address"
                                    >

                                        📍
                                        ${escapeHtml(
                                        bank.address
                                    )}

                                    </div>


                                    <div
                                        class="bank-card-meta"
                                    >

                                        <span
                                            class="bank-card-type"
                                        >

                                            ♻️
                                            ${escapeHtml(
                                        bank.waste_type
                                    )}

                                        </span>


                                        ${distanceHtml}

                                    </div>


                                    ${nearestClass

                                            ?

                                            `
                                            <div
                                                style="
                                                    margin-top:9px;
                                                    color:#4d9900;
                                                    font-size:10px;
                                                    font-weight:800;
                                                "
                                            >
                                                📍
                                                Bank sampah terdekat
                                            </div>
                                            `

                                            :

                                            ''
                                        }


                                    <div
                                        class="bank-card-divider"
                                    ></div>


                                    <div
                                        class="bank-hours-title"
                                    >

                                        🕒
                                        Jam Operasional

                                    </div>


                                    <div
                                        class="bank-hours"
                                    >

                                        ${renderOperatingHours(
                                            bank
                                        )}

                                    </div>


                                    <div
                                        class="bank-card-actions"
                                    >

                                        <a
                                            href="${googleUrl}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="
                                                card-action
                                                card-google
                                            "
                                            onclick="
                                                event.stopPropagation();
                                            "
                                        >
                                            🗺 Google Maps
                                        </a>


                                        ${waUrl

                                            ?

                                            `
                                                <a
                                                    href="${waUrl}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="
                                                        card-action
                                                        card-whatsapp
                                                    "
                                                    onclick="
                                                        event.stopPropagation();
                                                    "
                                                >
                                                    💬 WhatsApp
                                                </a>
                                                `

                                            :

                                            `
                                                <span></span>
                                                `
                                        }

                                    </div>

                                </article>

                            `;

                                }
                            )
                            .join('');


                    /*
                     * Klik card.
                     */

                    bankGrid
                        .querySelectorAll(
                            '.bank-card'
                        )
                        .forEach(
                            function (
                                card
                            ) {

                                card.addEventListener(
                                    'click',
                                    function () {

                                        const bankId =
                                            card.dataset.bankId;


                                        const bank =
                                            banks.find(
                                                function (
                                                    item
                                                ) {

                                                    return (
                                                        String(
                                                            item.id
                                                        ) ===
                                                        String(
                                                            bankId
                                                        )
                                                    );

                                                }
                                            );


                                        if (
                                            bank
                                        ) {

                                            focusBankOnMap(
                                                bank,
                                                true
                                            );

                                        }

                                    }
                                );

                            }
                        );

                }


                /* =====================================================
                   UPDATE STATISTICS
                ====================================================== */

                function updateStatistics() {

                    const open =
                        banks.filter(
                            function (
                                bank
                            ) {

                                return (
                                    getStatusType(
                                        bank
                                    ) ===
                                    'open'
                                );

                            }
                        ).length;


                    const closed =
                        banks.filter(
                            function (
                                bank
                            ) {

                                return (
                                    getStatusType(
                                        bank
                                    ) ===
                                    'closed'
                                );

                            }
                        ).length;


                    totalBank.textContent =
                        banks.length;


                    openBank.textContent =
                        open;


                    closedBank.textContent =
                        banks.length -
                        open;

                }


                /* =====================================================
                   LOCATION STATUS
                ====================================================== */

                function setLocationStatus(
                    text,
                    state
                ) {

                    locationStatus.textContent =
                        text;


                    locationStatusDot.className =
                        'location-status-dot ' +
                        (
                            state ??
                            ''
                        );

                }


                /* =====================================================
                   UPDATE USER MARKER
                   
                   TIDAK ADA PANEL "Lokasi aktif..."
                   DI DALAM PETA.
                ====================================================== */

                function updateUserMarker(
                    position
                ) {

                    if (
                        !map
                    ) {

                        return;

                    }


                    const latitude =
                        Number(
                            position.coords.latitude
                        );


                    const longitude =
                        Number(
                            position.coords.longitude
                        );


                    const accuracy =
                        Number(
                            position.coords.accuracy
                        ) || 0;


                    if (

                        !Number.isFinite(
                            latitude
                        )

                        ||

                        !Number.isFinite(
                            longitude
                        )

                    ) {

                        return;

                    }


                    userPosition = {

                        lat:
                            latitude,

                        lng:
                            longitude,

                        accuracy:
                            accuracy

                    };


                    const latLng =
                        [
                            latitude,
                            longitude
                        ];


                    /*
                     * User marker.
                     */

                    if (
                        !userMarker
                    ) {

                        userMarker =
                            L.marker(
                                latLng,
                                {

                                    icon:
                                        createUserIcon(),

                                    zIndexOffset:
                                        3000,

                                    keyboard:
                                        false

                                }
                            )
                                .addTo(
                                    map
                                );


                        /*
                         * Popup sederhana.
                         */

                        userMarker.bindPopup(
                            `
                    <strong>
                        📍 Lokasi Saya
                    </strong>
                    `
                        );

                    } else {

                        userMarker.setLatLng(
                            latLng
                        );

                    }


                    /*
                     * Accuracy circle.
                     */

                    if (
                        !userAccuracyCircle
                    ) {

                        userAccuracyCircle =
                            L.circle(
                                latLng,
                                {

                                    radius:
                                        Math.max(
                                            accuracy,
                                            5
                                        ),

                                    color:
                                        '#2563eb',

                                    fillColor:
                                        '#2563eb',

                                    fillOpacity:
                                        .06,

                                    weight:
                                        1

                                }
                            )
                                .addTo(
                                    map
                                );

                    } else {

                        userAccuracyCircle.setLatLng(
                            latLng
                        );


                        userAccuracyCircle.setRadius(
                            Math.max(
                                accuracy,
                                5
                            )
                        );

                    }


                    /*
                     * Status hanya di bagian
                     * status lokasi halaman.
                     */

                    setLocationStatus(
                        'Lokasi aktif',
                        'active'
                    );


                    calculateNearestBank();

                }


                /* =====================================================
                   CALCULATE NEAREST BANK
                ====================================================== */

                function calculateNearestBank() {

                    if (

                        !userPosition

                        ||

                        !banks.length

                    ) {

                        nearestBank =
                            null;


                        nearestInfo.innerHTML =
                            `
                    Bank sampah terdekat:
                    <strong>
                        Belum tersedia
                    </strong>
                    `;


                        return;

                    }


                    let closest =
                        null;


                    let closestDistance =
                        Infinity;


                    banks.forEach(
                        function (
                            bank
                        ) {

                            if (

                                !Number.isFinite(
                                    bank.latitude
                                )

                                ||

                                !Number.isFinite(
                                    bank.longitude
                                )

                            ) {

                                return;

                            }


                            const distance =
                                calculateDistance(
                                    userPosition.lat,
                                    userPosition.lng,
                                    bank.latitude,
                                    bank.longitude
                                );


                            bank._distance =
                                distance;


                            if (
                                distance <
                                closestDistance
                            ) {

                                closestDistance =
                                    distance;

                                closest =
                                    bank;

                            }

                        }
                    );


                    if (
                        !closest
                    ) {

                        return;

                    }


                    nearestBank =
                        closest;


                    nearestInfo.innerHTML =
                        `
                Bank sampah terdekat:
                <strong>
                    ${escapeHtml(
                            closest.name
                        )}
                </strong>
                —
                ${formatDistance(
                            closestDistance
                        )}
                `;


                    updateMarkerIcons();


                    renderBankCards();

                }


                /* =====================================================
                   LOCATION ERROR
                ====================================================== */

                function handleLocationError(
                    error
                ) {

                    console.warn(
                        'Location error:',
                        error
                    );


                    let message =
                        'Lokasi belum tersedia';


                    if (
                        error &&
                        error.code === 1
                    ) {

                        message =
                            'Akses lokasi ditolak';

                    }


                    else if (
                        error &&
                        error.code === 2
                    ) {

                        message =
                            'Lokasi tidak tersedia';

                    }


                    else if (
                        error &&
                        error.code === 3
                    ) {

                        message =
                            'Permintaan lokasi timeout';

                    }


                    setLocationStatus(
                        message,
                        'error'
                    );


                    nearestInfo.innerHTML =
                        `
                Bank sampah terdekat:
                <strong>
                    Belum diketahui
                </strong>
                `;

                }


                /* =====================================================
                   START LOCATION TRACKING
                ====================================================== */

                function startLocationTracking() {

                    if (
                        !navigator.geolocation
                    ) {

                        handleLocationError({
                            code:
                                2
                        });

                        return;

                    }


                    if (
                        watchId !== null
                    ) {

                        navigator.geolocation.clearWatch(
                            watchId
                        );

                    }


                    watchId =
                        navigator.geolocation.watchPosition(

                            updateUserMarker,

                            handleLocationError,

                            GEO_OPTIONS

                        );

                }


                /* =====================================================
                   REQUEST LOCATION
                ====================================================== */

                function requestUserLocation() {

                    if (
                        locationRequestInProgress
                    ) {

                        return;

                    }


                    if (
                        !navigator.geolocation
                    ) {

                        handleLocationError({
                            code:
                                2
                        });

                        return;

                    }


                    locationRequestInProgress =
                        true;


                    hideLocationPermissionPrompt();


                    startLocationTracking();


                    navigator.geolocation.getCurrentPosition(

                        updateUserMarker,

                        handleLocationError,

                        GEO_OPTIONS

                    );


                    setTimeout(
                        function () {

                            locationRequestInProgress =
                                false;

                        },
                        1500
                    );

                }


                /* =====================================================
                   LOCATION BUTTON
                ====================================================== */

                myLocationButton.addEventListener(
                    'click',
                    function () {

                        if (
                            !userPosition
                        ) {

                            showLocationPermissionPrompt();

                            return;

                        }


                        map.invalidateSize(
                            false
                        );


                        map.flyTo(
                            [
                                userPosition.lat,
                                userPosition.lng
                            ],
                            16,
                            {

                                animate:
                                    true,

                                duration:
                                    .7

                            }
                        );


                        setTimeout(
                            function () {

                                if (
                                    userMarker
                                ) {

                                    userMarker.openPopup();

                                }

                            },
                            700
                        );

                    }
                );


                /* =====================================================
                   LOCATION PERMISSION
                ====================================================== */

                allowLocationButton.addEventListener(
                    'click',
                    function () {

                        requestUserLocation();

                    }
                );


                laterLocationButton.addEventListener(
                    'click',
                    function () {

                        hideLocationPermissionPrompt();


                        setLocationStatus(
                            'Lokasi belum diaktifkan',
                            ''
                        );

                    }
                );


                /* =====================================================
                   LOCATION MODAL
                ====================================================== */

                function showLocationPermissionPrompt() {

                    locationModal.classList.add(
                        'show'
                    );


                    locationModal.setAttribute(
                        'aria-hidden',
                        'false'
                    );


                    /*
                     * Tidak menggunakan:
                     * scrollIntoView()
                     * window.scrollTo()
                     *
                     * Jadi halaman tidak dipaksa
                     * menuju bagian map.
                     */

                    document.body.style.overflow =
                        'hidden';

                }


                function hideLocationPermissionPrompt() {

                    locationModal.classList.remove(
                        'show'
                    );


                    locationModal.setAttribute(
                        'aria-hidden',
                        'true'
                    );


                    document.body.style.overflow =
                        '';

                }


                /* =====================================================
                   SEARCH
                ====================================================== */

                bankSearch.addEventListener(
                    'input',
                    function () {

                        renderBankCards();

                    }
                );


                /* =====================================================
                   FILTER
                ====================================================== */

                bankStatusFilter.addEventListener(
                    'change',
                    function () {

                        renderBankCards();

                    }
                );


                /* =====================================================
                   RESET
                ====================================================== */

                resetFilter.addEventListener(
                    'click',
                    function () {

                        bankSearch.value =
                            '';

                        bankStatusFilter.value =
                            'all';

                        renderBankCards();

                    }
                );


                /* =====================================================
                   LOAD BANKS
                ====================================================== */

                async function loadBanks() {

                    loadingState.style.display =
                        'flex';


                    try {

                        const response =
                            await fetch(
                                API_URL,
                                {

                                    method:
                                        'GET',

                                    headers:
                                    {
                                        'Accept':
                                            'application/json'
                                    },

                                    cache:
                                        'default'

                                }
                            );


                        if (
                            !response.ok
                        ) {

                            throw new Error(
                                'HTTP ' +
                                response.status
                            );

                        }


                        const result =
                            await response.json();


                        let rawData =
                            [];


                        if (
                            Array.isArray(
                                result
                            )
                        ) {

                            rawData =
                                result;

                        }


                        else if (

                            result &&

                            Array.isArray(
                                result.data
                            )

                        ) {

                            rawData =
                                result.data;

                        }


                        banks =
                            rawData
                                .map(
                                    normalizeBank
                                )
                                .filter(
                                    function (
                                        bank
                                    ) {

                                        return (

                                            Number.isFinite(
                                                bank.latitude
                                            )

                                            &&

                                            Number.isFinite(
                                                bank.longitude
                                            )

                                        );

                                    }
                                );


                        updateStatistics();


                        renderBankMarkers();


                        renderBankCards();


                        if (
                            userPosition
                        ) {

                            calculateNearestBank();

                        }


                    }


                    catch (
                    error
                    ) {

                        console.error(
                            'Bank Sampah API Error:',
                            error
                        );


                        bankGrid.innerHTML =
                            `
                    <div
                        style="
                            grid-column:1/-1;
                            text-align:center;
                            padding:40px;
                            color:#dc2626;
                        "
                    >

                        <strong>
                            Gagal memuat data bank sampah.
                        </strong>

                        <br><br>

                        <span
                            style="
                                font-size:12px;
                                color:#667085;
                            "
                        >
                            Pastikan endpoint
                            /api/bank-sampah
                            tersedia.
                        </span>

                    </div>
                    `;

                    }


                    finally {

                        loadingState.style.display =
                            'none';

                    }

                }


                /* =====================================================
                   START
                   
                   URUTAN:
                   1. Validasi element.
                   2. Map dibuat.
                   3. API dipanggil.
                   4. Permission prompt muncul.
                ====================================================== */

                if (
                    !requiredElementsExist()
                ) {

                    console.error(
                        'Elemen halaman bank sampah tidak lengkap.'
                    );

                    return;

                }


                if (
                    typeof window.L ===
                    'undefined'
                ) {

                    console.error(
                        'Leaflet belum tersedia.'
                    );


                    mapLoading.textContent =
                        'Leaflet belum tersedia. Muat ulang halaman.';

                    return;

                }


                /*
                 * Map dibuat lebih dahulu.
                 */

                initializeMap();


                /*
                 * API hanya satu kali.
                 */

                loadBanks();


                /*
                 * Location Permission Prompt
                 * tetap muncul otomatis.
                 */

                setTimeout(
                    function () {

                        showLocationPermissionPrompt();

                    },
                    350
                );


                /* =====================================================
                   RESIZE
                ====================================================== */

                window.addEventListener(
                    'resize',
                    function () {

                        if (
                            map
                        ) {

                            requestAnimationFrame(
                                function () {

                                    map.invalidateSize(
                                        false
                                    );

                                }
                            );

                        }

                    }
                );


                /* =====================================================
                   TAB ACTIVE
                ====================================================== */

                document.addEventListener(
                    'visibilitychange',
                    function () {

                        if (

                            !document.hidden

                            &&

                            map

                        ) {

                            requestAnimationFrame(
                                function () {

                                    map.invalidateSize(
                                        false
                                    );

                                }
                            );

                        }

                    }
                );


                /* =====================================================
                   CLEANUP
                ====================================================== */

                window.addEventListener(
                    'beforeunload',
                    function () {

                        if (

                            watchId !== null

                            &&

                            navigator.geolocation

                        ) {

                            navigator.geolocation.clearWatch(
                                watchId
                            );

                            watchId =
                                null;

                        }

                    }
                );

            }

        );

    </script>


</body>

</html>