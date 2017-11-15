function reset(currentType, id) {
      $.ajax({
           type: "POST",
           url: '../admin/reset.php',
           data:{action:'reset', type: currentType, userId: id},
           success:function(name) {
             alert("Password has been reset");
           }
      });
 }

