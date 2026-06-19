<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    private function ringkasanKeuanganOrganisasi($idOrganisasi)
    {
        $totalPemasukan = DB::table('keuangan')
            ->join(
                'kegiatan',
                'keuangan.id_kegiatan',
                '=',
                'kegiatan.id_kegiatan'
            )
            ->where(
                'kegiatan.id_organisasi',
                $idOrganisasi
            )
            ->where(
                'keuangan.jenis_transaksi',
                'pemasukan'
            )
            ->sum('keuangan.jumlah');

        $totalPengeluaran = DB::table('keuangan')
            ->join(
                'kegiatan',
                'keuangan.id_kegiatan',
                '=',
                'kegiatan.id_kegiatan'
            )
            ->where(
                'kegiatan.id_organisasi',
                $idOrganisasi
            )
            ->where(
                'keuangan.jenis_transaksi',
                'pengeluaran'
            )
            ->sum('keuangan.jumlah');

        return [
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $totalPemasukan - $totalPengeluaran,
        ];
    }

    public function dashboard()
{
    $pengurus = DB::table('pengurus')
        ->join(
            'data_organisasi',
            'pengurus.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        ->where(
            'pengurus.id_user',
            session('id_user')
        )
        ->first();

    $kegiatanAktif = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->orderBy(
            'tanggal_pelaksanaan',
            'asc'
        )
        ->get();

    $ringkasanKeuangan = $this->ringkasanKeuanganOrganisasi(
        $pengurus->id_organisasi
    );

    return view(
        'pengurus.dashboard',
        array_merge(
            compact(
            'pengurus',
            'kegiatanAktif'
            ),
            $ringkasanKeuangan
        )
    );
}

public function profilOrganisasi()
{
    $organisasi = DB::table('pengurus')
        ->join(
            'data_organisasi',
            'pengurus.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        ->where(
            'pengurus.id_user',
            session('id_user')
        )
        ->select('data_organisasi.*')
        ->first();

    return view(
        'pengurus.profil-organisasi',
        compact('organisasi')
    );
}

public function formEditProfilOrganisasi()
{
    $organisasi = DB::table('pengurus')
        ->join(
            'data_organisasi',
            'pengurus.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        ->where(
            'pengurus.id_user',
            session('id_user')
        )
        ->select('data_organisasi.*')
        ->first();

    return view(
        'pengurus.edit-profil-organisasi',
        compact('organisasi')
    );
}

public function updateProfilOrganisasi(Request $request)
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    DB::table('data_organisasi')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->update([
            'nama_organisasi' => $request->nama_organisasi,
            'periode_kepengurusan' => $request->periode_kepengurusan,
        ]);

    return redirect('/profil-organisasi')
        ->with(
            'success',
            'Profil organisasi berhasil diperbarui'
        );
}

public function manajemenAnggota()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $pendaftaran = DB::table(
        'pendaftaran_anggota_online'
    )
    ->where(
        'id_organisasi',
        $pengurus->id_organisasi
    )
    ->get();

    $anggota = DB::table('anggota')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->select(
            'id_anggota',
            'id_user',
            'id_organisasi',
            'nim',
            'nama',
            'no_hp',
            'program_studi',
            'status_keanggotaan'
        )
        ->get();

    return view(
        'pengurus.manajemen-anggota',
        compact(
            'pendaftaran',
            'anggota'
        )
    );
}

public function terimaAnggota($id)
{
    $pendaftaran = DB::table(
        'pendaftaran_anggota_online'
    )
    ->where(
        'id_pendaftaranA',
        $id
    )
    ->first();

    $idAnggota =
        $pendaftaran->id_organisasi .
        $pendaftaran->id_user;

    DB::table('anggota')
    ->insert([

        'id_anggota' => $idAnggota,

        'id_user' => $pendaftaran->id_user,

        'id_organisasi' => $pendaftaran->id_organisasi,

        'nim' => $pendaftaran->nim,

        'nama' => $pendaftaran->nama,

        'no_hp' => $pendaftaran->no_hp,

        'program_studi' => $pendaftaran->program_studi,

        'status_keanggotaan' => 'aktif'

    ]);

    DB::table('users')
    ->where(
        'id_user',
        $pendaftaran->id_user
    )
    ->update([

        'role' => 'anggota'

    ]);

    DB::table(
        'pendaftaran_anggota_online'
    )
    ->where(
        'id_pendaftaranA',
        $id
    )
    ->delete();

    return redirect(
        '/manajemen-anggota'
    );
}

