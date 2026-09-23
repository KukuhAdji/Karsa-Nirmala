import os
from pathlib import Path

from dotenv import load_dotenv


FASTAPI_DIR = Path(__file__).resolve().parent
ENV_FILE = FASTAPI_DIR.parent / "FrontEndLaravel" / ".env"

if ENV_FILE.exists():
    load_dotenv(ENV_FILE, override=True)

OPENROUTER_API_KEY = os.getenv("OPENROUTER_API_KEY")
OPENROUTER_MODEL = os.getenv(
    "OPENROUTER_MODEL",
    "nvidia/nemotron-3.5-lightning:free",
)
OPENROUTER_URL = "https://openrouter.ai/api/v1/chat/completions"
OPENROUTER_TIMEOUT_SECONDS = float(os.getenv("OPENROUTER_TIMEOUT_SECONDS", "120"))


def openrouter_headers() -> dict[str, str]:
    return {
        "Authorization": f"Bearer {OPENROUTER_API_KEY}",
        "Content-Type": "application/json",
        "HTTP-Referer": os.getenv("APP_URL", "http://localhost"),
        "X-Title": "WISE API",
    }
