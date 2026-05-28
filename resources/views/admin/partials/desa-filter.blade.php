<form method="GET" class="flex items-center gap-2">
    @foreach(request()->except('desa_id', 'page') as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <select name="desa_id" class="input-field !w-auto">
        <option value="">Semua Desa</option>
        @foreach($desas as $desa)
            <option value="{{ $desa->id }}" {{ ($desaId ?? '') == $desa->id ? 'selected' : '' }}>{{ $desa->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-primary text-sm">Filter</button>
    @if($desaId ?? false)
        <a href="{{ url()->current() }}?{{ http_build_query(request()->except('desa_id', 'page')) }}" class="btn-white text-sm">Reset</a>
    @endif
</form>
