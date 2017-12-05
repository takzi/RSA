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
			url: '../admin/admin_access.php',
			data: $data
			//  success: function(data){  
   //              alert("success" + data );  
   //          },
   //          error: function(data) {
   //          	//var err= eval("(" + xhr.responseText + ")");
   //              alert("Something went wrong in the server"); 
   //          }
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
			url: '../admin/admin_access.php',
			data: $data
		}).done(function(msg){
			//alert("Schedule Created");
			console.log(msg);
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
		$rawData = $("#dateValues").val().split('\n');
		$congName = $("#edit-name").val();
		$leaderName = $("#edit-leader-name").val();
		$congID = $('#congUID').val();
		$leaderID = $('#leaderUID').val()
		$dateValues = [];
		console.log($rawData);

		for(var index = 0; index < $rawData.length; index++){
			if(($current = $rawData[index].trim()).length != 0 && !$current.includes('/')){
				$dateValues.push($current);
			}
		}
		console.log($dateValues);
		console.log($('#congUID').val());
		var $data = {
	 		action: 'updateCongregation', blackouts: $dateValues, leader: $leaderName, cong: $congName
	 	}
		$.ajax({
			type: 'POST',
			url: '../admin/admin_access.php',
			data: $data,
		}).done(function(msg){
			console.log(msg);
			//alert("Congregation Updated");
			//location.reload();
		});
	})

	$("#updateBusDriver").click(function(){
		var $data = {
	 		action: 'updateBusDriver', 
	 	}
		$.ajax({
			type: 'POST',
			url: '../admin/admin_access.php',
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
           url: '../admin/admin_access.php',
           data: $data,
           success: function(data){  
                alert( data );  
            },
            error: function(data) {
            	//var err= eval("(" + xhr.responseText + ")");
                alert("Something went wrong in the server"); 
            }
<<<<<<< HEAD
          });
=======
        });
>>>>>>> 231233b6b8741d3511360350c5ce026f16df0935
	})

	$(".delete-btn").click(function(e){
		var $data = {
	 		action: 'delete', type: $(this).data("type"), id: $(this).data("id"), name: $(this).data("name")
	 	}
		$.ajax({
		   type: "POST",
           url: '../admin/admin_access.php',
           data: $data,
           success: function(data){  
                alert( data );  
            },
            error: function(data) {
            	//var err= eval("(" + xhr.responseText + ")");
                alert("Something went wrong in the server"); 
            }
		});
	})
}