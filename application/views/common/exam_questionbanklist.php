<div class="row">
    <?php 
    $count = 1;
                     foreach ($questionbanks as $qb) {
                        if ($count == 9 && $this->uri->total_segments() == 1)
                            break;
                        if ($count > count($this->config->item('bgimages'))) {
                            $count = 1;
                        }
                        $index = $count - 1;
                        ?><a href="<?php echo generateContentLink('question-bank', $qb->exam, $qb->subject, $qb->chapter, $qb->name, $qb->id); ?>" title="<?php echo $qb->name; ?>">
                    <!--<div class="outer col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                   
                        <div class="container1">
                                <div class="content">
                                    
                        <?php //echo $qb->name; ?><?php //if($qb->chapter){ echo '<br><h5 style="color:#000">'.$qb->chapter.'</h5>'; } ?>                                       
                                </div>
                            </div>
                        </div>
					-->
                     <div class="col-xs-6 col-sm-4 col-md-2" >
                        <div class="col-item offer offer-success" style="height:140px;">                            
                            	<div class="shape">
					<div class="shape-text">
						<span class="glyphicon glyphicon  glyphicon-file"></span>							
					</div>
				</div>
                            <div>
                               
                                    <div class="offer-content">
                                        
                                        <?php     $prdname_cnt=strlen($qb->name);
                 
                $prdhead_cnt=$prdname_cnt;
        
                                           if($prdhead_cnt>35){
                                               $prdhead= substr($qb->name,0,35).'..';//'<h5 style="color:#000">'.$qb->chapter.'</h5>';
                                           //$prdhead=$qb->name;
										   } else{
                                               $prdhead=$qb->name;
                                           
                                           }
                                           
                                        ?>
                                        
                                        
                                        <h6 class="vid_prod_hed" title="<?php    echo $qb->name; ?>"><?php    echo $prdhead; ?></h6>       
                                    </div>
             
                                    <div class="separator btn_prod_ved">
<div class="price"><h5 class="chepter-text-color"><?php $prdchap_cnt=strlen($qb->chapter);  

if($prdchap_cnt>30){
    //echo substr($qb->chapter,0,30); 
    
}else{
    //echo $qb->chapter;
} ?> 
   <button class="btn-lg btn-sm btn-md btn btn-raised btn-success" name="btnAlreadyExist">Practice Now</button> </h5></div>
                                                          
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