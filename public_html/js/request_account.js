$('#role').change(function(){
	var role = $('#role').val();
	if(role == 4){ // cong 
		$('#contactNum').removeClass("display").addClass("hide");
		$('#congName').removeClass("hide").addClass("display");
	} 
	if(role == 5){ // bus driver
		$('#congName').removeClass("display").addClass("hide");
		$('#contactNum').removeClass("hide").addClass("display");
	}

	if(role == -1 || role == 1){
		$('#contactNum').removeClass("display").addClass("hide");
		$('#congName').removeClass("display").addClass("hide");
	}
});

