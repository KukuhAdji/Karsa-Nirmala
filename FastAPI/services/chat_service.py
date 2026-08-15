import os
from pathlib import Path
from dotenv import load_dotenv
import requests
from typing import Optional
import time

BASE_DIR = Path(__file__).resolve().parent.parent
DOTENV_PATHS = [
    BASE_DIR / '.env',
    BASE_DIR / 'Frontend' / '.env'
]
for dotenv_path in DOTENV_PATHS:
    if dotenv_path.exists():
        load_dotenv(dotenv_path)

OPENROUTER_API_KEY = os.getenv('OPENROUTER_API_KEY')
print("=" * 50)
print("OPENROUTER_API_KEY =", OPENROUTER_API_KEY)
print("=" * 50)
OPENROUTER_MODEL = os.getenv(
    "OPENROUTER_MODEL",
    "google/gemma-4-31b-it:free"
)
print("MODEL =", OPENROUTER_MODEL)
OPENROUTER_URL = 'https://openrouter.ai/api/v1/chat/completions'

# Cache untuk mengurangi API calls
_response_cache = {}

# Pemetaan jenis sampah ke rekomendasi pengolahan dan nilai ekonomi
WASTE_CLASS_INFO = {
    "botol_plastik": {"category": "Anorganik", "handling": "Cuci bersih, pisahkan tutup dan label, lalu kumpulkan untuk daur ulang menjadi biji plastik atau produk lain.", "economic_value": "Kisaran harga umum di pasaran sekitar Rp 1.500–Rp 4.000 per kg untuk botol PET bersih dan kering, tergantung warna, kebersihan, dan permintaan pengepul."},
    "botol_kaca": {"category": "Anorganik", "handling": "Pisahkan dari sampah lain, bersihkan, dan simpan terpisah untuk dijual ke pengepul kaca.", "economic_value": "Kisaran harga umum sekitar Rp 300–Rp 1.500 per kg, tergantung jenis kaca, kebersihan, dan kondisi botol yang tidak pecah."},
    "kaleng_minuman": {"category": "Anorganik", "handling": "Bilas, tekan agar ringkas, lalu kumpulkan untuk pengepul logam.", "economic_value": "Kisaran harga umum sekitar Rp 2.000–Rp 6.000 per kg untuk kaleng bekas, tergantung kadar logam dan berat."},
    "kardus": {"category": "Anorganik", "handling": "Keringkan, peras, dan satukan agar lebih ringan saat disetor ke bank sampah atau pengepul kertas.", "economic_value": "Kisaran harga umum sekitar Rp 500–Rp 2.500 per kg, bergantung pada kebersihan, kadar kertas, serta pasar lokal."},
    "kertas": {"category": "Anorganik", "handling": "Pisahkan dari kertas basah atau terkontaminasi, jemur, lalu kumpulkan untuk daur ulang.", "economic_value": "Kisaran harga umum sekitar Rp 800–Rp 3.000 per kg untuk kertas bekas bersih, tergantung jenis kertas dan kualitasnya."},
    "bungkus_plastik_makanan": {"category": "Anorganik", "handling": "Cuci, keringkan, dan pisahkan agar tidak tercampur sampah basah.", "economic_value": "Kisaran harga umum biasanya Rp 500–Rp 2.000 per kg, tetapi bisa lebih rendah jika kondisi plastik kotor, lembab, atau tercampur sampah lain."},
    "cup_plastik": {"category": "Anorganik", "handling": "Bersihkan dari sisa minuman, keringkan, dan pisahkan untuk recycle.", "economic_value": "Kisaran harga umum sekitar Rp 500–Rp 2.500 per kg, tergantung jenis plastik dan kondisi cup yang dikumpulkan."},
    "sisa_makanan": {"category": "Organik", "handling": "Komposkan atau olah jadi pakan ternak bila sesuai, hindari membuang ke tempat sampah umum.", "economic_value": "Umumnya tidak dijual dalam bentuk mentah, tetapi bisa menghasilkan kompos atau biogas yang memberi nilai ekonomis jangka panjang melalui penghematan biaya pembuangan dan pupuk."},
    "buah_sayur": {"category": "Organik", "handling": "Kumpulkan untuk composting atau pengolahan pupuk organik rumah tangga.", "economic_value": "Nilai ekonomi bisa muncul dari kompos atau pupuk cair untuk kebun; jika diolah secara mandiri, manfaatnya bisa setara dengan pengurangan biaya pupuk."},
    "pakaian": {"category": "Anorganik", "handling": "Cuci, sortir layak pakai dan yang rusak, lalu donasikan atau jual ke pengepul tekstil.", "economic_value": "Pakaian layak pakai bisa laku Rp 10.000–Rp 100.000 per koleksi tergantung kondisi, merek, dan pasar; kain rusak bisa dijadikan bahan daur ulang atau serat kain."},
    "sepatu": {"category": "Anorganik", "handling": "Cuci dan pisahkan berdasarkan kondisi, lalu bisa dijual kembali, didonasikan, atau diolah jadi bahan daur ulang.", "economic_value": "Harga jual umumnya bervariasi, mulai dari Rp 20.000 hingga ratusan ribu per pasang tergantung kondisi, merek, dan kelayakan pakai."},
    "battery": {"category": "E-Waste", "handling": "Jangan dibuang sembarangan. Simpan di wadah tertutup dan serahkan ke pengepul limbah B3 atau bank sampah yang menerima baterai.", "economic_value": "Baterai bekas biasanya memiliki nilai ekonomis bila diproses lewat pengelolaan B3 yang aman, meski harga setiap jenis baterai berbeda-beda sesuai material logamnya."},
    "accu": {"category": "E-Waste", "handling": "Pisahkan dan serahkan ke tempat daur ulang aki yang aman agar tidak merusak lingkungan.", "economic_value": "Aki bekas memiliki nilai ekonomis karena mengandung timbal dan logam lain yang bisa didaur ulang secara formal, namun pengelolaannya harus aman dan sesuai aturan."}
}


