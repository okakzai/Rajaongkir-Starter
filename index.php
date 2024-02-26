<?php
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Jakarta');

$api_key = file_get_contents("apikey.txt");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Cek Ongkir Menggunakan API Rajaongkir Starter">
	<meta name="author" content="Maju AppZ">
	<title>Rajaongkir Starter</title>
	<link rel="icon" href="img/favicon.png" sizes="32x32">
	<script src="https://kit.fontawesome.com/c00efe6860.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css">
	<link href="autocomplete/jquery-ui-min.css" rel="stylesheet" type="text/css" />
	<link href="css/custom.css" rel="stylesheet" type="text/css">
</head>

<body class="bg-dark">
	<div class="container" style="margin-bottom:10px;margin-top:10px;">
		<div class="row">
			<div class="col-12">
				<div class="card my-4">
					<div class="card-body">
						<div class="row">
							<div class="col-md-3 col-12 mb-1">
								<input id="asal" class="form-control" placeholder="Ketik Asal Pengiriman">
								<input id="asalkota" class="form-control" type="hidden">
							</div>
							<div class="col-md-3 col-12 mb-1">
								<input id="tujuan" class="form-control" placeholder="Ketik Tujuan Pengiriman">
								<input id="tujuankota" class="form-control" type="hidden">
							</div>
							<div class="col-md-3 col-12 mb-1">
								<input id="berat" type="number" min="1" class="form-control" placeholder="Ketik Berat (Gram)">
							</div>
							<div class="col-md-3 col-12 mb-1 py-1">
								<div class="d-flex align-items-center justify-content-end">
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="kurir" id="kurir1" value="jne" checked>
										<label class="form-check-label text-muted small" for="kurir1">JNE</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="kurir" id="kurir2" value="pos">
										<label class="form-check-label text-muted small" for="kurir2">POS</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="kurir" id="kurir2" value="tiki">
										<label class="form-check-label text-muted small" for="kurir2">TIKI</label>
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex align-items-center justify-content-end mt-3">
							<button id="cek" type="submit" class="btn btn-danger text-white">
								Cek Ongkir <i class="fa-solid fa-magnifying-glass"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card my-4">
					<div class="card-body">
						<div id="loading" class="d-none"><img src="img/ajax-loader.gif"></div>
						<div id="ket" class="mb-3"></div>
						<table id="ongkos" class="table table-striped"></table>
					</div>
				</div>
			</div>

		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="autocomplete/jquery-ui.min.js"></script>
	<script src="autocomplete/jquery.ui.autocomplete.scroll.min.js"></script>
	<script src="js/custom.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#loading").removeClass("d-block");
			$("#loading").addClass("d-none");
			$("#ongkos").hide();
			$("#ket").hide();

			$('#asal').focus(function() {
				$("#loading").removeClass("d-block");
				$("#loading").addClass("d-none");
				$("#ongkos").hide();
				$("#ket").hide();
			});

			$('#tujuan').focus(function() {
				$("#loading").removeClass("d-block");
				$("#loading").addClass("d-none");
				$("#ongkos").hide();
				$("#ket").hide();
			});

			$('#asal').autocomplete({
				maxShowItems: 3,
				minLength: 2,
				delay: 100,
				select: function(event, ui) {
					$("#asal").val(ui.item.label);
					$("#asalkota").val(ui.item.value);
					return false;
				},
				source: "php/kota.php"
			});

			$('#tujuan').autocomplete({
				maxShowItems: 3,
				minLength: 2,
				delay: 100,
				select: function(event, ui) {
					$("#tujuan").val(ui.item.label);
					$("#tujuankota").val(ui.item.value);
					return false;
				},
				source: "php/kota.php"
			});


			$("#cek").click(function() {
				$("#ongkos_wrapper").remove();
				$("#ket").empty();
				$("#loading").addClass("d-block");
				$("#loading").after('<div id="ket" class="mb-3"></div>');
				$("#ket").after('<table id="ongkos" class="table table-striped"></table>');

				var asal = $('#asalkota').val();
				var tujuan = $('#tujuankota').val();
				var berat = $('#berat').val();
				var kurir = $('input[name=kurir]:checked').val();

				if (asal === '') {
					$("#loading").removeClass("d-block");
					$("#loading").addClass("d-none");
					Swal.fire({
						title: "Kota Asal Pengiriman",
						text: "Tidak boleh kosong!",
						icon: "error"
					});
				} else if (tujuan === '') {
					$("#loading").removeClass("d-block");
					$("#loading").addClass("d-none");
					Swal.fire({
						title: "Kota Tujuan Pengiriman",
						text: "Tidak boleh kosong!",
						icon: "error"
					});
				} else if (berat === '') {
					$("#loading").removeClass("d-block");
					$("#loading").addClass("d-none");
					Swal.fire({
						title: "Berat Kiriman",
						text: "Tidak boleh kosong dan harus berupa angka tanpa koma!",
						icon: "error"
					});
				} else if (berat <= 0) {
					$("#loading").removeClass("d-block");
					$("#loading").addClass("d-none");
					Swal.fire({
						title: "Berat Kiriman",
						text: "Harus lebih besar dari nol!",
						icon: "error"
					});
				} else {
					$.ajax({
						type: 'POST',
						url: 'php/cek_ongkir.php',
						data: {
							'tujuan': tujuan,
							'asal': asal,
							'berat': berat,
							'kurir': kurir
						},
						success: function(resp) {
							$("#loading").removeClass("d-block");
							$("#loading").addClass("d-none");
							const data = resp.split('^');
							if (data.length > 1) {
								Swal.fire({
									title: "cURL Error",
									text: data[1],
									icon: "error"
								});
							} else {
								var obj = $.parseJSON(resp);
								var status = obj['rajaongkir'].status;
								if (status.code == 400) {
									Swal.fire({
										title: "Rajaongkir Error",
										text: status.description,
										icon: "error"
									});
								} else {
									var hasil = obj['rajaongkir'].results;
									var n = hasil.length;
									document.title = 'Ongkir dari ' + obj['rajaongkir'].origin_details.type + ' ' + obj['rajaongkir'].origin_details.city_name + ', ' + obj['rajaongkir'].origin_details.province + ' ke ' + obj['rajaongkir'].destination_details.type + ' ' + obj['rajaongkir'].destination_details.city_name + ', ' + obj['rajaongkir'].destination_details.province + ' @ ' + seribu(obj['rajaongkir'].query.weight) + ' gram';
									$("#ket").show();
									$("#ket").html(
										'<div class="text-center">Asal: <span class="badge badge-primary">' + obj['rajaongkir'].origin_details.type + ' ' + obj['rajaongkir'].origin_details.city_name + ', ' + obj['rajaongkir'].origin_details.province + '</span></div>' +
										'<div class="text-center">Tujuan: <span class="badge badge-primary">' + obj['rajaongkir'].destination_details.type + ' ' + obj['rajaongkir'].destination_details.city_name + ', ' + obj['rajaongkir'].destination_details.province + '</span></div>' +
										'<div class="text-center">Berat: <span class="badge badge-primary">' + seribu(obj['rajaongkir'].query.weight) + '</span> Gram</div>'
									);
									$("#ongkos").html('<thead class="bg-primary">' +
										'<tr><th class="text-left">Kurir</th><th class="text-center">Layanan</th><th class="text-center">Sampai (Hari)</th><th style="text-align:right;">Ongkir (Rp)</th></tr></thead>' +
										'<tbody>');
									for (i = 0; i < n; i++) {
										if (obj['rajaongkir'].results[i].costs.length > 0) {
											var m = obj['rajaongkir'].results[i].costs.length;
											for (j = 0; j < m; j++) {
												$("#ongkos").append('<tr>' +
													'<td class="text-left">' +
													'<span class="text-uppercase">' +
													obj['rajaongkir'].results[i].code + '</span> (' + obj['rajaongkir'].results[i].name + ')' +
													'</td>' +
													'<td class="text-center">' +
													'<span class="text-uppercase">' +
													obj['rajaongkir'].results[i].costs[j].service + '</span> (' + obj['rajaongkir'].results[i].costs[j].description + ')' +
													'</td>' +
													'</td>' +
													'<td class="text-center">' +
													obj['rajaongkir'].results[i].costs[j].cost[0].etd +
													'</td>' +
													'</td>' +
													'<td class="text-center">' +
													seribu(obj['rajaongkir'].results[i].costs[j].cost[0].value) + ',00' +
													'</td>' +
													'</tr>');
											}
										}
									}
									$("#ongkos").append('</tbody>');
									$('#asal').val('');
									$('#asalkota').val('');
									$('#tujuan').val('');
									$('#tujuankota').val('');
									$('#berat').val('');
									$("#ongkos").DataTable({
										responsive: true,
										dom: 'Bfrtip',
										buttons: [{
												extend: 'excelHtml5'
											},
											{
												extend: 'pdfHtml5'
											}
										]
									});
								}
							}
						}
					});
				}
			});
		});
	</script>
</body>

</html>