<div id="wrapper">  <style>         .chepter-text-color {
        color: #4caf50;
font-weight: 400 !important;
font-size: 12px;
padding: 10px 0;
    }
        .chepter-color {
        color: #ff5722;
font-weight: 400 !important;
font-size: 12px;
padding: 10px 0;
    }
    
    
    .glyphic_fontinfo{
                font-size:35px;
                } 

.offer{
	background:#fff; border:1px solid #ddd; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); margin: 15px 0; overflow:hidden;
}
.offer:hover {
    -webkit-transform: scale(1.1); 
    -moz-transform: scale(1.1); 
    -ms-transform: scale(1.1); 
    -o-transform: scale(1.1); 
    transform:rotate scale(1.1); 
    -webkit-transition: all 0.4s ease-in-out; 
-moz-transition: all 0.4s ease-in-out; 
-o-transition: all 0.4s ease-in-out;
transition: all 0.4s ease-in-out;
    }
.offer-radius{
	border-radius:7px;
}

.offer-success {	border-color: #5cb85c; }

.offer-success-oppo {	border-color: #ff5722; }



.offer-content{
	padding:0 9px 8px;
}

.shape{    
    border-style: solid; border-width: 0 55px 25px 0; float:right; height: 0px; width: 0px;
	-ms-transform:rotate(360deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(360deg); /* Safari and Chrome */
	transform:rotate(360deg);
        border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
}     

.shape-text{
	color:#fff; font-size:11px; font-weight:bold; position:relative; right:-40px; top:1px; white-space: nowrap;
	-ms-transform:rotate(30deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(30deg); /* Safari and Chrome */
	transform:rotate(30deg);
}
.offer-success .shape{
	border-color: transparent #5cb85c transparent transparent;
}
.shape-oppo{    
    border-style: solid; border-width: 0 55px 25px 0; float:right; height: 0px; width: 0px;
	-ms-transform:rotate(360deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(360deg); /* Safari and Chrome */
	transform:rotate(360deg);
        border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
}     

.shape-text-oppo{
	color:#fff; font-size:11px; font-weight:bold; position:relative; right:-40px; top:1px; white-space: nowrap;
	-ms-transform:rotate(30deg); /* IE 9 */
	-o-transform: rotate(360deg);  /* Opera 10.5 */
	-webkit-transform:rotate(30deg); /* Safari and Chrome */
	transform:rotate(30deg);
}
/*
.shape-oppo{    
    border-style: solid; border-width: 42px 42px 0 0; float:left; height: 26px; width: 19px;
	-ms-transform:rotate(180deg); // IE 9 
	-o-transform: rotate(180deg);  // Opera 10.5 
	-webkit-transform:rotate(180deg); // Safari and Chrome 
	transform:rotate(180deg);
        border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
       
}
  .shape-text-oppo{
	color:#fff; font-size:11px;
        font-weight:bold; 
        position:relative; 
        right:-40px;
        top:1px; 
        white-space: nowrap;
	-ms-transform:rotate(30deg); // IE 9 
	-o-transform: rotate(30deg);  // Opera 10.5 
	-webkit-transform:rotate(30deg); // Safari and Chrome 
	transform:rotate(30deg);
} */
.offer-success-oppo .shape-oppo{
	border-color: transparent #ff5722 transparent transparent;
}
   

@media (min-width: 487px) {
  .col-sm-6 {
    width: 50%;
  }
}
@media (min-width: 900px) {
  .col-md-4 {
    width: 33.33333333333333%;
  }
}

@media (min-width: 1200px) {
  .col-lg-3 {
    width: 25%;
  }
  }
</style>
    <div class="container">
	<div class="row">
            <?php $this->load->view('common/breadcrumb'); 
            ?>    
     <div class="col-md-12 col-sm-12 onlinetestbody">
            <div id="page-inner">
                <div class="module_panel row">  
                <div class="col-sm-12 col-md-12"> 
    <script>
    window.onload = function() {
     
    var chart = new CanvasJS.Chart("chartContainer", {
    	animationEnabled: true,
    	theme: "light2",
    	title:{
    		text: "Marks VS Attempts"
    	},
    	axisY: {
    		title: "Marks Obtain"
    	},
    	data: [{
    		type: "column",
    		yValueFormatString: "#,##0.## Marks",
    		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart.render();
    }
    </script>
	
	<div class="row">
	<table class="table table-bordered">
    <thead>
	<tr><h3><?php echo 'Details For '.$name; ?></h3></tr>
      <tr>
        <th>Exam</th>
        <th>Test Name</th>
        <th>Info</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
	<ul class="list-inline" ><li><?php 
	if(isset($examInfo)){
			echo $examInfo->name;
		}else{
			echo 'All';
			
		} ?></li><li><?php 
		echo '<i class="material-icons">
subdirectory_arrow_right
</i>';
		if(isset($subjectsInfo)){
			echo $subjectsInfo->name;
		}else{
			echo 'All';
			
		} ?></li><li><?php 
		echo '<i class="material-icons">
subdirectory_arrow_right
</i>';
		if(isset($chaptersInfo)){
			echo $chaptersInfo->name;
		}else{
			echo 'All';
			
		}?></li></ul>
		</td>
        <td><?php if(isset($name)){
					echo $name;
		}else{
			echo 'N.A.';
			
		} ?>
		</td>
		<td>
		<ul><li><?php echo 'Calculator - '.$calculater; ?></li><li><?php echo 'Total Qus. - '.$total_qus; ?></li><li><?php echo 'Formula - '.$formula_array->online_exam_formula_name;
echo '<br>For Correct Answer- '.$formula_array->right_answer_marks.'<br>For Negetive Marks-'.round($formula_array->wrong_answer_marks,2).'';?></li></ul>
		</td>
      </tr>
    </tbody>
  </table>
	 </div>
    <div class="col-xs-12 col-md-12 text-center">
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   </div>
      </div>
                           
 </div>
    </div> </div>                      
 </div>
    </div> </div>
	