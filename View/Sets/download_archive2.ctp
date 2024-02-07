<script src ="/FileSaver.min.js"></script>

<?php
	
	echo '<pre>'; print_r(count($t)); echo '</pre>';
?>

<table class="highscoreTable" border="0">
	<tbody>
	<?php
		for($i=0; $i<count($t); $i++){
			echo '<tr>';
			echo '<td class="timeTableMiddle versionColor" align="left">';
			echo $t[$i]['Tsumego']['num'];
			echo '</td>';
			echo '<td class="timeTableMiddle versionColor" align="left">';
			echo $t[$i]['Tsumego']['title'];
			echo '</td>';
			echo '</tr>';
		}
	?>
	</tbody>
</table>

<script>
	setTimeout(function(){
	   window.location.href = "/sets/download_archive";
	}, 100);
</script>