public function tolakAnggota($id)
{
    DB::table(
        'pendaftaran_anggota_online'
    )
    ->where(
        'id_pendaftaranA',
        $id
    )
    ->delete();

    return redirect(
        '/manajemen-anggota'
    );
}

public function nonaktifkanAnggota($id)
{
    $anggota = DB::table('anggota')
        ->where(
            'id_anggota',
            $id
        )
        ->first();

    DB::table('anggota')
        ->where(
            'id_anggota',
            $id
        )
        ->update([
            'status_keanggotaan' => 'nonaktif'
        ]);

    DB::table('users')
        ->where(
            'id_user',
            $anggota->id_user
        )
        ->update([
            'role' => 'mahasiswa'
        ]);

    return redirect(
        '/manajemen-anggota'
    )->with(
        'success',
        'Anggota berhasil dinonaktifkan'
    );
}

public function aktifkanAnggota($id)
{
    $anggota = DB::table('anggota')
        ->where(
            'id_anggota',
            $id
        )
        ->first();

    DB::table('anggota')
        ->where(
            'id_anggota',
            $id
        )
        ->update([
            'status_keanggotaan' => 'aktif'
        ]);

    DB::table('users')
        ->where(
            'id_user',
            $anggota->id_user
        )
        ->update([
            'role' => 'anggota'
        ]);

    return redirect(
        '/manajemen-anggota'
    )->with(
        'success',
        'Anggota berhasil diaktifkan'
    );
}

public function manajemenKegiatan()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    return view(
        'pengurus.manajemen-kegiatan',
        compact('kegiatan')
    );
}

public function detailKegiatan($id)
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $kegiatan = DB::table('kegiatan')
        ->join(
            'data_organisasi',
            'kegiatan.id_organisasi',
            '=',
            'data_organisasi.id_organisasi'
        )
        ->where(
            'kegiatan.id_kegiatan',
            $id
        )
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        )
        ->select(
            'kegiatan.*',
            'data_organisasi.nama_organisasi'
        )
        ->first();

    if (!$kegiatan) {
        abort(404);
    }

    $pendaftar = DB::table('pendaftaran_kegiatan')
        ->where(
            'id_kegiatan',
            $id
        )
        ->get();

    return view(
        'pengurus.detail-kegiatan',
        compact(
            'kegiatan',
            'pendaftar'
        )
    );
}

public function hapusPesertaKegiatan($id)
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $pendaftaran = DB::table('pendaftaran_kegiatan')
        ->join(
            'kegiatan',
            'pendaftaran_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->where(
            'pendaftaran_kegiatan.id_pendaftaran',
            $id
        )
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        )
        ->select(
            'pendaftaran_kegiatan.id_kegiatan'
        )
        ->first();

    if (!$pendaftaran) {
        abort(404);
    }

    DB::table('pendaftaran_kegiatan')
        ->where(
            'id_pendaftaran',
            $id
        )
        ->delete();

    return redirect(
        '/detail-kegiatan/' . $pendaftaran->id_kegiatan
    )->with(
        'success',
        'Peserta berhasil dihapus'
    );
}

public function formEditKegiatan($id)
{
    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_kegiatan',
            $id
        )
        ->first();

    return view(
        'pengurus.edit-kegiatan',
        compact('kegiatan')
    );
}

