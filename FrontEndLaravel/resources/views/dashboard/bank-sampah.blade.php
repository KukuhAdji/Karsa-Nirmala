@extends('layouts.app')

@push('styles')
    <style>
        .bank-page {
            display: grid;
            gap: 1.5rem;
        }

        .page-header {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .eyebrow {
            display: inline-flex;
            width: fit-content;
            align-items: center;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(132, 204, 22, 0.12);
            border: 1px solid rgba(132, 204, 22, 0.2);
            color: #4d7d11;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .page-header h1 {
            font-size: clamp(2rem, 3vw, 3rem);
            line-height: 1.08;
            font-weight: 900;
            margin: 0;
            color: #0f172a;
        }

        .page-header h1 span {
            color: #7acb2c;
        }

        .page-header p {
            max-width: 760px;
            margin: 0;
            color: #667085;
            line-height: 1.7;
        }

        .location-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.8rem 1rem;
            background: rgba(255,255,255,0.8);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
        }

        .location-status-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: #374151;
        }

        .location-status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 4px rgba(148,163,184,0.15);
        }

        .location-status-dot.waiting { background: #fbbf24; }
        .location-status-dot.active { background: #22c55e; }
        .location-status-dot.error { background: #ef4444; }

        .nearest-info {
            text-align: right;
            color: #475467;
            font-size: 0.8rem;
            line-height: 1.6;
        }

        .nearest-info strong { color: #0f172a; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .stat-card {
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(148,163,184,0.2);
            border-radius: 22px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
            padding: 1.1rem 1.1rem 1rem;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .stat-value {
            margin-top: 0.7rem;
            font-size: clamp(1.5rem, 2vw, 2.1rem);
            font-weight: 900;
            color: #0f172a;
        }

        .stat-value.green { color: #16a34a; }
        .stat-value.red { color: #dc2626; }

        .filter-card {
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(148,163,184,0.2);
            border-radius: 24px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
            padding: 1rem;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(200px, 0.7fr) auto;
            gap: 1rem;
            align-items: end;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .field label {
            color: #475467;
            font-size: 0.75rem;
            font-weight: 800;
        }

        .input,
        .select,
        .reset-button {
            min-height: 46px;
            border-radius: 12px;
            border: 1px solid #dce1e7;
            background: #fff;
            color: #0f172a;
            font-size: 0.88rem;
            padding: 0.75rem 0.9rem;
        }

        .input:focus,
        .select:focus {
            border-color: #7acb2c;
            box-shadow: 0 0 0 3px rgba(122, 203, 44, 0.12);
            outline: none;
        }

        .reset-button {
            cursor: pointer;
            font-weight: 800;
            color: #475467;
            padding-inline: 1rem;
        }

        .map-card {
            position: relative;
            width: 100%;
            height: 540px;
            overflow: hidden;
            border: 1px solid rgba(148,163,184,0.2);
            border-radius: 24px;
            background: #e9eef0;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        #bankSampahMap {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            background: #e9eef0;
        }

        #bankSampahMap .leaflet-container {
            width: 100%;
            height: 100%;
            background: #e9eef0;
            font-family: inherit;
        }

        .map-loading {
            position: absolute;
            inset: 0;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eef1f4;
            color: #667085;
            font-size: 0.78rem;
            pointer-events: none;
            transition: opacity 0.15s ease;
        }

        .map-loading.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .map-overlay {
            position: absolute;
            z-index: 1200;
            top: 1rem;
            right: 1rem;
            pointer-events: none;
        }

        .map-location-button {
            pointer-events: auto;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-height: 44px;
            padding: 0 1rem;
            border: 1px solid rgba(226,232,240,0.95);
            border-radius: 13px;
            background: rgba(255,255,255,0.97);
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.13);
            color: #344054;
            font-size: 0.78rem;
            font-weight: 800;
            border: none;
            cursor: pointer;
        }

        .location-button-icon {
            width: 25px;
            height: 25px;
            border-radius: 8px;
            background: rgba(122, 203, 44, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.9rem;
        }

        .section-heading h2 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 900;
            color: #172033;
        }

        .result-count {
            color: #7a8799;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .loading-state {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.7rem;
            min-height: 120px;
            color: #667085;
            font-size: 0.8rem;
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid #e5e7eb;
            border-top-color: #7acb2c;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .bank-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .bank-card {
            background: #fff;
            border: 1px solid rgba(148,163,184,0.2);
            border-radius: 18px;
            padding: 1rem;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .bank-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .bank-card.active {
            border-color: #7acb2c;
            box-shadow: 0 0 0 3px rgba(122, 203, 44, 0.12);
        }

        .card-top {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .card-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ecfdf5;
            color: #16a34a;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .card-title {
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.35;
            font-weight: 800;
            color: #172033;
        }

        .status-badge {
            display: inline-flex;
            margin-top: 0.4rem;
            padding: 5px 8px;
            border-radius: 999px;
            font-size: 0.65rem;
            font-weight: 800;
        }

        .status-open { background: #dcfce7; color: #15803d; }
        .status-closed { background: #fee2e2; color: #dc2626; }
        .status-unknown { background: #fef9c3; color: #a16207; }

        .card-address {
            margin: 0.9rem 0 0.5rem;
            color: #667085;
            font-size: 0.72rem;
            line-height: 1.55;
        }

        .card-hours {
            margin: 0.4rem 0 0.7rem;
            color: #475467;
            font-size: 0.7rem;
            line-height: 1.5;
            font-weight: 700;
        }

        .card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.7rem;
        }

        .card-type {
            color: #7a8799;
            font-size: 0.68rem;
        }

        .card-distance {
            color: #2563eb;
            font-size: 0.72rem;
            font-weight: 800;
        }

        .bank-actions {
            display: flex;
            gap: 0.45rem;
            margin-top: 0.8rem;
        }

        .card-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            min-height: 34px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 0.68rem;
            font-weight: 800;
        }

        .card-google { background: #eff6ff; color: #2563eb; }
        .card-whatsapp { background: #ecfdf5; color: #16a34a; }

        .empty-state {
            display: none;
            text-align: center;
            padding: 50px 20px;
            color: #667085;
        }

        .empty-state.show { display: block; }

        .location-modal {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(15,23,42,0.45);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: 0.2s ease;
            z-index: 50;
        }

        .location-modal.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .location-modal-card {
            width: min(100%, 420px);
            background: rgba(255,255,255,0.98);
            border-radius: 24px;
            padding: 1.35rem 1.2rem 1.1rem;
            box-shadow: 0 26px 60px rgba(15, 23, 42, 0.2);
            text-align: center;
        }

        .location-modal-icon {
            width: 62px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.85rem;
            border-radius: 18px;
            background: #edf9d6;
            font-size: 1.8rem;
        }

        .location-modal-card h3 {
            margin: 0;
            color: #0f172a;
            font-size: 1.35rem;
            font-weight: 900;
        }

        .location-modal-card p {
            margin-top: 0.8rem;
            color: #475467;
            font-size: 0.82rem;
            line-height: 1.7;
        }

        .location-permission-info {
            margin-top: 0.9rem;
            padding: 0.8rem 0.9rem;
            background: #f8fafc;
            border: 1px solid #edf2f7;
            border-radius: 12px;
            color: #475467;
            font-size: 0.76rem;
            line-height: 1.6;
        }

        .location-permission-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.7rem;
            margin-top: 1rem;
        }

        .location-permission-btn {
            min-height: 44px;
            border: none;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 800;
            cursor: pointer;
        }

        .location-permission-btn.allow { background: #7acb2c; color: white; }
        .location-permission-btn.later { background: #eef2f7; color: #475467; }

        @media (max-width: 900px) {
            .stats-grid,
            .bank-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 700px) {
            .filter-grid,
            .stats-grid,
            .bank-grid,
            .location-permission-actions {
                grid-template-columns: 1fr;
            }

            .location-status {
                flex-direction: column;
                align-items: flex-start;
            }

            .nearest-info {
                text-align: left;
            }

            .map-card {
                height: 400px;
                border-radius: 18px;
            }
        }
    </style>
@endpush

@section('content')
<div class="bank-page">
    <section class="page-header">
        <div class="eyebrow">♻️ Smart Waste Network</div>
        <h1>Bank <span>Sampah</span></h1>
        <p>
            Temukan bank sampah di sekitar Surabaya berdasarkan lokasi, status operasional,
            jenis sampah, dan informasi layanan.
        </p>
    </section>

    <div class="location-status">
        <div class="location-status-left">
            <span id="locationStatusDot" class="location-status-dot waiting"></span>
            <span id="locationStatus">Menunggu izin lokasi...</span>
        </div>
        <div id="nearestInfo" class="nearest-info">
            Bank sampah terdekat: <strong>Belum tersedia</strong>
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
                <input id="bankSearch" class="input" type="search" placeholder="Cari nama atau alamat..." autocomplete="off">
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
            <button type="button" id="resetFilter" class="reset-button">Reset Filter</button>
        </div>
    </section>

    <section id="mapSection" class="map-card">
        <div id="bankSampahMap">
            <div id="mapLoading" class="map-loading">Memuat peta...</div>
        </div>
        <div class="map-overlay">
            <button type="button" id="myLocationButton" class="map-location-button">
                <span class="location-button-icon">📍</span>
                <span>Lokasi Saya</span>
            </button>
        </div>
    </section>

    <div class="section-heading">
        <h2>Daftar Bank Sampah</h2>
        <span id="resultCount" class="result-count">Memuat data...</span>
    </div>

    <div id="loadingState" class="loading-state">
        <div class="spinner"></div>
        Memuat data bank sampah...
    </div>

    <div id="bankGrid" class="bank-grid"></div>

    <div id="emptyState" class="empty-state">
        <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔎</div>
        <h3>Bank sampah tidak ditemukan</h3>
        <p>Coba gunakan kata kunci atau filter lainnya.</p>
    </div>
</div>

<div id="locationModal" class="location-modal" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="location-modal-card">
        <div class="location-modal-icon">📍</div>
        <h3 id="locationModalTitle">Location Permission Prompt</h3>
        <p>
            Izinkan aplikasi mengakses lokasi Anda untuk menampilkan posisi Anda pada peta dan
            menemukan bank sampah terdekat secara realtime.
        </p>
        <div class="location-permission-info">
            🔒 Lokasi digunakan hanya untuk fitur peta, perhitungan jarak, dan pencarian bank sampah terdekat.
        </div>
        <div class="location-permission-actions">
            <button type="button" id="allowLocationButton" class="location-permission-btn allow">📍 Izinkan Lokasi</button>
            <button type="button" id="laterLocationButton" class="location-permission-btn later">Nanti</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const API_URL = '/api/bank-sampah';
        const DEFAULT_CENTER = [-7.2575, 112.7521];
        const DEFAULT_ZOOM = 12;
        const GEO_OPTIONS = { enableHighAccuracy: true, maximumAge: 5000, timeout: 20000 };

        const bankSearch = document.getElementById('bankSearch');
        const bankStatusFilter = document.getElementById('bankStatusFilter');
        const resetFilter = document.getElementById('resetFilter');
        const bankGrid = document.getElementById('bankGrid');
        const emptyState = document.getElementById('emptyState');
        const loadingState = document.getElementById('loadingState');
        const resultCount = document.getElementById('resultCount');
        const totalBank = document.getElementById('totalBank');
        const openBank = document.getElementById('openBank');
        const closedBank = document.getElementById('closedBank');
        const locationStatus = document.getElementById('locationStatus');
        const locationStatusDot = document.getElementById('locationStatusDot');
        const nearestInfo = document.getElementById('nearestInfo');
        const mapLoading = document.getElementById('mapLoading');
        const myLocationButton = document.getElementById('myLocationButton');
        const locationModal = document.getElementById('locationModal');
        const allowLocationButton = document.getElementById('allowLocationButton');
        const laterLocationButton = document.getElementById('laterLocationButton');

        let banks = [];
        let filteredBanks = [];
        let map = null;
        let userPosition = null;
        let nearestBank = null;
        let userMarker = null;
        let userAccuracyCircle = null;
        let watchId = null;

        const bankMarkers = new Map();

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/\"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function getStatusType(bank) {
            const status = String(bank.status ?? '').trim().toLowerCase();
            if (status.includes('buka') || status.includes('open') || status.includes('operasional') || status.includes('24 jam')) return 'open';
            if (status.includes('tutup') || status.includes('closed')) return 'closed';
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

        function getTodayOperatingHours(bank) {
            const operatingHours = Array.isArray(bank.operatingHours) ? bank.operatingHours : [];
            if (!operatingHours.length) return 'Jam buka: tidak tersedia';

            const dayNames = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
            const today = dayNames[new Date().getDay()];
            const todaysHours = operatingHours.filter(item => String(item.day ?? '').toLowerCase() === today);

            if (!todaysHours.length) return 'Jam buka: tidak tersedia';
            if (todaysHours.some(item => item.is_unknown)) return 'Jam buka: tidak diketahui';
            if (todaysHours.some(item => item.is_24_hours)) return 'Jam buka: 24 jam';
            if (todaysHours.some(item => item.is_closed)) return 'Jam buka: tutup';

            const segments = todaysHours
                .filter(item => item.open_time && item.close_time)
                .map(item => item.open_time + ' - ' + item.close_time);

            if (segments.length) return 'Jam buka: ' + segments.join(', ');
            return 'Jam buka: tidak tersedia';
        }

        function normalizeBank(raw) {
            let operatingHours = raw.operating_hours ?? raw.operatingHours ?? [];
            if (operatingHours && !Array.isArray(operatingHours) && Array.isArray(operatingHours.data)) {
                operatingHours = operatingHours.data;
            }
            if (!Array.isArray(operatingHours)) operatingHours = [];

            return {
                ...raw,
                id: raw.id,
                name: raw.name ?? 'Bank Sampah',
                address: raw.address ?? 'Alamat belum tersedia',
                latitude: parseFloat(raw.latitude),
                longitude: parseFloat(raw.longitude),
                whatsapp: raw.whatsapp ?? '',
                status: raw.status ?? 'Tidak diketahui',
                waste_type: raw.waste_type ?? raw.wasteType ?? raw.jenis_sampah ?? 'Tidak diketahui',
                operatingHours
            };
        }

        function calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371000;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) ** 2 +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng / 2) ** 2;
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        }

        function formatDistance(distance) {
            if (!Number.isFinite(distance)) return '-';
            if (distance < 1000) return Math.round(distance) + ' m';
            return (distance / 1000).toFixed(2) + ' km';
        }

        function googleMapsUrl(bank) {
            const lat = Number(bank.latitude);
            const lng = Number(bank.longitude);
            if (Number.isFinite(lat) && Number.isFinite(lng)) {
                return 'https://www.google.com/maps/dir/?api=1&destination=' + encodeURIComponent(lat + ',' + lng);
            }
            return 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent([bank.name, bank.address].filter(Boolean).join(', '));
        }

        function whatsappUrl(bank) {
            if (!bank.whatsapp) return '';
            let phone = String(bank.whatsapp).replace(/[^0-9]/g, '');
            if (phone.startsWith('0')) phone = '62' + phone.substring(1);
            if (!phone) return '';
            const message = encodeURIComponent('Halo ' + bank.name + ', saya ingin mendapatkan informasi mengenai bank sampah.');
            return 'https://wa.me/' + phone + '?text=' + message;
        }

        function showLocationPermissionPrompt() {
            locationModal.classList.add('show');
            locationModal.setAttribute('aria-hidden', 'false');
            // Jangan memaksa body scroll tertutup. Halaman harus tetap bisa di-scroll,
            // terutama karena map dan daftar bank berada di bawah fold.
            document.body.style.overflow = '';
        }

        function hideLocationPermissionPrompt() {
            locationModal.classList.remove('show');
            locationModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        function initializeMap() {
            if (typeof window.L === 'undefined') {
                mapLoading.textContent = 'Leaflet belum tersedia. Muat ulang halaman.';
                return;
            }

            map = L.map(document.getElementById('bankSampahMap'), {
                zoomControl: true,
                attributionControl: true,
                preferCanvas: true,
                zoomAnimation: false,
                fadeAnimation: false,
                markerZoomAnimation: false,
                inertia: false,
                worldCopyJump: false
            });

            map.setView(DEFAULT_CENTER, DEFAULT_ZOOM, { animate: false });
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                minZoom: 10,
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            requestAnimationFrame(() => {
                map.invalidateSize(false);
                mapLoading.classList.add('hidden');
            });
        }

        function createUserIcon() {
            return L.divIcon({
                className: '',
                html: '<div style="width:18px;height:18px;border-radius:50%;background:#2563eb;border:3px solid #fff;box-shadow:0 0 0 4px rgba(37,99,235,0.20),0 3px 12px rgba(15,23,42,0.25);"></div>',
                iconSize: [18, 18],
                iconAnchor: [9, 9],
                popupAnchor: [0, -9]
            });
        }

        function createRecycleIcon(bank) {
            let color = '#eab308';
            const type = getStatusType(bank);
            if (type === 'open') color = '#16a34a';
            if (type === 'closed') color = '#ef4444';

            return L.divIcon({
                className: 'recycle-marker-wrapper',
                html: `
                    <div style="position:relative;width:46px;height:54px;display:flex;align-items:center;justify-content:center;filter:drop-shadow(0 4px 6px rgba(15,23,42,.22));">
                        <div style="position:absolute;width:42px;height:42px;left:2px;top:0;border-radius:50% 50% 50% 0;transform:rotate(-45deg);background:${color};border:3px solid #fff;"></div>
                        <div style="position:relative;z-index:2;width:26px;height:26px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;font-weight:900;">♻</div>
                        <div style="position:absolute;left:20px;bottom:1px;width:6px;height:9px;background:${color};transform:rotate(45deg);z-index:1;"></div>
                    </div>
                `,
                iconSize: [46, 54],
                iconAnchor: [23, 54],
                popupAnchor: [0, -50]
            });
        }

        function createPopup(bank) {
            const statusClass = getStatusClass(bank);
            const statusLabel = getStatusLabel(bank);
            const waUrl = whatsappUrl(bank);
            const distanceHtml = Number.isFinite(bank._distance) ? '<div style="font-size:11px;color:#667085;line-height:1.55;margin:4px 0;"><strong>Jarak:</strong> ' + formatDistance(bank._distance) + '</div>' : '';

            return `
                <div>
                    <div style="font-size:14px;font-weight:900;color:#172033;margin-bottom:7px;">${escapeHtml(bank.name)}</div>
                    <div style="font-size:11px;line-height:1.55;color:#667085;margin-bottom:8px;">📍 ${escapeHtml(bank.address)}</div>
                    <div style="display:inline-flex;padding:5px 8px;border-radius:999px;font-size:10px;font-weight:800;margin-bottom:8px;${statusClass === 'status-open' ? 'background:#dcfce7;color:#15803d;' : statusClass === 'status-closed' ? 'background:#fee2e2;color:#dc2626;' : 'background:#fef9c3;color:#a16207;'}">${escapeHtml(statusLabel)}</div>
                    <div style="font-size:11px;color:#667085;line-height:1.55;margin:4px 0;"><strong>Jenis sampah:</strong> ${escapeHtml(bank.waste_type)}</div>
                    ${distanceHtml}
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:10px;">
                        <a href="${googleMapsUrl(bank)}" target="_blank" rel="noopener noreferrer" style="display:inline-flex;align-items:center;justify-content:center;padding:7px 9px;border-radius:8px;text-decoration:none;font-size:10px;font-weight:800;background:#eff6ff;color:#1d4ed8;">🗺 Google Maps</a>
                        ${waUrl ? '<a href="' + waUrl + '" target="_blank" rel="noopener noreferrer" style="display:inline-flex;align-items:center;justify-content:center;padding:7px 9px;border-radius:8px;text-decoration:none;font-size:10px;font-weight:800;background:#dcfce7;color:#15803d;">💬 WhatsApp</a>' : ''}
                    </div>
                </div>
            `;
        }

        function renderBankMarkers() {
            if (!map) return;

            banks.forEach(bank => {
                if (!Number.isFinite(bank.latitude) || !Number.isFinite(bank.longitude)) return;
                const id = String(bank.id);

                if (bankMarkers.has(id)) {
                    const marker = bankMarkers.get(id);
                    marker.setIcon(createRecycleIcon(bank));
                    marker.setPopupContent(createPopup(bank));
                    return;
                }

                const marker = L.marker([bank.latitude, bank.longitude], { icon: createRecycleIcon(bank), keyboard: false });
                marker.bindPopup(createPopup(bank), { autoPan: true, autoPanPadding: [20, 20] });
                marker.on('click', () => highlightCard(bank.id));
                marker.addTo(map);
                bankMarkers.set(id, marker);
            });

            updateMarkerVisibility();
        }

        function updateMarkerVisibility() {
            if (!map) return;
            const visibleIds = new Set(filteredBanks.map(bank => String(bank.id)));
            bankMarkers.forEach((marker, id) => {
                if (visibleIds.has(id)) {
                    if (!map.hasLayer(marker)) marker.addTo(map);
                } else if (map.hasLayer(marker)) {
                    map.removeLayer(marker);
                }
            });
        }

        function highlightCard(bankId) {
            document.querySelectorAll('.bank-card').forEach(card => card.classList.remove('active'));
            const selected = document.querySelector('.bank-card[data-bank-id="' + CSS.escape(String(bankId)) + '"]');
            if (selected) selected.classList.add('active');
        }

        function focusBank(bankId) {
            const bank = banks.find(item => String(item.id) === String(bankId));
            if (!bank || !map) return;

            highlightCard(bankId);
            map.setView([bank.latitude, bank.longitude], 16, { animate: false });
            const marker = bankMarkers.get(String(bankId));
            if (marker) marker.openPopup();
        }

        function getFilteredBanks() {
            const keyword = bankSearch.value.trim().toLowerCase();
            const status = bankStatusFilter.value;

            return banks.filter(bank => {
                const text = (bank.name + ' ' + bank.address).toLowerCase();
                const matchSearch = !keyword || text.includes(keyword);
                let matchStatus = true;
                if (status === 'Buka') matchStatus = getStatusType(bank) === 'open';
                if (status === 'Tutup') matchStatus = getStatusType(bank) === 'closed';
                if (status === 'unknown') matchStatus = getStatusType(bank) === 'unknown';
                return matchSearch && matchStatus;
            });
        }

        function createBankCard(bank) {
            const statusClass = getStatusClass(bank);
            const statusLabel = getStatusLabel(bank);
            const distance = userPosition ? calculateDistance(userPosition.lat, userPosition.lng, bank.latitude, bank.longitude) : null;
            bank._distance = distance;

            return `
                <article class="bank-card" data-bank-id="${escapeHtml(bank.id)}" tabindex="0" role="button">
                    <div class="card-top">
                        <div class="card-icon">♻</div>
                        <div>
                            <h3 class="card-title">${escapeHtml(bank.name)}</h3>
                            <span class="status-badge ${statusClass}">${escapeHtml(statusLabel)}</span>
                        </div>
                    </div>
                    <div class="card-address">📍 ${escapeHtml(bank.address)}</div>
                    <div class="card-hours">🕒 ${escapeHtml(getTodayOperatingHours(bank))}</div>
                    <div class="card-meta">
                        <span class="card-type">${escapeHtml(bank.waste_type)}</span>
                        <span class="card-distance">${distance !== null ? '📏 ' + formatDistance(distance) : ''}</span>
                    </div>
                    <div class="bank-actions">
                        <a href="${googleMapsUrl(bank)}" target="_blank" rel="noopener noreferrer" class="card-action card-google">🗺 Maps</a>
                        ${whatsappUrl(bank) ? '<a href="' + whatsappUrl(bank) + '" target="_blank" rel="noopener noreferrer" class="card-action card-whatsapp">💬 WhatsApp</a>' : ''}
                    </div>
                </article>
            `;
        }

        function renderBankCards() {
            filteredBanks = getFilteredBanks();

            if (userPosition) {
                filteredBanks.sort((a, b) => {
                    const da = calculateDistance(userPosition.lat, userPosition.lng, a.latitude, a.longitude);
                    const db = calculateDistance(userPosition.lat, userPosition.lng, b.latitude, b.longitude);
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
            bankGrid.innerHTML = filteredBanks.map(createBankCard).join('');

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

        function updateUserMarker(position) {
            if (!map) return;
            const lat = Number(position.coords.latitude);
            const lng = Number(position.coords.longitude);
            const accuracy = Number(position.coords.accuracy) || 0;
            if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

            userPosition = { lat, lng, accuracy };
            const latLng = [lat, lng];

            if (!userMarker) {
                userMarker = L.marker(latLng, { icon: createUserIcon(), zIndexOffset: 3000, keyboard: false }).addTo(map);
                userMarker.bindPopup('<strong>📍 Lokasi Saya</strong>');
            } else {
                userMarker.setLatLng(latLng);
            }

            if (!userAccuracyCircle) {
                userAccuracyCircle = L.circle(latLng, {
                    radius: Math.max(accuracy, 5),
                    color: '#2563eb',
                    fillColor: '#2563eb',
                    fillOpacity: 0.06,
                    weight: 1,
                    interactive: false
                }).addTo(map);
            } else {
                userAccuracyCircle.setLatLng(latLng);
                userAccuracyCircle.setRadius(Math.max(accuracy, 5));
            }

            locationStatus.textContent = 'Lokasi aktif';
            locationStatusDot.className = 'location-status-dot active';
            calculateNearestBank();
        }

        function handleLocationSuccess(position) {
            userPosition = { lat: Number(position.coords.latitude), lng: Number(position.coords.longitude), accuracy: Number(position.coords.accuracy) || 0 };
            updateUserMarker(position);
        }

        function handleLocationError(error) {
            console.warn('GPS error:', error);
            locationStatusDot.className = 'location-status-dot error';

            if (error && error.code === 1) locationStatus.textContent = 'Akses lokasi ditolak';
            else if (error && error.code === 2) locationStatus.textContent = 'Lokasi tidak tersedia';
            else if (error && error.code === 3) locationStatus.textContent = 'Permintaan lokasi timeout';
            else locationStatus.textContent = 'Lokasi belum tersedia';

            nearestInfo.innerHTML = 'Bank sampah terdekat: <strong>Belum diketahui</strong>';
        }

        function calculateNearestBank() {
            if (!userPosition || !banks.length) {
                nearestBank = null;
                nearestInfo.innerHTML = 'Bank sampah terdekat: <strong>Belum tersedia</strong>';
                return;
            }

            let closest = null;
            let closestDistance = Infinity;
            banks.forEach(bank => {
                if (!Number.isFinite(bank.latitude) || !Number.isFinite(bank.longitude)) return;
                const distance = calculateDistance(userPosition.lat, userPosition.lng, bank.latitude, bank.longitude);
                bank._distance = distance;
                if (distance < closestDistance) {
                    closestDistance = distance;
                    closest = bank;
                }
            });

            nearestBank = closest;
            if (!closest) return;
            nearestInfo.innerHTML = 'Bank sampah terdekat: <strong>' + escapeHtml(closest.name) + '</strong> — ' + formatDistance(closestDistance);
            renderBankCards();
        }

        function requestUserLocation() {
            if (!navigator.geolocation) {
                handleLocationError({ code: 2 });
                return;
            }

            locationStatus.textContent = 'Mencari lokasi...';
            locationStatusDot.className = 'location-status-dot waiting';
            hideLocationPermissionPrompt();

            navigator.geolocation.getCurrentPosition(
                position => {
                    handleLocationSuccess(position);
                    if (map && userPosition) map.setView([userPosition.lat, userPosition.lng], 15, { animate: false });
                    if (watchId !== null) navigator.geolocation.clearWatch(watchId);
                    watchId = navigator.geolocation.watchPosition(handleLocationSuccess, handleLocationError, GEO_OPTIONS);
                },
                error => {
                    handleLocationError(error);
                    if (watchId !== null) navigator.geolocation.clearWatch(watchId);
                    watchId = navigator.geolocation.watchPosition(handleLocationSuccess, handleLocationError, GEO_OPTIONS);
                },
                GEO_OPTIONS
            );
        }

        async function loadBanks() {
            loadingState.style.display = 'flex';
            try {
                const response = await fetch(API_URL, { method: 'GET', headers: { Accept: 'application/json' }, cache: 'default' });
                if (!response.ok) throw new Error('HTTP ' + response.status);

                const result = await response.json();
                let rawData = [];
                if (Array.isArray(result)) rawData = result;
                else if (result && Array.isArray(result.data)) rawData = result.data;

                banks = rawData.map(normalizeBank).filter(bank => Number.isFinite(bank.latitude) && Number.isFinite(bank.longitude));

                totalBank.textContent = banks.length;
                openBank.textContent = banks.filter(bank => getStatusType(bank) === 'open').length;
                closedBank.textContent = banks.filter(bank => getStatusType(bank) !== 'open').length;

                renderBankMarkers();
                renderBankCards();
            } catch (error) {
                console.error('Bank Sampah API Error:', error);
                bankGrid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:40px;color:#dc2626;"><strong>Gagal memuat data bank sampah.</strong><br><br><span style="font-size:12px;color:#667085">Pastikan endpoint /api/bank-sampah tersedia.</span></div>';
            } finally {
                loadingState.style.display = 'none';
            }
        }

        bankSearch.addEventListener('input', renderBankCards);
        bankStatusFilter.addEventListener('change', renderBankCards);
        resetFilter.addEventListener('click', () => {
            bankSearch.value = '';
            bankStatusFilter.value = 'all';
            renderBankCards();
        });

        myLocationButton.addEventListener('click', () => {
            if (!('geolocation' in navigator)) {
                handleLocationError({ code: 2 });
                return;
            }

            requestUserLocation();

            if (map && userPosition) {
                map.invalidateSize(false);
                map.setView([userPosition.lat, userPosition.lng], 16, { animate: false });
            }
        });

        allowLocationButton.addEventListener('click', requestUserLocation);
        laterLocationButton.addEventListener('click', hideLocationPermissionPrompt);

        initializeMap();
        loadBanks();

        // Gunakan browser-native permission prompt. Ini akan muncul seperti permission
        // yang biasa ditampilkan oleh situs web, bukan custom modal yang terlihat seperti
        // overlay buatan. Browser sendiri yang menentukan apakah prompt muncul atau tidak.
        if ('geolocation' in navigator) {
            requestUserLocation();
        } else {
            handleLocationError({ code: 2 });
        }

        window.addEventListener('resize', () => {
            if (map) requestAnimationFrame(() => map.invalidateSize(false));
        });
    });
</script>
@endpush
