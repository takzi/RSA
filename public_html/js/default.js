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
		}).done(function(msg){
			alert("Rotation Created");
			console.log(msg);
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
			if(msg == true){
				alert("Bus Driver Schedule Generation Complete.");
			}
			else{
				alert("availability missing to complete schedule.")
			}
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
    	if (window.location.href.indexOf("?") >= 0){
    		var $data = {
    		uid: $.urlParam('uid'),
    		type: $.urlParam('type'),
    		message: $('#email-content').val(),
	 		action: 'email'
		 	}
	    	$.ajax({
				type: 'POST',
				url: 'admin/admin_access.php',
				data: $data
			}).done(function(msg){
				if(msg){
					alert("Message was succesfully sent.")
				}
			});
    	}
    	else{
    		var $data = {
    		message: $('#email-content').val(),
	 		action: 'emailAdmin'
		 	}
	    	$.ajax({
				type: 'POST',
				url: 'admin/admin_access.php',
				data: $data
			}).done(function(msg){
				if(msg){
					alert("Message was succesfully sent.")
				}
			});
    	}
    })

    $("#dateArrowButton").click(function(e){
        e.preventDefault();
    });

	$("#updateCongregation").click(function(){
		$congName = $("#edit-name").val();
		$leaderName = $("#edit-leader-name").val();
		$congID = $('#congUID').val();
		$leaderID = $('#leaderUID').val()

		var $data = {
	 		action: 'updateCongregation', leaderID: $leaderID, leader: $leaderName, congID: $congID, cong: $congName
	 	}
		$.ajax({
			type: 'POST',
			url: '../admin/admin_access.php',
			data: $data,
		}).done(function(msg){
			submitBlackoutDates();
			alert("Congregation Updated");
			location.reload();
		});
	})

	$(".blackout").click(function(){
		insertBlackoutDateValue();
	})

	$(".availability").click(function(){
		insertAvailabilityDateValue();
	})

	$("#updateBlackoutDates").click(function(){
		submitBlackoutDates();
		alert("The blackout dates are now saved");
		location.reload();
	})

	$("#updateAvailability").click(function(){
		submitAvailabilityDates();
		alert("The availability dates are now saved");
		location.reload();
	})

	$("#updateBusDriver").click(function(){
		$name = $("#edit-name").val();
		$busID = $('#busDriverUID').val();
		$contactNumber = $('#edit-number').val();
		var $data = {
	 		action: 'updateBusDriver', name: $name, id: $busID, contactNum: $contactNumber
	 	}
		$.ajax({
			type: 'POST',
			url: '../admin/admin_access.php',
			data: $data
		}).done(function(msg){
			// console.log(msg);
			submitAvailabilityDates();
			alert("Bus Driver Updated");
			location.reload();
		});
	})

	$(".addBusDriver").click(function(){
		$fname = $("#fname").val();
		$lname = $("#lname").val();
		$email = $("#email").val();
		$contactNumber = $('#edit-number').val();
		console.log("name: " + $fname + " " + $lname + "\t" + $email + "\t" + $contactNumber);
		if($fname && $lname && $email && $contactNumber){
			var $data = {
		 		action: 'addBusDriver', fname: $fname, lname: $lname, email: $email, contact: $contactNumber
		 	}
			$.ajax({
				type: 'POST',
				url: '../admin/admin_access.php',
				data: $data
			}).done(function(msg){
				// submitAvailabilityDates();
				console.log(trim(msg));
				//location.reload();
			});
		}
	})

	$('#addBusDriverBtn').click(function(e){
		// preventing from refreshing
		e.preventDefault();
	})

	$('a.anchor').click(function(e){
		// preventing from refreshing
		e.preventDefault();
	})

	$("#save-btn").click(function(e) {
		$name = $("#edit-leader-name").val();
		$userID = $("#userID").val();
		var $data = {
			action:'save', id: $userID, name: $name
		}

	   $.ajax({
           type: "POST",
           url: '../admin/admin_access.php',
           data: $data,
           success: function(data){  
                alert( "User Updated" );  
                location.reload();
            },
            error: function(data) {
            	//var err= eval("(" + xhr.responseText + ")");
                alert("Something went wrong in the server"); 
            }
        });
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
        });
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
                location.reload();
            },
            error: function(data) {
            	//var err= eval("(" + xhr.responseText + ")");
                alert("Something went wrong in the server"); 
            }
		});
	})

	var blackoutDates = [];
	function insertBlackoutDateValue(){
		var fromDate = $("#date-from-input").val();
		var toDate = $("#date-to-input").val();

		if(fromDate && toDate){
			if($("#dateValues").text().trim() == "No blackout dates"){
				$("#dateValues").text("");
			}

			blackoutDates.push(fromDate + ","+toDate);
			var formattedDate = getBlackoutDateString(fromDate, toDate);
			var txt = document.createTextNode(formattedDate +"\n");
			$("#dateValues").append(txt);
			$("#date-from-input").val("");
			$("#date-to-input").val("");
		}
	}

	function getBlackoutDateString(fromDateStr, toDateStr) {
	    [fromYear, fromMonth, fromDay] = fromDateStr.split("-");
	    [toYear, toMonth, toDay] = toDateStr.split("-");

	    return fromMonth + '/' + fromDay + '/' + fromYear + ' - ' +  toMonth + '/' + toDay + '/' + toYear;
	}

	function submitBlackoutDates(){
		console.log(blackoutDates);
		var id = $('#congUID').val();
		for(var i = 0 ; i < blackoutDates.length; i++ ){
			[fromDate, toDate] = blackoutDates[i].split(",");
			$.ajax({
			  type: "POST",
			  url: "../templates/admin/admin_access.php",
			  data:{action:'submitBlackoutDates', congID: id,from: fromDate, to: toDate}
			})
		}
	}

	function getMonth(monthNumber){
		var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		return months[monthNumber - 1];
	}

	var availabilityDates = [];
	function insertAvailabilityDateValue(){
		var date = $("#date-input").val();
		var time_of_day =$("#time_of_day").val();
		if (typeof (time_of_day) == 'undefined')
			time_of_day = 1;
		console.log(time_of_day);
		if(date && time_of_day != -1){
			if($("#dateValues").text().trim() == "No availability dates"){
				$("#dateValues").text("");
			}

			availabilityDates.push(date + ","+ time_of_day);
			var formattedDate = getAvailabilityDateString(date) + ' - ' + getTimeOfDay(time_of_day);
			var txt = document.createTextNode(formattedDate+"\n");
			$("#dateValues").append(txt);
			$("#date-input").val("");
		}
	}

	function getAvailabilityDateString(dateStr) {
	    [year, month, day] = dateStr.split("-");

	    return month + '/' + day + '/' + year;
	}

	function submitAvailabilityDates(){
		console.log(availabilityDates);
		var id = $('#busDriverUID').val();
		for(var i = 0 ; i < availabilityDates.length; i++ ){
			[date, time_of_day] = availabilityDates[i].split(",");
			$.ajax({
			  type: "POST",
			  url: "../templates/admin/admin_access.php",
			  data:{action:'submitAvailabilityDates', busID: id, availabilityDate: date, timeOfDay: time_of_day}
			});
		}
	}

	function getTimeOfDay(timeOfDayValue){
		var timeOfDay = ['Any', 'Morning', 'Afternoon'];
		return timeOfDay[timeOfDayValue - 1];
	}
}