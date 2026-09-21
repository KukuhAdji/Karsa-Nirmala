from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from config import OPENROUTER_API_KEY, OPENROUTER_MODEL, OPENROUTER_TIMEOUT_SECONDS

from routers.predict_router import router as predict_router
from routers.chat_router import router as chat_router

app = FastAPI()

# Add CORS middleware
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Bisa di-restrict ke ["http://localhost:8000"] saja untuk production
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

app.include_router(predict_router)
app.include_router(chat_router)

@app.get('/')
def root():
    return {
        'message': 'WISE API Running',
        'endpoints': ['/predict', '/chat']
    }

@app.get('/health')
def health():
    return {
        'status': 'healthy',
        'predict_route': '/predict',
        'chat_route': '/chat',
        'openrouter': {
            'configured': bool(OPENROUTER_API_KEY),
            'model': OPENROUTER_MODEL,
            'timeout_seconds': OPENROUTER_TIMEOUT_SECONDS,
        }
    }
