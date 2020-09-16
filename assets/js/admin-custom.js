  $(document).ready(function () {
       $.validator.addMethod("fileCheck", function (value, element) {
      // alert("helo"+value);
       var ext = value.substring(value.lastIndexOf('.') + 1);
       // alert("helo"+ext);
           var fsize = $('#file')[0].files[0].size
      //  alert("helo"+fsize);
           if(ext =="jpg" || ext=="gif" || ext=="jpeg" || ext=="png" || ext=="pdf" ) {
          
        if(fsize<500000) {//do something if file size more than 1 mb (1048576)
            return true;
        }else{
            alert(" You upload  file/image maximun size 500kb !");
           return false;
        }        
      }
       else{
        alert("Upload gif,jpg,jpeg,png,pdf Images only");
        return false;
        }

    },'Please select correct format or size');
        
 $("#add_list-form").validate({
                    rules: {
                             title: {
                                          required: true
                              },
                             //description: {
                                        //  required: true
                             // },
                               external_url: {
                                          required: true
                            },

                              image_url: { required: "#file:blank"},
                              //phoneNight: { required: "#phoneDay:blank" }




                          file: {
                                          required: "#image_url:blank",
                                          fileCheck: true
                              }
                    },
                  messages: {
                              title: {
                                         required: "Please title",
                              },
                                 //  description: {
                                     //    required: "Please desription",
                            //  },
                          external_url: {
                                         required: "Please enter url",
                              },

                              image_url:{

                                required: "Please enter image url",

                              },


                            file: {
                               required: "Please select the file OR url ",
                              }
    
           },
 
               
     });
    




$("#edit_list-form").validate({
                    rules: {
                             title: {
                                          required: true
                              },
                             //description: {
                                        //  required: true
                             // },
                               external_url: {
                                          required: true
                            }
                    },
                  messages: {
                              title: {
                                         required: "Please title",
                              },
                                 //  description: {
                                     //    required: "Please desription",
                            //  },
                          external_url: {
                                         required: "Please enter url",
                              }
    
           },
 
               
     });


$("#add_category_form").validate({
                    rules: {
                             name: {
                                          required: true
                              },
                             //description: {
                                        //  required: true
                             // },
                               order: {
                                          required: true
                            },
                         
                    },
                  messages: {
                              name: {
                                         required: "Please enter name",
                              },
                                 //  description: {
                                     //    required: "Please desription",
                            //  },
                          order: {
                                         required: "Please enter order no",
                              },
                           
    
           },
 
               
     });
     
     
     
     
     
     $("#media-form").validate({
                    rules: {
                             title: {
                                          required: true
                              },                              
                         
                    },
                  messages: {
                              title: {
                                         required: "Please enter title",
                              },
           },
 
               
     });
     
     
     $("#add_users").validate({
                    rules: {
                        companyname: {
                                          required: true
                              },
                             firstname: {
                                          required: true
                              },
                             
                             lastname: {
                                          required: true
                            },
                          email: {
                                          required: true,
                                          email: true
                              },
                            password: {
                                          required: true,
                                           minlength: 5
                              },
                                confirm_password: {
                                          required: true,
                                           minlength: 5,
                                           equalTo: "#password"
                              }
                    },
                  messages: {
                      companyname: {
                                         required: "Please enter your Company Name",
                              },
                              firstname: {
                                         required: "Please enter your First Name",
                              },
                                  lastname :{
                                        required: "Please enter your Last Name",
                              },
                          email: {
                                         required: "Please Email",
                                          email: "Please enter valid Email Address"
                              },
                            password: {
                               required: "Please provide a password",
                               minlength: "Your password must be at least 5 characters long",
                              },
                              confirm_password: {
                                required: "Please Confirm_password",
                                minlength: "Your password must be at least 5 characters long",
                                equalTo: "Please enter the same password as above"
                              }
    
           },
 
               
     });
   
  
 
$("#admin-login").validate({
                   rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 5
                        }
                    },
                    messages: {
                        password: {
                            required: "Please enter your password"
                        },
                        email: {
                        required: "Please enter your email address",
                        email: "Please enter valid Email Address"
                        }     
               },
               
     });
     $("input:radio[name=adtype]").click(function(){
    if($("input:radio[name=adtype]:checked").val()==4){
        $('#listingentryform').hide('slow');
        $('#rssurlbox').show();
    }else{
        $('#listingentryform').show('slow');
        $('#rssurlbox').hide();
    }
 });
  $("#getfeeditemsform").validate({
    rules: {
      feed_url: {
        required: true
      }
    },
    messages: {
      feed_url: {
        required: "Please enter rss feed url."
      }
    },
    submitHandler: function(form) {
      $.ajax( {
                url: '/admin/getListingsFromFeed',
                type: 'get',
                
                async: true,
                data: $('#getfeeditemsform').serialize(),
                success: function(response) {
                    $('#feeditems').html(response);
                    $('#feeditems').show();
                },
                error: function() {
                    // Put the submit elements back
                    //submitContainer.html(submitElems);
                }
            });
    }               
     });
  $(document).on('submit','#submitrsslist',function(){
      alert($('#category').val());
      $('#rsscatgeory_id').val($('#category').val());
  });
});
  