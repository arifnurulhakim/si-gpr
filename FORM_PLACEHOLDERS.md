# Form Placeholders - SI-GPR

## Deskripsi

Dokumentasi ini menjelaskan placeholder yang telah ditambahkan ke semua form input di aplikasi SI-GPR untuk memberikan panduan dan contoh kepada pengguna.

## 📝 Form Kartu Keluarga

### Create & Edit Form

| Field | Placeholder | Deskripsi |
|-------|-------------|-----------|
| **Nomor Kartu Keluarga** | `Contoh: 3273011234567890` | Format 16 digit nomor kartu keluarga |
| **Nama Kepala Keluarga** | `Contoh: Ahmad Supriadi` | Nama lengkap kepala keluarga |
| **Alamat** | `Contoh: Jl. Raya Bogor No. 123, Gang Melati` | Alamat lengkap tempat tinggal |
| **RT** | `Contoh: 001` | Nomor RT (3 digit) |
| **RW** | `Contoh: 005` | Nomor RW (3 digit) |
| **Desa/Kelurahan** | `Contoh: Kelurahan Cibinong` | Nama desa atau kelurahan |
| **Kecamatan** | `Contoh: Cibinong` | Nama kecamatan |
| **Kota/Kabupaten** | `Contoh: Bogor` | Nama kota atau kabupaten |
| **Provinsi** | `Contoh: Jawa Barat` | Nama provinsi |
| **Kode Pos** | `Contoh: 16913` | Kode pos 5 digit |

## 👥 Form Anggota Keluarga

### Create & Edit Form

| Field | Placeholder | Deskripsi |
|-------|-------------|-----------|
| **NIK** | `Contoh: 3273011234567890` | Format 16 digit nomor induk kependudukan |
| **Nama Lengkap** | `Contoh: Siti Nurhaliza` | Nama lengkap anggota keluarga |
| **Kewarganegaraan** | `Contoh: WNI` | Kode kewarganegaraan (3 karakter) |

### Dropdown Fields (Tidak memerlukan placeholder)

| Field | Opsi |
|-------|------|
| **Jenis Kelamin** | Laki-laki, Perempuan |
| **Status Perkawinan** | Belum Kawin, Kawin, Cerai Hidup, Cerai Mati |
| **Hubungan dengan Kepala Keluarga** | Kepala Keluarga, Suami, Istri, Anak, Orang Tua, Famili Lain, Pembantu, Lainnya |

## 🔐 Form Authentication

### Login Form

| Field | Placeholder | Deskripsi |
|-------|-------------|-----------|
| **Email** | `Contoh: admin@ekk.com` | Email untuk login |
| **Password** | `Contoh: password` | Password untuk login |

### Register Form

| Field | Placeholder | Deskripsi |
|-------|-------------|-----------|
| **Nama** | `Contoh: Ahmad Supriadi` | Nama lengkap user |
| **Email** | `Contoh: ahmad@example.com` | Email untuk registrasi |
| **Password** | `Contoh: password123` | Password baru |
| **Konfirmasi Password** | `Contoh: password123` | Konfirmasi password |

## 🎯 Manfaat Placeholder

### 1. **User Experience (UX)**
- Memberikan panduan visual kepada pengguna
- Mengurangi kesalahan input
- Mempercepat proses pengisian form

### 2. **Konsistensi Data**
- Memastikan format data yang konsisten
- Mengurangi variasi input yang tidak standar
- Memudahkan validasi data

### 3. **Accessibility**
- Meningkatkan aksesibilitas untuk pengguna dengan keterbatasan
- Memberikan konteks yang jelas untuk screen reader
- Memudahkan navigasi keyboard

## 📋 Implementasi Teknis

### HTML Structure
```html
<input type="text" 
       name="field_name" 
       id="field_name" 
       placeholder="Contoh: Sample Data"
       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
```

### CSS Styling
- Placeholder menggunakan warna `placeholder-gray-500`
- Konsisten dengan design system Tailwind CSS
- Responsive pada semua ukuran layar

## 🔄 Update History

### v1.0.0 - Initial Implementation
- ✅ Kartu Keluarga form (Create & Edit)
- ✅ Anggota Keluarga form (Create & Edit)
- ✅ Authentication forms (Login & Register)
- ✅ Konsistensi placeholder di semua form

## 🚀 Best Practices

### 1. **Konsistensi Format**
- Semua placeholder dimulai dengan "Contoh: "
- Menggunakan format yang realistis dan relevan
- Konsisten dengan standar data Indonesia

### 2. **Klaritas**
- Placeholder jelas dan mudah dipahami
- Tidak terlalu panjang atau terlalu pendek
- Menggunakan contoh yang familiar

### 3. **Maintenance**
- Mudah diupdate jika ada perubahan format
- Terdokumentasi dengan baik
- Konsisten di seluruh aplikasi

## 📱 Responsive Behavior

- Placeholder tetap terlihat di semua ukuran layar
- Tidak mengganggu layout pada mobile
- Konsisten dengan responsive design

## 🔮 Future Enhancements

- [ ] Dynamic placeholder berdasarkan lokasi user
- [ ] Auto-complete suggestions
- [ ] Real-time validation dengan contoh
- [ ] Multi-language placeholder support
- [ ] Contextual help tooltips 
