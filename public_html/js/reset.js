/**
 * Functions for resetting password
 *
 * @author     Tiandre Turner
 * @version    Release: 1.0
 * @date       11/16/2017
 */
 
function reset(currentType, id) {
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

