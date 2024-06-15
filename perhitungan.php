<?php
require_once('includes/init.php');

$user_role = get_role();
if ($user_role == 'admin') {

	$page = "Perhitungan";
	require_once('template/header.php');

	// Clear the previous calculation results
	mysqli_query($koneksi, "TRUNCATE TABLE hasil;");

	// Fetch criteria data
	$kriteria = array();
	$q1 = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
	while ($krit = mysqli_fetch_array($q1)) {
		$kriteria[$krit['id_kriteria']] = $krit;
	}

	// Fetch alternatives data
	$alternatif = array();
	$q2 = mysqli_query($koneksi, "SELECT * FROM alternatif");
	while ($alt = mysqli_fetch_array($q2)) {
		$alternatif[$alt['id_alternatif']] = $alt;
	}

	// Initialize min and max arrays
	$min_max = array();
	foreach ($kriteria as $key) {
		$q3 = mysqli_query($koneksi, "SELECT MAX(nilai) as max, MIN(nilai) as min FROM penilaian WHERE id_kriteria='$key[id_kriteria]'");
		$min_max[$key['id_kriteria']] = mysqli_fetch_array($q3);
	}
?>

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-calculator"></i> Data Perhitungan</h1>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Bobot Preferensi (W)</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<?php foreach ($kriteria as $key) : ?>
								<th><?= $key['kode_kriteria'] ?> (<?= $key['type'] ?>)</th>
							<?php endforeach ?>
						</tr>
					</thead>
					<tbody>
						<tr align="center">
							<?php foreach ($kriteria as $key) : ?>
								<td><?= $key['bobot'] ?></td>
							<?php endforeach ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Matrix Keputusan (X)</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<th width="5%" rowspan="2">No</th>
							<th>Nama Alternatif</th>
							<?php foreach ($kriteria as $key) : ?>
								<th><?= $key['kode_kriteria'] ?></th>
							<?php endforeach ?>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($alternatif as $alt) : ?>
							<tr align="center">
								<td><?= $no; ?></td>
								<td align="left"><?= $alt['alternatif'] ?></td>
								<?php foreach ($kriteria as $key) : ?>
									<td>
										<?php
										$q4 = mysqli_query($koneksi, "SELECT nilai FROM penilaian WHERE id_alternatif='$alt[id_alternatif]' AND id_kriteria='$key[id_kriteria]'");
										$data = mysqli_fetch_array($q4);
										echo isset($data['nilai']) ? $data['nilai'] : '-';
										?>
									</td>
								<?php endforeach ?>
							</tr>
						<?php
							$no++;
						endforeach
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Matriks Ternormalisasi (R)</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<th width="5%" rowspan="2">No</th>
							<th>Nama Alternatif</th>
							<?php foreach ($kriteria as $key) : ?>
								<th><?= $key['kode_kriteria'] ?></th>
							<?php endforeach ?>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($alternatif as $alt) : ?>
							<tr align="center">
								<td><?= $no; ?></td>
								<td align="left"><?= $alt['alternatif'] ?></td>
								<?php foreach ($kriteria as $key) : ?>
									<td>
										<?php
										$q4 = mysqli_query($koneksi, "SELECT nilai FROM penilaian WHERE id_alternatif='$alt[id_alternatif]' AND id_kriteria='$key[id_kriteria]'");
										$dt1 = mysqli_fetch_array($q4);

										if ($key['type'] == "Benefit") {
											echo round(($dt1['nilai'] / $min_max[$key['id_kriteria']]['max']), 2);
										} else {
											echo round(($min_max[$key['id_kriteria']]['min'] / $dt1['nilai']), 2);
										}
										?>
									</td>
								<?php endforeach ?>
							</tr>
						<?php
							$no++;
						endforeach
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Perhitungan Nilai Preferensi (V)</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<th width="5%">No</th>
							<th>Nama Alternatif</th>
							<th>Perhitungan</th>
							<th>Nilai</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($alternatif as $alt) : ?>
							<tr align="center">
								<td><?= $no; ?></td>
								<td align="left"><?= $alt['alternatif'] ?></td>
								<td>
									SUM
									<?php
									$nilai_v = 0;
									foreach ($kriteria as $key) :
										$bobot = $key['bobot'];
										$q4 = mysqli_query($koneksi, "SELECT nilai FROM penilaian WHERE id_alternatif='$alt[id_alternatif]' AND id_kriteria='$key[id_kriteria]'");
										$dt1 = mysqli_fetch_array($q4);

										if ($key['type'] == "Benefit") {
											$nilai_r = round(($dt1['nilai'] / $min_max[$key['id_kriteria']]['max']), 2);
										} else {
											$nilai_r = round(($min_max[$key['id_kriteria']]['min'] / $dt1['nilai']), 2);
										}
										$nilai_penjumlahan = $bobot * $nilai_r;
										$nilai_v += $nilai_penjumlahan;
										echo "(" . $bobot . "x" . $nilai_r . ") ";
									endforeach ?>
								</td>
								<td>
									<?php
									echo $nilai_v;
									$kode = uniqid('kode-', true);
									mysqli_query($koneksi, "INSERT INTO hasil (kode_hasil, id_alternatif, nilai) VALUES ('$kode', '$alt[id_alternatif]', '$nilai_v')");
									?>
								</td>
							</tr>
						<?php
							$no++;
						endforeach
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<?php
	require_once('template/footer.php');
} else {
	header('Location: login.php');
}
?>