	<?php
		echo '<table border="0">';
		for($i=0; $i<count($ts); $i++){
			if($ts[$i]['Tsumego']['rd']!=0 && $ts[$i]['Tsumego']['rd']!=7){
				echo '<tr>';
				echo '<td><a target="_blank" href="/users/tsumego_rating/'.$ts[$i]['Tsumego']['id'].'" > '.$ts[$i]['Tsumego']['id'].'</a></td>';
				echo '<td>'.$ts[$i]['Tsumego']['rd'].'</td>';
				echo '</tr>';
			}
		}
		echo '<table>';
	?>