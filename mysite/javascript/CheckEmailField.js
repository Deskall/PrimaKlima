$(document).ready(function(){
	$(document).on("paste","[data-referent-name]",function(e){
		console.log('ahha try to paste? NO!');
		e.preventDefault();
	});
	$(document).on("change","[data-referent-name]",function(e){
		console.log('ici');
	});
});