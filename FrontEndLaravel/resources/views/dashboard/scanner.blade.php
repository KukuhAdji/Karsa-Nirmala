@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-5xl space-y-6 px-4 pb-12 pt-5 sm:px-6">

    @if(session('success'))
        <div class="rounded-[24px] border border-lime-200 bg-lime-50 p-4 text-sm font-medium text-lime-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-[28px] border border-slate-200/80 bg-white/80 p-4 shadow-[0_20px_55px_rgba(15,23,42,0.06)] backdrop-blur-xl sm:p-6">

        <div class="space-y-5">

            <div class="space-y-1.5">
                <h1 class="text-[1.8rem] font-black tracking-tight text-slate-900 sm:text-[2.6rem]">
                    Karsa Nirmala Waste Scanner
                </h1>
                <p class="text-sm text-slate-500 sm:text-[0.98rem]">
                    Use your webcam live to scan waste for fast identification.
                </p>
            </div>

            <div class="space-y-6">

                <div class="relative overflow-hidden rounded-[24px] border border-slate-200 bg-slate-900 shadow-[0_18px_38px_rgba(15,23,42,0.12)]">
                    <video
                        id="cameraVideo"
                        class="hidden h-[280px] w-full object-cover sm:h-[360px]"
                        autoplay
                        muted
                        playsinline>
                    </video>

                    <img
                        id="preview"
                        class="hidden h-[280px] w-full object-cover sm:h-[360px]"
                        alt="Captured preview">

                    <div id="cameraFallback" class="flex h-[280px] w-full items-center justify-center text-base text-slate-300 sm:h-[360px]">
                        Live camera preview will appear here.
                    </div>
                </div>

                <canvas id="canvas" class="hidden"></canvas>

                <div class="flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <button
                        id="startCamera"
                        type="button"
                        class="w-full rounded-[18px] bg-gradient-to-r from-lime-500 to-emerald-500 px-6 py-3.5 text-sm font-bold text-white shadow-[0_14px_28px_rgba(34,197,94,0.25)] transition hover:scale-[1.01] sm:w-auto">
                        Start Camera
                    </button>

                    <button
                        id="captureBtn"
                        type="button"
                        class="hidden w-full rounded-[18px] bg-sky-500 px-6 py-3.5 text-sm font-bold text-white shadow-[0_14px_28px_rgba(14,165,233,0.25)] transition hover:scale-[1.01] sm:w-auto">
                        Capture Frame
                    </button>

                    <button
                        id="stopCamera"
                        type="button"
                        class="hidden w-full rounded-[18px] bg-slate-200 px-6 py-3.5 text-sm font-bold text-slate-700 transition hover:bg-slate-300 sm:w-auto">
                        Stop Camera
                    </button>

                    <label class="flex w-full cursor-pointer items-center justify-center rounded-[18px] border border-slate-200 bg-slate-100 px-6 py-3.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-200 sm:w-auto">
                        Upload Image
                        <input
                            type="file"
                            accept="image/*"
                            id="imageInput"
                            hidden>
                    </label>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-gradient-to-br from-lime-50 via-white to-emerald-50 p-5 sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div class="w-full space-y-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                Result
                            </p>
                            <h2 id="resultCategory" class="text-3xl font-black tracking-tight text-lime-600 sm:text-4xl">
                                Waiting for scan
                            </h2>

                            <div class="space-y-2">
                                <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-200">
                                    <div id="scanProgress" class="h-full w-0 rounded-full bg-gradient-to-r from-lime-500 to-emerald-500 transition-all duration-500"></div>
                                </div>
                                <p id="resultCategoryType" class="text-sm text-slate-500">
                                    Pilih gambar untuk memulai.
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col items-end gap-2">
                            <button
                                id="saveScanBtn"
                                type="button"
                                class="hidden rounded-[18px] bg-gradient-to-r from-emerald-500 to-lime-500 px-5 py-3 text-sm font-bold text-white shadow-[0_14px_28px_rgba(34,197,94,0.25)] transition hover:scale-[1.01]">
                                Simpan Scan
                            </button>
                            <p id="saveStatus" class="hidden text-xs font-semibold text-emerald-600"></p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <label class="text-sm font-semibold text-slate-600">
                            Confidence
                        </label>

                        <div class="h-3.5 overflow-hidden rounded-full bg-slate-200">
                            <div id="confidenceBar" class="h-full rounded-full bg-gradient-to-r from-lime-500 to-emerald-500" style="width: 0%"></div>
                        </div>

                        <p id="confidenceValue" class="text-base font-bold text-slate-700">
                            0%
                        </p>
                    </div>

                    <div id="youtubeSection" class="mt-6 hidden rounded-[22px] border border-red-100 bg-red-50 p-4">
                        <h4 class="text-lg font-black text-slate-800">
                            Tutorial Pengolahan Sampah
                        </h4>

                        <p id="youtubeTitle" class="mt-2 text-sm text-slate-700"></p>

                        <a
                            id="youtubeLink"
                            href="#"
                            target="_blank"
                            class="mt-4 inline-flex items-center justify-center rounded-[14px] bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-red-700">
                            🎥 Tonton Tutorial di YouTube
                        </a>
                    </div>

                    <div class="mt-6 rounded-[22px] border border-lime-200 bg-lime-50/80 p-4">
                        <h4 class="text-lg font-black text-slate-800">
                            Recycling Recommendation
                        </h4>

                        <div id="recommendations" class="mt-3 space-y-2 text-sm leading-relaxed text-slate-700">
                            <p>• Start a scan or upload an image first.</p>
                        </div>
                    </div>

                    <button
                        id="askAssistantBtn"
                        class="mt-6 w-full rounded-[18px] bg-gradient-to-r from-lime-500 to-emerald-500 px-5 py-4 text-base font-bold text-white shadow-[0_18px_32px_rgba(34,197,94,0.28)] transition hover:scale-[1.01]">
                        Ask AI Assistant
                    </button>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p id="cameraHint" class="text-sm text-slate-500">
                        Allow camera access to scan waste in real time.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const FASTAPI_URL = "{{ env('FASTAPI_URL', 'http://127.0.0.1:8001') }}".replace(/\/+$/g, '');
