/************NAVIGATION JS***************/
function clean(str){
    
return str.replace(/\s+/g, '-').toLowerCase();
}

	
	
	
	

/************VERTICAL GRID JS***************/

function arrange(){
      var handler = $('#tiles li');
      var options = {
      autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#main'), // Optional, used for some extra CSS styling
          offset: 1, // Optional, the distance between grid items
          outerOffset: 10 // Optional, the distance to the containers border
    };
      setTimeout(function() { handler.wookmark(options);  }, 600);
	
       if($('.navbar-toggle').is(':visible')){
      //$(".navbar-toggle").trigger('click');
      }
  $('#tiles li').trigger('refreshWookmark');
  }	
  
  
/************PAGING JS***************/
var track_load = 1; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
var total_groups =$('#totalpages').val();//1; //total record group(s)
$(document).ready(function() {


	//$('#tiles').load("index1.html", {'group_no':track_load}, function() {track_load++;}); //load first group
	
	$(window).scroll(function() { //detect page scroll
		
		if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
		{
			
			if(track_load <= total_groups-1 && loading==false) //thereis more data to load
			{
				loading = true; //prevent further ajax loading
				$('.animation_image').show(); //show loading image
        if($('#issearch').val() !=''){
          var getUrl=base_url+'posting/getAjaxSearchPosting/'+$('#issearch').val()+'/'+track_load+'/'+$('#limit').val();
        }else{
          var getUrl=base_url+'posting/getAjaxPosting/'+$('#category_id').val()+'/'+track_load+'/'+$('#limit').val();
        }
				
               
				//load data from the server using a HTTP POST request
				$.get(getUrl, function(data){
									
					$("#tiles").append(data); //append received data into the element
					arrange();
					//hide loading image
					$('.animation_image').hide(); //hide loading image once data is received
					
					track_load++; //loaded group increment
					loading = false; 
				
				}).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
					
					alert(thrownError); //alert with HTTP error
					$('.animation_image').show(); //hide loading image
					loading = false;
				
				});
				
			}
		}
	});
}); 


/************GRID FUNCTION***************/

$(document).ready(function(){
			arrange();
$("#slide-nav .navbar-toggle").on("click", function() {
    $("body , html").scrollTop(0);
});

		
                

/*LOG-IN VALIDATIONS*/
if(jQuery('body').attr('id')==='login') {
                //form validation rules
                $("#login-form").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        login_password: {
                            required: true,
                            minlength: 5
                        }
                    },
                    messages: {
                        login_password: {
                            required: "Please enter your password"
                        },
                        required: "Please enter your email address",
                        email: "Please enter valid Email Address"
                    },
                    submitHandler: function (form) {
                        $.ajax( {
                            url: base_url+'login/login_submit',
                            type: 'POST',
                            dataType: 'json',
                            async: true,
                            data: $('#login-form').serialize(),
                            success: function(response) {
                                // If there were form validation errors returned
                                if(response.success === 'false') {
                                    // Put the submit elements back

                                    //$('.header span').html(response.error).fadeOut(5000);
                                    $('#log-error-msg').html(response.error).show();
                                    return false;
                                }else if(response.success === 'true'){
                                    window.location.href=base_url+'user';
                                }
                            },
                            error: function() {
                                // Put the submit elements back
                                //submitContainer.html(submitElems);
                            }
                        });
                    }
                });
            }
       

       



/*REGISTRATION VALIDATIONS*/


                //form validation rules
                $("#registration-form").validate({
                    
                    rules: {
                        companyname: "required",
                        firstname: "required",
                        lastname: "required",
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
                        companyname: "Please enter your Company Name",
                        firstname: "Please enter your First Name",
                        lastname: "Please enter your Last Name",
                        password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long"
                        },
                        confirm_password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long",
                            equalTo: "Please enter the same password as above"
                        },
                        email: "Please enter a valid email address"
                       
                    },
                    submitHandler: function (form) {
                       
                        $.ajax( {
                            url: base_url+'login/registration_submit',
                            type: 'POST',
                            dataType: 'json',
                            async: true,
                            data: $('#registration-form').serialize(),
                            success: function(response) {

                                // If there were form validation errors returned
                                if(response.success === 'false') {

                                    $('#regi-error-msg').html(response.error).show();
                                    $('#email').focus();
                                    return false;
                                }else if(response.success === 'true'){

                                    $('#regi-success-msg').html(response.success_message).show().focus();
                                    $('#registration-form').hide();
                                     $('#regi-error-msg').hide();
                                }



                            },
                            error: function() {

                            }
                        });
                    }


                });
