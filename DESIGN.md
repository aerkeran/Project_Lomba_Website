# DESIGN.md --- SpeakFun!

> **Dokumen Acuan Design & UI/UX untuk AI Agent**
>
> Dokumen ini menjadi sumber kebenaran (single source of truth) untuk
> keputusan visual, UI/UX, interaksi, responsivitas, aksesibilitas, dan
> konsistensi antarmuka website **SpeakFun!**.

------------------------------------------------------------------------

## 1. Tujuan Dokumen

`DESIGN.md` digunakan sebagai acuan AI Agent dan developer ketika:

-   membuat halaman baru;
-   membuat atau mengubah komponen UI;
-   menentukan warna, typography, spacing, icon, dan ilustrasi;
-   merancang responsive layout;
-   membuat state interaksi seperti loading, success, error, empty
    state;
-   memastikan UI tetap ramah anak SD;
-   melakukan implementasi frontend Laravel;
-   melakukan refactor tanpa merusak identitas visual SpeakFun!.

Jika terdapat keputusan desain yang bertentangan dengan dokumen ini, AI
Agent harus mengutamakan aturan yang lebih spesifik pada
halaman/komponen tersebut dan menjaga prinsip utama SpeakFun!: **fun,
simple, educational, safe, accessible, dan child-friendly**.

------------------------------------------------------------------------

# 2. Product Design Vision

## 2.1 Identitas Produk

**SpeakFun!** adalah website pembelajaran Bahasa Inggris untuk anak SD
yang menggunakan pendekatan visual, permainan sederhana, Text-to-Speech,
dan latihan pengucapan.

Produk harus terasa seperti:

-   aplikasi belajar;
-   menyenangkan seperti permainan;
-   mudah dipahami tanpa membaca instruksi panjang;
-   aman untuk anak;
-   tidak terlalu ramai;
-   memberi feedback positif.

Produk **tidak boleh** terasa seperti:

-   dashboard enterprise;
-   aplikasi administrasi sekolah;
-   website yang terlalu formal;
-   UI penuh teks;
-   interface yang membutuhkan banyak langkah.

## 2.2 Design Keywords

Gunakan kata kunci berikut sebagai dasar keputusan visual:

> **Fun --- Friendly --- Colorful --- Simple --- Clear --- Interactive
> --- Educational --- Safe**

------------------------------------------------------------------------

# 3. Target User

Target utama:

-   anak SD;
-   pengguna dengan kemampuan membaca yang masih berkembang;
-   pengguna yang sedang belajar kosakata Bahasa Inggris dasar;
-   pengguna yang membutuhkan bantuan audio untuk memahami
    pronunciation.

Target sekunder:

-   guru;
-   orang tua;
-   admin/pengelola konten.

### Prinsip UI untuk Anak

1.  Satu layar harus memiliki satu tujuan utama.
2.  Gunakan kalimat pendek.
3.  Gunakan tombol yang jelas.
4.  Gunakan icon + teks bila memungkinkan.
5.  Jangan menggunakan istilah teknis.
6.  Berikan feedback segera setelah anak melakukan aksi.
7.  Gunakan warna sebagai pendukung, bukan satu-satunya penanda.
8.  Hindari navigasi yang dalam atau kompleks.
9.  Gunakan visual benda/objek untuk membantu pemahaman.
10. Jangan membuat anak merasa gagal ketika jawaban salah.

------------------------------------------------------------------------

# 4. Brand Direction

## 4.1 Brand Personality

SpeakFun! harus terasa:

-   ceria;
-   bersahabat;
-   energik;
-   suportif;
-   modern;
-   edukatif;
-   tidak mengintimidasi.

## 4.2 Tone of Voice

Gunakan bahasa yang:

-   sederhana;
-   positif;
-   pendek;
-   encouraging;
-   sesuai usia anak.

### Contoh

Gunakan:

-   `Let's Learn!`
-   `Good job!`
-   `Try Again!`
-   `Listen & Repeat`
-   `Your turn!`
-   `Awesome!`
-   `Keep trying!`

Hindari:

-   `Incorrect response detected.`
-   `Authentication failed.`
-   `Invalid pronunciation input.`
-   `Your performance is below average.`

------------------------------------------------------------------------

# 5. Visual Design System

## 5.1 General Style

Style utama:

-   modern flat UI;
-   rounded corners;
-   soft shadows;
-   playful illustrations;
-   high readability;
-   moderate use of colors;
-   generous whitespace.

