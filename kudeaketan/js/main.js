'use strict'
console.log('hello');

$(document).ready(function(){

	$('#recherche').autocomplete({
		source : 'liste.php?lang=fr&'
	});

	$('#bilaketa').autocomplete({
		source : 'liste.php?lang=eus&'
	});

	$("button[name='delete']").on('click',function(e){
		console.log('hello world');
		return(confirm('Etes-vous sûr de vouloir supprimer la ligne?'));
	})

	$('.modify').on('dblclick', function(e){
		console.log('double clique');
		var url = $(this).find('.list').attr('action');
		console.log(url);
		window.location.href = url;
	})
});
