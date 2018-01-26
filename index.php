<?php
$servername = "mysql4.000webhost.com";
$username = "a4045753_pingu";
$password = "pingu123";
$db = "a4045753_pingu";

$conn = new mysqli($servername, $username, $password, $db);
if (mysqli_connect_error()) {
	die("Database connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>SCC SSPA entry system</title>
  	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<style>
	body{
		font-family: 'Montserrat', 'Microsoft JhengHei', sans-serif;
		margin: 0;
		padding: 0;
		font-size:16px;
	}
	hr{
		border: 0;
		height: 1px;
		background: #333;
		background-image: linear-gradient(to right, #ccc, #333, #ccc);
		margin: 1px 0;
	}
	.header{
		font-size:30px;
		padding:15px;
		background-color: #87cefa;
		text-align: center; 
	}
	.title{
		font-size: 20px;
		font-weight: bold;
		padding:10px 0px;
	}
	.footer{
		font-size:12px;
		padding:10px;
		background-color: #ffffe0;
		text-align: right; 
	}
	.section{
		padding:10px;
	}
	input, .ui-widget{
		font-family: inherit !important; 
		font-size: inherit !important;
	}
	input[type=submit]{
		display:block;
		width: 200px;
		margin: 20px auto;
		padding: 10px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		background-color: #87CEFA;
		line-height: 2;
		transition: background-color 0.5s ease; 
	}
	input[type=submit]:hover{
		background-color: #00BFFF;
	}
	input[type=checkbox]{
		transform: scale(2);
	}
	.ui-widget input{
		padding: 5px;
		margin: 2px 0;
		display: inline-block;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
	}
	.ui-autocomplete {
		max-height: 250px;
		overflow-y: auto;
		overflow-x: hidden;
	}
	.thin{
		width: 50px;
	}
	.middle{
		width: 100px;
	}
	.long{
		width: 500px;
	}
	.extend{
		width: 100%;
	}
	table {
		border-collapse: collapse;
		width: 100%;
		text-align: center; 
	}
	th, td {
		padding: 4px;
	}

	tr:nth-child(even){background-color: #f2f2f2}

	th {
		background-color: #4CAF50;
		color: white;
	}
	
	</style>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
	$( function() {
		
		var award_list = <?php $sql = "SELECT * FROM sspa_award_list ORDER BY sspa_award ASC";
				$response = array();
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) $response[]=$row['sspa_award'];
				echo json_encode($response);?>;
		var duty_list = <?php $sql = "SELECT * FROM sspa_duty_list ORDER BY sspa_duty ASC";
				$response = array();
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) $response[]=$row['sspa_duty'];
				echo json_encode($response);?>;
		var prize_list = <?php $sql = "SELECT * FROM sspa_prize_list ORDER BY sspa_prize ASC";
				$response = array();
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) $response[]=$row['sspa_prize'];
				echo json_encode($response);?>;
		var eca_list = <?php $sql = "SELECT * FROM sspa_eca_list ORDER BY sspa_eca ASC";
				$response = array();
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) $response[]=$row['sspa_eca'];
				echo json_encode($response);?>;
		var remarks_list = <?php $sql = "SELECT * FROM sspa_remarks_list ORDER BY sspa_remarks ASC";
				$response = array();
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) $response[]=$row['sspa_remarks'];
				echo json_encode($response);?>;	
		
		$( ".award" ).autocomplete({
			source: award_list,
		});
		
		$( ".duty" ).autocomplete({
			source: duty_list,
		});
		
		$( ".prize" ).autocomplete({
			source: prize_list,
		});
		
		$( ".eca" ).autocomplete({
			source: eca_list,
		});
		
		$( ".remarks" ).autocomplete({
			source: remarks_list,
		});
		
		$("#id").on("change", function(){
			if ($(this).val()!=""){
				$.ajax({
					method: "POST",
					url: "get_stu_name.php",
					data: {id: $(this).val()}
				}).done(function(data){
					$("#stu_name").html("Student name: " + data);
				});
			}
		});
		
		function complex_concat(n,name,primary){
			temp = "";
			for (var i=1; i<=n; i++){
				if ($("#" + name + "_" + i).val() != "" && $("#" + name + "_P" + primary + "_" + i).prop('checked')){
					temp += (temp=="" ? "":", ") + $("#" + name + "_" + i).val();
					if ($("#" + name + "_award_" + i).length != 0 && $("#" + name + "_award_" + i).val()!=""){
						temp += " (" + $("#" + name + "_award_" + i).val() + ")";
					}
				}
			}
			return temp;
		}
		
		function simple_concat(n,name){
			temp = "";
			for (var i=1; i<=n; i++){
				if ($("#" + name + "_" + i).val() != ""){
					temp += (temp=="" ? "":", ") + $("#" + name + "_" + i).val();
					if ($("#" + name + "_award_" + i).length !=0 && $("#" + name + "_award_" + i).val()!=""){
						temp += " (" + $("#" + name + "_award_" + i).val() + ")";
					}
				}
			}
			return temp;
		}
		
		function get_new_array(str, arr){
			temp = {"table":str};
			counter = 0;
			$("." + str).each(function(index){
			if ($(this).val()!="" && $.inArray($(this).val(),arr)==-1){
					arr.push($(this).val());
					temp[counter] = $(this).val();
					counter += 1;
				}
			});
			if (counter == 0) {
				return null;
			} else {
				return temp;
			}
		}
		
		$("#form").submit(function(e) {
			
			if (confirm('Are you sure you want to submit?')) {
				
				$("#hidden_id").val($("#id").val());
				
				$("#duties_P5_all").val(complex_concat(10,"duty",5));
				$("#duties_P6_all").val(complex_concat(10,"duty",6));
				$("#prizes_P5_all").val(complex_concat(20,"prize",5));
				$("#prizes_P6_all").val(complex_concat(20,"prize",6));
				$("#eca_all").val(simple_concat(20,"eca"));
				$("#remarks_all").val(simple_concat(20,"remarks"));
				
				var a1 = $.ajax({
					type: "POST",
					url: "submit_form.php",
					data: $("#form").serialize(),
				});
				var a2 = $.ajax({
					type: "POST",
					url: "add_new_item.php",
					data: get_new_array("award",award_list),
				});
				var a3 = $.ajax({
					type: "POST",
					url: "add_new_item.php",
					data: get_new_array("duty",duty_list),
				});
				var a4 = $.ajax({
					type: "POST",
					url: "add_new_item.php",
					data: get_new_array("eca",eca_list),
				});
				var a5 = $.ajax({
					type: "POST",
					url: "add_new_item.php",
					data: get_new_array("prize",prize_list),
				});
				var a6 = $.ajax({
					type: "POST",
					url: "add_new_item.php",
					data: get_new_array("remarks",remarks_list),
				});
				
				$.when(a1,a2,a3,a4,a5,a6).done(function(x1,x2,x3,x4,x5,x6){
					var error = x1[0] + x2[0] + x3[0] + x4[0] + x5[0] + x6[0];
					if (error == ""){
						location.reload();
					} else {
						alert(error);
					}
				});
			}
			e.preventDefault();
			
		});
		
	} );
	</script>
