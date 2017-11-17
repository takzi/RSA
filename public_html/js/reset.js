function reset(currentType, id) {
		console.log("Type: "+ currentType + "\tId: " + id);
	    	      $.ajax({
           type: "POST",
           url: '../admin/reset.php',
           data:{action:'reset', type: currentType, userId: id},
           async: true,
           crossDomain: true,
           success: function(){  
                alert( "Password reset!" );  
            },
            error: function(data) {
                alert("Sorry, it is seems that there is an error"); 
            }
          });
 }

