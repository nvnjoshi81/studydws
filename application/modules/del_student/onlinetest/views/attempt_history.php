<div id="wrapper"> 
   <link href="<?php echo get_assets('assets/graph_css/'.$graphasset.'.css');?>" rel="stylesheet" type="text/css">

    <div class="container">
	<div class="row">
            <?php $this->load->view('common/breadcrumb'); 
            ?>    
     <div class="col-md-12 col-sm-12 onlinetestbody">
            <div id="page-inner">
                <div class="module_panel row">  
                <div class="col-sm-12 col-md-12"> 
 <script>  <?php if($chart_type=='bar'){
	  ?> 
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
 <?php }else if($chart_type=='line'){
	 ?>
	 window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Marks VS Attempts"
	},
	axisY:{
		title: "Marks Obtain",
		logarithmic: true,
		titleFontColor: "#6D78AD",
		gridColor: "#6D78AD",
		labelFormatter: addSymbols
	},
	axisY2:{
		title: "Attempts",
		titleFontColor: "#51CDA0",
		tickLength: 0,
		labelFormatter: addSymbols
	},
	legend: {
		cursor: "pointer",
		verticalAlign: "top",
		fontSize: 16,
		itemclick: toggleDataSeries
	},
	data: [{
		type: "line",
		markerSize: 0,
		showInLegend: true,
		name: "Log Scale",
		yValueFormatString: "#,##0 MW",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	},
	{
		type: "line",
		markerSize: 0,
		axisYType: "secondary",
		showInLegend: true,
		name: "Linear Scale",
		yValueFormatString: "#,##0 MW",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
function addSymbols(e){
	var suffixes = ["", "K", "M", "B"];
 
	var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);
	if(order > suffixes.length - 1)
		order = suffixes.length - 1;
 
	var suffix = suffixes[order];
	return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
}
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}
 
} 
<?php
} 
?> 
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
	<ul class="list-inline" >
	<li><?php 
	if(isset($examInfo)){
			echo $examInfo->name;
		}else{
			echo 'All';
		} ?>
	</li>
	<li>
		<?php 
echo '<i class="material-icons">subdirectory_arrow_right
</i>';
		if(isset($subjectsInfo)){
		echo $subjectsInfo->name;
		}else{
		echo 'All';
		} ?>
		</li><li><?php 
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
    <div class="col-xs-12 col-md-12 text-center"><table class="table table-bordered">
    <thead><tr><h3><?php if($chart_type=='bar'){
		  ?><a href="<?php echo base_url('online-test/attempts/'.$testid.'/line'); ?>" >Click For Line Chart</a><?php
	  }elseif($chart_type=='line'){
		  ?><a href="<?php echo base_url('online-test/attempts/'.$testid.'/bar'); ?>" >Click For Bar Chart</a><?php
	  }else{
		  
	  } ?></h3></tr>  <thead>  </table>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   </div>
      </div>
                           
 </div>
    </div> </div>                      
 </div>
    </div> </div>
	