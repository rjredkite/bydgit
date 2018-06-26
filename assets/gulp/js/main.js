$(document).ready(function(){
	/*=========================================
	[ TOOLTIP ]
	========================================== */
    $('[data-toggle="tooltip"]').tooltip(); 

    /*=========================================
	[ TOOLTIP ]
	========================================== */
    $('.datepicker').datepicker({
     orientation: "bottom auto"
    });


    /*=========================================
	[ POPOVER ]
	========================================== */
    $('[data-toggle="popover"]').popover(); 

	$(document).on('click', function (e) {
	    $('[data-toggle="popover"],[data-original-title]').each(function () {
	        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {                
	            (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
	        }

	    });
	});

	/*=========================================
	[ JFILESTYLE ]
	========================================== */
	$(".file-browse").jfilestyle({buttonText: "Browse"});

	$(".upload_images").jfilestyle({buttonText: '<i class="fa fa-folder-open" aria-hidden="true"></i>'});

});