$("#header-search").validate({
                    
                    rules: {
                        searchinput: "required"
                       
                    },
                    messages: {
                        searchinput: "Please enter search term."
                    },
                    submitHandler: function (form) {
                       var searchterm=$('#searchinput').val();
                        window.location.href='/search/'+searchterm;
                        return false;
                    }

                });
$('#seacrhbtn').on('click',function(){

  $("#header-search").submit();
});
                });

/*add_posting VALIDATIONS*/
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
        
 $("#add_post-form").validate({
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
                          file: {
                                          required: true,
                                          fileCheck: true
                              }
                    },
                  messages: {
                              title: {
                                         required: "Please title"
                              },
                                 //  description: {
                                     //    required: "Please desription",
                            //  },
                          external_url: {
                                         required: "Please enter url"
                              },
                            file: {
                               required: "Please select the file"
                              }
    
           }
 
               
     });
    
});
$(function(){
    $(document).on('click',"a[rel='categorylinks']",function(e){
        var catid=$(this).attr('catid');
        var is_sub=$(this).attr('is_sub');
        var atext=$(this).text();
        //get the link location that was    
        pageurl = $(this).attr('href');
        if(is_sub !='yes'){
            getcategory(atext,catid,'');
        }
        
        getposting(catid);
        //to change the browser URL to the given link location
        if(pageurl!=window.location){
            window.history.pushState({path:pageurl},'',pageurl);
        }
        //stop refreshing to the page given in
        return false;
    });
});

function copyClick(obj){
      var pageurl=$(obj).attr('href');
       var catid=$(obj).attr('catid');
        var catname=$(obj).html();
        
       $(obj).closest('dl').nextAll().remove();
        //if(is_sub !='yes'){
        if(catid > 0){  
        getcategory('',catid,catname);
       
        
        getposting(catid);
        //to change the browser URL to the given link location
        if(pageurl!=window.location){
            window.history.pushState({path:pageurl},'',pageurl);
        }
      }
        //stop refreshing to the page given in
        return false;

}
  function getposting(catid){
      track_load=0;
      
      var postcount=$('#postcount').val();
      $('#category_id').val(catid);
      var limit =$('#limit').val();
      if(postcount < limit){
          total_groups=0;

      }else{
          var page=postcount/limit;
          //alert(postcount+limit+page);
      }
      
        $.ajax({
       
                url: base_url+'posting/getAjaxPosting/'+catid+'/'+track_load+'/'+limit,
                type: 'GET',
                 // async: true,

                success: function(response) {   
                    $('#tiles').empty();
                   $('#tiles').append(response);
                    arrange();
                    track_load++;
                }
               
               
               
            });
}



  function getcategory(atext,catid,catname){
    $.ajax({
        url: base_url+'categories/getsubcategories/'+catid,
        type: 'GET',
        dataType: 'json',
        async: true,
        success: function(data) {
            var postings=data.listingcount;
            $('#postcount').val(postings);
            var cat_id=[];
            var cat_name=[];
            var html="";
            if(atext != '') { html+="<h3>"+atext+"</h3>"; catname=atext;} 
            if(atext == '') catname=catname;
            if(data.subcategories.length > 0 ){
              html+='<dl class="select-dropdown drop-select"><dt><a href="javascript:void(0);"><span>Browse '
              +catname+'</span></a></dt> <dd><ul>';
              //html+="<select onchange='copyClick(this);'  id='"+catid+"' class='subcateoptions custom-select'> <option value='0'><b>Select</b></option>";
              $.each( data.subcategories, function( i,categories) {
                html+='<li><a href="'+base_url+"category/"+clean(categories.name)+'"  catid="'+categories.id+'" value="'+categories.id+'">'+categories.name+'</a></li>';
                 //html+="<option value='"+categories.id+"' link='"+base_url+"category/"+clean(categories.name)+"' catid='"+categories.id+"'>"+categories.name+"</option>";
                          //html+="&nbsp<a rel='categorylinks' is_sub='yes' href='"+base_url+"category/"+clean(categories.name)+"' catid='"+categories.id+"' >"+categories.name+"</a>";
                        // data=categories.id+','+categories.name;
                          // $('#subcategory').html(html);
              });
              //html+='</select>';
              html+='</ul></dd></dl>';
            }else{
              
            }
            if(atext == ''){
                $('#subcategory').append(html);
               
            }else{
              $('#subcategory').html(html);
              
            }
            
        }
               
    });
  }
	
	
	
	
