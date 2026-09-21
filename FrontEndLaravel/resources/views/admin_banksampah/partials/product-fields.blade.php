<div>
    <label class="text-sm font-bold text-slate-700">Nama produk</label>
    <input name="name" required value="{{ old('name', $product?->name) }}" class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm">
</div>
<div>
    <label class="text-sm font-bold text-slate-700">Kategori</label>
    <input name="category" value="{{ old('category', $product?->category) }}" class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm">
</div>
<div class="md:col-span-2">
    <label class="text-sm font-bold text-slate-700">Deskripsi</label>
    <textarea name="description" rows="3" class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm">{{ old('description', $product?->description) }}</textarea>
</div>
<div>
    <label class="text-sm font-bold text-slate-700">Harga (Rp)</label>
    <input name="price" type="number" min="0" required value="{{ old('price', $product?->price) }}" class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm">
</div>
<div>
    <label class="text-sm font-bold text-slate-700">Stok</label>
    <input name="stock" type="number" min="0" required value="{{ old('stock', $product?->stock ?? 0) }}" class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm">
</div>
<div>
    <label class="text-sm font-bold text-slate-700">Gambar produk</label>
    <input name="image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" @required(!$product) class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:text-sm file:font-bold file:text-emerald-700">
    <p class="mt-1 text-xs text-slate-500">JPG, PNG, atau WebP. Maksimal 5 MB{{ $product?->image ? '. Kosongkan jika tidak ingin mengganti gambar.' : '.' }}</p>
    @if ($product?->image)
        @php
            $productImage = preg_match('/^https?:\/\//i', $product->image)
                ? $product->image
                : asset('storage/' . $product->image);
        @endphp
        <img src="{{ $productImage }}" alt="{{ $product->name }}" class="mt-3 h-20 w-20 rounded-xl object-cover">
    @endif
</div>
<div>
    <label class="text-sm font-bold text-slate-700">Status</label>
    <select name="status" class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm">
        @foreach (['Tersedia', 'Discontinued'] as $status)
            <option value="{{ $status }}" @selected(old('status', $product?->status ?? 'Tersedia') === $status)>{{ $status }}</option>
        @endforeach
    </select>
</div>
