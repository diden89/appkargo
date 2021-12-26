/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/transaksi/tagihan_pembayaran.js
 */

const tagihanPembayaran = {
	selectedData: '',
	init: function() {
		const me = this;

		
		$('#date_range_1').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
		$('#date_range_1').noobsdaterangepicker({
			// parentEl: "#" + popup[0].id + " .modal-body",
			showDropdowns: true,
			singleDatePicker: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
		});
		$('#date_range_2').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
		$('#date_range_2').noobsdaterangepicker({
			// parentEl: "#" + popup[0].id + " .modal-body",
			showDropdowns: true,
			singleDatePicker: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
		});

		$('#tanggal_penagihan').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
		$('#tanggal_penagihan').noobsdaterangepicker({
			// parentEl: "#" + popup[0].id + " .modal-body",
			showDropdowns: true,
			singleDatePicker: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
		});
	}

	
	
};

$(document).ready(function() {
	tagihanPembayaran.init();
	$('#setting_manual').change(function(e){
		if(this.checked)
		{
			$('#company_name').attr('hidden', false);
			$('#owner').attr('hidden', false);
			$('#phone').attr('hidden', false);
			$('#add_company').attr('hidden', false);

		}
		else
		{
			$('#company_name').attr('hidden', true);
			$('#owner').attr('hidden', true);
			$('#phone').attr('hidden', true);
			$('#add_company').attr('hidden', true);

			$('#nama_perusahaan').val('');
			$('#pimpinan').val('');
			$('#no_telp').val('');
			$('#alamat_perusahaan').val('');

		}
	});
});