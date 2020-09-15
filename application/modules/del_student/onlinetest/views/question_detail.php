<div id="wrapper">
    <div class="container">
        <div class="row">
            <?php $this->load->view('common/breadcrumb');           

            ?>
 <div class="col-md-12 col-lg-12">

<div class="clearfix"></div>      
            <ul class="nav nav-tabs" role="tablist">                
                <li role="presentation">
                    <a href="#solution" aria-controls="solution" role="tab" data-toggle="tab">
                        Question Detail 
                    </a>
                </li>
            </ul>
            <div class="tab-content">             
                <div role="tabpanel" class="tab-pane active" id="solution">
                    <?php if(isset($sections)){ foreach($sections as $key=>$value){ ?>
                    <div class="col-md-12">
                        <h4><?php echo $key;?></h4>
                        <?php $cc=1;foreach($value['questions'] as $key1=>$value1){ ?>
                        <div class="oaerror <?php if($value1['answered_correctly']==1){ echo 'success'; }elseif($value1['answered_correctly']==2){ echo 'warning';}elseif($value1['answered_correctly']==0){ echo 'danger';}?>">
                            <strong><?php echo $cc;?>) &nbsp;</strong>
                            
                                <?php echo $value1['question'];?>
                            <p>&nbsp;</p>
                            <p>Answers: </p>
                            <?php $t='A';foreach($value1['answers'] as $answer){ ?>
                            <p>
                            <div <?php if($answer->is_correct==1){ echo 'class="text text-success"';}?>><strong><?php echo $t;?>) &nbsp;</strong><?php echo $answer->answer?></div>
                        </p>
                        <p>EXPLANATION:<?php echo $answer->description; ?></p>
                            <?php $t++;} ?>
                        </div>
                        <?php $cc++;} ?>
                    </div>
                    <?php } }else{
                        ?>
                                <div class="col-md-12">
                        <h4><?php echo 'Not found!'?></h4>
                            <?php
                    } ?>
                </div>
                
  </div>


                
            </div>
            
        </div>
    </div>
</div>
</div>
