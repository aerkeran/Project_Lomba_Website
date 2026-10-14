# SpeakFun!

**Listen, Speak, Learn!**

Website pembelajaran Bahasa Inggris untuk siswa Sekolah Dasar (kelas 1–6).

---

## 1. Pengertian & Tujuan Website

**SpeakFun!** adalah website pembelajaran Bahasa Inggris yang berfokus pada tiga kemampuan dasar: **mendengar (listen), mengucapkan (speak), dan memahami kosakata (learn)**. Fitur utamanya adalah **Text-To-Speech (TTS)**: siswa melihat gambar suatu benda, mengetik namanya, lalu website menampilkan dan membacakan padanan Bahasa Inggrisnya.

Contoh alur (PRD §1):

| Gambar | Siswa mengetik | SpeakFun! memberikan |
|---|---|---|
| 🍎 apel | `apel` | **Apple** + dibacakan melalui TTS |

**Tujuan website (PRD §3):**

1. Membantu siswa mengenal kosakata Bahasa Inggris.
2. Membantu siswa mendengar pengucapan kata Bahasa Inggris yang benar.
3. Memberikan kesempatan menirukan pengucapan.
4. Menguji ingatan kosakata melalui kuis.
5. Membuat belajar terasa sederhana dan menyenangkan.

Website ini **bukan** platform belajar Bahasa Inggris yang lengkap, melainkan media latihan **kosakata dan pengucapan dasar**. Sesuai PRD §13, tanpa login, leaderboard, ranking, chat, atau pengaturan selain volume.

---

## 2. Tech Stack

| Lapisan | Teknologi | Keterangan |
|---|---|---|
| Bahasa | **PHP 8.3** | Sesuai `composer.json` (`"php": "^8.3"`) |
| Framework | **Laravel 13** | `laravel/framework ^13.17` |
| Templat Blade | **Blade** | `resources/views/*.blade.php` |
| Build tool | **Vite 8** | `laravel-vite-plugin ^3.1`, script `dev` / `build` |
| CSS | **Tailwind CSS v4** | `@tailwindcss/vite`, design token via `@theme` |
| JavaScript | **Vanilla ES Modules** | Tanpa framework SPA; `resources/js/features/*` |
| Text-To-Speech | **VoiceRSS** + **Web Speech API** | Audio utama dari server (`/tts`), fallback ke browser bila gagal |
| Konten | **JSON statis** | `database/data/level-1.json` … `level-6.json`, dibaca `VocabularyRepository` — tanpa tabel database |
| Testing | **PHPUnit 12** | `php artisan test` |
| Code style | **Laravel Pint** | `vendor/bin/pint` |
| Dev tools | Laravel Boost, Laravel Pail, Tinker | |

**Alur TTS:**

```text
Tombol 🔊 → resources/js/features/tts.js
              ├─ GET /tts?text=apple  →  TtsController → TtsService → VoiceRSS → MP3
              └─ bila gagal / key kosong → Web Speech API browser (suara tetap keluar)
```

API key VoiceRSS (`VOICERSS_KEY`) hanya disimpan di server, tidak pernah sampai ke browser.

---

## 3. Font

| Font | Bobot | Penggunaan | Token CSS |
|---|---|---|---|
| **Nunito Sans** | 400, 500, 600, 700 | Teks UI / body (paragraf, label tombol, instruksi) | `--font-sans` |
| **Nunito** | 700, 800 | Heading / display ("SpeakFun!", "Choose Your Level!", judul halaman) | `--font-display` |

Keduanya dipilih karena bentuknya *rounded* dan mudah dibaca oleh anak (PRD §9 Typography).

- Didefinisikan di `vite.config.js` melalui `laravel-vite-plugin/fonts` (sumber: **Bunny Fonts**), lalu di-*self-host* saat `npm run build`.
- Token dipakai di `resources/css/app.css` (`@theme { --font-sans; --font-display; }`) dan dipanggil lewat class Tailwind `font-sans` / `font-display`.
- Layout memanggil font lewat directive `@fonts` di `resources/views/layouts/app.blade.php`.

---

## 4. Rute & Peta Tombol

### 4.1 Daftar rute (`routes/web.php`)

| Method | URL | Nama rute | Handler | Halaman |
|---|---|---|---|---|
| GET | `/` | `home` | view `menu` | Menu Screen |
| GET | `/settings` | `settings` | view `settings` | Settings (volume) |
| GET | `/levels` | `levels` | `LevelController@index` | Pemilihan Level |
| GET | `/levels/{level}` | `levels.show` | `LevelController@show` | Learning Menu |
| GET | `/levels/{level}/{activity}` | `activity.show` | `LevelController@activity` | Materi / Latihan / Kuis |
| GET | `/tts` | `tts` | `TtsController` (invokable) | Audio MP3 (throttle 60 req/menit) |

`{level}` wajib angka, `{activity}` hanya boleh `materi`, `latihan`, atau `kuis` — selain itu 404.

### 4.2 Ke mana setiap tombol mengarah

**Menu Screen (`/`)**

| Tombol | Arah |
|---|---|
| ▶ **Play** | → `/levels` (pemilihan level) |
| ⚙ **Settings** | → `/settings` |
| Slider volume | Tidak pindah halaman — mengatur volume audio (tersimpan di browser) |

**Settings (`/settings`)**

| Tombol | Arah |
|---|---|
| ← **Back** | → `/` |
| Slider volume | Tidak pindah halaman |

**Pemilihan Level (`/levels`)**