def build_prompt(
    message: str,
    predicted_class: Optional[str] = None,
    category: Optional[str] = None,
    confidence: Optional[float] = None
) -> str:
    context_lines = []

    if predicted_class:
        context_lines.append(f"Kelas spesifik: {predicted_class}")
    if category:
        context_lines.append(f"Kategori utama: {category}")
    if confidence is not None:
        context_lines.append(f"Confidence: {confidence:.2f}")

    context_text = "\n".join(context_lines) if context_lines else "Tidak ada konteks prediksi gambar."

    return f"""Anda adalah Peri Nirmala, asisten edukasi lingkungan yang ramah, hangat, dan peka terhadap isu sampah serta pengelolaannya.

Konteks prediksi sampah saat ini:
{context_text}

Pesan pengguna:
{message}

PANDUAN RESPONS Anda:
1. TONE & MANNER:
   - Gunakan bahasa Indonesia yang lugas, hangat, dan mudah dipahami
   - Panggil pengguna dengan "Kamu" atau "Anda" secara natural
   - Gunakan emoji yang sesuai agar terasa lebih hidup dan manusiawi 😊♻️💰
   - Hindari terdengar terlalu formal atau robotik

2. JIKA PERTANYAAN RELEVAN (tentang sampah, daur ulang, pengelolaan limbah, dan nilai ekonomis sampah):
   - Berikan jawaban yang jelas, edukatif, dan praktis
   - Jelaskan cara pengolahan atau pengelolaan yang benar
   - Jelaskan apakah sampah tersebut bisa dijual ke pengepul atau bank sampah, serta kisaran nilai ekonomisnya jika ada
   - Jika ada konteks prediksi, gunakan untuk memberi rekomendasi yang spesifik dan bermanfaat
   - Fokus pada pengelolaan sampah secara berkelanjutan, pemisahan sampah, daur ulang, komposting, dan potensi nilai ekonomi

3. JIKA PERTANYAAN DILUAR KONTEKS:
   - Tegur dengan SOPAN dan RAMAH
   - Jelaskan bahwa Peri Nirmala fokus pada edukasi pengelolaan sampah, pengolahan limbah, dan nilai ekonomis sampah
   - Tawarkan topik yang bisa dibantu, seperti: cara memilah sampah, daur ulang, pengolahan kompos, manfaat bank sampah, harga sampah di pengepul, pengelolaan sampah rumah tangga, dan limbah elektronik
   - Akhiri dengan ajakan ramah untuk bertanya topik yang sesuai

4. CONTOH TEGUR SOPAN:
   - "Hmm, sepertinya pertanyaan ini di luar fokus Peri Nirmala ya 😊. Kami fokus pada edukasi pengelolaan sampah, pengolahan limbah, dan nilai ekonomis sampah seperti yang bisa dijual ke pengepul atau bank sampah. Mau tanya mengenai cara memilah sampah atau harga sampah bekas?"
   - "Pertanyaannya menarik, tapi fokus kami lebih ke pengelolaan sampah dan ekonomi sirkular 💚. Kalau kamu mau, kita bisa bahas cara mengolah sampah rumah tangga atau potensi nilai jualnya."

5. JIKA CONFIDENCE PREDIKSI RENDAH:
   - Sarankan pengguna mengunggah foto yang lebih jelas
   - Berikan tips pengambilan gambar sampah agar klasifikasi lebih akurat

6. PRIORITAS KONTEN:
   - Berikan edukasi tentang cara mengolah sampah secara benar
   - Tampilkan potensi nilai ekonomis jika dijual ke pengepul atau bank sampah
   - Jelaskan manfaat dari memilah sampah, mendaur ulang, dan mengurangi sampah yang berakhir di tempat pembuangan

Ingat: Respons harus terasa seperti ngobrol dengan teman yang peduli lingkungan, bukan bot formal.
""".strip()


