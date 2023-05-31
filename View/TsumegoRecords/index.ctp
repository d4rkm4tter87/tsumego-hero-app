<?php
	if(isset($_SESSION['loggedInUser'])){
		if($_SESSION['loggedInUser']['User']['id']!=72 && $_SESSION['loggedInUser']['User']['id']!=1543){
			echo '<script type="text/javascript">window.location.href = "/";</script>';
		}	
	}else{
		echo '<script type="text/javascript">window.location.href = "/";</script>';
	}
?>
CSV Files:<br>
<a href="/tsumego_records/csv/0">rating mode small</a><br>
<a href="/tsumego_records/csv/1">rating mode large</a><br>
<a href="/tsumego_records/csv/2">level mode small</a><br>
<a href="/tsumego_records/csv/3">level mode large</a><br>
<a href="/tsumego_records/csv/4">locations</a><br>
<a href="/tsumego_records/json">json</a><br>
<div align="center">
<?php
	//echo '<pre>';print_r($trs2);echo '</pre>';
?> 


<table width="85%" border="0" class="userstatsstbale">
	<tr>
		<td colspan="7">
		<?php
			echo $x;
		?>
		</td>
		
	</tr>
	<tr>
		<th>#</th>
		<th>user-id</th>
		<th>user-elo</th>
		<th>user-deviation</th>
		<th>tsumego-id</th>
		<th>tsumego-elo</th>
		<th>tsumego-deviation</th>
		<th>status</th>
		<th>seconds</th>
		<th>date/time</th>
	</tr>
	<?php
	
		for($i=0; $i<count($trs); $i++){
			if($trs[$i]['TsumegoRecord']['status']=='F'){
				$trs[$i]['TsumegoRecord']['user_deviation'] = '-'.$trs[$i]['TsumegoRecord']['user_deviation'];
				$trs[$i]['TsumegoRecord']['tsumego_deviation'] = '+'.$trs[$i]['TsumegoRecord']['tsumego_deviation'];
			}elseif($trs[$i]['TsumegoRecord']['status']=='S'){
				$trs[$i]['TsumegoRecord']['user_deviation'] = '+'.$trs[$i]['TsumegoRecord']['user_deviation'];
				$trs[$i]['TsumegoRecord']['tsumego_deviation'] = '-'.$trs[$i]['TsumegoRecord']['tsumego_deviation'];
			}
			if($trs[$i]['TsumegoRecord']['user_deviation']==null) $trs[$i]['TsumegoRecord']['user_deviation'] = 0;
			if($trs[$i]['TsumegoRecord']['tsumego_deviation']==null) $trs[$i]['TsumegoRecord']['tsumego_deviation'] = 0;
			
			echo '<tr>';
				echo '<td>';
					echo '<div align="center">'.($i+1).'</div>';
				echo '</td>';
				echo '<td>';
					echo '<div align="center"><a href="/tsumego_records/index/'.$trs[$i]['TsumegoRecord']['user_id'].'">'.$trs[$i]['TsumegoRecord']['user_id'].'</a></div>';
				echo '</td>';
				echo '<td>';
					echo '<div align="center">'.$trs[$i]['TsumegoRecord']['user_elo'].'</div>';
				echo '</td>';
				echo '<td>';
					echo '<div align="center">'.$trs[$i]['TsumegoRecord']['user_deviation'].'</div>';
				echo '</td>';
				echo '<td>';
					echo '<div align="center">'.$trs[$i]['TsumegoRecord']['tsumego_id'].'</div>';
				echo '</td>';
				echo '<td>';
					echo '<div align="center">'.$trs[$i]['TsumegoRecord']['tsumego_elo'].'</div>';
				echo '</td>';
				echo '<td>';
					echo '<div align="center">'.$trs[$i]['TsumegoRecord']['tsumego_deviation'].'</div>';
				echo '</td>';
				echo '<td>';
					echo '<div align="center">'.$trs[$i]['TsumegoRecord']['status'].'</div>';
				echo '</td>';
				echo '<td>';
					echo '<div align="center">'.$trs[$i]['TsumegoRecord']['seconds'].'</div>';
				echo '</td>';
				echo '<td>';
					echo '<div align="center">'.$trs[$i]['TsumegoRecord']['created'].'</div>';
				echo '</td>';
			echo '</tr>';
		}

	?>
	</table>


<?php
	//echo '<pre>'; print_r($trs); echo '</pre>';
?>