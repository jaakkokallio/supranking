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
	
	$("body").on("click", ".ranking-list tr td, .result-list tr td", function() {
		if ($(this).parent("tr").data("competitor-id")) {
			$.get(window.urlRoot+"/competitor/"+$(this).parent("tr").data("competitor-id"), function(data) {
				$("#competitor-modal").html(data);
				$(".placing").popover({trigger: "hover", html: true});
				$("#competitor-modal").modal();		
			});
		}	
	});
	
	$("body").on("click", ".admin-competitors-list .show-results", function(e) {
		e.preventDefault();
		if ($(this).data("competitor-id")) {
			$.get(window.urlRoot+"/competitor/"+$(this).data("competitor-id"), function(data) {
				$("#competitor-modal").html(data);
				$(".placing").popover({trigger: "hover", html: true});
				$("#competitor-modal").modal(); 		
			});
		}
	});
		
	// Admin
	
	$('.date').datepicker();

	// Create competitor

	$("body").on("click", "form#create-competitors a.submit-form", function(e) {
		e.preventDefault();
		$.post(window.urlRoot+"/competitor-create", $("form#create-competitors").serialize(), function(data) {
			if (data.competitors.successes.length > 0) {
				var spreadsheet = $("#"+data.competitors.successes[0].gender+"-"+data.discipline+"-spreadsheet").handsontable('getInstance');
				$.each(data.competitors.successes, function(i, c) {
					var name = c.first_name+" "+c.last_name;
					window.competitors[c.gender].push({competitor_id: c.competitor_id, competitor: name});
					spreadsheet.setDataAtCell(c.row, 0, c.competitor_id);
					spreadsheet.setDataAtCell(c.row, 1, name);
				});
			}
			if (data.competitors.errors.length > 0) {
				addCompetitors(data.discipline, data.competitors.errors[0].gender, $.map(data.competitors.errors, function(c) { return {row: c.row, competitor: c.first_name+" "+c.last_name}; }), {error: true});
			} else {
				$("#new-competitor-modal").modal("hide");
			}
		}, "json");
	});
	
	$(".save-results").click(function(e) {
		e.preventDefault();
		var femaleDistanceResults = $("#female-distance-spreadsheet").length > 0 ? $.grep($("#female-distance-spreadsheet").handsontable('getInstance').getData(), function(r) { return r.competitor_id != null; }) : [];
		var femaleSprintResults = $("#female-sprint-spreadsheet").length > 0 ? $.grep($("#female-sprint-spreadsheet").handsontable('getInstance').getData(), function(r) { return r.competitor_id != null; }) : [];
		var maleDistanceResults = $("#male-distance-spreadsheet").length > 0 ? $.grep($("#male-distance-spreadsheet").handsontable('getInstance').getData(), function(r) { return r.competitor_id != null; }) : [];
		var maleSprintResults = $("#male-sprint-spreadsheet").length > 0 ? $.grep($("#male-sprint-spreadsheet").handsontable('getInstance').getData(), function(r) { return r.competitor_id != null; }) : [];
	
		var results = {
			female: {distance: femaleDistanceResults, sprint: femaleSprintResults}, 
			male: {distance: maleDistanceResults, sprint: maleSprintResults}
		};
		
		$.post(window.urlRoot+"/competition-results-update", {competition_id: $(this).data("competition-id"), results: results}, function(data) {
			if (data.errors.length > 0) {
				$(".results-spreadsheets").append("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button> "+data.errors.length+" fel uppstod!</div>");
			} else {
				$(".results-spreadsheets").append("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button> "+data.created_results.length+" resultat sparades!</div>");
			}
		}, "json");
	});
	
});

// Results spreadsheet

var addCompetitors = function(discipline, gender, competitorChanges, options) {
	$.get(window.urlRoot+"/competitor-new", {discipline: discipline, gender: gender, competitor_changes: competitorChanges, error: options.error}, function(data) {
		$("#new-competitor-modal").html(data); 		
		$("#new-competitor-modal").modal(); 		
	});
};


var timeValidator = function(value, callback) {
	setTimeout(function(){
    	if (!value || value.length == 0 || /^([0-9][0-9]):([0-5][0-9]):([0-5][0-9])$/.test(value)) {
      		callback(true);
    	} else {
      		callback(false);
    	}
  	}, 100);
};

var autocompleteCompetitors = function(gender, query, process) {
	process($.grep($.map(window.competitors[gender], function(c) { return c.competitor; }), function(c) { return c.indexOf(query) == 0; }));
};

$.fn.spreadsheet = function(discipline, gender, results) {
	if (discipline == "distance") {
		var data = $.map(results, function(r) { return {competitor_id: r.competitor_id, competitor: r.competitor, class: r.class, time: r.time}; });
		var colHeaders = ["ID", "Deltagare", "Klass", "Tid"];
		var colWidths = [50, 400, 100, 100];
		var columns = [{data: "competitor_id", readOnly: true},
					   {data: "competitor", type: 'autocomplete', strict: true, source: function (query, process) { autocompleteCompetitors(gender, query, process); }}, 
				  	   {data: "class", type: 'dropdown', source: ["126", "14"]}, 
				       {data: "time", validator: timeValidator}];
	} else {
		var data = $.map(results, function(r) { return {competitor_id: r.competitor_id, competitor: r.competitor, time: r.time}; });
		var colHeaders = ["ID", "Deltagare", "Tid"];
		var colWidths = [50, 400, 100];
		var columns = [{data: "competitor_id", readOnly: true},
					   {data: "competitor", type: 'autocomplete', strict: true, source: function (query, process) { autocompleteCompetitors(gender, query, process); }}, 
				  	   {data: "time", validator: timeValidator}];
	}
	var table = this;
	table.handsontable({
		data: data, 
		fillHandle: "vertical",
		colHeaders: colHeaders, 
		rowHeaders: true, 
		minSpareRows: 1,
		pasteMode: "shift_down",
		colWidths: colWidths, 
		columns: columns,
		afterChange: function(changes, source) {
			if (changes && changes.length > 0) {
				$.each(changes, function(i, c) {
					if (table.handsontable('countCols') == 4 && table.handsontable('getDataAtCell', c[0], 1) && table.handsontable('getDataAtCell', c[0], 1).length > 0 && (!table.handsontable('getDataAtCell', c[0], 2) || table.handsontable('getDataAtCell', c[0], 2) == "")) {
						table.handsontable('setDataAtCell', c[0], 2, "126");
					} else if (c[1] == "competitor" && (c[3] == undefined || c[3].length == 0)) {
						table.handsontable('setDataAtCell', c[0], 0, null);
					}
				});
				if (source && (source == "edit" || source == "spliceCol")) {
					var competitorNames = $.map(window.competitors[gender], function(c) { return c.competitor; });
					var competitorChanges = $.grep(changes, function(c) { return c[1] == "competitor" && c[3] && c[3].length > 0 && $.inArray(c[3], competitorNames) == -1; });				
					if (competitorChanges.length > 0) {
						addCompetitors(discipline, gender, $.map(competitorChanges, function(c) { return {row: c[0], competitor: c[3]}; }), {});					
					} else {
						var existingCompetitorChanges = $.grep(changes, function(c) { return c[1] == "competitor" && c[3] && c[3].length > 0 && $.inArray(c[3], competitorNames) > -1; });
						$.each(existingCompetitorChanges, function(i, change) {
							table.handsontable('setDataAtCell', change[0], 0, $.grep(window.competitors[gender], function(c) { return c.competitor == change[3]; })[0].competitor_id);
						});
					}
				}
			}
		}
	});
};