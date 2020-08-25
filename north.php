<?php
$con = mysqli_connect('localhost','tcf','134889','hsi');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>北水流入</title>
	<?php include 'website/header.php'; ?>

</head>
<body>
	

	<?php
	    $date1 = array();
		$shanghai_data = array();
		$total_data = array();
		
		$result1=mysqli_query($con, "select * from hsi.Shanghai order by Date");
	    while($rows=mysqli_fetch_assoc($result1)){
        	$date1[] = $rows['Date'];
		    $shanghai_data[] = $rows['Shanghai'];
			$total_data[] = $rows['Total'];
		}	
    ?>

    <?php
	    $date2 = array();
		$hk = array();

		$result2=mysqli_query($con, "select * from hsi.hk_connect order by Date");
	    while($row2=mysqli_fetch_assoc($result2)){
        	$date2[] = $row2['Date'];
		    $hk[] = $row2['north'];
		}
    ?>


    <div class="container">
    	<br><br>
    	<h3>港股流入A股</h3>
    	<table class="table table-bordered">
    		<thead class="thead-dark">
	        <tr>
	            <th>Date</th><th>Shanghai</th><th>Total</th>
	        </tr>
	       	</thead>
	       	<tbody>
	        <tr>
	        	<td><?php echo $date1[count($date1)-5] ?></td><td><?php echo $shanghai_data[count($shanghai_data)-5] ?></td><td><?php echo $total_data[count($total_data)-5] ?></td>
	        </tr>
	        <tr>
	        	<td><?php echo $date1[count($date1)-4] ?></td><td><?php echo $shanghai_data[count($shanghai_data)-4] ?></td><td><?php echo $total_data[count($total_data)-4] ?></td>
	        </tr>
	        <tr>
	        	<td><?php echo $date1[count($date1)-3] ?></td><td><?php echo $shanghai_data[count($shanghai_data)-3] ?></td><td><?php echo $total_data[count($total_data)-3] ?></td>
	        </tr>
	        <tr>
	        	<td><?php echo $date1[count($date1)-2] ?></td><td><?php echo $shanghai_data[count($shanghai_data)-2] ?></td><td><?php echo $total_data[count($total_data)-2] ?></td>
	        </tr>
	        <tr>
	        	<td><?php echo $date1[count($date1)-1] ?></td><td><?php echo $shanghai_data[count($shanghai_data)-1] ?></td><td><?php echo $total_data[count($total_data)-1] ?></td>
	        </tr>
	        </tbody>
	    </table>
    	<div id="shanghai_chart" style=" height: 450px; width: 100%;"></div>
    	<br><br>
    	<h3>A股流入港股</h3>
    	<table class="table table-bordered">
    		<thead class="thead-dark">
	        <tr>
	            <th>Date</th><th>North to HK</th>
	        </tr>
	       	</thead>
	       	<tbody>
	        <tr>
	        	<td><?php echo $date2[count($date2)-5] ?></td><td><?php echo $hk[count($hk)-5] ?>
	        </tr>
	        <tr>
	        	<td><?php echo $date2[count($date2)-4] ?></td><td><?php echo $hk[count($hk)-4] ?>
	        </tr>
	        <tr>
	        	<td><?php echo $date2[count($date2)-3] ?></td><td><?php echo $hk[count($hk)-3] ?>
	        </tr>
	        <tr>
	        	<td><?php echo $date2[count($date2)-2] ?></td><td><?php echo $hk[count($hk)-2] ?>
	        </tr>
	        <tr>
	        	<td><?php echo $date2[count($date2)-1] ?></td><td><?php echo $hk[count($hk)-1] ?>
	        </tr>
	        </tbody>
	    </table>
    	<div id="hk_chart" style=" height: 450px; width: 100%;"></div>
    </div>
    <br><br><br>


	
	    
    
    <script type="text/javascript">
	
	    var date1 = <?php echo json_encode($date1) ?>;
	    var shanghai_data = <?php echo json_encode($shanghai_data) ?>;
		var total_data = <?php echo json_encode($total_data) ?>;

		var shanghai = [];
		var total = [];

		for(var i = 0; i < date1.length; i++){
	      shanghai.push({x: new Date(date1[i]), y: Number(shanghai_data[i])});
	      total.push({x: new Date(date1[i]), y: Number(total_data[i])});
	    }



		var shanghaiChart = new CanvasJS.StockChart("shanghai_chart",{
		    theme: "light2",
		    exportEnabled: true,
		    title:{
		      text:"Money Flow (¥)十億"
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
		      data: [{
		        type: "line",
		        name: "Shanghai",
				showInLegend: true,
		        dataPoints : shanghai
		      },
		      {
		        type: "line",
		        name: "Total",
				showInLegend: true,
		        dataPoints : total
		      }]   		
		    }],
		    navigator: {
		      data: [{
		        dataPoints: shanghai
		      }],
		      slider: {
		        minimum: new Date(date1[date1.length-90]),
		        maximum: new Date(date1[date1.length-1])
		      }
		    }
		  });
		  
		    
		shanghaiChart.render();
	  
	
	</script>

    <script type="text/javascript">

    var x_data = <?php echo json_encode($date2) ?>;
    var hk_data = <?php echo json_encode($hk) ?>;

	var hk = [];

	for(var i = 0; i < x_data.length; i++){
      hk.push({x: new Date(x_data[i]), y: Number(hk_data[i])});
    }

    
	
	var hkChart = new CanvasJS.StockChart("hk_chart",{
	    theme: "light2",
	    exportEnabled: true,
	    title:{
	      text:"Money Flow (¥)十億"
	    },
	    charts: [{
	      axisX: {
	        crosshair: {
	          enabled: true,
	          snapToDataPoint: true
	        }
	      },
	      data: [{
	        type: "line",
	        name: "hk",
			showInLegend: true,
	        dataPoints : hk
	      }]
	    }],
	    navigator: {
	      data: [{
	        dataPoints: hk
	      }],
	      slider: {
	        minimum: new Date(x_data[x_data.length-90]),
	        maximum: new Date(x_data[x_data.length-1])
	      }
	    }
	  });
	  
	    
	hkChart.render();
	  
	
	</script>

</body>
</html>