# Changelog

Semua perubahan penting **SpeakFun!** dicatat di file ini.

Format mengikuti [Keep a Changelog](https://keepachangelog.com/id/1.1.0/) dan
proyek ini mengikuti [Semantic Versioning](https://semver.org/lang/id/).

---

## [Unreleased]

### Planned

- **Fase 2 — Navigasi:** Menu Screen, Settings (volume), Level Selection, Learning Menu, tombol Back.
- **Fase 3 — Fitur inti:** Materi, Latihan, Kuis (ketik jawaban + feedback).
- **Fase 4 — Polish & QA:** responsive, aksesibilitas, micro-interaction, checklist PRD §12.

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

[Unreleased]: https://github.com/aerkeran/Project_Lomba_Website/compare/v0.1.0...HEAD
[0.1.0]: https://github.com/aerkeran/Project_Lomba_Website/releases/tag/v0.1.0
