     <style>
    .app_border {
        border: 2px solid green;
        border-color: green;
}
</style>
<div id="wrapper">
    <div class="row">      
      <div class="col-md-6 col-sm-6 col-lg-6 app_border">
            <p><?php echo $oe_question[0]->question; ?></p>
            <?php $oe_answer_count=count($oe_answer); 
            $alphbat_array=['1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E','6'=>'F',]
            ?>
            <div id="panel-answer" class="user_ans">
                     <?php $j=1; for($i=0;$i<$oe_answer_count;$i++) { ?>
                                <table class="table table-hover user_ans">
                                <tbody>
                                <tr class="row">
                                <td class="col-xs-12 col-sm-12 col-md-12 text-left"><?php echo $alphbat_array[$j]; echo ')&nbsp;'.$oe_answer[$i]->answer; $j++;?>                            </td>
                                </tr>
                                </tbody>
                                </table>
                     <?php } ?>
                                          
                          </div>
      </div>      
    </div>
</div>
