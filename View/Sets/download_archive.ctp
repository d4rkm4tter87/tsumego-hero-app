


<table class="highscoreTable" border="0">
	<tbody>
	<?php
		for($i=0; $i<count($s); $i++){
			echo '<tr>';
			echo '<td class="timeTableMiddle versionColor" align="left">';
			echo $s[$i]['Set']['id'];
			echo '</td>';
			echo '<td class="timeTableMiddle versionColor" align="left">';
			echo $s[$i]['Set']['title'];
			echo '</td>';
			echo '</tr>';
		}
	?>
	</tbody>
</table>

<script>
<?php
	if($text<count($s)){
		echo 'setTimeout(function(){
			window.location.href = "/sets/download_archive2/'.$s[$text]['Set']['id'].'";
		}, 100);';
	}
?>
</script>
