
	<div class="homeCenter2">
		<?php
			echo '<p class="title5">Profile</p>';
			//echo '<pre>';print_r($users2);echo '</pre>';
			if($hideEmail){
				$user = null;
				$solved = 0;
				$xpSum = 0;
				$p = 0;
				$rank = 0;
			}
		?>
	
		
		<table border="0" width="100%">
		<tr>
		<td style="vertical-align:top;padding:8px 0 0 14px;" width="63%" height="150px">
		
		<?php
			echo $user['User']['name'].'<br>';	
			if(!$hideEmail){
				echo '<div id="msg1">'.$user['User']['email'].' <a id="show" style="color:#74d14c;">change</a></div><br>';
				echo '<div id="msg2">';
				echo $this->Form->create('User');
				echo '<table border="0">';
				echo '<tr>';
				echo '<td style="vertical-align:top;>';
				echo $this->Form->input('email', array('label' => '', 'type' => 'text', 'placeholder' => 'E-Mail'));
				echo '</td><td style="vertical-align: top;" >';
				echo '<div class="submit"><input style="margin:0px;" value="Submit" type="submit"></div>';
				echo '</td>';
				echo '<tr>';
				echo '</table>';
				echo '</div>';
			}
			if($deletedProblems==1){
				echo 'If you have completed at least 75% of the problems, you can reset progress that is older than one year without losing any
				XP. <br><br>
				<font style="font-weight:800;color:#74d14c" >You have completed '.$p.'%. '; 
				
				if($p>=75){
					echo 'You can delete progress on '.$dNum.' problems.</font><br><br>';
					echo '<a class="new-button" href="#" onclick="delUts(); return false;">Reset ('.$dNum.')</a><br><br>';
				}else{
					echo '<br><br><a class="new-button-inactive" href="#" >Reset ('.$dNum.')</a><br><br>';
				}
			}elseif($deletedProblems==2){
				echo '<font style="font-weight:800;color:#74d14c" >The progress of '.$dNum.' problems has been deleted.</font>'; 
			}elseif($deletedProblems==3){
				
			}
		?>
		
		</td>
		<td style="vertical-align: top;">
		<table border="0">
		<?php
			echo '<tr>';
			//$tsumegoNum -= 1530;
			if($solved > $tsumegoNum) $solved=$tsumegoNum;
			echo '<td>Solved:</td>';
			echo '<td>'.$solved.' of '.$tsumegoNum.'</td>';
			echo ' </tr>';
			echo '<tr>';
			echo '<td>Level:</td><td>'.$user['User']['level'].'</td>';
			echo '</tr>';
			echo '<td>Health:</td><td>'.$user['User']['health'].' HP</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Level Up:</td><td>'.$user['User']['xp'].'/'.$user['User']['nextlvl'].'</td>';
			echo '</tr>';
		?>
		</table>
		</td>
		<td style="vertical-align: top;">
		<table border="0">
		<?php
			echo '<tr>';
			echo '<td>Overall:</td>';
			echo '<td>'.$p.'%</td>';
			echo '</tr>';
			
			echo '<tr>';
			if($rank==0) $rank = '-';
			echo '<td>Rank:</td><td>'.$rank.'</td>';
			echo '</tr>';
			
			echo '<tr>';
			$heroPowers = 0;
			if($user['User']['level']>=20) $heroPowers++;
			if($user['User']['level']>=30) $heroPowers++;
			if($user['User']['level']>=40) $heroPowers++;
			if($user['User']['premium']>0) $heroPowers++;
			echo '<td>Hero Powers:</td><td>'.$heroPowers.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>XP earned:</td><td>'.$xpSum.' XP</td>';
			echo '</tr>';
		?>
		</table>
		</td>
		</tr>
		</table>
		
	</div>
	
	<?php
	
	
	$size = count($graph);
	if($size<10) $height = '400';
	else if($size<30) $height = '600';
	else if($size<50) $height = '900';
	else $height = '1200';
	//print_r($size);
	?>
	  
	<script>
	$("#msg2").hide();
	$("#show").click(function(){
		$("#msg2").show();
	});
	
	window.onload = function () {
	
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		theme: "dark1",
		axisX:{
			interval: 1,labelFontSize: 14
			
		},
		axisY2:{
			interlacedColor: "rgba(1,77,101,.2)",
			gridColor: "rgba(1,77,101,.1)",
			titleFontSize: 17,
			labelFontSize: 14,
			title: "Solved Problems"
		},
		data: [{
			type: "bar",
			name: "tsumego",
			axisYType: "secondary",
			color: "#74d14c",
			dataPoints: [
				<?php
					if($size!=1){
						if($size>70) $startIndex = $size-70;
						else $startIndex = 0;
						for($j=$startIndex; $j<$size; $j++){
							$date = date_create($graph[$j]['date']);
							$tmonth = date("F", strtotime($graph[$j]['date']));
							$tday = $date->format('d. ');
							$tyear = $date->format('Y');
							if($tday[0]==0) $tday = substr($tday, -3);
							$graph[$j]['date'] = $tday.$tmonth.' '.$tyear;
							if($graph[$j]['num']==0.1) $graph[$j]['num']=0;
							echo '{ y: '.$graph[$j]['num'].', label: "'.$graph[$j]['date'].'" }';
							if($j!=count($graph)-1) echo ',';
						}
					}else{
						echo '{ y: 0, label: " " },';
						echo '{ y: '.$graph[0]['num'].', label: "'.$graph[0]['date'].'" }';
					}
				?>
			]
		}]
	});
	chart.render();

	}
	</script>
	
	<div align="center">
	<div id="chartContainer" style="height:<?php echo $height; ?>px;width:100%;"></div>
	</div>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<div class="homeCenter2" >
	<div class="homeCenter3" >
	<br>
	
	<br>
	</div></div>
	<script>
	function delUts(){
		<?php 
		echo 'confirm("Are you sure that you want to delete your progress on '.$dNum.' problems?");';
		echo 'window.location.href = "/users/view/'.$_SESSION['loggedInUser']['User']['id'].'?delete-uts=true";'; 
		?>
	}
	</script>
	
	
	

	
	
	
	
	
	
	
	
	

