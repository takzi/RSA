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

	$('a.anchor').click(function(e){
		// preventing from refreshing
		e.preventDefault();
	})

	$(".reset-btn").click(function(e) {
		var $data = {
			action:'reset', type: $(this).data("type"), userId: $(this).data("id")
		}
		//console.log($data);

	   $.ajax({
           type: "POST",
           url: '../../BUS/admin/AdminFunctions.class.php',
           data: $data,
           success: function(data){  
                alert( data );  
            },
            error: function(data) {
            	console.log(data);
                alert("Sorry, it is seems that there is an error"); 
            }
<<<<<<< HEAD
          });
=======
        });
>>>>>>> 231233b6b8741d3511360350c5ce026f16df0935
	})

	// $("#deleteButton").click(function(currentType, currentId){
	// 	var $data = {
	//  		action: 'delete', type: data, id: currentId
	//  	}
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: '../../../../BUS/admin/AdminFunctions.class.php',
	// 		data: $data
	// 	}).done(function(msg){
	// 		console.log(msg);
	// 		//alert("Bus Driver Updated");
	// 		//location.reload();
	// 	});
	// })
}