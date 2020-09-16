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