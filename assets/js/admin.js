/**
 * JavaScript code for dataTable.
 *
 * @author     WP-Translations Team
 * @link       https://wp-translations.pro
 * @since      1.0.0
 *
 * @package    WPT_Custom_Mo_File
 * @subpackage WPT_Custom_Mo_File/assets/js
 */

/* global document wptCustomMoFile */

jQuery( document ).ready( function( $ ) {
	'use strict';

	$( '#wpt-customofile-rules-table' ).DataTable( {
		columnDefs: [
			{
				orderable: false,
				targets: 0,
			},
			{
				orderable: false,
				targets: 4,
			},
		],
		order: [
			[
				1,
				'asc',
			],
		],
		language: {
			sProcessing: wptCustomMoFile.sProcessing,
			sSearch: wptCustomMoFile.sSearch,
			sLengthMenu: wptCustomMoFile.sLengthMenu,
			sInfo: wptCustomMoFile.sInfo,
			sInfoEmpty: wptCustomMoFile.sInfoEmpty,
			sInfoFiltered: wptCustomMoFile.sInfoFiltered,
			sLoadingRecords: wptCustomMoFile.sLoadingRecords,
			sZeroRecords: wptCustomMoFile.sZeroRecords,
			sEmptyTable: wptCustomMoFile.sEmptyTable,
			oPaginate: {
				sFirst: wptCustomMoFile.sFirst,
				sPrevious: wptCustomMoFile.sPrevious,
				sNext: wptCustomMoFile.sNext,
				sLast: wptCustomMoFile.sLast,
			},
			oAria: {
				sSortAscending: wptCustomMoFile.sSortAscending,
				sSortDescending: wptCustomMoFile.sSortDescending,
			},
		},
	} );
} );
