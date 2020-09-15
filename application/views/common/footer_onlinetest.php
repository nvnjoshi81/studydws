
<!-- /.container -->

<!-- jQuery -->
<script src="<?php echo get_assets('assets/frontend/js/jquery.js') ?>"></script>
<script src="<?php echo get_assets('assets/frontend/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_assets('assets/frontend/js/material.js'); ?>"></script>
<script src="<?php echo get_assets('assets/frontend/js/jquery.validator.js') ?>"></script>
<script src="<?php echo get_assets('assets/frontend/js/isotope-docs.min.js') ?>"></script> 
<script src="<?php echo get_assets('assets/frontend/js/toastr.min.js') ?>"></script>
<script src="<?php echo get_assets('assets/frontend/js/pinterest_grid.js') ?>"></script>
<script src="<?php echo get_assets('assets/frontend/js/common.js') ?>"></script>
<script>
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    if (isChrome) {
        $('#videoplayer_div').click(function () {
            if ($("#videoplayer").get(0).paused) {
                $("#videoplayer").get(0).play();
            } else {
                $("#videoplayer").get(0).pause();
            }
        });
    }
    $('#updatePass').click(function () {
        var confirm_password = $('#confirm_password').val();
        var password = $('#password').val();
        if ((password != '') && (confirm_password != password)) {
            alert('Password and Confierm Password Not Equal!');
            return false;
        }

    });


</script>
<script>
    $(document).ready(function () {
        $.material.init();
        $(window).bind('scroll', function () {
            var navHeight = 148;
            ($(window).scrollTop() > navHeight) ? $('nav.mainnav').addClass('goToTop') : $('nav.mainnav').removeClass('goToTop');
        });
    });
</script>



<!-- Script to Activate the Carousel -->
<script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    });
    function checkdvd() {
        if ($('input#dvdreq').is(':checked')) {
            $('#delivery_req').val(1);
        }


    }
</script>

<script>
    $(document).ready(function () {

        //Check to see if the window is top if not then display button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.totop').fadeIn();
            } else {
                $('.totop').fadeOut();
            }
        });

        //Click event to scroll to top
        $('.totop').click(function () {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });

    });
</script>
<?php
if (isset($scripts) && count($scripts) > 0) {
    foreach ($scripts as $key => $script) {
        ?>
        <script type="text/javascript" src="<?php echo strpos($script, 'http') !== false ? $script : $this->config->item('web_root') . $script; ?>"></script>

    <?php }
} ?>

<?php if (isset($loadMathJax)) { ?>
    <!--mathJax -->
    <script type="text/x-mathjax-config">
        //
        //  Do NOT use this page as a template for your own pages.  It includes 
        //  code that is needed for testing your site's installation of MathJax,
        //  and that should not be used in normal web pages.  Use sample.html as
        //  the example for how to call MathJax in your own pages.
        //
        MathJax.HTML.Cookie.Set("menu",{});
        MathJax.Hub.Config({
        extensions: ["tex2jax.js","TeX/AMSmath.js", "TeX/AMSsymbols.js"],
        jax: ["input/TeX","output/HTML-CSS"],
        "HTML-CSS": {availableFonts:["TeX"], linebreaks: { automatic: true },
        styles: {".MathJax_Preview": {visibility: "hidden"},".MathJax_Display":{display:'inline'}}
        }
        });
        MathJax.Hub.Register.StartupHook("HTML-CSS Jax Ready",function () {
        MathJax.Hub.Insert(MathJax.InputJax.TeX.Definitions.macros,{
        cancel:  ["Extension","cancel"],
        bcancel: ["Extension","cancel"],
        xcancel: ["Extension","cancel"],
        cancelto:["Extension","cancel"]
        });
        var HTMLCSS = MathJax.OutputJax["HTML-CSS"];
        if (HTMLCSS && HTMLCSS.imgFonts) {document.getElementById("imageFonts").style.display = ""}

        var FONT = MathJax.OutputJax["HTML-CSS"].Font;
        FONT.loadError = function (font) {
        MathJax.Message.Set("Can't load web font TeX/"+font.directory,null,2000);
        document.getElementById("noWebFont").style.display = "";
        };
        FONT.firefoxFontError = function (font) {
        MathJax.Message.Set("Firefox can't load web fonts from a remote host",null,3000);
        document.getElementById("ffWebFont").style.display = "";
        };
        $("ul#filter li a").click(function(){
        var $grid = $('.grid').isotope({
        // options
        });
        var selText = $(this).text();
        var filter=$(this).attr('tag');

        $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
        $grid.isotope({ filter: '.'+filter });
        });
        });		
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/MathJax/MathJax.js"></script>
<?php } ?>

<script>
$(document).ready(function() {
  document.getElementsByTagName("html")[0].style.visibility = "visible";
});
    $(document).on('click', '#mloginbtn', function () {
        $('#mainlogin').show('slow');
        $('#mainsignup').hide('slow');
        $('#login_msg').html('');
        $('.error-notice').hide();
        return false;
    });
    $(document).on('click', '#msignupbtn', function () {
        $('#mainlogin').hide('slow');
        $('#mainsignup').show('slow');
        $('#login_msg').html('');
        $('.error-notice').hide();
        return false;
    });
