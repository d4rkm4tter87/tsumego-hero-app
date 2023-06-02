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
	echo '<h1>File Uploads</h1>';
	echo '<table border="0" class="statsTable">';
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
	
	echo '<div class="homeLeft">';
	echo '<h1>Comments</h1>';
	echo '<table border="0" class="statsTable">';
	$iCounter = 1;
	for($i=count($ca['tsumego_id'])-1; $i>=0; $i--){
		echo '<tr>
			<td>'.($iCounter).'</td>
			<td><a target="_blank" href="/tsumegos/play/'.$ca['tsumego_id'][$i].'">'.$ca['tsumego'][$i].'</a></td>
			<td>'.$ca['created'][$i].'</td>
		</tr>';
		echo '<tr>
			<td></td>
			<td><b style="color:grey;">'.$ca['type'][$i].'</b><br>'.$ca['name'][$i].': '.$ca['answer'][$i].'</td>
			<td></td>
		</tr>';
		echo '<tr><td>';
		if(count($aa2)-1!=$i) echo '<hr>';
		echo '</td></tr>';
		$iCounter++;
	}
	echo '</table>';
	
	echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
	echo '</div>';
	
?>