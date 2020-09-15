
<!-- /.container -->

<!-- jQuery -->
<script src="<?php echo get_assets('assets/frontend/js/jquery.js') ?>"></script>
<script src="<?php echo get_assets('assets/frontend/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_assets('assets/frontend/js/material.js'); ?>"></script>
<script src="<?php echo get_assets('assets/frontend/js/jquery.validator.js') ?>"></script>
<script src="<?php echo get_assets('assets/frontend/js/isotope-docs.min.js') ?>"></script> 
<script src="<?php echo get_assets('assets/frontend/js/toastr.min.js') ?>"></script>

<script src="<?php echo get_assets('assets/frontend/js/common.js') ?>"></script>
<script type="text/javascript">
    function checkSingleQus(aId,aRight){ 
        //$('#ansblock').children('i').css('display','none'); 

$( "span.ansblock" ).children().css('display','none'); 
        if(aRight==1){
            $("#ansright_"+aId).css('display', 'block');
            
        }else{
            $("#answrong_"+aId).css('display', 'block');
        }
    }
</script>
<script>
    $(document).ready(function () {
        $.material.init();
        $(window).bind('scroll', function () {
            var navHeight = 148;
            ($(window).scrollTop() > navHeight) ? $('nav.mainnav').addClass('goToTop') : $('nav.mainnav').removeClass('goToTop');
        });
    });
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
        "HTML-CSS": {
        availableFonts:[],
        styles: {".MathJax_Preview": {visibility: "hidden"},".MathJax_Display":{display:'inline'}}
        }
        });

        MathJax.Hub.Register.StartupHook("HTML-CSS Jax Ready",function () {
        MathJax.Hub.Insert(MathJax.InputJax.TeX.Definitions.macros,{
        cancel: ["Extension","cancel"],
        bcancel: ["Extension","cancel"],
        xcancel: ["Extension","cancel"],
        cancelto: ["Extension","cancel"]
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
    
    function showHideans(qaid){
          $("#ansBlock_"+qaid).toggle();
    }
    
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

$(document).on('click','#report_error',function(){
    $('#error_box').toggle();
});


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
    }, 1000)
  })

</script>
<?php } ?>

</body>

</html>
