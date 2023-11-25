
	<?php 
	//echo $s1['Sgf']['sgf'];echo '<br><br>';echo $s2['Sgf']['sgf'];
	//echo $_SERVER["HTTP_HOST"];
	if($_SERVER["HTTP_HOST"]=='localhost') 
		$rootPath = '/tsumego-hero';
	else
		$rootPath = '';
	if($s2!=null)
		$diff = '$diff';
	else
		$diff = '';
	?>
	<script>
		document.cookie = "sgfForBesogo=<?php echo $s1['Sgf']['sgf'].';path='.$rootPath; ?>/app/webroot/editor/";
		<?php if($s2!=null){ ?>
			document.cookie = "diffForBesogo=<?php echo $s2['Sgf']['sgf'].';path='.$rootPath; ?>/app/webroot/editor/";
		<?php } ?>
		window.location.href = "<?php echo $rootPath.'/app/webroot/editor/?onSite='.$_SERVER['HTTP_HOST'].'$'.($t['Tsumego']['id']*1337).$diff; ?>";
	</script>