/**
 * JavaScript code for dataTable
 *
 * @author     WP-Translations Team
 * @link       http://wp-translations.org
 * @since      1.0.0
 *
 * @package    WPT_Custom_Mo_File
 * @subpackage WPT_Custom_Mo_File/assets/js
 */

/* global validateForm */

jQuery( document ).ready( function( $ ) {

	'use strict';

	$('#wpt-customofile-rules-table').DataTable( {
			"columnDefs": [
			 { "orderable": false, "targets": 0 },
			 { "orderable": false, "targets": 4 }
		 ],
			"order": [[ 1, "asc" ]],

			"language": {
				"sProcessing":     wpt_customofile.sProcessing,
				"sSearch":         wpt_customofile.sSearch,
				"sLengthMenu":     wpt_customofile.sLengthMenu,
				"sInfo":           wpt_customofile.sInfo,
				"sInfoEmpty":      wpt_customofile.sInfoEmpty,
				"sInfoFiltered":   wpt_customofile.sInfoFiltered,
				"sLoadingRecords": wpt_customofile.sLoadingRecords,
				"sZeroRecords":    wpt_customofile.sZeroRecords,
				"sEmptyTable":     wpt_customofile.sEmptyTable,
				"oPaginate": {
						"sFirst":      wpt_customofile.sFirst,
						"sPrevious":   wpt_customofile.sPrevious,
						"sNext":       wpt_customofile.sNext,
						"sLast":       wpt_customofile.sLast,
				},
				"oAria": {
						"sSortAscending":  wpt_customofile.sSortAscending,
						"sSortDescending": wpt_customofile.sSortDescending,
				}
			}
	} );

} );
