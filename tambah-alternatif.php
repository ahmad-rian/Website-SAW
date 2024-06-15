<?php
require_once('includes/init.php');
cek_login($role = array(1));

$errors = array();
$nama = '';

if (isset($_POST['submit'])) {
	$nama = trim($_POST['nama']);

	// Validasi input nama
	if (empty($nama)) {
		$errors[] = 'Alternatif tidak boleh kosong';
	}

	// Jika tidak ada error, lakukan penyimpanan data
	if (empty($errors)) {
		$query = "INSERT INTO alternatif (alternatif) VALUES ('$nama')";
		$result = mysqli_query($koneksi, $query);

		if ($result) {
			// Redirect dengan status sukses
			redirect_to('list-alternatif.php?status=sukses-baru');
		} else {
			$errors[] = 'Data gagal disimpan';
		}
	}
}

$page = "Alternatif";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Data Alternatif</h1>
	<a href="list-alternatif.php" class="btn btn-secondary btn-icon-split">
		<span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
		<span class="text">Kembali</span>
	</a>
</div>

<?php if (!empty($errors)) : ?>
	<div class="alert alert-danger">
		<?php foreach ($errors as $error) : ?>
			<p><?php echo htmlspecialchars($error); ?></p>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<form action="tambah-alternatif.php" method="post">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-fw fa-plus"></i> Tambah Data Alternatif</h6>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Nama Alternatif</label>
					<input autocomplete="off" type="text" name="nama" required value="<?php echo htmlspecialchars($nama); ?>" class="form-control" />
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
			<button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
		</div>
	</div>
</form>

<?php
require_once('template/footer.php');
?>