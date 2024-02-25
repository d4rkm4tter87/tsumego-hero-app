	<script src ="/js/previewBoard.js"></script>
	<div class="homeRight">
		<p class="title4 title4right"><?php echo $d1; ?></p>
		<?php
			if(isset($_SESSION['loggedInUser']['User']['id']))
				echo '<img id="title-image" src="/img/modeSelect24.png" width="100%" alt="Tsumego Hero Modes" title="Tsumego Hero Modes">';
			else
				echo '<img id="title-image" src="/img/modeSelect24x.png" width="100%" alt="Tsumego Hero Modes" title="Tsumego Hero Modes">';
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
		if(count($scheduleTsumego)!=0){
			echo '<font color="#444">Added today:</font><br>';
			if(count($scheduleTsumego)<=1){
				echo '<a class="scheduleTsumego" href="/sets/view/'.$newT['Tsumego']['set_id'].'"><b>
				'.$newT['Tsumego']['set'].' '.$newT['Tsumego']['set2'].' - '.$newT['Tsumego']['num'].'</b></a><br>
					<li class="set'.$newT['Tsumego']['status'].'1" style="margin-top:4px;">
						<a href="/tsumegos/play/'.$newT['Tsumego']['id'].'">'.$newT['Tsumego']['num'].'</a>
					</li>';
			}else{
				echo '<a class="scheduleTsumego" href="/sets/view/'.$newT['Tsumego']['set_id'].'"><b>
				'.$newT['Tsumego']['set'].' '.$newT['Tsumego']['set2'].' - '.count($scheduleTsumego).' problems</b></a><br>';
				for($i=0; $i<count($scheduleTsumego); $i++){
					echo '<li class="set'.$scheduleTsumego[$i]['Tsumego']['status'].'1" style="margin-top:4px;">
						<a id="tooltip-hover'.$i.'" class="tooltip" href="/tsumegos/play/'.$scheduleTsumego[$i]['Tsumego']['id'].'">'
						.$scheduleTsumego[$i]['Tsumego']['num'].'<span><div id="tooltipSvg'.$i.'"></div></span></a>
					</li>';
				}
			}
			if(count($scheduleTsumego)<=10) echo '';
			else echo '<br>';
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
			
		<?php if(count($scheduleTsumego)!=0) echo '<br><br><br>';
		else echo ''; 
		?>
		<font color="#444">Most popular today:</font><br>
		<a id="mostPopularToday" href="/sets/view/<?php echo $totd['Tsumego']['set_id']; ?>"><b><?php echo $totd['Tsumego']['set'].' '.$totd['Tsumego']['set2']; ?></b> - <?php echo $totd['Tsumego']['num']; ?></a><br>
			<li class="set<?php echo $totd['Tsumego']['status']; ?>1" style="margin-top:4px;">
				<a id="tooltip-hover99" class="tooltip" href="/tsumegos/play/<?php echo $totd['Tsumego']['id']; ?>">
				<?php echo $totd['Tsumego']['num']; ?><span><div id="tooltipSvg99"></div></span></a>
			</li>
			<br><br>
		</div>
		
		<p class="title4">Update 25.02.2024</p>
		<div class="new1">
		<b>Overall rating</b><br><br>
		<div id="progressBarInLevelMode">
		Progress bar in level mode:<br>
		<?php
			$levelBarDisplayChecked1 = '';
			$levelBarDisplayChecked2 = '';
			if($levelBar==1)
				$levelBarDisplayChecked1 = 'checked="checked"';
			else
				$levelBarDisplayChecked2 = 'checked="checked"';
		?>
		<input type="radio" id="levelBarDisplay1" name="levelBarDisplay" value="1" onclick="levelBarChange(1);" <?php echo $levelBarDisplayChecked1; ?>> <b id="levelBarDisplay1text">Show level</b><br>
		<input type="radio" id="levelBarDisplay2" name="levelBarDisplay" value="2" onclick="levelBarChange(2);" <?php echo $levelBarDisplayChecked2; ?>> <b id="levelBarDisplay2text">Show rating (new)</b><br>
		<br>
		</div>
		With this update, Tsumego attempts in any mode affect the user rating.<br>
		<?php
		$link1 = '';
		$link2 = '';
		$link3 = '';
		if(isset($_SESSION['loggedInUser']['User']['id'])){
			$link1 = '/tsumegos/play/'.$_SESSION['lastVisit'].'?mode=1';
			$link2 = '/tsumegos/play/'.$nextMode['Tsumego']['id'].'?mode=2';
			$link3 = '/ranks/overview';
		}
		?>
		• <a href="<?php echo $link1; ?>" style="color:#74d14c">Level mode</a> problems affect level and user rating.<br>
		• <a href="<?php echo $link2; ?>" style="color:#c240f7">Rating mode</a> is the same as before, but all formulas for user and tsumego rating calculation have been improved.<br>
		• <a href="<?php echo $link3; ?>" style="color:#ca6658">Time mode</a> also affects the user rating.<br><br>
		
		<b>Rewards:</b> Every Sunday, the 3 highest rated users that have no premium account get a premium upgrade. Next prize giving: 03.03.24. To give everyone a fresh start, all user ratings have been reset.<br><br>
		
		<b>Profile page</b><br><br>
		<?php
		if(isset($_SESSION['loggedInUser']['User']['id']))
			echo 'The <a href="/users/view/'.$_SESSION['loggedInUser']['User']['id'].'">profile page</a> contains more data and is organized in line and bar charts.';
		else
			echo 'The profile page contains more data and is organized in line and bar charts.';
		?>
		<br>
		<br>
		<div align="center">
		<img src="/img/profile-display-example.PNG" title="profile-display-example" alt="profile-display-example" width="65%">
		<br>
		</div>
		</div>
		<p class="title4">Update 01.02.2024</p>
		<div class="new1">
		<b>Explanation for the duplicate update on 01.02.2024</b><br><br>
		
		We decided to merge the duplicate problems on the website. This means, that when you solve a problem and it has duplicates,
		it is also solved in other collections. When you had a collection complete and there were unsolved problems again on 
		1. February, it means that duplicates were merged and you need to solve it again for all occurences of that board position.<br><br>
		<div align="center">
		<img src="/img/duplicate-explanation.JPG" title="duplicate-explanation" alt="duplicate-explanation" width="70%">
		<br>
		</div>
		</div>
		<p class="title4">Update 11.01.2024</p>
		<div class="new1">
		<b>Similar problem search</b><br><br>
		
		This update contains a search function that can be used on the problem pages. It searches for problems that are similar to
		the currently visited problem. A parameter can be set for the maximum difference in stones that are placed on the board.</a><br><br>
		<div align="center">
		<img src="/img/similar-problems-example1.PNG" title="similar-problems-example1" alt="similar-problems-example1" width="50%">
		<img src="/img/similar-problems-example2.PNG" title="similar-problems-example2" alt="similar-problems-example2" width="70%">
		
		<br>
		</div>
		</div>
		<p class="title4">Update 28.12.2023</p>
		<div class="new1">
		<b>Board previews and more achievements</b><br><br>
		
		It is now possible to see previews of the problems. A preview is shown when you move your mouse over a problem.
		There are also 23 new <a href="/achievements">achievements.</a><br><br>
		<div align="center">
		<img src="/img/boardPreviewExample.PNG" title="Board preview example" alt="Board preview example">
		
		<br>
		</div>
		</div>
		<p class="title4">Update 23.11.2023</p>
		<div class="new1">
		<br>
		<div align="center">
		<a class="menuIcons2" id="darkButton2" onclick="darkAndLight();"><img id="darkButtonImage2" src="/img/light-icon1.png" width="30px"></a>
		<h1 class="darkButton2">Dark Theme</h1>
		<a class="menuIcons2" id="darkButton3" onclick="darkAndLight();"><img id="darkButtonImage3" src="/img/light-icon1.png" width="30px"></a>
		</div>
		<br>
		<br>
		<br>
		</div>
		<p class="title4">Update 06.11.2023</p>
		<div class="new1">
			<b>More achievements</b><br><br>
			
			The achievements have been stocked up to 91 and there is now an achievement highscore.<br><br>
			<table width="90%"><tr>
			<td><a href="/achievements">View Achievements</a></td>
			<td><a href="/users/achievements">Achievement Highscore</a></td>
			</tr></table>
			<br>
		</div>
		<p class="title4">Update 27.10.2023</p>
		<div class="new1">
			<b>Achievements!</b><br><br>
			
			With today's update, you can hunt for achievements. Achievements give additional XP. There will be a user ranking
			and possibly other rewards. This update contains the first 46 achievements of many more.
			<br><br>
			<a href="/achievements">View Achievements</a>
			<br><br>
			<div align="center"><img width="90%" src="/img/achievementExample.png"></div>
			<br>
			
		</div>
		<p class="title4">Update 14.10.2023</p>
		<div class="new1">
			<b>Improved comments</b><br><br>
			• <b>Link position in comments</b>: It is now possible to link board positions by clicking "Link current position".
			<br>
			<div align="center"><img width="90%" src="/img/commentPositionExample1.JPG"></div>
			<br>
			The position can be accessed by selecting the icon in the comment.
			<br>
			<div align="center"><img width="50%" src="/img/commentPositionExample2.png"></div>
			<br>
			• <b>Dynamic coordinates</b>: The coordinates written in the comments adjust according to the visible board area.
			<br>
			<div align="center"><img width="90%" src="/img/dynCommentsExample.png"></div>
			<br>
			Example: <a href="/tsumegos/play/25881">1000 Weiqi problems - 58</a>
			
		</div>
		
		
		<p class="title4">Update 20.07.2023</p>
		<div class="new1">
			<b>New board viewer: BesoGo</b><br><br>
			We changed the technology that is used to display the problems from jGoBoard to BesoGo. There are various advantages, such as 
			a tree display in the review, changing views without refresh, editing and saving problems on the website and more. It also opens
			possibilities to merge recurring board positions and to make a better result distinction. Instead of correct and incorrect,
			a future update is going to include more details.
			<br><br>
			<div align="center"><img width="60%" src="/img/besoGoExample.png"></div>
			<br>
			It comes
			with a separate editor which was the starting point to make this possible. <a href="https://kovarex.github.io/besogo/testing.html" target="_blank">Editor</a>
			<br><br>
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
			/*
			if(isset($_SESSION['loggedInUser'])){
			} 
				echo '<p class="title4">Your last Activities</p><div class="new1">';
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
			echo '<br></div>';
			*/	
		}	
			
		?>
	</div>
	
	<div class="homeLeft">
		<p class="title4">Most Recent Achievements</p>
		<?php
			$quotePick = ceil(substr($quote, 1)/3);
			
			//$quotePick = 8;
			if(!isset($_SESSION['lastVisit'])) $_SESSION['lastVisit'] = 15352;
			$modeActions = '';
			$modeActions2 = 'class="modeboxes"';
			if(isset($_SESSION['loggedInUser']) && $ac) $modeActions = 'class="modeboxes" onmouseover="mode2hover()" onmouseout="modeNoHover()"';
			if($ac) $modeActions2 = 'class="modeboxes"';
			else $modeActions2 = 'class="modeboxes"';
		
			
			echo '<div class="quotePick'.$quotePick.'" id="ajaxWallpaper"></div>';
			/*
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
			*/
		?>
		<a href="/tsumegos/play/<?php echo $_SESSION['lastVisit']; ?>?mode=1">
			<div class="modeBox1" onmouseover="mode1hover()" onmouseout="modeNoHover()"></div>
		</a>
		<a href="/tsumegos/play/<?php echo $_SESSION['lastVisit']; ?>?mode=1">
			<div class="modeBox11" onmouseover="mode1hover()" onmouseout="modeNoHover()"></div>
		</a>
		<?php if(isset($_SESSION['loggedInUser']['User']['id'])){ ?>
		<a href="/tsumegos/play/<?php echo $nextMode['Tsumego']['id']; ?>?mode=2">
			<div class="modeBox2" onmouseover="mode2hover()" onmouseout="modeNoHover()"></div>
		</a>
		<a href="/tsumegos/play/<?php echo $nextMode['Tsumego']['id']; ?>?mode=2">
			<div class="modeBox22" onmouseover="mode2hover()" onmouseout="modeNoHover()"></div>
		</a>
		<a href="/ranks/overview">
			<div class="modeBox3" onmouseover="mode3hover()" onmouseout="modeNoHover()"></div>
		</a>
		<a href="/ranks/overview">
			<div class="modeBox33" onmouseover="mode3hover()" onmouseout="modeNoHover()"></div>
		</a>
		<a href="/achievements">
			<div class="modeBox4" onmouseover="mode4hover()" onmouseout="modeNoHover()"></div>
		</a>
		<a href="/achievements">
			<div class="modeBox44" onmouseover="mode4hover()" onmouseout="modeNoHover()"></div>
		</a>
		<?php
		}
		echo '<img src="/img/new_startpage/'.$quotePick.'.PNG" width="100%" alt="Tsumego Hero Message of the Day" title="Tsumego Hero Message of the Day">';
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
		  <h2 id="uotdStartPage" <?php if(strlen($userOfTheDay)>=10) echo 'class="midLongName1"'; ?>><?php echo $userOfTheDay; ?></h2>
		</div>
		<p class="uotdmargin">&nbsp;</p>
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
		<p class="title4">Recent Donations and Upgrades</p>
		<div class="new1">
			<table class="newx" border="0">
				<tr>
					<td><h1>24.02.2024</h1></td>
					<td><h1>Younes Driouiche</h1></td>
					<td><h1>10,00 €</h1></td>
				</tr>
				<tr>
					<td><h1>22.02.2024</h1></td>
					<td><h1>Trianguli</h1></td>
					<td><h1>10,00 €</h1></td>
				</tr>
				<tr>
					<td><h1>21.02.2024</h1></td>
					<td><h1>Enrico Alvares</h1></td>
					<td><h1>10,00 €</h1></td>
				</tr>
				<tr>
					<td><h1>19.02.2024</h1></td>
					<td><h1>Tigran</h1></td>
					<td><h1>15,00 €</h1></td>
				</tr>
				<tr>
					<td><h1>18.02.2024</h1></td>
					<td><h1>Josechu</h1></td>
					<td><h1>10,00 €</h1></td>
				</tr>
				<!--
				<tr>
					<td><h1>10,00 € <font size="2px">subscription</font></h1></td>
				</tr>
				-->
			</table>	
		<br>
		</div>
		
		<p class="title4">Problem Database Size </p>
		<div class="new1">
		<?php
		$tsumegoDates = array();
		for($j=0; $j<count($tsumegos); $j++){
			$date = date_create($tsumegos[$j]);
			array_push($tsumegoDates, date_format($date,"Y-m-d"));
		}
		$tsumegoDates = array_count_values($tsumegoDates);
		$tsumegoDates['2018-02-07'] = 160;
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
			if($date==date_create('2020-02-22')) $td[$j]['num'] -= 347;
			//if($date==date_create('2023-09-01')) $td[$j]['num'] -= 141;
			if($date==date_create('2023-09-01')) $td[$j]['num'] -= 4;
			if($date==date_create('2023-10-04')) $td[$j]['num'] -= 10;
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
		
		<p class="title4">New Collection: Kano Yoshinori | 31.12.2023</p>
		<div class="new1">	
					This series written by Kano Yoshinori in 1985 covers a large range of fundamental topics. 
			Volume 1 contains problems about recognizing atari, ladders, snapbacks and basic life and death problems. Created for Tsumego Hero by Stepan Trubitsin.
			<div align="center"><img width="95%" src="/img/kano-yoshinori-promo.png" alt="New Collection: Kano Yoshinori" title="New Collection: Kano Yoshinori">
			
			<a class="new-button main-page" style="font-size:14px;" href="/sets/view/214">Play</a><br><br></div>
		
		</div>
		<p class="title4">New Collection: 9x9 Endgame Problems</p>
		<div class="new1">
			There's a saying in Go that your overall strength is limited by your endgame strength. Even if you are leading a lot in the opening and middle game, mistakes in endgame can still lose you the game. This collection allows you to practice and level-up your endgame in a small 9x9 board with real-game examples.   
			<div align="center"><img width="95%" src="/img/9x9-startpage.png">
			
			<a class="new-button main-page" style="font-size:14px;" href="/sets/view/207">Play</a><br><br></div>
		</div>
		<p class="title4">New Collection: Sacrifical Tsumego</p>
		<div class="new1">
			Sometimes sacrifices are necessary in order to kill, but how many stones can you sacrifice before killing? 
			That's the question this collection aims to answer. 
			<div align="center"><img width="95%" src="/img/sacrifical-tsumego-home.png">
			
			<a class="new-button main-page" style="font-size:14px;" href="/sets/view/197">Play</a><br><br></div>
		</div>
		<p class="title4">New Collection: Yi Kuo</p>
		<div class="new1">
			Yi Kuo is a classical kifu and tsumego book written by Huang Longshi (1651-1700). It was posthumously published in 1710. 
			Go Seigen once commented that Longshi's fighting skill 
			was of 13-dan strength. The problems in this collection are focused mainly on endgame tesujis. 
			<div align="center"><img width="95%" src="/img/yi-kuo-home.png">
			
			<a class="new-button main-page" style="font-size:14px;" href="/sets/view/195">Play</a><br><br></div>
		</div>
		</div>
		<br>
		<div style="clear:both;"></div> 
		<br>
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
			<?php if(isset($_SESSION['loggedInUser']['User']['id'])){ ?>
				$("#title-image").attr("src", "/img/modeSelect24-1.png");
			<?php }else{ ?>
				$("#title-image").attr("src", "/img/modeSelect24x-1.png");
			<?php } ?>
		}
		function mode2hover(){
			$("#title-image").attr("src", "/img/modeSelect24-2.png");
		}
		function mode3hover(){
			$("#title-image").attr("src", "/img/modeSelect24-3.png");
		}
		function mode4hover(){
			$("#title-image").attr("src", "/img/modeSelect24-4.png");
		}
		function modeNoHover(){
			<?php if(isset($_SESSION['loggedInUser']['User']['id'])){ ?>
				$("#title-image").attr("src", "/img/modeSelect24.png");
			<?php }else{ ?>
				$("#title-image").attr("src", "/img/modeSelect24x.png");
			<?php } ?>
		}
		let textBuffer = "";
		function getContent(){
			var xmlHttp = new XMLHttpRequest();
			xmlHttp.open("GET", "mainPageAjax.txt", false);
			xmlHttp.send(null);
			
			if(xmlHttp.responseText!==textBuffer){
				textBuffer = xmlHttp.responseText;
				$("#ajaxWallpaper").css("display", "none");
				setTimeout(nextFadeIn(xmlHttp.responseText), 100);
				setTimeout(nextFadeIn2, 300);
			}
		}
		function nextFadeIn2(){
			$("#ajaxWallpaper").fadeIn(300);
		}
		function nextFadeIn(responseText){
			var element = document.getElementById("ajaxWallpaper");
			element.innerHTML = responseText;
		}
		
		var ajaxCall = $.ajax({
			type: 'GET',
			url: "mainPageAjax.txt",
			dataType: 'txt'
		});
		
		$(document).ready(function(){
			ajaxCall.done(function(data){
			});
			setInterval(getContent, 1000);
		});
		getContent();
		
		let tooltipSgfs = [];
		let popularTooltip = [];
		<?php
		for($a=0; $a<count($tooltipSgfs); $a++){
			echo 'tooltipSgfs['.$a.'] = [];';
			for($y=0; $y<count($tooltipSgfs[$a]); $y++){
				echo 'tooltipSgfs['.$a.']['.$y.'] = [];';
				for($x=0; $x<count($tooltipSgfs[$a][$y]); $x++){
					echo 'tooltipSgfs['.$a.']['.$y.'].push("'.$tooltipSgfs[$a][$x][$y].'");';
				}
			}
		}
		
		for($y=0; $y<count($popularTooltip); $y++){
			echo 'popularTooltip['.$y.'] = [];';
			for($x=0; $x<count($popularTooltip[$y]); $x++){
				echo 'popularTooltip['.$y.'].push("'.$popularTooltip[$x][$y].'");';
			}
		}
		
		for($i=0; $i<count($scheduleTsumego); $i++)
			echo 'createPreviewBoard('.$i.', tooltipSgfs['.$i.'], '.$tooltipInfo[$i][0].', '.$tooltipInfo[$i][1].', '.$tooltipBoardSize[$i].');';
		echo 'createPreviewBoard(99, popularTooltip, '.$popularTooltipInfo[0].', '.$popularTooltipInfo[1].', '.$popularTooltipBoardSize.');';	
		
		?>
	</script>
	<?php
	if(!isset($_SESSION['loggedInUser']['User']['id'])){
		echo '<style>
		#progressBarInLevelMode{
			display:none;
		}
		</style>';
	}
	?>
	
		