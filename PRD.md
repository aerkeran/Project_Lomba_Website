# PRD — SpeakFun!

**Tagline:** Listen, Speak, Learn!  
**Jenis:** Website pembelajaran Bahasa Inggris untuk siswa SD  
**Platform:** Web / Browser  
**Target Level:** Kelas 1–6 SD

---

## 1. Project Overview

**SpeakFun!** adalah website pembelajaran Bahasa Inggris untuk siswa Sekolah Dasar yang berfokus pada kemampuan **mendengar (listen), mengucapkan (speak), dan memahami kosakata Bahasa Inggris**.

Fitur utama website adalah **Text-To-Speech (TTS)**. Siswa akan melihat gambar suatu benda, kemudian memasukkan nama benda tersebut dalam Bahasa Indonesia. Website akan menampilkan dan membacakan padanan Bahasa Inggrisnya.

Contoh:

- Gambar: apel
- Siswa mengetik: **apel**
- SpeakFun! memberikan: **Apple** dan membacakannya melalui TTS.

Setelah mempelajari materi, siswa dapat melakukan latihan pengucapan dan kuis mengetik kosakata Bahasa Inggris berdasarkan suara yang didengar.

---

## 2. Problem

Siswa SD sering mengalami kesulitan dalam:

- Menghafal kosakata Bahasa Inggris.
- Mengetahui cara pengucapan kata Bahasa Inggris yang benar.
- Menghubungkan benda sehari-hari dengan nama Bahasa Inggrisnya.
- Berlatih mendengarkan dan mengucapkan Bahasa Inggris secara mandiri.
- Mendapatkan media pembelajaran yang sederhana dan menyenangkan.

Pembelajaran berbasis teks saja juga kurang membantu siswa dalam melatih **listening dan pronunciation**.

---

## 3. Goal

Tujuan utama SpeakFun!:

1. Membantu siswa mengenal kosakata Bahasa Inggris.
2. Membantu siswa mendengar pengucapan kata Bahasa Inggris.
3. Memberikan kesempatan kepada siswa untuk menirukan pengucapan.
4. Menguji kemampuan siswa mengingat kosakata melalui kuis.
5. Membuat proses belajar Bahasa Inggris terasa sederhana dan menyenangkan.

### Fokus Utama

**Listen → Speak → Learn**

Website tidak ditujukan sebagai platform pembelajaran Bahasa Inggris yang lengkap, tetapi sebagai media latihan **kosakata dan pengucapan dasar**.

---

## 4. Target Users

### Primary User

**Siswa/Siswi Sekolah Dasar kelas 1–6.**

Level pembelajaran dibedakan berdasarkan kelas:

| Level | Kelas |
|---|---|
| Level 1 | Kelas 1 |
| Level 2 | Kelas 2 |
| Level 3 | Kelas 3 |
| Level 4 | Kelas 4 |
| Level 5 | Kelas 5 |
| Level 6 | Kelas 6 |

### Karakteristik Pengguna

- Anak-anak.
- Membutuhkan interface sederhana.
- Lebih mudah memahami informasi melalui gambar dan suara.
- Membutuhkan tombol yang jelas dan mudah ditekan.
- Tidak membutuhkan banyak teks instruksi.

---

## 5. Brand Personality

### Brand

**SpeakFun!**

### Tagline

**Listen, Speak, Learn!**

### Personality

SpeakFun! harus terasa:

- Fun
- Friendly
- Playful
- Educational
- Interactive
- Encouraging

Website harus terasa seperti **belajar sambil bermain**, bukan seperti mengerjakan aplikasi ujian.

### Tone

Gunakan bahasa yang:

- Sederhana.
- Ramah anak.
- Positif.
- Tidak terlalu formal.

Contoh:

> **Great job! 🎉**  
> Kamu berhasil!

Hindari bahasa yang terlalu formal seperti:

> Jawaban Anda benar.

---

## 6. Required Pages/Sections

Struktur utama website:

```text
SpeakFun!
│
├── 1. Menu Screen
│
├── 2. Level Selection
│      ├── Level 1
│      ├── Level 2
│      ├── Level 3
│      ├── Level 4
│      ├── Level 5
│      └── Level 6
│
└── 3. Learning Menu
       ├── Materi
       ├── Latihan
       └── Kuis/Tes
```

### 6.1 Menu Screen

Halaman pertama ketika website dibuka.

Isi:

- Logo/nama **SpeakFun!**
- Tagline **Listen, Speak, Learn!**
- Tombol **Play**
- Tombol **Settings**
- Pengaturan volume

Contoh:

```text
SpeakFun!
Listen, Speak, Learn!

       ▶ PLAY

    ⚙ SETTINGS
```

---

### 6.2 Settings

Untuk workshop, settings hanya berisi pengaturan:

**Volume**

Contoh:

```text
SETTINGS

🔊 Volume
[ ━━━━━━━●━━ ]

      BACK
```

