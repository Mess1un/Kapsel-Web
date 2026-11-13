<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\InfoPpdb;
use App\Models\Pengumuman;
use App\Models\ProfilSekolah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Contoh konten (teks diambil dari desain Figma) agar halaman tidak kosong saat diuji.
 * Semua data ini bersifat ilustratif dan boleh diubah atau dihapus dari panel admin.
 */
class ContohDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->profil();
        $this->guru();
        $this->pengumuman();
        $this->berita();
        $this->galeri();
        $this->ppdb();
    }

    private function profil(): void
    {
        ProfilSekolah::query()->updateOrCreate([], [
            'nama_sekolah' => 'SD Nusantara',
            'slogan' => 'Bertumbuh bersama, berakar pada nilai.',
            'jenjang' => 'Sekolah Dasar',
            'npsn' => null,
            'hero_judul' => 'Tempat tumbuh, belajar, dan menjadi berarti.',
            'hero_deskripsi' => 'Mendampingi setiap anak dengan pembelajaran yang bermakna, karakter yang kuat, dan lingkungan yang peduli.',
            'pengenalan_judul' => 'Pendidikan yang dekat dengan kehidupan.',
            'pengenalan' => "SD Nusantara adalah contoh sekolah dasar yang menempatkan karakter, rasa ingin tahu, dan kebersamaan sebagai fondasi belajar. Kami membangun lingkungan yang aman agar setiap anak merasa diterima dan berani mencoba.\n\nMelalui kerja sama guru dan orang tua, pengalaman belajar tidak berhenti di ruang kelas. Nilai saling menghargai, mandiri, dan peduli tumbuh dalam keseharian.",
            'nama_kepala_sekolah' => 'Ratna Wulandari, S.Pd.',
            'kutipan_sambutan' => 'Setiap anak membawa potensi yang layak kita rawat bersama.',
            'sambutan' => 'Selamat datang di ruang informasi SD Nusantara. Melalui website ini, kami ingin menjaga komunikasi yang terbuka dengan keluarga dan masyarakat. Mari bergandengan tangan menciptakan pengalaman sekolah yang hangat, aman, dan bermakna.',
            'sejarah' => '<p>Dalam narasi contoh ini, SD Nusantara tumbuh dari semangat masyarakat untuk menghadirkan pendidikan dasar yang dekat dan dapat diakses. Sekolah menjadi tempat anak mengenal pengetahuan sekaligus belajar hidup bersama.</p><p>Dari ruang kelas hingga kegiatan di lingkungan sekitar, sekolah terus mengembangkan cara belajar yang melibatkan keluarga. Kebiasaan membaca, kepedulian terhadap lingkungan, dan sikap saling menghargai menjadi bagian dari keseharian.</p>',
            'visi' => 'Terwujudnya anak yang berkarakter, gemar belajar, mandiri, dan peduli lingkungan.',
            'misi' => [
                'Menyelenggarakan pembelajaran yang aman, bermakna, dan menghargai keunikan anak.',
                'Membiasakan sikap jujur, disiplin, tanggung jawab, dan saling menghormati.',
                'Menumbuhkan budaya membaca serta keberanian bertanya dan berkarya.',
                'Membangun kemitraan dengan keluarga dan merawat lingkungan sekolah.',
            ],
            'fasilitas' => [
                ['nama' => 'Ruang kelas', 'deskripsi' => 'Ruang belajar terang dengan penataan yang mendukung interaksi.', 'foto' => null],
                ['nama' => 'Perpustakaan & sudut baca', 'deskripsi' => 'Tempat menjelajah cerita dan membangun kebiasaan membaca.', 'foto' => null],
                ['nama' => 'Halaman & kebun sekolah', 'deskripsi' => 'Ruang terbuka untuk bergerak, bermain, dan merawat alam.', 'foto' => null],
            ],
            'struktur_organisasi' => [
                ['jabatan' => 'Kepala Sekolah', 'nama' => 'Ratna Wulandari, S.Pd.'],
                ['jabatan' => 'Koordinator Kurikulum', 'nama' => 'Budi Santoso, S.Pd.'],
                ['jabatan' => 'Tim Pendidik', 'nama' => 'Guru Kelas 1–6 & guru bidang'],
                ['jabatan' => 'Komite Sekolah', 'nama' => '[nama sesuai keputusan sekolah]'],
            ],
            'jumlah_siswa' => 320,
            'jumlah_guru' => 18,
            'jumlah_kelas' => 12,
            'jumlah_ekstrakurikuler' => 8,
            'alamat' => 'Jl. Pendidikan No. 01, Kel. Teladan, Kec. Harapan, Kota Contoh, 00000',
            'telepon' => '(021) 000-0000',
            'email' => 'halo@sdnusantara.test',
            'jam_operasional' => "Senin–Jumat: 07.30–14.00 WIB\nSabtu–Minggu: Tidak melayani\nHari libur: Mengikuti kalender resmi",
        ]);
    }

    private function guru(): void
    {
        $guru = [
            ['Ratna Wulandari, S.Pd.', 'Kepala Sekolah'],
            ['Dewi Lestari, S.Pd.', 'Guru Kelas 1'],
            ['Budi Santoso, S.Pd.', 'Guru Kelas 2'],
            ['Siti Rahmawati, S.Pd.', 'Guru Kelas 3'],
            ['Agus Prasetyo, S.Pd.', 'Guru Kelas 4'],
            ['Rina Puspitasari, S.Pd.', 'Guru Kelas 5'],
            ['Ahmad Fauzi, S.Pd.', 'Guru Kelas 6'],
            ['Indah Permatasari, S.Pd.', 'Guru Pendidikan Jasmani'],
        ];

        foreach ($guru as $i => [$nama, $jabatan]) {
            Guru::query()->updateOrCreate(['nama' => $nama], [
                'jabatan' => $jabatan,
                'urutan' => $i,
                'aktif' => true,
            ]);
        }
    }

    private function pengumuman(): void
    {
        $data = [
            ['Jadwal penilaian akhir semester genap', 'Akademik', '2026-05-14', 'Penilaian dilaksanakan pada 2–6 Juni 2026. Simak jadwal dan persiapan yang perlu diperhatikan.', true],
            ['Informasi libur dan kegiatan sekolah bulan Juni', 'Kalender', '2026-05-13', 'Panduan agenda sekolah selama bulan Juni untuk membantu orang tua merencanakan kegiatan keluarga.', false],
            ['Pertemuan orang tua dan wali murid', 'Kegiatan', '2026-05-11', 'Undangan pertemuan pada Sabtu, 23 Mei 2026, pukul 08.00 di aula sekolah.', false],
            ['Persiapan berkas PPDB tahun ajaran 2026/2027', 'PPDB', '2026-05-09', 'Calon wali murid dapat mempelajari daftar berkas dan berkonsultasi dengan panitia di sekolah.', false],
            ['Pengembalian buku perpustakaan semester genap', 'Layanan', '2026-05-06', 'Mohon mengembalikan buku pinjaman paling lambat 29 Mei 2026 melalui petugas perpustakaan.', false],
            ['Kerja bakti lingkungan sekolah bersama keluarga', 'Kegiatan', '2026-05-02', 'Mari menjaga lingkungan sekolah pada Sabtu, 16 Mei 2026. Bawa perlengkapan kebersihan sederhana.', false],
        ];

        $isi = '<p>Yth. Bapak/Ibu Orang Tua dan Wali Murid, penilaian akhir semester genap direncanakan berlangsung pada 2–6 Juni 2026. Kegiatan ini menjadi bagian dari refleksi proses belajar selama satu semester.</p>'
            . '<h3>Ringkasan pelaksanaan</h3>'
            . '<table><tbody><tr><td>Tanggal</td><td>Selasa–Sabtu, 2–6 Juni 2026</td></tr><tr><td>Waktu</td><td>07.30–11.00 WIB, mengikuti jadwal kelas</td></tr><tr><td>Tempat</td><td>Ruang kelas masing-masing</td></tr><tr><td>Peserta</td><td>Kelas 1–6 dengan pendampingan guru kelas</td></tr></tbody></table>'
            . '<h3>Hal yang perlu dipersiapkan</h3>'
            . '<ul><li>Pastikan anak beristirahat cukup dan sarapan sebelum berangkat.</li><li>Siapkan alat tulis, kartu kegiatan, dan perlengkapan sesuai arahan guru.</li><li>Dampingi anak mengulang materi secara bertahap tanpa memberikan tekanan.</li><li>Apabila anak sakit atau berhalangan hadir, hubungi guru kelas melalui saluran resmi.</li></ul>'
            . '<p>Jadwal mata pelajaran akan disampaikan oleh guru kelas melalui surat edaran. Terima kasih atas kerja sama Bapak/Ibu dalam mendampingi anak dengan tenang dan penuh perhatian.</p>'
            . '<p><strong>Hormat kami,<br>Tim Pendidik SD Nusantara</strong></p>';

        foreach ($data as [$judul, $kategori, $tanggal, $ringkasan, $penting]) {
            Pengumuman::query()->firstOrCreate(['judul' => $judul], [
                'kategori' => $kategori,
                'ringkasan' => $ringkasan,
                'isi' => $isi,
                'penting' => $penting,
                'diterbitkan' => true,
                'tanggal_terbit' => Carbon::parse($tanggal . ' 08:00'),
            ]);
        }
    }

    private function berita(): void
    {
        $data = [
            ['Pekan Literasi: menumbuhkan kecintaan pada buku', 'Kegiatan', '2026-05-12', 'Membaca bersama, bertukar cerita, dan merawat rasa ingin tahu melalui kegiatan literasi di sekolah.', 'Literasi dan kebiasaan membaca'],
            ['Belajar merawat lingkungan dari kebun sekolah', 'Lingkungan', '2026-05-08', 'Kegiatan berkebun mengajak anak mengenal tanaman dan membangun kebiasaan peduli lingkungan.', 'Lingkungan hidup'],
            ['Ruang ekspresi melalui karya seni bersama', 'Kegiatan', '2026-05-04', 'Warna, bentuk, dan kerja sama menjadi bagian dari pengalaman belajar yang menyenangkan.', 'Seni dan kreativitas'],
            ['Jumat sehat, bergerak dan bermain bersama', 'Kegiatan', '2026-04-30', 'Gerak bersama di halaman sekolah mempererat kebersamaan dan kebiasaan hidup sehat.', 'Kesehatan'],
            ['Sekolah dan orang tua: membangun komunikasi', 'Sekolah', '2026-04-27', 'Pertemuan wali murid menjadi ruang berbagi untuk mendampingi tumbuh kembang anak.', 'Kemitraan keluarga'],
            ['Sudut baca baru untuk cerita yang lebih luas', 'Sekolah', '2026-04-23', 'Penataan sudut baca menghadirkan ruang yang tenang untuk menjelajah buku setiap hari.', 'Literasi'],
        ];

        $isi = '<p>Suasana perpustakaan terasa lebih hidup dalam Pekan Literasi SD Nusantara. Anak-anak bersama guru memilih buku, membaca bergiliran, dan membagikan cerita yang mereka sukai. Kegiatan ini mengajak seluruh warga sekolah melihat membaca sebagai kebiasaan yang dekat dengan kehidupan.</p>'
            . '<h2>Membaca, bercerita, dan saling mendengar</h2>'
            . '<p>Setiap kelas mendapat kesempatan mengunjungi perpustakaan dan mengenal beragam bacaan. Guru mendampingi anak memilih buku sesuai minat, kemudian membuka percakapan sederhana tentang tokoh, pengalaman, dan pesan cerita. Tidak ada tuntutan untuk menyelesaikan banyak halaman; yang utama adalah rasa ingin tahu.</p>'
            . '<blockquote><p>“Kebiasaan membaca tumbuh ketika anak merasa didengar dan diberi ruang untuk memilih.”</p></blockquote>'
            . '<h2>Dilanjutkan dari rumah</h2>'
            . '<p>Orang tua dapat melanjutkan kebiasaan ini dengan menyediakan waktu singkat untuk membaca bersama. Ajak anak menceritakan bagian yang paling disukai, dengarkan pertanyaannya, dan hubungkan cerita dengan pengalaman sehari-hari.</p>';

        foreach ($data as [$judul, $kategori, $tanggal, $ringkasan, $topik]) {
            Berita::query()->firstOrCreate(['judul' => $judul], [
                'kategori' => $kategori,
                'ringkasan' => $ringkasan,
                'isi' => $isi,
                'topik' => $topik,
                'penulis' => 'Tim Publikasi Sekolah',
                'diterbitkan' => true,
                'tanggal_terbit' => Carbon::parse($tanggal . ' 08:00'),
            ]);
        }
    }

    private function galeri(): void
    {
        $data = [
            ['Pekan Literasi: menumbuhkan kecintaan pada buku', 'Kegiatan', '2026-05-12', 'Membaca bersama dan berbagi cerita di perpustakaan.'],
            ['Belajar merawat lingkungan dari kebun sekolah', 'Lingkungan', '2026-05-08', 'Merawat tanaman dalam kegiatan kebun sekolah.'],
            ['Ruang ekspresi melalui karya seni bersama', 'Kegiatan', '2026-05-04', 'Membuat karya kelas secara berkelompok.'],
            ['Jumat sehat, bergerak dan bermain bersama', 'Kegiatan', '2026-04-30', 'Bergerak bersama pada kegiatan Jumat sehat.'],
        ];

        foreach ($data as [$judul, $kategori, $tanggal, $deskripsi]) {
            Galeri::query()->firstOrCreate(['judul' => $judul], [
                'kategori' => $kategori,
                'deskripsi' => $deskripsi,
                'foto' => [],
                'tanggal_kegiatan' => $tanggal,
                'diterbitkan' => true,
            ]);
        }
    }

    private function ppdb(): void
    {
        InfoPpdb::query()->updateOrCreate([], [
            'tahun_ajaran' => '2026/2027',
            'dibuka' => true,
            'judul' => 'Langkah awal untuk tumbuh bersama.',
            'deskripsi' => 'Kami mengundang calon orang tua dan wali murid untuk mengenal lingkungan belajar SD Nusantara. Pelajari petunjuk di bawah ini sebelum berkonsultasi dengan panitia PPDB.',
            'ketentuan_pengantar' => 'Calon peserta didik kelas 1 dengan pendampingan orang tua atau wali.',
            'ketentuan' => [
                'Memenuhi ketentuan usia masuk SD sesuai aturan yang berlaku.',
                'Melengkapi dokumen dan mengikuti verifikasi sekolah.',
                'Memahami mekanisme penerimaan yang ditetapkan sekolah.',
            ],
            'ketentuan_catatan' => 'Batas usia, prioritas penerimaan, dan daya tampung wajib merujuk keputusan resmi.',
            'persyaratan' => [
                'Salinan akta kelahiran anak',
                'Salinan Kartu Keluarga',
                'Pasfoto terbaru sesuai arahan panitia',
                'Dokumen pendukung sesuai ketentuan resmi',
            ],
            'persyaratan_catatan' => 'Bawa dokumen asli untuk diperlihatkan bila diminta panitia.',
            'tahapan' => [
                ['judul' => 'Konsultasi & penyerahan berkas', 'tanggal' => '1–12 Juni 2026', 'keterangan' => 'Datang ke sekolah bersama orang tua/wali untuk memperoleh penjelasan alur dan menyerahkan berkas.'],
                ['judul' => 'Pemeriksaan kelengkapan', 'tanggal' => '15–17 Juni 2026', 'keterangan' => 'Panitia memeriksa dokumen dan menghubungi wali bila ada berkas yang perlu dilengkapi.'],
                ['judul' => 'Informasi hasil', 'tanggal' => '20 Juni 2026', 'keterangan' => 'Hasil disampaikan melalui pengumuman resmi sekolah. Konfirmasikan langsung kepada panitia.'],
                ['judul' => 'Konfirmasi & daftar ulang', 'tanggal' => '22–24 Juni 2026', 'keterangan' => 'Orang tua/wali melakukan konfirmasi sesuai petunjuk yang diberikan sekolah.'],
            ],
            'cara_pendaftaran' => '<p>Pendaftaran pada rancangan versi pertama diarahkan melalui layanan sekolah. Belum tersedia formulir pendaftaran daring atau pengiriman dokumen melalui website ini.</p><ol><li>Pelajari persyaratan dan siapkan daftar pertanyaan.</li><li>Hubungi panitia untuk memastikan jadwal layanan.</li><li>Datang ke sekolah bersama wali dan ikuti arahan petugas.</li></ol>',
            'email_panitia' => 'ppdb@sdnusantara.test',
            'telepon_panitia' => '(021) 000-0000',
        ]);
    }
}
