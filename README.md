<p align="center">
  <a href="https://laravel.com" target="_blank">
   <img 
    src="https://raw.githubusercontent.com/dedeambari/fp-anteraje/frontend/assets/icon.png" width="400" alt="Laravel Logo">
  </a>
</p>
<hr>
Aplikasi antar-jemput modern berbasis mobile dan web, dibangun dengan stack ringan tapi powerful: React + Vite + Tailwind CSS + Capacitor. Siap digunakan sebagai PWA atau native app di Android.

## 🧩 Tech Stack

| Tech               | Keterangan                                                                |
| ------------------ | ------------------------------------------------------------------------- |
| React 19           | Library UI modern & deklaratif                                            |
| Vite 6             | Bundler cepat dengan dukungan native ESM                                  |
| Tailwind CSS 4     | Utility-first styling, dikombinasi dengan DaisyUI                         |
| DaisyUI 5          | Komponen Tailwind siap pakai                                              |
| Capacitor 7        | Platform bridge untuk akses fitur native (Splash Screen, Status Bar, dll) |
| Zustand            | State management minimalis                                                |
| React Router DOM 7 | Routing berbasis komponen                                                 |
| Axios              | HTTP client untuk komunikasi dengan backend                               |
| Swiper             | Library carousel responsif dan fleksibel                                  |
| Framer Motion      | Animasi halus dan modern                                                  |
| React Hot Toast    | Untuk notifikasi simpel dan stylish                                       |

## 📦 Instalasi

```bash
# Clone repositori
git clone git@github.com:username/antar-aje.git
cd antar-aje

# Install dependencies
npm install
```

## 🧪 Menjalankan Dev Server

```bash
npm run dev
```

Server akan berjalan di `http://localhost:5173` (atau port lainnya jika bentrok).

## 🏗️ Build Project

```bash
npm run build
```

Untuk preview build:

```bash
npm run preview
```

## 📱 Jalankan di Android

Running di android.

```bash
npx cap sync android
npx cap open android

```

## 📂 Struktur Proyek

```
📦src
 ┣ 📂assets
 ┃ ┣ 📜logo-placeholder.svg
 ┃ ┣ 📜react.svg
 ┃ ┗ 📜transport.png
 ┣ 📂components
 ┃ ┣ 📜BuktiPreview.tsx
 ┃ ┣ 📜Footer.tsx
 ┃ ┣ 📜Header.tsx
 ┃ ┣ 📜setupStatusBar.tsx
 ┃ ┣ 📜SplashScreen.tsx
 ┃ ┣ 📜Tabs.tsx
 ┃ ┣ 📜ToastCustom.tsx
 ┃ ┗ 📜UpdateProsess.tsx
 ┣ 📂lib
 ┃ ┗ 📜axios.ts
 ┣ 📂pages
 ┃ ┣ 📂auth
 ┃ ┃ ┣ 📜AuthPage.tsx
 ┃ ┃ ┣ 📜ForgotPasswordPage.tsx
 ┃ ┃ ┣ 📜LoginPage.tsx
 ┃ ┃ ┣ 📜ResetPasswordPage.tsx
 ┃ ┃ ┗ 📜VerifyOtpPage.tsx
 ┃ ┗ 📂tabs
 ┃ ┃ ┣ 📜DetailBarangPage.tsx
 ┃ ┃ ┣ 📜HomePage.tsx
 ┃ ┃ ┣ 📜ProfilePage.tsx
 ┃ ┃ ┣ 📜TabsPage.tsx
 ┃ ┃ ┗ 📜TaskPage.tsx
 ┣ 📂store
 ┃ ┣ 📜useAppBootstrapStore.ts
 ┃ ┣ 📜useAuthStore.ts
 ┃ ┣ 📜useForgotPasswordStore.ts
 ┃ ┣ 📜useHomeStore.ts
 ┃ ┣ 📜useProfileStore.ts
 ┃ ┣ 📜useTabsStore.ts
 ┃ ┗ 📜useTaskStore.ts
 ┣ 📂types
 ┃ ┣ 📜index.d.ts
 ┃ ┗ 📜swiper-css.d.ts
 ┣ 📂utils
 ┃ ┗ 📜helper.ts
 ┣ 📜App.tsx
 ┣ 📜index.css
 ┣ 📜main.tsx
 ┗ 📜vite-env.d.ts
```

## ⚙️ Script NPM

| Script    | Fungsi                              |
| --------- | ----------------------------------- |
| `dev`     | Menjalankan development server      |
| `build`   | Compile TypeScript dan build Vite   |
| `preview` | Preview hasil build di local server |
| `lint`    | Jalankan ESLint untuk cek kode      |

## ✨ Fitur Utama (coming soon)

- [x] Splash screen & status bar native
- [x] Routing modern dengan React Router
- [x] Komponen UI dengan DaisyUI
- [x] Toast & animasi yang smooth
- [x] Otentikasi & proteksi route
- [x] API terhubung dengan Laravel backend

## 🧠 Catatan Developer

- Gunakan `zustand` untuk state yang butuh persistence/global
- Semua styling berbasis Tailwind – no custom CSS
- Gunakan `react-hot-toast` untuk feedback UI user-friendly
- Struktur folder modular, scalable buat maintain jangka panjang

---

> Dibuat dengan 💻 oleh kelompok 12
