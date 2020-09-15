<div class="row">
    <?php 
    $count = 1;
                     foreach ($ot as $qb) {
                        if ($count == 9 && $this->uri->total_segments() == 1)
                            break;
                        if ($count > count($this->config->item('bgimages'))) {
                            $count = 1;
                        }
                        $index = $count - 1;
						
						if(isset($qb->chapter)&&$qb->chapter!==''){
							$chaptername=$qb->chapter;
						}else{
							$chaptername=$qb->name;
						}
                        ?>
						<a href="<?php echo generateContentLink('online-test', $qb->exam, $qb->subject, $chaptername, $qb->name, $qb->id); ?>" title="<?php echo $qb->name; ?>">
               
                     <div class="col-xs-6 col-sm-4 col-md-2" >
                        <div class="col-item offer offer-success" style="height:140px;">                            
                            	<div class="shape">
					<div class="shape-text">
						<span class="glyphicon glyphicon  glyphicon-file"></span>							
					</div>
				</div>
                <div>
                <div class="offer-content">
                <?php     
				$prdname_cnt=strlen($qb->name);
                $prdhead_cnt=$prdname_cnt;
                                   if($prdhead_cnt>35){
                                               $prdhead= substr($qb->name,0,35).'..';
											   //'<h5 style="color:#000">'.$qb->chapter.'</h5>';
                                           } else{
                                               $prdhead=$qb->name;
                                           }
                                        ?>
                                        <h6 class="vid_prod_hed" title="<?php    echo $qb->name; ?>"><?php    echo $prdhead; ?></h6>       
                                    </div>
			 
			 <div class="separator btn_prod_ved">
                                        <p class="buy_btn"><?php 
										//$prdchap_cnt=strlen($qb->chapter);  

if($prdchap_cnt>30){
    //echo substr($qb->chapter,0,30); 
    
}else{
    //echo $qb->chapter;
} ?>
   <button class="btn-lg btn-sm btn-md btn btn-raised btn-success" name="btnAlreadyExist">Start Test</button>
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