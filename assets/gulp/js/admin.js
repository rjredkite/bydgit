$(document).ready(function(){
	/*===================================================================
	[ ADMIN BACKEND  ]
	=================================================================== */

		$(window).resize(function(){location.reload();});

	    /* =========================================
		[ ADMIN SIDEBAR NAVIGATION ]
		========================================== */

		if( $(window).width() > 648 ){

			$('#byd-button-collapse').click(function(){

				if($('#adminsidenav').hasClass('sidenav-open')){
					
					$('#adminsidenav').removeClass('sidenav-open');
					$('#adminsidenav').animate({"margin-left": '-=250'},350);
					$('.admin-body-container').animate({"margin-left": '0'},340);
					$('#adminsidenav').addClass('sidenav-close');
					

				}else{

					$('#adminsidenav').removeClass('sidenav-close');
					$('#adminsidenav').animate({"margin-left": '+=250'},350);
					$('.admin-body-container').animate({"margin-left": '250px'},340);
					$('#adminsidenav').addClass('sidenav-open');
					

				}
			});
		}else{

			$('.admin-body-container').css('margin-left','0px');

			$('#adminsidenav').removeClass('sidenav-open');				
			$('.mobile-black').css('display','none');
			$('#adminsidenav').animate({"margin-left": '-=250'},350);
			$('#adminsidenav').addClass('sidenav-close');

			if($('#adminsidenav').hasClass('sidenav-open')){
				$('.mobile-black').css('display','block');
			}

			$('#byd-button-collapse').click(function(){

				if($('#adminsidenav').hasClass('sidenav-open')){
						
					$('#adminsidenav').removeClass('sidenav-open');				
					$('.mobile-black').css('display','none');
					$('#adminsidenav').animate({"margin-left": '-=250'},350);
					$('#adminsidenav').addClass('sidenav-close');

					
				}else{

					$('#adminsidenav').removeClass('sidenav-close');
					$('.mobile-black').css('display','block');
					$('#adminsidenav').animate({"margin-left": '+=250'},350);
					$('#adminsidenav').addClass('sidenav-open');

				}

			});

			$('.admin-logo i').click(function(){

				$('#adminsidenav').removeClass('sidenav-open');
				$('.mobile-black').css('display','none');
				$('#adminsidenav').animate({"margin-left": '-=250'},350);
				$('#adminsidenav').addClass('sidenav-close');

			});

			$('.mobile-black').click(function(){

				$('#adminsidenav').removeClass('sidenav-open');
				$('.mobile-black').css('display','none');
				$('#adminsidenav').animate({"margin-left": '-=250'},350);
				$('#adminsidenav').addClass('sidenav-close');

			});

		}



		/* =========================================
		[ ADMIN SIDEBAR NAVIGATION ]
		========================================== */
	    $('#page-published').change(function(){
	    	if($(this).prop('checked') == true) {
	           
	        } else {
	            $("#checkbox-admin").modal("show");
	            $('#page-published').prop('checked', true);
	        }
		});

		$('#page-edit-yes').click(function(){
			$('#page-published').prop('checked', false);
		});

		$('#page-edit-no').click(function(){
			$('#page-published').prop('checked', true);
		});

		/* =========================================
		[ ADMIN USERS SEARCH FIELDS ]
		========================================== */
		$('#admin-search-button').click(function(){
			$('.admin-search-fields').slideToggle();
		});

});