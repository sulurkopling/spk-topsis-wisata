<?php include '../config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>TOPSIS & Detail Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(to right, #f6f9fc, #e0f7fa); margin-top: 40px; }
        .img-preview { max-width: 100%; height: auto; border-radius: 12px; }
        table { font-size: 14px; }
    </style>
</head>
<body>
<div class="container">

<?php
$id = $_GET['id'] ?? null;

if ($id !== null) {
    echo "<a href='hasil_pemilihan.php' class='btn btn-secondary mb-3'>← Kembali ke Hasil Pemilihan</a>";
    echo "<div class='card shadow p-4'>";

    $wisata = $koneksi->query("SELECT * FROM wisata WHERE id_wisata='$id'")->fetch_assoc();

    if (!$wisata) {
        echo "<div class='alert alert-danger'>Data wisata tidak ditemukan.</div>";
    } else {
        echo "<h3 class='mb-3'>{$wisata['nama']}</h3>";
        echo "<img src='../images/{$wisata['foto']}' class='img-preview mb-3'><br>";
        echo "<p><strong>Alamat:</strong> {$wisata['alamat']}</p>";
        echo "<p><strong>Jenis Wisata:</strong> {$wisata['jenis']}</p>";
        echo "<p><strong>Keterangan:</strong><br>{$wisata['keterangan']}</p>";
        echo "<hr>";

        $kriteriaMap = [1 => 'Jarak', 2 => 'Waktu', 3 => 'Tiket', 4 => 'Transportasi', 5 => 'Fasilitas'];
        $nilai = [];
        $q = $koneksi->query("SELECT * FROM nilai WHERE id_wisata='$id'");
        while ($row = $q->fetch_assoc()) {
            $nilai[$row['id_kriteria']] = $row['nilai'];
        }

        function getLabel($kategori, $bobot) {
            $labels = [
                'Jarak' => [
                    1 => '0–20 km',
                    2 => '21–40 km',
                    3 => '41–60 km',
                    4 => '61–80 km',
                    5 => '81–100 km'
                ],
                'Waktu' => [
                    5 => 'Pagi – Sore',
                    4 => 'Sore – Malam',
                    3 => 'Siang – Sore',
                    2 => '24 Jam',
                    1 => 'Pagi – Siang'
                ],
                'Tiket' => [
                    1 => 'Rp 0–10.000',
                    2 => 'Rp 11.000–20.000',
                    3 => 'Rp 21.000–30.000',
                    4 => 'Rp 31.000–40.000',
                    5 => 'Rp 41.000–50.000'
                ],
                'Transportasi' => [
                    5 => 'Sepeda Motor',
                    4 => 'Mobil Pribadi',
                    3 => 'Angkutan Umum',
                    2 => 'Ojek',
                    1 => 'Delman'
                ],
                'Fasilitas' => [
                    // Fasilitas → tidak pakai mapping angka → tampilkan string langsung
                ]
            ];

            if ($kategori == 'Fasilitas') {
                // Fasilitas disimpan sebagai string → tampilkan langsung
                return $bobot ?: '-';
            } else {
                return $labels[$kategori][$bobot] ?? '-';
            }
        }

        echo "<h5 class='mt-4'>Detail Kriteria:</h5><ul class='list-group'>";
        foreach ($kriteriaMap as $id_k => $nama) {
            $nilai_k = $nilai[$id_k] ?? 0;
            $label = getLabel($nama, $nilai_k);
            echo "<li class='list-group-item'><strong>$nama:</strong> $label</li>";
        }
        echo "</ul>";
    }

    echo "</div>";
} else {
    // jika tidak ada ID, tampilkan proses TOPSIS seperti biasa
    include 'topsis_proses.php';
}
?>

</div>
</body>
</html>