def chat_with_gemma(
    message: str,
    predicted_class: Optional[str] = None,
    category: Optional[str] = None,
    confidence: Optional[float] = None
) -> str:
    if not OPENROUTER_API_KEY:
        return "⚠️ OPENROUTER_API_KEY belum diset. Silakan setting env variable terlebih dahulu."

    # Generate cache key dari message (untuk pertanyaan yang sama, gunakan cache)
    cache_key = f"{message}_{predicted_class}_{category}".lower()
    if cache_key in _response_cache:
        print(f"Using cached response for: {cache_key}")
        return _response_cache[cache_key]

    prompt = build_prompt(message, predicted_class, category, confidence)

    headers = {
        "Authorization": f"Bearer {OPENROUTER_API_KEY}",
        "Content-Type": "application/json",
        "HTTP-Referer": "http://localhost",
        "X-Title": "WISE API"
    }

    payload = {
        "model": OPENROUTER_MODEL,
        "messages": [
            {
                "role": "system",
                "content": """Kamu adalah Peri Nirmala, asisten edukasi lingkungan yang ramah dan peka terhadap pengelolaan sampah. 
Kamu bicara natural, warm, dan mendorong orang untuk ikut menjaga lingkungan dengan cara yang mudah dipahami. 
Fokus utamamu adalah edukasi tentang pengolahan sampah, cara memilah sampah, manfaat daur ulang, serta nilai ekonomis sampah jika dijual ke pengepul atau bank sampah. 
Gunakan bahasa Indonesia yang santai tapi tetap informatif, dan gunakan emoji secukupnya agar terasa menyenangkan. 💚♻️💰"""
            },
            {
                "role": "user",
                "content": prompt
            }
        ],
        "temperature": 0.7,
        "top_p": 0.9
    }

    # Retry logic untuk handle rate limit
    max_retries = 3
    retry_delay = 2  # detik
    
    for attempt in range(max_retries):
        try:
            response = requests.post(
                OPENROUTER_URL,
                headers=headers,
                json=payload,
                timeout=60
            )
            print("\n" + "=" * 60)
            print("REQUEST KE OPENROUTER")
            print("MODEL :", OPENROUTER_MODEL)
            print("STATUS:", response.status_code)
            print("BODY:")
            print(response.text)
            print("=" * 60 + "\n")

            # Jika success
            if response.status_code == 200:
                data = response.json()
                result = data["choices"][0]["message"]["content"]
                _response_cache[cache_key] = result
                return result

            # Jika rate limited
            elif response.status_code == 429:
                if attempt < max_retries - 1:
                    wait_time = retry_delay * (2 ** attempt)
                    print(f"Rate limited. Retry dalam {wait_time} detik...")
                    time.sleep(wait_time)
                    continue
                else:
                    return "⏱️ Maaf, API sedang sibuk. Coba lagi dalam beberapa saat ya 😊"

            # Error lainnya
            else:
                try:
                    error_detail = response.json().get("error", {}).get("message", "Unknown error")
                except:
                    error_detail = response.text

                return f"❌ Terjadi error: {error_detail}"

        except requests.exceptions.Timeout:
            return "⏱️ Request timeout. Coba lagi ya 😊"

        except requests.exceptions.ConnectionError:
            return "🌐 Koneksi error. Pastikan internet kamu stabil ya 💚"

        except Exception as e:
            print(f"Error: {e}")
            return f"⚠️ Terjadi kesalahan: {e}"

    return "⏱️ Gagal setelah beberapa kali percobaan. Coba lagi nanti 😊"


