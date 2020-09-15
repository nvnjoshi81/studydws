        <div class="panel-groupl lftacc" id="accordion">
                 
                    <?php if(isset($subject_chapters)) { 
                        ?><div class="left_heading"><i class="material-icons">assignment_ind</i> Subjects</div><?php
                        foreach($subject_chapters as $key=>$value){ ?>
                    
                    <div class="panel panel-default">
               
                    <div class="panel-heading">
                        <span class="rht_page_open"><a href="<?php echo base_url($this->uri->segment(1).'/'.url_title($selectedexam->name,'-',TRUE).'/'.$selectedexam->id.'/'.url_title($key,'-',TRUE).'/'.$value['id'])?>"><i class="material-icons">chevron_right</i></a></span>  
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $value['id'];?>"><span class="lefticon fa fa-book">
                            </span><?php echo $key;?></a>
                        </h4>
                    </div>
                    
                    <div id="collapse_<?php echo $value['id'];?>" class="panel-collapse collapse">
                        <div class="panel-body leftmenupanel-body">
                            <ul>
                                  <?php foreach($value['chapters'] as $k=>$v){ ?>	
                                <li>
                                        <span class="lefticon glyphicon glyphicon-menu-right text-primary"></span>
                                        <a href="<?php echo base_url($this->uri->segment(1).'/'.url_title($selectedexam->name,'-',true).'/'.$selectedexam->id.'/'.  url_title($key,'-',true).'/'.$value['id'].'/'.url_title($v[1],'-',true).'/'.$v[0])?>"><?php echo $v[1];?></a>
                                    </li>
                                 <?php } ?>
                                
                            </ul>
                        </div>
                    </div>
                    </div>
                    <?php }} ?>
                    <?php if(!isset($subject_chapters) && isset($examcategories)) { 
                        ?><div class="left_heading"><i class="material-icons">assignment_ind</i> Exams</div><?php
                        foreach($examcategories as $exam){?>
                    
                    <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $exam->id?>"><span class="lefticon glyphicon glyphicon-folder-close">
                            </span><?php echo $exam->name;?></a>
                        </h4>
                    </div>
                    
                    <div id="collapse_<?php echo $exam->id?>" class="panel-collapse collapse">
                        <div class="panel-body leftmenupanel-body">
                            <table class="table">
                                  <tr>
                                    <td>   
                                    <a href="<?php echo base_url($this->uri->segment(1).'/'.  url_title($exam->name,'-',true).'/'.$exam->id)?>"><label  class="subname" >All Subject</label></a>
                                    </td>
                                </tr>
                                 <?php foreach($examsubjects[$exam->id] as $k=>$v){ ?>
                                <tr>
                                    <td>   
                                        <a href="<?php echo base_url($this->uri->segment(1).'/'.url_title($exam->name,'-',true).'/'.$exam->id.'/'.  url_title($k,'-',true).'/'.$v['id'])?>"><label  class="subname" ><?php echo $k;?></label></a>
                                    </td>
                                </tr>
                                 <?php } ?>
                                
                            </table>
                        </div>
                    </div>
                         </div>
                    <?php }} ?>
               
                
            </div>
            
        <!-- adv left panel -->
        <div class="left_advertisepanel">
        <img src="<?php echo base_url('');?>/assets/images/260adv.jpg" alt="adversite" />
        </div>
     
    

<!--<nav role="navigation" class="navbar-default navbar-side">
            <div class="sidebar-collapse">
                <ul id="main-menu" class="nav">
		<?php if(isset($subject_chapters)) { foreach($subject_chapters as $key=>$value){ ?>		
                    <li>
                        <a href="#">
                            <span class=" btn btn-primary btn-fab subjecticon"><?php echo substr($key,0,2)?></span>
                            <?php echo $key;?>
                            <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo base_url($this->uri->segment(1).'/'.url_title($selectedexam->name,'-',true).'/'.$selectedexam->id.'/'.  url_title($key,'-',true).'/'.$value['id'])?>">All Chapters</a>
                            </li>
                            <?php foreach($value['chapters'] as $k=>$v){ ?>	
                            <li>
                                <a href="<?php echo base_url($this->uri->segment(1).'/'.url_title($selectedexam->name,'-',true).'/'.$selectedexam->id.'/'.  url_title($key,'-',true).'/'.$value['id'].'/'.url_title($v[1],'-',true).'/'.$v[0])?>"><?php echo $v[1];?></a>
                            </li>
                            <?php } ?>
                            
                            </ul>
                    </li>
                <?php } }?>
                    <?php if(!isset($subject_chapters) && isset($examcategories)) { foreach($examcategories as $exam){ ?>		
                    <li>
                        <a href="<?php echo base_url($this->uri->segment(1).'/'.url_title($exam->name,'-',true).'/'.$exam->id)?>">
                            <i class="fa fa-sitemap fa-3x"></i> 
                            <?php echo $exam->name;?>
                        <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="<?php echo base_url($this->uri->segment(1).'/'.url_title($exam->name,'-',true).'/'.$exam->id)?>">All Subjects</a></li>
                            <?php foreach($examsubjects[$exam->id] as $k=>$v){ ?>	
                            <li>
                                <a href="<?php echo base_url($this->uri->segment(1).'/'.url_title($exam->name,'-',true).'/'.$exam->id.'/'.  url_title($k,'-',true).'/'.$v['id'])?>"><?php echo $k;?></a>
                            </li>
                            <?php } ?>
                            
                            </ul>
                            
                    </li>
                <?php } }?>
                  
                    	
                </ul>
               
            </div>
            
        </nav> -->