public function updateKegiatan(Request $request)
{
    DB::table('kegiatan')
        ->where(
            'id_kegiatan',
            $request->id_kegiatan
        )
        ->update([

            'tanggal_pelaksanaan'
                => $request->tanggal_pelaksanaan,

            'lokasi'
                => $request->lokasi,

            'kuota_peserta'
                => $request->kuota_peserta,

            'biaya_pendaftaran'
                => $request->biaya_pendaftaran

        ]);

    return redirect(
        '/manajemen-kegiatan'
    )->with(
        'success',
        'Kegiatan berhasil diperbarui'
    );
}

public function selesaikanKegiatan($id)
{
    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_kegiatan',
            $id
        )
        ->first();

    $jumlahRiwayat = DB::table(
        'riwayat_kegiatan'
    )->count();

    $idRiwayat =
        'R' .
        str_pad(
            $jumlahRiwayat + 1,
            2,
            '0',
            STR_PAD_LEFT
        );

    $jumlahPeserta = DB::table(
        'pendaftaran_kegiatan'
    )
    ->where(
        'id_kegiatan',
        $id
    )
    ->count();

    DB::table('riwayat_kegiatan')
        ->insert([

            'id_riwayat'
                => $idRiwayat,

            'id_kegiatan'
                => $id,

            'jumlah_peserta'
                => $jumlahPeserta . ' orang',

            'tanggal_selesai'
                => now(),

            'evaluasi'
                => '-',

            'status'
                => 'Selesai'

        ]);

    DB::table('pendaftaran_kegiatan')
        ->where(
            'id_kegiatan',
            $id
        )
        ->delete();

    DB::table('kegiatan')
        ->where(
            'id_kegiatan',
            $id
        )
        ->update([
            'tanggal_pelaksanaan' => '1000-01-01',
            'lokasi' => null,
            'kuota_peserta' => null,
        ]);

    return redirect(
        '/riwayat-kegiatan'
    )->with(
        'success',
        'Kegiatan berhasil diselesaikan'
    );
}


public function riwayatKegiatan()
{
    $riwayat = DB::table('riwayat_kegiatan')
        ->join(
            'kegiatan',
            'riwayat_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->select(
            'riwayat_kegiatan.*',
            'kegiatan.nama_kegiatan',
            'kegiatan.deskripsi',
            'kegiatan.biaya_pendaftaran'
        )
        ->get();

    return view(
        'pengurus.riwayat-kegiatan',
        compact('riwayat')
    );
}

public function keuangan()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    $transaksi = DB::table('keuangan')
        ->join(
            'kegiatan',
            'keuangan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        )
        ->select(
            'keuangan.*',
            'kegiatan.nama_kegiatan'
        )
        ->orderBy(
            'tanggal_transaksi',
            'desc'
        )
        ->get();

    $ringkasanKeuangan = $this->ringkasanKeuanganOrganisasi(
        $pengurus->id_organisasi
    );

    return view(
    'pengurus.keuangan',
    array_merge(
        compact(
            'kegiatan',
            'transaksi'
        ),
        $ringkasanKeuangan
    )
);
}

public function tambahTransaksi(Request $request)
{
    $jumlah = DB::table('keuangan')
        ->count();

    $idBaru =
        'TR' .
        str_pad(
            $jumlah + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

    DB::table('keuangan')
        ->insert([

            'id_transaksi' => $idBaru,

            'id_kegiatan' => $request->id_kegiatan,

            'jenis_transaksi'
                => $request->jenis_transaksi,

            'jumlah'
                => $request->jumlah,

            'tanggal_transaksi'
                => now(),

            'keterangan'
                => $request->keterangan

        ]);

    return redirect(
        '/keuangan'
    )->with(
        'success',
        'Transaksi berhasil ditambahkan'
    );
}

public function hapusTransaksi($id)
{
    DB::table('keuangan')
        ->where('id_transaksi', $id)
        ->delete();

    return redirect('/keuangan')
        ->with(
            'success',
            'Transaksi berhasil dihapus'
        );
}

public function editTransaksi($id)
{
    $transaksi = DB::table('keuangan')
        ->where(
            'id_transaksi',
            $id
        )
        ->first();

    $kegiatan = DB::table('kegiatan')
        ->get();

    return view(
        'pengurus.edit-transaksi',
        compact(
            'transaksi',
            'kegiatan'
        )
    );
}

public function updateTransaksi(Request $request, $id)
{
    DB::table('keuangan')
        ->where(
            'id_transaksi',
            $id
        )
        ->update([

            'id_kegiatan'
                => $request->id_kegiatan,

            'jenis_transaksi'
                => $request->jenis_transaksi,

            'jumlah'
                => $request->jumlah,

            'keterangan'
                => $request->keterangan

        ]);

    return redirect('/keuangan')
        ->with(
            'success',
            'Transaksi berhasil diperbarui'
        );
}

public function proposalLpj()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    $dokumen = DB::table('dokumen_kegiatan')
        ->join(
            'kegiatan',
            'dokumen_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->select(
            'dokumen_kegiatan.*',
            'kegiatan.nama_kegiatan'
        )
        ->get();

    return view(
        'pengurus.proposal-lpj',
        compact(
            'kegiatan',
            'dokumen'
        )
    );
}

