<?php
require_once('includes/init.php');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check login with role 1 (adjust this according to your authentication logic)
cek_login($role = array(1));

$errors = array();
$sts = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['tambah'])) {
		$id_alternatif = $_POST['id_alternatif'];
		$id_kriteria = $_POST['id_kriteria'];
		$nilai = $_POST['nilai'];

		// Validate input
		if (!$id_kriteria) {
			$errors[] = 'ID kriteria tidak boleh kosong';
		}
		if (!$id_alternatif) {
			$errors[] = 'ID Alternatif tidak boleh kosong';
		}
		if (empty($nilai)) {
			$errors[] = 'Nilai kriteria tidak boleh kosong';
		}

		// If no errors, save data
		if (empty($errors)) {
			$i = 0;
			$success = true;
			foreach ($nilai as $key) {
				$nilai_esc = mysqli_real_escape_string($koneksi, $key);
				$id_kriteria_esc = mysqli_real_escape_string($koneksi, $id_kriteria[$i]);
				$id_alternatif_esc = mysqli_real_escape_string($koneksi, $id_alternatif);

				// Remove id_penilaian from the insert statement as it's auto-incremented
				$sql = "INSERT INTO penilaian (id_alternatif, id_kriteria, nilai) VALUES ('$id_alternatif_esc', '$id_kriteria_esc', '$nilai_esc')";
				$simpan = mysqli_query($koneksi, $sql);
				if (!$simpan) {
					$success = false;
					echo "Error: " . mysqli_error($koneksi);
					break;
				}
				$i++;
			}
			if ($success) {
				$sts[] = 'Data berhasil disimpan';
			} else {
				$sts[] = 'Data gagal disimpan';
			}
		}
	}

	if (isset($_POST['edit'])) {
		$id_alternatif = $_POST['id_alternatif'];
		$id_kriteria = $_POST['id_kriteria'];
		$nilai = $_POST['nilai'];

		// Validate input
		if (!$id_kriteria) {
			$errors[] = 'ID kriteria tidak boleh kosong';
		}
		if (!$id_alternatif) {
			$errors[] = 'ID Alternatif tidak boleh kosong';
		}
		if (empty($nilai)) {
			$errors[] = 'Nilai kriteria tidak boleh kosong';
		}

		// If no errors, update data
		if (empty($errors)) {
			$i = 0;
			mysqli_query($koneksi, "DELETE FROM penilaian WHERE id_alternatif = '$id_alternatif';");
			$success = true;
			foreach ($nilai as $key) {
				$nilai_esc = mysqli_real_escape_string($koneksi, $key);
				$id_kriteria_esc = mysqli_real_escape_string($koneksi, $id_kriteria[$i]);
				$id_alternatif_esc = mysqli_real_escape_string($koneksi, $id_alternatif);

				// Remove id_penilaian from the insert statement as it's auto-incremented
				$sql = "INSERT INTO penilaian (id_alternatif, id_kriteria, nilai) VALUES ('$id_alternatif_esc', '$id_kriteria_esc', '$nilai_esc')";
				$simpan = mysqli_query($koneksi, $sql);
				if (!$simpan) {
					$success = false;
					echo "Error: " . mysqli_error($koneksi);
					break;
				}
				$i++;
			}
			if ($success) {
				$sts[] = 'Data berhasil diupdate';
			} else {
				$sts[] = 'Data gagal diupdate';
			}
		}
	}
}

$page = "Penilaian";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-edit"></i> Data Penilaian</h1>
</div>