</head>
<body>

	<div class="header">SCC SSPA entry system</div>
	<form id="form" method="post" action=""> 
		
		<div class="section">
			<div class="title">General information</div>
			<div class="ui-widget">
				<label for="id">Application no.</label>
				<input class="thin" id="id">
			</div>
			<div id="stu_name">Student name: </div>
			<div class="ui-widget">
				<label for="tel">Tel. no.</label>
				<input id="tel" name="tel" class="long">
			</div>
		</div>
		
		<hr>
		
		<div class="section">
			<div class="title">(C) Academic Achievement and Conduct</div>
			<table>
				<tr>
					<th></th>
					<th>Chinese</th>
					<th>English</th>
					<th>Math</th>
					<th>General Studies</th>
					<th>Conduct</th>
					<th>Rank (class)</th>
					<th>Rank (form)</th>
				</tr>
				<tr>
					<td>P.5</td>
					<td><div class="ui-widget"><input class="thin" name="chi_5"></div></td>
					<td><div class="ui-widget"><input class="thin" name="eng_5"></div></td>
					<td><div class="ui-widget"><input class="thin" name="maths_5"></div></td>
					<td><div class="ui-widget"><input class="thin" name="gs_5"></div></td>
					<td><div class="ui-widget"><input class="thin" name="conduct_5"></div></td>
					<td><div class="ui-widget"><input class="middle" name="rank_class_5"></div></td>
					<td><div class="ui-widget"><input class="middle" name="rank_form_5"></div></td>
				</tr>
				<tr>
					<td>P.6</td>
					<td><div class="ui-widget"><input class="thin" name="chi_6"></div></td>
					<td><div class="ui-widget"><input class="thin" name="eng_6"></div></td>
					<td><div class="ui-widget"><input class="thin" name="maths_6"></div></td>
					<td><div class="ui-widget"><input class="thin" name="gs_6"></div></td>
					<td><div class="ui-widget"><input class="thin" name="conduct_6"></div></td>
					<td><div class="ui-widget"><input class="middle" name="rank_class_6"></div></td>
					<td><div class="ui-widget"><input class="middle" name="rank_form_6"></div></td>
				</tr>
			</table>
		</div>
		
		<hr>
		
		<div class="section">
			<div class="title">(D) Duties and Services in School</div>
			<table>
				<tr>
					<th>Items</th>
					<th>P.5</th>
					<th>P.6</th>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend duty" id="duty_1"></div></td>
					<td><input type="checkbox" id="duty_P5_1"></td>
					<td><input type="checkbox" id="duty_P6_1"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend duty" id="duty_2"></div></td>
					<td><input type="checkbox" id="duty_P5_2"></td>
					<td><input type="checkbox" id="duty_P6_2"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend duty" id="duty_3"></div></td>
					<td><input type="checkbox" id="duty_P5_3"></td>
					<td><input type="checkbox" id="duty_P6_3"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend duty" id="duty_4"></div></td>
					<td><input type="checkbox" id="duty_P5_4"></td>
					<td><input type="checkbox" id="duty_P6_4"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend duty" id="duty_5"></div></td>
					<td><input type="checkbox" id="duty_P5_5"></td>
					<td><input type="checkbox" id="duty_P6_5"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend duty" id="duty_6"></div></td>
					<td><input type="checkbox" id="duty_P5_6"></td>
					<td><input type="checkbox" id="duty_P6_6"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend duty" id="duty_7"></div></td>
					<td><input type="checkbox" id="duty_P5_7"></td>
					<td><input type="checkbox" id="duty_P6_7"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend duty" id="duty_8"></div></td>
					<td><input type="checkbox" id="duty_P5_8"></td>
					<td><input type="checkbox" id="duty_P6_8"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend duty" id="duty_9"></div></td>
					<td><input type="checkbox" id="duty_P5_9"></td>
					<td><input type="checkbox" id="duty_P6_9"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend duty" id="duty_10"></div></td>
					<td><input type="checkbox" id="duty_P5_10"></td>
					<td><input type="checkbox" id="duty_P6_10"></td>
				</tr>
			</table>
			<input id="duties_P5_all" name="duties_5" style="display:none;">
			<input id="duties_P6_all" name="duties_6" style="display:none;">
		</div>
		
		<hr>
		
		<div class="section">
			<div class="title">(E) Prizes obtained</div>
			<table>
				<tr>
					<th style="width: 60%">Items</th>
					<th style="width: 20%">Award</th>
					<th>P.5</th>
					<th>P.6</th>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_1"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_1"></div></td>
					<td><input type="checkbox" id="prize_P5_1"></td>
					<td><input type="checkbox" id="prize_P6_1"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_2"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_2"></div></td>
					<td><input type="checkbox" id="prize_P5_2"></td>
					<td><input type="checkbox" id="prize_P6_2"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_3"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_3"></div></td>
					<td><input type="checkbox" id="prize_P5_3"></td>
					<td><input type="checkbox" id="prize_P6_3"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_4"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_4"></div></td>
					<td><input type="checkbox" id="prize_P5_4"></td>
					<td><input type="checkbox" id="prize_P6_4"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_5"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_5"></div></td>
					<td><input type="checkbox" id="prize_P5_5"></td>
					<td><input type="checkbox" id="prize_P6_5"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_6"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_6"></div></td>
					<td><input type="checkbox" id="prize_P5_6"></td>
					<td><input type="checkbox" id="prize_P6_6"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_7"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_7"></div></td>
					<td><input type="checkbox" id="prize_P5_7"></td>
					<td><input type="checkbox" id="prize_P6_7"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_8"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_8"></div></td>
					<td><input type="checkbox" id="prize_P5_8"></td>
					<td><input type="checkbox" id="prize_P6_8"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_9"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_9"></div></td>
					<td><input type="checkbox" id="prize_P5_9"></td>
					<td><input type="checkbox" id="prize_P6_9"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_10"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_10"></div></td>
					<td><input type="checkbox" id="prize_P5_10"></td>
					<td><input type="checkbox" id="prize_P6_10"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_11"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_11"></div></td>
					<td><input type="checkbox" id="prize_P5_11"></td>
					<td><input type="checkbox" id="prize_P6_11"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_12"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_12"></div></td>
					<td><input type="checkbox" id="prize_P5_12"></td>
					<td><input type="checkbox" id="prize_P6_12"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_13"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_13"></div></td>
					<td><input type="checkbox" id="prize_P5_13"></td>
					<td><input type="checkbox" id="prize_P6_13"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_14"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_14"></div></td>
					<td><input type="checkbox" id="prize_P5_14"></td>
					<td><input type="checkbox" id="prize_P6_14"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_15"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_15"></div></td>
					<td><input type="checkbox" id="prize_P5_15"></td>
					<td><input type="checkbox" id="prize_P6_15"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_16"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_16"></div></td>
					<td><input type="checkbox" id="prize_P5_16"></td>
					<td><input type="checkbox" id="prize_P6_16"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_17"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_17"></div></td>
					<td><input type="checkbox" id="prize_P5_17"></td>
					<td><input type="checkbox" id="prize_P6_17"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_18"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_18"></div></td>
					<td><input type="checkbox" id="prize_P5_18"></td>
					<td><input type="checkbox" id="prize_P6_18"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_19"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_19"></div></td>
					<td><input type="checkbox" id="prize_P5_19"></td>
					<td><input type="checkbox" id="prize_P6_19"></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend prize" id="prize_20"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="prize_award_20"></div></td>
					<td><input type="checkbox" id="prize_P5_20"></td>
					<td><input type="checkbox" id="prize_P6_20"></td>
				</tr>				
			</table>
			<input id="prizes_P5_all" name="prizes_5" style="display:none;">
			<input id="prizes_P6_all" name="prizes_6" style="display:none;">
		</div>
		
		<hr>
		
		<div class="section">
			<div class="title">(F) Extra-curricular Activities</div>
			<table>
				<tr>
					<th>Items</th>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_1"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_2"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_3"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_4"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_5"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_6"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_7"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_8"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_9"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_10"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_11"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_12"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_13"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_14"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_15"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_16"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_17"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_18"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_19"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend eca" id="eca_20"></div></td>
				</tr>
			</table>
			<input id="eca_all" name="eca" style="display:none;">
		</div>
		
		<hr>
		
		<div class="section">
			<div class="title">(G) Other Achievements</div>
			<table>
				<tr>
					<th style="width: 70%">Items</th>
					<th style="width: 30%">Award</th>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_1"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_1"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_2"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_2"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_3"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_3"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_4"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_4"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_5"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_5"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_6"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_6"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_7"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_7"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_8"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_8"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_9"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_9"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_10"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_10"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_11"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_11"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_12"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_12"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_13"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_13"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_14"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_14"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_15"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_15"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_16"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_16"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_17"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_17"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_18"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_18"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_19"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_19"></div></td>
				</tr>
				<tr>
					<td><div class="ui-widget"><input class="extend remarks" id="remarks_20"></div></td>
					<td><div class="ui-widget"><input class="extend award" id="remarks_award_20"></div></td>
				</tr>
			</table>
			<input id="remarks_all" name="remarks" style="display:none;">
		</div>
		
		<input id="hidden_id" name="id" style="display:none;"> <!-- put the id at the bottom so as to facilitate php sql binding -->
		<input type="submit" value="Submit">
		
	</form>
	
</body>
</html>
<?php $conn->close();?>