public function uploadDokumen(Request $request)
{

if (in_array($request->jenis, ['Proposal', 'LPJ'])) {

        $request->validate([
            'file_dokumen' => 'required|mimes:pdf,doc,docx|max:5120'
        ], [
            'file_dokumen.mimes' => 'Proposal dan LPJ hanya boleh PDF atau DOCX.'
        ]);

    } elseif ($request->jenis == 'Dokumentasi') {

        $request->validate([
            'file_dokumen' => 'required|mimes:jpg,jpeg,png,zip|max:5120'
        ], [
            'file_dokumen.mimes' => 'Dokumentasi hanya boleh JPG, PNG, atau ZIP.'
        ]);

    }

    $file = $request->file('file_dokumen');

    $namaFile = time() . '_' . $file->getClientOriginalName();

    $file->move(
        public_path('uploads'),
        $namaFile
    );

    $jumlah = DB::table(
        'dokumen_kegiatan'
    )->count();

    $idBaru =
        'D' .
        str_pad(
            $jumlah + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

    DB::table('dokumen_kegiatan')
        ->insert([

            'id_dokumen' => $idBaru,

            'id_kegiatan'
                => $request->id_kegiatan,

            'nama_dokumen'
                => $request->nama_dokumen,

            'jenis'
                => $request->jenis,

            'deskripsi'
                => $request->deskripsi,

            'tanggal_upload'
                => now(),

            'file_dokumen'
                => $namaFile

        ]);

    return redirect(
        '/proposal-lpj'
    );
}

public function hapusDokumen($id)
{
    $dokumen = DB::table('dokumen_kegiatan')
        ->where(
            'id_dokumen',
            $id
        )
        ->first();

    if ($dokumen) {

        $path = public_path(
            'uploads/' .
            $dokumen->file_dokumen
        );

        if (file_exists($path)) {

            unlink($path);

        }

        DB::table('dokumen_kegiatan')
            ->where(
                'id_dokumen',
                $id
            )
            ->delete();
    }

    return redirect(
        '/proposal-lpj'
    )->with(
        'success',
        'Dokumen berhasil dihapus'
    );
}

public function eksporLaporan()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    $anggota = DB::table('anggota')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    $kegiatan = DB::table('kegiatan')
        ->where(
            'id_organisasi',
            $pengurus->id_organisasi
        )
        ->get();

    $keuangan = DB::table('keuangan')
        ->join(
            'kegiatan',
            'keuangan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->where(
            'kegiatan.id_organisasi',
            $pengurus->id_organisasi
        )
        ->select(
            'keuangan.*',
            'kegiatan.nama_kegiatan'
        )
        ->get();

    return view(
        'pengurus.ekspor-laporan',
        compact(
            'anggota',
            'kegiatan',
            'keuangan'
        )
    );
}

private function idOrganisasiPengurus()
{
    $pengurus = DB::table('pengurus')
        ->where(
            'id_user',
            session('id_user')
        )
        ->first();

    return $pengurus->id_organisasi;
}