Jangan menggunakan:

-   glassmorphism berlebihan;
-   gradient ekstrem;
-   neon yang menyilaukan;
-   shadow terlalu gelap;
-   terlalu banyak border;
-   layout yang terlalu padat.

------------------------------------------------------------------------

# 6. Color System

Warna dapat disesuaikan ketika implementasi final dilakukan, tetapi
seluruh UI harus mengikuti semantic color system berikut.

## 6.1 Primary

``` text
Primary        #4F7DF3
Primary Hover  #3F6FE5
Primary Soft   #EAF0FF
```

Digunakan untuk:

-   CTA utama;
-   tombol belajar;
-   link penting;
-   progress indicator;
-   selected state.

## 6.2 Secondary

``` text
Secondary      #FFB84D
Secondary Soft #FFF4DF
```

Digunakan untuk:

-   highlight;
-   reward;
-   badge;
-   elemen playful;
-   attention state yang tidak kritis.

## 6.3 Accent

``` text
Accent         #5BCB8A
Accent Soft    #E9F9F0
```

Digunakan untuk:

-   jawaban benar;
-   success state;
-   progress positif;
-   achievement.

## 6.4 Error

``` text
Error          #F16B6B
Error Soft     #FFF0F0
```

Digunakan untuk:

-   error;
-   jawaban salah;
-   validation;
-   microphone/browser error.

Error harus tetap bersifat edukatif dan tidak menghukum.

## 6.5 Neutral

``` text
Text Primary   #263238
Text Secondary #607080
Text Muted     #8A98A8

Background     #F8FAFD
Surface        #FFFFFF
Border         #E3E8EF
```

## 6.6 Color Rules

-   Maksimal 1 primary CTA dominan dalam satu area.
-   Jangan menggunakan semua warna brand sekaligus.
-   Text harus memiliki kontras yang cukup.
-   Jangan menggunakan warna saja untuk menyatakan benar/salah.
-   Success/error harus disertai icon atau teks.
-   Background sebaiknya tetap terang dan bersih.

------------------------------------------------------------------------

# 7. Typography

## 7.1 Font

Prioritaskan font sans-serif yang:

-   mudah dibaca;
-   memiliki bentuk huruf sederhana;
-   mendukung Bahasa Indonesia dan Bahasa Inggris;
-   memiliki weight lengkap.

Rekomendasi:

``` text
Primary: Nunito Sans
Fallback: Inter, system-ui, sans-serif
```

Untuk heading yang lebih playful dapat menggunakan:

``` text
Nunito
```

## 7.2 Type Scale

``` text
Display      40–48px / 700–800
H1           32–40px / 700
H2           24–32px / 700
H3           20–24px / 700
Body Large   18px / 400–600
Body         16px / 400–500
Body Small   14px / 400–500
Caption      12px / 400–600
Button       16px / 600–700
```

Untuk mobile:

``` text
Display      32–36px
H1           28–32px
H2           22–26px
H3           18–22px
Body         16px
```

## 7.3 Typography Rules

-   Gunakan maksimal 2 jenis font.
-   Heading boleh bold.
-   Jangan menggunakan uppercase untuk paragraph panjang.
-   Hindari line-height terlalu rapat.
-   Gunakan sentence case sebagai default.

------------------------------------------------------------------------

# 8. Spacing System

Gunakan sistem spacing berbasis kelipatan 4 atau 8.

``` text
4px   = xs
8px   = sm
12px  = md-sm
16px  = md
24px  = lg
32px  = xl
48px  = 2xl
64px  = 3xl
80px  = section
```

### Rules

-   Card internal padding: minimal `16px`.
-   Desktop section spacing: `48–80px`.
-   Mobile section spacing: `32–48px`.
-   Jangan membuat elemen terlalu berdekatan.
-   Gunakan whitespace untuk memisahkan kelompok informasi.

------------------------------------------------------------------------

# 9. Border Radius

SpeakFun! menggunakan rounded UI.

``` text
Small      8px
Medium     12px
Large      16px
Card       20px
Hero       24px
Pill       999px
```

Gunakan radius besar untuk:

-   card pembelajaran;
-   game/quiz container;
-   CTA utama;
-   illustration container.

------------------------------------------------------------------------

# 10. Shadows

Shadow harus lembut.

Contoh:

``` css
box-shadow: 0 4px 16px rgba(38, 50, 56, 0.08);
```

