<?php
$con = mysqli_connect('localhost','tcf','134889','hsi');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<?php include 'website/header.php'; ?>

</head>
<body>
	
    <div class="container">
    	<br><br>
    	<a href="http://www.zhijinwang.com/etf/">Gold ETF</a>
    	<div id="gold_chart" style=" height: 450px; width: 100%;"></div>
    	<br><br>
    	<div id="usbond_chart" style=" height: 450px; width: 100%;"></div>
    </div>

	<?php

	    $gold_dates = array();
		$net_data = array();
		$gold_price_data = array();
		
		$result1=mysqli_query($con, "select * from hsi.Gold order by Date");
	    while($grows=mysqli_fetch_assoc($result1)){
        	$gold_dates[] = $grows['Date'];
		    $net_data[] = $grows['Net_tonne'];
			$gold_price_data[] = $grows['Price'];
		}
    ?>

    <?php

	    $dates = array();
		$mo1 = array();
		$mo2 = array();
		$mo3 = array();
		$mo6 = array();
		$yr1 = array();
		$yr2 = array();
		$yr3 = array();
		$yr5 = array();
		$yr7 = array();
		$yr10 = array();
		$yr20 = array();
		$yr30 = array();


		$result=mysqli_query($con, "select * from hsi.USbond order by Date");
	    while($rows=mysqli_fetch_assoc($result)){

        	$dates[] = $rows['Date'];
		    $mo1[] = $rows['1mo'];
			$mo2[] = $rows['2mo'];
			$mo3[] = $rows['3mo'];
			$mo6[] = $rows['6mo'];
			$yr1[] = $rows['1yr'];
			$yr2[] = $rows['2yr'];
			$yr3[] = $rows['3yr'];
			$yr5[] = $rows['5yr'];
			$yr7[] = $rows['7yr'];
			$yr10[] = $rows['10yr'];
			$yr20[] = $rows['20yr'];
			$yr30[] = $rows['30yr'];
		}
    		
    ?>
	    

	    
    
    <script type="text/javascript">

    var gold_date = <?php echo json_encode($gold_dates) ?>;
    var net_gold_data = <?php echo json_encode($net_data) ?>;
	var net_price_data = <?php echo json_encode($gold_price_data) ?>;

	var net_ton = [];
	var net_price = [];

	for(var i = 0; i < gold_date.length; i++){
      net_ton.push({x: new Date(gold_date[i]), y: Number(net_gold_data[i])});
      net_price.push({x: new Date(gold_date[i]), y: Number(net_price_data[i])});
    }

    
	
	var goldChart = new CanvasJS.StockChart("gold_chart",{
	    theme: "light2",
	    exportEnabled: true,
	    title:{
	      text:"Gold Chart"
	    },
	    charts: [{
	      axisX: {
	        crosshair: {
	          enabled: true,
	          snapToDataPoint: true
	        }
	      },
	      axisY: {
	        title: "Net Tonne"
	      },
	      axisY2: {
			title: "Price",
			titleFontColor: "#C0504E",
			lineColor: "#C0504E",
			labelFontColor: "#C0504E",
			tickColor: "#C0504E"
		},
	      data: [{
	        type: "line",
	        name: "Net tonne",
			showInLegend: true,
	        dataPoints : net_ton
	      },
	      {
	        type: "line",
	        name: "Price",
	        axisYType: "secondary",
			showInLegend: true,
	        dataPoints : net_price
	      }]
	    }
		
	    ],
	    navigator: {
	      data: [{
	        dataPoints: net_price
	      }],
	      slider: {
	        minimum: new Date(gold_date[gold_date.length-90]),
	        maximum: new Date(gold_date[gold_date.length-1])
	      }
	    }
	  });
	  
	    
	goldChart.render();

	</script>

    <script type="text/javascript">

    var x_data = <?php echo json_encode($dates) ?>;
    var mo1_data = <?php echo json_encode($mo1) ?>;
    var mo2_data = <?php echo json_encode($mo2) ?>;
    var mo3_data = <?php echo json_encode($mo3) ?>;
    var mo6_data = <?php echo json_encode($mo6) ?>;
    var yr1_data = <?php echo json_encode($yr1) ?>;
    var yr2_data = <?php echo json_encode($yr2) ?>;
    var yr3_data = <?php echo json_encode($yr3) ?>;
    var yr5_data = <?php echo json_encode($yr5) ?>;
    var yr7_data = <?php echo json_encode($yr7) ?>;
    var yr10_data = <?php echo json_encode($yr10) ?>;
    var yr20_data = <?php echo json_encode($yr20) ?>;
	var yr30_data = <?php echo json_encode($yr30) ?>;

	var mo1 = [];
	var mo2 = [];
	var mo3 = [];
	var mo6 = [];
	var yr1 = [];
	var yr2 = [];
	var yr3 = [];
	var yr5 = [];
	var yr7 = [];
	var yr10 = [];
	var yr20 = [];
	var yr30 = [];

	for(var i = 0; i < x_data.length; i++){
	  mo1.push({x: new Date(x_data[i]), y: Number(mo1_data[i])});
	  mo2.push({x: new Date(x_data[i]), y: Number(mo2_data[i])});
	  mo3.push({x: new Date(x_data[i]), y: Number(mo3_data[i])});
	  mo6.push({x: new Date(x_data[i]), y: Number(mo6_data[i])});

      yr1.push({x: new Date(x_data[i]), y: Number(yr1_data[i])});
      yr2.push({x: new Date(x_data[i]), y: Number(yr2_data[i])});
      yr3.push({x: new Date(x_data[i]), y: Number(yr3_data[i])});
      yr5.push({x: new Date(x_data[i]), y: Number(yr5_data[i])});
      yr7.push({x: new Date(x_data[i]), y: Number(yr7_data[i])});
      yr10.push({x: new Date(x_data[i]), y: Number(yr10_data[i])});
      yr20.push({x: new Date(x_data[i]), y: Number(yr20_data[i])});
      yr30.push({x: new Date(x_data[i]), y: Number(yr30_data[i])});
    }

    
	
	var stockChart = new CanvasJS.StockChart("usbond_chart",{
	    theme: "light2",
	    exportEnabled: true,
	    title:{
	      text:"US Bond Yield Rates"
	    },
	    charts: [{
	      axisX: {
	        crosshair: {
	          enabled: true,
	          snapToDataPoint: true
	        }
	      },
	      axisY: {
	        prefix: "$"
	      },
	      data: [
	      {
	        type: "line",
	        name: "1mo",
			showInLegend: true,
	        dataPoints : mo1
	      },
	      {
	        type: "line",
	        name: "2mo",
			showInLegend: true,
	        dataPoints : mo2
	      },
	      {
	        type: "line",
	        name: "3mo",
			showInLegend: true,
	        dataPoints : mo3
	      },

	      {
	        type: "line",
	        name: "6mo",
			showInLegend: true,
	        dataPoints : mo6
	      },
	      {
	        type: "line",
	        name: "1yr",
			showInLegend: true,
	        dataPoints : yr1
	      },
	      {
	        type: "line",
	        name: "2yr",
			showInLegend: true,
	        dataPoints : yr2
	      },
	      {
	        type: "line",
	        name: "3yr",
			showInLegend: true,
	        dataPoints : yr3
	      },
	      {
	        type: "line",
	        name: "5yr",
			showInLegend: true,
	        dataPoints : yr5
	      },
	      {
	        type: "line",
	        name: "7yr",
			showInLegend: true,
	        dataPoints : yr7
	      },
	      {
	        type: "line",
	        name: "10yr",
			showInLegend: true,
	        dataPoints : yr10
	      },
	      {
	        type: "line",
	        name: "20yr",
			showInLegend: true,
	        dataPoints : yr20
	      },
	      {
	        type: "line",
	        name: "30yr",
			showInLegend: true,
	        dataPoints : yr30
	      }
	      ]
	    }],
	    navigator: {
	      data: [{
	        dataPoints: yr10
	      }],
	      slider: {
	        minimum: new Date(x_data[x_data.length-90]),
	        maximum: new Date(x_data[x_data.length-1])
	      }
	    }
	  });
	  
	    
	stockChart.render();
	  
	
	</script>

</body>
</html>