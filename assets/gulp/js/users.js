$(document).ready(function(){

	/*============================================
	[ NAVBAR FRONT END]
	=============================================*/		
        $(window).scroll(function(){
     		if ( $(window).scrollTop() <= 150) {
         		$('.navbar-container').removeClass('navbar-float');
         	}else{
         		$('.navbar-container').addClass('navbar-float');
         	}
	    });



    /*===================================================================
	[ OWL CAROUSEL  ]
	=================================================================== */
		/* =========================================
		[ LISTING FRONT END SLIDER ]
		========================================== */
		$('.owl-listingpage-carousel').owlCarousel({						               
			loop: true,
			nav:true,
			navText : ["<i class='fa fa-chevron-circle-left' aria-hidden='true'></i>","<i class='fa fa-chevron-circle-right' aria-hidden='true'></i>"],
			URLhashListener: true,
			items: 1,
			startPosition: 'URLHash'
	    });

	/*===================================================================
	[ LISTING SORT SEARCH FILTER FRONT END ]
	=================================================================== */

		/* =========================================
		[ STUD-DOG LISTINGS SORT BY ]
		========================================== */
		$('#sort-stud-dogs').change(function(){

			$sort = $('#sort-stud-dogs').val();

			$('#search-sort-stud-dogs').val($sort);

			$('#form-stud-dogs').submit();
		});

		/* =========================================
		[ PUPPIES LISTINGS SORT BY ]
		========================================== */
		$('#sort-puppies').change(function(){

			$sort = $('#sort-puppies').val();

			$('#search-sort-puppies').val($sort);

			$('#form-puppies').submit();
		});

		/* =========================================
		[ MEMORIALS LISTINGS SORT BY ]
		========================================== */
		$('#sort-memorials').change(function(){

			$sort = $('#sort-memorials').val();

			$('#search-sort-memorials').val($sort);

			$('#form-memorials').submit();
		});

		/* =========================================
		[ LISTINGS SORT BY ]
		========================================== */
		$('#sort-listings').change(function(){

			$sort = $('#sort-listings').val();

			$('#search-sort-listings').val($sort);

			$('#form-listings').submit();
		});


	/*===================================================================
	[ BREEDS SORT BY SELECT ]
	=================================================================== */
	$('#breeds-kc-group').change(function(){
		$kennelid = $(this).val();

		if($kennelid != 'all'){
			$('.breeds-kennel-container').hide();
			$($kennelid).show();
		}else{
			$('.breeds-kennel-container').show();
		}
		
	});
	
});