Tidak perlu memasukkan pengaturan lain.

---

### 6.3 Level Selection

Setelah menekan **Play**, siswa diarahkan ke pemilihan level.

Tampilkan:

```text
Choose Your Level!

[ LEVEL 1 ]   [ LEVEL 2 ]
[ LEVEL 3 ]   [ LEVEL 4 ]
[ LEVEL 5 ]   [ LEVEL 6 ]
```

Setiap level mewakili kelas SD.

---

### 6.4 Learning Menu

Setelah memilih level, siswa masuk ke menu pembelajaran.

Contoh:

```text
LEVEL 1

What do you want to do?

📚 MATERI

🗣️ LATIHAN

📝 KUIS / TES
```

Tiga pilihan utama:

1. **Materi**
2. **Latihan**
3. **Kuis/Tes**

---

### 6.5 Materi

Halaman materi berisi kosakata Bahasa Inggris sesuai level.

Setiap materi menggunakan gambar sebagai stimulus.

Contoh:

```text
        [IMAGE]
          🍎

         Apple

        🔊 PLAY

       [ NEXT → ]
```

Fungsi tombol speaker:

- Memutar pengucapan.
- Dapat ditekan berulang kali.

---

### 6.6 Latihan

Latihan berfokus pada **mendengar dan menirukan pengucapan**.

Alur:

```text
Gambar / Kata
      ↓
🔊 Contoh pengucapan
      ↓
Siswa mendengarkan
      ↓
Siswa menirukan
      ↓
🔊 Bisa diputar ulang
```

Untuk versi workshop, **tidak perlu voice recognition** untuk menilai suara siswa.

---

### 6.7 Kuis/Tes

Kuis menguji kemampuan siswa setelah mempelajari materi.

Alur:

```text
🔊 Dengarkan contoh

       ↓

Ketik nama benda
dalam Bahasa Inggris

[____________]

       ↓

     CHECK
```

Contoh:

> 🔊 Apple

Siswa mengetik:

> `apple`

Kemudian sistem memberikan feedback.

**Benar:**

> 🎉 Great Job!

**Salah:**

> 😊 Try Again!

Siswa dapat mendengarkan suara kembali sebelum menjawab.

---

## 7. Content Requirements

Materi harus disesuaikan dengan tingkat kelas.

### Level 1–2

Kosakata sangat dasar, misalnya:

- Apple
- Book
- Cat
- Dog
- Ball
- Table
- Chair
- Pencil

### Level 3–4

Kosakata lebih beragam, misalnya:

- School
- Classroom
- Teacher
- Family
- Food
- Animals
- Clothes
- Body parts

### Level 5–6

Kosakata dan materi lebih kompleks, misalnya:

- Daily activities
- Places
- Hobbies
- Objects
- Simple expressions
- Basic sentences

> Catatan: daftar kosakata final dapat ditentukan kemudian berdasarkan materi Bahasa Inggris yang digunakan sekolah.

### Data Setiap Item Materi

Setiap item materi minimal memiliki:

```text
ID
Level
Indonesian Word
English Word
Image
Audio
```

Contoh:

```json
{
  "level": 1,
  "indonesia": "apel",
  "english": "apple",
  "image": "apple.png",
  "audio": "apple"
}
```

---

## 8. Functional Requirements

### FR-01 — Navigation

Sistem harus dapat berpindah:

```text
Menu
 ↓
Level
 ↓
Learning Menu
 ↓
Materi / Latihan / Kuis
```

Setiap halaman harus memiliki tombol **Back**.

---

### FR-02 — Text-To-Speech

Website harus dapat menggunakan fitur Text-To-Speech untuk membacakan kosakata Bahasa Inggris.

Contoh:

```text
Indonesia: apel
English: apple

🔊 → "Apple"
```

Bahasa TTS harus menggunakan **English**.

---

### FR-03 — Repeat Audio

Siswa dapat menekan tombol speaker berkali-kali untuk mendengarkan pengucapan.

Tidak ada batas jumlah pemutaran.

---

### FR-04 — Materi

Siswa dapat:

1. Melihat gambar.
2. Melihat kosakata Bahasa Inggris.
3. Mendengarkan pengucapan.
4. Berpindah ke kosakata berikutnya.

---

### FR-05 — Latihan

Siswa dapat:

1. Mendengarkan contoh.
2. Menirukan pengucapan secara langsung.
3. Memutar ulang contoh.

Untuk versi workshop, **tidak perlu voice recognition** untuk menilai suara siswa.

---

### FR-06 — Kuis

Sistem memberikan:

1. Gambar/stimulus.
2. Audio Bahasa Inggris.
3. Input jawaban.
4. Tombol Check.
5. Feedback benar/salah.

Contoh:

```text
🔊 Apple

Your answer:

[ apple       ]

[ CHECK ]
```

---

### FR-07 — Jawaban Kuis

