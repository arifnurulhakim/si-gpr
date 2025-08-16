# E-Kartu Keluarga (EKK)

Sistem manajemen kartu keluarga berbasis web yang dibangun dengan Laravel dan Tailwind CSS.

## Fitur

- **Dashboard** - Statistik dan ringkasan data kartu keluarga
- **Manajemen Kartu Keluarga** - CRUD untuk data kartu keluarga
- **Manajemen Anggota Keluarga** - CRUD untuk data anggota keluarga
- **Autentikasi** - Login dan register user
- **Responsive Design** - Interface yang responsif dengan Tailwind CSS

## Teknologi

- **Backend**: Laravel 12
- **Frontend**: Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel UI

## Instalasi

### Prerequisites

- PHP 8.1+
- Composer
- MySQL
- Node.js & NPM

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd ekk
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database**
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ekk_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migrasi**
   ```bash
   php artisan migrate:fresh
   ```

6. **Seed database**
   ```bash
   php artisan db:seed --class=UserSeeder
   ```

7. **Compile assets**
   ```bash
   npm run dev
   ```

8. **Jalankan server**
   ```bash
   php artisan serve
   ```

## Struktur Database

### Tabel `families`
- `id` - Primary key
- `family_card_number` - Nomor kartu keluarga (unique)
- `head_of_family_name` - Nama kepala keluarga
- `address` - Alamat lengkap
- `rt` - RT
- `rw` - RW
- `village` - Desa/Kelurahan
- `sub_district` - Kecamatan
- `city` - Kota/Kabupaten
- `province` - Provinsi
- `postal_code` - Kode pos

### Tabel `family_members`
- `id` - Primary key
- `family_id` - Foreign key ke families
- `nik` - NIK (unique)
- `name` - Nama lengkap
- `gender` - Jenis kelamin (L/P)
- `date_of_birth` - Tanggal lahir
- `marital_status` - Status perkawinan
- `relationship_to_head` - Hubungan dengan kepala keluarga
- `citizenship` - Kewarganegaraan

### Tabel `family_card_events`
- `id` - Primary key
- `family_id` - Foreign key ke families
- `family_member_id` - Foreign key ke family_members (nullable)
- `event_type` - Jenis event
- `event_date` - Tanggal event
- `description` - Deskripsi event

### Tabel `family_card_requests`
- `id` - Primary key
- `family_id` - Foreign key ke families
- `request_type` - Jenis permintaan
- `request_date` - Tanggal permintaan
- `status` - Status (PENDING/APPROVED/REJECTED)
- `notes` - Catatan

## Akun Default

Setelah menjalankan seeder, akun default tersedia:
- **Email**: admin@ekk.com
- **Password**: password

## Routes

### Authentication
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `GET /register` - Halaman register
- `POST /register` - Proses register
- `POST /logout` - Logout

### Dashboard
- `GET /dashboard` - Dashboard utama

### Kartu Keluarga
- `GET /families` - Daftar kartu keluarga
- `GET /families/create` - Form tambah kartu keluarga
- `POST /families` - Simpan kartu keluarga
- `GET /families/{id}` - Detail kartu keluarga
- `GET /families/{id}/edit` - Form edit kartu keluarga
- `PUT /families/{id}` - Update kartu keluarga
- `DELETE /families/{id}` - Hapus kartu keluarga

### Anggota Keluarga
- `GET /family-members` - Daftar anggota keluarga
- `GET /family-members/create` - Form tambah anggota keluarga
- `POST /family-members` - Simpan anggota keluarga
- `GET /family-members/{id}/edit` - Form edit anggota keluarga
- `PUT /family-members/{id}` - Update anggota keluarga
- `DELETE /family-members/{id}` - Hapus anggota keluarga

## Fitur Utama

### Dashboard
- Statistik total kartu keluarga
- Statistik total anggota keluarga
- Statistik permintaan pending
- Daftar kartu keluarga terbaru
- Aksi cepat untuk tambah data

### Manajemen Kartu Keluarga
- Daftar kartu keluarga dengan pagination
- Form tambah/edit dengan validasi
- Detail kartu keluarga dengan anggota
- Hapus kartu keluarga dengan konfirmasi

### Manajemen Anggota Keluarga
- Daftar anggota keluarga dengan pagination
- Form tambah/edit dengan dropdown untuk enum
- Validasi NIK unik
- Hapus anggota keluarga dengan konfirmasi

## Validasi

### Kartu Keluarga
- Nomor kartu keluarga harus unik
- Semua field wajib diisi
- Format RT/RW maksimal 3 karakter
- Kode pos maksimal 5 karakter

### Anggota Keluarga
- NIK harus unik
- Tanggal lahir harus valid
- Jenis kelamin harus L atau P
- Status perkawinan harus sesuai enum
- Hubungan dengan kepala keluarga harus sesuai enum

## Styling

Aplikasi menggunakan Tailwind CSS untuk styling dengan komponen yang konsisten:
- **Colors**: Indigo untuk primary, Gray untuk neutral
- **Typography**: Responsive text sizing
- **Layout**: Grid dan Flexbox
- **Components**: Cards, Tables, Forms, Buttons
- **Responsive**: Mobile-first approach

## Development

### Menjalankan Development Server
```bash
php artisan serve
npm run dev
```

### Menjalankan Tests
```bash
php artisan test
```

### Menjalankan Migrasi
```bash
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh
```

## License

MIT License
