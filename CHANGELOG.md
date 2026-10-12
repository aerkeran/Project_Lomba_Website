# Changelog

Semua perubahan penting **SpeakFun!** dicatat di file ini.

Format mengikuti [Keep a Changelog](https://keepachangelog.com/id/1.1.0/) dan
proyek ini mengikuti [Semantic Versioning](https://semver.org/lang/id/).

---

## [Unreleased]

### Planned

- **Fase 4 — Polish & QA:** responsive, aksesibilitas, micro-interaction, checklist PRD §12.

---

## [0.3.0] - 2026-10-11

Fase 3 (fitur inti) dari rundown pengerjaan `PRD.md` §6.5–§6.7 — Materi, Latihan, dan Kuis.

### Added

#### Fase 3 — Materi, Latihan, Kuis

- **Materi** (`GET /levels/{level}/materi`) → `resources/views/activities/materi.blade.php`: gambar, kosakata Inggris, caption Bahasa Indonesia, tombol **Play**, **Previous/Next** (PRD §6.5 dan FR-04).
- **Latihan** (`GET /levels/{level}/latihan`) → `resources/views/activities/latihan.blade.php`: `Say this word:` + gambar + kata + tombol **Listen** besar + badge `Now it's your turn!` (PRD §6.6 dan FR-05). Sengaja tanpa mikrofon karena workshop tidak memakai voice recognition.
- **Kuis** (`GET /levels/{level}/kuis`) → `resources/views/activities/kuis.blade.php`: gambar + tombol **Listen** + kolom ketik + tombol **Check** + feedback `Great Job!` / `Try Again!` (PRD §6.7, FR-06, FR-07).
- **Komponen `<x-lesson-shell>`** → bingkai bersama ketiga aktivitas: tombol Back, header Level·aktivitas, `<x-progress-bar>`, kartu, dan navigasi Previous/Next. Seluruh kata level dikirim sebagai `<ol>` tersembunyi sehingga tidak ada *reload* di antara kata.
- **`resources/js/features/lesson.js`** — logika berjalan di browser: ganti gambar/kata/caption, perbarui progress bar & `aria-valuenow`, navigasi Previous/Next, tombol **Finish 🎉** di kata terakhir yang kembali ke Learning Menu, serta pemeriksaan jawaban Kuis.
- **`cancelAudioButton()`** di `audio-button.js` — mematikan pengucapan dan mereset state ke Idle ketika siswa berpindah kata, sekaligus meng-*bump* generation supaya promise playback yang dibatalkan tidak menggambar pesan error untuk kata yang sudah ditinggalkan.
- **Titik-ikat pada `<x-progress-bar>`** (`data-progress-count`, `data-progress-fill`) agar JS dapat memperbarui tanpa merender ulang.
- **`ActivityPagesTest`** — 6 test baru: isi tiap aktivitas, ketiadaan kolom ketik pada Latihan, feedback ganda pada Kuis, label progress per aktivitas, seluruh level mengirim seluruh kata, dan keberadaan file gambar yang dijanjikan data JSON.

### Changed

- `app/Http/Controllers/LevelController.php` — `activity()` tidak lagi mengembalikan *empty state* placeholder, melainkan memuat `activities.{materi,latihan,kuis}` lengkap dengan `items`, `total`, `menuUrl`, `label`, dan `icon`.
- `resources/js/app.js` — `boot()` ikut memanggil `initLesson()`.
- `tests/Feature/NavigationTest.php` — ekspektasi `No lessons yet.` diganti penanda konten nyata tiap aktivitas.

### Removed

- `resources/views/activity.blade.php` — view *empty state* Fase 2 sudah digantikan tiga halaman nyata.

### Notes

- **Pemeriksaan jawaban Kuis dilakukan di browser.** PRD §13 tidak memuat akun, skor, maupun peringkat, jadi tidak ada yang bisa dicurangi; imbal hasilnya jawaban muncul seketika (`DESIGN.md` §36 Prinsip 2) tanpa menunggu round-trip ke server. Jawaban memang terbaca di `data-english` halaman.
- **Kuis butuh JavaScript.** Materi dan Latihan tetap menampilkan kata pertama tanpa JS, tetapi Kuis baru bisa berjalan penuh dengan JS — seluruh pipeline audio pun sudah bergantung JS sejak Fase 1.
- **Prev pada Materi/Latihan adalah penambahan** di luar ASCII PRD §6.5 (hanya `NEXT →`), demi `DESIGN.md` §41 yang menaruh usability di urutan prioritas pertama.
- Kata Inggris dibandingkan setelah *lowercase*, spasi ganda dirapatkan, dan tanda baca di ujung dibuang (FR-07).

### Testing

- **35 test / 368 assertion lulus** (`php artisan test --compact`).
- `vendor/bin/pint --dirty --format agent` bersih.
- `npm run build` sukses; `lesson.js` ikut ter-bundle (JS naik 4.37 kB → 7.06 kB).
- Smoke test manual: `/levels/1/materi`, `/levels/1/latihan`, `/levels/1/kuis`, `/levels/4/materi` → `200`; `/levels/1/tantangan` → `404`.

---

## [0.2.0] - 2026-10-11

Fase 2 (navigasi) dari rundown pengerjaan `PRD.md` §6 — halaman-halaman yang dapat diklik penuh.

### Added

#### Fase 2 — Navigasi

- **Menu Screen** (`GET /`) → `resources/views/menu.blade.php`: logo SpeakFun!, tagline, tombol **Play**, tombol **Settings**, dan slider volume (PRD §6.1).
- **Settings** (`GET /settings`) → `resources/views/settings.blade.php`: slider volume saja, tanpa pengaturan lain (PRD §6.2).
- **Level Selection** (`GET /levels`) → `resources/views/levels.blade.php`: satu tombol per kelas, satu kolom di mobile dan grid di desktop (PRD §6.3 dan §10).
- **Learning Menu** (`GET /levels/{level}`) → `resources/views/learning-menu.blade.php`: Materi, Latihan, Kuis / Tes (PRD §6.4).
- **Halaman tiap aktivitas** (`GET /levels/{level}/{activity}`) → `resources/views/activity.blade.php`. Isi sekarang masih *empty state* `DESIGN.md` §26; materi sesungguhnya dibuat pada Fase 3. Route sudah ada sejak Fase 2 supaya FR-01 (masuk ke Materi/Latihan/Kuis) lengkap dan dapat diuji sejak hari pertama.
- **`LevelController`** dengan `index`, `show`, dan `activity`. Level divalidasi lewat `VocabularyRepository`, sehingga kelas yang belum ada datanya menghasilkan `404` alih-alih halaman kosong.
- **Route dijaga ketat**: `{level}` dibatasi `whereNumber` dan `{activity}` dibatasi `whereIn(['materi', 'latihan', 'kuis'])`.
- **Komponen `<x-volume-slider>`** — satu markup untuk slider di Menu Screen dan di Settings, di-*sync* oleh `volume.js`.
- **`NavigationTest`** — 6 test baru yang memeriksa isi halaman, seluruh link (dibandingkan lewat path agar tidak bergantung host), tombol Back, dan kasus 404.

### Changed

- `routes/web.php` — `/` tidak lagi menampilkan `welcome.blade.php`; ditambah route `settings`, `levels`, `levels.show`, `activity.show`.
- `resources/views/layouts/app.blade.php` — wrapper diberi `min-h-screen` supaya halaman yang isinya pendek terpusat secara vertikal.
- `resources/views/levels.blade.php` — subjudul Indonesia dihapus agar label UI tetap satu bahasa mengikuti contoh PRD §6.3.

### Testing

- **29 test / 255 assertion lulus** (`php artisan test --compact`).
- `vendor/bin/pint --dirty --format agent` bersih.
- `npm run build` sukses; utilitas yang dipakai (`accent-primary`, `h-11`, `rounded-hero`, `sm:grid-cols-2`, dsb.) dipastikan ikut ter-compile.
- Smoke test manual 9 URL: `/`, `/settings`, `/levels`, `/levels/1`, `/levels/6`, `/levels/1/materi` → `200`; `/levels/99`, `/levels/abc`, `/levels/1/tantangan` → `404`.

### Notes

- **Tidak ada navbar.** Navigasi mengikuti model PRD §6: satu rantai Menu → Level → Learning Menu, dengan tombol Back di setiap halaman (FR-01). Tidak ada halaman Progress karena PRD melarang leaderboard/peringkat.
- **Tombol Back selalu di kiri atas** di semua halaman, meskipun contoh PRD §6.2 menempatkan Back di bawah pada Settings — dipilih demi konsistensi (`DESIGN.md` §5).
- `resources/views/welcome.blade.php` sudah tidak dipakai dan boleh dihapus.

---

## [0.1.0] - 2026-10-10

Fase 0 (fondasi) dan Fase 1 (audio + komponen) dari rundown pengerjaan `PRD.md` dan `DESIGN.md`.

### Added

#### Fase 0 — Fondasi desain & konten

- **Design token** CSS (warna, radius, spacing, shadow, font) sesuai `DESIGN.md` §6–§10 dan §38 → `resources/css/app.css`.
- **Font Nunito Sans** (teks) dan **Nunito** (heading) melalui bunny fonts, menggantikan Instrument Sans → `vite.config.js`.
- **Data kosakata statis** 6 level × 8 kata → `database/data/level-{1..6}.json`. Tiap item membawa `id`, `level`, `indonesia`, `english`, `image`, `audio` sesuai PRD §7.
- **`VocabularyRepository`** untuk membaca dan memvalidasi file JSON. Level yang belum punya file menghasilkan collection kosong agar halaman bisa menampilkan empty state (`DESIGN.md` §26), sedangkan data yang rusak gagal keras.
- **48 gambar placeholder SVG** → `public/images/vocab/` (emoji flat di atas latar pastel per level; `table.svg` digambar manual karena emoji tidak menggambarkan meja dengan jelas).
- **Konfigurasi TTS** → `config/tts.php`, beserta `VOICERSS_KEY` di `.env.example`.

#### Fase 1 — Audio & komponen

- **Route `GET /tts`** sebagai proxy VoiceRSS, sehingga API key tidak pernah sampai ke browser.
- **`TtsService`**: cache MP3 per kata di `storage/app/tts-cache` (kuota VoiceRSS hanya sekali per pengucapan), retry khusus kegagalan koneksi, validasi signature MP3 sebelum menyimpan, dan pencatatan log bila provider gagal.
- **`TtsController`** dengan validasi input ketat dan `503 Audio is not available right now.` ketika audio tidak dapat dibuat.
- **`resources/js/features/tts.js`**: alur utama `/tts` → fallback **Web Speech API** → pesan ramah anak. Mendukung state Idle / Speaking / Finished / Unsupported / Error (`DESIGN.md` §17 dan §34).
- **`resources/js/features/volume.js`**: volume disimpan di `localStorage` dan diterapkan ke `<audio>` maupun `speechSynthesis` sekaligus (PRD FR-08).
- **`resources/js/features/audio-button.js`**: delegation listener sehingga tombol yang dibuat dinamis ikut berfungsi; state tombol `idle → loading → speaking → done | error`.
- **Layout utama** → `resources/views/layouts/app.blade.php` (skip-link, `data-tts-url`, region `#sf-tts-status` untuk pesan audio).
- **6 komponen reusable** → `resources/views/components/`: `<x-button>`, `<x-card>`, `<x-back-button>`, `<x-audio-button>`, `<x-feedback>`, `<x-progress-bar>`.
- **Sistem tombol `.btn`** (variant primary/secondary/ghost, ukuran sm/md/lg, `min-height` 44px, focus ring) sesuai `DESIGN.md` §21 dan aturan touch target §29.
- **Throttle 60 request/menit** pada route `/tts` untuk menjaga kuota harian VoiceRSS.

#### Alat bantu AI

- **Laravel Boost** terpasang: `AGENTS.md` ditulis ulang menjadi panduan khusus project, ditambah `.agents/skills/*` dan `boost.json`.

### Changed

- `resources/css/app.css` — menambahkan token tema SpeakFun! di atas `@import 'tailwindcss'`.
- `resources/js/app.js` — menjadi entry point yang mendaftarkan audio button dan volume slider.
- `routes/web.php` — menambahkan route `tts`.
- `vite.config.js` — font bunny berganti ke Nunito Sans + Nunito.
- `.env.example` — menambahkan `VOICERSS_KEY=`.
- `composer.json` / `composer.lock` — menambahkan `laravel/boost` (dev dependency).
- `AGENTS.md` — digenerate ulang oleh `php artisan boost:install`.

### Fixed

Dua bug yang ditemukan oleh test suite saat Fase 1 dijalankan:

- `Http::retry()` secara default melempar `RequestException` untuk semua 4xx/5xx, sehingga penolakan VoiceRSS (key salah, kuota habis) berujung error 500 alih-alih fallback. Diperbaiki dengan `throw: false` agar jawaban 4xx ditangani sebagai sinyal "gunakan Web Speech API".
- `TtsController::__invoke()` menyatakan return type `Illuminate\Http\Response`, padahal `response()->file()` mengembalikan `BinaryFileResponse`. Return type diperbaiki.

### Testing

- 3 file test baru: `VocabularyRepositoryTest`, `TtsRouteTest`, `BladeComponentsTest`.
- **23 test / 210 assertion lulus** (`php artisan test --compact`).
- `vendor/bin/pint --dirty --format agent` bersih.
- `npm run build` sukses (CSS token, `.btn`, dan font Nunito ter-compile).
- Smoke test manual: `GET /tts?text=apple` → `503` dengan pesan ramah anak; `GET /` → `200`.

### Notes

- **Belum ada halaman UI SpeakFun!** — route `/` masih menampilkan `welcome.blade.php` bawaan Laravel. Landing page dibuat pada Fase 2.
- **Gambar masih placeholder** dan akan diganti artwork final. Nama file sudah menjadi kontrak di `database/data/level-{1..6}.json`, jadi penggantian gambar tidak memerlukan perubahan kode.
- **`VOICERSS_KEY` belum diisi.** Tanpa key, audio otomatis memakai Web Speech API browser (tetap berfungsi, hanya karakter suaranya berbeda).
- **`public/build` tidak di-commit** — jalankan `npm run build` setelah clone.

[Unreleased]: https://github.com/aerkeran/Project_Lomba_Website/compare/v0.3.0...HEAD
[0.3.0]: https://github.com/aerkeran/Project_Lomba_Website/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/aerkeran/Project_Lomba_Website/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/aerkeran/Project_Lomba_Website/releases/tag/v0.1.0
