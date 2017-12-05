/**
 *  @author Anthony Perez
 **/
 
$.urlParam = function(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	return results[1] || 0;
}

 //start func.
 window.onload = function(){

 	$("#genScheBut").click(function(){
	 	var $data = {
	 		action: 'generateCongregationSchedule'
	 	}
		$.ajax({
			type: "POST",
			url: '../../../../BUS/schedule/generate_congregations_schedule.php',
			data: $data
		}).done(function(msg){
			//alert("Rotation Created");
			console.log(msg);
			//location.reload();
		});
	})

 	$("#createSchedule").click(function(){
		var $data = {
	 		action: 'generateBusDriverSchedule'
	 	}
		$.ajax({
			type: 'POST',
			url: '../../../../BUS/schedule/generate_bus_driver_schedule.php',
			data: $data
		}).done(function(){
			alert("Schedule Created");
			//location.reload();
		});
	})

	$("#loginBtn").click(function(){
		
	})

	$("#edit-cong-form").submit(function(e){
        e.preventDefault();
    })

    $("#edit-bus-form").submit(function(e){
        e.preventDefault();
    })

    $("#email-form").submit(function(e){
    	e.preventDefault();
    })

    $("#email-sender").click(function(){
    	var $data = {
    		uid: $.urlParam('uid'),
    		message: $('#email-content').val(),
	 		action: 'email'
	 	}
    	console.log("Sending server: "+$data);
  //   	$.ajax({
		// 	type: 'POST',
		// 	url: '../../../../BUS/schedule/generate_bus_driver_schedule.php',
		// 	data: $data
		// }).done(function(){
		// 	alert("Schedule Created");
		// 	//location.reload();
		// });
    })

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

	$("#resetButton").click(function(currentType, id) {
		var $data = {
			action:'reset', type: currentType, userId: id
		}
	   $.ajax({
           type: "POST",
           url: '../../../../BUS/admin/AdminFunctions.class.php',
           data: $data,
           success: function(data){  
                alert( data );  
            },
            error: function(data) {
                alert("Sorry, it is seems that there is an error"); 
            }
          });
	})

	$("#deleteButton").click(function(currentType, currentId){
		var $data = {
	 		action: 'delete', type: currentType, id: currentId
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