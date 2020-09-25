<div id="wrapper">
    <div class="container">
        <div class="row">
          <?php $this->load->view('common/breadcrumb');?>
            
            <div class="col-lg-9" >
                <?php foreach($listings as $list){ ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="bold_txt"><a title="<?php echo $list->title;?>" href="<?php echo base_url();?>articles/<?php echo getDashedUrl($list->name)?>/<?php echo getDashedUrl($list->title)?>/<?php echo $list->id?>">
                            <?php echo $list->title; ?>
                            </a>
                        <span class="pull-right"><?php //echo date('D, F jS Y',$list->dt_created);?></span>
                    </h4></div>
                    <div class="panel-body details_ques_ans text-justify">
                        <?php echo word_limiter(custom_strip_tags($list->description),150,'<a href="'.base_url().'articles/'.url_title($list->name,'-',true).'/'.url_title($list->title,'-',true).'/'.$list->id.'" title="'.$list->title.'"> more...</a>');?>
                        
                    </div>
                    <div class="panel-footer">
                        Catgeory:<a title="<?php echo $list->name;?>" href="<?php echo base_url()?>articles/<?php echo url_title($list->name,'-',true).'/'.$list->category_id;?>">
                                    <?php echo $list->name;?>
                                </a>
                    </div>
              </div>
              <br/>
                <?php } ?>
              <div class="col-md-12 text-right"><?php echo '<nav>'.$this->pagination->create_links().'</nav>'; ?></div> 
            </div>
            <div class="col-md-3 col-sm-3">
            <?php $this->load->view('rightcol');?>
            </div>
        </div>
    </div>
</div>
