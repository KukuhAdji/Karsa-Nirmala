@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Admin Bank Sampah</p>
            <h1 class="mt-1 text-3xl font-black text-slate-900">Kelola Bank Sampah</h1>
            <p class="mt-2 text-sm text-slate-500">
                Kamu hanya dapat mengubah data {{ $bankSampah->name }} yang terhubung dengan akunmu.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-bold">Periksa kembali data yang diisi:</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.bank-sampah.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <h2 class="text-xl font-black text-slate-900">Informasi Bank Sampah</h2>
                <label for="name" class="mt-5 block text-sm font-bold text-slate-700">Nama bank sampah</label>
                <input id="name" name="name" type="text" required value="{{ old('name', $bankSampah->name) }}"
                    class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </section>

            <section class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div>
                    <h2 class="text-xl font-black text-slate-900">Lokasi Bank Sampah</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Perbarui koordinat apabila bank sampah berpindah lokasi.
                    </p>
                </div>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="latitude" class="text-sm font-bold text-slate-700">Latitude</label>
                        <input
                            id="latitude"
                            name="latitude"
                            type="number"
                            step="0.0000001"
                            min="-90"
                            max="90"
                            required
                            value="{{ old('latitude', $bankSampah->latitude) }}"
                            class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <p class="mt-1 text-xs text-slate-500">Rentang: -90 sampai 90.</p>
                    </div>

                    <div>
                        <label for="longitude" class="text-sm font-bold text-slate-700">Longitude</label>
                        <input
                            id="longitude"
                            name="longitude"
                            type="number"
                            step="0.0000001"
                            min="-180"
                            max="180"
                            required
                            value="{{ old('longitude', $bankSampah->longitude) }}"
                            class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <p class="mt-1 text-xs text-slate-500">Rentang: -180 sampai 180.</p>
                    </div>
                </div>
            </section>

            <section class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Jam Operasional</h2>
                        <p class="mt-1 text-sm text-slate-500">Atur satu rentang jam buka dan tutup untuk setiap hari.</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">Data milik sendiri</span>
                </div>

                <div class="mt-6 space-y-3">
                    @foreach ($days as $day)
                        @php
                            $dayHours = $hours->get($day, collect());
                            $firstHour = $dayHours->first();
                            $closed = (bool) data_get($firstHour, 'is_closed', false);
                            $is24Hours = (bool) data_get($firstHour, 'is_24_hours', false);
                            $isUnknown = (bool) data_get($firstHour, 'is_unknown', false);
                            $openTime = data_get($firstHour, 'open_time');
                            $closeTime = data_get($firstHour, 'close_time');
                        @endphp
                        <div class="grid gap-3 rounded-2xl bg-slate-50 p-4 md:grid-cols-[1fr_1fr_1fr_auto] md:items-end">
                            <div>
                                <p class="text-sm font-black capitalize text-slate-800">{{ $day }}</p>
                                @if ($dayHours->count() > 1)
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $dayHours->map(fn ($item) => substr($item->open_time, 0, 5).'–'.substr($item->close_time, 0, 5))->join(', ') }}
                                    </p>
                                @elseif ($is24Hours)
                                    <p class="mt-1 text-xs font-bold text-emerald-600">Buka 24 jam</p>
                                @elseif ($isUnknown)
                                    <p class="mt-1 text-xs text-slate-500">Jam belum diketahui</p>
                                @endif
                            </div>
                            <div>
                                <label for="open-{{ $day }}" class="text-xs font-bold text-slate-500">Buka</label>
                                <input id="open-{{ $day }}" name="hours[{{ $day }}][open_time]" type="time"
                                    value="{{ old("hours.$day.open_time", $openTime ? substr($openTime, 0, 5) : '') }}"
                                    @disabled($closed || $is24Hours) class="mt-1 w-full rounded-xl border-slate-200 text-sm disabled:bg-slate-100">
                            </div>
                            <div>
                                <label for="close-{{ $day }}" class="text-xs font-bold text-slate-500">Tutup</label>
                                <input id="close-{{ $day }}" name="hours[{{ $day }}][close_time]" type="time"
                                    value="{{ old("hours.$day.close_time", $closeTime ? substr($closeTime, 0, 5) : '') }}"
                                    @disabled($closed || $is24Hours) class="mt-1 w-full rounded-xl border-slate-200 text-sm disabled:bg-slate-100">
                            </div>
                            <label class="flex items-center gap-2 text-sm font-bold text-slate-600">
                                <input name="hours[{{ $day }}][is_closed]" type="checkbox" value="1" @checked($closed)
                                    class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                    onchange="toggleDay('{{ $day }}', this.checked)">
                                Tutup
                            </label>
                        </div>
                    @endforeach
                </div>
            </section>

            <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-emerald-500 to-lime-500 px-5 py-4 text-sm font-black text-white shadow-lg shadow-emerald-500/20 transition hover:scale-[1.01]">
                Simpan Perubahan
            </button>
        </form>
    </div>

    <script>
        function toggleDay(day, isClosed) {
            document.getElementById(`open-${day}`).disabled = isClosed;
            document.getElementById(`close-${day}`).disabled = isClosed;
        }
    </script>
@endsection