const PREDICT_ENDPOINT = `${FASTAPI_URL}/predict`;
const CHAT_PAGE_URL = "{{ route('chatbot') }}";
const cameraVideo = document.getElementById('cameraVideo');
const preview = document.getElementById('preview');
const cameraFallback = document.getElementById('cameraFallback');
const canvas = document.getElementById('canvas');
const startCameraBtn = document.getElementById('startCamera');
const captureBtn = document.getElementById('captureBtn');
const stopCameraBtn = document.getElementById('stopCamera');
const imageInput = document.getElementById('imageInput');
const askAssistantBtn = document.getElementById('askAssistantBtn');
const cameraHint = document.getElementById('cameraHint');
const saveScanBtn = document.getElementById('saveScanBtn');
const saveStatus = document.getElementById('saveStatus');
const resultCategory = document.getElementById('resultCategory');
const resultCategoryType = document.getElementById('resultCategoryType');
const confidenceBar = document.getElementById('confidenceBar');
const confidenceValue = document.getElementById('confidenceValue');
const recommendations = document.getElementById('recommendations');
const scanProgress = document.getElementById('scanProgress');

let cameraStream = null;
let currentImageFile = null;
let currentCategoryKey = null;
let currentPredictedClass = null;
let currentRecommendations = [
    'Start a scan or upload an image first.'
];
let currentYoutube = {
    title: 'Tutorial Pengelolaan Sampah',
    url: '#'
};

const classLabels = {
    accu: 'Accu',
    battery: 'Baterai',
    botol_kaca: 'Botol Kaca',
    botol_plastik: 'Botol Plastik',
    buah_sayur: 'Buah & Sayur',
    bungkus_plastik_makanan: 'Bungkus Plastik Makanan',
    cup_plastik: 'Cup Plastik',
    kaleng_minuman: 'Kaleng Minuman',
    kardus: 'Kardus',
    kertas: 'Kertas',
    pakaian: 'Pakaian',
    sepatu: 'Sepatu',
    sisa_makanan: 'Sisa Makanan'
};

const categoryNames = {
    organik: 'Organik',
    anorganik: 'Anorganik',
    'e-waste': 'Limbah Elektronik'
};

const categoryRecommendations = {
    organik: [
        'Pisahkan sampah organik dari sampah lainnya.',
        'Taruh pada tempat kompos atau tempat sampah organik.',
        'Gunakan sampah organik untuk kompos atau pupuk tanaman.'
    ],
    anorganik: [
        'Bersihkan sampah anorganik sebelum dibuang.',
        'Masukkan ke dalam tempat sampah daur ulang yang sesuai.',
        'Pisahkan plastik, kaca, kertas, dan logam.'
    ],
    'e-waste': [
        'Kumpulkan limbah elektronik di tempat khusus e-waste.',
        'Jangan buang bersama sampah biasa.',
        'Lepaskan baterai sebelum dibuang jika memungkinkan.'
    ]
};

function showPreview(imageSrc) {
    preview.src = imageSrc;
    preview.classList.remove('hidden');
    cameraVideo.classList.add('hidden');
    cameraFallback.classList.add('hidden');
    cameraHint.textContent = 'Image ready for classification.';
    saveScanBtn.classList.remove('hidden');
}

function getReadableLabel(classKey) {
    return classLabels[classKey] || classKey.replace(/_/g, ' ');
}