Untuk card yang lebih menonjol:

``` css
box-shadow: 0 8px 24px rgba(38, 50, 56, 0.10);
```

Jangan menggunakan shadow hitam pekat.

------------------------------------------------------------------------

# 11. Iconography

Gunakan icon yang:

-   sederhana;
-   rounded;
-   mudah dikenali anak;
-   konsisten stroke/weight-nya.

Rekomendasi:

-   microphone;
-   volume/speaker;
-   play;
-   arrow;
-   check;
-   refresh;
-   home;
-   book;
-   star;
-   trophy;
-   help/info.

Untuk aksi utama, icon dapat digunakan bersama label.

Contoh:

``` text
🔊 Listen
🎤 Speak
➡️ Next
🔄 Try Again
```

Emoji boleh digunakan sebagai elemen dekoratif atau reward, tetapi bukan
pengganti icon sistem secara keseluruhan.

------------------------------------------------------------------------

# 12. Illustration Direction

Ilustrasi adalah elemen penting untuk membuat SpeakFun! terasa ramah
anak.

Karakteristik:

-   flat/soft illustration;
-   bentuk sederhana;
-   ekspresi positif;
-   warna lembut;
-   objek mudah dikenali;
-   background tidak terlalu kompleks.

Contoh objek pembelajaran:

-   apple;
-   book;
-   pencil;
-   chair;
-   cat;
-   dog;
-   car;
-   school;
-   bag;
-   ball.

### Image Rules

-   Gunakan gambar yang jelas.
-   Satu gambar sebaiknya mewakili satu objek utama.
-   Hindari gambar dengan background ramai.
-   Gunakan aspect ratio konsisten.
-   Jangan mengandalkan gambar tanpa label/audio.

------------------------------------------------------------------------

# 13. Layout Architecture

## 13.1 Global Layout

Struktur umum:

``` text
┌─────────────────────────────────────┐
│ Header / Navigation                 │
├─────────────────────────────────────┤
│                                     │
│ Main Content                        │
│                                     │
├─────────────────────────────────────┤
│ Footer                              │
└─────────────────────────────────────┘
```

Pada halaman belajar, footer boleh dihilangkan agar fokus anak tidak
terganggu.

## 13.2 Content Width

Desktop:

``` text
max-width: 1200px
```

Reading/learning content:

``` text
max-width: 900px
```

Narrow text content:

``` text
max-width: 720px
```

Gunakan:

``` css
margin-inline: auto;
padding-inline: 24px;
```

Mobile:

``` text
padding-inline: 16px;
```

------------------------------------------------------------------------

# 14. Navigation

## Desktop

Header dapat berisi:

``` text
[SpeakFun!]   Home   Learn   Practice   Progress
```

CTA atau profile berada di sisi kanan bila diperlukan.

## Mobile

Gunakan navigation sederhana.

Prioritas:

1.  Home
2.  Learn
3.  Practice
4.  Progress

Jangan menampilkan terlalu banyak menu sekaligus.

------------------------------------------------------------------------

# 15. Halaman Utama / Landing Page

## Tujuan

Menjelaskan SpeakFun! secara singkat dan membawa anak ke aktivitas
belajar.

## Struktur

``` text
Hero
 ↓
How It Works
 ↓
Learning Categories
 ↓
Practice CTA
 ↓
Footer
```

## Hero

Komponen:

-   headline;
-   short description;
-   primary CTA;
-   illustration;
-   optional secondary CTA.

Contoh:

``` text
Learn English,
Have Fun!

Belajar kosakata Bahasa Inggris
dengan gambar, suara, dan latihan.

[ Start Learning ]
```

Hero harus langsung menjelaskan manfaat produk.

------------------------------------------------------------------------

# 16. Halaman Learning

Ini adalah salah satu halaman utama SpeakFun!.

## Struktur

``` text
Progress
     ↓
Object Image
     ↓
Indonesian Question
     ↓
Answer Input
     ↓
Submit
     ↓
Text-to-Speech Result
```

Contoh:

``` text
Question 3 of 10

        [ APPLE IMAGE ]

Apa bahasa Inggris dari benda ini?

[  ketik jawaban...  ]

[ Check Answer ]
```

## Rules

-   Fokuskan satu soal dalam satu layar.
-   Gambar harus dominan.
-   Input harus besar.
-   CTA harus mudah ditemukan.
-   Jangan menampilkan banyak informasi yang tidak relevan.

