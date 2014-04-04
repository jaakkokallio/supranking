/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*var checkGender = $('.btn-group.gender button[name="genderChoice"].active').val();
alert(checkGender);*/
/*

 */

$(document).ready(function() {

    /* Table initialisation */
    var rTable = $('.ranking-list').dataTable( {
        "aaSorting": [[ 0, "asc" ]],
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "sPaginationType": "bootstrap",
        fnDrawCallback: function(){
            var wrapper = this.parent();
            var rowsPerPage = this.fnSettings()._iDisplayLength;
            var rowsToShow = this.fnSettings().fnRecordsDisplay();
            var minRowsPerPage = this.fnSettings().aLengthMenu[0][0];
            if ( rowsToShow <= rowsPerPage || rowsPerPage == -1 ) {
                $('.dataTables_paginate', wrapper).css('visibility', 'hidden');
            }
            else {
                $('.dataTables_paginate', wrapper).css('visibility', 'visible');
            }
            if ( rowsToShow <= minRowsPerPage ) {
                $('.dataTables_length', wrapper).css('visibility', 'hidden');
            }
            else {
                $('.dataTables_length', wrapper).css('visibility', 'visible');
            }
        },
        "oLanguage": {
            "sLengthMenu": "_MENU_ resultat per sida",
            "sZeroRecords": "Ingen data tillgänglig.",
            "sInfo": "Visar _START_ - _END_ av _TOTAL_ resultat",
            "sInfoEmpty": "Visar 0 - 0 av 0 resultat",
            "sInfoFiltered": "(filtrerar från _MAX_ totala resultat)",
            "sSearch": "Sök: ",
            "oPaginate": {
                "sFirst":    "",
                "sPrevious": "",
                "sNext":     "",
                "sLast":     ""
            }
        }
    } );

    var aCTable = $('.admin-competitors-list').dataTable({
        "aaSorting": [[ 0, "asc" ]],
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "sPaginationType": "bootstrap",
		"aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 5 ] } ],
        fnDrawCallback: function(){
            var wrapper = this.parent();
            var rowsPerPage = this.fnSettings()._iDisplayLength;
            var rowsToShow = this.fnSettings().fnRecordsDisplay();
            var minRowsPerPage = this.fnSettings().aLengthMenu[0][0];
            if ( rowsToShow <= rowsPerPage || rowsPerPage == -1 ) {
                $('.dataTables_paginate', wrapper).css('visibility', 'hidden');
            }
            else {
                $('.dataTables_paginate', wrapper).css('visibility', 'visible');
            }
            if ( rowsToShow <= minRowsPerPage ) {
                $('.dataTables_length', wrapper).css('visibility', 'hidden');
            }
            else {
                $('.dataTables_length', wrapper).css('visibility', 'visible');
            }
        },
        "oLanguage": {
            "sLengthMenu": "_MENU_ deltagare per sida",
            "sZeroRecords": "Ingen data tillgänglig.",
            "sInfo": "Visar _START_ - _END_ av _TOTAL_ deltagare",
            "sInfoEmpty": "Visar 0 - 0 av 0 deltagare",
            "sInfoFiltered": "(filtrerar från _MAX_ deltagare)",
            "sSearch": "Sök: ",
            "oPaginate": {
                "sFirst":    "",
                "sPrevious": "",
                "sNext":     "",
                "sLast":     ""
            }
        }
    } );

	if ($('.ranking-list').length > 0) {

		// Sort immediately with column 1
	    rTable.fnSort( [ [0,'asc'] ] );

	    // Male or Female ranking lists
	    var checkGender = ($('#gender').val());

	    if(checkGender == "Herrar"){
	        $('#genderMale').fadeIn();
	    }

	    $('.btn-group.genderChoice button#genderMaleBtn').click(function(){
	        rTable.fnSortListener( document.getElementById(this), 0 );
	        $('#genderFemale').hide();
	        $('#genderMale').fadeIn();

	    });

	    $('.btn-group.genderChoice button#genderFemaleBtn').click(function(){
	        rTable.fnSortListener( document.getElementById(this), 0 );
	        $('#genderMale').hide();
	        $('#genderFemale').fadeIn();
	    });

	}
	
	if ($('.admin-competitors-list').length > 0) {

	    aCTable.fnSort( [ [2,'asc'] ] );

	}
	

	// Show competitor details
	
	$('.ranking-list tr td, .result-list tr td').click(function() {
		$.get("competitor.php?competitor_id="+$(this).parent("tr").data("competitor-id"), function(data) {
			$("#competitor-modal").html(data); 
			$("#competitor-modal").modal(); 		
		});
	});
	
	$('.admin-competitors-list .show-results').click(function(e) {
		e.preventDefault();
		$.get("competitor.php?competitor_id="+$(this).data("competitor-id"), function(data) {
			$("#competitor-modal").html(data); 
			$("#competitor-modal").modal(); 		
		});
	});
	
	// Admin
	
	$('.date').datepicker();

});