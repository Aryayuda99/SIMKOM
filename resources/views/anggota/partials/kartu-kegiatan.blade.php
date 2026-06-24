{{-- Halaman Kartu Kegiatan --}}
@php
    $kuota = (int) ($item->kuota_peserta ?? 0);
    $terisi = (int) ($item->jumlah_peserta ?? 0);
    $slotTersisa = max($kuota - $terisi, 0);
    $slotPenuh = $kuota <= 0 || $slotTersisa <= 0;
    $persen = $kuota > 0 ? min(round(($terisi / $kuota) * 100), 100) : 0;
@endphp

<article class="card">
    <div class="split">
        <div class="actions">
            <span class="badge">{{ $label }}</span>

            <span class="badge green">
                {{ ($item->biaya_pendaftaran ?? 0) > 0
                    ? 'Rp '.number_format($item->biaya_pendaftaran,0,',','.')
                    : 'Gratis' }}
            </span>
        </div>

        <span class="badge purple">Sertifikat</span>
    </div>

    <h2 style="margin-top:18px">
        {{ $item->nama_kegiatan }}
    </h2>

    <p class="subtitle">
        {{ $item->deskripsi ?? 'Deskripsi kegiatan' }}
    </p>

    <div class="meta">
        <span>Tanggal: {{ $item->tanggal_pelaksanaan }}</span>
        <span>Lokasi: {{ $item->lokasi ?? '-' }}</span>
        <span>Diselenggarakan oleh {{ $item->nama_organisasi }}</span>
    </div>

    <div style="margin-top:18px">
        <div class="split">
            <span>{{ $terisi }}/{{ $kuota }} peserta</span>
            <span>{{ $slotTersisa }} slot tersisa</span>
        </div>
        <div class="progress" style="margin-top:8px">
            <span style="width:{{ $persen }}%"></span>
        </div>
    </div>

    {{-- Kondisi tampilan berdasarkan data yang tersedia --}}

    @if($slotPenuh)
        <button class="btn" style="width:100%;margin-top:16px" type="button" disabled>Slot Penuh</button>
    @else
        <a
            class="btn primary"
            style="width:100%;margin-top:16px"
            href="/pendaftaran-kegiatan/{{ $item->id_kegiatan }}"
        >
            Daftar Sekarang
        </a>
    @endif
</article>
