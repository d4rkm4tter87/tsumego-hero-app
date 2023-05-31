<?php
	
	if(isset($_SESSION['loggedInUser'])){
		if($_SESSION['loggedInUser']['User']['isAdmin']<1){
			echo '<script type="text/javascript">window.location.href = "/";</script>';
		}	
	}else{
		echo '<script type="text/javascript">window.location.href = "/";</script>';
	}

	echo '<div class="homeRight">';
	?>
	<?php
	echo '<table class="statsTable">';
	for($i=0; $i<count($aa1); $i++){	
		echo '<tr>
			<td>'.($i+1).'</td>
			
			<td><a target="_blank" href="/tsumegos/play/'.$aa1[$i]['AdminActivity']['tsumego_id'].'">'.$aa1[$i]['AdminActivity']['tsumego'].'</a></td>
			<td>'.$aa1[$i]['AdminActivity']['created'].'</td>';
		echo '</tr>';
		echo '<tr>
			<td></td>
			<td>'.$aa1[$i]['AdminActivity']['name'].': '.$aa1[$i]['AdminActivity']['file'].'</td>
			<td>'.$aa1[$i]['AdminActivity']['answer'].'</td>
		</tr>';
		echo '<tr><td>';
		if(count($aa1)-1!=$i) echo '<hr>';
		echo '</td></tr>';
	}
	echo '</table>';
	echo '</div>';
	//echo '<pre>';print_r($aa1);echo '</pre>';
	//echo '<pre>';print_r($aa2);echo '</pre>';
	echo '<div class="homeLeft">';
	echo '<table class="statsTable">';
	for($i=0; $i<count($aa2); $i++){
		echo '<tr>
			<td>'.($i+1).'</td>
			<td><a target="_blank" href="/tsumegos/play/'.$aa2[$i]['AdminActivity']['tsumego_id'].'">'.$aa2[$i]['AdminActivity']['tsumego'].'</a></td>
			<td>'.$aa2[$i]['AdminActivity']['created'].'</td>
		</tr>';
		echo '<tr>
			<td></td>
			<td>'.$aa2[$i]['AdminActivity']['name'].': '.$aa2[$i]['AdminActivity']['answer'].'</td>
			<td></td>
		</tr>';
		echo '<tr><td>';
		if(count($aa2)-1!=$i) echo '<hr>';
		echo '</td></tr>';
	}
	echo '</table>';
	
	echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
	echo '</div>';
	
?>