def build_recommendation_prompt(
    predicted_class: str,
    category: str,
    confidence: float
) -> str:
    """Build prompt untuk menghasilkan rekomendasi pengolahan sampah, harga pasar per kg, dan opsi daur ulang mandiri yang konkret."""
    waste_info = WASTE_CLASS_INFO.get(predicted_class.lower(), {})
    handling = waste_info.get("handling", "Pisahkan dari sampah lain dan olah sesuai jenis sampah.")
    economic_value = waste_info.get("economic_value", "Nilai ekonomis tergantung kualitas, berat, dan permintaan pasar.")
    readable_class = predicted_class.replace('_', ' ').title()

    return f"""Kamu diminta untuk menghasilkan REKOMENDASI PENGELOLAAN SAMPAH yang sangat praktis, lebih panjang, dan benar-benar berguna bagi pengguna.

KONTEKS SAMPAH:
- Jenis Sampah: {readable_class}
- Kategori: {category}
- Cara Pengolahan Umum: {handling}
- Informasi Harga Pasar: {economic_value}

TUGAS UTAMA:
Buat respons yang bisa menjawab 3 kebutuhan pengguna sekaligus:
1. Cara pengolahan sampah yang benar
2. Kisaran harga jual di pasaran atau ke pengepul/bank sampah
3. Opsi daur ulang mandiri jika memungkinkan, lengkap dengan langkah sederhana yang bisa dilakukan sendiri di rumah

PENTING: output harus dibuat dengan format nomor urut yang rapi, bukan paragraf panjang tanpa struktur.

BERIKAN RESPONS DENGAN FORMAT BERIKUT (PERSIS seperti ini):

REKOMENDASI PENGELOLAAN UNTUK SAMPAH {readable_class.upper()}:
1. [Penjelasan langkah pertama pengolahan yang benar dan aman, dibuat lebih detail daripada jawaban singkat]
2. [Penjelasan langkah kedua: pemisahan, pencucian, pengeringan, dan penyimpanan agar nilai ekonomis tetap tinggi]
3. [Penjelasan langkah ketiga: persiapan agar sampah lebih siap dijual atau diolah lebih lanjut]
4. [Penjelasan langkah keempat: jika memungkinkan, uraikan cara daur ulang mandiri yang bisa dilakukan di rumah atau lingkungan sekitar]
5. [Penjelasan langkah kelima: tindakan tambahan seperti kompos, recycle kreatif, pengemasan, atau penyimpanan agar lebih efisien]

KISARAN HARGA PASAR PER 1 KG:
1. [Berikan kisaran harga yang realistis untuk pasar lokal dalam satuan rupiah per 1 kilogram. Contoh: Rp 1.500–Rp 4.000 per kg]
2. [Jelaskan faktor yang memengaruhi harga, seperti kebersihan, berat, warna, kondisi, dan pasar setempat]
3. [Jika harga bisa sangat bervariasi, sebutkan bahwa estimasi bisa naik/turun tergantung volume, kondisi, dan penampungan]

PENGOLAHAN MANDIRI JIKA DIMUNGKINKAN:
1. [Jika bisa diolah sendiri, jelaskan langkah-langkah sederhana dan aman untuk daur ulang mandiri di rumah]
2. [Sebutkan alat yang dibutuhkan, misalnya wadah, air, alat pemotong, atau alat pengering]
3. [Jelaskan manfaat dari proses mandiri, seperti menghemat biaya, menambah nilai tambah, dan mengurangi sampah]
4. [Jika tidak bisa diolah sendiri, berikan alasan singkat dan sebutkan alternatif terbaik seperti bank sampah atau pengepul]

PENUTUP:
[Kalimat motivasi singkat yang mendorong pengguna untuk memilah, mengolah, dan menjual atau mendaur ulang sampah dengan benar]

PANDUAN PENULISAN:
- Gunakan bahasa Indonesia yang natural, ramah, dan praktis
- Tambahkan emoji yang relevan, tapi jangan berlebihan
- Setiap bagian harus berupa daftar bernomor, bukan paragraf panjang tanpa urutan
- Wajib mencantumkan harga dalam satuan rupiah per 1 kilogram, misalnya Rp 1.500–Rp 4.000 per kg
- Wajib menyebutkan opsi daur ulang mandiri jika sampah itu memang bisa diolah sendiri
- Fokus pada pengolahan sampah, nilai ekonomi, dan solusi nyata
- Jangan menulis kalimat yang terlalu umum atau terlalu singkat
- Jangan yang jawabannya berparagraf panjang tanpa nomor urut

JANGAN TAMBAHKAN APAPUN SELAIN FORMAT DI ATAS - tidak ada intro, tidak ada kalimat tambahan di awal atau akhir!""".strip()


