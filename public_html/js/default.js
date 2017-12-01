/**
 *  @author Anthony Perez
 **/
 
 //start func.
 window.onload = function(){

 	$("#gencongBut").click(function(){
	 	var $data = {
	 		action: 'generateCongregationSchedule'
	 	}
		$.ajax({
			type: "POST",
			url: '../../../BUS/schedule/generate_congregations_schedule.php',
			data: $data
		}).done(function(msg){
			//alert("Rotation Created");
			console.log(msg);
			//location.reload();
		});
	})

 	$("#genbusBut").click(function(){
		var $data = {
	 		action: 'generateBusDriverSchedule'
	 	}
		$.ajax({
			type: 'POST',
			url: '../../../BUS/schedule/generate_bus_driver_schedule.php',
			data: $data
		}).done(function(msg){
			console.log(msg);
			//alert("Schedule Created");
			//location.reload();
		});
	})

	$("#emailBtn").click(function(){

	})

	$("#loginBtn").click(function(){
		
	})

	$("#edit-cong-form").submit(function(e){
        e.preventDefault();
    });

    $("#edit-bus-form").submit(function(e){
        e.preventDefault();
    });

	$("#updateCongregation").click(function(){
		var $data = {
	 		action: 'updateCongregation'
	 	}
		$.ajax({
			type: 'POST',
			url: '../../../../BUS/admin/AdminFunctions.class.php',
			data: $data
		}).done(function(msg){
			console.log(msg);
			//alert("Congregation Updated");
			//location.reload();
		});
	})

	$("#updateBusDriver").click(function(){
		var $data = {
	 		action: 'updateBusDriver'
	 	}
		$.ajax({
			type: 'POST',
			url: '../../../../BUS/admin/AdminFunctions.class.php',
			data: $data
		}).done(function(msg){
			console.log(msg);
			//alert("Bus Driver Updated");
			//location.reload();
		});
	})
}