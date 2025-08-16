# Sidebar Layout - E-Kartu Keluarga

## Deskripsi

Layout baru dengan sidebar di samping kiri seperti Filament Admin Panel, memberikan pengalaman yang lebih modern dan terorganisir.

## Fitur Sidebar

### 🎨 Design
- **Fixed Sidebar** - Sidebar tetap di posisi kiri dengan lebar 256px (w-64)
- **Indigo Theme** - Menggunakan warna indigo sebagai primary color
- **Shadow & Border** - Efek visual yang elegan dengan shadow dan border

### 📱 Responsive
- **Desktop First** - Optimized untuk desktop dengan sidebar tetap
- **Mobile Ready** - Layout yang responsif untuk berbagai ukuran layar

### 🔧 Komponen

#### 1. Logo Section
```html
<div class="flex items-center justify-center h-16 bg-indigo-600">
    <h1 class="text-xl font-bold text-white">E-Kartu Keluarga</h1>
</div>
```

#### 2. Navigation Menu
- **Dashboard** - Icon dashboard dengan active state
- **Kartu Keluarga** - Icon keluarga dengan active state
- **Anggota Keluarga** - Icon user dengan active state

#### 3. User Profile Section
- **Avatar** - Inisial user dalam lingkaran
- **User Info** - Nama dan email user
- **Logout Button** - Icon logout dengan hover effect

#### 4. Top Bar
- **Page Title** - Judul halaman yang dinamis
- **Notifications** - Icon notifikasi (placeholder)

## Struktur Layout

### Authenticated Users
```html
<body>
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg">
        <!-- Logo -->
        <!-- Navigation -->
        <!-- User Menu -->
    </div>

    <!-- Main Content -->
    <div class="ml-64">
        <!-- Top Bar -->
        <!-- Page Content -->
    </div>
</body>
```

### Guest Users
```html
<body>
    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm">
        <!-- Logo & Login/Register Links -->
    </nav>

    <!-- Guest Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Content -->
    </main>
</body>
```

## Active State Logic

Setiap menu item memiliki active state berdasarkan route yang sedang aktif:

```php
{{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : '' }}
{{ request()->routeIs('families.*') ? 'bg-indigo-50 text-indigo-700' : '' }}
{{ request()->routeIs('family-members.*') ? 'bg-indigo-50 text-indigo-700' : '' }}
```

## Icon Set

Menggunakan Heroicons (SVG) untuk konsistensi visual:

- **Dashboard**: Chart bar icon
- **Kartu Keluarga**: Users group icon
- **Anggota Keluarga**: User icon
- **Logout**: Logout icon
- **Notifications**: Bell icon

## Color Scheme

- **Primary**: Indigo-600 (#4F46E5)
- **Hover**: Indigo-50 (#EEF2FF)
- **Active**: Indigo-700 (#4338CA)
- **Text**: Gray-700 (#374151)
- **Background**: Gray-50 (#F9FAFB)

## Responsive Behavior

### Desktop (≥1024px)
- Sidebar tetap di posisi kiri
- Main content dengan margin-left 256px
- Full navigation menu visible

### Tablet (768px - 1023px)
- Sidebar tetap, content menyesuaikan
- Navigation tetap accessible

### Mobile (<768px)
- Layout menyesuaikan untuk mobile
- Sidebar bisa di-collapse (future enhancement)

## Keuntungan

1. **Better Organization** - Menu terorganisir dengan baik
2. **Modern Look** - Design yang modern seperti admin panel profesional
3. **Easy Navigation** - Navigasi yang intuitif dan mudah
4. **Consistent UX** - Pengalaman pengguna yang konsisten
5. **Scalable** - Mudah untuk menambah menu baru

## Future Enhancements

- [ ] Mobile sidebar toggle
- [ ] Collapsible sidebar
- [ ] Breadcrumb navigation
- [ ] Search functionality
- [ ] Dark mode support
- [ ] Customizable theme colors 
