
	<div class="homeRight">
	
		
		<p class="title4">Modes</p>
		
		<?php
			echo '<img id="title-image" src="/img/modeselect.png" width="100%" alt="Tsumego Hero Modes" title="Tsumego Hero Modes">';
		?>
		<br>
			<?php
			/*
			if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['premium']>=2){
			echo '<p class="title4">New Collection</p>
			<br><font color="blue">Hello '.$_SESSION['loggedInUser']['User']['name'].', please check and comment on the collection 
			<a href="/sets/view/142">Diabolical</a> in the Sandbox. Upload by original author David Mitchell (DaviidM). </font>
			<br><br>';
			}}
			
			*/
			//print_r($newT);
		?>
		<p class="title4">Problems of the Day</p>
		
		<div class="new1">
		<?php
			//echo '<pre>';print_r($scheduleTsumego);echo '</pre>';
		if(count($scheduleTsumego)!=0){	
			echo '<font color="#444">Added today:</font><br>';
			if(count($scheduleTsumego)<=1){
				echo '<a style="color:#000;" href="/sets/view/'.$newT['Tsumego']['set_id'].'"><b>
				'.$newT['Tsumego']['set'].' '.$newT['Tsumego']['set2'].'</b> - '.$newT['Tsumego']['num'].'</a><br>
					<li class="set'.$newT['Tsumego']['status'].'1" style="margin-top:4px;">
						<a href="/tsumegos/play/'.$newT['Tsumego']['id'].'">'.$newT['Tsumego']['num'].'</a>
					</li>';
			}else{
				echo '<a style="color:#000;" href="/sets/view/'.$newT['Tsumego']['set_id'].'"><b>
				'.$newT['Tsumego']['set'].' '.$newT['Tsumego']['set2'].'</b> - '.count($scheduleTsumego).' problems</a><br>';
				for($i=0; $i<count($scheduleTsumego); $i++){
					echo '<li class="set'.$scheduleTsumego[$i]['Tsumego']['status'].'1" style="margin-top:4px;">
						<a href="/tsumegos/play/'.$scheduleTsumego[$i]['Tsumego']['id'].'">'.$scheduleTsumego[$i]['Tsumego']['num'].'</a>
					</li>';
				}
			}
			echo '<br>';
		}
		/*
			$currentSet = 145;
			$newTs = array();
			$newTsMap = array();
			for($i=0; $i<count($ts); $i++){
				if($ts[$i]['Tsumego']['created'] == '2021-06-10 22:00:00'){
				if($ts[$i]['Tsumego']['set_id'] == $currentSet){
					array_push($newTs, $ts[$i]);
					array_push($newTsMap, $ts[$i]['Tsumego']['num']);
				}	
				}
			}
			asort($newTsMap);
			$newTsMap = array_values($newTsMap);
			
			echo '<a style="color:#000;" href="/sets/view/'.$setNames[$currentSet]['Set']['id'].'"><b>'.$setNames[$currentSet]['Set']['title'].
			' '.$setNames[$currentSet]['Set']['title2'].
			'</b></a> - '.count($newTs).' Problems<br>';
			
			for($i=count($newTs)-1; $i>=0; $i--){
				if(!isset($newTs[$i]['Tsumego']['status'])) $newTs[$i]['Tsumego']['status'] = 'N';
			}
			for($i=0; $i<count($newTsMap); $i++){
				for($j=0; $j<count($newTs); $j++){
					if($newTs[$j]['Tsumego']['num']==$newTsMap[$i]){
						echo '
							<li class="set'.$newTs[$j]['Tsumego']['status'].'1" style="margin-top:4px;">
								<a href="/tsumegos/play/'.$newTs[$j]['Tsumego']['id'].'?mode=1">'.$newTs[$j]['Tsumego']['num'].'</a>
							</li>
						';
					}
				}
			}
			*/
		?>		
			
		<?php if(count($scheduleTsumego)!=0) echo '<br>'; ?>
		<br><br>
		<font color="#444">Most popular today:</font><br>
		<a style="color:#000;" href="/sets/view/<?php echo $totd['Tsumego']['set_id']; ?>"><b><?php echo $totd['Tsumego']['set'].' '.$totd['Tsumego']['set2']; ?></b> - <?php echo $totd['Tsumego']['num']; ?></a><br>
			<li class="set<?php echo $totd['Tsumego']['status']; ?>1" style="margin-top:4px;">
				<a href="/tsumegos/play/<?php echo $totd['Tsumego']['id']; ?>"><?php echo $totd['Tsumego']['num']; ?></a>
			</li>
			<br><br>
		</div>
		<p class="title4">Update 05.06.2023</p>
		<div class="new1">
			<b>Design improvements</b><br><br>
			The new menu takes away less space at the top. It also has more navigation options in a drowpdown. Other improvements involve spacing and colors on all pages.<br><br>
			<img width="100%" src="/img/newMenu1.PNG"><br><br>
			The Sandbox is now accessible for all premium users and users that reach level 60.<br>
			<br>
		</div>
		<p class="title4">Winners of the Time Mode in May '23 </p>
		<div class="new1">
			<b>Winners: darkgeass, posetcay, Fupfv, iryumika, bliviu</b><br><br>
			The winners get a premium upgrade and the achievement Time Master. Achievements will be visible later this year.<br><br>
			<div align="center">
			<img src="/img/time-master.png" width="75%"><br>
			</div>
			
			<br>
		</div>
		<p class="title4">Update 22.05.2023</p>
		<div class="new1">
			<b>New: Collection accuracy and time scoring</b><br><br>
			• The collections store data about the time spent and about the solved/failed attempts for each problem. 
			This is shown by an accuracy (0% all fails, 100% all solves) and an average time (in seconds). 
			The data is available one year back.<br><br>
			• Progress in a collection can be reset. This can be used 4 times per month (on the entire website).<br><br>
			<img src="/img/bild1.PNG" width="500px"><br>
			Example: <a href="/sets/view/117">Easy Capture</a>
			<br><br>
			<p style="font-weight:800;text-align:left;">The first places in Slow/Fast/Blitz (Time Mode) by the end of May 2023 each get a reward.</p>
			<br>
		</div>
		<p class="title4">New Collection: 5x5 Endgame Problems</p>
		<div class="new1">
			Go problems in the world of 5x5. 
			<br><br>
			<div align="center">
				<img width="210px" src="/img/set_pjZR59_5x5 Endgame Problems.PNG" width="90%" alt="5x5 Endgame Problems" title="5x5 Endgame Problems">
				<br><br>
				<a class="new-button main-page" style="font-size:14px;" href="/sets/view/181">Play</a>
				<!-- <a class="new-button-inactive" style="font-size:14px;">Play</a>  -->
			</div>
			<br>
		</div>
		
		<p class="title4">Recent Donations and Upgrades</p>
		<div class="new1">
			<table class="newx">
		<tr><td width="50%"><h1>yonur</h1></td><td><h1>10,00 €</h1></td></tr>
		<tr><td><h1>Kirasan</h1></td><td><h1>10,00 €</h1></td></tr>
		<tr><td><h1>Salata</h1></td><td><h1>10,00 €</h1></td></tr>
		<tr><td><h1>Edward Feustel</h1></td><td><h1>10,00 €</h1></td></tr>
		<tr><td><h1>Scotty Reed</h1></td><td><h1>2,17 € <i>subscription</i></h1></td></tr>
		
		</table>	
		<br>
		</div>	
		<p class="title4">Tsumego Hero Videos</p>
		<div class="new1">	
			<br>
			<div align="center">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/OMIfyzXS9Vo" frameborder="0" allow="accelerometer; 
			autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<br>
			<b>Video by Daniel ML</b><br>
			Twitch: <a href="https://www.twitch.tv/danielml001" target="_blank">https://www.twitch.tv/danielml001</a><br>
			Youtube: <a href="https://www.youtube.com/channel/UCc4gkScb1PJAiDDtZ00eAjA" target="_blank">Daniel ML</a><br>
			<br>
			<b>All Episodes</b><br>
			E1: <a href="https://www.youtube.com/watch?v=t4dR3JrP_x8" target="_blank">Tsumego Hero 1 : Hard Mode</a><br>
			E2: <a href="https://www.youtube.com/watch?v=rZBmLnzSWWI" target="_blank">Tsumego Hero 2 : Extra Life</a><br>
			E3: <a href="https://www.youtube.com/watch?v=OMIfyzXS9Vo" target="_blank">Tsumego Hero 3 : Hero Rising</a><br>
			<br>
		</div>
			<?php
			if(isset($_SESSION['loggedInUser'])){
			
			
			
			//if($_SESSION['loggedInUser']['User']['completed']==1){
			if(false){
			//if($_SESSION['loggedInUser']['User']['id']==72){
			//echo '<pre>';print_r($ux);echo '</pre>';
			?>
			<div id="sandboxVolunteers2">
				<p class="title4">Sandbox</p>
				<br>
				<div align="center"><font size="4px">
				There are new problems in the sandbox.</font>
				<table border="0" width="300px">
				<tr>
				<td width="33%" style="text-align:center;font-size:17px;font-weight:800;">
				</td>
				<td width="33%" style="text-align:center;font-size:17px;font-weight:800;">
					<a href="/sets/beta" style="color:black;"><font size="4px">Enter</font><br></a>
				</td>
				<td width="33%" style="text-align:center;font-size:17px;font-weight:800;">
				</td>
				</tr>
				</table>
				</div>
			</div>
			<?php 
			}
			
			if(false){
			?>
			<div id="sandboxVolunteers">
				<p class="title4">Sandbox Volunteers</p>
				<br>
				The Sandbox is an effort to increase the quality of the problems on Tsumego Hero. 
				All problems are there for trial, before they get published. A small group 
				of users has access. Their task is to solve them and comment if they find a mistake. 
				<br><br>
				<div align="center">
				Would you like to have early access to not published problems? 
				<table border="0" width="300px">
				<tr>
				<td width="33%" style="text-align:center;font-size:17px;font-weight:800;">
					<a href="#" id="sandboxY" onclick="sandboxY(); return false;" style="color:black;">Yes</a>
				</td>
				<td width="33%" style="text-align:center;font-size:17px;font-weight:800;">
					<a href="#" id="sandboxN" onclick="sandboxN(); return false;" style="color:black;">No</a>
				</td>
				<td width="33%" style="text-align:center;font-size:17px;font-weight:800;">
					<a href="#" id="sandboxM" onclick="sandboxM(); return false;" style="color:black;">Maybe</a>
				</td>
				</tr>
				</table>
				</div>
				<br>
			</div>
			<?php 
			}
			
			if(false){
			?>
			<div id="sandboxVolunteers2">
				<p class="title4">Sandbox Volunteers</p>
				<br>
				<div align="center"><font size="4px">
				You have been invited.</font>
				<table border="0" width="300px">
				<tr>
				<td width="33%" style="text-align:center;font-size:17px;font-weight:800;">
				</td>
				<td width="33%" style="text-align:center;font-size:17px;font-weight:800;">
					<a href="/sets/beta" style="color:black;"><font size="4px">Enter</font><br></a>
				</td>
				<td width="33%" style="text-align:center;font-size:17px;font-weight:800;">
				</td>
				</tr>
				</table>
				</div>
				
			</div>
				
			<?php 
			}
			?>
			
			<?php
			/*if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['completed']==1){
			?>
			
			<div >
				<p class="title4">Sandbox</p>
				<br>
				<div align="left"><font size="4px">
				There are new problems in the <a href="/sets/beta">Sandbox</a>, please check.
				<br><br>
				</font>
				
				</div>
			</div>
			
			<?php
			}
			}*/
			
			if(isset($_SESSION['loggedInUser'])){
			?>
			<?php } ?>
			<p class="title4">Your last Activities</p>
			<div class="new1">
			<?php 
				echo '<a style="color:#000;" href="/sets/view/'.$visit1['Set']['id'].'">
					<b>'.$visit1['Set']['title'];
					if($visit1['Set']['title2']!=null) echo ', '.$visit1['Set']['title2'];
				echo '</b></a><br>'; 
				if(isset($visit2)){
					echo '<a style="color:#000;" href="/sets/view/'.$visit2['Set']['id'].'">
						<b>'.$visit2['Set']['title'];
						if($visit2['Set']['title2']!=null) echo ', '.$visit2['Set']['title2'];
					echo '</b></a><br>'; 
					if(isset($visit3)){
						echo '<a style="color:#000;" href="/sets/view/'.$visit3['Set']['id'].'">
							<b>'.$visit3['Set']['title'];
							if($visit3['Set']['title2']!=null) echo ', '.$visit3['Set']['title2'];
						echo '</b></a><br>'; 
					}
				}
			?>
			<br>
			</div>
			<?php		
		}	
			
		?>
		
	</div>
	
	<div class="homeLeft">
		<p class="title4">Message of the Day | <?php echo $d1; ?></p>
		<?php
			
			if(!isset($_SESSION['lastVisit'])) $_SESSION['lastVisit'] = 15352;
			$modeActions = '';
			$modeActions2 = 'class="modeboxes"';
			if(isset($_SESSION['loggedInUser']) && $ac) $modeActions = 'class="modeboxes" onmouseover="mode2hover()" onmouseout="modeNoHover()" onclick="goMode2()"';
			if($ac) $modeActions2 = 'class="modeboxes"';
			else $modeActions2 = 'class="modeboxes"';
		
			if(isset($_SESSION['loggedInUser'])){
				$url1 = '';
				$url2 = '';
				$url3 = '';
				$url4 = '';
				
				if($_SESSION['loggedInUser']['User']['id']==72){
					$url1 = '<a href="/users/stats">Page Stats</a><br>';
					$url2 = '<a href="/users/userstats">User Stats</a><br>';
					$url3 = '<a href="/users/adminstats">Admin Stats</a><br>';
					$url4 = '<a href="/tsumego_records/">Tsumego Records</a><br>
							<a href="/users/purge">Purge</a><br>';
					
				}elseif($_SESSION['loggedInUser']['User']['id']==408){
					$url2 = '<a href="/users/userstats">User Stats</a><br>';
					$url3 = '<a href="/users/adminstats">Admin Stats</a><br>';
					$url4 = '<a href="/tsumego_records/">Tsumego Records</a><br>';
				}elseif($_SESSION['loggedInUser']['User']['isAdmin']>0){
					$url3 = '<a href="/users/adminstats">Admin Stats</a><br>';
					$url2 = '<a href="/users/userstats">User Stats</a><br>';
				}
				
				echo '<div style="position:absolute;top:60px;left:28px;">';
				echo $url1;
				echo $url2;
				echo $url3;
				echo $url4;
				echo '</div>';
			}
			
			echo '<div class="time-mode-play">';
			if(isset($_SESSION['loggedInUser'])){
				echo '<a id="time-mode-play-button" class="new-button main-page" style="font-size:14px;" href="/ranks/overview">Play</a>';
				echo '<div class="time-mode-play-box" onmouseover="mode3hover()" onmouseout="mode3NoHover()" onclick="goMode3()"></div>';
			}else{
				echo '<a class="new-button-inactive main-page" style="font-size:14px;position:relative;left:-7px">Sign In</a>';
			}
			echo '</div>';
		?>
		
		<div class="modeBox1" onmouseover="mode1hover()" onmouseout="modeNoHover()" onclick="goMode1()">
			<div class="modeboxes">
				<a class="new-button main-page" style="font-size:14px;" href="<?php echo '/tsumegos/play/'.$_SESSION['lastVisit'].'?mode=1'; ?>">Play</a>
			</div>
		</div>
		<div class="modeBox2" style="<?php if($ac) echo 'cursor:pointer;';?>" <?php echo $modeActions ?>>
			<div <?php echo $modeActions2 ?>>
				<?php 
				if(isset($_SESSION['loggedInUser']) && $ac){
					if($nextMode['Tsumego']['id']==null) $nextMode['Tsumego']['id'] = 15352;
					echo '<a class="new-button main-page" style="font-size:14px;" href="/tsumegos/play/'.$nextMode['Tsumego']['id'].'?mode=2'.'">play</a>'; 
				}else echo '<a id="modeboxes2" class="new-button-inactive main-page" style="font-size:14px;">sign in</a>'; 
				?>
			</div>
		</div>
		<?php
			//$quote = '7000';
			if(isset($_SESSION['loggedInUser'])){
				echo '<img id="modeboxes3" src="/img/time-mode-hero2.png?v=1.456" width="100%" alt="Tsumego Hero Message of the Day" title="Tsumego Hero Message of the Day">';
			}else{
				echo '<img src="/img/time-mode-hero2.png?v=1.456" width="100%" alt="Tsumego Hero Message of the Day" title="Tsumego Hero Message of the Day">';
			}
		
		/*
		<div class="danielml-bg">
		<br>
		<i>"Baduk Borough. This used to be a quiet city. A city that could be that could be any town USA. That is, until an evil cat samurai
		threatened the lifes and the livelihoods of the people in this town... Looks like this city needs a hero. A Tsumego Hero!"</i>
		<br><br>
		<div align="center">
		<iframe width="560" height="315" src="https://www.youtube.com/embed/OMIfyzXS9Vo" frameborder="0" allow="accelerometer; 
		autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		<br>
		<b>Video by Daniel ML</b><br>
		Twitch: <a href="https://www.twitch.tv/danielml001" target="_blank">https://www.twitch.tv/danielml001</a><br>
		Youtube: <a href="https://www.youtube.com/channel/UCc4gkScb1PJAiDDtZ00eAjA" target="_blank">Daniel ML</a><br>
		<br>
		<b>All Episodes</b><br>
		E1: <a href="https://www.youtube.com/watch?v=t4dR3JrP_x8" target="_blank">Tsumego Hero 1 : Hard Mode</a><br>
		E2: <a href="https://www.youtube.com/watch?v=rZBmLnzSWWI" target="_blank">Tsumego Hero 2 : Extra Life</a><br>
		E3: <a href="https://www.youtube.com/watch?v=OMIfyzXS9Vo" target="_blank">Tsumego Hero 3 : Hero Rising</a><br>
		<br>
		<b>About</b><br>
		Daniel ML is a Go streamer and I'm a fan of his content since he started streaming on twitch about 3 years ago.
		He is very enjoyable to watch, a great entertainer and always in a good mood.
		<br>
		*/
		
			//if(isset($_SESSION['loggedInUser'])){
				/*
				$url1 = '';
				$url2 = '';
				$url3 = '';
				$url4 = '';
				
				if($_SESSION['loggedInUser']['User']['id']==72){
					$url1 = '<a href="/users/stats">Page Stats</a><br>';
					$url2 = '<a href="/users/userstats">User Stats</a><br>';
					$url3 = '<a href="/users/adminstats">Admin Stats</a><br>';
					$url4 = '<a href="/tsumego_records/">Tsumego Records</a><br>';
				}elseif($_SESSION['loggedInUser']['User']['id']==1543){
					$url2 = '<a href="/users/userstats">User Stats</a><br>';
					$url3 = '<a href="/users/adminstats">Admin Stats</a><br>';
					$url4 = '<a href="/tsumego_records/">Tsumego Records</a><br>';
				}elseif($_SESSION['loggedInUser']['User']['isAdmin']>0){
					$url3 = '<a href="/users/adminstats">Admin Stats</a><br>';
				}
				
				echo '<div style="position:absolute;top:60px;left:28px;">';
				echo $url1;
				echo $url2;
				echo $url3;
				echo $url4;
				echo '</div>';
				
				The rating mode gives you a rank for your ability to solve tsumego. 
				The system is based on <a target="_blank" href="https://en.wikipedia.org/wiki/Elo_rating_system">elo rating</a>, which is used for tournaments in 
				chess, go and other games. As in tournaments players get opponents 
				around their rank, the rating mode matches you with go problems 
				around your skill level.<br><br>
				echo '<div style="position:absolute;width:662px;top:60px;left:28px;font-weight:800;color:white;padding:2px 15px;">
				<div style="text-decoration:underline;font-size:22px;" align="center">Rating Mode – 2<sup>nd</sup> Iteration</div><br>
				
				The rating mode gives you a rank for your ability to solve tsumego. 
				The system is based on <a style="color:white;" target="_blank" href="https://en.wikipedia.org/wiki/Elo_rating_system">elo rating</a>, which is used for tournaments in 
				chess, go and other games. As in tournaments players get opponents 
				around their rank, the rating mode matches you with tsumego problems 
				around your skill level.<br><br>
				<div id="cd2" style="font-size:25px;float:left;padding-left:190px;">
				<p style="float:left">Available in:&nbsp;</p>
				<p style="float:left" id="hours"></p>
				<p style="float:left" id="mins"></p>
				<p style="float:left" id="secs"></p>
				</div>
				<br><br><br><br><br>
				
				Availability:<br>
				○ This will be available for all premium users.<br>
				○ The 2<sup>nd</sup> iteration is going to end on 01.10.2020 (If later, this date will be updated)<br>
				○ There will be iterations and prizes each month.<br><br>

				Prizes:<br>
				○ The first 5 places of the 1<sup>st</sup> iteration won the exclusive secret area “Hand of God”. The winners are: PepinoNegro, StephaneLamy, Farkas, yaya and Fupfv.<br>
				○ The first place by the end of the 2<sup>nd</sup> iteration wins 20,00 €.<br><br><br>
				
				<a style="color:white;" href="/activates">Configuration details >></a>

				</div>';
				*/
				
			//}
		?>
		
		
		
		<p class="title4">User of the Day </p>
		<div class="new1">
		<div class="uotd mid uotd<?php echo $uotdbg; ?> mid<?php echo $uotdbg; ?> ">
		  <h2 <?php if(strlen($userOfTheDay)>=10) echo 'class="midLongName1"'; ?>><?php echo $userOfTheDay; ?></h2>
		</div>
		<p class="uotdmargin">&nbsp;</p>
		</div>
		
	
		
		<?php 
			if(isset($loggedInUser)){
				echo '
					<p class="title4">Restoration Countdown</p>
					<div class="new1">
					
					<font size="5px">
						<div id="homeCountdown"></div>
					
					</font>
				</div>';
				
				$asdf = '';
			}else{
				$asdf = '';
			}
		?>
		
		<p class="title4">Info Pages</p>
		<div class="new1">
			There are new info pages about the functions on the website and in the three different modes. 
			<a href="/sites/websitefunctions">Website Functions</a><br><br>
			Another info pages shows guidelines about go rules and what they mean on Tsumego Hero in regards of solving or failing a problem.
			<a href="/sites/gotutorial">Go Tutorial</a><br><br>
		
		</div>
		
		<?php if(isset($_SESSION['loggedInUser'])){ ?>
		<?php if($_SESSION['loggedInUser']['User']['premium']==0 && $user['User']['id']!=1165){ ?>
			<p class="title4">Donations</p>
			<div class="new1">
			<div align="center"><a href="/users/donate"><img id="donateH" onmouseover="donateHover()" onmouseout="donateNoHover()" width="180px" src="/img/donateButton1.png"></a><br>
			Get access to <a href="/users/donate">Tsumego Hero Premium</a>.<br><br>
			</div>
			</div>
		<?php }else{ ?>
			
		<?php } ?>
		<?php }else{ ?>
			<p class="title4">Donations</p>
			<div class="new1">
			<div align="center"><a href="/users/donate"><img id="donateH" onmouseover="donateHover()" onmouseout="donateNoHover()" width="180px" src="/img/donateButton1.png"></a><br>
			Get access to <a href="/users/donate">Tsumego Hero Premium</a>.<br><br>
			</div>
			</div>
		<?php } ?>
		<p class="title4">Problem Database Size </p>
		<div class="new1">
		<?php
		$tsumegoDates = array();
		for($j=0; $j<count($tsumegos); $j++){
			$date = date_create($tsumegos[$j]);
			array_push($tsumegoDates, date_format($date,"Y-m-d"));
		}
		$tsumegoDates = array_count_values($tsumegoDates);
		$tsumegoDates['2018-02-07'] = 161;
		$tsumegoDates['2018-03-11'] = 151;
		$tsumegoDates['2018-04-10'] = 205;
		$tsumegoDates['2018-04-25'] = 204;
		$tsumegoDates['2018-05-04'] = 89;
		$dt = new DateTime();
		$dt = $dt->format('Y-m-d');
		if(!isset($tsumegoDates[$dt])){
			$tsumegoDates[$dt] = 0.1;
		}
		ksort($tsumegoDates);
		
		$td = array();
		reset($tsumegoDates);
		$nextDay = '';
		$c = 0;
		while(current($tsumegoDates)){
			if(key($tsumegoDates)!=$nextDay&&$nextDay!=''){
				while(key($tsumegoDates)!=$nextDay){
					$td[$c]['date'] = $nextDay;
					$td[$c]['num'] = 0;
					$c++;
					$nextDay = date_create($nextDay);
					$nextDay->modify('+1 day');
					$nextDay = date_format($nextDay,"Y-m-d");
				}
				
			}
			$nextDay = key($tsumegoDates);
			$nextDay = date_create($nextDay);
			$nextDay->modify('+1 day');
			$nextDay = date_format($nextDay,"Y-m-d");
		
			$td[$c]['date'] = key($tsumegoDates);
			$td[$c]['num'] = current($tsumegoDates);
			$c++;
			next($tsumegoDates);
		}
		
		$sum = 0;
		for($j=0; $j<count($td); $j++){
		
		
			$td[$j]['num'] = $td[$j]['num'] + $sum;
			$date = date_create($td[$j]['date']);
			
			if($date==date_create('2019-03-27')) $td[$j]['num'] -= 1277;
			if($date==date_create('2019-04-25')) $td[$j]['num'] -= 238;
			if($date==date_create('2019-05-01')) $td[$j]['num'] -= 32;
			if($date==date_create('2019-05-19')) $td[$j]['num'] -= 40;
			if($date==date_create('2020-02-22')) $td[$j]['num'] -= 364;
			$x = $td[$j]['num'];
			$sum = $x;
			
			
			//echo '<pre>';print_r($date);echo '</pre>';
			$td[$j]['y'] = $date->format('Y');
			$td[$j]['m'] = $date->format('m');
			$td[$j]['m'] = $td[$j]['m'] - 1;
			$td[$j]['d'] = $date->format('d');
			$td[$j]['d'] = $td[$j]['d'] * 1;
		}
		?>
		<script>
		window.onload = function () {

		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			animationDuration: 1000,
			theme: "dark1",
			title:{
				text: "",
				fontSize: 20,
				 fontWeight: "lighter"
			},
		   axisX:{
				valueFormatString: "DD MMM YY",
				labelFontSize: 11
			},
			axisY:{
				includeZero: true,
				labelFontSize: 14
			},
			data: [{        
				type: "area", 
				color: "#d19fe4",
				fillOpacity: .7,
				lineThickness: 3,
				dataPoints: [
					<?php
						for($j=0; $j<count($td); $j++){
							$td[$j]['num'] = round($td[$j]['num']);
							echo '{ x: new Date('.$td[$j]['y'].', '.$td[$j]['m'].', '.$td[$j]['d'].'), y: '.$td[$j]['num'].' }';
							if($j!=count($td)-1) echo ',';
						}
					?>
				]
			}]
		});
		chart.render();

		}
		</script>
		<div id="chartContainer" style="height: 400px; width: 100%;"></div>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
		<br>
		</div>
		<p class="title4">Contributors</p>
		<div class="new1">
		Tsumego Hero is only in constant good shape, because there were users who helped creating the files for the problems.
		If you want to do some tsumego training and at the same time help the website by creating files, please message me. Help is much appreciated.<br><br>
		All contributors are listed here: <a href="/users/authors">Authors</a>
		<br>
		</div>
		
		<p class="title4">Admins</p>
		<div class="new1">
		We are looking for more admins who can confidently answer comments in the discuss area.
		Ideally, there is a small group of active or semi-active admins that is interested in discussion, uploading problems or creating new collections.
		Let me know if you would like to be on the productive side of Tsumego Hero. (<a href="mailto:me@joschkazimdars.com">me@joschkazimdars.com</a>)
		
		<br>
		</div>
		
		<p class="title4">Guide To Become Strong </p>
		<div class="new1">
		<p class="titleBy">&nbsp;by Benjamin Teuber 6 Dan</p>
		
		<table border="0" class="newstable1">
		<tr>
			<td colspan="2">
			Many times I hear questions and requests like "How can I become strong?" or "My Go lacks this or that. 
			Please teach me how to be better at it!". In general, I think many people overestimate the role of 
			a Go-Teacher. Of course, it's very important to play and analyze with stronger players too, but still 
			the teacher is not everything. Most of the learning consists of exploring Go for yourself, and not by 
			having every single move explained.
			Actually, most part of my study in Japan did not consist of being taught by pros, but of studying by myself. 
			One big point of being next to professionals was that they explained how to do this.
			<br><br>
			For you, these lines mean that you don't have to go to Japan or find a 6-Dan teacher to become incredibly strong!!!
			 Instead, if you are ambitious, you just have to know what to do by yourself. This is why I decided to write this small tutorial.
			</td>
		</tr>
		</table><br>
		<h4>How to become strong (in order of importance)</h4>
		<table >
		<tr><td style="vertical-align:top;">1.</td><td>Play, play, play - the stronger your opponent the better for you</td></tr>
		<tr><td style="vertical-align:top;">2.</td><td> Do Tsumego in the right way continuously. Maybe this seems to be boring for you at first, but you'll see how much fun it is 
		once you start. It's very important how to do so!</td></tr>
		<tr><td style="vertical-align:top;">3.</td><td>Analyze your games with other players (as above, the stronger the better) - best would be to found a private study group 
		(ten eyes will find more than two or four...) </td></tr>
		<tr><td style="vertical-align:top;">4.</td><td>Do Tsumego</td></tr>
		<tr><td style="vertical-align:top;">5.</td><td>If you like, repeat and learn some pro games</td></tr>
		<tr><td style="vertical-align:top;">6.</td><td>More Tsumego</td></tr>
		<tr><td style="vertical-align:top;">7.</td><td>If you have some interesting book about fuseki, joseki, shape, endgame or whatever, read it if you enjoy - but don't spend too much time with it</td></tr>
		<tr><td style="vertical-align:top;">8.</td><td>If you still have time left, how about a few tsumego-problems?</td></tr>
		
		</table>
		<br>
		<font size="4px"><b>
		<a href="/sites/view/0">Read more >></a><br><br>
		</b></font>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		
		<!--
		<p class="title4 ">Contributors</p>
		<br>
		<font size="5px">
		Timo (Timo Kreuzer)<br>
		Silent gentleman (саша черных)<br>
		Bradford (Bradford Malbon)<br>
		GoDave89 (David Ulbricht)<br> 
		okimoyo (Ryan Smith)<br>
		gobum<br>
		Andrey<br>
		<br>
		
		</font>
		
		<p class="title4 ">Donations in September</p>
		<br>
		<font size="5px">
		<table class="donatorsTable">
		<tr>
		<td>Contraband</td><td>21,00 €</td>
		</tr>
		<tr>
		<td>DuskEagle</td><td>20,00 €</td>
		</tr>
		<tr>
		<td>og1L</td><td>20,00 €</td>
		</tr>
		<tr>
		<td>Danglard</td><td>20,00 €</td>
		</tr>
		<tr>
		<td>Tsultruim</td><td>20,00 €</td>
		</tr>
		<tr>
		<td>GoGentleman</td><td>20,00 €</td>
		</tr>
		<tr>
		<td>averell</td><td>20,00 €</td>
		</tr>
		<tr>
		<td>Sosnovsky (Juan Manuel)</td><td>10,00 €</td>
		</tr>
		<tr>
		<td>waste</td><td>10,00 €</td>
		</tr>
		<tr>
		<td>Paytonbigsby</td><td>10,00 €</td>
		</tr>
		</table>
		-->
		</font>
		
		<?php if(!isset($loggedInUser)) echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>'; ?>
	</div>
	
	<script>
		function check1(){
			if(document.getElementById("dropdown-1").checked == true){
				document.getElementById("dropdowntable").style.display = "inline-block"; 
				document.getElementById("dropdowntable2").style.display = "inline-block"; 
				document.getElementById("boardsInMenu").style.color = "#74D14C"; 
				document.getElementById("boardsInMenu").style.backgroundColor = "grey"; 
			}
			if(document.getElementById("dropdown-1").checked == false){
				document.getElementById("dropdowntable").style.display = "none"; 
				document.getElementById("dropdowntable2").style.display = "none";
				document.getElementById("boardsInMenu").style.color = "#d19fe4"; 
				document.getElementById("boardsInMenu").style.backgroundColor = "transparent";
			}
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
		}
		function donateHover(){
			document.getElementById("donateH").src = '/img/donateButton1h.png';
		}	
		function donateNoHover(){
			document.getElementById("donateH").src = "/img/donateButton1.png";
		}
		
		function sandboxY(){
			document.cookie = "sandbox=3";
			document.getElementById("sandboxVolunteers").style = "display:none;";
		}
		function sandboxN(){
			document.cookie = "sandbox=1";
			document.getElementById("sandboxVolunteers").style = "display:none;";
		}
		function sandboxM(){
			document.cookie = "sandbox=2";
			document.getElementById("sandboxVolunteers").style = "display:none;";
		}
		function mode1hover(){
			 $("#title-image").attr("src", "/img/modeselect-1.png");
		}
		function mode2hover(){
			 $("#title-image").attr("src", "/img/modeselect-2.png");
		}
		function modeNoHover(){
			 $("#title-image").attr("src", "/img/modeselect.png");
		}
		function mode3hover(){
			 $("#modeboxes3").attr("src", "/img/time-mode-hero2-hover.png");
		}
		function mode3NoHover(){
			 $("#modeboxes3").attr("src", "/img/time-mode-hero2.png?v=1.456");
		}
		function goMode1(){
			<?php echo 'window.location.href = "/tsumegos/play/'.$_SESSION['lastVisit'].'?mode=1";'; ?>
		}
		function goMode2(){
			<?php echo 'window.location.href = "/tsumegos/play/'.$nextMode['Tsumego']['id'].'?mode=2";'; ?>
		}
		function goMode3(){
			<?php echo 'window.location.href = "/ranks/overview";'; ?>
		}
	</script>
	
	
	
	
		