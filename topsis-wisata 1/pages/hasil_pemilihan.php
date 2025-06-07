<?php include '../config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Rekomendasi Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #fff1eb, #ace0f9);
        }
        .container {
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">📊 Hasil Rekomendasi Tempat Wisata (TOPSIS)</h2>
    <div class="d-flex justify-content-between mb-3">
    <div>
        <a href="../index.php" class="btn btn-secondary btn-fixed">Home</a>
        <a href="edit_kriteria.php" class="btn btn-secondary btn-fixed">&larr; Kembali</a>
    </div>
    <div>
        <a href="topsis.php" class="btn btn-primary btn-fixed">Lihat hasil perhitungan &rarr;</a>
    </div>
</div>

    <div class="card shadow p-4">
        <table class="table table-bordered table-hover">
            <thead class="table-info">
                <tr><th>No</th><th>Nama Wisata</th><th>Nilai Akhir</th><th>Pilihan</th></tr>
            </thead>
            <tbody>
            <?php
            $alternatif = [];
            $kriteria = [];
            $nilai = [];

            $q1 = $koneksi->query("SELECT * FROM wisata");
            while ($row = $q1->fetch_assoc()) {
                $alternatif[$row['id_wisata']] = $row['nama'];
            }

            $q2 = $koneksi->query("SELECT * FROM kriteria");
            while ($row = $q2->fetch_assoc()) {
                $kriteria[$row['id_kriteria']] = $row;
            }

            $q3 = $koneksi->query("SELECT * FROM nilai");
            foreach ($q3 as $n) {
                $nilai[$n['id_wisata']][$n['id_kriteria']] = $n['nilai'];
            }

            $normal = []; $akar = [];
            foreach ($kriteria as $id_k => $k) {
                $total = 0;
                foreach ($alternatif as $id_a => $nama) {
                    $total += pow($nilai[$id_a][$id_k] ?? 0, 2);
                }
                $akar[$id_k] = sqrt($total);
            }

            foreach ($alternatif as $id_a => $nama) {
                foreach ($kriteria as $id_k => $k) {
                    $normal[$id_a][$id_k] = ($nilai[$id_a][$id_k] ?? 0) / ($akar[$id_k] ?: 1);
                }
            }

            $terbobot = [];
            foreach ($alternatif as $id_a => $nama) {
                foreach ($kriteria as $id_k => $k) {
                    $terbobot[$id_a][$id_k] = $normal[$id_a][$id_k] * $k['bobot'];
                }
            }

            $ideal = []; $anti = [];
            foreach ($kriteria as $id_k => $k) {
                $vals = array_column($terbobot, $id_k);
                $ideal[$id_k] = ($k['atribut'] == 'benefit') ? max($vals) : min($vals);
                $anti[$id_k]  = ($k['atribut'] == 'benefit') ? min($vals) : max($vals);
            }

            $preferensi = [];
            foreach ($alternatif as $id_a => $nama) {
                $dp = 0; $dm = 0;
                foreach ($kriteria as $id_k => $k) {
                    $dp += pow($terbobot[$id_a][$id_k] - $ideal[$id_k], 2);
                    $dm += pow($terbobot[$id_a][$id_k] - $anti[$id_k], 2);
                }
                $dplus = sqrt($dp);
                $dmin = sqrt($dm);
                $preferensi[$id_a] = $dmin / (($dmin + $dplus) ?: 1);
            }

            arsort($preferensi);
            $no = 1;
            foreach ($preferensi as $id => $v) {
                echo "<tr>
                    <td>$no</td>
                    <td>{$alternatif[$id]}</td>
                    <td>" . round($v, 4) . "</td>
                    <td><a href='topsis.php?id=$id' class='btn btn-sm btn-info'>Lihat</a></td>
                </tr>";
                $no++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