Sistem melakukan pencocokan jawaban siswa dengan jawaban yang benar.

Minimal:

```text
Correct → 🎉 Great Job!
Wrong   → 😊 Try Again!
```

---

### FR-08 — Volume

Settings hanya mengatur volume audio website.

---

## 9. Design Requirements

### Visual Style

Gunakan desain yang:

- Ceria.
- Bersih.
- Modern.
- Ramah anak.
- Tidak terlalu kompleks.

### Warna

Gunakan palet warna cerah tetapi tetap nyaman dilihat.

Contoh:

- Warna utama: biru.
- Warna sekunder: kuning.
- Warna aksen: hijau/oranye.
- Background: putih atau warna pastel.

### Typography

Gunakan font yang:

- Mudah dibaca.
- Rounded/friendly.
- Memiliki ukuran cukup besar.

### Buttons

Tombol harus:

- Besar.
- Mudah diklik.
- Memiliki label yang jelas.
- Memiliki ikon jika diperlukan.

Contoh:

**▶ PLAY**

lebih baik daripada tombol kecil yang hanya berisi ikon.

### Image

Gunakan gambar yang:

- Jelas.
- Tidak terlalu kompleks.
- Mudah dikenali anak.
- Relevan dengan kosakata.

---

## 10. Responsive Requirements

Website harus dapat digunakan pada:

- Smartphone.
- Tablet.
- Laptop/Desktop.

Prioritas utama adalah **mobile/tablet**, karena anak kemungkinan menggunakan perangkat dengan layar sentuh.

### Mobile

- Tombol berukuran besar.
- Tidak membutuhkan horizontal scrolling.
- Gambar tetap terlihat jelas.
- Layout dapat berubah menjadi satu kolom.

Contoh:

```text
[ LEVEL 1 ]

[ LEVEL 2 ]

[ LEVEL 3 ]
```

daripada tombol terlalu kecil dalam satu baris.

### Desktop

Level dapat ditampilkan dalam grid:

```text
[LEVEL 1] [LEVEL 2] [LEVEL 3]

[LEVEL 4] [LEVEL 5] [LEVEL 6]
```

---

## 11. Accessibility Requirements

SpeakFun! harus mudah digunakan oleh anak-anak.

### Audio

- Semua audio memiliki tombol Play.
- Audio dapat diulang.
- Volume dapat diatur.
- Jangan mengandalkan audio saja untuk navigasi.

### Visual

- Teks harus memiliki kontras yang cukup.
- Ukuran teks tidak terlalu kecil.
- Tombol memiliki label yang jelas.
- Jangan menggunakan warna sebagai satu-satunya indikator benar/salah.

Contoh:

Tidak hanya menggunakan warna hijau untuk jawaban benar.

Gunakan:

> 🎉 **Correct! Great Job!**

---

## 12. Success Criteria

Website dianggap berhasil untuk workshop apabila:

### Navigation

- [ ] User dapat membuka Menu Screen.
- [ ] Tombol Play dapat membuka Level Selection.
- [ ] User dapat memilih Level 1–6.
- [ ] User dapat masuk ke Materi, Latihan, dan Kuis.
- [ ] Tombol Back bekerja dengan benar.

### TTS

- [ ] Website dapat mengeluarkan suara Bahasa Inggris.
- [ ] Pengucapan dapat diputar ulang.
- [ ] Volume dapat diatur.

### Materi

- [ ] Gambar dapat ditampilkan.
- [ ] Kosakata Bahasa Inggris ditampilkan.
- [ ] User dapat berpindah antar materi.

### Latihan

- [ ] User dapat mendengarkan contoh pengucapan.
- [ ] User dapat mengulang audio sebanyak yang diperlukan.

### Kuis

- [ ] User dapat mendengarkan kata.
- [ ] User dapat mengetik jawaban Bahasa Inggris.
- [ ] Sistem dapat mengecek jawaban.
- [ ] Sistem memberikan feedback benar/salah.

### UI

- [ ] Website dapat digunakan pada smartphone.
- [ ] Tombol mudah ditekan.
- [ ] Interface mudah dipahami siswa SD.
- [ ] Tidak ada fitur yang membingungkan atau tidak diperlukan.

---

## 13. Things to Avoid

Agar scope workshop tetap sederhana, **jangan menambahkan fitur berikut**:

- Login/register siswa.
- Database akun siswa.
- Leaderboard.
- Sistem ranking.
- Chat.
- Forum.
- Multiplayer.
- Sistem pembayaran.
- Dashboard guru.
- Dashboard orang tua.
- AI chatbot.
- Speech recognition kompleks.
- Sistem sertifikat.
- Notifikasi.
- Sistem achievement/badge yang kompleks.
- Pengaturan selain volume.
- Materi pelajaran di luar kosakata dan pronunciation dasar.

### Prinsip Scope SpeakFun!

> **One website, one simple goal: Listen → Speak → Learn.**