------------------------------------------------------------------------

# 17. Text-to-Speech Interface

Text-to-Speech adalah fitur inti.

## Komponen

``` text
[ 🔊 Listen ]
```

atau:

``` text
English Word
     Apple

[ 🔊 Hear Pronunciation ]
```

## Interaction

Ketika tombol ditekan:

1.  button menunjukkan loading/speaking state;
2.  browser memutar pronunciation;
3.  user dapat menekan ulang;
4.  button kembali ke normal.

### Speaking State

``` text
🔊 Speaking...
```

Setelah selesai:

``` text
🔊 Listen Again
```

Jangan membuat tombol disabled terlalu lama tanpa feedback.

------------------------------------------------------------------------

# 18. Speaking / Pronunciation Practice

Halaman latihan pronunciation menggunakan microphone.

## Struktur

``` text
Instruction
     ↓
Target Word
     ↓
Listen Example
     ↓
Microphone Button
     ↓
Recording State
     ↓
Result / Feedback
```

Contoh:

``` text
Say this word:

APPLE

[ 🔊 Listen ]

[ 🎤 Tap and Speak ]

Your pronunciation:
[ feedback ]
```

## Microphone Button

State:

### Idle

``` text
🎤 Speak
```

### Recording

``` text
⏺ Listening...
```

### Processing

``` text
Analyzing...
```

### Success

``` text
✓ Great pronunciation!
```

### Retry

``` text
Try again!
```

Feedback harus mendorong anak untuk mencoba kembali.

------------------------------------------------------------------------

# 19. Quiz / Practice UI

## Question Card

``` text
┌─────────────────────────────┐
│ Question 4 / 10             │
│                             │
│        [ IMAGE ]            │
│                             │
│ What is this?               │
│                             │
│ [ Apple ]                   │
│ [ Book  ]                   │
│ [ Chair ]                   │
│ [ Table ]                   │
└─────────────────────────────┘
```

Answer option:

-   besar;
-   mudah ditekan;
-   memiliki clear selected state;
-   tidak terlalu banyak dalam satu layar.

## Correct State

Tampilkan:

-   check icon;
-   success color;
-   short positive feedback.

Contoh:

``` text
✓ Correct!
Awesome!
```

## Wrong State

Jangan mempermalukan user.

Gunakan:

``` text
Not quite!
Let's try again.
```

------------------------------------------------------------------------

# 20. Progress & Gamification

Gamification digunakan untuk meningkatkan motivasi, bukan membuat
kompetisi yang menekan.

Komponen:

-   progress bar;
-   stars;
-   badges;
-   completed lessons;
-   streak jika diperlukan.

Contoh:

``` text
Your Progress

████████░░ 80%

8 / 10 lessons completed
```

## Rules

-   Hindari ranking publik anak.
-   Hindari membandingkan nilai dengan anak lain.
-   Reward harus positif.
-   Jangan menggunakan punishment visual berlebihan.

------------------------------------------------------------------------

# 21. Button System

## Primary

Digunakan untuk aksi utama.

``` text
Background: Primary
Text: White
Radius: 12–16px
Height: 44–52px
```

Contoh:

``` text
[ Start Learning ]
```

## Secondary

Untuk aksi pendukung.

``` text
Background: Primary Soft
Text: Primary
```

## Ghost

Untuk aksi yang tidak dominan.

``` text
Background: transparent
Text: Text Secondary
```

## Danger

Hanya untuk aksi yang benar-benar destruktif atau error recovery.

Jangan menggunakan warna merah untuk jawaban salah sebagai punishment.

------------------------------------------------------------------------

# 22. Input System

Input harus:

-   minimal 44px tinggi;
-   rounded;
-   label jelas;
-   placeholder singkat;
-   memiliki focus state.

Contoh:

``` text
What is this in English?

[ Type your answer... ]
```

### Focus

Gunakan outline/ring yang jelas.

Jangan hanya mengubah warna border sedikit.

------------------------------------------------------------------------

# 23. Card System

Card digunakan untuk:

-   lesson;
-   category;
-   quiz;
-   progress;
-   achievement.

Card structure:

``` text
┌─────────────────────────────┐
│ Icon / Image                │
│                             │
│ Title                       │
│ Description                 │
│                             │
│ [ Action ]                  │
└─────────────────────────────┘
```

Card tidak boleh terlalu banyak dalam satu halaman anak.

------------------------------------------------------------------------