//$(document).ready(function(){
//$(".categories ul li .main-cat span").click(function() {
//if(!$(this).parent().next().is(':visible')){
// $( "div.sub-categories:visible" ).slideUp();
// $( "div.sub-categories:visible" ).prev().children().toggleClass("fa-minus-square");
// $( "div.sub-categories:visible" ).prev().toggleClass("active");
//}
//   $(this).parent().next().slideToggle();
//  $(this).toggleClass("fa-minus-square");
//  $(this).parent().toggleClass("active");
//});











$(document).ready(function(){
$(".categories ul li .toggle-sub").click(function() {
if(!$(this).next().is(':visible')){
 $( "div.sub-categories:visible" ).slideUp();
 $( "div.sub-categories:visible" ).prev().toggleClass("fa-minus-square active");
 $( "div.sub-categories:visible" ).prev().prev().toggleClass("active");
}
   $(this).next().slideToggle();
  $(this).toggleClass("fa-minus-square active");
  $(this).prev().toggleClass("active");
});

$(".categories ul li .main-cat, .categories ul li .sub-categories").click(function() {
   $('.fixed-bar').animate({ width: 'toggle'}, 500);
});













$('.categories .sub-categories a').click(function(){
    $('.categories .sub-categories a').removeClass("active");
    $(this).addClass("active");
});

$('.all-categories ul li a').click(function(){
    $('.all-categories ul li a').removeClass("active");
    $(this).addClass("active");
}); 


//$('.menu-toggle').click( function() {
//     var toggleWidth = $(".fixed-bar").width() == 500 ? "0" : "400px";
//     $('.fixed-bar').animate({ width: toggleWidth });
//});


$('.menu-toggle').on('click', function() {
$('.fixed-bar').animate({ width: 'toggle'}, 500);
});


$('.view-all-cat').click(function(){
    $('.all-categories').animate({height:'toggle'},500);
	$(this).children('span').toggleClass('active');
	$(this).children('span').children('i').toggleClass('fa-chevron-down');
});
});
jQuery(function($) {
  $('a[href^="http://"],a[href^="https://"]')
    .not('[href*="drillyourskills.local"]')
    .click(function(e) {
      var url = this.href;
     
      e.preventDefault();
      window.open(url);
    })
});
$(document).ready(function() {
            $(document).on('click',".select-dropdown dt a",function() {
               $(".select-dropdown dd ul").hide();
                $(this).parent().next().children(".select-dropdown dd ul").toggle();

            });
                        
            $(document).on('click',".select-dropdown dd ul li a",function(e) {
              e.preventDefault();
              copyClick($(this));
                var text = $(this).html();
                
                $(this).parent().parent().parent().prev().children().children(".select-dropdown dt a span").html(text);
                $(this).parent().parent(".select-dropdown dd ul").hide();
                $("#result").html("Selected value is: " + getSelectedValue("sample"));
            });
                        
            function getSelectedValue(id) {
                return $("#" + id).find("dt a span.value").html();
            }

            $(document).on('click', function(e) {
                var $clicked = $(e.target);
                if (! $clicked.parents().hasClass("select-dropdown"))
                    $(".select-dropdown dd ul").hide();
            });
        });
$(document).ready(function () {


    //stick in the fixed 100% height behind the navbar but don't wrap it
    $('#slide-nav.navbar-inverse').after($('<div class="inverse" id="navbar-height-col"></div>'));
  
    $('#slide-nav.navbar-default').after($('<div id="navbar-height-col"></div>'));  

    // Enter your ids or classes
    var toggler = '.navbar-toggle';
    var pagewrapper = '#main';
    var navigationwrapper = '.navbar-header';
    var menuwidth = '100%'; // the menu inside the slide menu itself
    var slidewidth = '70%';
    var menuneg = '-100%';
    var slideneg = '-70%';


    $("#slide-nav").on("click", toggler, function (e) {

        var selected = $(this).hasClass('slide-active');

        $('#slidemenu').stop().animate({
            left: selected ? menuneg : '0px'
        });

        $('#navbar-height-col').stop().animate({
            left: selected ? slideneg : '0px'
        });

        $(pagewrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });

        $(navigationwrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });


        $(this).toggleClass('slide-active', !selected);
        $('#slidemenu').toggleClass('slide-active');


        $('#page-content, .navbar, body, .navbar-header').toggleClass('slide-active');


    });


    var selected = '#slidemenu, #page-content, body, .navbar, .navbar-header';


    $(window).on("resize", function () {

        if ($(window).width() > 767 && $('.navbar-toggle').is(':hidden')) {
            $(selected).removeClass('slide-active');
        }


    });

$('#main').css('margin-left',$('.fixed-bar ').width()+'px');


});
