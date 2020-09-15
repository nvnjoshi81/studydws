<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo ucwords($searchtype);?></h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <form method="post" action="<?php echo base_url('admin/'.$searchtype.'/search')?>">
            <div class="panel">
                <div class="panel-heading">Enter ID to search</div>
                    <div class="input-group custom-search-form col-md-4">
                    <input required="true" type="text" placeholder="Search..." class="form-control" name="search">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
             
    </div>
    </form> 
         <?php if(isset($answers)){ ?>
        <div class="row">
      <div class="panel panel-default">
        <div class="form-group">
                 <label>Question</label>
            <div class="text-right">
            <?php
            
            $path_edit_content ='admin/content/editcontent/';
            $var_item_question_id=$question->id;
            ?>
            <a href="<?php
	echo base_url() .$path_edit_content .$var_item_question_id; ?>">
                    <i class="fa fa-edit cat-edit"></i>
            </a>
            </div>
                 
            <div><?php echo custom_strip_tags($question->question);?></div>
            </div>
           
             <?php if(isset($answers)){ $cc=1; foreach($answers as $answer){ ?>
            <div class="form-group">
               <label>Answer <?php echo $cc?></label>
        <p><?php echo custom_strip_tags($answer->answer);?></p>
        <hr>
            </div>
            
             <?php $cc++; }} ?>            
         
      </div>
      
</div>
             <?php } ?>
    </div>
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
    var FONT = MathJax.OutputJax["HTML-CSS"].Font;
    FONT.loadError = function (font) {
      MathJax.Message.Set("Can't load web font TeX/"+font.directory,null,2000);
      document.getElementById("noWebFont").style.display = "";
    };
    FONT.firefoxFontError = function (font) {
      MathJax.Message.Set("Firefox can't load web fonts from a remote host",null,3000);
      document.getElementById("ffWebFont").style.display = "";
    };
  });

(function (HUB) {
  
  var MINVERSION = {
    Firefox: 3.0,
    Opera: 9.52,
    MSIE: 6.0,
    Chrome: 0.3,
    Safari: 2.0,
    Konqueror: 4.0,
    Unknown: 10000.0 // always disable unknown browsers
  };
  
  if (!HUB.Browser.versionAtLeast(MINVERSION[HUB.Browser]||0.0)) {
    HUB.Config({
      jax: [],                   // don't load any Jax
      extensions: [],            // don't load any extensions
      "v1.0-compatible": false   // skip warning message due to no jax
    });
    setTimeout('document.getElementById("badBrowser").style.display = ""',0);
  }
  
})(MathJax.Hub);

MathJax.Hub.Register.StartupHook("End",function () {
  var HTMLCSS = MathJax.OutputJax["HTML-CSS"];
  if (HTMLCSS && HTMLCSS.imgFonts) {document.getElementById("imageFonts").style.display = ""}
});

</script>
<script type="text/javascript" src="<?php echo base_url('assets')?>/MathJax/MathJax.js"></script>                   