# 24. Feedback System

Feedback harus cepat dan mudah dipahami.

## Success

``` text
✓ Great job!
```

## Wrong Answer

``` text
Almost!
Try one more time.
```

## Browser Permission

``` text
Microphone permission is needed
to practice speaking.
```

## TTS Not Available

``` text
Audio is not available right now.
You can continue learning without it.
```

Jangan menampilkan error teknis seperti stack trace kepada anak.

------------------------------------------------------------------------

# 25. Loading State

Gunakan loading state yang sederhana.

Contoh:

``` text
Preparing your lesson...
```

Gunakan skeleton atau spinner jika proses cukup lama.

Jangan membuat layar blank.

------------------------------------------------------------------------

# 26. Empty State

Contoh:

``` text
No lessons yet.

Your next lesson will appear here soon.
```

Berikan satu CTA jika ada tindakan yang bisa dilakukan.

------------------------------------------------------------------------

# 27. Error State

Error harus:

-   manusiawi;
-   singkat;
-   actionable;
-   tidak teknis.

Contoh:

``` text
Oops!

Something went wrong.
Please try again.

[ Try Again ]
```

Developer-only technical information harus berada di log, bukan UI anak.

------------------------------------------------------------------------

# 28. Responsive Design

SpeakFun! harus mobile-first.

## Breakpoints

Gunakan breakpoint standar yang fleksibel:

``` text
Mobile:  < 640px
Tablet:  640–1023px
Desktop: >= 1024px
```

## Mobile Rules

-   satu kolom;
-   CTA full-width jika sesuai konteks;
-   image tidak terlalu kecil;
-   tombol mudah disentuh;
-   navigasi sederhana;
-   tidak ada horizontal scrolling.

## Tablet

-   dua kolom bila membantu;
-   card dapat menggunakan grid.

## Desktop

-   gunakan whitespace lebih banyak;
-   content tetap memiliki max-width;
-   jangan membuat elemen terlalu melebar.

------------------------------------------------------------------------

# 29. Accessibility

SpeakFun! harus mempertimbangkan aksesibilitas sejak awal.

## Keyboard

Semua interactive element harus dapat diakses keyboard.

## Focus

Focus state harus terlihat jelas.

## Screen Reader

-   gunakan semantic HTML;
-   gunakan label pada input;
-   gunakan accessible name pada button;
-   image memiliki alt text.

## Color

Jangan menyampaikan informasi hanya melalui warna.

Contoh:

Salah:

``` text
Hijau = benar
Merah = salah
```

Benar:

``` text
✓ Correct!
✕ Try again!
```

## Touch Target

Target sentuh ideal:

``` text
minimum 44 × 44px
```

------------------------------------------------------------------------

# 30. Motion & Animation

Animation digunakan untuk meningkatkan feedback, bukan dekorasi
berlebihan.

Gunakan:

-   fade;
-   scale kecil;
-   slide;
-   progress animation;
-   success bounce ringan.

Durasi umum:

``` text
150–300ms
```

Hindari:

-   flashing;
-   animasi terus menerus;
-   parallax berat;
-   animasi yang mengganggu fokus belajar.

Jika user mengaktifkan reduced motion, kurangi atau matikan animasi
non-esensial.

------------------------------------------------------------------------

# 31. Sound Design

Karena SpeakFun! merupakan produk pembelajaran berbasis audio, sound
harus diperlakukan sebagai bagian dari UX.

Prioritas audio:

1.  pronunciation;
2.  user feedback;
3.  optional reward sound.

Jangan autoplay audio yang tidak diminta user.

Tombol audio harus memiliki label yang jelas.

------------------------------------------------------------------------

# 32. Browser & Device Considerations

Fitur microphone dan Text-to-Speech bergantung pada kemampuan
browser/device.

AI Agent harus:

-   melakukan feature detection;
-   menyediakan fallback;
-   tidak mengasumsikan API selalu tersedia;
-   menampilkan error yang mudah dipahami;
-   menjaga core learning flow tetap dapat digunakan jika audio gagal.

------------------------------------------------------------------------

# 33. Component Architecture

Komponen UI disarankan dibagi menjadi:

