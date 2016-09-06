jQuery(document).ready(function($) {
	$('#wptcmf-rules-table').DataTable( {
			"columnDefs": [
			 { "orderable": false, "targets": 0 },
			 { "orderable": false, "targets": 4 }
		 ],
			"order": [[ 1, "asc" ]],

			"language": {
				"sProcessing":     wptcmf.sProcessing,
				"sSearch":         wptcmf.sSearch,
				"sLengthMenu":     wptcmf.sLengthMenu,
				"sInfo":           wptcmf.sInfo,
				"sInfoEmpty":      wptcmf.sInfoEmpty,
				"sInfoFiltered":   wptcmf.sInfoFiltered,
				"sLoadingRecords": wptcmf.sLoadingRecords,
				"sZeroRecords":    wptcmf.sZeroRecords,
				"sEmptyTable":    wptcmf.sEmptyTable,
				"oPaginate": {
						"sFirst":      wptcmf.sFirst,
						"sPrevious":   wptcmf.sPrevious,
						"sNext":       wptcmf.sNext,
						"sLast":       wptcmf.sLast,
				},
				"oAria": {
						"sSortAscending":  wptcmf.sSortAscending,
						"sSortDescending": wptcmf.sSortDescending,
				}
			}
	});
});
