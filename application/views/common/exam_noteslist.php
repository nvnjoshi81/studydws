<div class="row">
    <?php 
    $count = 1;
        foreach ($notes as $qb) {
                        /*if ($count == 20 && $this->uri->total_segments() == 1)
                            break;
                         *
                         *  */
                        if ($count > count($this->config->item('bgimages'))) {
                            $count = 1;
                        }
                        $index = $count - 1;
                        ?>
    <!-- style="background-size: 100% 100%; background-repeat: no-repeat;background-image: url('/assets/frontend/images/<?php //echo $this->config->item('bgimages')[$count - 1] ?>');"-->
	<?php
	 if(isset($qb->subject)&&$qb->subject!=''){
	   $qbsubject=$qb->subject;
   }else{
	   $qbsubject='allsubject';
   }
   if(isset($qb->chapter)&&$qb->chapter!=''){
	   $qbchapter=$qb->chapter;
   }else{
	   $qbchapter='allchapter';
   } ?>
    <a href="<?php echo generateContentLink('notes', $qb->exam, $qbsubject, $qbchapter, $qb->title, $qb->id); ?>">
                      
                        <div class="col-xs-6 col-sm-4 col-md-2">
                       
                        <div class="col-item offer offer-success" style="height:140px;"> 
                            <div class="shape">
					<div class="shape-text">
						<span  class="glyphicon glyphicon  glyphicon-info-sign"></span>
					</div>
                                
				</div>
                            <div>
                                    <div class="offer-content">
                                        
                                        <?php     $prdname_cnt=strlen($qb->title);
                 
                $prdhead_cnt=$prdname_cnt;
        
                                           if($prdhead_cnt>35){
                                               $prdhead= substr($qb->title,0,35).'..';
											  //'<h5 style="color:#000">'.$qb->chapter.'</h5>';
                                           
                                               // $prdhead= $qb->title ;
                                           
										   } else{
                                                $prdhead= $qb->title ;
                                           
                                           }
                                           
                                        ?>
                                    <h6 class="vid_prod_hed" title="<?php    echo $qb->title; ?>"><?php    echo $prdhead; ?></h6>       
                                    </div>
             <div class="separator btn_prod_ved">
                                        <p class="buy_btn">   <button class="btn-lg btn-sm btn-md btn btn-raised btn-success" name="btnAlreadyExist">Read Now</button>
                                        </p> 
                                    </div>
                                                            </div>
                        </div>
                    </div>
    </a>
                        <?php
                        $count++;
                    }
                    ?>
</div>