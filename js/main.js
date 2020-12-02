'use strict'

$(document).ready(function(){

/*	$(window).on('scroll', function(e) {
		console.log('ça scrolle ici');
		$('header').addClass('fixedTopNav');
	})*/
	
	$('.flexslider').flexslider({
    	animation: "slide",
    	directionNav: false,
		controlNav: false
  	});

	var test = document.querySelectorAll('.sum');
	var sum = 0;
	for (var i = 0; i < test.length; i++) {
		var test2 = parseFloat(test[i].innerText);
		sum += test2;
		console.log(sum);
	}
	sum = sum.toFixed(2);
	$('#grandTotal').text(sum);

	$("#mdfPswd").on('click', function(e) {
		var pswd1 = $("input[name='newPswd1']").val();
		var pswd2 = $("input[name='newPswd2']").val();
		console.log(pswd1);
		console.log(pswd2);
		if (pswd1 != pswd2) {
			alert('la confirmation du nouveau mot de passe ne correspond pas!');
			return false;
		}
	})

	$("#brPh").on('click', function(e) {
		var pswd1 = $("input[name='newPswd1']").val();
		var pswd2 = $("input[name='newPswd2']").val();
		console.log(pswd1);
		console.log(pswd2);
		if (pswd1 != pswd2) {
			alert('Pasahitz berriaren berrespena ez dator bat!');
			return false;
		}
	});

	$("input[name='delivery']").on('click', function(e) {
		var inputId = $(this).val();
		console.log(inputId);
		var  details = $("#detail").children("p");
		console.log(details);
		details.hide();
		var showP = $('#detail').find("."+inputId+"");
		var contentP = showP.text();
		console.log(contentP);
		showP.show();

	});


	$("button[class=mail]").on('click', function(e){
		let mail = $("input[name=email").val();
		let langue = $("input[name=lang").val();

		$.post(
		 	"_question.php?lang="+langue,
		 	{email: mail},
		 	function(data){
				console.log(data);

		 		if (data) {
		 			$('.container').html(data);
		 			$('button[id=result').toggle();
		 		} else {
		 			$('.container').html("<p>Il n'y as pas de compte avec ce courriel.</p>")
		 		}

		 	},
		 	'text'
		)
	});


	$("button[id=result]").on('click', function(e){

		let master = $("input[name=master]").val();

		let result = $("input[name=result]").val();

		if (master == result) {
			let mail = $("input[name=email").val();
			let langue = $("input[name=lang").val();

			$.post(
		 		"_newPassword.php?lang="+langue,
		 		{email: mail},
		 		function(data){

		 			if (data == 'Success') {
						$('#endOfProcedure').toggle();
		 			} else {
		 				$('.container').html('<p>Erreur lors de la connexion...</p>')
		 			}

		 		},
		 		'text'
			)

		}
	})

});