| Tombol | Arah |
|---|---|
| ← **Back** | → `/` |
| **Level 1 … Level 6** | → `/levels/{level}` (contoh: `Level 3` → `/levels/3`) |

**Learning Menu (`/levels/{level}`)**

| Tombol | Arah |
|---|---|
| ← **Back** | → `/levels` |
| 📚 **Materi** | → `/levels/{level}/materi` |
| 🗣️ **Latihan** | → `/levels/{level}/latihan` |
| 📝 **Kuis / Tes** | → `/levels/{level}/kuis` |

**Halaman Materi / Latihan / Kuis (`/levels/{level}/{activity}`)**

| Tombol | Arah / perilaku |
|---|---|
| ← **Back** | → `/levels/{level}` (kembali ke Learning Menu) |
| 🔊 **Listen** | Tidak pindah halaman — memutar pengucapan (server `/tts?text=…`, fallback Web Speech API). Bisa ditekan berulang tanpa batas (FR-03) |
| **← Previous** | Tidak pindah halaman — pindah ke kata sebelumnya (JavaScript `lesson.js`) |
| **Next →** | Tidak pindah halaman — pindah ke kata berikutnya; **pada kata terakhir** → kembali ke `/levels/{level}`. Pada Kuis, tombol Next hanya muncul setelah jawaban benar |
| **Check** (Kuis saja) | Tidak pindah halaman — mengecek jawaban di browser, lalu menampilkan *Great Job!* / *Try Again!* |
| *Skip to content* | → `#main-content` (tautan aksesibilitas di setiap halaman) |

---

## 5. Struktur Proyek

```text
Project_Lomba_Website/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── LevelController.php      # Level picker, Learning Menu, Materi/Latihan/Kuis
│   │       ├── TtsController.php        # GET /tts → MP3 pengucapan
│   │       └── Controller.php
│   ├── Library/
│   │   └── voicerss_tts.php             # (legacy) helper VoiceRSS, tidak terpakai
│   ├── Models/
│   │   └── User.php                     # bawaan Laravel, tidak dipakai fitur workshop
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── Services/
│       ├── TtsService.php               # Panggil VoiceRSS + cache MP3 per kata
│       └── VocabularyRepository.php     # Baca kosakata dari JSON per level
│
├── config/
│   ├── tts.php                          # VOICERSS_KEY, endpoint, bahasa, lokasi cache
│   ├── filesystems.php                  # Disk local / public / speeches / s3
│   └── ...
│
├── database/
│   ├── data/
│   │   ├── level-1.json … level-6.json  # Sumber data kosakata (PRD §7)
│   ├── factories/, migrations/, seeders/
│
├── public/
│   └── images/vocab/                    # Gambar kosakata per kata
│
├── resources/
│   ├── css/app.css                      # Design token Tailwind v4 (@theme), tombol, animasi
│   ├── js/
│   │   ├── app.js                       # Entry point
│   │   └── features/
│   │       ├── audio-button.js          # State tombol 🔊 (idle/loading/speaking/done/error)
│   │       ├── lesson.js                # Navigasi antar kata + cek jawaban kuis
│   │       ├── tts.js                   # Panggil /tts, fallback Web Speech API
│   │       └── volume.js                # Penyimpanan & perubahan volume
│   └── views/
│       ├── layouts/app.blade.php        # Kerangka halaman, @fonts, @vite, region status TTS
│       ├── menu.blade.php               # Menu Screen (PRD §6.1)
│       ├── settings.blade.php           # Settings (PRD §6.2)
│       ├── levels.blade.php             # Level Selection (PRD §6.3)
│       ├── learning-menu.blade.php      # Learning Menu (PRD §6.4)
│       ├── activities/
│       │   ├── materi.blade.php         # PRD §6.5
│       │   ├── latihan.blade.php        # PRD §6.6
│       │   └── kuis.blade.php           # PRD §6.7
│       └── components/                  # Button, AudioButton, BackButton, Card,
│                                        # Feedback, LessonShell, ProgressBar, VolumeSlider
│
├── routes/
│   ├── web.php                          # Seluruh rute halaman + /tts
│   └── console.php
│
├── tests/
│   ├── Feature/                         # NavigationTest, ActivityPagesTest,
│   │                                    # TtsRouteTest, VocabularyRepositoryTest, …
│   └── Unit/
│
├── vite.config.js                       # Input build + deklarasi font Nunito / Nunito Sans
├── composer.json                        # Skrip setup / dev / test
├── package.json                         # build, dev
├── PRD.md                               # Product Requirement Document
├── DESIGN.md                            # Acuan desain visual & komponen
└── CHANGELOG.md                         # Riwayat perubahan
```

**Alur navigasi utama (PRD §6):**

```text
Menu (/) ──▶ Levels (/levels) ──▶ Learning Menu (/levels/{level})
   │                                                 │
   └──▶ Settings (/settings)                        ├──▶ Materi   (/levels/{level}/materi)
                                                     ├──▶ Latihan  (/levels/{level}/latihan)
                                                     └──▶ Kuis     (/levels/{level}/kuis)
```

---

## 6. Menjalankan Proyek

```bash
composer run setup     # composer install, .env + APP_KEY, migrate, npm install, npm run build
composer run dev       # server + Vite dev secara bersamaan
composer run test      # menjalankan seluruh test PHPUnit
```

Atau manual:

```bash
composer install
cp .env.example .env && php artisan key:generate
npm install && npm run build
php artisan serve
```
