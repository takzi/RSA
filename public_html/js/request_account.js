/**
 * Functions for account request
 *
 * @author     Tiandre Turner
 * @version    Release: 1.0
 * @date       11/14/2017
 */

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

$('#confirmpass').focusout(function(){
	var pass = $('#pass').val();
	var confirmpass = $('#confirmpass').val();

	if(pass !== confirmpass){
		$('#confirmed').removeClass("hide").addClass("display");
	}else{
		$('#confirmed').removeClass("display").addClass("hide");
	}
});