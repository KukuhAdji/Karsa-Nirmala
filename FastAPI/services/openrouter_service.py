import os
import requests
from typing import Optional

OPENROUTER_API_KEY = os.getenv("OPENROUTER_API_KEY")
OPENROUTER_MODEL = os.getenv("OPENROUTER_MODEL", "google/gemma-2-9b-it:free")
OPENROUTER_URL = "https://openrouter.ai/api/v1/chat/completions"


def build_prompt(message: str, predicted_class: Optional[str], category: Optional[str], confidence: Optional[float]) -> str:
    context = []
    if predicted_class:
        context.append(f"Kelas spesifik: {predicted_class}")
    if category:
        context.append(f"Kategori utama: {category}")
    if confidence is not None:
        context.append(f"Confidence: {confidence:.2f}")

    context_text = "\n".join(context) if context else "Tidak ada konteks prediksi gambar."

    return f"""
Anda adalah Peri Nirmala, asisten edukasi lingkungan yang ramah.

Konteks prediksi:
{context_text}

Pesan pengguna:
{message}

Tugas Anda:
1. Berikan jawaban singkat, jelas, dan edukatif dalam Bahasa Indonesia.
2. Fokus pada pengelolaan sampah dan pengolahan sampah yang benar.
3. Jika ada konteks prediksi, beri rekomendasi praktis seperti cara memilah, mengolah, dan menjual sampah ke pengepul atau bank sampah.
4. Sampaikan informasi nilai ekonomis sampah bila relevan, seperti potensi harga jual dan faktor yang memengaruhi harga.
5. Jangan mengubah hasil klasifikasi.
6. Jika confidence rendah, sarankan pengguna mengunggah gambar yang lebih jelas.
7. Gunakan gaya yang hangat, membantu, dan ramah seperti teman yang peduli lingkungan.
""".strip()


def chat_with_gemma(message: str, predicted_class: Optional[str] = None, category: Optional[str] = None, confidence: Optional[float] = None) -> str:
    if not OPENROUTER_API_KEY:
        return "OPENROUTER_API_KEY belum diset di environment."

    prompt = build_prompt(message, predicted_class, category, confidence)

    headers = {
        "Authorization": f"Bearer {OPENROUTER_API_KEY}",
        "Content-Type": "application/json",
        "HTTP-Referer": "http://localhost",
        "X-Title": "WISE API",
    }

    payload = {
        "model": OPENROUTER_MODEL,
        "messages": [
            {"role": "system", "content": "Anda adalah Peri Nirmala, asisten edukasi lingkungan yang ramah, informatif, dan fokus pada pengolahan sampah serta nilai ekonomis sampah yang bisa dijual ke pengepul atau bank sampah."},
            {"role": "user", "content": prompt}
        ],
        "temperature": 0.4
    }

    response = requests.post(OPENROUTER_URL, headers=headers, json=payload, timeout=60)
    response.raise_for_status()

    data = response.json()
    return data["choices"][0]["message"]["content"]