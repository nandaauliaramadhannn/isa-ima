# Intelligence Socio Analytics (ISA) & Intelligence Media Analytics (IMA)

Aplikasi ini adalah sistem crawling, analisis, dan pelaporan data dari sosial media dan media mainstream terkait topik-topik strategis seperti Bupati, Wakil Bupati, dan Kabupaten Bekasi.

## 🔍 Tujuan Aplikasi

- **ISA (Intelligence Socio Analytics)**  
  Mengambil dan menganalisis data dari media sosial (Twitter, Facebook, Instagram, TikTok) berdasarkan keyword tertentu.

- **IMA (Intelligence Media Analytics)**  
  Mengambil dan menganalisis data dari portal berita mainstream seperti Detik, Kompas, Tempo, Tribunnews, Radar Bekasi, dan Website Resmi Pemkab Bekasi.

---

## 🧭 Alur Aplikasi

### IMA (Intelligence Media Analytics)

1. **Input Keyword & Periode**  
   Admin memasukkan keyword (misal: "bupati", "kabupaten bekasi") dan periode tanggal.

2. **Crawling Berita**
   Aplikasi akan melakukan scraping berita dari beberapa media online:
   - Detik.com
   - Kompas.com
   - Tempo.co
   - Tribunnews.com
   - RadarBekasi.id
   - Bekasikab.go.id (Website resmi)

3. **Penyimpanan ke Database**
   - Data berita disimpan ke tabel `imas` dan `ima_analises`
   - Isi yang disimpan: Judul, isi (jika ada), tanggal publish, sumber berita, dan keyword.

4. **Analisis Sentimen (Opsional)**
   - Bisa dilakukan analisis sentimen otomatis atau manual
   - Menentukan apakah isi berita bernada **positif**, **negatif**, atau **netral**

5. **Visualisasi & Laporan**
   - Data ditampilkan melalui dashboard atau dikompilasi ke laporan PDF / Excel / DOCX

---

## 🗃 Struktur Tabel (Database)

### Tabel: `imas`
| Field | Keterangan |
|-------|------------|
| id | ID utama |
| sumber_media | Nama sumber berita |
| keyword | Kata kunci pencarian |
| tanggal_mulai | Periode mulai pencarian |
| tanggal_selesai | Periode akhir pencarian |
| jumlah_berita | Total berita ditemukan |
| created_by | ID user input |
| timestamps | Waktu dibuat dan update |

### Tabel: `ima_analises`
| Field | Keterangan |
|-------|------------|
| id | ID utama |
| ima_id | Relasi ke tabel `imas` |
| judul | Judul berita |
| isi | Isi berita (opsional) |
| sentimen | Sentimen (positif/negatif/netral) |
| tanggal_publish | Tanggal publish berita |
| sumber_berita | Asal berita (Detik, Kompas, dll) |
| timestamps | Waktu dibuat dan update |

---

## 📁 Struktur Folder

