
              
              $(".toggleforms").click(function(f) {
                  $("#signupform").toggle();
                  $("#loginform").toggle();
              });
              
              $("#diary").bind("input propertychange",function(){
                  
                 $.ajax({
                     method:"POST",
                     url: "updatedatabase.php",
                     data: { content: $("#diary").val() }
                     
                     
                 })
                 .done(function(msg){
                    // $(this).addClass("done");
                    //console.log(msg);
                 });
                  
              });
              

          