function getRecommendations(category, predictedClass) {
    const categoryKey = category || 'anorganik';
    const baseRecommendations = categoryRecommendations[categoryKey] || categoryRecommendations.anorganik;
    const extra = predictedClass ? [`Pastikan ${getReadableLabel(predictedClass)} dibuang dengan benar sesuai kategori.`] : [];
    return [...extra, ...baseRecommendations];
}

function updateYoutubeTutorial(category) {
    const youtubeSection = document.getElementById('youtubeSection');
    const youtubeTitle = document.getElementById('youtubeTitle');
    const youtubeLink = document.getElementById('youtubeLink');

    if (currentYoutube && currentYoutube.title && currentYoutube.url && currentYoutube.url !== '#') {
        youtubeTitle.textContent = currentYoutube.title;
        youtubeLink.href = currentYoutube.url;
        youtubeLink.onclick = null;
        youtubeSection.classList.remove('hidden');
        return;
    }

    youtubeTitle.textContent = 'Tutorial sedang dimuat...';
    youtubeLink.textContent = '🎥 Tonton Tutorial di YouTube';
    youtubeLink.href = '#';
    youtubeLink.onclick = (e) => {
        e.preventDefault();
        alert("Maaf, tutorial untuk sampah jenis ini sedang dicari. Silakan coba lagi atau search manual di YouTube dengan kata kunci: 'daur ulang " + category + "'");
    };
    youtubeSection.classList.remove('hidden');
}

function updateResult(label, categoryKey, confidence, recommendationsText) {
    currentCategoryKey = categoryKey || 'anorganik';
    currentPredictedClass = label;

    resultCategory.textContent = label;
    resultCategoryType.textContent = categoryNames[categoryKey] || categoryNames.anorganik;
    scanProgress.style.width = '100%';

    confidenceBar.style.width = `${confidence}%`;
    confidenceValue.textContent = `${confidence}%`;

    currentRecommendations = recommendationsText;

    if (typeof recommendationsText === 'string') {
        recommendations.innerHTML = recommendationsText;
    } else if (Array.isArray(recommendationsText)) {
        recommendations.innerHTML = recommendationsText
            .map(item => `<p>• ${item}</p>`)
            .join('');
    }

    updateYoutubeTutorial(categoryKey);
    saveScanBtn.classList.remove('hidden');
}

function setStatus(message, isError = false) {
    const statusText = isError ? message : message;
    resultCategoryType.textContent = statusText;
    scanProgress.style.width = isError ? '40%' : '60%';
    if (isError) {
        scanProgress.classList.remove('from-lime-500', 'to-emerald-500');
        scanProgress.classList.add('from-red-500', 'to-rose-500');
    } else {
        scanProgress.classList.remove('from-red-500', 'to-rose-500');
        scanProgress.classList.add('from-lime-500', 'to-emerald-500');
    }
}

async function startCamera() {
    try {
        cameraStream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment' },
            audio: false
        });

        cameraVideo.srcObject = cameraStream;
        cameraVideo.classList.remove('hidden');
        cameraFallback.classList.add('hidden');
        captureBtn.classList.remove('hidden');
        stopCameraBtn.classList.remove('hidden');
        preview.classList.add('hidden');
        cameraHint.textContent = 'Point your camera at waste and tap Capture Frame.';
    } catch (error) {
        cameraHint.textContent = 'Camera access blocked or unavailable. Please upload an image instead.';
        console.error(error);
    }
}

function stopCamera(showFallback = true) {
    if (cameraStream) {
        cameraStream.getTracks().forEach(track => track.stop());
        cameraStream = null;
    }

    cameraVideo.classList.add('hidden');
    captureBtn.classList.add('hidden');
    stopCameraBtn.classList.add('hidden');

    if (showFallback && preview.classList.contains('hidden')) {
        cameraFallback.classList.remove('hidden');
    } else {
        cameraFallback.classList.add('hidden');
    }
}

