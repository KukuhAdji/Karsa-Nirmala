@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header Section --}}
    <div>
        <h1 class="text-3xl font-black text-slate-900">Riwayat Scan</h1>
        <p class="mt-2 text-slate-500">Lihat semua hasil klasifikasi sampah yang telah Anda scan</p>
    </div>

    {{-- History Content --}}
    @if($histories->count())

        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach($histories as $history)
                <div class="group relative overflow-hidden rounded-[24px] border border-slate-200/80 bg-white/90 shadow-sm transition-all duration-300 hover:shadow-lg hover:border-lime-300/50 backdrop-blur-sm">
                    
                    {{-- Image Container --}}
                    <div class="relative h-40 overflow-hidden bg-slate-100">
                        @php
                            $storagePath = storage_path('app/public/' . ($history->image ?? ''));
                            if ($history->image && file_exists($storagePath)) {
                                $imgUrl = asset('storage/' . $history->image);
                            } else {
                                $imgUrl = asset('images/placeholder.png');
                            }
                        @endphp
                        <img 
                            src="{{ $imgUrl }}" 
                            alt="Scan Image" 
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110" />
                        
                        {{-- Confidence Badge --}}
                        <div class="absolute right-2 top-2">
                            <span class="inline-flex items-center rounded-full bg-gradient-to-r from-lime-400 to-green-500 px-2.5 py-1 text-xs font-bold text-white shadow-md">
                                {{ number_format($history->confidence, 0) }}%
                            </span>
                        </div>
                    </div>

                    {{-- Content Container --}}
                    <div class="space-y-3 p-5">
                        
                        {{-- Category --}}
                        <div>
                            <span class="inline-flex items-center rounded-full bg-lime-50 px-2.5 py-0.5 text-xs font-bold text-lime-700 border border-lime-200/50">
                                {{ ucfirst($history->category) }}
                            </span>
                        </div>

                        {{-- Date --}}
                        <p class="text-xs text-slate-500">
                            {{ $history->created_at->format('d M Y, H:i') }}
                        </p>

                        {{-- Recommendation Preview --}}
                        <p class="line-clamp-2 text-sm leading-5 text-slate-700">
                            {{ $history->recommendation }}
                        </p>

                        {{-- View Button --}}
                        <button 
                            type="button"
                            class="mt-2 w-full rounded-[12px] bg-lime-50 py-2 text-xs font-bold text-lime-700 transition hover:bg-lime-100 border border-lime-200/50">
                            Lihat Detail
                        </button>

                    </div>

                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($histories->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $histories->links() }}
            </div>
        @endif

    @else

        {{-- Empty State --}}
        <div class="rounded-[24px] border border-slate-200/80 bg-slate-50/80 p-12 text-center">
            
            <div class="mx-auto mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="4" y="5" width="16" height="15" rx="2"/>
                    <path d="M9 5V3h6v2"/>
                    <path d="M9 10h6"/>
                    <path d="M12 10v6"/>
                </svg>
            </div>

            <h3 class="text-lg font-black text-slate-900">
                Belum ada scan
            </h3>
            
            <p class="mt-2 text-sm text-slate-600">
                Mulai scan sampah Anda untuk melihat history di sini
            </p>

            <a 
                href="{{ route('scanner') }}" 
                class="mt-5 inline-flex items-center gap-2 rounded-[14px] bg-gradient-to-r from-lime-500 to-green-600 px-5 py-2.5 text-sm font-bold text-white shadow-md transition hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg>
                Mulai Scanner
            </a>

        </div>

    @endif

</div>

@endsection