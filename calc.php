<?php
$con = mysqli_connect('localhost','tcf','134889','hsi');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>恆指月結圖</title>
	<?php include 'website/header.php'; ?>

</head>
<body>

	<div class="container">
	<br><br>
    	<h3>恆指月結計算機</h3>
    	<form class="form-inline" action="calc.php" method="get">
		  <div class="form-group mb-2">
		    <input type="text" readonly class="form-control-plaintext" value="輸入日子">
		  </div>
		  <div class="form-group mx-sm-3 mb-2">
		    <input type="date" name="date" class="form-control">
		  </div>
		  <button type="submit" name="submit" class="btn btn-primary mb-2">submit</button>
		</form>

		<div id="graph"></div>
		<div id="load_data"></div>
		<br><br>
		<div id="load_data2"></div>
		<br><br>
		<div id="load_data3"></div>


    </div>
    <?php

		if(isset($_GET['submit'])){
			$tdate = $_GET['date'];
			$date = array();
			$open = array();
			$high = array();
			$low = array();
			$close = array();
			
			$result=mysqli_query($con, "select Close, VHSI from hsi.HSI_VHSI where Date = '{$tdate}';");
		    while($row=mysqli_fetch_assoc($result)){
			    $HSI = $row['Close'];
				$VHSI = $row['VHSI'];
			}

			$result2=mysqli_query($con, "select Date, Open, High, Low, Close from hsi.HSI_VHSI order by Date;");
		    while($rows=mysqli_fetch_assoc($result2)){
			    $date[] = $rows['Date'];
			    $open[] = $rows['Open'];
				$high[] = $rows['High'];
				$low[] = $rows['Low'];
				$close[] = $rows['Close'];
			}


    	}
    ?>


    <script type="text/javascript">
    	const date = "<?php echo $tdate ?>";
    	const hsi = <?php echo $HSI ?>;
    	const vhsi = <?php echo $VHSI ?>;
    	var date_data = <?php echo json_encode($date) ?>;
	    var open_data = <?php echo json_encode($open) ?>;
		var high_data = <?php echo json_encode($high) ?>;
		var low_data = <?php echo json_encode($low) ?>;
		var close_data = <?php echo json_encode($close) ?>;
		var datess = [];
		var open = [];
		var high = [];
		var low = [];
		var close = [];


		for(var i = 0; i < date_data.length; i++){
		      datess.push((date_data[i]));
		      open.push(Number(open_data[i]));
		      high.push(Number(high_data[i]));
		      low.push(Number(low_data[i]));
		      close.push(Number(close_data[i]));
		}



    	
	    // const date = document.getElementById("date").value;
	    // const hsi = document.getElementById("hsi").value;
	    // const vhsi = document.getElementById("vhsi").value;
	  
	 
	    // const hsi = 27493.7;
	    // const vhsi = 20.87;
	    let table_data = `
	    <table class="table table-bordered" style="font-size:14px;color:#000000;" id="customers">
	        <col width="12%"><col width="12%"><col width="10%">
	        <col width="10%"><col width="10%"><col width="10%">
	        <col width="10%"><col width="10%"><col width="10%">
	        <tr>
	            <th>Date</th>
	            <th style="border-right: 2px solid;">${date}</th>
	            <th colspan="7">預計恒指上或落的幅度</th>
	        </tr>
	        <tr>
	                <th style="border-bottom: 2px solid;">恒指收市價</th>
	                <th style="border-bottom: 2px solid;border-right: 2px solid;">VHSI</th>
	                <th style="border-bottom: 2px solid;">概率</th>
	                <th style="border-bottom: 2px solid;">一日</th>
	                <th style="border-bottom: 2px solid;">一星期</th>
	                <th style="border-bottom: 2px solid;">兩星期</th>
	                <th style="border-bottom: 2px solid;">一個月</th>
	                <th style="border-bottom: 2px solid;">兩個月</th>
	                <th style="border-bottom: 2px solid;">三個月</th>
	        </tr>`;

	    table_data += `
	    <tr>
	        <td>${hsi}</td>
	        <td style="border-right: 2px solid;">${vhsi}</td>
	        <td>68%</th>
	        <td>${Math.round(hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*(vhsi/100)/Math.sqrt(26))}</td>
	        <td>${Math.round(hsi*(vhsi/100)/Math.sqrt(12))}</td>
	        <td>${Math.round(hsi*(vhsi/100)/Math.sqrt(6))}</td>
	        <td>${Math.round(hsi*(vhsi/100)/Math.sqrt(4))}</td>
	    </tr>`  
	    table_data += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>80%</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(12))}</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(6))}</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(4))}</td>
	    </tr>`  
	    table_data += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>90%</td>
	        <td>${Math.round(1.64*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(1.64*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(1.64*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	        <td>${Math.round(1.64*hsi*(vhsi/100)/Math.sqrt(12))}</td>
	        <td>${Math.round(1.64*hsi*(vhsi/100)/Math.sqrt(6))}</td>
	        <td>${Math.round(1.64*hsi*(vhsi/100)/Math.sqrt(4))}</td>
	    </tr>`  
	    table_data += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>95%</td>
	        <td>${Math.round(1.96*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(1.96*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(1.96*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	        <td>${Math.round(1.96*hsi*(vhsi/100)/Math.sqrt(12))}</td>
	        <td>${Math.round(1.96*hsi*(vhsi/100)/Math.sqrt(6))}</td>
	        <td>${Math.round(1.96*hsi*(vhsi/100)/Math.sqrt(4))}</td>
	    </tr>`  
	    table_data += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>99%</td>
	        <td>${Math.round(2.58*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(2.58*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(2.58*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	        <td>${Math.round(2.58*hsi*(vhsi/100)/Math.sqrt(12))}</td>
	        <td>${Math.round(2.58*hsi*(vhsi/100)/Math.sqrt(6))}</td>
	        <td>${Math.round(2.58*hsi*(vhsi/100)/Math.sqrt(4))}</td>
	    </tr>`  

	    table_data += '</table>';
	    document.getElementById('load_data').innerHTML = table_data;

		// ----------------------------------------------------------------
	    // 上方下方對沖位
	    let table_data2 = `
	    <table class="table table-bordered" style="font-size:14px;color:#000000;" id="customers">
	        <col width="12%"><col width="12%"><col width="10%">
	        <col width="10%"><col width="10%"><col width="10%">
	        <col width="10%"><col width="10%"><col width="10%">`
	    
	    
	    
	    
	    var t1 = new Date(date);
	    t1.setDate(t1.getDate() + 1);
	    
	    var t2 = new Date(date);
	    t2.setDate(t2.getDate() + 7);
	    
	    var t3 = new Date(date);
	    t3.setDate(t3.getDate() + 14);

	    var t4 = new Date(date);
	    t4.setDate(t4.getDate() + 30);
	    
	    var Dates = []
	    Dates.push(t1, t2, t3, t4)
	    console.log(Dates)


	    var U1021 = []
	    U1021.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.521*2));
	    U1021.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.521*2));
	    U1021.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.521*2));
	    U1021.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.521*2));
	    console.log(U1021);

	    table_data2 += `
	    <tr>
	        <td></td>
	        <td bgcolor="#c9c9c5" style="border-right: 2px solid;">上方誤差</td>
	        <td bgcolor="#c9c9c5">1.021</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.521*2)}</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.521*2)}</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.521*2)}</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.521*2)}</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(6)*0.521*2)}</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(4)*0.521*2)}</td>
	    </tr>`  
	    
	    var U1000 = []
	    U1000.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.5*2));
	    U1000.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.5*2));
	    U1000.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.5*2));
	    U1000.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.5*2));
	    console.log(U1000);
	    
	    table_data2 += `
	    <tr>
	        <td></td>
	        <td bgcolor="orange" style="border-right: 2px solid;">預計上限</td>
	        <td bgcolor="orange">1.000</td>
	        <td bgcolor="orange">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.5*2)}</td>
	        <td bgcolor="orange">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.5*2)}</td>
	        <td bgcolor="orange">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.5*2)}</td>
	        <td bgcolor="orange">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.5*2)}</td>
	        <td bgcolor="orange">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(6)*0.5*2)}</td>
	        <td bgcolor="orange">${Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(4)*0.5*2)}</td>
	    </tr>`  
	    
	    var U0854 = []
	    U0854.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.354*2));
	    U0854.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.354*2));
	    U0854.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.354*2));
	    U0854.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.354*2));
	    console.log(U0854);
	    
	    table_data2 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>0.854</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.354*2)}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.354*2)}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.354*2)}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.354*2)}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(6)*0.354*2)}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(4)*0.354*2)}</td>
	    </tr>`  
	    
	    var U0764 = []
	    U0764.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.264*2));
	    U0764.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.264*2));
	    U0764.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.264*2));
	    U0764.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.264*2));
	    console.log(U0764);
	    
	    table_data2 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;">上方對沖位</td>
	        <td>0.764</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.264*2)}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.264*2)}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.264*2)}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.264*2)}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(6)*0.264*2)}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(4)*0.264*2)}</td>
	    </tr>`  
	    
	    var U0618 = []
	    U0618.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.118*2));
	    U0618.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.118*2));
	    U0618.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.118*2));
	    U0618.push(Math.round(hsi*1 + 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.118*2));
	    console.log(U0618);
	    
	    table_data2 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td bgcolor="yellow">0.618</td>
	        <td bgcolor="yellow">${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.118*2)}</td>
	        <td bgcolor="yellow">${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.118*2)}</td>
	        <td bgcolor="yellow">${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.118*2)}</td>
	        <td bgcolor="yellow">${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.118*2)}</td>
	        <td bgcolor="yellow">${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(6)*0.118*2)}</td>
	        <td bgcolor="yellow">${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(4)*0.118*2)}</td>
	    </tr>`  
	    table_data2 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>0.500</td>
	        <td colspan="6">${Math.round(hsi)}</td>
	    </tr>`  
	    
	    var L0382 = []
	    L0382.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.118*2));
	    L0382.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.118*2));
	    L0382.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.118*2));
	    L0382.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.118*2));
	    console.log(L0382);
	    
	    table_data2 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td bgcolor="yellow">0.382</td>
	        <td bgcolor="yellow">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.118*2)}</td>
	        <td bgcolor="yellow">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.118*2)}</td>
	        <td bgcolor="yellow">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.118*2)}</td>
	        <td bgcolor="yellow">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.118*2)}</td>
	        <td bgcolor="yellow">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(6)*0.118*2)}</td>
	        <td bgcolor="yellow">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(4)*0.118*2)}</td>
	    </tr>`
	    
	    var L0236 = []
	    L0236.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.264*2));
	    L0236.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.264*2));
	    L0236.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.264*2));
	    L0236.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.264*2));
	    console.log(L0236);


	    table_data2 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;">下方對沖位</td>
	        <td>0.236</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.264*2)}</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.264*2)}</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.264*2)}</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.264*2)}</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(6)*0.264*2)}</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(4)*0.264*2)}</td>
	    </tr>`
	    
	    var L0146 = []
	    L0146.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.354*2));
	    L0146.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.354*2));
	    L0146.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.354*2));
	    L0146.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.354*2));
	    console.log(L0146);
	    
	    table_data2 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>0.146</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.354*2)}</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.354*2)}</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.354*2)}</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.354*2)}</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(6)*0.354*2)}</td>
	        <td>${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(4)*0.354*2)}</td>
	    </tr>`
	    
	    var L0000 = []
	    L0000.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.5*2));
	    L0000.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.5*2));
	    L0000.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.5*2));
	    L0000.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.5*2));
	    console.log(L0000);
	    
	    table_data2 += `
	    <tr>
	        <td></td>
	        <td bgcolor="orange" style="border-right: 2px solid;">預計下限</td>
	        <td bgcolor="orange">0.000</td>
	        <td bgcolor="orange">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.5*2)}</td>
	        <td bgcolor="orange">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.5*2)}</td>
	        <td bgcolor="orange">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.5*2)}</td>
	        <td bgcolor="orange">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.5*2)}</td>
	        <td bgcolor="orange">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(6)*0.5*2)}</td>
	        <td bgcolor="orange">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(4)*0.5*2)}</td>
	    </tr>`
	    
	    var L0021 = []
	    L0021.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.521*2));
	    L0021.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.521*2));
	    L0021.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.521*2));
	    L0021.push(Math.round(hsi*1 - 1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.521*2));
	    console.log(L0021);
	    
	    table_data2 += `
	    <tr>
	        <td></td>
	        <td bgcolor="#c9c9c5" style="border-right: 2px solid;">下方誤差</td>
	        <td bgcolor="#c9c9c5">-0.021</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(252)*0.521*2)}</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(52)*0.521*2)}</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(26)*0.521*2)}</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(12)*0.521*2)}</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(6)*0.521*2)}</td>
	        <td bgcolor="#c9c9c5">${Math.round(hsi-1.28*hsi*(vhsi/100)/Math.sqrt(4)*0.521*2)}</td>
	    </tr>`       
	    table_data2 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>預計間距</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(252)*2)}</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(52)*2)}</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(26)*2)}</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(12)*2)}</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(6)*2)}</td>
	        <td>${Math.round(1.28*hsi*(vhsi/100)/Math.sqrt(4)*2)}</td>
	    </tr>`       
	    table_data2 += '</table>';
	    document.getElementById('load_data2').innerHTML = table_data2;

		// ----------------------------------------------------------------

		let table_data3 = `
		    <table class="table table-bordered" style="font-size:14px;color:#000000;" id="customers">
		        <col width="12%"><col width="12%"><col width="10%">
		        <col width="10%"><col width="10%"><col width="10%">
		        <col width="10%"><col width="10%"><col width="10%">
		        <tr>
		            <th>Date</th>
		            <th style="border-right: 2px solid;">${date}</th>
		            <th></th>
		            <th colspan="2">一日</th>
		            <th colspan="2">一星期</th>
		            <th colspan="2">兩星期</th>
		        </tr>
		        <tr>
		                <th style="border-bottom: 2px solid;">恒指收市價</th>
		                <th style="border-bottom: 2px solid;border-right: 2px solid;">VHSI</th>
		                <th style="border-bottom: 2px solid;">概率</th>
		                <th style="border-bottom: 2px solid;">預計上限</th>
		                <th style="border-bottom: 2px solid;">預計下限</th>
		                <th style="border-bottom: 2px solid;">預計上限</th>
		                <th style="border-bottom: 2px solid;">預計下限</th>
		                <th style="border-bottom: 2px solid;">預計上限</th>
		                <th style="border-bottom: 2px solid;">預計下限</th>
		        </tr>`;

	    table_data3 += `
	    <tr>
	        <td>${hsi}</td>
	        <td style="border-right: 2px solid;">${vhsi}</td>
	        <td>68%</th>
	        <td>${Math.round(hsi*1+hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*1-hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*1+hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*1-hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*1+hsi*(vhsi/100)/Math.sqrt(26))}</td>
	        <td>${Math.round(hsi*1-hsi*(vhsi/100)/Math.sqrt(26))}</td>
	    </tr>`  
	    table_data3 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>80%</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*1-1.28*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*1-1.28*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*1+1.28*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	        <td>${Math.round(hsi*1-1.28*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	    </tr>`  
	    table_data3 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>90%</td>
	        <td>${Math.round(hsi*1+1.64*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*1-1.64*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*1+1.64*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*1-1.64*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*1+1.64*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	        <td>${Math.round(hsi*1-1.64*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	    </tr>`  
	    table_data3 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>95%</td>
	        <td>${Math.round(hsi*1+1.96*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*1-1.96*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*1+1.96*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*1-1.96*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*1+1.96*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	        <td>${Math.round(hsi*1-1.96*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	    </tr>`  
	    table_data3 += `
	    <tr>
	        <td></td>
	        <td style="border-right: 2px solid;"></td>
	        <td>99%</td>
	        <td>${Math.round(hsi*1+2.58*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*1-2.58*hsi*(vhsi/100)/Math.sqrt(252))}</td>
	        <td>${Math.round(hsi*1+2.58*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*1-2.58*hsi*(vhsi/100)/Math.sqrt(52))}</td>
	        <td>${Math.round(hsi*1+2.58*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	        <td>${Math.round(hsi*1-2.58*hsi*(vhsi/100)/Math.sqrt(26))}</td>
	    </tr>`  

	    table_data3 += '</table>';
	    document.getElementById('load_data3').innerHTML = table_data3;


	
	        
	        
	        
	    var trace1 = {
            x: datess,
            close: close,
            high: high,
            low: low,
            open: open,
            line: {color: 'rgba(31,119,180,1)'},
            type: 'candlestick',
            name: 'HSI',
            xaxis: 'x', 
            yaxis: 'y'
        };
	        
	        
	        
	    var trace2 = {
	        type: "Scatter",
	        mode: "lines+markers",
	        x: Dates,
	        y: U1021,
	        name: "1.021"
	    }
	        
	    var trace3 = {
	        type: "Scatter",
	        mode: "lines+markers",
	        x: Dates,
	        y: U1000,
	        name: "1.000"
	    }
	        
	    var trace4 = {
	        type: "Scatter",
	        mode: "lines+markers",
	        x: Dates,
	        y: U0854,
	        name: "0.854"
	    }    

	    var trace5 = {
	        type: "Scatter",
	        mode: "lines+markers",
	        x: Dates,
	        y: U0764,
	        name: "0.764"
	    }  
	        
	    var trace6 = {
	        type: "Scatter",
	        mode: "lines+markers",
	        x: Dates,
	        y: U0618,
	        name: "0.618"
	    }  
	        
	    var trace7 = {
	        type: "Scatter",
	        mode: "lines+markers",
	        x: Dates,
	        y: L0382,
	        name: "0.382"
	    }  

	    var trace8 = {
	        type: "Scatter",
	        mode: "lines+markers",
	        x: Dates,
	        y: L0236,
	        name: "0.236"
	    }  
	        
	    var trace9 = {
	        type: "Scatter",
	        mode: "lines+markers",
	        x: Dates,
	        y: L0146,
	        name: "0.146"
	    }  
	        
	    var trace10 = {
	        type: "Scatter",
	        mode: "lines+markers",
	        x: Dates,
	        y: L0000,
	        name: "0.000"
	    }  

	    var trace11 = {
	        type: "Scatter",
	        mode: "lines+markers",
	        x: Dates,
	        y: L0021,
	        name: "-0.021"
	    }  


	    var data = [trace1, trace2, trace3, trace4, trace5, trace6, trace7, trace8, trace9, trace10, trace11];
	    // var data = [trace1];
	        
	    var layout = {
	        title: '恆指波幅上下限圖',
	        dragmode: 'pan',
	        xaxis: {
	        rangeslider: {visible: true},
	        range: [datess[datess.length-45], datess[datess.length-1]],
	        type: 'date'
	        },
	        yaxis: {
	            autorange: true,
	            fixedrange: false,
	        },
	        height: 800
	    };
	        
	    Plotly.newPlot('graph', data, layout);
	        
	        

    </script>

	


</body>
</html>