private function labelPeriode($periode)
{
    return $periode === 'tahun'
        ? 'Tahun Ini'
        : 'Bulan Ini';
}

private function terapkanPeriode($query, $kolomTanggal, $periode)
{
    if ($periode === 'tahun') {
        return $query->whereYear(
            $kolomTanggal,
            now()->year
        );
    }

    return $query
        ->whereYear(
            $kolomTanggal,
            now()->year
        )
        ->whereMonth(
            $kolomTanggal,
            now()->month
        );
}

private function dataLaporanKegiatan($periode)
{
    $query = DB::table('riwayat_kegiatan')
        ->join(
            'kegiatan',
            'riwayat_kegiatan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->where(
            'kegiatan.id_organisasi',
            $this->idOrganisasiPengurus()
        )
        ->select(
            'riwayat_kegiatan.*',
            'kegiatan.nama_kegiatan',
            'kegiatan.deskripsi',
            'kegiatan.biaya_pendaftaran'
        );

    return $this->terapkanPeriode(
        $query,
        'riwayat_kegiatan.tanggal_selesai',
        $periode
    )
    ->orderBy(
        'riwayat_kegiatan.tanggal_selesai',
        'desc'
    )
    ->get();
}

private function dataLaporanKeuangan($periode)
{
    $query = DB::table('keuangan')
        ->join(
            'kegiatan',
            'keuangan.id_kegiatan',
            '=',
            'kegiatan.id_kegiatan'
        )
        ->where(
            'kegiatan.id_organisasi',
            $this->idOrganisasiPengurus()
        )
        ->select(
            'keuangan.*',
            'kegiatan.nama_kegiatan'
        );

    return $this->terapkanPeriode(
        $query,
        'keuangan.tanggal_transaksi',
        $periode
    )
    ->orderBy(
        'keuangan.tanggal_transaksi',
        'desc'
    )
    ->get();
}

private function escapePdfText($text)
{
    return str_replace(
        ['\\', '(', ')', "\r", "\n"],
        ['\\\\', '\(', '\)', ' ', ' '],
        (string) $text
    );
}

private function buatPdf($baris)
{
    $halaman = array_chunk(
        $baris,
        46
    );

    $objects = [];
    $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
    $objects[3] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';

    $kids = [];

    foreach ($halaman as $index => $isiHalaman) {
        $pageObject = 4 + ($index * 2);
        $contentObject = $pageObject + 1;
        $kids[] = $pageObject . ' 0 R';

        $content = "BT\n/F1 10 Tf\n50 800 Td\n14 TL\n";

        foreach ($isiHalaman as $line) {
            $content .= '(' . $this->escapePdfText($line) . ") Tj\nT*\n";
        }

        $content .= "ET";

        $objects[$pageObject] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 3 0 R >> >> /Contents ' . $contentObject . ' 0 R >>';
        $objects[$contentObject] = "<< /Length " . strlen($content) . " >>\nstream\n" . $content . "\nendstream";
    }

    $objects[2] = '<< /Type /Pages /Kids [' . implode(' ', $kids) . '] /Count ' . count($halaman) . ' >>';
    ksort($objects);

    $pdf = "%PDF-1.4\n";
    $offsets = [0];

    foreach ($objects as $number => $object) {
        $offsets[$number] = strlen($pdf);
        $pdf .= $number . " 0 obj\n" . $object . "\nendobj\n";
    }

    $xrefPosition = strlen($pdf);
    $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
    $pdf .= "0000000000 65535 f \n";

    for ($i = 1; $i <= count($objects); $i++) {
        $pdf .= str_pad($offsets[$i], 10, '0', STR_PAD_LEFT) . " 00000 n \n";
    }

    $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
    $pdf .= "startxref\n" . $xrefPosition . "\n%%EOF";

    return $pdf;
}

