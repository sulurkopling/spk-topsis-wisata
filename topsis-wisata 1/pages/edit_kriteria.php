
<?php include '../config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Nilai Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e3f2fd, #ffffff);
        }
        .container {
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">⚙️ Input Nilai Kriteria Wisata</h2>
<div class="d-flex justify-content-between mb-3">
    <div>
        <a href="../index.php" class="btn btn-secondary btn-fixed">Home</a>
        <a href="edit_wisata.php" class="btn btn-secondary btn-fixed">&larr; Kembali</a>
    </div>
    <div>
        <a href="hasil_pemilihan.php" class="btn btn-primary btn-fixed">Lanjut &rarr;</a>
    </div>
</div>


      <div class="card shadow p-4">
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Pilih Wisata</label>
                <select name="id_wisata" class="form-select" required>
                    <option value="">-- Pilih Wisata --</option>
                    <?php
                    $wisata = $koneksi->query("SELECT * FROM wisata");
                    while ($w = $wisata->fetch_assoc()) {
                        echo "<option value='{$w['id_wisata']}'>{$w['nama']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jarak</label>
                <select name="jarak" class="form-select" required>
                    <option value="1">0–20 km</option>
                    <option value="2">21–40 km</option>
                    <option value="3">41–60 km</option>
                    <option value="4">61–80 km</option>
                    <option value="5">81–100 km</option>
                </select>

            </div>

            <div class="mb-3">
                <label class="form-label">Waktu</label>
                <select name="waktu" class="form-select" required>
                    <option value="5">Pagi – Sore</option>
                    <option value="4">Sore – Malam</option>
                    <option value="3">Siang – Sore</option>
                    <option value="2">24 Jam</option>
                    <option value="1">Pagi – Siang</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tiket</label>
                <select name="tiket" class="form-select" required>
                    <option value="1">Rp 0–10.000</option>
                    <option value="2">Rp 11.000–20.000</option>
                    <option value="3">Rp 21.000–30.000</option>
                    <option value="4">Rp 31.000–40.000</option>
                    <option value="5">Rp 41.000–50.000</option>
                </select>
  
            </div>

            <div class="mb-3">
                <label class="form-label">Transportasi</label>
                <select name="transportasi" class="form-select" required>
                    <option value="5">Sepeda Motor</option>
                    <option value="4">Mobil Pribadi</option>
                    <option value="3">Angkutan Umum</option>
                    <option value="2">Ojek</option>
                    <option value="1">Delman</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fasilitas (boleh lebih dari satu)</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fasilitas[]" value="5" id="f1">
                    <label class="form-check-label" for="f1">Parkir</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fasilitas[]" value="4" id="f2">
                    <label class="form-check-label" for="f2">Toilet</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fasilitas[]" value="3" id="f3">
                    <label class="form-check-label" for="f3">Mushala</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fasilitas[]" value="2" id="f4">
                    <label class="form-check-label" for="f4">Penginapan</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fasilitas[]" value="1" id="f5">
                    <label class="form-check-label" for="f5">Tempat Makan</label>
                </div>
            </div>

            <button type="submit" name="simpan" class="btn btn-success">Simpan Nilai</button>
        </form>
    </div>
</div>

<?php
if (isset($_POST['simpan'])) {
    $id = $_POST['id_wisata'];
    $jarak = $_POST['jarak'];
    $waktu = $_POST['waktu'];
    $tiket = $_POST['tiket'];
    $transportasi = $_POST['transportasi'];
    $fasilitas = $_POST['fasilitas'] ?? [];
    $fasilitas_total = array_sum($fasilitas);

    $koneksi->query("DELETE FROM nilai WHERE id_wisata='$id'");
    $koneksi->query("INSERT INTO nilai (id_wisata, id_kriteria, nilai) VALUES ('$id', 1, '$jarak')");
    $koneksi->query("INSERT INTO nilai (id_wisata, id_kriteria, nilai) VALUES ('$id', 2, '$waktu')");
    $koneksi->query("INSERT INTO nilai (id_wisata, id_kriteria, nilai) VALUES ('$id', 3, '$tiket')");
    $koneksi->query("INSERT INTO nilai (id_wisata, id_kriteria, nilai) VALUES ('$id', 4, '$transportasi')");
    $koneksi->query("INSERT INTO nilai (id_wisata, id_kriteria, nilai) VALUES ('$id', 5, '$fasilitas_total')");

    echo "<script>alert('Nilai kriteria disimpan!'); window.location='edit_kriteria.php';</script>";
}
?>
</body>
</html>
