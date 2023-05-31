

	<div align="center">
	<h2>Likes/Dislikes of <?php echo $s['Set']['title'].' '.$s['Set']['title2']; ?></h2>
	</div>
	<br>
	<?php
	echo $likes.' likes, '.$dislikes.' dislikes<br>';
	?>
	<br>
	<table class="contentOnTop" width="100%">
	<tr>
	<td>
	<table >
	<?php
		for($j=0; $j<count($a); $j++){
			echo '<tr>';
			echo '<td>'.$a[$j]['Reputation']['user'].'</td>';
			echo '<td>'.$a[$j]['Reputation']['tsumego'].'</td>';
			echo '<td>'.$a[$j]['Reputation']['value'].'</td>';
			echo '<td>'.$a[$j]['Reputation']['created'].'</td>';
			echo '</tr>';
		}
		//echo '<pre>'; print_r($as); echo '</pre>'; 
		//echo '<pre>'; print_r($repSets); echo '</pre>'; 
	?>
	</table>

	<?php
	
	//echo '<pre>'; print_r($a); echo '</pre>'; 