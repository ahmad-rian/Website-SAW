<?php
require_once('includes/init.php');

$user_role = get_role();
if ($user_role == 'admin' || $user_role == 'user') {

	$page = "Hasil";
	require_once('template/header.php');
?>

	<style>
		@media print {
			body * {
				visibility: hidden;
			}

			.printable-area,
			.printable-area * {
				visibility: visible;
			}

			.printable-area {
				position: absolute;
				left: 0;
				top: 0;
			}

			.chart-container {
				display: block !important;
				position: static !important;
			}
		}
	</style>

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Data Hasil Akhir</h1>
		<a href="#" onclick="printPage();" class="btn btn-primary"> <i class="fa fa-print"></i> Cetak Data </a>
	</div>

	<div class="card shadow mb-4 printable-area">
		<!-- /.card-header -->
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Hasil Akhir Perankingan</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr align="center">
							<th>Nama Alternatif</th>
							<th>Nilai</th>
							<th width="15%">Rank</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 0;
						$alternatif_nama = [];
						$nilai = [];
						$query = mysqli_query($koneksi, "SELECT * FROM hasil JOIN alternatif ON hasil.id_alternatif=alternatif.id_alternatif ORDER BY hasil.nilai DESC");
						while ($data = mysqli_fetch_array($query)) {
							$no++;
							$alternatif_nama[] = $data['alternatif'];
							$nilai[] = $data['nilai'];
						?>
							<tr align="center">
								<td align="left"><?= $data['alternatif'] ?></td>
								<td><?= $data['nilai'] ?></td>
								<td><?= $no; ?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>

			<!-- Add a container for Chart.js -->
			<div class="mt-4 chart-container">
				<canvas id="rankingChart" width="120px" height="30px"></canvas>
			</div>
		</div>
	</div>

	<!-- Include Chart.js library -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		// Prepare the data for Chart.js
		var ctx = document.getElementById('rankingChart').getContext('2d');
		var rankingChart = new Chart(ctx, {
			type: 'bar', // Change this to 'bar' for histogram
			data: {
				labels: <?php echo json_encode($alternatif_nama); ?>,
				datasets: [{
					label: 'Nilai Preferensi',
					data: <?php echo json_encode($nilai); ?>,
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

		// Function to print the page
		function printPage() {
			window.print();
		}
	</script>

<?php
	require_once('template/footer.php');
} else {
	header('Location: login.php');
}
?>