<?php if ($this->session->userdata('ask_mobile') == 1) { ?>
        $(window).load(function () {
            $('#addmobile').modal({show: true, backdrop: 'static', keyboard: false});
        });
<?php } elseif ($this->session->userdata('ask_mobile_verification') == 1) { ?>
        $(window).load(function () {
            $('#otpverification').modal({show: true, backdrop: 'static', keyboard: false});
            $('#otpverification').on('shown.bs.modal', function (e) {

                $.ajax({
                    method: "GET",
                    url: base_url + "customer/welcome/generateOtp",
                    success: function (data) {

                    }
                });
                // do something...
            });
        });
<?php } ?>

    $('body').on('shown.bs.modal', function (e) {
        $("#add_mobile").validate({
            ignore: "",
            rules: {
                // Rules for validation


                mobile: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true

                }
            },
            messages: {
                // messages for valided fields

                mobile: {
                    required: "Please enter 10 digit mobile number.",
                    minlength: 'Please enter 10 digit mobile number.',
                    maxlength: 'Please enter 10 digit mobile number.',
                }
            }
        });
        $("#otp_verification").validate({
            ignore: "",
            rules: {
                // Rules for validation


                mobile: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    digits: true

                }
            },
            messages: {
                // messages for valided fields

                mobile: {
                    required: "Please enter 6 digits OTP.",
                    minlength: 'Please enter 6 digits OTP.',
                    maxlength: 'Please enter 6 digits OTP.',
                }
            }
        });
    });
    function getCity() {
        var state_id = $('#state').val();
        $.ajax({
            type: "GET",
            url: base_url + "common/cities/" + state_id,
            //data:'email=' + $('#email').val() + '&password=' + $('#password').val(),
            //dataType: "json",
            success: function (response)
            {
                $('#city').html(response);
                //alert(response.toSource());
                /*if(response.success===false){ 
                 $('#err_msg').html(response.message).show();
                 }else{
                 window.location.href=base_url+'account';
                 }*/
            }
        });
    }

    $(document).ready(function () {
        if ($('.product-description').get(0)) {
            $('.product-description').shorten({
                moreText: 'read more',
                lessText: 'read less',
                showChars: 500,
            });
        }
    });
    $(document).ready(function () {
        $('#pinBoot').pinterest_grid({
            no_columns: 4,
            padding_x: 10,
            padding_y: 10,
            margin_bottom: 50,
            single_column_breakpoint: 700
        });
    });
    $("#mainsearch").submit(function (event) {
        var query = $("#search_txt").val();
        var type = $('input[name=search]:checked', '#mainsearch').val()
        var action = base_url + 'search/' + query + '/' + type;
        window.location.href = action;
        event.preventDefault();
    });

  



</script>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-40859911-1', 'studyadda.com');
ga('send', 'pageview');

</script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-40859911-1");
pageTracker._trackPageview();
} catch(err) {}
</script>
<?php 
$showFooterlinks='yes';
if($showFooterlinks=='yes') {  
?>
<div id="google_translate_element"></div>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
  window.addEventListener('load', function() {
    var setInt = setInterval(function() {
      if (jQuery('.form-box:contains("You are successfully registered")').is(":visible")) {
        ga('send', 'event', 'form', 'submit', 'sign up');
        clearInterval(setInt);
      }
    }, 7000)
  })



jQuery(document).ready(function(){
    delay();
});

function delay() {
    var secs = 10000;
    setTimeout('initFadeIn()', secs);
}

function initFadeIn() {
     document.getElementById("synteq").style.opacity = 1;
}
</script>
<?php } ?>
<div class="modal fade" id="forgotpassword" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form action="" method="post" name="forgot_password" id="forgot_password">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Reset Password.</b></h4>
                </div>
                <div class="modal-body" id="forgetpass_content">
                    Email : <input class="form-control email_form" type="" name="email" id="email">
                </div>
                <div class="modal-footer" id="forgetpass_content_button">
                    <button type="submit" class="btn btn-success">Send Password</button>
                    <button type="cancel" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!------forgot password pop up--->
<div class="modal fade" id="addmobile" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form action="<?php echo base_url('customer/welcome/updatemobile') ?>" method="post" name="add_mobile" id="add_mobile">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><b>Add Mobile</b></h4>
                </div>
                <div class="modal-body">
                    Enter Mobile Number <input class="form-control email_form" type="" name="mobile" id="mobile">
                </div>
                <div class="modal-footer" id="forgetpass_content_button"><button type="submit" class="btn btn-success text-right">Submit</button>

                </div><div id="forgetpass_content_button" class="">
                   <a href="customer/logout" class="btn btn-success text-left">Logout</a> 

                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="otpverification" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form action="<?php echo base_url('customer/welcome/verifyotp') ?>" method="post" name="otp_verification" id="otp_verification">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><b>Enter OTP</b></h4>
                    <p>OTP has been sent to your mobile number and is valid for one hour</p>
                </div>
                <div class="modal-body">
                    Enter One Time Password <input class="otp form-control email_form" type="" name="otp" id="otp">
                </div>
                <div class="modal-footer" id="forgetpass_content_button">
                    <button type="submit" class="btn btn-success">Submit</button>

                </div>
            </div>
        </form>
    </div>
</div>
</body>

</html>
