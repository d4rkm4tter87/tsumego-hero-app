<?php
	$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
	$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		$url = parse_url($_SERVER['HTTP_HOST']);
		$url['path'] = str_replace('tsumego-hero.com','',$url['path']);
		if($url['path']=='www.') echo '<script type="text/javascript">window.location.href = "https://tsumego-hero.com'.$_SERVER['REQUEST_URI'].'";</script>';
		if(isset($_SESSION['redirect']) && $_SESSION['redirect']=='sets'){
			unset($_SESSION['redirect']);
			echo '<script type="text/javascript">window.location.href = "/";</script>';
		}
		if(isset($_SESSION['redirect']) && $_SESSION['redirect']=='loading'){
			unset($_SESSION['redirect']);
			echo '<script type="text/javascript">window.location.href = "/users/loading";</script>';
		}
		//if($_SERVER['REMOTE_ADDR'] != '188.104.244.212') echo '<script type="text/javascript">window.location.href = "https://tsumego-hero.com/";</script>';
		echo $this->Html->charset(); 
	?>
	<title>
		<?php
			if(!isset($_SESSION['title'])) echo 'Tsumego Hero';
			else echo $_SESSION['title'];
		?>
	</title>
	
	<meta name="description" content="Interactive tsumego database. Solve go problems, get stronger, level up, have fun.">
	<meta name="keywords" content="tsumego, problems, puzzles, baduk, weiqi, tesuji, life and death, solve, solving, hero, go, in-seong, level" >	
	<meta name="Author" content="Joschka Zimdars">
	<meta property="og:title" content="Tsumego Hero">
	<link rel="stylesheet" type="text/css" href="/css/default.css?v=2.2">
	<?php
		//echo $_SERVER['REMOTE_ADDR'];
		echo $this->Html->meta('icon');
		//echo $this->Html->css('default');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
	?>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="/dist/jgoboard-latest.js"></script>
	<?php
		
		if($mode==1){ 
			if(isset($user['User']['level'])) $levelNum = 'Level '.$user['User']['level'];
			else $levelNum = 1;
			$xpBarFill = 'xp-bar-fill-c1';
		}elseif($mode==2){
			$xpBarFill = 'xp-bar-fill-c2';
			if($user['User']['elo_rating_mode']>=2900) $td = '9d';
			elseif($user['User']['elo_rating_mode']>=2800) $td = '8d';
			elseif($user['User']['elo_rating_mode']>=2700) $td = '7d';
			elseif($user['User']['elo_rating_mode']>=2600) $td = '6d';
			elseif($user['User']['elo_rating_mode']>=2500) $td = '5d';
			elseif($user['User']['elo_rating_mode']>=2400) $td = '4d'; 
			elseif($user['User']['elo_rating_mode']>=2300) $td = '3d';
			elseif($user['User']['elo_rating_mode']>=2200) $td = '2d'; 
			elseif($user['User']['elo_rating_mode']>=2100) $td = '1d';
			elseif($user['User']['elo_rating_mode']>=2000) $td = '1k'; 
			elseif($user['User']['elo_rating_mode']>=1900) $td = '2k';
			elseif($user['User']['elo_rating_mode']>=1800) $td = '3k'; 
			elseif($user['User']['elo_rating_mode']>=1700) $td = '4k';
			elseif($user['User']['elo_rating_mode']>=1600) $td = '5k';
			elseif($user['User']['elo_rating_mode']>=1500) $td = '6k';
			elseif($user['User']['elo_rating_mode']>=1400) $td = '7k'; 
			elseif($user['User']['elo_rating_mode']>=1300) $td = '8k';
			elseif($user['User']['elo_rating_mode']>=1200) $td = '9k';
			elseif($user['User']['elo_rating_mode']>=1100) $td = '10k';
			elseif($user['User']['elo_rating_mode']>=1000) $td = '11k';
			elseif($user['User']['elo_rating_mode']>=900) $td = '12k';
			elseif($user['User']['elo_rating_mode']>=800) $td = '13k';
			elseif($user['User']['elo_rating_mode']>=700) $td = '14k';
			elseif($user['User']['elo_rating_mode']>=600) $td = '15k';
			elseif($user['User']['elo_rating_mode']>=500) $td = '16k';
			elseif($user['User']['elo_rating_mode']>=400) $td = '17k';
			elseif($user['User']['elo_rating_mode']>=300) $td = '18k';
			elseif($user['User']['elo_rating_mode']>=200) $td = '19k';
			elseif($user['User']['elo_rating_mode']>=100) $td = '20k';
			else $td = '20k';
			//$levelNum = '<p id="bar-0"></p><p id="bar-1">'.$td.'</p><p id="bar-2">&nbsp;(</p><p id="bar-3">'.$user['User']['elo_rating_mode'].'</p><p id="bar-2">)</p>';
			$levelNum = $td;
		}elseif($mode==3){
			$levelNum = '15k';
			$xpBarFill = 'xp-bar-fill-c3';
		}
	?>
