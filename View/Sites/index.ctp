<?php 
	$donations = array();
	$donations[0]['date'] = '12.10.2024';
	$donations[0]['user'] = 'Timurlan ';
	$donations[0]['amount'] = '10,00 €';

	$donations[1]['date'] = '10.10.2024';
	$donations[1]['user'] = 'Arjan ';
	$donations[1]['amount'] = '10,00 €';

	$donations[2]['date'] = '10.10.2024';
	$donations[2]['user'] = 'Gonuzul ';
	$donations[2]['amount'] = '10,00 €';

	$donations[3]['date'] = '05.10.2024';
	$donations[3]['user'] = 'Andre83 ';
	$donations[3]['amount'] = '10,00 €';

	$donations[4]['date'] = '02.10.2024';
	$donations[4]['user'] = 'Jean-Fred Moulin ';
	$donations[4]['amount'] = '10,00 €';
	//$donations[4]['amount'] = '10,00 € <font size="2px">subscription</font>';
?>
	<script src ="/js/previewBoard.js"></script>
	<script src="https://accounts.google.com/gsi/client" async defer></script>
	
	<?php if($_SESSION['loggedInUser']['User']['isAdmin'] > 0){ ?>
	<div class="admin-panel-main-page">
		<ul>
			<li><a class="adminLink2" href="/users/adminstats">Activities</a></li>
		</ul>
	</div>
	<?php } ?>

	<div class="homeRight">
		<p class="title4 title4right"><?php echo $d1; ?></p>
		<?php
		if(isset($_SESSION['loggedInUser']['User']['id']))
			echo '<img id="title-image" src="/img/modeSelect24.png" width="100%" alt="Tsumego Hero Modes" title="Tsumego Hero Modes">';
		else
			echo '<img id="title-image" src="/img/modeSelect24x.png" width="100%" alt="Tsumego Hero Modes" title="Tsumego Hero Modes">';
		?>
		<br>
		<p class="title4">Problems of the Day</p>
		<div class="new1">
		<?php
		if(count($scheduleTsumego)!=0){
			echo '<font color="#444">Added today:</font><br>';
			if(count($scheduleTsumego)>1){
				if(!$scheduleTsumego[0]['Tsumego']['locked']){ 
					echo '<a class="scheduleTsumego" href="/sets/view/'.$newT['Tsumego']['set_id'].'"><b>
					'.$newT['Tsumego']['set'].' '.$newT['Tsumego']['set2'].' - '.count($scheduleTsumego).' problems</b></a><br>';
				}else{
					echo '<a class="scheduleTsumego" href="/users/donate"><b>
					'.$newT['Tsumego']['set'].' '.$newT['Tsumego']['set2'].' - '.count($scheduleTsumego).' problems</b></a><br>';
				}
			}
			for($i=0; $i<count($scheduleTsumego); $i++){
				if(!$scheduleTsumego[$i]['Tsumego']['locked']){ 
					echo '<li class="set'.$scheduleTsumego[$i]['Tsumego']['status'].'1" style="margin-top:4px;">
						<a id="tooltip-hover'.$i.'" class="tooltip" href="/tsumegos/play/'.$scheduleTsumego[$i]['Tsumego']['id'].'?search=topics">'
						.$scheduleTsumego[$i]['Tsumego']['num'].'<span><div id="tooltipSvg'.$i.'"></div></span></a>
					</li>';
				}else{
					echo '<li class="set'.$scheduleTsumego[$i]['Tsumego']['status'].'1" style="margin-top:4px;background-image: url(\'/img/viewButtonLocked.png\'">
						<a class="tooltip" href="/users/donate">&nbsp;</a>
					</li>';
				}
			}
			if(count($scheduleTsumego)<=10) echo '';
			else echo '<br>';
		}
		if(count($scheduleTsumego)!=0) echo '<br><br><br>';
		else echo ''; 
		?>
		<font color="#444">Most popular today:</font><br>
			<?php if(!$totd['Tsumego']['locked']){ ?>
				<a id="mostPopularToday" href="/sets/view/<?php echo $totd['Tsumego']['set_id']; ?>"><b>
					<?php echo $totd['Tsumego']['set'].' '.$totd['Tsumego']['set2']; ?></b> - <?php echo $totd['Tsumego']['num']; ?></a><br>
				<li class="set<?php echo $totd['Tsumego']['status']; ?>1" style="margin-top:4px;">
					<a id="tooltip-hover99" class="tooltip" href="/tsumegos/play/<?php echo $totd['Tsumego']['id'].'?search=topics'; ?>">
						<?php echo $totd['Tsumego']['num']; ?>
						<span><div id="tooltipSvg99"></div></span>
					</a>
				</li>
			<?php }else{ ?>
				<a id="mostPopularToday" href="/users/donate"><b>
					<?php echo $totd['Tsumego']['set'].' '.$totd['Tsumego']['set2']; ?></b> - <?php echo $totd['Tsumego']['num']; ?></a><br>
				<li class="set<?php echo $totd['Tsumego']['status']; ?>1" style="margin-top:4px;background-image: url('/img/viewButtonLocked.png');">
					<a class="tooltip" href="/users/donate">
						&nbsp;
					</a>
				</li>
			<?php } ?>
			<br><br>
		</div>
		<!-- RIGHT NEWS -->
		<!-- RIGHT NEWS -->
		<!-- RIGHT NEWS -->
		<p class="title4">New Collection: Attack Hero | 30.12.2024</p>
		<div class="new1">	
		In the game of Go, attacks can be used to get an advantage on the board. When attacking a group, killing is not the first objective. 
		Instead of that a group can be attacked to gain influence, gain territory, stabilize their own group, create thickness or many other reasons. 
		This collection teaches the best ways to attack groups to get an advantage on the board.<br><br>
		<div align="center"><img width="60%" src="/img/attack-hero-promo.png" alt="New Collection: Attack Hero" title="New Collection: Attack Hero"><br><br>
		<?php if($hasPremium){ ?>
			<a class="new-button main-page" style="font-size:14px;" href="/sets/view/246">Play</a><br><br>
		<?php }else{ ?>
			<a class="new-button-inactive main-page" style="font-size:14px;">Play</a><br><br>
		<?php } ?>
		</div>
		</div>
		<p class="title4">New Collection: Igo Hatsuyoron | 13.12.2024</p>
		<div class="new1">	
		Igo Hatsuyoron (literally: Production of Yang in the Game of Go) is a collection of 183 go problems mostly 
		life and death problems, compiled in 1713 by the Japanese go master Inoue Dosetsu Inseki. The problems in this collection 
		have a very high difficulty, so discussion of solutions might not always be possible.<br><br>
		<div align="center"><img width="95%" src="/img/igo-hatzuyoron.png" alt="New Collection: Igo Hatsuyoron" title="New Collection: Igo Hatsuyoron">
		
		<a class="new-button main-page" style="font-size:14px;" href="/sets/view/242">Play</a><br><br></div>
		</div>
		<p class="title4">Update 29.11.2024</p>
		<div class="new1">
			<b>Customizable collection index page</b><br><br>
			The collection index page got a makeover, which makes use of the newly introduced tags. You can set filters for three categories: 
				<b style="color:#77c14a">Topics</b>, <b style="color:#be6cdd">Difficulty</b> and <b style="color:#d5795a">Tags</b>. 
			<br>
			<div align="center">
				<img style="margin:5px" src="/img/customizable-collections-example.PNG" title="Customizable Collections Example" width="85%">
			</div>
			Further, there are two grouping parameters: Collection types and collection sizes. The type is set to one of the three filters.
			In this example, the type is difficulty, which groups the problems in collections for the rank. 
			The applied filters remain set on the problem pages until they are changed or removed.
			<br><br>
		</div>
		<p class="title4">Update 26.10.2024</p>
		<div class="new1">
			<b>Tags, proposals and rewards</b><br><br>
			We need your help! The problems on this website are currently uncategorized, which we should change. 
			The goal is to assign matching tags to every problem. All users that have passed level 40 or 6k 
			are welcome to help with this meaningful task. There are amazing <a href="/users/rewards">rewards</a> for those who 
			help with adding and creating tags and/or proposals. So the next time you see a problem, for example, 
			with a <a href="/tag_names/view/8">Seki</a>, a <a href="/tag_names/view/6">Snapback</a> or an 
			<a href="/tag_names/view/7">Under the Stones</a> tesuji, leave a tag.
			<br>
			<div align="center">
				<img style="margin:5px" src="/img/example-tags-proposals.PNG" title="Example for tags and proposals" width="72%">
			</div>
			It is now also possible to make proposals for improving the problem files. You select "Make Proposal", modify the move tree and save. An
			admin is going to check and approve the changes. For getting rewards, a point system has been implemented: <b>Add tag (1 pt)</b>, <b>create new tag (3 pts)</b>, 
			<b>make proposal (5 pts)</b>. Any contribution has to be accepted by an admin to become public. <i>Rewards have been deactivated as they were meant for the early 
			phase of tags to get it running.</i>
			<br><br>
		</div>
		<p class="title4">Update 13.10.2024</p>
		<div class="new1">
			<b>Account management</b><br><br>
			• Longer sessions.<br>
			• Sign in with Google account.<br>
			• Option to delete all account related data.<br>
			<div align="center">
				<div class="g-signin">
					<?php if(isset($_SESSION['loggedInUser']['User']['id'])){ ?>
					<img src="/img/google-logo.png" title="google-logo" alt="google-logo" width="40px" style="border-radius:25%">
					<?php }else{ ?>
					<div
						id="g_id_onload"
						data-client_id="842499094931-nt12l2fehajo4k7f39bb44fsjl0l4h6u.apps.googleusercontent.com"
						data-context="signin"
						data-ux_mode="popup"
						data-login_uri="/users/googlesignin"
						data-auto_prompt="false"
					></div>
					<div
						class="g_id_signin"
						data-type="standard"
						data-shape="rectangular"
						data-theme="outline"
						data-text="sign_in_with"
						data-size="large"
					></div>
					<?php } ?>
				</div>
			</div>
		</div>
		<p class="title4">New: Diabolical - the whole book | 19.08.2024</p>
		<div class="new1">
			Today we start publishing all problems from the Diabolical Vol. 1 book. That is 100 boards with each containing 4 or more problems.
			Props to posetcay for adding the missing solutions and greetings to David Mitchell, who is the author and also a friend of the website
			for several years.
			PDFs and more books by him and his association can be found here: 
			<a href="https://australiango.asn.au/aga-books" target="_blank">australiango.asn.au/aga-books</a>

			<br><br>
			<div align="center"><img width="95%" src="/img/diabolical-new-promo.png" alt="New: Diabolical - the whole book" title="New: Diabolical - the whole book">
			
			<a class="new-button main-page" style="font-size:14px;" href="/sets/view/237">Play</a><br><br></div>
		</div>
		<p class="title4">New Collection: Direction of the Play  | 28.07.2024</p>
		<div class="new1">	
			This collection covers full board positions, mostly from professional games. 
			The task is to choose the best move from the given options. The problems were checked with AI for correctness. <br><br>
			<div align="center"><img width="95%" src="/img/directionofplay-info.png" alt="New Collection: Direction of the Play" title="New Collection: Direction of the Play">
			
			<a class="new-button main-page" style="font-size:14px;" href="/sets/view/236">Play</a><br><br></div>
		</div>
		<p class="title4">New Collection: Techniques of TsumeGo  | 04.07.2024</p>
		<div class="new1">	
			In the game of Go, to solve crucial situations, one has to master the different techniques that the game presents. Those techniques, 
			also known as Tesuji, are presented in this collection.
			The first topics and the first Tesuji techniques to master are ladders (Shicho) and nets (Geta).<br><br>
			<i>Kageyama says "If you want to capture stones, hold up two fingers and say to yourself: 'Can I capture with the net?' and 'Can I capture with the ladder?'"</i><br><br>
			<div align="center"><img width="95%" src="/img/techniques.PNG" alt="New Collection: Techniques of TsumeGo" title="New Collection: Techniques of TsumeGo">
			
			<a class="new-button main-page" style="font-size:14px;" href="/sets/view/235">Play</a><br><br></div>
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
		
			<?php
			if(isset($_SESSION['loggedInUser'])){
			if(false){
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
		}	
		?>
	</div>
	
	<div class="homeLeft">
		<p class="title4">Most Recent Achievements</p>
		<?php
			$quotePick = ceil(substr($quote, 1)/3);
			if(!isset($_SESSION['lastVisit'])) $_SESSION['lastVisit'] = 15352;
			$modeActions = '';
			$modeActions2 = 'class="modeboxes"';
			if(isset($_SESSION['loggedInUser']) && $ac) $modeActions = 'class="modeboxes" onmouseover="mode2hover()" onmouseout="modeNoHover()"';
			if($ac) $modeActions2 = 'class="modeboxes"';
			else $modeActions2 = 'class="modeboxes"';
			echo '<div class="quotePick'.$quotePick.'" id="ajaxWallpaper"></div>';
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
		?>
		<p class="title4">User of the Day </p>
		<div class="new1">
		<div class="uotd mid uotd<?php echo $uotdbg; ?> mid<?php echo $uotdbg; ?> ">
		  <h2 id="uotdStartPage" <?php if(strlen($userOfTheDay)>=10) echo 'class="midLongName1"'; ?>><?php echo $userOfTheDay; ?></h2>
		</div>
		<p class="uotdmargin">&nbsp;</p>
		</div>
		<?php if(
			!isset($_SESSION['loggedInUser']['User']['id'])
			|| isset($_SESSION['loggedInUser']['User']['id']) && $_SESSION['loggedInUser']['User']['premium']==0
		){ ?>
			<p class="title4">Upgrade to Premium</p>
			<div class="new1">
			<div align="center">
				<br>
				<a href="/users/donate"><img id="donateH" onmouseover="donateHover()" onmouseout="donateNoHover()" width="180px" src="/img/upgradeButton1.png"></a>
				<br><br>
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
			if($date==date_create('2023-09-01')) $td[$j]['num'] -= 4;
			if($date==date_create('2023-10-04')) $td[$j]['num'] -= 10;
			if($date==date_create('2024-08-18')) $td[$j]['num'] -= 31;
			$x = $td[$j]['num'];
			$sum = $x;
			
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
		<p class="title4">Recent Upgrades</p>
		<div class="new1">
			<table class="newx" border="0">
				<?php 
					for($i=0;$i<count($urNames);$i++)
						echo '<tr><td><img width="40px" src="/img/hpP.png"></td><td><h1 style="margin:2px">'.$urNames[$i].'</h1></td></tr>';
				?>
			</table>	
		</div>
		
		<!-- LEFT NEWS -->
		<!-- LEFT NEWS -->
		<!-- LEFT NEWS -->
		<p class="title4">Bugfix 01.05.2024</p>
		<div class="new1">
		Longer sessions were not working properly, so this feature is reverted. If there are still any issues, such as log-outs, try to delete the cookies.<br><br>
		</div>
		<p class="title4">Update 30.04.2024</p>
		<div class="new1">
		
		<b>Improved search, ratings and board views</b><br><br>
		<b>• Boards can be roatated.</b> <br>
		<b>• Broader rank system:</b> While the last update enabled ranks from 21k to 9d, this update scales the existing problems into the new range.<br>
		<b>• Improved raitng calculation:</b> The Tsumego rating calculation added an activity value that is meant to have a higher variance
		with fresh problems.<br>
		
		<b>• Improved similar problem search:</b> The search has been improved by storing solution types in the database.
		It always finds many similar problems in any search now and is very fast. <br>
		<div align="center">
		<img src="/img/example-search.png" title="search-example" alt="search-example" width="350px"><br>
		Example: <a href="/tsumegos/duplicatesearch/2897">Life & Death - Elementary 745</a><br>
		<i>In this example, it finds 30 similar problems almost instantly.</i><br><br>
		</div>
		</div>
		<p class="title4">Update 03.04.2024</p>
		<div class="new1">
		<b>Improvements of rank display and score mechanics</b><br><br>
		
		<b>• Broader rank system:</b> Player and Tsumego ranks range from 21k to 9d.<br>
		<b>• Collection difficulty:</b> Instead of a difficulty value from 1 to 9, the average kyu/dan rank is shown.<br>
		<b>• Mode-indepentent scores:</b> Problems in rating- and time mode give also xp and they change the problem's status to solved on succeeding. 
		This means that rating and level 
		are affected in any mode.<br>
		<b>• Progress bar switch:</b> The progress bar can display any type and it can be switched on the problem pages by 
		selecting the lower left corner.<br><br>
		<div align="center">
		<img src="/img/thumbs/1.PNG" title="bar-example" alt="bar-example" width="140px">
		
		<br>
		</div>
		</div>
		<p class="title4">17.03.2024</p>
		<div class="new1">
		<b>Prizes</b><br><br>
		
		<b>Madec</b>, <b>Kimok</b> and <b>YuriyStepanovich</b> win a premium account as they have the highest non-premium ratings.<br><br>
		</div>
		<p class="title4">10.03.2024</p>
		<div class="new1">
		<b>Prizes</b><br><br>
		
		<b>GoTalk</b>, <b>Futsal</b> and <b>Imaim</b> win a premium account. One more time we upgrade 3 accounts on 17.03.2024.<br><br>
		</div>
		<p class="title4">03.03.2024</p>
		<div class="new1">
		<b>Prizes</b><br><br>
		
		<b>Rippa</b>, <b>au61413080900</b> and <b>franp9am</b> win a premium account as they have the highest non-premium ratings. On
		10.03.2024 we give away 3 more.<br><br>
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
		<a class="menuIcons2" id="darkButton2" onclick="darkAndLight();"><img id="darkButtonImage2" src="/img/light-icon1x.png" width="30px"></a>
		<h1 class="darkButton2">Dark Theme</h1>
		<a class="menuIcons2" id="darkButton3" onclick="darkAndLight();"><img id="darkButtonImage3" src="/img/light-icon1x.png" width="30px"></a>
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
			document.getElementById("donateH").src = '/img/upgradeButton1h.png';
		}	
		function donateNoHover(){
			document.getElementById("donateH").src = "/img/upgradeButton1.png";
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
	
		