	<?php
		echo count($ts);
		

		echo '<table border="1">';
		for($i=0; $i<count($ts); $i++){
			echo '<tr>';
			echo '<td><a target="_blank" href="/tsumegos/play/'.$ts[$i]['Tsumego']['id'].'">'.$ts[$i]['Tsumego']['id'].'</a></td>';
			echo '<td>'.$ts[$i]['Tsumego']['difficulty'].'</td>';
			echo '<td>'.$ts[$i]['Tsumego']['userWin'].'</td>';
			echo '<td>'.$ts[$i]['Tsumego']['author'].'</td>';
			echo '</tr>';
		}
		echo '<table>';
	?>