</head>
<body>
	<div id="container" align="center">
	<div width="100%" class="whitebox1">
		<div align="left">
			<a href="/">
				<?php 
					$logo = 'tsumegoHero1';
					$logoH = 'tsumegoHero2';
				?>
				<img id="logo1" alt="Tsumego Hero" title="Tsumego Hero" src="/img/tsumegoHero1.png" onmouseover="logoHover(this)" onmouseout="logoNoHover(this)" height="55px">
			</a>
		</div>
	
		<div class="outerMenu1">
			<?php 
				if(isset($_SESSION['lastVisit'])) $lv = $_SESSION['lastVisit'];
				else $lv = '15352';
				
				if(isset($_SESSION['loggedInUser'])){
					
					
					if($_SESSION['loggedInUser']['User']['premium']>=1) $sand = 'onmouseover="sandboxHover()" onmouseout="sandboxNoHover()"';
					else $sand = '';
					if($_SESSION['loggedInUser']['User']['premium']>=1) $leaderboard = 'onmouseover="leaderboardHover()" onmouseout="leaderboardNoHover()"';
					else $leaderboard = '';
				}else{
					$sand = '';
					$leaderboard = '';
				}
				
				$homeA = '';
				$collectionsA = '';
				$playA = '';
				$highscoreA = '';
				$discussA = '';
				$sandboxA = '';
				$leaderboardA = '';
				$refreshLinkToStart = '';
				$refreshLinkToSets = '';
				$refreshLinkToHighscore = '';
				$refreshLinkToLeaderboard = '';
				$refreshLinkToSandbox = '';
				$refreshLinkToDiscuss = '';
				$refreshLinkToLeaderboardBackup = '';
				$refreshLinkToSandboxBackup = '';
				$refreshLinkToDiscussBackup = '';
				$levelHighscoreA = '';
				$ratingHighscoreA = '';
				$timeHighscoreA = '';
				$dailyHighscoreA = '';
				$levelModeA = '';
				$ratingModeA = '';
				$timeModeA = '';
				$websitefunctionsA = '';
				$gotutorialA = '';
				$aboutA = '';
				
				if($_SESSION['page'] == 'home') $homeA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'set') $collectionsA = 'style="color:#74d14c;"';
				else if($_SESSION['page']=='play' || $_SESSION['page']=='level mode' || $_SESSION['page']=='rating mode' || $_SESSION['page']=='time mode'){
					//$playA = 'style="color:#74d14c;"';
					$refreshLinkToStart = 'id="refreshLinkToStart"';
					$refreshLinkToSets = 'id="refreshLinkToSets"';
					$refreshLinkToHighscore = 'id="refreshLinkToHighscore"';
					$refreshLinkToLeaderboard = 'id="refreshLinkToLeaderboard"';
					$refreshLinkToSandbox = 'id="refreshLinkToSandbox"';
					$refreshLinkToDiscuss = 'id="refreshLinkToDiscuss"';
					if($_SESSION['page'] == 'level mode') $levelModeA = 'style="color:#74d14c;"';
					else if($_SESSION['page'] == 'rating mode') $ratingModeA = 'style="color:#74d14c;"';
					else if($_SESSION['page'] == 'time mode') $timeModeA = 'style="color:#74d14c;"';
				}					
				else if($_SESSION['page'] == 'highscore') $highscoreA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'discuss') $discussA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'sandbox') $sandboxA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'leaderboard') $leaderboardA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'websitefunctions') $websitefunctionsA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'gotutorial') $gotutorialA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'about') $aboutA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'levelHighscore') $levelHighscoreA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'ratingHighscore') $ratingHighscoreA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'timeHighscore') $timeHighscoreA = 'style="color:#74d14c;"';
				else if($_SESSION['page'] == 'dailyHighscore') $dailyHighscoreA = 'style="color:#74d14c;"';
				
				if(isset($nextMode['Tsumego']['id'])){
					if($nextMode['Tsumego']['id']==null) $nextMode['Tsumego']['id'] = 15352;
				}else{
					$nextMode['Tsumego']['id'] = 15352;
				}
				//echo $_SESSION['page'];
				//echo '<li><a '.$refreshLinkToStart.' class="menuLi" '.$homeA.' href="/">Home</a></li>';
				//echo '<li><a '.$refreshLinkToSets.' class="menuLi" '.$collectionsA.' id="collectionsInMenu" '.$sand.' href="/sets">Collections</a></li>';
				//if(true)/*if(!$ac)*/ echo '<li><a class="menuLi" '.$playA.' href="/tsumegos/play/'.$lv.'">Play</a></li>';	
				//else echo '<li><a class="menuLi" '.$playA.' href="/tsumegos/play/'.$nextMode['Tsumego']['id'].'?mode=2">Play</a></li>';
				//echo '<li><a '.$refreshLinkToHighscore.' class="menuLi" '.$highscoreA.' id="highscoreInMenu" '.$leaderboard.' href="/users/'.$highscoreLink.'">Highscore</a></li>';
				if(isset($_SESSION['loggedInUser'])){
					if($_SESSION['loggedInUser']['User']['isAdmin']==0) $discussFilter = '';
					else $discussFilter = '?filter=false';
					if($_SESSION['loggedInUser']['User']['completed']==1 || $_SESSION['loggedInUser']['User']['premium']>=1){
					//echo '<li><a '.$refreshLinkToSandbox.' class="menuLi" id="sandbox-menu" '.$sandboxA.' href="/sets/beta">Sandbox</a></li>';
					}else{
						$refreshLinkToSandboxBackup = '<a id="refreshLinkToSandbox"></a>';
					}
					if($_SESSION['loggedInUser']['User']['premium']>=1){
					//echo '<li><a '.$refreshLinkToLeaderboard.' class="menuLi" id="leaderboard-menu" '.$leaderboardA.' href="/users/leaderboard">Leaderboard</a></li>';
					}else{
						$refreshLinkToLeaderboardBackup = '<a id="refreshLinkToLeaderboard"></a>';
					}
				}else{
					$refreshLinkToDiscussBackup = '<a id="refreshLinkToDiscuss"></a>';
				}	
				
			?> 
			<div id="newMenu">
			<nav>
				<ul>
					<?php echo '<li><a class="homeMenuLink" href="/" '.$refreshLinkToStart.' '.$homeA.'>Home</a>'; 
					echo '<ul class="newMenuLi1">';
						echo '<li><a id="tutorialLink" href="/sites/websitefunctions" '.$websitefunctionsA.'>Functions & Modes</a></li>';
						echo '<li><a id="tutorialLink" href="/sites/gotutorial" '.$gotutorialA.'>Go Rules</a></li>';
						//echo '<li><a id="tutorialLink" href="/sites/gotutorial" '.$gotutorialA.'>Go Tutorial</a></li>';
						echo '<li><a href="/users/authors" '.$aboutA.'>About</a></li>';
					echo '</ul>';       
					echo '</li>';
					echo '<li><a '.$refreshLinkToSets.' '.$collectionsA.' href="/sets">Collections</a>';
					if(isset($_SESSION['loggedInUser'])){
						if($_SESSION['loggedInUser']['User']['premium']>=1 || $_SESSION['loggedInUser']['User']['level']>=60){
							echo '<ul class="newMenuLi2">';
								echo '<li><a '.$refreshLinkToSandbox.' '.$sandboxA.' href="/sets/beta">Sandbox</a></li>';
								if($_SESSION['loggedInUser']['User']['isAdmin']>=1){
									echo '<li><a class="adminLink" href="/users/adminstats">Admin Activities</a></li>';
									echo '<li><a class="adminLink" href="/users/userstats">User Activities</a></li>';
									echo '<li><a class="adminLink" href="https://kovarex.github.io/besogo/testing.html">Editor</a></li>';
									echo '<li><a class="adminLink" href="/users/publish">Publish Schedule</a></li>';
									echo '<li><a class="adminLink" href="/users/likesview">Likes/Dislikes</a></li>';
								}
							echo '</ul>';
						}
					}
					echo '</li>';
					echo '<li><a class="homeMenuLink" '.$playA.' href="/tsumegos/play/'.$lv.'">Play</a>';
					echo '<ul class="newMenuLi3">';
						echo '<li><a href="/tsumegos/play/'.$_SESSION['lastVisit'].'?mode=1" '.$levelModeA.'>Level</a></li>';
						if(isset($_SESSION['loggedInUser']['User']['id'])){
							echo '<li><a href="/tsumegos/play/'.$nextMode['Tsumego']['id'].'?mode=2" '.$ratingModeA.'>Rating</a></li>';
							echo '<li><a href="/ranks/overview" '.$timeModeA.'>Time</a></li>';
						}
					echo '</ul>'; 
					echo '<li><a '.$refreshLinkToHighscore.' '.$highscoreA.' href="/users/'.$highscoreLink.'">Highscore</a>';
					echo '<ul class="newMenuLi4">';
						echo '<li><a id="tutorialLink" href="/users/highscore" '.$levelHighscoreA.'>Level Highscore</a></li>';
						echo '<li><a id="tutorialLink" href="/users/rating" '.$ratingHighscoreA.'>Rating Highscore</a></li>';
						echo '<li><a id="tutorialLink" href="/users/highscore3" '.$timeHighscoreA.'>Time Highscore</a></li>';
						echo '<li><a id="tutorialLink" href="/users/leaderboard" '.$dailyHighscoreA.'>Daily Highscore</a></li>';
					echo '</ul>';
					if(isset($_SESSION['loggedInUser'])) echo '<li><a  '.$refreshLinkToDiscuss.'  '.$discussA.'href="/comments'.$discussFilter.'">Discuss</a></li>';
					else echo '<li><a style="color:#aaa;">Discuss</a></li>';
					echo '<li class="menuIcons1"><a href="#" id="soundButton" onclick="changeSound(); return false;"><img id="soundButtonImage" src="/img/sound-icon1.png" width="25px"></a></li>';
					?>
					<li class="menuIcons1">
							<div class="dropdown">
								<label for="dropdown-1" id="boardsInMenu" class="dropdown-button">
									<img id="boardsButtonImage" src="/img/boards-icon1.png" width="25px">
								</label>
								<input class="dropdown-open" type="checkbox" id="dropdown-1" style="display:none;" onchange="check1(); return false;">
								<label for="dropdown-1" class="dropdown-overlay"></label>
								<div class="dropdown-inner">
									<table id="dropdowntable" border="0">
										<tr>
										<?php
											$tr = 1;
											for($i=1;$i<=54;$i++){
												if(isset($boardNames[$i])){
												echo '
													<td width="19px" align="right" style="position:relative;top:1px;padding:4px;">
														<input type="checkbox" class="newCheck" id="newCheck'.$i.'" onchange="check2();" '.$enabledBoards[$i].'>
													</td>
													<td width="19px" align="center" style="position:relative;top:3px;padding:2px;">
														
														<div class="img-'.$boardPositions[$i][0].'small"></div>
													</td>
													<td width="115px" style="padding:0px;text-align:left;">
														'.$boardNames[$i].'
													</td>
												';
												}
												if($tr%4==0 && $tr>0) echo '</tr><tr>';
												$tr++;
											}
										?>	
										</tr>
									</table>
									<br>
									<div id="dropdowntable2" align="center">
										<?php
											echo '<a class="new-button" href="'.$_SERVER['REQUEST_URI'].'">Save</a>';
										?>
										<br><br>
									</div>
								</div>
							</div>
						
					</li>
				</ul>
			</nav>
		</div>
		</div>
		<div class="outerMenu2">
			<li><a></a></li>
		</div>
		<div class="outerMenu3">
			<?php  
				$currentPage = '';
				if($_SESSION['page'] == 'user') $currentPage = 'style="color:#74d14c;" ';
				if(!isset($_SESSION['loggedInUser']['User']['id'])) echo '<li><a class="menuLi" id="signInMenu" '.$currentPage.'href="/users/login">Sign In</a></li>';
			?>
		</div>
		
	</div>
	<?php
		if(isset($_SESSION['loggedInUser']) && isset($_SESSION['loggedInUser']['User']['id'])){
			//if($_SESSION['loggedInUser']['User']['id']!=72){
			//echo '<pre>';print_r($_SESSION['loggedInUser']);echo '</pre>';
			echo '
				<div id="account-bar-wrapper" onmouseover="xpHover()">
					  <div id="account-bar">
							<div id="account-bar-user">
								<a href="/users/view/'.$_SESSION['loggedInUser']['User']['id'].'">
									'.$user['User']['name'].'
								</a>
							</div>
							<div id="xp-bar">
								  <div id="xp-bar-fill" class="'.$xpBarFill.'">
										<div id="xp-increase-fx">
											<div id="xp-increase-fx-flicker">
												<div class="xp-increase-glow1"></div>
												<div class="xp-increase-glow2"></div>
												<div class="xp-increase-glow3"></div>
											</div>
											<div class="xp-increase-glow2"></div>
										</div>
								  </div>
							</div>
							<div id="account-bar-xp-wrapper">
								<div id="account-bar-xp">'.$levelNum.'</div>
							</div>
					  </div>
				</div>
				<div id="heroProfile" onmouseover="xpHover()" onmouseout="xpNoHover()">
					<li><a href="/users/view/'.$_SESSION['loggedInUser']['User']['id'].'">Profile</a></li>
				</div>
				<div id="heroLogout" onmouseover="xpHover()" onmouseout="xpNoHover()">
					<li><a href="/users/logout">Sign Out</a></li>
				</div>
			';
			
		}
	?>
	
	<div width="100%" align="left" class="whitebox2" <?php if(isset($_SESSION['loggedInUser'])){ echo 'onmouseover="xpNoHover()"'; } ?>>
		<?php 
			$setHeight = '';
			if(isset($set)){
				if($set['Set']['id']==60) $setHeight = 'style="height:1340px;"';
			}
			echo $refreshLinkToLeaderboardBackup.$refreshLinkToSandboxBackup.$refreshLinkToDiscussBackup;
			echo '<div id="content" '.$setHeight.'>';
			echo $this->Session->flash();
			echo $this->Flash->render();
			echo $this->fetch('content'); 
		?>
		</div>
	</div>
	</div>
	<div id="footer" class="footerLinks"><br>
	
	
	
	<?php if(isset($_SESSION['loggedInUser'])){ ?>
	<?php if($_SESSION['loggedInUser']['User']['premium']==0 && $user['User']['id']!=1165){ ?>
		<div align="center"><a href="/users/donate"><img id="donateH2" onmouseover="donateHover2()" onmouseout="donateNoHover2()" width="180px" src="/img/donateButton1.png"></a><br></div><br>	
	<?php } ?>
	<?php }else{ ?>
		<div align="center"><a href="/users/donate"><img id="donateH2" onmouseover="donateHover2()" onmouseout="donateNoHover2()" width="180px" src="/img/donateButton1.png"></a><br></div><br>
	<?php } ?>
	Tsumego Hero © 2023<br>
		<a href="mailto:me@joschkazimdars.com">me@joschkazimdars.com</a><br><br>
		<a href="/sites/impressum">Legal notice</a><br>
		<a href="/users/authors">About</a><br><br><br>
	</div>
	
	<script type="text/javascript">
		usedModeSwitch = false;
		document.cookie = "score=0";
		document.cookie = "misplay=0";
		document.cookie = "preId=0";
		document.cookie = "sprint=0";
		document.cookie = "intuition=0";
		document.cookie = "rejuvenation=0";
		document.cookie = "refinement=0";
		document.cookie = "favorite=0";
		document.cookie = "mode=0";
		document.cookie = "skip=0";
		document.cookie = "transition=0";
		document.cookie = "difficulty=0";
		document.cookie = "seconds=0";
		document.cookie = "sequence=0";
		document.cookie = "reputation=0";
		document.cookie = "rank=0";
		document.cookie = "lastMode=0";
		document.cookie = "sound=0";
		document.cookie = "correctNoPoints=0";
		document.cookie = "ui=0";
		document.cookie = "requestProblem=0";
		
		<?php 
			if(isset($textureCookies)){
				for($i=0;$i<count($textureCookies);$i++){
					echo 'document.cookie = "'.$textureCookies[$i].'=0";';
				}
			}
		?>
		var soundsEnabled = true;
		var notMode3 = true;
		
		<?php if(isset($_SESSION['loggedInUser'])){ ?>
		var userXP = <?php echo $user['User']['xp']; ?> ;
		var userLevel = <?php echo $user['User']['level']; ?> ;
		var userNextLvl = <?php echo $user['User']['nextlvl']; ?> ;
		var userElo = <?php echo $user['User']['elo_rating_mode']; ?> ;
		var soundValue = 0;
		<?php 
		echo 'soundValue = "'.$_SESSION['loggedInUser']['User']['sound'].'";';
		
		} ?>
		
		$(document).ready(function(){
			loadBar();
			if(soundValue=="off"){
				document.getElementById("soundButtonImage").src="/img/sound-icon2.png";
				document.cookie = "sound=off";
				soundsEnabled = false;
			}
			if(soundValue=="on"){
				document.getElementById("soundButtonImage").src="/img/sound-icon1.png";
				document.cookie = "sound=on";
				soundsEnabled = true;
			}
			
			<?php
				if($_SESSION['loggedInUser']['User']['mode']==1){
					echo '$("#account-bar-user > a").css({color:"#74d14c"});';
				}elseif($_SESSION['loggedInUser']['User']['mode']==2){
					echo '$("#account-bar-user > a").css({color:"#d19fe4"});';
				}
				if(isset($sortColor) && $sortColor!= 'null'){
					if($sortColor=='1'){
						echo 'solvedColor();';
					}
					if($sortColor=='2'){
						echo 'difficultyColor();';
					}
					if($sortColor=='3'){
						echo 'sizeColor();';
					}
					if($sortColor=='4'){
						echo 'dateColor();';
					}
				}
				if(isset($sortOrder) && $sortOrder!= 'null'){
					if($sortOrder=='10'){
						echo 'progressButton1();';
					}
					if($sortOrder=='20'){
						echo 'difficultyButton2();';
					}
					if($sortOrder=='30'){
						echo 'sizeButton1();';
					}
					if($sortOrder=='40'){
						echo 'dateButton1();';
					}
					if($sortOrder=='11'){
						echo 'progressButton2();';
					}
					if($sortOrder=='21'){
						echo 'difficultyButton1();';
					}
					if($sortOrder=='31'){
						echo 'sizeButton2();';
					}
					if($sortOrder=='41'){
						echo 'dateButton2();';
					}
				}
				
			if(isset($loggedInUser)){
				echo 'var end = new Date("'.$nextDay.' 00:00 AM");';
				?>
				var _second = 1000;
				var _minute = _second * 60;
				var _hour = _minute * 60;
				var _day = _hour * 24;
				var timer;
				var now = new Date();
				var distance = end - now;
				if (distance < 0) {
					clearInterval(timer);
					return;
				}
				var days = Math.floor(distance / _day);
				var hours = Math.floor((distance % _day) / _hour);
				var minutes = Math.floor((distance % _hour) / _minute);
				var seconds = Math.floor((distance % _minute) / _second);
				if(hours<10) hours="0"+hours;
				if(minutes<10) minutes="0"+minutes;
				if(seconds<10) seconds="0"+seconds;
				if(document.getElementById("homeCountdown")){
					document.getElementById("homeCountdown").innerHTML = hours + ":";
					document.getElementById("homeCountdown").innerHTML += minutes + ":";
					document.getElementById("homeCountdown").innerHTML += seconds;
				}
				timer = setInterval(showRemaining, 1000);
				function showRemaining() {
					var now = new Date();
					var distance = end - now;
					if (distance < 0) {
						clearInterval(timer);
						return;
					}
					var days = Math.floor(distance / _day);
					var hours = Math.floor((distance % _day) / _hour);
					var minutes = Math.floor((distance % _hour) / _minute);
					var seconds = Math.floor((distance % _minute) / _second);
					if(hours<10) hours="0"+hours;
					if(minutes<10) minutes="0"+minutes;
					if(seconds<10) seconds="0"+seconds;
					if(document.getElementById("homeCountdown")){
						document.getElementById("homeCountdown").innerHTML = hours + ":";
						document.getElementById("homeCountdown").innerHTML += minutes + ":";
						document.getElementById("homeCountdown").innerHTML += seconds;
					}
				}
			<?php } ?>
		});
		function updateCookie(c1,c2){
			document.cookie = c1+c2;
		}
		
		function logoHover(img){
			img.src = '/img/<?php echo $logoH ?>.png';
		}
		
		function logoNoHover(img){
			img.src = "/img/<?php echo $logo ?>.png";
		}
		
		function check1(){
			if(document.getElementById("dropdown-1").checked == true){
				document.getElementById("dropdowntable").style.display = "inline-block"; 
				document.getElementById("dropdowntable2").style.display = "inline-block"; 
				$(".dropdown-inner").css("opacity", "1");
				$(".dropdown-inner").css("display", "inline-block");
			}
			if(document.getElementById("dropdown-1").checked == false){
				document.getElementById("dropdowntable").style.display = "none"; 
				document.getElementById("dropdowntable2").style.display = "none";
				$(".dropdown-inner").css("opacity", "0");
				$(".dropdown-inner").css("display", "none");
			}
		}
		function test1(){
			alert("test");
		}
		function boardsHover(){
			document.getElementById("boardsInMenu").style.color = "#74D14C"; 
			document.getElementById("boardsInMenu").style.backgroundColor = "grey"; 
		}
		function boardsNoHover(){
			document.getElementById("boardsInMenu").style.color = "#d19fe4"; 
			document.getElementById("boardsInMenu").style.backgroundColor = "transparent";
		}
		function check2(){
			if(document.getElementById("newCheck1").checked) document.cookie = "texture1=checked"; else document.cookie = "texture1= ";
			if(document.getElementById("newCheck2").checked) document.cookie = "texture2=checked"; else document.cookie = "texture2= ";
			if(document.getElementById("newCheck3").checked) document.cookie = "texture3=checked"; else document.cookie = "texture3= ";
			if(document.getElementById("newCheck4").checked) document.cookie = "texture4=checked"; else document.cookie = "texture4= ";
			if(document.getElementById("newCheck5").checked) document.cookie = "texture5=checked"; else document.cookie = "texture5= ";
			if(document.getElementById("newCheck6").checked) document.cookie = "texture6=checked"; else document.cookie = "texture6= ";
			if(document.getElementById("newCheck7").checked) document.cookie = "texture7=checked"; else document.cookie = "texture7= ";
			if(document.getElementById("newCheck8").checked) document.cookie = "texture8=checked"; else document.cookie = "texture8= ";
			if(document.getElementById("newCheck9").checked) document.cookie = "texture9=checked"; else document.cookie = "texture9= ";
			if(document.getElementById("newCheck10").checked) document.cookie = "texture10=checked"; else document.cookie = "texture10= ";
			if(document.getElementById("newCheck11").checked) document.cookie = "texture11=checked"; else document.cookie = "texture11= ";
			if(document.getElementById("newCheck12").checked) document.cookie = "texture12=checked"; else document.cookie = "texture12= ";
			if(document.getElementById("newCheck13").checked) document.cookie = "texture13=checked"; else document.cookie = "texture13= ";
			if(document.getElementById("newCheck14").checked) document.cookie = "texture14=checked"; else document.cookie = "texture14= ";
			if(document.getElementById("newCheck15").checked) document.cookie = "texture15=checked"; else document.cookie = "texture15= ";
			if(document.getElementById("newCheck16").checked) document.cookie = "texture16=checked"; else document.cookie = "texture16= ";
			if(document.getElementById("newCheck17").checked) document.cookie = "texture17=checked"; else document.cookie = "texture17= ";
			if(document.getElementById("newCheck18").checked) document.cookie = "texture18=checked"; else document.cookie = "texture18= ";
			if(document.getElementById("newCheck19").checked) document.cookie = "texture19=checked"; else document.cookie = "texture19= ";
			if(document.getElementById("newCheck20").checked) document.cookie = "texture20=checked"; else document.cookie = "texture20= ";
			if(document.getElementById("newCheck21").checked) document.cookie = "texture21=checked"; else document.cookie = "texture21= ";
			if(document.getElementById("newCheck22").checked) document.cookie = "texture22=checked"; else document.cookie = "texture22= ";
			if(document.getElementById("newCheck23").checked) document.cookie = "texture23=checked"; else document.cookie = "texture23= ";
			if(document.getElementById("newCheck24").checked) document.cookie = "texture24=checked"; else document.cookie = "texture24= ";
			if(document.getElementById("newCheck25").checked) document.cookie = "texture25=checked"; else document.cookie = "texture25= ";
			if(document.getElementById("newCheck26").checked) document.cookie = "texture26=checked"; else document.cookie = "texture26= ";
			if(document.getElementById("newCheck27").checked) document.cookie = "texture27=checked"; else document.cookie = "texture27= ";
			if(document.getElementById("newCheck28").checked) document.cookie = "texture28=checked"; else document.cookie = "texture28= ";
			if(document.getElementById("newCheck29").checked) document.cookie = "texture29=checked"; else document.cookie = "texture29= ";
			if(document.getElementById("newCheck30").checked) document.cookie = "texture30=checked"; else document.cookie = "texture30= ";
			if(document.getElementById("newCheck31").checked) document.cookie = "texture31=checked"; else document.cookie = "texture31= ";
			if(document.getElementById("newCheck32").checked) document.cookie = "texture32=checked"; else document.cookie = "texture32= ";
			if(document.getElementById("newCheck33").checked) document.cookie = "texture33=checked"; else document.cookie = "texture33= ";
			if(document.getElementById("newCheck34").checked) document.cookie = "texture34=checked"; else document.cookie = "texture34= ";
			if(document.getElementById("newCheck35").checked) document.cookie = "texture35=checked"; else document.cookie = "texture35= ";
			if(document.getElementById("newCheck36").checked) document.cookie = "texture36=checked"; else document.cookie = "texture36= ";
			if(document.getElementById("newCheck37").checked) document.cookie = "texture37=checked"; else document.cookie = "texture37= ";
			if(document.getElementById("newCheck38").checked) document.cookie = "texture38=checked"; else document.cookie = "texture38= ";
			if(document.getElementById("newCheck39").checked) document.cookie = "texture39=checked"; else document.cookie = "texture39= ";
			if(document.getElementById("newCheck40").checked) document.cookie = "texture40=checked"; else document.cookie = "texture40= ";
			if(document.getElementById("newCheck41").checked) document.cookie = "texture41=checked"; else document.cookie = "texture41= ";
			if(document.getElementById("newCheck42").checked) document.cookie = "texture42=checked"; else document.cookie = "texture42= ";
			if(document.getElementById("newCheck43").checked) document.cookie = "texture43=checked"; else document.cookie = "texture43= ";
			if(document.getElementById("newCheck44").checked) document.cookie = "texture44=checked"; else document.cookie = "texture44= ";
			if(document.getElementById("newCheck45").checked) document.cookie = "texture45=checked"; else document.cookie = "texture45= ";
			if(document.getElementById("newCheck46").checked) document.cookie = "texture46=checked"; else document.cookie = "texture46= ";
			if(document.getElementById("newCheck47").checked) document.cookie = "texture47=checked"; else document.cookie = "texture47= ";
			if(document.getElementById("newCheck48").checked) document.cookie = "texture48=checked"; else document.cookie = "texture48= ";
			if(document.getElementById("newCheck49").checked) document.cookie = "texture49=checked"; else document.cookie = "texture49= ";
			if(document.getElementById("newCheck50").checked) document.cookie = "texture50=checked"; else document.cookie = "texture50= ";
			if(document.getElementById("newCheck51").checked) document.cookie = "texture51=checked"; else document.cookie = "texture51= ";
			if(document.getElementById("newCheck52").checked) document.cookie = "texture52=checked"; else document.cookie = "texture52= ";
			if(document.getElementById("newCheck53").checked) document.cookie = "texture53=checked"; else document.cookie = "texture53= ";
			if(document.getElementById("newCheck54").checked) document.cookie = "texture54=checked"; else document.cookie = "texture54= ";
		}
		
		function changeSound(){
			if(getCookie("sound")=="off"){
				document.getElementById("soundButtonImage").src="/img/sound-icon1.png";
				document.cookie = "sound=on";
				soundsEnabled = true;
			}else if(getCookie("sound")=="on"){
				document.getElementById("soundButtonImage").src="/img/sound-icon2.png";
				document.cookie = "sound=off";
				soundsEnabled = false;
			}else{
				document.getElementById("soundButtonImage").src="/img/sound-icon2.png";
				document.cookie = "sound=off";
				soundsEnabled = false;
			}
		}
		
		function getCookie(cname){
			var name = cname + "=";
			var decodedCookie = decodeURIComponent(document.cookie);
			var ca = decodedCookie.split(';');
			for(var i = 0; i<ca.length; i++){
				var c = ca[i];
				while (c.charAt(0) == ' '){
					c = c.substring(1);
				}
				if (c.indexOf(name) == 0){
					return c.substring(name.length, c.length);
				}
			}
			return "";
		}
		
		function loadBar(){
			if(notMode3){
			<?php if($mode==1){ ?>
				<?php $barPercent = $user['User']['xp']/$user['User']['nextlvl']*100; ?>
				$("#xp-increase-fx").css("display","inline-block");
				$("#xp-bar-fill").css("box-shadow", "-5px 0px 10px #fff inset");
				<?php echo '$("#xp-bar-fill").css("width","'.$barPercent.'%");'; ?>
				$("#xp-increase-fx").fadeOut(0);$("#xp-bar-fill").css({"-webkit-transition":"all 0.5s ease","box-shadow":""});
			<?php }elseif($mode==2){ ?>
				<?php $barPercent = substr($user['User']['elo_rating_mode'], -2); ?>
				$("#xp-increase-fx").css("display","inline-block");
				$("#xp-bar-fill").css("box-shadow", "-5px 0px 10px #fff inset");
				<?php echo '$("#xp-bar-fill").css("width","'.$barPercent.'%");'; ?>
				$("#xp-increase-fx").fadeOut(0);$("#xp-bar-fill").css({"-webkit-transition":"all 0.5s ease","box-shadow":""});
			<?php }elseif($mode==3){ ?>
				<?php $barPercent = 100; ?>
				$("#xp-increase-fx").css("display","inline-block");
				$("#xp-bar-fill").css("box-shadow", "-5px 0px 10px #fff inset");
				<?php echo '$("#xp-bar-fill").css("width","'.$barPercent.'%");'; ?>
				$("#xp-increase-fx").fadeOut(0);$("#xp-bar-fill").css({"-webkit-transition":"all 0.5s ease","box-shadow":""});
			<?php }?>
			}else{
				
			}
		}
		
		function xpHover(){
			if(notMode3){
				<?php 
				if(isset($_SESSION['loggedInUser'])){
					if($_SESSION['loggedInUser']['User']['mode']==1) echo 'document.getElementById("account-bar-xp").innerHTML = userXP+"/"+userNextLvl;';
					elseif($_SESSION['loggedInUser']['User']['mode']==2) echo 'if(!usedModeSwitch) document.getElementById("account-bar-xp").innerHTML = userElo; 
					else document.getElementById("account-bar-xp").innerHTML = userXP+"/"+userNextLvl;';
				}else{
					echo 'document.getElementById("account-bar-xp").innerHTML = "Level"+userXP+"/"+userNextLvl;';
				}
				?>
			}
			document.getElementById("heroProfile").style.display = "inline-block";
			document.getElementById("heroLogout").style.display = "inline-block";
		}	
		function xpNoHover(){
			if(notMode3){
				<?php if($mode==1){ ?>
				document.getElementById("account-bar-xp").innerHTML = "Level"+<?php echo '"'.$level.' "' ?> + userLevel + <?php echo '"'.$td.'"' ?>;
				<?php }elseif($mode==2){ ?>
					if(!usedModeSwitch) document.getElementById("account-bar-xp").innerHTML = '<?php echo $levelNum; ?>' ;
					else document.getElementById("account-bar-xp").innerHTML = "Level"+<?php echo '"'.$level.' "' ?> + userLevel;
				<?php } ?>
			}
			document.getElementById("heroProfile").style.display = "none";
			document.getElementById("heroLogout").style.display = "none";
		}
		function sandboxHover(){
			if(document.getElementById("sandboxLink")) document.getElementById("sandboxLink").style.display = "inline-block";
			if(document.getElementById("collectionsInMenu")) document.getElementById("collectionsInMenu").style.color = "#74d14c";
			if(document.getElementById("collectionsInMenu")) document.getElementById("collectionsInMenu").style.backgroundColor = "grey";
		}
		function sandboxNoHover(){
			if(document.getElementById("sandboxLink")) document.getElementById("sandboxLink").style.display = "none";
			if(document.getElementById("collectionsInMenu")) document.getElementById("collectionsInMenu").style.backgroundColor = "rgba(0,0,0,0)";
			if(document.getElementById("collectionsInMenu")) document.getElementById("collectionsInMenu").style.color = "#d19fe4";
		}
		function leaderboardHover(){
			if(document.getElementById("leaderboardLink")) document.getElementById("leaderboardLink").style.display = "inline-block";
			if(document.getElementById("highscoreInMenu")) document.getElementById("highscoreInMenu").style.color = "#74d14c";
			if(document.getElementById("highscoreInMenu")) document.getElementById("highscoreInMenu").style.backgroundColor = "grey";
		}
		function leaderboardNoHover(){
			if(document.getElementById("leaderboardLink")) document.getElementById("leaderboardLink").style.display = "none";
			if(document.getElementById("highscoreInMenu")) document.getElementById("highscoreInMenu").style.backgroundColor = "rgba(0,0,0,0)";
			if(document.getElementById("highscoreInMenu")) document.getElementById("highscoreInMenu").style.color = "#d19fe4";
		}
		function donateHover2(){
			document.getElementById("donateH2").src = '/img/donateButton1h.png';
		}	
		function donateNoHover2(){
			document.getElementById("donateH2").src = "/img/donateButton1.png";
		}
	</script>
</body>
</html>
