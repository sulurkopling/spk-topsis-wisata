<?php include '../config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0f7fa, #fff);
        }
        .container {
            margin-top: 40px;
        }
        img.thumb {
            width: 80px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">📍 Kelola Tempat Wisata</h2>
<div class="d-flex justify-content-between mb-3">
    <div>
        <a href="../index.php" class="btn btn-secondary btn-fixed">&larr;Kembali</a>
    </div>
    <div>
        <a href="edit_kriteria.php" class="btn btn-primary btn-fixed">Lanjut &rarr;</a>
    </div>
</div>

    <?php
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $row = $koneksi->query("SELECT * FROM wisata WHERE id_wisata='$id'")->fetch_assoc();
    ?>
    <div class="card p-4 shadow">
        <h5>Edit Wisata</h5>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id_wisata'] ?>">
            <div class="mb-2">
                <label>Nama Wisata:</label>
                <input type="text" name="nama" value="<?= $row['nama'] ?>" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Jenis:</label>
                <select name="jenis" class="form-select" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Alam" <?= $row['jenis'] == 'Alam' ? 'selected' : '' ?>>Alam</option>
                    <option value="Budaya" <?= $row['jenis'] == 'Budaya' ? 'selected' : '' ?>>Budaya</option>
                    <option value="Sejarah" <?= $row['jenis'] == 'Sejarah' ? 'selected' : '' ?>>Sejarah</option>
                </select>
            </div>
            <div class="mb-2">
                <label>Alamat:</label>
                <input type="text" name="alamat" value="<?= $row['alamat'] ?>" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Keterangan:</label>
                <textarea name="keterangan" class="form-control"><?= $row['keterangan'] ?></textarea>
            </div>
            <div class="mb-2">
                <label>Ganti Foto:</label>
                <input type="file" name="foto" class="form-control">
            </div>
            <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
            <a href="edit_wisata.php" class="btn btn-warning">Batal</a>
        </form>
    </div>
    <hr>
    <?php } else { ?>

    <div class="card p-4 shadow">
        <h5>Tambah Wisata Baru</h5>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-2">
                <label>Nama Wisata:</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Jenis:</label>
                <select name="jenis" class="form-select" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Alam">Alam</option>
                    <option value="Budaya">Budaya</option>
                    <option value="Sejarah">Sejarah</option>
                </select>
            </div>
            <div class="mb-2">
                <label>Alamat:</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Keterangan:</label>
                <textarea name="keterangan" class="form-control"></textarea>
            </div>
            <div class="mb-2">
                <label>Upload Foto:</label>
                <input type="file" name="foto" class="form-control" required>
            </div>
            <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
        </form>
    </div>
    <hr>
    <?php } ?>

    <div class="card p-3 shadow">
        <h5>Daftar Wisata</h5>
        <table class="table table-bordered table-hover mt-2">
            <thead class="table-primary">
                <tr><th>No</th><th>Foto</th><th>Nama</th><th>Jenis</th><th>Alamat</th><th>Keterangan</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $data = $koneksi->query("SELECT * FROM wisata");
            while ($row = $data->fetch_assoc()) {
                echo "<tr>
                    <td>$no</td>
                    <td><img src='../images/{$row['foto']}' class='thumb'></td>
                    <td>{$row['nama']}</td>
                    <td>{$row['jenis']}</td>
                    <td>{$row['alamat']}</td>
                    <td>{$row['keterangan']}</td>
                    <td>
                        <a href='?edit={$row['id_wisata']}' class='btn btn-sm btn-warning'>Edit</a>
                        <a href='?hapus={$row['id_wisata']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Hapus data ini?')\">Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $alamat = $_POST['alamat'];
    $keterangan = $_POST['keterangan'];
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp, "../images/$foto");
    $koneksi->query("INSERT INTO wisata (nama, jenis, alamat, keterangan, foto) VALUES ('$nama','$jenis','$alamat','$keterangan','$foto')");
    echo "<script>alert('Wisata ditambahkan!'); window.location='edit_wisata.php';</script>";
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $alamat = $_POST['alamat'];
    $keterangan = $_POST['keterangan'];
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "../images/$foto");
        $koneksi->query("UPDATE wisata SET nama='$nama', jenis='$jenis', alamat='$alamat', keterangan='$keterangan', foto='$foto' WHERE id_wisata='$id'");
    } else {
        $koneksi->query("UPDATE wisata SET nama='$nama', jenis='$jenis', alamat='$alamat', keterangan='$keterangan' WHERE id_wisata='$id'");
    }
    echo "<script>alert('Wisata diperbarui!'); window.location='edit_wisata.php';</script>";
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $koneksi->query("DELETE FROM wisata WHERE id_wisata='$id'");
    echo "<script>alert('Data dihapus!'); window.location='edit_wisata.php';</script>";
}
?>
</body>
</html>
