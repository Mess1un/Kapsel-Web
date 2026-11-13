@props(['data', 'satuan' => 'konten'])
{{-- Penomoran halaman sesuai desain: "Menampilkan 1–6 dari 6 konten" + Sebelumnya / nomor / Berikutnya --}}
@if ($data->total() > 0)
    <div class="halaman-nomor">
        <span>Menampilkan {{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} {{ $satuan }}</span>
        <div class="tombol-grup">
            @if ($data->onFirstPage())
                <span class="nomor mati">Sebelumnya</span>
            @else
                <a href="{{ $data->previousPageUrl() }}" rel="prev">Sebelumnya</a>
            @endif

            @foreach ($data->getUrlRange(max(1, $data->currentPage() - 2), min($data->lastPage(), $data->currentPage() + 2)) as $nomor => $url)
                @if ($nomor === $data->currentPage())
                    <span class="nomor aktif" aria-current="page">{{ $nomor }}</span>
                @else
                    <a href="{{ $url }}">{{ $nomor }}</a>
                @endif
            @endforeach

            @if ($data->hasMorePages())
                <a href="{{ $data->nextPageUrl() }}" rel="next">Berikutnya</a>
            @else
                <span class="nomor mati">Berikutnya</span>
            @endif
        </div>
    </div>
@endif