``` text
Layout
├── Header
├── Footer
└── PageContainer

Navigation
├── Navbar
├── MobileMenu
└── Breadcrumb (jika diperlukan)

UI
├── Button
├── Input
├── Card
├── Badge
├── ProgressBar
├── Modal
├── Toast
└── Alert

Learning
├── LessonCard
├── QuestionCard
├── ObjectImage
├── AnswerInput
├── AudioButton
├── SpeechRecorder
├── FeedbackMessage
└── LessonProgress

Gamification
├── StarReward
├── AchievementBadge
├── ProgressSummary
└── CompletionCard
```

AI Agent harus mengutamakan reuse component daripada membuat markup baru
yang identik.

------------------------------------------------------------------------

# 34. Page State Requirements

Setiap halaman interaktif minimal harus memikirkan state berikut:

``` text
Default
Loading
Success
Error
Empty
Disabled
Hover
Focus
Active
Mobile
Desktop
```

Untuk fitur microphone:

``` text
Idle
Permission Request
Recording
Processing
Success
Retry
Unsupported
Error
```

Untuk Text-to-Speech:

``` text
Idle
Speaking
Finished
Unsupported
Error
```

------------------------------------------------------------------------

# 35. UX Flow Utama

## Flow A --- Belajar Kosakata

``` text
Home
 ↓
Start Learning
 ↓
Choose Lesson
 ↓
Show Object
 ↓
User Answers in Indonesian
 ↓
System Shows English Word
 ↓
Text-to-Speech
 ↓
User Listens
 ↓
Next Question
```

## Flow B --- Speaking Practice

``` text
Practice
 ↓
Choose Word
 ↓
Listen to Example
 ↓
Tap Microphone
 ↓
Speak
 ↓
Processing
 ↓
Feedback
 ↓
Retry / Next
```

------------------------------------------------------------------------

# 36. UX Principles untuk Anak

## Principle 1 --- One Task at a Time

Jangan memberikan terlalu banyak tugas dalam satu layar.

## Principle 2 --- Immediate Feedback

Setiap aksi penting harus memberikan feedback.

## Principle 3 --- Positive Learning

Kesalahan adalah bagian dari proses belajar.

## Principle 4 --- Visual First

Gunakan gambar dan icon untuk membantu teks.

## Principle 5 --- Audio Support

Pronunciation harus mudah ditemukan.

## Principle 6 --- Minimal Reading Load

Instruksi harus singkat.

## Principle 7 --- Safe Exploration

Anak boleh mencoba kembali tanpa takut kehilangan progress.

------------------------------------------------------------------------

# 37. Content Guidelines

Gunakan:

-   kalimat pendek;
-   vocabulary sederhana;
-   instruksi langsung;
-   positive language.

Contoh:

``` text
Listen first.
Now it's your turn!
What is this?
Great job!
Try again!
```

Hindari:

``` text
Please provide the appropriate English lexical equivalent
for the displayed visual object.
```

------------------------------------------------------------------------

# 38. Design Tokens

AI Agent sebaiknya menggunakan token daripada hard-code nilai visual
berulang.

Contoh:

``` css
:root {
  --color-primary: #4F7DF3;
  --color-primary-soft: #EAF0FF;

  --color-secondary: #FFB84D;
  --color-secondary-soft: #FFF4DF;

  --color-success: #5BCB8A;
  --color-success-soft: #E9F9F0;

  --color-error: #F16B6B;
  --color-error-soft: #FFF0F0;

  --color-text: #263238;
  --color-text-secondary: #607080;
  --color-text-muted: #8A98A8;

  --color-background: #F8FAFD;
  --color-surface: #FFFFFF;
  --color-border: #E3E8EF;

  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 16px;
  --radius-card: 20px;
  --radius-xl: 24px;
  --radius-pill: 999px;

  --space-xs: 4px;
  --space-sm: 8px;
  --space-md: 16px;
  --space-lg: 24px;
  --space-xl: 32px;
  --space-2xl: 48px;
  --space-3xl: 64px;
}
```

------------------------------------------------------------------------

# 39. Laravel Frontend Guidance

Design harus mudah diterapkan pada struktur Laravel.

Rekomendasi:

``` text
resources/
├── css/
│   ├── app.css
│   └── components/
├── js/
│   ├── app.js
│   └── features/
└── views/
    ├── layouts/
    ├── components/
    ├── home/
    ├── learning/
    ├── practice/
    └── progress/
```

Blade components disarankan untuk elemen reusable.

Contoh:

``` text
<x-button />
<x-card />
<x-audio-button />
<x-progress-bar />
<x-question-card />
<x-feedback />
```

