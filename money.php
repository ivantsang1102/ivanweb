<?php
$con = mysqli_connect('localhost','tcf','134889','hsi');
mysqli_set_charset($con, "utf8");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Money</title>
	<?php include 'website/header.php'; ?>

</head>
<body>

    <div class="container">
    	<br><br>
    	<h3>港股及CCASS</h3>
    	<form class="form-inline" action="money.php" method="get">
		  <div class="form-group mb-2">
		    <input type="text" readonly class="form-control-plaintext" value="輸入股票號碼">
		  </div>
		  <div class="form-group mx-sm-3 mb-2">
		    <input type="text" name="ticker" class="form-control" placeholder="ticker">
		  </div>
		  <button type="submit" name="submit" class="btn btn-primary mb-2">submit</button>
		</form>
		<div id="stock_chart" style=" height: 450px; width: 100%;"></div>
		<br><br>
		<div id="ccass_chart" style=" height: 450px; width: 100%;"></div>
		<br><br><br>
		
	</div>
		<?php
			$date = array();
			$open = array();
			$high = array();
			$low = array();
			$close = array();
			$date2 = array();
			$ccass = array();
		
		if(isset($_GET['submit'])){
			$ticker = $_GET['ticker'];
			$string = "";
			for ($x=0; $x < 5-strlen($ticker); $x++) {
				$string .= '0';
			}
			$ticker = $string . $ticker;

			$result1=mysqli_query($con, "select Date, Open, High, Low, Close from hsi.t{$ticker} order by Date");
		    while($rows=mysqli_fetch_assoc($result1)){
	        	$date[] = $rows['Date'];
			    $open[] = $rows['Open'];
				$high[] = $rows['High'];
				$low[] = $rows['Low'];
				$close[] = $rows['Close'];
			}
			
			$result2=mysqli_query($con, "select Name from hsi.stocklist where Ticker='{$ticker}'");
			while($row=mysqli_fetch_assoc($result2)){
				$ticker_name = $row['Name'];
			}

			$result3=mysqli_query($con, "select Date,no_participants_total from hsi.c{$ticker} order by Date");
			while($row3=mysqli_fetch_assoc($result3)){
				$date2[] = $row3['Date'];
				$ccass[] = $row3['no_participants_total'];
			}

		}

		?>

		

    	<script type="text/javascript">
    		var ticker_name = "<?php echo ($ticker_name) ?>";
    		var date_data = <?php echo json_encode($date) ?>;
		    var open_data = <?php echo json_encode($open) ?>;
			var high_data = <?php echo json_encode($high) ?>;
			var low_data = <?php echo json_encode($low) ?>;
			var close_data = <?php echo json_encode($close) ?>;
			var date2_data = <?php echo json_encode($date2) ?>;
			var ccass_data = <?php echo json_encode($ccass) ?>;
			var ohlc = [];
			var close = [];
			var ccass = [];


			for(var i = 0; i < date_data.length; i++){
		      ohlc.push({x: new Date(date_data[i]), y: [Number(open_data[i]),Number(high_data[i]),Number(low_data[i]),Number(close_data[i])] });
		      close.push({x: new Date(date_data[i]), y: Number(close_data[i])});
		    }

		    for(var i = 0; i < date2_data.length; i++){
		      ccass.push({x: new Date(date2_data[i]), y: Number(ccass_data[i])});
		    }
		    

			var stockChart = new CanvasJS.StockChart("stock_chart",{
			    theme: "light2",
			    exportEnabled: true,
			    title:{
			      text:"<?php echo $ticker  ?>" +' - '+ ticker_name,
			      horizontalAlign: "left",
			      fontSize: 30
			    },
			    charts: [{
			      axisX: {
			        crosshair: {
			          enabled: true,
			          snapToDataPoint: true
			        }
			      },
			      axisY: {
			        title: "Price",
			        crosshair: {
			          enabled: true
			        }
			      },
			      data: [{
			        type: "candlestick",
			        yValueFormatString: "$#,###.00",
			        dataPoints : ohlc
			      }]   		
			    }],
			    toolTip: {
			        shared: true
			    },
			    navigator: {
			      data: [{
			        dataPoints: close
			      }],
			      slider: {
			        minimum: new Date(date_data[date_data.length-90]),
			        maximum: new Date(date_data[date_data.length-1])
			      }
			    }
			  	});
			  
			    
			stockChart.render();

			var ccassChart = new CanvasJS.StockChart("ccass_chart",{
			    theme: "light2",
			    exportEnabled: true,
			    title:{
			      text:"CCASS 参與者數目",
			      horizontalAlign: "left",
			      fontSize: 30
			    },
			    charts: [{
			      axisX: {
			        crosshair: {
			          enabled: true,
			          snapToDataPoint: true
			        }
			      },
			      axisY: {
			        title: "no of agent",
			        crosshair: {
			          enabled: true,
			          snapToDataPoint: true
			        }
			      },
			      data: [{
			        type: "line",
			        markerType: "none",
			        dataPoints : ccass
			      }]   		
			    }],
			    navigator: {
			      data: [{
			        dataPoints: close
			      }],
			      slider: {
			        minimum: new Date(date2_data[date2_data.length-90]),
			        maximum: new Date(date2_data[date2_data.length-1])
			      }
			    }
			  	});
			  
			    
			ccassChart.render();

    		
			
    	</script>
    
</body>
</html>