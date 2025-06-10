
<h2 class="text-center mb-4">🧮 Perhitungan Metode TOPSIS Lengkap</h2>
<div class="d-flex justify-content-between mb-3">
    <a href="hasil_pemilihan.php" class="btn btn-secondary">← Kembali</a>
    <a href="../index.php" class="btn btn-primary">Home</a>
</div>

<div class='card shadow p-4'>
<?php
$alternatif = [];
$kriteria = [];
$nilai = [];

$q1 = $koneksi->query("SELECT * FROM wisata");
while ($row = $q1->fetch_assoc()) $alternatif[$row['id_wisata']] = $row['nama'];

$q2 = $koneksi->query("SELECT * FROM kriteria");
while ($row = $q2->fetch_assoc()) $kriteria[$row['id_kriteria']] = $row;

$q3 = $koneksi->query("SELECT * FROM nilai");
foreach ($q3 as $n) $nilai[$n['id_wisata']][$n['id_kriteria']] = $n['nilai'];

echo "<h5>1. Matriks Keputusan</h5><table class='table table-bordered'><tr><th>Wisata</th>";
foreach ($kriteria as $k) echo "<th>{$k['kode']}</th>";
echo "</tr>";
foreach ($alternatif as $id_a => $nama) {
    echo "<tr><td>$nama</td>";
    foreach ($kriteria as $id_k => $k) {
        $v = $nilai[$id_a][$id_k] ?? 0;
        echo "<td>$v</td>";
    }
    echo "</tr>";
}
echo "</table>";


$normal = []; $akar = [];
foreach ($kriteria as $id_k => $k) {
    $total = 0;
    foreach ($alternatif as $id_a => $nama) $total += pow($nilai[$id_a][$id_k] ?? 0, 2);
    $akar[$id_k] = sqrt($total);
}
foreach ($alternatif as $id_a => $nama)
    foreach ($kriteria as $id_k => $k)
        $normal[$id_a][$id_k] = ($nilai[$id_a][$id_k] ?? 0) / ($akar[$id_k] ?: 1);

echo "<h5>2. Matriks Ternormalisasi</h5><table class='table table-bordered'><tr><th>Wisata</th>";
foreach ($kriteria as $k) echo "<th>{$k['kode']}</th>";
echo "</tr>";
foreach ($alternatif as $id_a => $nama) {
    echo "<tr><td>$nama</td>";
    foreach ($kriteria as $id_k => $k)
        echo "<td>" . round($normal[$id_a][$id_k], 4) . "</td>";
    echo "</tr>";
}
echo "</table>";

$terbobot = [];
foreach ($alternatif as $id_a => $nama)
    foreach ($kriteria as $id_k => $k)
        $terbobot[$id_a][$id_k] = $normal[$id_a][$id_k] * $k['bobot'];

echo "<h5>3. Matriks Normalisasi Terbobot</h5><table class='table table-bordered'><tr><th>Wisata</th>";
foreach ($kriteria as $k) echo "<th>{$k['kode']}</th>";
echo "</tr>";
foreach ($alternatif as $id_a => $nama) {
    echo "<tr><td>$nama</td>";
    foreach ($kriteria as $id_k => $k)
        echo "<td>" . round($terbobot[$id_a][$id_k], 4) . "</td>";
    echo "</tr>";
}
echo "</table>";

$ideal = []; $anti = [];
foreach ($kriteria as $id_k => $k) {
    $vals = array_column($terbobot, $id_k);
    $ideal[$id_k] = ($k['atribut'] == 'benefit') ? max($vals) : min($vals);
    $anti[$id_k]  = ($k['atribut'] == 'benefit') ? min($vals) : max($vals);
}

echo "<h5>4. Solusi Ideal Positif & Negatif</h5><table class='table table-bordered'><tr><th>Kriteria</th>";
foreach ($kriteria as $k) echo "<th>{$k['kode']}</th>";
echo "</tr><tr><td>Ideal (+)</td>";
foreach ($ideal as $v) echo "<td>" . round($v, 4) . "</td>";
echo "</tr><tr><td>Anti Ideal (-)</td>";
foreach ($anti as $v) echo "<td>" . round($v, 4) . "</td>";
echo "</tr></table>";

$Dplus = []; $Dmin = [];
echo "<h5>5. Jarak ke Ideal (+) dan (-)</h5><table class='table table-bordered'><tr><th>Wisata</th><th>D+</th><th>D-</th></tr>";
foreach ($alternatif as $id_a => $nama) {
    $dp = 0; $dm = 0;
    foreach ($kriteria as $id_k => $k) {
        $dp += pow($terbobot[$id_a][$id_k] - $ideal[$id_k], 2);
        $dm += pow($terbobot[$id_a][$id_k] - $anti[$id_k], 2);
    }
    $Dplus[$id_a] = sqrt($dp);
    $Dmin[$id_a] = sqrt($dm);
    echo "<tr><td>$nama</td><td>" . round($Dplus[$id_a], 4) . "</td><td>" . round($Dmin[$id_a], 4) . "</td></tr>";
}
echo "</table>";

$preferensi = [];
echo "<h5>6. Nilai Preferensi</h5><table class='table table-bordered'><tr><th>Wisata</th><th>Nilai</th></tr>";
foreach ($alternatif as $id_a => $nama) {
    $preferensi[$id_a] = $Dmin[$id_a] / (($Dmin[$id_a] + $Dplus[$id_a]) ?: 1);
    echo "<tr><td>$nama</td><td>" . round($preferensi[$id_a], 4) . "</td></tr>";
}
echo "</table>";

arsort($preferensi);
echo "<h5>7. Ranking</h5><table class='table table-bordered'><tr><th>Rank</th><th>Nama</th><th>Nilai</th></tr>";
$rank = 1;
foreach ($preferensi as $id => $val) {
    echo "<tr><td>$rank</td><td>{$alternatif[$id]}</td><td>" . round($val, 4) . "</td></tr>";
    $rank++;
}
echo "</table>";
?>
</div>