AI Agent tidak boleh menduplikasi komponen jika komponen reusable sudah
tersedia.

------------------------------------------------------------------------

# 40. AI Agent Design Rules

Ketika membuat atau mengubah UI SpeakFun!, AI Agent wajib mengikuti
aturan berikut.

## MUST

-   mengikuti color tokens;
-   mengikuti typography;
-   menggunakan spacing system;
-   menggunakan reusable components;
-   menjaga responsive behavior;
-   menjaga accessibility;
-   menyediakan loading/error/success state untuk fitur async;
-   mempertahankan child-friendly UX;
-   menjaga visual hierarchy;
-   menggunakan semantic HTML.

## SHOULD

-   menggunakan icon + label;
-   menggunakan micro-interaction sederhana;
-   memaksimalkan whitespace;
-   membuat CTA jelas;
-   menjaga halaman tetap ringan.

## MUST NOT

-   membuat UI enterprise yang terlalu kompleks;
-   menggunakan terlalu banyak warna;
-   menggunakan font dekoratif berlebihan;
-   menghilangkan focus state;
-   membuat tombol kecil;
-   menampilkan technical error kepada anak;
-   menggunakan warna sebagai satu-satunya indikator status;
-   membuat autoplay audio;
-   membuat animasi yang mengganggu;
-   mengubah brand direction tanpa alasan.

------------------------------------------------------------------------

# 41. Design Decision Priority

Jika terjadi konflik antar keputusan desain, gunakan prioritas:

``` text
1. Usability & Safety
2. Accessibility
3. Learning Goal
4. Simplicity
5. Consistency
6. Brand Aesthetic
7. Decoration
```

Dengan kata lain:

> Fungsi dan kemudahan belajar lebih penting daripada dekorasi.

------------------------------------------------------------------------

# 42. Definition of Done --- UI

Sebuah UI dianggap selesai apabila:

-   [ ] sesuai design system;
-   [ ] responsive pada mobile, tablet, desktop;
-   [ ] memiliki hover/focus/active state bila relevan;
-   [ ] memiliki loading state bila ada proses async;
-   [ ] memiliki error state;
-   [ ] memiliki success state bila relevan;
-   [ ] dapat digunakan keyboard;
-   [ ] memiliki accessible label;
-   [ ] tidak menyebabkan horizontal overflow;
-   [ ] text dapat dibaca dengan jelas;
-   [ ] CTA utama mudah ditemukan;
-   [ ] tidak ada informasi teknis yang bocor ke user;
-   [ ] reusable component digunakan jika tersedia;
-   [ ] visual hierarchy jelas;
-   [ ] child-friendly;
-   [ ] konsisten dengan halaman lain.

------------------------------------------------------------------------

# 43. Checklist AI Agent Sebelum Commit

Sebelum menyelesaikan implementasi frontend, AI Agent harus memeriksa:

``` text
[ ] Apakah halaman memiliki satu tujuan utama?
[ ] Apakah CTA utama terlihat jelas?
[ ] Apakah desain cocok untuk anak SD?
[ ] Apakah typography mudah dibaca?
[ ] Apakah warna mengikuti token?
[ ] Apakah spacing konsisten?
[ ] Apakah button cukup besar untuk touch?
[ ] Apakah mobile layout sudah diperiksa?
[ ] Apakah keyboard navigation berfungsi?
[ ] Apakah focus state tersedia?
[ ] Apakah image memiliki alt text?
[ ] Apakah async action memiliki loading state?
[ ] Apakah error message ramah anak?
[ ] Apakah audio memiliki fallback?
[ ] Apakah komponen existing sudah digunakan?
[ ] Apakah ada unnecessary animation?
[ ] Apakah UI terlalu ramai?
```

------------------------------------------------------------------------

# 44. Final Design Principle

SpeakFun! harus membuat anak merasa:

> **"Aku bisa belajar Bahasa Inggris dengan mudah dan menyenangkan."**

Setiap keputusan desain harus mendukung pengalaman tersebut.

**Design mantra:**

``` text
Simple enough for children.
Fun enough to keep learning.
Clear enough to understand.
Accessible enough for everyone.
```

------------------------------------------------------------------------

## Document Status

-   **Project:** SpeakFun!
-   **Document:** DESIGN.md
-   **Purpose:** UI/UX and frontend design specification
-   **Audience:** AI Agent, frontend developer, UI/UX designer
-   **Status:** Initial design specification
-   **Related Document:** PRD.md