def get_formatted_waste_recommendation(
    predicted_class: str,
    category: str,
    confidence: float
) -> dict:
    """
    Menghasilkan rekomendasi pengolahan sampah terformat dengan struktur rapi.
    
    Returns:
        dict dengan keys: intro, recommendations, sdgs, closing, low_confidence_warning
    """
    if not OPENROUTER_API_KEY:
        return {
            "intro": "",
            "recommendations": [],
            "sdgs": [],
            "closing": "⚠️ API key tidak tersedia.",
            "low_confidence_warning": ""
        }
    
    readable_class = predicted_class.replace('_', ' ').title()
    
    # Generate cache key
    cache_key = f"formatted_recommendation_{predicted_class}_{category}".lower()
    if cache_key in _response_cache:
        print(f"Using cached formatted recommendation for: {predicted_class}")
        return _response_cache[cache_key]
    
    prompt = build_recommendation_prompt(predicted_class, category, confidence)
    
    headers = {
        "Authorization": f"Bearer {OPENROUTER_API_KEY}",
        "Content-Type": "application/json",
        "HTTP-Referer": "http://localhost",
        "X-Title": "WISE API"
    }
    
    payload = {
        "model": OPENROUTER_MODEL,
        "messages": [
            {
                "role": "system",
                "content": "Kamu adalah Peri Nirmala, asisten yang ahli dalam memberikan rekomendasi pengelolaan sampah dengan struktur terorganisir, ramah, dan actionable. Selalu ikuti format yang diminta dengan tepat."
            },
            {
                "role": "user",
                "content": prompt
            }
        ],
        "temperature": 0.6,
        "top_p": 0.8
    }
    
    max_retries = 3
    retry_delay = 2
    
    for attempt in range(max_retries):
        try:
            response = requests.post(OPENROUTER_URL, headers=headers, json=payload, timeout=60)
            
            if response.status_code == 200:
                data = response.json()
                raw_response = data["choices"][0]["message"]["content"]
                
                # Parse response ke struktur yang diinginkan
                formatted_result = _parse_recommendation_response(raw_response, readable_class, confidence)
                
                # Cache the response
                _response_cache[cache_key] = formatted_result
                return formatted_result
            
            elif response.status_code == 429:
                if attempt < max_retries - 1:
                    wait_time = retry_delay * (2 ** attempt)
                    print(f"Rate limited. Retry dalam {wait_time} detik...")
                    time.sleep(wait_time)
                    continue
                else:
                    return {
                        "intro": "",
                        "recommendations": [],
                        "sdgs": [],
                        "closing": "⏱️ Server sedang sibuk. Coba lagi dalam beberapa saat ya 😊",
                        "low_confidence_warning": ""
                    }
            
            else:
                try:
                    error_detail = response.json().get('error', {}).get('message', 'Unknown error')
                except:
                    error_detail = response.text
                return {
                    "intro": "",
                    "recommendations": [],
                    "sdgs": [],
                    "closing": f"❌ Error: {error_detail}",
                    "low_confidence_warning": ""
                }
        
        except requests.exceptions.Timeout:
            return {
                "intro": "",
                "recommendations": [],
                "sdgs": [],
                "closing": "⏱️ Request timeout. Coba lagi ya 😊",
                "low_confidence_warning": ""
            }
        except requests.exceptions.ConnectionError:
            return {
                "intro": "",
                "recommendations": [],
                "sdgs": [],
                "closing": "🌐 Koneksi error. Pastikan internet stabil ya 💚",
                "low_confidence_warning": ""
            }
        except Exception as e:
            print(f"Error getting recommendation: {str(e)}")
            return {
                "intro": "",
                "recommendations": [],
                "sdgs": [],
                "closing": f"⚠️ Terjadi kesalahan: {str(e)}",
                "low_confidence_warning": ""
            }
    
    return {
        "intro": "",
        "recommendations": [],
        "sdgs": [],
        "closing": "⏱️ Gagal mengambil rekomendasi. Coba lagi nanti 😊",
        "low_confidence_warning": ""
    }