<?php if (!empty($sts)) : ?>
	<div class="alert alert-info">
		<?php foreach ($sts as $st) : ?>
			<?= $st; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php if (!empty($errors)) : ?>
	<div class="alert alert-danger">
		<?php foreach ($errors as $error) : ?>
			<?= $error; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Daftar Data Penilaian</h6>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-primary text-white">
					<tr align="center">
						<th width="5%">No</th>
						<th>Alternatif</th>
						<th width="15%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$query = mysqli_query($koneksi, "SELECT * FROM alternatif");
					while ($data = mysqli_fetch_array($query)) :
						$id_alternatif = $data['id_alternatif'];
						$q = mysqli_query($koneksi, "SELECT * FROM penilaian WHERE id_alternatif='$id_alternatif'");
						$cek_tombol = mysqli_num_rows($q);
					?>
						<tr align="center">
							<td><?= $no ?></td>
							<td align="left"><?= $data['alternatif'] ?></td>
							<td>
								<?php if ($cek_tombol == 0) : ?>
									<a data-toggle="modal" href="#set<?= $data['id_alternatif'] ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Input</a>
								<?php else : ?>
									<a data-toggle="modal" href="#edit<?= $data['id_alternatif'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
									<a data-toggle="modal" href="#chart<?= $data['id_alternatif'] ?>" class="btn btn-info btn-sm"><i class="fa fa-chart-bar"></i> Lihat Chart</a>
								<?php endif; ?>
							</td>
						</tr>

						<!-- Modal Tambah Penilaian -->
						<div class="modal fade" id="set<?= $data['id_alternatif'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Input Penilaian</h5>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									</div>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
										<div class="modal-body">
											<?php
											$q2 = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
											while ($d = mysqli_fetch_array($q2)) :
											?>
												<input type="hidden" name="id_alternatif" value="<?= $data['id_alternatif'] ?>">
												<input type="hidden" name="id_kriteria[]" value="<?= $d['id_kriteria'] ?>">
												<div class="form-group">
													<label class="font-weight-bold">(<?= $d['kode_kriteria'] ?>) <?= $d['kriteria'] ?></label>
													<?php if ($d['ada_pilihan'] == 1) : ?>
														<select name="nilai[]" class="form-control" required>
															<option value="">--Pilih--</option>
															<?php
															$pilihan = explode(",", $d['pilihan']);
															foreach ($pilihan as $p) :
															?>
																<option value="<?= $p ?>"><?= $p ?></option>
															<?php endforeach; ?>
														</select>
													<?php else : ?>
														<input type="number" name="nilai[]" value="0" class="form-control" required>
													<?php endif; ?>
												</div>
											<?php endwhile; ?>
										</div>
										<div class="modal-footer">
											<button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
											<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- End Modal Tambah Penilaian -->

						<!-- Modal Edit Penilaian -->
						<div class="modal fade" id="edit<?= $data['id_alternatif'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Edit Penilaian</h5>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									</div>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
										<div class="modal-body">
											<?php
											$q3 = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
											while ($d2 = mysqli_fetch_array($q3)) :
											?>
												<input type="hidden" name="id_alternatif" value="<?= $data['id_alternatif'] ?>">
												<input type="hidden" name="id_kriteria[]" value="<?= $d2['id_kriteria'] ?>">
												<div class="form-group">
													<label class="font-weight-bold">(<?= $d2['kode_kriteria'] ?>) <?= $d2['kriteria'] ?></label>
													<?php if ($d2['ada_pilihan'] == 1) : ?>
														<select name="nilai[]" class="form-control" required>
															<option value="">--Pilih--</option>
															<?php
															$pilihan = explode(",", $d2['pilihan']);
															foreach ($pilihan as $p) :
																$qx = mysqli_query($koneksi, "SELECT * FROM penilaian WHERE id_alternatif='$id_alternatif' AND id_kriteria='$d2[id_kriteria]'");
																$dx = mysqli_fetch_array($qx);
															?>
																<option value="<?= $p ?>" <?= ($p == $dx['nilai']) ? 'selected' : '' ?>><?= $p ?></option>
															<?php endforeach; ?>
														</select>
													<?php else : ?>
														<input type="number" name="nilai[]" value="<?= $dx['nilai'] ?>" class="form-control" required>
													<?php endif; ?>
												</div>
											<?php endwhile; ?>
										</div>
										<div class="modal-footer">
											<button type="submit" name="edit" class="btn btn-primary">Simpan</button>
											<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- End Modal Edit Penilaian -->

						<!-- Modal Chart Penilaian -->
						<div class="modal fade" id="chart<?= $data['id_alternatif'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="myModalLabel"><i class="fa fa-chart-bar"></i> Chart Penyebaran Nilai Kriteria</h5>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									</div>
									<div class="modal-body">
										<canvas id="chartCanvas<?= $data['id_alternatif'] ?>"></canvas>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
									</div>
								</div>
							</div>
						</div>
						<!-- End Modal Chart Penilaian -->

					<?php
						$no++;
					endwhile;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
require_once('template/footer.php');
?>

<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Generate Charts -->
<script>
	<?php
	$query = mysqli_query($koneksi, "SELECT * FROM alternatif");
	while ($data = mysqli_fetch_array($query)) {
		$id_alternatif = $data['id_alternatif'];
		$chartData = [];
		$chartLabels = [];
		$q = mysqli_query($koneksi, "SELECT kriteria.kriteria, penilaian.nilai FROM penilaian JOIN kriteria ON penilaian.id_kriteria = kriteria.id_kriteria WHERE penilaian.id_alternatif='$id_alternatif'");
		while ($d = mysqli_fetch_array($q)) {
			$chartLabels[] = $d['kriteria'];
			$chartData[] = $d['nilai'];
		}
	?>
		var ctx = document.getElementById('chartCanvas<?= $id_alternatif ?>').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?= json_encode($chartLabels) ?>,
				datasets: [{
					label: 'Nilai',
					data: <?= json_encode($chartData) ?>,
					backgroundColor: 'rgba(54, 162, 235, 0.2)',
					borderColor: 'rgba(54, 162, 235, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	<?php
	}
	?>
</script>

<?php
require_once('template/footer.php');
?>