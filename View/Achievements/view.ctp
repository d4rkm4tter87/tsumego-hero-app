	
	<div align="center" >
	<?php
	if(!empty($as)) $aColor = $a['Achievement']['color']; 
	else $aColor = 'achievementColorGray';
	?>
	<p class="title <?php echo $aColor; ?>2">
				<br>Achievement: <?php echo $a['Achievement']['name']; ?>
				<br><br> 
				</p>
				<div class="achievemetProfileLink">
					<?php
						if(isset($_SESSION['loggedInUser']['User']['id'])){
							echo '<a href="/users/view/'.$_SESSION['loggedInUser']['User']['id'].'">Profile</a>';
						}
					?>
				</div>
				<div class="achievemetIndexLink">
					<a href="/achievements">View Achievements</a>
				</div>
		<div align="center" id="achievementWrapper">
	<a href="/achievements" style="text-decoration:none;">
	<div align="center" class="achievement2 <?php 
	echo $aColor;
	if(empty($as)) $a['Achievement']['image'] = 'ac000i';
	?>">
		<div class="acTitle">
			<h1><?php echo $a['Achievement']['name']; ?></h1>
		</div>
		<div class="acImg">
			<img src="/img/<?php echo $a['Achievement']['image']; ?>.png">
			<div class="acImgXp">
			<?php echo $a['Achievement']['xp']; ?> XP
			</div>
		</div>
		<div class="acDesc">
			<?php 
			echo $a['Achievement']['description']; 
			if($a['Achievement']['additionalDescription']!=null) echo '*';
			?>
		</div>
		<div class="acDate">
			<?php 
			if(!empty($as)){
				$date = new DateTime($as['Achievement']['created']);
				echo $as['AchievementStatus']['created'];
			}
			?>
		</div>
	</div>
	</a>
	<font color="gray">
	<?php 
	if($a['Achievement']['additionalDescription']!=null)
		echo '*'.$a['Achievement']['additionalDescription']; 
	?></font>
	<br>
	<br>
	<?php 
	if($aCount==0) echo 'Nobody unlocked this achievement.';
	else if($aCount==1) echo '1 user unlocked this achievement.';
	else echo $aCount.' users unlocked this achievement.';
	
	?><br><br>
	</div>
		
	</div>