def _parse_recommendation_response(response_text: str, predicted_class: str, confidence: float) -> dict:
    """
    Parse response dari Gemma dan ekstrak ke struktur yang diinginkan.

    Returns:
        dict dengan: intro, recommendations (list), sdgs (list), closing, low_confidence_warning
    """
    lines = response_text.strip().split('\n')

    recommendations = []
    economic_value = []
    closing = ""
    intro = f"Wah selamat kamu sudah melakukan identifikasi sampah, sampah kamu adalah {predicted_class}! 🎉"

    current_section = None

    for line in lines:
        line = line.strip()
        if not line:
            continue

        upper_line = line.upper()

        if 'REKOMENDASI' in upper_line and 'PENGELOLAAN' in upper_line:
            current_section = 'recommendations'
            continue
        elif 'KISARAN HARGA' in upper_line or 'POTENSI NILAI EKONOMIS' in upper_line:
            current_section = 'economic_value'
            continue
        elif 'PENGOLAHAN MANDIRI' in upper_line:
            current_section = 'recommendations'
            continue
        elif 'PENUTUP' in upper_line:
            current_section = 'closing'
            continue

        if line and (line[0].isdigit() and ('.' in line[:3] or ')' in line[:3])):
            item = line.split('.', 1)[1].strip() if '.' in line else line.split(')', 1)[1].strip()
            if current_section == 'recommendations':
                recommendations.append(item)
            elif current_section == 'economic_value':
                economic_value.append(item)
        elif current_section == 'closing' and line:
            closing += line + " "

    closing = closing.strip()

    low_confidence_warning = ""
    if confidence < 0.8:
        low_confidence_warning = f"⚠️ Confidence prediksi hanya {confidence*100:.1f}%. Untuk hasil yang lebih akurat, silakan upload ulang gambar sampah dengan pencahayaan lebih jelas dan gambaran yang lebih detail. Terima kasih! 😊"

    return {
        "intro": intro,
        "recommendations": recommendations,
        "sdgs": economic_value,
        "closing": closing,
        "low_confidence_warning": low_confidence_warning
    }


def get_waste_recommendation(
    predicted_class: str,
    category: str,
    confidence: float
) -> str:
    """
    Menghasilkan rekomendasi pengolahan sampah spesifik menggunakan Gemma AI (legacy function).
    
    Args:
        predicted_class: Jenis sampah yang terdeteksi (e.g., 'botol_plastik')
        category: Kategori utama (e.g., 'Anorganik')
        confidence: Confidence score dari model (0-1)
    
    Returns:
        String berisi rekomendasi pengolahan dari Gemma
    """
    # Gunakan function baru dan format ke HTML string
    formatted = get_formatted_waste_recommendation(predicted_class, category, confidence)
    
    html = f"""<div class='recommendations-container'>
        <p class='intro-text'>{formatted['intro']}</p>
    """
    
    if formatted['recommendations']:
        html += "<div class='recommendations-section'>"
        html += "<h4>Rekomendasi Pengolahan untuk sampah {0}:</h4>".format(predicted_class.replace('_', ' ').title())
        html += "<ol class='recommendations-list'>"
        for rec in formatted['recommendations']:
            html += f"<li>{rec}</li>"
        html += "</ol></div>"
    
    if formatted['sdgs']:
        html += "<div class='sdgs-section'>"
        html += "<h4>Potensi Nilai Ekonomis:</h4>"
        html += "<ol class='sdgs-list'>"
        for sdg in formatted['sdgs']:
            html += f"<li>{sdg}</li>"
        html += "</ol></div>"
    
    if formatted['closing']:
        html += f"<p class='closing-text'>{formatted['closing']}</p>"
    
    if formatted['low_confidence_warning']:
        html += f"<div class='warning-box'><p>{formatted['low_confidence_warning']}</p></div>"
    
    html += "</div>"
    
    return html