private function downloadPdf($judul, $periode, $header, $rows, $filename)
{
    $lines = [
        $judul,
        'Periode: ' . $this->labelPeriode($periode),
        'Tanggal Export: ' . now()->format('Y-m-d H:i'),
        '',
        implode(' | ', $header),
        str_repeat('-', 110),
    ];

    foreach ($rows as $row) {
        $line = implode(' | ', $row);

        foreach (str_split($line, 110) as $chunk) {
            $lines[] = $chunk;
        }
    }

    return response(
        $this->buatPdf($lines),
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]
    );
}

private function downloadExcel($judul, $periode, $header, $rows, $filename)
{
    $html = '<html><head><meta charset="UTF-8"></head><body>';
    $html .= '<h2>' . e($judul) . '</h2>';
    $html .= '<p>Periode: ' . e($this->labelPeriode($periode)) . '</p>';
    $html .= '<table border="1"><thead><tr>';

    foreach ($header as $item) {
        $html .= '<th>' . e($item) . '</th>';
    }

    $html .= '</tr></thead><tbody>';

    foreach ($rows as $row) {
        $html .= '<tr>';

        foreach ($row as $cell) {
            $html .= '<td>' . e($cell) . '</td>';
        }

        $html .= '</tr>';
    }

    $html .= '</tbody></table></body></html>';

    return response(
        $html,
        200,
        [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]
    );
}

private function rowsKegiatan($kegiatan)
{
    return $kegiatan->map(function ($item) {
        return [
            $item->nama_kegiatan,
            $item->tanggal_selesai,
            $item->jumlah_peserta ?? '-',
            $item->status ?? '-',
            $item->evaluasi && $item->evaluasi !== '-' ? $item->evaluasi : 'Belum diisi',
            'Rp ' . number_format($item->biaya_pendaftaran ?? 0, 0, ',', '.'),
        ];
    })->toArray();
}

private function rowsKeuangan($keuangan)
{
    return $keuangan->map(function ($item) {
        return [
            $item->tanggal_transaksi,
            $item->nama_kegiatan,
            ucfirst($item->jenis_transaksi),
            'Rp ' . number_format($item->jumlah ?? 0, 0, ',', '.'),
            $item->keterangan ?? '-',
        ];
    })->toArray();
}

public function exportKegiatanPdf(Request $request)
{
    $periode = $request->get('periode', 'bulan');
    $kegiatan = $this->dataLaporanKegiatan($periode);

    return $this->downloadPdf(
        'Laporan Kegiatan',
        $periode,
        ['Nama Kegiatan', 'Tanggal Selesai', 'Peserta', 'Status', 'Evaluasi', 'Biaya'],
        $this->rowsKegiatan($kegiatan),
        'laporan-kegiatan.pdf'
    );
}

public function exportKegiatanExcel(Request $request)
{
    $periode = $request->get('periode', 'bulan');
    $kegiatan = $this->dataLaporanKegiatan($periode);

    return $this->downloadExcel(
        'Laporan Kegiatan',
        $periode,
        ['Nama Kegiatan', 'Tanggal Selesai', 'Peserta', 'Status', 'Evaluasi', 'Biaya'],
        $this->rowsKegiatan($kegiatan),
        'laporan-kegiatan.xls'
    );
}

public function exportKeuanganPdf(Request $request)
{
    $periode = $request->get('periode', 'bulan');
    $keuangan = $this->dataLaporanKeuangan($periode);

    return $this->downloadPdf(
        'Laporan Keuangan',
        $periode,
        ['Tanggal', 'Kegiatan', 'Tipe', 'Nominal', 'Keterangan'],
        $this->rowsKeuangan($keuangan),
        'laporan-keuangan.pdf'
    );
}

public function exportKeuanganExcel(Request $request)
{
    $periode = $request->get('periode', 'bulan');
    $keuangan = $this->dataLaporanKeuangan($periode);

    return $this->downloadExcel(
        'Laporan Keuangan',
        $periode,
        ['Tanggal', 'Kegiatan', 'Tipe', 'Nominal', 'Keterangan'],
        $this->rowsKeuangan($keuangan),
        'laporan-keuangan.xls'
    );
}
}