async function saveScan() {
    if (!currentImageFile) {
        setStatus('Pilih gambar atau ambil foto dulu sebelum menyimpan.', true);
        return;
    }

    const category = currentCategoryKey || 'anorganik';
    const confidence = parseFloat(confidenceValue.textContent.replace('%', '')) || 0;

    let recommendationText = '';
    if (typeof currentRecommendations === 'string') {
        const temp = document.createElement('div');
        temp.innerHTML = currentRecommendations;
        recommendationText = temp.textContent || temp.innerText || '';
    } else if (Array.isArray(currentRecommendations)) {
        recommendationText = currentRecommendations.join('\n');
    } else {
        recommendationText = 'Rekomendasi pengelolahan sampah sesuai kategori.';
    }

    const formData = new FormData();
    formData.append('image', currentImageFile);
    formData.append('category', category);
    formData.append('confidence', confidence);
    formData.append('recommendation', recommendationText);

    saveScanBtn.disabled = true;
    saveScanBtn.textContent = 'Menyimpan...';
    saveStatus.textContent = 'Sedang menyimpan scan...';
    saveStatus.classList.remove('hidden', 'text-red-600');
    saveStatus.classList.add('text-emerald-600');

    try {
        const response = await fetch("{{ route('scanner.upload') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData,
        });

        const contentType = response.headers.get('content-type') || '';
        const result = contentType.includes('application/json')
            ? await response.json()
            : { success: false, message: 'Server merespon dengan tipe yang tidak diharapkan.' };

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Terjadi kesalahan saat menyimpan scan.');
        }

        saveStatus.textContent = 'Penyimpanan selesai ✓';
        saveStatus.classList.remove('hidden', 'text-red-600');
        saveStatus.classList.add('text-emerald-600');
        saveScanBtn.textContent = 'Tersimpan';
        resultCategoryType.textContent = 'Scan berhasil disimpan ke database.';
        scanProgress.style.width = '100%';
        currentImageFile = null;
        saveScanBtn.disabled = false;

        setTimeout(() => {
            saveStatus.classList.add('hidden');
            saveScanBtn.textContent = 'Simpan Scan';
        }, 1800);
    } catch (error) {
        saveStatus.textContent = 'Gagal menyimpan scan';
        saveStatus.classList.remove('hidden', 'text-emerald-600');
        saveStatus.classList.add('text-red-600');
        setStatus(error.message, true);
        saveScanBtn.textContent = 'Simpan Scan';
        saveScanBtn.disabled = false;
        console.error(error);
    }
}

async function classifyImage(file) {
    if (!file) {
        setStatus('File tidak ditemukan.', true);
        return;
    }

    scanProgress.classList.remove('from-red-500', 'to-rose-500');
    scanProgress.classList.add('from-lime-500', 'to-emerald-500');
    scanProgress.style.width = '30%';
    resultCategory.textContent = 'Waiting for scan';
    resultCategoryType.textContent = 'Sedang menganalisis gambar...';

    const formData = new FormData();
    formData.append('file', file);

    try {
        const response = await fetch(PREDICT_ENDPOINT, {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();

        if (!response.ok || !data.predicted_class) {
            throw new Error(data.detail || data.error || 'Prediksi gagal.');
        }

        scanProgress.style.width = '75%';

        const classLabel = getReadableLabel(data.predicted_class);
        const categoryKey = data.category || 'anorganik';
        const categoryLabel = categoryNames[categoryKey] || categoryNames.anorganik;
        const confidencePercent = Math.round((data.confidence || 0) * 10000) / 100;
        const recommendationsText = data.recommendation || getRecommendations(categoryKey, data.predicted_class);

        if (data.youtube) {
            currentYoutube = data.youtube;
        }

        updateResult(classLabel, categoryKey, confidencePercent, recommendationsText);
        resultCategoryType.textContent = `Prediksi selesai: ${categoryLabel}`;
        currentImageFile = file;
    } catch (error) {
        scanProgress.style.width = '100%';
        resultCategory.textContent = 'Scan failed';
        resultCategoryType.textContent = error.message || 'Terjadi kesalahan saat memprediksi gambar.';
        scanProgress.classList.remove('from-lime-500', 'to-emerald-500');
        scanProgress.classList.add('from-red-500', 'to-rose-500');
        console.error(error);
    }
}

startCameraBtn?.addEventListener('click', startCamera);
stopCameraBtn?.addEventListener('click', stopCamera);

captureBtn?.addEventListener('click', () => {
    if (!cameraStream) {
        return;
    }

    const width = cameraVideo.videoWidth || 640;
    const height = cameraVideo.videoHeight || 480;

    canvas.width = width;
    canvas.height = height;

    const ctx = canvas.getContext('2d');
    ctx.drawImage(cameraVideo, 0, 0, width, height);

    canvas.toBlob(async blob => {
        if (!blob) {
            setStatus('Tidak dapat menangkap gambar.', true);
            return;
        }

        const file = new File([blob], 'scan.jpg', { type: 'image/jpeg' });
        currentImageFile = file;
        showPreview(URL.createObjectURL(blob));
        stopCamera(false);
        await classifyImage(file);
    }, 'image/jpeg');
});

imageInput?.addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (!file) return;

    currentImageFile = file;

    const reader = new FileReader();
    reader.onload = async function (e) {
        showPreview(e.target.result);
        stopCamera(false);
        await classifyImage(file);
    };
    reader.readAsDataURL(file);
});

askAssistantBtn?.addEventListener('click', () => {
    window.location.href = CHAT_PAGE_URL;
});

saveScanBtn?.addEventListener('click', saveScan);
</script>

@endsection