# ============================================================================
# YOUTUBE HARDCODED LINKS - Edit these URLs dengan link YouTube yang benar
# Format: "waste_type": {"title": "Judul Video", "url": "https://youtube.com/..."}
# ============================================================================
YOUTUBE_FALLBACK = {
    "botol_plastik": {"title": "video tutorial pengolahan botol plastik", "url": "https://youtu.be/9LovD6VCa40?si=sJOwy-eed7rcs6Mw"},
    "botol_kaca": {"title": "video tutorial pengolahan botol kaca", "url": "https://youtube.com/shorts/JoI5hzQyRD0?si=4Hoaipmt69wG9eXy"},
    "kaleng_minuman": {"title": "video tutorial pengolahan kaleng minuman]", "url": "https://youtube.com/shorts/AWDSZZt6TZ0?si=IQyxMPw3EcIBdqPS"},
    "kardus": {"title": "video tutorial pengolahan kardus", "url": "https://youtu.be/3b6YMmPIydk?si=INJ9d0kHPoWOwa6t"},
    "kertas": {"title": "video tutorial pengolahan kertas", "url": "https://youtube.com/shorts/olBErEr5eTo?si=smlGzZEbOz0QFMZx"},
    "bungkus_plastik_makanan": {"title": "video tutorial pengolahan bungkus plastik", "url": "https://youtu.be/MJd3bo_XRaU?si=fXVvb58X34DCVIrc"},
    "cup_plastik": {"title": "video tutorial pengolahan cup plastik]", "url": "https://youtube.com/shorts/_zgCSFJTMpo?si=dTJawLnCDGkjrfm7"},
    "sisa_makanan": {"title": "video tutorial pengolahan sisa makanan]", "url": "https://youtu.be/0qfGNQ499JA?si=KbvzZsKepUENvBoS"},
    "buah_sayur": {"title": "video tutorial pengolahan buah sayur]", "url": "https://youtu.be/J8STpSfvkwU?si=sKu1js-NfMVLG05e"},
    "pakaian": {"title": "video tutorial pengolahan pakaian]", "url": "https://youtu.be/q-_sT1AdzPQ?si=mKvHrpL_ko47wp-S"},
    "sepatu": {"title": "video tutorial pengolahan sepatu]", "url": "https://youtu.be/kNflGgtJyLA?si=zJ4go1vvhRAenlP_"},
    "battery": {"title": "[video tutorial pengolahan battery]", "url": "https://youtu.be/8035JvuCKWw?si=dQ5FiNdIKPb5FKQC"},
    "accu": {"title": "video tutorial pengolahanaccu]", "url": "https://www.youtube.com/watch?v=7JWv-nkkggc"}
}


def get_youtube_recommendation(
    predicted_class: str,
    category: str
) -> dict:
    """
    Get YouTube tutorial link untuk sampah tertentu.
    
    SIMPLE VERSION: Hanya ambil dari YOUTUBE_FALLBACK (hardcoded links).
    User dapat mengedit links langsung di YOUTUBE_FALLBACK dictionary.
    
    Args:
        predicted_class: Jenis sampah (e.g., 'botol_plastik')
        category: Kategori sampah (e.g., 'Anorganik')
    
    Returns:
        dict dengan keys: title, url
    """
    
    predicted_class_lower = predicted_class.lower()
    
    # Jika ada di YOUTUBE_FALLBACK, return langsung
    if predicted_class_lower in YOUTUBE_FALLBACK:
        link = YOUTUBE_FALLBACK[predicted_class_lower]
        # Cek apakah user sudah isi atau masih template
        if "[ATUR:" in link.get("url", ""):
            print(f"⚠️ YouTube link untuk '{predicted_class}' belum diatur - masih template")
            return {
                "title": f"Silakan atur tutorial untuk {predicted_class}",
                "url": "#"
            }
        return link
    
    # Jika tidak ada di dictionary
    print(f"⚠️ Waste type '{predicted_class}' tidak ada di YOUTUBE_FALLBACK")
    return {
        "title": "Tutorial tidak tersedia",
        "url": "#"
    }


