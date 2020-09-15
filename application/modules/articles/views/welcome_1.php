<!--  ##########################################################################  -->
<section class="container middlepanelncert">
    <section class="row midsec">
        <!-- end top horizontal menucontainer-->
        <!--breadcrums container-->
        <!--<div class="container_bannner">cvbvcbc</div>-->
        <ol class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
        <?php if($this->router->fetch_method()=='category'){ ?>
            <li><a href="<?php echo base_url()?>articles">Articles</a></li>
            <li class="active"><?php echo $category->name;?></li>
        <?php }else{ ?>
            <li class="active">Articles</li>
        <?php } ?>
        </ol>
        <!-- end breadcrums container-->

        <!--Middle  content  container-->
        <div class="col-xs-12 col-md-9">
		
        <div class="article_body_panel">
        <h2 class="text-primary"><a href="#">Tsunami</a></h2>
          <div class="rev_article">
            <p class="col-md-5"><strong>Category : </strong><i>Secondary School Level</i></p>
            <p class="col-md-7 pull-right text-right"><strong>Posted by </strong> <i>onlineessay onlineessay Thu, January 21st 2016</i></p>
          </div>
          
          <p>Outline: Explaining the term and describing the brief condition of the calamity. Early history of the oceanic earthquakes causing tsunami. Generation of tsunami. Attempts to detect tsunami. Measure to reduce damages caused onshore during tsunami.</p>
          <p>Outline: Explaining the term and describing the brief condition of the calamity. Early history of the oceanic earthquakes causing tsunami. Generation of tsunami. Attempts to detect tsunami. Measure to reduce damages caused onshore during tsunami. <a href="#"> [ more... ]</a> </p> 
              
        </div>
          

           <div class="clearfix"></div> 
        
        <div class="article_body_panel">
        <h2 class="text-primary"><a href="#">Tsunami</a></h2>
          <div class="rev_article">
            <p class="col-md-5"><strong>Category : </strong><i>Secondary School Level</i></p>
            <p class="col-md-7 pull-right text-right"><strong>Posted by </strong> <i>onlineessay onlineessay Thu, January 21st 2016</i></p>
          </div>
          
          <p>Outline: Explaining the term and describing the brief condition of the calamity. Early history of the oceanic earthquakes causing tsunami. Generation of tsunami. Attempts to detect tsunami. Measure to reduce damages caused onshore during tsunami.</p>
          <p>Outline: Explaining the term and describing the brief condition of the calamity. Early history of the oceanic earthquakes causing tsunami. Generation of tsunami. Attempts to detect tsunami. Measure to reduce damages caused onshore during tsunami. <a href="#">[ more... ] </a> </p> 
              
        </div>
           
           
           <div class="clearfix"></div> 
        
           
           <div class="panel panel-success relatedques">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Related Articles</strong></h3>
          </div>
          <div class="panel-body">
            <a href="#">My Favourite City - Allahabad </a> | <a href="#">Hobbies </a> | <a href="#">All</a>
          </div>
        </div>



        
        </div>
        
        <!-- right panel -->
        <div class="col-sm-12 col-md-3 rht_status_mat">
                    <div class="panel panel-primary">
                	<div class="panel-heading">
                            <h4> <i class="material-icons">[A]</i> &nbsp;Arrticles Categories</h4>
                        </div>
                	<div class="panel-body">
                            <ul>
                                <li><i class="material-icons">play_arrow</i> <a href="#"> Science Projects And Inventions</a> </li>
                                <li><i class="material-icons">play_arrow</i><a href="#"> Science Projects And Inventions</a> </li>
                            </ul>
                        </div>
                    <!--<div class="panel-footer"> <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a href="#">View All</a> </div>-->
                    </div>
                     
                </div>
                
         <div class="col-sm-12 col-md-3 rht_status_mat">
                    <div class="panel panel-primary">
                	<div class="panel-heading">
                            <h4> <i class="material-icons">[A]</i> &nbsp;Archive</h4>
                        </div>
                	<div class="panel-body">
                            <ul>
                                <li><i class="material-icons">play_arrow</i> <a href="#"> January 2016 <span class="text-warning">(131)</span> </a> </li>
                                <li><i class="material-icons">play_arrow</i><a href="#">  December 2014 <span class="text-warning">(11)</span> </a> </li>
                            </ul>
                        </div>
                    <!--<div class="panel-footer"> <i class="glyphicon glyphicon-eye-open"> </i> &nbsp; <a href="#">View All</a> </div>-->
                    </div>
                     
                </div>        
                
        
        
        

        <aside class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="clear"></div>
            <div class="top-search col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                <form id="newssearch" action="">
                    <input type="text" id="newssearch-q" name="newssearch-q" autocomplete="off" title="" class="glow placeholder" value="Search your News here">
                        <button class="search-button" type="submit" title="Search"></button>
                    </form>
                </div>
                <div class="clear"></div>
                <!--news and updates box starts  container-->
                <div class="box_closed">
                    <div class="clear"></div>
                    <div class="clear"></div>
                    <!--news list starts-->
                    <ul class="sa_news_list" id="paging-content">
                        <?php foreach($listings as $list){ ;?>
                        <li class="row">
                            <h3 class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                <a title="<?php echo $list->title;?>" href="<?php echo $this->config->item('web_root');?>articles/<?php echo getDashedUrl($list->name)?>/<?php echo getDashedUrl($list->title)?>/<?php echo $list->id?>">
                                    <?php echo $list->title;?>
                                </a>
                            </h3>
                            <h4 class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <?php echo date('D, F jS Y',$list->dt_created);?>
                            </h4>
                            <h5> Category : 
                                <a title="<?php echo $list->name;?>" href="<?php echo $this->config->item('web_root');?>articles/<?php echo getDashedUrl($list->name).'/'.$list->category_id;?>">
                                    <?php echo $list->name;?>
                                </a>
                                <em></em>
                            </h5>
                            <!--	<p class="meta"></p><a href="#" class="image"><img src="images/photo_60x60.jpg" class="img-responsive" alt="Electricity Meter" title="Electricity Meter"></a>-->
                            <p>
                                <?php echo substr($list->description,0,450);?>&nbsp;&nbsp;

                                <a href="<?php echo $this->config->item('web_root');?>articles/<?php echo getDashedUrl($list->name)?>/<?php echo getDashedUrl($list->title)?>/<?php echo $list->id?>" title="<?php echo $list->title?>">More...</a>
                            </p>
                        </li>
                        <?php } ?>
                    </ul>
                    <!--news list end container-->
                    <!--<div class="more"><a href="">View More </a></div>-->
                    <div class="clear"></div>
                     <div class="col-md-12 text-right"><?php echo '<nav>'.$this->pagination->create_links().'</nav>'; ?></div> 
                </div>
                <div class="clear"></div>
                <div class="clear"></div>
                <div id="latest_news_cntr" class="box_closed">
                    <h3>Featured Articles</h3>
                    <div class="clearfix"></div>
                    <ul class="row">
                        
                             <?php foreach($featured as $ls){ ?>
                                        <li class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <a href="<?php echo $this->config->item('web_root');?>articles/<?php echo getDashedUrl($ls->name).'/'.getDashedUrl($ls->title).'/'.$ls->id?>">
                                                <img width="100%" title="<?php echo $ls->title?>" alt="<?php echo $ls->title?>" src="<?php echo $this->config->item("web_root")?>images/students_image.jpg" class="img-responsive">
                                                <?php echo $ls->title;?>
                                            </a>
                                        </li>
                             <?php } ?>
                            
                                </ul>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                            <div class="box_closed">
                                <h3>Recent Articles</h3>
                                <!--recent news box starts  container-->
                                <div id="related_news_container" class="box">
                                    <div class="pagination"></div>
                                    <!---------------------------------recent news list------------------------------------->
                                    <ul id="pagging-content" class="sa_related_news">
                                        <?php foreach($recent as $ls){ ?>
                                        <li>
                                            <a href="<?php echo $this->config->item('web_root');?>articles/<?php echo getDashedUrl($ls->name).'/'.getDashedUrl($ls->title).'/'.$ls->id?>">
                                                <?php echo $ls->title;?>
                                            </a>
                                        </li>
                                         <?php } ?>
                                        
                                    </ul>
                                    <!---------------------------------recent news list ends------------------------------------->
                                    <div class="pagination"></div>
                                    <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <!--<div id="related-tags-section" class="box_closed">
                                <h3>Tag Cloud</h3>
                                <ul class="related-tags">
                                    <li>
                                        <a href="">systems of equations </a>
                                    </li>
                                    <li>
                                        <a href="">Officer on Horseback </a>
                                    </li>
                                    <li>
                                        <a href="">Patterns and Equations</a>
                                    </li>
                                    <li>
                                        <a href="">Two Passing Bicycles</a>
                                    </li>
                                    <li>
                                        <a href="">Word Problem</a>
                                    </li>
                                    <li>
                                        <a href="">Solving Systems of Equations</a>
                                    </li>
                                    <li>
                                        <a href="">Problem Solving Linear Systems</a>
                                    </li>
                                    <li>
                                        <a href="">ystems of Three Variables Systems of Three Variables</a>
                                    </li>
                                    <li>
                                        <a href="">systems of Inequalities</a>
                                    </li>
                                    <li>
                                        <a href="">Inequalities System of Inequalities Application f</a>
                                    </li>
                                    <li>
                                        <a href="">Types of Linear Systems</a>
                                    </li>
                                    <li>
                                        <a href="">Systems Graphing systems</a>
                                    </li>
                                    <li>
                                        <a href="">Systems and rate problems </a>
                                    </li>
                                    <li>
                                        <a href="">elimination Solving systems by elimination </a>
                                    </li>
                                    <li>
                                        <a href="">Addition Elimination Method</a>
                                    </li>
                                </ul>
                                <div class="clear"></div>
                            </div>-->
                        </aside>
                        <!---------------------------------End Middle  content  container-------------------------------------->
                        <?php $this->load->view('rightcol');?>
                        </section>
                        <div class="clear"></div>
                    </section>
                    <!--  ##########################################################################  -->
