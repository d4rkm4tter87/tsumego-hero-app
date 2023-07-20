
<?php if($ui==2){ ?>
	<link rel="stylesheet" type="text/css" href="/besogo/css/besogo.css">
	<link rel="stylesheet" type="text/css" href="/besogo/css/board-flat.css">

	<script src="/besogo/js/besogo.js?v=1.2"></script>
	<script src="/besogo/js/transformation.js?v=1.2"></script>
	<script src="/besogo/js/treeProblemUpdater.js?v=1.2"></script>
	<script src="/besogo/js/nodeHashTable.js?v=1.2"></script>
	<script src="/besogo/js/editor.js?v=1.2"></script>
	<script src="/besogo/js/gameRoot.js?v=1.2"></script>
	<script src="/besogo/js/status.js?v=1.2"></script>
	<script src="/besogo/js/svgUtil.js?v=1.2"></script>
	<script src="/besogo/js/parseSgf.js?v=1.2"></script>
	<script src="/besogo/js/loadSgf.js?v=1.2"></script>
	<script src="/besogo/js/saveSgf.js?v=1.2"></script>
	<script src="/besogo/js/boardDisplay.js?v=1.2"></script>
	<script src="/besogo/js/coord.js?v=1.2"></script>
	<script src="/besogo/js/toolPanel.js?v=1.3"></script>
	<script src="/besogo/js/filePanel.js?v=1.2"></script>
	<script src="/besogo/js/controlPanel.js?v=1.2"></script>
	<script src="/besogo/js/commentPanel.js?v=1.2"></script>
	<script src="/besogo/js/treePanel.js?v=1.2"></script>
<?php } ?>
<?php
	$choice = array();
	for($i=1;$i<=count($enabledBoards);$i++){
		if($enabledBoards[$i]=='checked') array_push($choice, $boardPositions[$i]);
	}
	if($corner=='full board') $boardSize = 'medium';
	else $boardSize = 'large';
	shuffle($choice);


	$authorx = $t['Tsumego']['author'];
	if($authorx=='Joschka Zimdars') $authorx = 'd4rkm4tter';
	if($authorx=='Jérôme Hubert') $authorx = 'jhubert';

	$heroPower1 = 'hp1x';
	$heroPower2 = 'hp2x';
	$heroPower3 = 'hp3x';
	$heroPower4 = 'hp4x';
	$heroPower5 = 'hp5x';

	$xpDisplayColor = 'black';
	if($goldenTsumego){
		$xpDisplayColor = '#b5910b';
		echo '<style>#xpDisplay{font-weight:800;color:#b5910b;}</style>';
	}
	if(isset($formRedirect)) echo '<script type="text/javascript">window.location.href = "/tsumegos/play/'.$t['Tsumego']['id'].'";</script>';
	if(isset($deleteProblem2)) echo '<script type="text/javascript">window.location.href = "/sets/view/'.$t['Tsumego']['set_id'].'";</script>';
	if($r10==1) echo '<script type="text/javascript">window.location.href = "/ranks/result";</script>';
	if($isSandbox){
		$sandboxComment = '(Sandbox)';
		if(isset($_SESSION['loggedInUser'])){
		}else{
			echo '<script type="text/javascript">window.location.href = "/";</script>';
		}
	}else $sandboxComment = '';

	if($t['Tsumego']['set_id']==6473 ||$t['Tsumego']['set_id']==11969 || $t['Tsumego']['set_id']==29156 || $t['Tsumego']['set_id']==31813 || $t['Tsumego']['set_id']==33007
	|| $t['Tsumego']['set_id']==71790 || $t['Tsumego']['set_id']==74761 || $t['Tsumego']['set_id']==81578 || $t['Tsumego']['set_id']==88156){
		if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['secretArea1']==0 && $t['Tsumego']['set_id']==11969) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea2']==0 && $t['Tsumego']['set_id']==29156) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea3']==0 && $t['Tsumego']['set_id']==31813) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea4']==0 && $t['Tsumego']['set_id']==33007) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea5']==0 && $t['Tsumego']['set_id']==71790) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea6']==0 && $t['Tsumego']['set_id']==74761) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea7']==0 && $t['Tsumego']['set_id']==81578) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea9']==0 && $t['Tsumego']['set_id']==6473) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea10']==0 && $t['Tsumego']['set_id']==88156) echo '<script type="text/javascript">window.location.href = "/";</script>';
		}else{
			echo '<script type="text/javascript">window.location.href = "/";</script>';
		}

		$sprintEnabled = 0;
		$intuitionEnabled = 0;
		$rejuvenationEnabled = 0;
		$refinementEnabled = 0;

		echo '
			<style>#xpDisplay{font-weight:800;color:#60167d;}</style>
		';
		$heroPower1 = 'hp1xx';
		$heroPower2 = 'hp2xx';
		$heroPower3 = 'hp3xx';
		$heroPower4 = 'hp4xx';
		$heroPower5 = 'hp5xx';
	}

	if($t['Tsumego']['set_id']==11969) echo '<script type="text/javascript" src="/'.$boardSize.'/board23.js"></script>'; //Pretty Area
	else if($t['Tsumego']['set_id']==29156) echo '<script type="text/javascript" src="/'.$boardSize.'/board24.js"></script>'; //Hunting
	else if($t['Tsumego']['set_id']==31813) echo '<script type="text/javascript" src="/'.$boardSize.'/board25.js"></script>'; //The Ghost
	else if($t['Tsumego']['set_id']==33007) echo '<script type="text/javascript" src="/'.$boardSize.'/board26.js"></script>'; //Carnage
	else if($t['Tsumego']['set_id']==71790) echo '<script type="text/javascript" src="/'.$boardSize.'/board27.js"></script>'; //Blind Spot
	else if($t['Tsumego']['set_id']==74761) echo '<script type="text/javascript" src="/'.$boardSize.'/board28.js"></script>'; //Giants
	else if($t['Tsumego']['set_id']==81578) echo '<script type="text/javascript" src="/'.$boardSize.'/board29.js"></script>'; //Moves of Resistance
	else if($t['Tsumego']['set_id']==88156) echo '<script type="text/javascript" src="/'.$boardSize.'/board30.js"></script>'; //Hand of God
	else if($goldenTsumego) echo '<script type="text/javascript" src="/'.$boardSize.'/board46.js"></script>'; //Golden
	else if($t['Tsumego']['set_id']==6473) echo '<script type="text/javascript" src="/'.$boardSize.'/board55.js"></script>'; //Tsumego Grandmaster
	else echo '<script type="text/javascript" src="/'.$boardSize.'/board'.$choice[0][0].'.js"></script>'; // Regular
	if($ui==2){ 
		if($t['Tsumego']['set_id']==11969) $choice[0] = $boardPositions[44]; //Pretty Area
		else if($t['Tsumego']['set_id']==29156) $choice[0] = $boardPositions[45]; //Hunting
		else if($t['Tsumego']['set_id']==31813) $choice[0] = $boardPositions[46]; //The Ghost
		else if($t['Tsumego']['set_id']==33007) $choice[0] = $boardPositions[47]; //Carnage
		else if($t['Tsumego']['set_id']==71790) $choice[0] = $boardPositions[48]; //Blind Spot
		else if($t['Tsumego']['set_id']==74761) $choice[0] = $boardPositions[49]; //Giants
		else if($t['Tsumego']['set_id']==81578) $choice[0] = $boardPositions[50]; //Moves of Resistance
		else if($t['Tsumego']['set_id']==88156) $choice[0] = $boardPositions[50]; //Hand of God
		else if($goldenTsumego) $choice[0] = array(46,'texture46','black34.png','white34.png'); //Golden
		else if($t['Tsumego']['set_id']==6473) $choice[0] = $boardPositions[51]; //Tsumego Grandmaster
		else echo '<script type="text/javascript" src="/'.$boardSize.'/board'.$choice[0][0].'.js"></script>'; // Regular
	}
	if(isset($_SESSION['lastVisit'])) $lv = $_SESSION['lastVisit'];
	else $lv = '15352';

	$a1 = '';
	$b1 = '';
	$c1 = '';
	$d1 = '';
	$x2 = '';
	$multipleChoiceCorrect = '';
	if($corner=='full board') $ansDisplay = 'ansBig';
	else $ansDisplay = 'ans';

	$blackLiberties = $libertyCount - $blackSubtractedLiberties;
	$whiteLiberties = $libertyCount - $whiteSubtractedLiberties;

	$playerColor = array();
	$pl = 0;
	if($colorOrientation=='black') $pl = 0;
	elseif($colorOrientation=='white') $pl = 1;
	else $pl = rand(0,1);
	
	if($firstPlayer=='w' || $t['Tsumego']['set_id']==109 || $checkBSize!=19 || $t['Tsumego']['set_id']==159 || $t['Tsumego']['set_id']==161) $pl=0;
	if($pl==0){
		$playerColor[0] = 'BLACK';
		$playerColor[1] = 'WHITE';
		$e = $blackLiberties;
		$blackLiberties = $whiteLiberties;
		$whiteLiberties = $e;
	}else{
		$playerColor[0] = 'WHITE';
		$playerColor[1] = 'BLACK';
	}
	$descriptionColor;
	if($pl==0)$descriptionColor = 'Black ';
	else $descriptionColor = 'White ';

	$t['Tsumego']['description'] = str_replace('b ', $descriptionColor, $t['Tsumego']['description']);

?>

	<table width="100%" border="0">
	<tr>
	<td align="center" width="29%">
		<div id="health">
			<?php

			$health = $user['User']['health'] - $user['User']['damage'];
			for($i=0; $i<$health; $i++){
				echo '<img title="Heart" id="heart'.$i.'" src="/img/'.$fullHeart.'.png">';
			}
			for($i=0; $i<$user['User']['damage']; $i++){
				$h = $health+$i;
				echo '<img title="Empty Heart" id="heart'.$h.'" src="/img/'.$emptyHeart.'.png">';
			}
			?>
		</div>
	</td>
	<td align="center" width="42%">
	<table>
	<tr>
		<td align="center">
			<div id="playTitle">
				<?php
					if(strlen($t['Tsumego']['file'])>4){
						$di = ' - ';
						$di2 = '';
						$anz = '';
					}else{
						$di = ' ';
						$di2 = '/';
					}
					if($mode==2) $inFavorite='';
					if($inFavorite==''){
						if($mode==1){
							if($t['Tsumego']['set_id']==38){
								if($t['Tsumego']['file']<=17) $altTitle = 'Essential Tsumego Vol. I';
								elseif($t['Tsumego']['file']<=28) $altTitle = 'Essential Tsumego Vol. II';
								else $altTitle = 'How to win the capturing race';
								echo '<a id="playTitleA" href="/sets/view/'.$set['Set']['id'].'">'.$altTitle.$di.$t['Tsumego']['file'].$di2.$anz.'</a>';
							}else{
								echo '<a id="playTitleA" href="/sets/view/'.$set['Set']['id'].'">'.$set['Set']['title'].$di.$t['Tsumego']['file'].$di2.$anz.'</a>';
							}
						}elseif($mode==2){
							echo '<div class="slidecontainer">
							  <input type="range" min="1" max="7" value="'.$difficulty.'" class="slider" id="rangeInput" name="rangeInput">
							  <div id="sliderText">regular</div>
							</div>';
							echo '<a id="playTitleA" href=""></a>';
						}elseif($mode==3){
							echo '<font size="5px">'.$currentRankNum.' of '.$stopParameter.'</font>';
						}
					}else echo '<a id="playTitleA" href="/sets/view/1">Favorites</a>
					<font style="font-weight:400;" color="grey" >(<a style="color:grey;" id="playTitleA" href="/sets/view/'.$set['Set']['id'].'">'.$set['Set']['title'].$di.$t['Tsumego']['file'].$di2.$anz.'</a>)</font>';

				?>
				<br>
				<?php
				if($t['Tsumego']['set_id']==109 || $t['Tsumego']['set_id']==159 || $t['Tsumego']['set_id']==161){
					if($additionalInfo['mode']==0){
				?>
						<table class="gameInfo" style="padding-top:7px;">
						<tr>
						<td>
						Black:
						</td>
						<td>
						White:
						</td>
						</tr>
						<tr>
						<td style="padding-left:20px;padding-right:20px;">
						<?php echo $additionalInfo['playerNames'][0]; ?>
						</td>
						<td>
						<?php echo $additionalInfo['playerNames'][1]; ?>
						</td>
						</tr>
						</table>

					<?php }else{
						if(count($additionalInfo['playerNames'])==4){
					?>

						<table class="gameInfo" style="padding-top:7px;">
						<tr>
						<td>
						<?php //echo '<pre>';print_r($additionalInfo);echo '</pre>';
						echo $additionalInfo['playerNames'][0].' on '.$additionalInfo['playerNames'][1];
						?>
						</td>
						</tr>

						</table>


						<table class="gameInfo" style="padding-top:7px;">
						<tr>
						<td>
						Black:
						</td>
						<td>
						White:
						</td>
						</tr>
						<tr>
						<td style="padding-left:20px;padding-right:20px;">
						<?php echo $additionalInfo['playerNames'][2]; ?>
						</td>
						<td>
						<?php echo $additionalInfo['playerNames'][3]; ?>
						</td>
						</tr>
						</table>

				<?php }}} ?>
			</div>
		</td>
	</tr>
	<tr>
		<td align="center">

		<?php 
		if($mode==1) echo '<div id="titleDescription" class="titleDescription1">';
		elseif($mode==2  || $mode==3) echo '<div id="titleDescription" class="titleDescription2">';
			if($t['Tsumego']['set_id']==109 || $t['Tsumego']['set_id']==159 || $t['Tsumego']['set_id']==161) echo '<b>'.$t['Tsumego']['description'].'</b> '; 
			else echo $t['Tsumego']['description'].' '; 
			if(isset($t['Tsumego']['hint']) && $t['Tsumego']['hint']!='') echo '<font color="grey" style="font-style:italic;">('.$t['Tsumego']['hint'].')</font>'; 
		if($_SESSION['loggedInUser']['User']['isAdmin']>0 || $set['Set']['public']==0 && $_SESSION['loggedInUser']['User']['isAdmin']==2){
		?>
		<a class="modify-description" href="#">(Edit)</a>
		<div class="modify-description-panel">
			<?php
				$placeholder = str_replace('Black', 'b', $t['Tsumego']['description']);
				$placeholder = str_replace('White', 'b', $placeholder);
				echo $this->Form->create('Comment');
				echo $this->Form->input('id', array('type' => 'hidden', 'value' => $t['Tsumego']['id']));
				echo $this->Form->input('admin_id', array('type' => 'hidden', 'value' => $_SESSION['loggedInUser']['User']['id']));
				echo $this->Form->input('modifyDescription', array('value' => $placeholder, 'label' => '', 'type' => 'text', 'placeholder' => 'description'));
				echo $this->Form->input('modifyHint', array('value' => $t['Tsumego']['hint'], 'label' => '', 'type' => 'text', 'placeholder' => 'hint'));
				echo $this->Form->input('modifyAuthor', array('value' => $t['Tsumego']['author'], 'label' => '', 'type' => 'text', 'placeholder' => 'author'));
				if($isSandbox) echo $this->Form->input('deleteProblem', array('value' => '', 'label' => '', 'type' => 'text', 'placeholder' => 'delete'));
				echo $this->Form->end('Submit');
			?>
		</div>
		<?php } ?>
		</div>
		</td>
	</tr>
	</table>
	</td>
	<td align="center" width="29%">
		<?php
			if($mode==1){//not mode 3
				if($user['User']['level']>=20 && $sprintEnabled==1){
					echo '
						<a href="#"><img id="sprint" title="Sprint: Double XP for 2 minutes." alt="Sprint" src="/img/hp1.png"
						onmouseover="sprintHover()" onmouseout="sprintNoHover()" onclick="sprint(); return false;"></a>
					';
				}else{
					echo '
						<a href="#"><img id="sprint" title="Sprint (Level 20): Double XP for 2 minutes." src="/img/'.$heroPower1.'.png"
						style="cursor: context-menu;" alt="Sprint"></a>
					';
				}
				if($user['User']['level']>=30 && $intuitionEnabled==1){
					echo '
						<a href="#"><img id="intuition" title="Intuition: Shows the first correct move." alt="Intuition" src="/img/hp2.png"
						onmouseover="intuitionHover()" onmouseout="intuitionNoHover()" onclick="intuition(); return false;"></a>
					';
				}else{
					echo '
						<a href="#"><img id="intuition" title="Intuition (Level 30): Shows the first correct move." src="/img/'.$heroPower2.'.png"
						style="cursor: context-menu;" alt="Intuition"></a>
					';
				}
				if($user['User']['level']>=40 && $rejuvenationEnabled==1){
					echo '
						<a href="#"><img id="rejuvenation" title="Rejuvenation: Restores health, Intuition and locks." src="/img/hp3.png"
						onmouseover="rejuvenationHover()" onmouseout="rejuvenationNoHover()" onclick="rejuvenation(); return false;"></a>
					';
				}else{
					echo '
						<a href="#"><img id="rejuvenation" title="Rejuvenation (Level 40): Restores health, Intuition and locks." src="/img/'.$heroPower3.'.png"
						style="cursor: context-menu;" alt="Rejuvenation"></a>
					';
				}
				if($user['User']['premium']>0 || $user['User']['level']>=100){
					if($refinementEnabled==1){
						echo '
							<a href="#"><img id="refinement" title="Refinement: Gives you a chance to solve a golden tsumego. If you fail, it disappears." src="/img/hp4.png"
							onmouseover="refinementHover()" onmouseout="refinementNoHover()" onclick="refinement(); return false;"></a>
						';
					}else{
						echo '
							<a href="#"><img id="refinement" title="Refinement (Level 100 or Premium): Gives you a chance to solve a golden tsumego. If you fail, it disappears." src="/img/'.$heroPower4.'.png"
							style="cursor: context-menu;" alt="Refinement"></a>
						';
					}
				}else{
					echo '
						<a href="#"><img id="refinement" title="Refinement (Level 100 or Premium): Gives you a chance to solve a golden tsumego. If you fail, it disappears." src="/img/'.$heroPower4.'.png"
						style="cursor: context-menu;" alt="Refinement"></a>
					';
				}
				if($user['User']['premium']>0 || $user['User']['level']>=50){
					if($potionActive){
						echo '
							<img id="potion" title="Potion (Passive): If you misplay and have no hearts left, you have a small chance to restore your health." src="/img/hp5.png">
						';
					}else{
						/*echo '
							<img id="potion" title="Potion (Passive): If you misplay and have no hearts left, you have a small chance to restore your health." src="/img/'.$heroPower5.'.png">
						';*/
					}

				}else{
					/*echo '
						<img id="potion" title="Potion (Passive): If you misplay and have no hearts left, you have a small chance to restore your health." src="/img/'.$heroPower5.'.png">
					';*/
				}
			}else{
				echo '
					<a href="#"><img id="sprint" title="Sprint (Level 20): Double XP for 2 minutes." src="/img/hp1x.png"
					style="cursor: context-menu;" alt="Sprint"></a>
				';
				echo '
					<a href="#"><img id="intuition" title="Intuition (Level 30): Shows the first correct move." src="/img/hp2x.png"
					style="cursor: context-menu;" alt="Intuition"></a>
				';
				echo '
					<a href="#"><img id="rejuvenation" title="Rejuvenation (Level 40): Restores health, Intuition and locks." src="/img/hp3x.png"
					style="cursor: context-menu;" alt="Rejuvenation"></a>
				';
				echo '
					<a href="#"><img id="refinement" title="Refinement (Level 100 or Premium): Gives you a chance to solve a golden tsumego. If you fail, it disappears." src="/img/hp4x.png"
					style="cursor: context-menu;" alt="Refinement"></a>
				';
			}
		?>
	</td>
	</tr>
	</table>
	<?php
		$xpDisplayTableWidth = 70;
		if($corner=='t' || $corner=='b') $xpDisplayTableWidth = 79;
		if($corner=='tl' || $corner=='tr' || $corner=='bl' || $corner=='br') $xpDisplayTableWidth = 55;
	?>

	<div align="center">
		<table class="xpDisplayTable" border="0" width="<?php echo $xpDisplayTableWidth; ?>%">
			<tr>
			<td width="33%">
				<?php if($mode!=3){ ?>
				<div id="xpDisplay" align="center">
					<font size="4" color="<?php echo $xpDisplayColor; ?>"></font>
				</div>
				<?php }else{ ?>
				<div id="xpDisplay" align="center"></div>
				<div id="time-mode-countdown">
					10.0
				</div>
				<div id="plus2">+2</div>
				<?php } ?>
			</td>
			<td width="33%">
				<div id="status" align="center" style="color:black;"></div>
			</td>
			<td width="33%">
				<div id="status2" align="center" style="color:black;">
				<font size="4">
				<?php
				if($t['Tsumego']['userWin']!=0){
					if($t['Tsumego']['userWin']>=0 && $t['Tsumego']['userWin']<=22) $tRank='5d';
					elseif($t['Tsumego']['userWin']<=26.5) $tRank='4d';
					elseif($t['Tsumego']['userWin']<=30) $tRank='3d';
					elseif($t['Tsumego']['userWin']<=34) $tRank='2d';
					elseif($t['Tsumego']['userWin']<=38) $tRank='1d';
					elseif($t['Tsumego']['userWin']<=42) $tRank='1k';
					elseif($t['Tsumego']['userWin']<=46) $tRank='2k';
					elseif($t['Tsumego']['userWin']<=50) $tRank='3k';
					elseif($t['Tsumego']['userWin']<=54.5) $tRank='4k';
					elseif($t['Tsumego']['userWin']<=58.5) $tRank='5k';
					elseif($t['Tsumego']['userWin']<=63) $tRank='6k';
					elseif($t['Tsumego']['userWin']<=67) $tRank='7k';
					elseif($t['Tsumego']['userWin']<=70.8) $tRank='8k';
					elseif($t['Tsumego']['userWin']<=74.8) $tRank='9k';
					elseif($t['Tsumego']['userWin']<=79) $tRank='10k';
					elseif($t['Tsumego']['userWin']<=83.5) $tRank='11k';
					elseif($t['Tsumego']['userWin']<=88) $tRank='12k';
					elseif($t['Tsumego']['userWin']<=92) $tRank='13k';
					elseif($t['Tsumego']['userWin']<=96) $tRank='14k';
					else $tRank='15k';

					echo  $tRank.' <font color="grey">('.$t['Tsumego']['userWin'].'%)</font>';
					//echo '<img src="/img/questionmark.png" title="% of successful attempts">';
				}
				//echo '<pre>';print_r($t);echo '</pre>';
				?>
				</font>
				</div>
			</td>
			</tr>
		</table>
	</div>

	<?php if($dailyMaximum) echo '<style>.upgradeLink{display:block;}</style>'; ?>
	<div class="upgradeLink" align="center">
		<a href="/users/donate">Upgrade to Premium</a>
	</div>

	<!-- BOARD -->
	<?php if($ui==2){ ?>
		<br>
		<div id="target"></div>
		<div id="targetLockOverlay"></div>
	<?php }else{ ?>
		<div id="board" align="center"></div>
	<?php } ?>
	<div id="errorMessageOuter" align="center">
		<div id="errorMessage"></div>
	</div>
	<?php
		//SEMEAI START
		if($isSemeai && !$dailyMaximum){
			if($t['Tsumego']['status'] == 'setF2' || $t['Tsumego']['status'] == 'setX2'){
				$selectAEnabled = '';
				$selectBEnabled = '';
				$selectCEnabled = '';
				$selectDEnabled = '';
			}else{
				$selectAEnabled = 'selectA';
				$selectBEnabled = 'selectB';
				$selectCEnabled = 'selectC';
				$selectDEnabled = 'selectD';
			}
			echo '
				<table border="0" width="100%">
				<tr>
				<td width="36%">
				</td>
				<td style="text-align:top;">
				<table border="0">
				<tr>
				<td width="178px" style="white-space:nowrap;">
					<a id ="multipleChoice1" href="#" onclick="'.$selectAEnabled.'(); return false;">&nbsp;&nbsp;Black is dead&nbsp;&nbsp;</a>
					<br><br>
				</td>
				<td>
					<a id ="multipleChoice3" href="#" onclick="'.$selectCEnabled.'(); return false;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unsettled&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
					<br><br>
				</td>
				</tr>
				<tr>
				<td width="178px" style="white-space:nowrap;">
					<a id ="multipleChoice2" href="#" onclick="'.$selectBEnabled.'(); return false;">&nbsp;White is dead&nbsp;&nbsp;</a>
				</td>
				<td>
					<a id ="multipleChoice4" href="#" onclick="'.$selectDEnabled.'(); return false;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Seki&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>

				</td>
				</tr>
				</table>


				</td>
				<td width="35%">
				</td>
				</tr>

				</table>
				<br>
			';
			$semeaiText = '';
			$wrongChoiceStudyPart = 'document.getElementById("theComment").style.cssText = "display:block;border:thick double #e03c4b;";';
			if($t['Tsumego']['set_id']==159 || $t['Tsumego']['set_id']==161){
				$partArray = explode(';', $part);
				$semeaiText = 'document.getElementById("theComment").innerHTML = "'.$additionalInfo['semeaiText'].'";';
				$wrongChoiceStudyPart = '';
			}
			$correctChoice = '
				document.getElementById("multipleChoice1").style.cssText = "background-color:#ca6363;";
				document.getElementById("multipleChoice2").style.cssText = "background-color:#ca6363;";
				document.getElementById("multipleChoice3").style.cssText = "background-color:#ca6363;";
				document.getElementById("multipleChoice4").style.cssText = "background-color:#ca6363;";
				document.getElementById("status").style.color = "green";
				document.getElementById("status").innerHTML = "<h2>Correct!</h2>";
				document.getElementById("theComment").style.cssText = "display:block;border:thick double green;";
				document.getElementById("currentElement").style.backgroundColor = "green";
				'.$semeaiText.'
				$("#commentSpace").show();
				if(mode==3) document.cookie = "rank='.$mode3ScoreArray[0].'";
				if(mode==3) seconds = seconds.toFixed(1);
				if(mode==3) secondsy = seconds*10*'.$t['Tsumego']['id'].';
				if(mode==3) document.cookie = "seconds="+secondsy;
				if(mode==3) timeModeEnabled = false;
				if(mode==3) document.cookie = "score='.$score1.'";
				if(mode==3) document.cookie = "preId='.$t['Tsumego']['id'].'";
				if(mode==3) $("#time-mode-countdown").css("color","green");
				if(mode==3) runXPBar(true);
				if(!noXP){
					if(!doubleXP){
						x2 = "'.$score1.'";
						x3 = 1;
					}else{
						x2 = "'.$score2.'";
						x3 = 2;
					}
					if(goldenTsumego){
						x2 = "'.$score1.'";
						x3 = 1;
					}
					document.cookie = "score="+x2;
					document.getElementById("refreshLinkToStart").href = "/tsumegos/play/'.$lv.'?refresh=1";
					document.getElementById("refreshLinkToSets").href = "/tsumegos/play/'.$lv.'?refresh=2";
					if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/'.$lv.'?refresh=3";
					document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/'.$lv.'?refresh=4";
					document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/'.$lv.'?refresh=5";
					document.getElementById("refreshLinkToSandbox").href = "/tsumegos/play/'.$lv.'?refresh=6";
					xpReward = ('.$t['Tsumego']['difficulty'].'*x3) + '.$user['User']['xp'].';
					userNextlvl = '.$user['User']['nextlvl'].';
					ulvl = '.$user['User']['level'].';
					if(xpReward>userNextlvl){
						xpReward = userNextlvl;
						ulvl = ulvl + 1;
					}
					if(mode==1) runXPBar(true);
					if(mode==1) runXPNumber("account-bar-xp", '.$user['User']['xp'].', xpReward, 1000, ulvl);
					noXP = true;
				}
				document.cookie = "preId='.$t['Tsumego']['id'].'";
			';
			$wrongChoice = '
				document.getElementById("multipleChoice1").style.cssText = "background-color:#ca6363;";
				document.getElementById("multipleChoice2").style.cssText = "background-color:#ca6363;";
				document.getElementById("multipleChoice3").style.cssText = "background-color:#ca6363;";
				document.getElementById("multipleChoice4").style.cssText = "background-color:#ca6363;";
				document.getElementById("status").style.color = "#e03c4b";
				document.getElementById("status").innerHTML = "<h2>Incorrect</h2>";
				'.$wrongChoiceStudyPart.'
				if(mode==3) document.cookie = "rank='.$mode3ScoreArray[1].'";
				if(mode==3) locked = true;
				if(mode==3) tryAgainTomorrow = true;
				if(mode==3) document.cookie = "misplay=1";
				if(mode==3) seconds = seconds.toFixed(1);
				if(mode==3) secondsy = seconds*10*'.$t['Tsumego']['id'].';
				if(mode==3) document.cookie = "seconds="+secondsy;
				if(mode==3) timeModeEnabled = false;
				if(mode==3) $("#time-mode-countdown").css("color","#e45663");
				if(!noXP){
					misplays++;
					document.cookie = "misplay="+misplays;
					document.getElementById("refreshLinkToStart").href = "/tsumegos/play/'.$lv.'?refresh=1";
					document.getElementById("refreshLinkToSets").href = "/tsumegos/play/'.$lv.'?refresh=2";
					if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/'.$lv.'?refresh=3";
					document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/'.$lv.'?refresh=4";
					document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/'.$lv.'?refresh=5";
					document.getElementById("refreshLinkToSandbox").href = "/tsumegos/play/'.$lv.'?refresh=6";
					updateHealth();
					hoverLocked = false;
					if('.$health.' - misplays<0){
						document.getElementById("currentElement").style.backgroundColor = "#e03c4b";
						document.getElementById("status").innerHTML = "<h2>Try again tomorrow</h2>";
						tryAgainTomorrow = true;
						locked = true;
					}
				}
				document.cookie = "preId='.$t['Tsumego']['id'].'";
			';
			if($t['Tsumego']['set_id']==159){
				if($semeaiType == 1){
					$a1 = $correctChoice;
					$b1 = $wrongChoice;
					$c1 = $wrongChoice;
					$d1 = $wrongChoice;
					$multipleChoiceCorrect = 'document.getElementById("multipleChoice1").style.cssText = "background-color:#60c982;";';
				}elseif($semeaiType == 2){
					$a1 = $wrongChoice;
					$b1 = $correctChoice;
					$c1 = $wrongChoice;
					$d1 = $wrongChoice;
					$multipleChoiceCorrect = 'document.getElementById("multipleChoice2").style.cssText = "background-color:#60c982;";';
				}elseif($semeaiType == 3){
					$a1 = $wrongChoice;
					$b1 = $wrongChoice;
					$c1 = $correctChoice;
					$d1 = $wrongChoice;
					$multipleChoiceCorrect = 'document.getElementById("multipleChoice3").style.cssText = "background-color:#60c982;";';
				}else{
					$a1 = $wrongChoice;
					$b1 = $wrongChoice;
					$c1 = $wrongChoice;
					$d1 = $correctChoice;
					$multipleChoiceCorrect = 'document.getElementById("multipleChoice4").style.cssText = "background-color:#60c982;";';
				}
			}else{
				if($semeaiType == 1){
					if($whiteLiberties > $blackLiberties){
						$a1 = $correctChoice;
						$b1 = $wrongChoice;
						$c1 = $wrongChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice1").style.cssText = "background-color:#60c982;";';
						$sum1 = $whiteLiberties - $blackLiberties;
						$sum2 = '';
						if($sum1>1) $sum2 = 's';
						$x1 = 'Black is dead. ('.$sum1.' move'.$sum2.' behind)';
					}
					if($whiteLiberties < $blackLiberties){
						$a1 = $wrongChoice;
						$b1 = $correctChoice;
						$c1 = $wrongChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice2").style.cssText = "background-color:#60c982;";';
						$sum1 = $blackLiberties - $whiteLiberties;
						$sum2 = '';
						if($sum1>1) $sum2 = 's';
						$x1 = 'White is dead. ('.$sum1.' move'.$sum2.' behind)';
					}
					if($whiteLiberties == $blackLiberties){
						$a1 = $wrongChoice;
						$b1 = $wrongChoice;
						$c1 = $correctChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice3").style.cssText = "background-color:#60c982;";';
						$x1 = 'The position is unsettled. (whoever plays first wins)';
					}
					$x2 = '
						document.getElementById("theComment").innerHTML =
						"Semeai Type 1: No eyes, less than 2 inside liberties.<br>No Seki possible.<br> Black has '
						.$blackLiberties.' liberties.<br> White has '
						.$whiteLiberties.' liberties.<br>'
						.$x1.'";
					';
				}else if($semeaiType == 2){
					$x3='';
					$bx1 = '';
					$wx1 = '';
					if($blackLiberties > $whiteLiberties){
						$fav = 'Black is the favorite with more outside liberties.';
						$blackLibertiesBefore = $blackLiberties;
						$blackLiberties += 1;
						$whiteLibertiesBefore = $whiteLiberties;
						$whiteLiberties += $insideLiberties;
						$bx1 = 'favorite: '.$blackLibertiesBefore.' outside + 1 inside.';
						$wx1 = 'underdog: '.$whiteLibertiesBefore.' outside + '.$insideLiberties.' inside.';
					}
					else if($whiteLiberties > $blackLiberties){
						$fav = 'White is the favorite with more outside liberties.';
						$whiteLibertiesBefore = $whiteLiberties;
						$whiteLiberties += 1;
						$blackLibertiesBefore = $blackLiberties;
						$blackLiberties += $insideLiberties;
						$bx1 = 'underdog: '.$blackLibertiesBefore.' outside + '.$insideLiberties.' inside.';
						$wx1 = 'favorite: '.$whiteLibertiesBefore.' outside + 1 inside.';
					}
					else{
						$fav = 'Seki - same amount of liberties.';
						$a1 = $wrongChoice;
						$b1 = $wrongChoice;
						$c1 = $wrongChoice;
						$d1 = $correctChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice4").style.cssText = "background-color:#60c982;";';
					}
					if($whiteLiberties > $blackLiberties){
						$bwSum = $whiteLiberties - $blackLiberties;
						$plural = '';
						if($bwSum>1) $plural='s';

						if($fav == 'Black is the favorite with more outside liberties.'){
							$x1='Seki. (Black is '.$bwSum.' move'.$plural.' behind for killing)';
							$a1 = $wrongChoice;
							$b1 = $wrongChoice;
							$c1 = $wrongChoice;
							$d1 = $correctChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice4").style.cssText = "background-color:#60c982;";';
						}else{
							$x1='Black is dead. ('.$bwSum.' move'.$plural.' behind)';
							$a1 = $correctChoice;
							$b1 = $wrongChoice;
							$c1 = $wrongChoice;
							$d1 = $wrongChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice1").style.cssText = "background-color:#60c982;";';
						}
					}
					if($whiteLiberties < $blackLiberties){
						$bwSum = $blackLiberties - $whiteLiberties;
						$plural = '';
						if($bwSum>1) $plural='s';
						if($fav == 'White is the favorite with more outside liberties.'){
							$x1='Seki. (White is '.$bwSum.' move'.$plural.' behind for killing)';
							$a1 = $wrongChoice;
							$b1 = $wrongChoice;
							$c1 = $wrongChoice;
							$d1 = $correctChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice4").style.cssText = "background-color:#60c982;";';
						}else{
							$x1='White is dead. ('.$bwSum.' move'.$plural.' behind)';
							$a1 = $wrongChoice;
							$b1 = $correctChoice;
							$c1 = $wrongChoice;
							$d1 = $wrongChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice2").style.cssText = "background-color:#60c982;";';
						}
					}
					if($whiteLiberties==$blackLiberties && $fav!='Seki - same amount of liberties.'){
						$x1='Unsettled. (whoever plays first accomplishes his task)';
						$a1 = $wrongChoice;
						$b1 = $wrongChoice;
						$c1 = $correctChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice3").style.cssText = "background-color:#60c982;";';
					}

					if($fav != 'Seki - same amount of liberties'){
						$x3 = 'Black has '.$blackLiberties.' liberties. ('.$bx1.')<br> White has '.$whiteLiberties.' liberties. ('.$wx1.')<br>'.$x1;
					}
					$x2 = '
						document.getElementById("theComment").innerHTML =
						"Semeai Type 2: No eyes, 2 or more inside liberties.<br>The favorite\'s task is to kill.<br>The favorite counts his outside liberties plus 1 inside liberty.<br>The underdog\'s task is Seki.<br>The underdog counts his outside liberties plus all inside liberties.<br>'
						.$fav.' <br> '
						.$x3.'";
					';
				}else if($semeaiType == 3){
					if($whiteLiberties > $blackLiberties){
						$a1 = $correctChoice;
						$b1 = $wrongChoice;
						$c1 = $wrongChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice1").style.cssText = "background-color:#60c982;";';
						$sum1 = $whiteLiberties - $blackLiberties;
						$sum2 = '';
						if($sum1>1) $sum2 = 's';
						$x1 = 'Black is dead. ('.$sum1.' move'.$sum2.' behind)';
					}
					if($whiteLiberties < $blackLiberties){
						$a1 = $wrongChoice;
						$b1 = $correctChoice;
						$c1 = $wrongChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice2").style.cssText = "background-color:#60c982;";';
						$sum1 = $blackLiberties - $whiteLiberties;
						$sum2 = '';
						if($sum1>1) $sum2 = 's';
						$x1 = 'White is dead. ('.$sum1.' move'.$sum2.' behind)';
					}
					if($whiteLiberties == $blackLiberties){
						$a1 = $wrongChoice;
						$b1 = $wrongChoice;
						$c1 = $correctChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice3").style.cssText = "background-color:#60c982;";';
						$x1 = 'The position is unsettled. (whoever plays first wins)';
					}
					$x2 = '
						document.getElementById("theComment").innerHTML =
						"Semeai Type 3: Eye vs no eye.<br>No Seki possible.<br> All inside liberties count for the group with the eye.<br> Black has '
						.$blackLiberties.' liberties.<br> White has '
						.$whiteLiberties.' liberties.<br>'
						.$x1.'";
					';
				}else if($semeaiType == 4){
					$x3='';
					$bx1 = '';
					$wx1 = '';
					if($blackLiberties > $whiteLiberties){
						$fav = 'Black is the favorite with more exclusive liberties.<br>';
						$blackLibertiesBefore = $blackLiberties;
						$whiteLibertiesBefore = $whiteLiberties;
						$whiteLiberties += $insideLiberties;
						$bx1 = 'favorite: '.$blackLibertiesBefore.' exclusive liberties';
						$wx1 = 'underdog: '.$whiteLibertiesBefore.' exclusive + '.$insideLiberties.' inside';
					}else if($whiteLiberties > $blackLiberties){
						$fav = 'White is the favorite with more exclusive liberties.<br>';
						$whiteLibertiesBefore = $whiteLiberties;
						$blackLibertiesBefore = $blackLiberties;
						$blackLiberties += $insideLiberties;
						$bx1 = 'underdog: '.$blackLibertiesBefore.' exclusive + '.$insideLiberties.' inside';
						$wx1 = 'favorite: '.$whiteLibertiesBefore.' exclusive liberties';
					}else{
						$fav = 'Seki - same amount of liberties.<br>';
						$a1 = $wrongChoice;
						$b1 = $wrongChoice;
						$c1 = $wrongChoice;
						$d1 = $correctChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice4").style.cssText = "background-color:#60c982;";';
					}
					if($whiteLiberties > $blackLiberties){
						$bwSum = $whiteLiberties - $blackLiberties;
						$plural = '';
						if($bwSum>1) $plural='s';

						if($fav == 'Black is the favorite with more exclusive liberties.<br>'){
							$x1='Seki. (Black is '.$bwSum.' move'.$plural.' behind for killing)';
							$a1 = $wrongChoice;
							$b1 = $wrongChoice;
							$c1 = $wrongChoice;
							$d1 = $correctChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice4").style.cssText = "background-color:#60c982;";';
						}else{
							$x1='Black is dead. ('.$bwSum.' move'.$plural.' behind)';
							$a1 = $correctChoice;
							$b1 = $wrongChoice;
							$c1 = $wrongChoice;
							$d1 = $wrongChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice1").style.cssText = "background-color:#60c982;";';
						}
					}
					if($whiteLiberties < $blackLiberties){
						$bwSum = $blackLiberties - $whiteLiberties;
						$plural = '';
						if($bwSum>1) $plural='s';
						if($fav == 'White is the favorite with more exclusive liberties.<br>'){
							$x1='Seki. (White is '.$bwSum.' move'.$plural.' behind for killing)';
							$a1 = $wrongChoice;
							$b1 = $wrongChoice;
							$c1 = $wrongChoice;
							$d1 = $correctChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice4").style.cssText = "background-color:#60c982;";';
						}else{
							$x1='White is dead. ('.$bwSum.' move'.$plural.' behind)';
							$a1 = $wrongChoice;
							$b1 = $correctChoice;
							$c1 = $wrongChoice;
							$d1 = $wrongChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice2").style.cssText = "background-color:#60c982;";';
						}
					}
					if($whiteLiberties==$blackLiberties && $fav!='Seki - same amount of liberties.<br>'){
						$x1='Unsettled. (whoever plays first accomplishes his task)';
						$a1 = $wrongChoice;
						$b1 = $wrongChoice;
						$c1 = $correctChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice3").style.cssText = "background-color:#60c982;";';
					}

					if($fav != 'Seki - same amount of liberties.<br>'){
						$x3 = 'Black has '.$blackLiberties.' liberties. ('.$bx1.')<br> White has '.$whiteLiberties.' liberties. ('.$wx1.')<br>'.$x1;
						if($insideLiberties==0){
							$x3 = 'Black has '.$blackLiberties.' liberties. <br> White has '.$whiteLiberties.' liberties. <br>'.$x1;
						}
					}else{
						if($insideLiberties==0){
							$x1='Unsettled. (whoever plays first wins)';
							$a1 = $wrongChoice;
							$b1 = $wrongChoice;
							$c1 = $correctChoice;
							$d1 = $wrongChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice3").style.cssText = "background-color:#60c982;";';
							$x3 = 'Black has '.$blackLiberties.' liberties. <br> White has '.$whiteLiberties.' liberties. <br>'.$x1;
						}
					}
					if($insideLiberties==0){
						$x5 = 'No Seki possible because there are no inside liberties.<br>';
						$fav = '';
					}else{
						$x5 = 'Seki possible if there is one or more inside liberties.<br>The favorite\'s task is to kill.<br>The favorite counts his exclusive liberties.<br>The underdog\'s task is Seki.<br>The underdog counts his exclusive plus all inside liberties.<br>';
					}
					$x2 = '
						document.getElementById("theComment").innerHTML =
						"Semeai Type 4: Same sized big eyes.<br>'.$x5.''
						.$fav.''
						.$x3.'";
					';
				}else if($semeaiType == 5){
					if($whiteLiberties > $blackLiberties){
						$a1 = $correctChoice;
						$b1 = $wrongChoice;
						$c1 = $wrongChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice1").style.cssText = "background-color:#60c982;";';
						$sum1 = $whiteLiberties - $blackLiberties;
						$sum2 = '';
						if($sum1>1) $sum2 = 's';
						$x1 = 'Black is dead. ('.$sum1.' move'.$sum2.' behind)';
					}
					if($whiteLiberties < $blackLiberties){
						$a1 = $wrongChoice;
						$b1 = $correctChoice;
						$c1 = $wrongChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice2").style.cssText = "background-color:#60c982;";';
						$sum1 = $blackLiberties - $whiteLiberties;
						$sum2 = '';
						if($sum1>1) $sum2 = 's';
						$x1 = 'White is dead. ('.$sum1.' move'.$sum2.' behind)';
					}
					if($whiteLiberties == $blackLiberties){
						$a1 = $wrongChoice;
						$b1 = $wrongChoice;
						$c1 = $correctChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice3").style.cssText = "background-color:#60c982;";';
						$x1 = 'The position is unsettled. (whoever plays first wins)';
					}
					$x2 = '
						document.getElementById("theComment").innerHTML =
						"Semeai Type 5: Big eye vs smaller eye.<br>No Seki possible.<br> All inside liberties count for the group with the bigger eye.<br> Black has '
						.$blackLiberties.' liberties.<br> White has '
						.$whiteLiberties.' liberties.<br>'
						.$x1.'";
					';
				}else if($semeaiType == 6){
					$x3='';
					$bx1 = '';
					$wx1 = '';
					if($blackLiberties > $whiteLiberties){
						$fav = 'Black is the favorite with more exclusive liberties.<br>';
						$blackLibertiesBefore = $blackLiberties;
						$whiteLibertiesBefore = $whiteLiberties;
						$whiteLiberties += $insideLiberties;
						$bx1 = 'favorite: '.$blackLibertiesBefore.' exclusive liberties';
						$wx1 = 'underdog: '.$whiteLibertiesBefore.' exclusive + '.$insideLiberties.' inside';
					}else if($whiteLiberties > $blackLiberties){
						$fav = 'White is the favorite with more exclusive liberties.<br>';
						$whiteLibertiesBefore = $whiteLiberties;
						$blackLibertiesBefore = $blackLiberties;
						$blackLiberties += $insideLiberties;
						$bx1 = 'underdog: '.$blackLibertiesBefore.' exclusive + '.$insideLiberties.' inside';
						$wx1 = 'favorite: '.$whiteLibertiesBefore.' exclusive liberties';
					}else{
						$fav = 'Seki - same amount of liberties.<br>';
						$a1 = $wrongChoice;
						$b1 = $wrongChoice;
						$c1 = $wrongChoice;
						$d1 = $correctChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice4").style.cssText = "background-color:#60c982;";';
					}
					if($whiteLiberties > $blackLiberties){
						$bwSum = $whiteLiberties - $blackLiberties;
						$plural = '';
						if($bwSum>1) $plural='s';

						if($fav == 'Black is the favorite with more exclusive liberties.<br>'){
							$x1='Seki. (Black is '.$bwSum.' move'.$plural.' behind for killing)';
							$a1 = $wrongChoice;
							$b1 = $wrongChoice;
							$c1 = $wrongChoice;
							$d1 = $correctChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice4").style.cssText = "background-color:#60c982;";';
						}else{
							$x1='Black is dead. ('.$bwSum.' move'.$plural.' behind)';
							$a1 = $correctChoice;
							$b1 = $wrongChoice;
							$c1 = $wrongChoice;
							$d1 = $wrongChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice1").style.cssText = "background-color:#60c982;";';
						}
					}
					if($whiteLiberties < $blackLiberties){
						$bwSum = $blackLiberties - $whiteLiberties;
						$plural = '';
						if($bwSum>1) $plural='s';
						if($fav == 'White is the favorite with more exclusive liberties.<br>'){
							$x1='Seki. (White is '.$bwSum.' move'.$plural.' behind for killing)';
							$a1 = $wrongChoice;
							$b1 = $wrongChoice;
							$c1 = $wrongChoice;
							$d1 = $correctChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice4").style.cssText = "background-color:#60c982;";';
						}else{
							$x1='White is dead. ('.$bwSum.' move'.$plural.' behind)';
							$a1 = $wrongChoice;
							$b1 = $correctChoice;
							$c1 = $wrongChoice;
							$d1 = $wrongChoice;
							$multipleChoiceCorrect = 'document.getElementById("multipleChoice2").style.cssText = "background-color:#60c982;";';
						}
					}
					if($whiteLiberties==$blackLiberties && $fav!='Seki - same amount of liberties.<br>'){
						$x1='Unsettled. (whoever plays first accomplishes his task)';
						$a1 = $wrongChoice;
						$b1 = $wrongChoice;
						$c1 = $correctChoice;
						$d1 = $wrongChoice;
						$multipleChoiceCorrect = 'document.getElementById("multipleChoice3").style.cssText = "background-color:#60c982;";';
					}

					if($fav != 'Seki - same amount of liberties.<br>'){
						$x3 = 'Black has '.$blackLiberties.' liberties. ('.$bx1.')<br> White has '.$whiteLiberties.' liberties. ('.$wx1.')<br>'.$x1;
					}
					$x5 = 'Seki possible if there is one or more inside liberties.<br>The favorite\'s task is to kill.<br>The favorite counts his exclusive liberties.<br>The underdog\'s task is Seki.<br>The underdog counts his exclusive plus all inside liberties.<br>';
					$x2 = '
						document.getElementById("theComment").innerHTML =
						"Semeai Type 6: Small eye vs small eye.<br>'.$x5.''
						.$fav.$x3.'";
					';
				}

			}
		}
		//SEMEAI END

	if($mode==1 || $mode==3){
		$naviAdjust1 = 38;
	}elseif($mode==2){
		$naviAdjust1 = 25;
	}
	?>
	<div align="center">
		<div id="theComment" >

		</div>
	</div>
	<?php if($ui!=2){ ?>
	<table width="100%" border="0">
	<tr>
	<td width="<?php echo $naviAdjust1; ?>%" align="right">
	<?php if($firstRanks==0){ ?>
		<div class="tsumegoNavi-left">
		<?php
			if(isset($_SESSION['loggedInUser'])){
			if($mode==1 || $mode==3) $vf = '';
			elseif($mode==2) $vf = 'style="visibility:hidden"';
		?>

		<form class="favCheckbox" <?php echo $vf; ?>>
		<input type="checkbox" id="favCheckbox" name="favCheckbox" value="1" <?php if($favorite) echo 'checked="checked"'; ?>>
		<label for="favCheckbox" id="favCheckbox2" <?php if(!$favorite) echo 'title="Mark as favorite"'; else echo 'title="Marked as favorite"'; ?>  onclick="selectFav();"></label>
		</form>
		<?php }
		if(!$hasAnyFavorite){
		if(isset($_SESSION['loggedInUser'])){ ?>
	<div id="ans2">
	</div>
	<?php }} ?>

		<?php
			//if($t['Tsumego']['status']=='setS2' || $t['Tsumego']['status']=='setC2'){
			if($mode==1 || $mode==3){
				$opacityB = 1;
				$opacityW = 1;
				$opacityT = .5;
				$opacityBO = .5;
				$opacityTL = .5;
				$opacityTR = .5;
				$opacityBL = .5;
				$opacityBR = .5;
				if($orientation==null){
					$orientation = '';
					if($corner=='t') $opacityT = 1;
					elseif($corner=='b') $opacityBO = 1;
					elseif($corner=='tl') $opacityTL = 1;
					elseif($corner=='tr') $opacityTR = 1;
					elseif($corner=='bl') $opacityBL = 1;
					elseif($corner=='br') $opacityBR = 1;
				}else{
					if($orientation=='top') $opacityT = 1;
					elseif($orientation=='bottom') $opacityBO = 1;
					elseif($orientation=='topleft') $opacityTL = 1;
					elseif($orientation=='topright') $opacityTR = 1;
					elseif($orientation=='bottomleft') $opacityBL = 1;
					elseif($orientation=='bottomright') $opacityBR = 1;
					$orientation = '&orientation='.$orientation;
				}
				if($colorOrientation==null){
					$colorOrientation = '';
					if($pl==0){
						echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'?playercolor=white'.$orientation.'"><img src="/img/colorOrientationB.png" style="padding:5px 1px 0 1px;opacity:'.$opacityB.';"></a>';
					}elseif($pl==1){
						echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'?playercolor=black'.$orientation.'"><img src="/img/colorOrientationW.png" style="padding:5px 1px 0 1px;opacity:'.$opacityB.';"></a>';
					}
				}else{
					if($colorOrientation=='black'){
						echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'?playercolor=white'.$orientation.'"><img src="/img/colorOrientationB.png" style="padding:5px 1px 0 1px;opacity:'.$opacityB.';"></a>';
					}elseif($colorOrientation=='white'){
						echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'?playercolor=black'.$orientation.'"><img src="/img/colorOrientationW.png" style="padding:5px 1px 0 1px;opacity:'.$opacityB.';"></a>';
					}
					$colorOrientation = '&playercolor='.$colorOrientation;
				}
				if($corner=='t' || $corner=='b'){
					echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'?orientation=top'.$colorOrientation.'"><img src="/img/boardOrientationT.png" style="padding:5px 1px 0 1px;opacity:'.$opacityT.';"></a>';
					echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'?orientation=bottom'.$colorOrientation.'"><img src="/img/boardOrientationB.png" style="padding:5px 0 0 1px;opacity:'.$opacityBO.';"></a>';
				}
				elseif($corner=='tl' || $corner=='tr' || $corner=='bl' || $corner=='br'){
					echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'?orientation=bottomleft'.$colorOrientation.'"><img src="/img/boardOrientationBL.png" style="padding:5px 1px 0 1px;opacity:'.$opacityBL.';"></a>';
					echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'?orientation=topleft'.$colorOrientation.'"><img src="/img/boardOrientationTL.png" style="padding:5px 1px 0 1px;opacity:'.$opacityTL.';"></a>';
					echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'?orientation=bottomright'.$colorOrientation.'"><img src="/img/boardOrientationBR.png" style="padding:5px 0 0 1px;opacity:'.$opacityBR.';"></a>';
					echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'?orientation=topright'.$colorOrientation.'"><img src="/img/boardOrientationTR.png" style="padding:5px 1px 0 1px;opacity:'.$opacityTR.';"></a>';
				}
			}
		?>
		</div>
	<?php } ?>
	</td>
	<td width="24%" align="center" height="40px">
	<?php if($firstRanks==0){ ?>
	<div class="tsumegoNavi-middle">
		<?php
		//BUTTONS
		if($prev!=0) echo '<a class="new-button" href="/tsumegos/play/'.$prev.$inFavorite.'">Back</a>';
		else echo '<a class="new-button-inactive" >Back</a>';

		if($isSemeai){
			echo '<a class="new-button" href="/tsumegos/play/'.$t['Tsumego']['id'].'">Reset</a>';
		}else{
			echo '<a id="resetButton" class="new-button" href="#" onclick="reset(); return false;">Reset</a>';
			echo '<a id="reviewButton" class="new-button-red" href="#" onclick="review(); return false;">Review</a>';
		}
		if($next!=0) echo '<a class="new-button" href="/tsumegos/play/'.$next.$inFavorite.'">Next</a>';
		else echo '<a class="new-button-inactive" >Next</a>';
		?>
	</div>
	<div class="tsumegoNavi-middle2">
		<?php
		//BUTTONS
		echo '<a class="new-button" target="_blank" href="/tsumego_rating_attempts/user/'.$_SESSION['loggedInUser']['User']['id'].'" >History</a>';
		echo '<a id="resetButton" class="new-button" href="#" onclick="reset(); return false;">Reset</a>';
		echo '<a id="reviewButton2" class="new-button-red" href="#" onclick="review(); return false;">Review</a>';
		if($user['User']['readingTrial']<=0){
			echo '<a class="new-button-inactive" id="skipButton" >Skip(0)</a>';
		}else{
			echo '<a class="new-button" id="skipButton" onclick="skip(); return false;" href="/tsumegos/play/'.$nextMode['Tsumego']['id'].'">Skip('.$user['User']['readingTrial'].')</a>';
		}


		?>
	</div>
	<?php }else{ ?>

		<div class="tsumegoNavi-middle">
			<?php
			//BUTTONS

				echo '<a id="reviewButton" class="new-button-red" href="#" onclick="review(); return false;">Review</a>';
				echo '<a id="reviewButton-inactive" class="new-button-inactive" href="#">Review</a>';
				echo '<a class="new-button" href="/tsumegos/play/'.$next.'">Next</a>';
			?>
		</div>

	<?php } ?>
	</td>
	<td width="10%">
	<?php if($firstRanks==0){ ?>
		<div class="tsumegoNavi-right">
		<?php
			if(isset($_SESSION['loggedInUser'])){
				if($mode==1 || $mode==0){//not mode 3
					$repThumbsDown = 'id="thumbs-down" onmouseover="thumbsDownHover()" onmouseout="thumbsDownNoHover()" onclick="thumbsDown();" width="32px" height="32px"';
					$repThumbsUp = 'id="thumbs-up" onmouseover="thumbsUpHover()" onmouseout="thumbsUpNoHover()" onclick="thumbsUp();" width="32px" height="32px"';
					if(isset($rep['Reputation']['value'])){
						if($rep['Reputation']['value']==1){
							echo '<img src="/img/thumbs-up.png" '.$repThumbsUp.'> <img src="/img/thumbs-down-inactive.png" '.$repThumbsDown.'>';
						}else if($rep['Reputation']['value']==-1){
							echo '<img src="/img/thumbs-up-inactive.png" '.$repThumbsUp.'> <img src="/img/thumbs-down.png" '.$repThumbsDown.'>';
						}else{
							echo '<img src="/img/thumbs-up-inactive.png" '.$repThumbsUp.'> <img src="/img/thumbs-down-inactive.png" '.$repThumbsDown.'>';
						}
					}else{
						echo '<img src="/img/thumbs-up-inactive.png" '.$repThumbsUp.'> <img src="/img/thumbs-down-inactive.png" '.$repThumbsDown.'>';
					}
				}
			}
		//<div class="author-notice" style="">asdf</div>
		?>

		</div>
	<?php } ?>
	</td>
	<td width="28%">
		<?php
		if($t['Tsumego']['author']!=''){
				$author = '<div class="author-notice" style="">File by '.$t['Tsumego']['author'].'</div>';
			}else $author = '';
			echo $author;
		?>
	</td>
	</tr>
	</table>
	<?php } ?>
	<div align="center">

	<?php if($firstRanks!=0){ ?>
	<!--
	<input type="radio" id="t1" name="fav_language" value="1" onchange="txx(1);">
	<label for="t1">next</label>


	<input type="radio" id="t2" name="fav_language" value="2" onchange="txx(2);">
	<label for="t2">reset</label><br>
	-->
	<?php } ?>

	<?php
		//if($mode==2) echo 'mode 2';
		//elseif($mode==3) echo 'mode 3';
		//else echo 'mode 1';
	?>
	</div>
	<?php if($firstRanks==0){ ?>
	<div class="tsumegoNavi1">
		<div class="tsumegoNavi2">
			<?php
			$josekiThumb = '';
			$josekiThumb2 = '';
			$josekiButton = '';
			$josekiHeight = '';
			for($i=0; $i<count($navi); $i++){
				if($set['Set']['id']==161){
					$jt = 'josekiThumb1.png';
					if($navi[$i]['Tsumego']['type']==1) $jt = 'josekiThumb1.png';
					elseif($navi[$i]['Tsumego']['type']==2) $jt = 'josekiThumb2.png';
					if($navi[$i]['Tsumego']['num']!='') $jx = '<img src="/img/'.$jt.'" width="45px">';
					else $jx = '';
					$josekiThumb = '<br>'.$jx.'<span id="tooltip-span"><img width="200px" alt="" src="/img/thumbs/'.$navi[$i]['Tsumego']['thumbnail'].'.PNG"/></span>';
					$josekiThumb2 = 'class="tooltip"';
					if($navi[$i]['Tsumego']['num']!='') $josekiButton = 'style="height:71px;background-image: url(\'/img/viewButton3.png\');"';

				}
				if($t['Tsumego']['id'] == $navi[$i]['Tsumego']['id']) $additionalId = 'id="currentElement"';
				else $additionalId = '';
				echo '<li '.$additionalId.$josekiButton.' id="naviElement'.$i.'" class="'.$navi[$i]['Tsumego']['status'].'">
					<a '.$josekiThumb2.' href="/tsumegos/play/'.$navi[$i]['Tsumego']['id'].$inFavorite.'">'.$navi[$i]['Tsumego']['num'].$josekiThumb.'</a></li>';
				if($i==0 || $i==count($navi)-2) echo '<li class="setBlank"><a></a></li>';
			}
			?>
		</div>
	</div>
	<?php }else{
		echo '<div id="currentElement"></div>';
	}		?>
	<div align="center">
	<?php if($activate){
	if(isset($_SESSION['loggedInUser'])){
	if($_SESSION['loggedInUser']['User']['isAdmin']>0){
		?>
		<div class="mode1">
			<table>
			<tr>
			<td>
			<div class="modeSwitcher" id="modeSwitcher1" onmouseover="m1hover()" onmouseout="m1noHover()">
				<input type="radio" id="ms1" name="ms" value="1" onchange="modeCheckbox(1);">
				<label for="ms1">jGoBoard</label>
			</div>
			<div class="modeSwitcher" id="modeSwitcher2" onmouseover="m2hover()" onmouseout="m2noHover()">
				<input type="radio" id="ms2" name="ms" value="2" onchange="modeCheckbox(2);">
				<label for="ms2">BesoGo</label>
			</div>
			</td>
			</tr>
			</table>
		</div>
		<?php
	}
	}
	}
	
	//echo '<pre>';print_r($allUts);echo '</pre>';
	//echo '<pre>'; print_r($nextMode); echo '</pre>';
	//echo '<pre>'; print_r($nextMode3); echo '</pre>';
	//echo '<pre>'; print_r($t); echo '</pre>';
	//echo 'u '.$user['User']['elo_rating_mode'].'<br>';
	//echo '<pre>'; print_r($masterArray); echo '</pre>';
	//echo '<pre>'; print_r($_SESSION['loggedInUser']['User']['name']); echo '</pre>';
	//echo '<pre>'; print_r($enabledBoards); echo '</pre>'; 
	//echo '<pre>'; print_r($boardPositions); echo '</pre>'; 
	//echo '<pre>'; print_r($choice); echo '</pre>'; 
	//echo '<pre>'; print_r($file); echo '</pre>';
	if(isset($_SESSION['loggedInUser'])){
		if($firstRanks==0){
			if(($t['Tsumego']['status']=='setS2' || $t['Tsumego']['status']=='setC2' || $t['Tsumego']['status']=='setW2') || $_SESSION['loggedInUser']['User']['isAdmin']==1 || $isSandbox){
					$getTitle = str_replace('&','and',$set['Set']['title']);
					echo '<a href="/download.php?key='.$hash.'&title='.$getTitle.'" class="selectable-text">Download SGF</a><br><br>';
			}
			if($_SESSION['loggedInUser']['User']['isAdmin']==1){
				echo '<a href="/download.php?key='.$hash.'&title=" style="margin-right:20px;" class="selectable-text">Admin-Download SGF</a>';
					echo '<a id="show4" class="selectable-text">Admin-Upload SGF<img id="greyArrow4" src="/img/greyArrow1.png"></a>';
					echo '
						<div id="msg4">
							<br>
							<form action="" method="POST" enctype="multipart/form-data">
								<input type="file" name="adminUpload" />
								<input value="Submit" type="submit"/>
							</form>
						</div>
						<br><br>
					';
				if($t['Tsumego']['set_id']==159 && $isSemeai){
					echo $this->Form->create('Study');
					echo $this->Form->input('study1', array('value' => 'Black is dead', 'label' => '', 'type' => 'text', 'placeholder' => 'field 1'));
					echo $this->Form->input('study2', array('value' => 'White is dead', 'label' => '', 'type' => 'text', 'placeholder' => 'field 2'));
					echo $this->Form->input('study3', array('value' => 'Seki', 'label' => '', 'type' => 'text', 'placeholder' => 'field 3'));
					echo $this->Form->input('study4', array('value' => 'Ko', 'label' => '', 'type' => 'text', 'placeholder' => 'field 4'));
					echo $this->Form->input('studyCorrect', array('value' => '4', 'label' => '', 'type' => 'text', 'placeholder' => 'correct field'));
					echo $this->Form->end('Submit');
					echo '<br><br>';
				}
			}else echo '<br>';
			//if($_SESSION['loggedInUser']['User']['premium']>=1){
			//if($t['Tsumego']['set_id']!=122 && $t['Tsumego']['set_id']!=124 && $t['Tsumego']['set_id']!=127 && $t['Tsumego']['set_id']!=139){
			if($t['Tsumego']['set_id']!=42){
				echo '<div id="msg1">Leave a <a id="show">message<img id="greyArrow1" src="/img/greyArrow1.png"></a></div>';
			}
			echo '<br>';
			echo '<div id="msg2">';
			echo $this->Form->create('Comment');
			echo $this->Form->input('tsumego_id', array('type' => 'hidden', 'value' => $t['Tsumego']['id']));
			echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $user['User']['id']));
			echo $this->Form->input('message', array('label' => '', 'type' => 'textarea', 'placeholder' => 'Message'));
			echo $this->Form->end('Submit');

		?>
		<br>
			<a id="show3">Upload SGF<img id="greyArrow2" src="/img/greyArrow1.png"></a>
			<div id="msg3">
				<br>
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="file" name="game" />
					<input value="Submit" type="submit"/>
				</form>
			</div>
		</div>
		<?php }
		if($firstRanks==0){
		?>


		<table class="sandboxTable" width="62%">
		<tr>
		<td>
		<?php
		echo '<div id="commentSpace">';
			$showComment2 = array();
			$showComment3 = array();

			for($i=0; $i<count($showComment); $i++){
				if(is_numeric($showComment[$i]['Comment']['status'])) $showComment[$i]['Comment']['textAnswer'] = 'false';
				else{
					$showComment[$i]['Comment']['textAnswer'] = $showComment[$i]['Comment']['status'];
					$showComment[$i]['Comment']['status'] = 100;
				}
				if($showComment[$i]['Comment']['status']!=99) array_push($showComment2, $showComment[$i]);
			}
			$showComment = $showComment2;
			$resolvedCommentCount = 0;

			if(count($showComment)>0) echo '<div id="msg1x"><a id="show2">Comments<img id="greyArrow" src="/img/greyArrow2.png"></a></div><br>';
				echo '<div id="msg2x">';
			for($i=count($showComment)-1; $i>=0; $i--){
					$commentColorCheck = false;
					for($a=0; $a<count($admins); $a++){
						if($showComment[$i]['Comment']['user']==$admins[$a]['User']['name']) $commentColorCheck = true;
					}
					if($commentColorCheck) $commentColor = 'commentBox2';
					else $commentColor = 'commentBox1';
					echo '<div class="sandboxComment">';
					echo '<table class="sandboxTable2" width="100%" border="0"><tr><td>';
					echo '<div class="'.$commentColor.'">'.$showComment[$i]['Comment']['user'].':<br>';
					echo $showComment[$i]['Comment']['message'].'</div>';
					if($showComment[$i]['Comment']['status']!=0 && $showComment[$i]['Comment']['status']!=97 && $showComment[$i]['Comment']['status']!=98 && $showComment[$i]['Comment']['status']!=96){
						echo '<div class="commentAnswer">';
							echo '<div style="padding-top:7px;"></div>'.$showComment[$i]['Comment']['admin'].':<br>';
							if($showComment[$i]['Comment']['status']==1) echo 'Your move(s) have been added.<br>';
							else if($showComment[$i]['Comment']['status']==2) echo 'Your file has been added.<br>';
							else if($showComment[$i]['Comment']['status']==3) echo 'Your solution has been added.<br>';
							else if($showComment[$i]['Comment']['status']==4) echo 'I disagree with your comment.<br>';
							else if($showComment[$i]['Comment']['status']==5) echo 'Provide sequence.<br>';
							else if($showComment[$i]['Comment']['status']==6) echo 'Resolved.<br>';
							else if($showComment[$i]['Comment']['status']==7) echo 'I couldn\'t follow your comment.<br>';
							else if($showComment[$i]['Comment']['status']==8) echo 'You seem to try sending non-SGF-files.<br>';
							else if($showComment[$i]['Comment']['status']==9) echo 'You answer is inferior to the correct solution.<br>';
							else if($showComment[$i]['Comment']['status']==10) echo 'I disagree with your comment. I added sequences.<br>';
							else if($showComment[$i]['Comment']['status']==11) echo 'I don\'t know.<br>';
							else if($showComment[$i]['Comment']['status']==12) echo 'I added sequences.<br>';
							else if($showComment[$i]['Comment']['status']==13) echo 'You are right, but the presented sequence is more interesting.<br>';
							else if($showComment[$i]['Comment']['status']==14) echo 'I didn\'t add your file.<br>';
							else if($showComment[$i]['Comment']['status']==100) echo $showComment[$i]['Comment']['textAnswer'];
							else echo $showComment[$i]['Comment']['status'];
						echo '</div>';
					}
					echo '</td><td align="right" class="sandboxTable2time">';
					echo $showComment[$i]['Comment']['created'];
					if($_SESSION['loggedInUser']['User']['id'] == $showComment[$i]['Comment']['user_id']){
						echo '<a class="deleteComment" href="/tsumegos/play/'.$t['Tsumego']['id'].'?deleteComment='.$showComment[$i]['Comment']['id'].'"><br>Delete</a>';
					}
					if($_SESSION['loggedInUser']['User']['isAdmin']==1){
						if($showComment[$i]['Comment']['status']==0){
							//echo '<br><a class="deleteComment" href="/tsumegos/play/'.$t['Tsumego']['id'].'?deleteComment='.$showComment[$i]['Comment']['id'].'&changeComment=2">Can\'t Resolve This</a>';
							echo '<br>';
							if($_SESSION['loggedInUser']['User']['id']!=$showComment[$i]['Comment']['user_id'] && $commentColorCheck){
								echo '<a class="deleteComment" style="text-decoration:none;" href="/tsumegos/play/'.$t['Tsumego']['id'].'?deleteComment='.$showComment[$i]['Comment']['id'].'&changeComment=3">
									<img class="thumbs-small" title="approve this comment" width="20px" src="/img/thumbs-small.png">
								</a>';
							}
							echo '&nbsp;<a id="adminComment'.$i.'" class="adminComment" href="">Answer</a>';

						}else{
							echo '<a id="adminComment'.$i.'" class="adminComment" href=""><br>Edit</a>';
						}
					}
					echo '</td></tr></table>';

					echo '<div id="adminCommentPanel'.$i.'" class="adminCommentPanel">
					<table class="sandboxTable2" width="100%" border="0">
					<tr>
					<td width="50%" style="vertical-align:top">';
						echo $this->Form->create('Comment');
						echo $this->Form->input('id', array('type' => 'hidden', 'value' => $showComment[$i]['Comment']['id']));
						echo $this->Form->input('admin_id', array('type' => 'hidden', 'value' => $_SESSION['loggedInUser']['User']['id']));
						echo $this->Form->input('status', array('id' => 'CommentStatus'.$i, 'label' => '', 'type' => 'textarea', 'placeholder' => 'Message'));
						echo $this->Form->end('Submit');
					echo '</td>
					<td width="50%" style="vertical-align:top">';

						echo '<select id="myselect'.$i.'">
							<option value="0"></option>
							<option value="1">Your moves have been added.</option>
							<option value="2">Your move has been added.</option>
							<option value="3">Your file has been added.</option>
							<option value="4">I disagree with your comment.</option>
							<option value="6">Provide sequence.</option>
							<option value="6">Resolved.</option>
							<option value="7">I couldn\'t follow your comment.</option>
							<option value="8">You seem to try sending non-SGF-files.</option>
							<option value="9">You answer is inferior to the correct solution.</option>
							<option value="10">I disagree with your comment. I added sequences.</option>
							<option value="11">I don\'t know.</option>
							<option value="12">I added sequences.</option>
							<option value="13">You are right, but the presented sequence is more interesting.</option>
							<option value="14">I didn\'t add your file.</option>
						</select>';
						echo '<div align="right">';
						echo '<br><br><br><a class="deleteComment" href="/tsumegos/play/'.$t['Tsumego']['id'].'?deleteComment='.$showComment[$i]['Comment']['id'].'&changeComment=1">No Answer Necessary</a>';
						echo '<br><a class="deleteComment" href="/tsumegos/play/'.$t['Tsumego']['id'].'?deleteComment='.$showComment[$i]['Comment']['id'].'&changeComment=2">Can\'t Resolve This</a>';
						echo '<br><a class="deleteComment" href="/tsumegos/play/'.$t['Tsumego']['id'].'?deleteComment='.$showComment[$i]['Comment']['id'].'">Delete</a>';
						echo '</div>';
					echo '</td>
					</tr>
					</table>
					</div>
					';
					echo '</div>';
					echo '<div class="sandboxCommentSpace"></div>';
			}

		?>
		</div>

		</td>
		</tr>
		</table>

	<?php
	}
	}else{
		?>
		<br>
		</div><br>
		<div align="center">
		<table class="sandboxTable" width="62%">
		<tr>
		<td>
		<?php
		echo '<div id="commentSpace">';

			$showComment2 = array();
			$showComment3 = array();

			for($i=0; $i<count($showComment); $i++){
				if(is_numeric($showComment[$i]['Comment']['status'])) $showComment[$i]['Comment']['textAnswer'] = 'false';
				else{
					$showComment[$i]['Comment']['textAnswer'] = $showComment[$i]['Comment']['status'];
					$showComment[$i]['Comment']['status'] = 100;
				}
				if($showComment[$i]['Comment']['status']!=99) array_push($showComment2, $showComment[$i]);
			}
			$showComment = $showComment2;
			$resolvedCommentCount = 0;

			if(count($showComment)>0) echo '<div id="msg1x"><a id="show2">Comments<img id="greyArrow" src="/img/greyArrow2.png"></a></div><br>';
				echo '<div id="msg2x">';
			for($i=count($showComment)-1; $i>=0; $i--){
					echo '<div class="sandboxComment">';
					echo '<table class="sandboxTable2" width="100%" border="0"><tr><td>';
					echo $showComment[$i]['Comment']['user'].':<br>';
					echo $showComment[$i]['Comment']['message'].'<br>';
					if($showComment[$i]['Comment']['status']!=0 && $showComment[$i]['Comment']['status']!=97 && $showComment[$i]['Comment']['status']!=98  && $showComment[$i]['Comment']['status']!=96){
						echo '<div style="color:#113cd4" class="commentAnswer">';
							echo '<div style="padding-top:7px;"></div>'.$showComment[$i]['Comment']['admin'].':<br>';
							if($showComment[$i]['Comment']['status']==1) echo 'Your move(s) have been added.<br>';
							else if($showComment[$i]['Comment']['status']==2) echo 'Your file has been added.<br>';
							else if($showComment[$i]['Comment']['status']==3) echo 'Your solution has been added.<br>';
							else if($showComment[$i]['Comment']['status']==4) echo 'I disagree with your comment.<br>';
							else if($showComment[$i]['Comment']['status']==5) echo 'Provide sequence.<br>';
							else if($showComment[$i]['Comment']['status']==6) echo 'Resolved.<br>';
							else if($showComment[$i]['Comment']['status']==7) echo 'I couldn\'t follow your comment.<br>';
							else if($showComment[$i]['Comment']['status']==8) echo 'You seem to try sending non-SGF-files.<br>';
							else if($showComment[$i]['Comment']['status']==9) echo 'You answer is inferior to the correct solution.<br>';
							else if($showComment[$i]['Comment']['status']==10) echo 'I disagree with your comment. I added sequences.<br>';
							else if($showComment[$i]['Comment']['status']==11) echo 'I don\'t know.<br>';
							else if($showComment[$i]['Comment']['status']==12) echo 'I added sequences.<br>';
							else if($showComment[$i]['Comment']['status']==13) echo 'You are right, but the presented sequence is more interesting.<br>';
							else if($showComment[$i]['Comment']['status']==14) echo 'I didn\'t add your file.<br>';
							else if($showComment[$i]['Comment']['status']==100) echo $showComment[$i]['Comment']['textAnswer'];
							else echo $showComment[$i]['Comment']['status'];
						echo '</div>';
					}
					echo '</td><td align="right" class="sandboxTable2time">';
					echo $showComment[$i]['Comment']['created'];
					if($_SESSION['loggedInUser']['User']['id'] == $showComment[$i]['Comment']['user_id']){
						echo '<a class="deleteComment" href="/tsumegos/play/'.$t['Tsumego']['id'].'?deleteComment='.$showComment[$i]['Comment']['id'].'"><br>Delete</a>';
					}
					if($_SESSION['loggedInUser']['User']['isAdmin']==1){
						if($showComment[$i]['Comment']['status']==0) echo '<a id="adminComment'.$i.'" class="adminComment" href=""><br>Answer</a>';
						else echo '<a id="adminComment'.$i.'" class="adminComment" href=""><br>Edit</a>';
					}
					echo '</td></tr></table>';

					echo '<div id="adminCommentPanel'.$i.'" class="adminCommentPanel">
					<table class="sandboxTable2" width="100%" border="0">
					<tr>
					<td width="50%" style="vertical-align:top">';
						echo $this->Form->create('Comment');
						echo $this->Form->input('id', array('type' => 'hidden', 'value' => $showComment[$i]['Comment']['id']));
						echo $this->Form->input('admin_id', array('type' => 'hidden', 'value' => $_SESSION['loggedInUser']['User']['id']));
						echo $this->Form->input('status', array('id' => 'CommentStatus'.$i, 'label' => '', 'type' => 'textarea', 'placeholder' => 'Message'));
						echo $this->Form->end('Submit');
					echo '</td>
					<td width="50%" style="vertical-align:top">';

						echo '<select id="myselect'.$i.'">
							<option value="0"></option>
							<option value="1">Your moves have been added.</option>
							<option value="2">Your move has been added.</option>
							<option value="3">Your file has been added.</option>
							<option value="4">I disagree with your comment.</option>
							<option value="6">Provide sequence.</option>
							<option value="6">Resolved.</option>
							<option value="7">I couldn\'t follow your comment.</option>
							<option value="8">You seem to try sending non-SGF-files.</option>
							<option value="9">You answer is inferior to the correct solution.</option>
							<option value="10">I disagree with your comment. I added sequences.</option>
							<option value="11">I don\'t know.</option>
							<option value="12">I added sequences.</option>
							<option value="13">You are right, but the presented sequence is more interesting.</option>
							<option value="14">I didn\'t add your file.</option>
						</select>';
						echo '<div align="right">';
						echo '<br><br><br><a class="deleteComment" href="/tsumegos/play/'.$t['Tsumego']['id'].'?deleteComment='.$showComment[$i]['Comment']['id'].'&changeComment=1">No Answer Necessary</a>';
						echo '<br><a class="deleteComment" href="/tsumegos/play/'.$t['Tsumego']['id'].'?deleteComment='.$showComment[$i]['Comment']['id'].'&changeComment=2">Can\'t Resolve This</a>';
						echo '<br><a class="deleteComment" href="/tsumegos/play/'.$t['Tsumego']['id'].'?deleteComment='.$showComment[$i]['Comment']['id'].'">Delete</a>';
						echo '</div>';
					echo '</td>
					</tr>
					</table>
					</div>
					';
					echo '</div>';
					echo '<div class="sandboxCommentSpace"></div>';
			}

		?>
		</div>

		</td>
		</tr>
		</table>
		</div>


	<?php
	}
	?>

	<?php if($potionAlert){
	?>
		<label>
		  <input type="checkbox" class="alertCheckbox1" autocomplete="off" />
		  <div class="alertBox alertInfo">
			<div class="alertBanner" align="center">
			Hero Power
			<span class="alertClose">x</span>
			</div>
			<span class="alertText">
			<?php
			echo '<img id="hpIcon1" src="/img/hp5.png">
			You found a potion, your hearts have been restored.'
			?>
			<br class="clear1"/></span>
		  </div>
		</label>
	<?php }
	echo '</div>';
	if(count($showComment)>0){
		echo '<div align="center">';
		echo '<font color="grey"></font>';
		echo '</div>';
	}
	$browser = $_SERVER['HTTP_USER_AGENT'] . "\n\n";

	echo '<audio><source src="/sounds/stone1.ogg"></audio>';
	echo '';
	/*
	if(strpos($browser, 'Firefox')){
		echo '<audio><source src="'.$_SERVER['HTTP_HOST'].'/sounds/stone1x.ogg"></audio>';
	}else if(strpos($browser, 'Chrome')){
		echo '<audio><source src="'.$_SERVER['HTTP_HOST'].'/sounds/stone1x.ogg"></audio>';
	}else{
		echo '<audio><source src="'.$_SERVER['HTTP_HOST'].'/sounds/stone1x.mp3"></audio>';
	}*/

	if($corner=='full board') $boardSize='medium';
	else $boardSize='large';
	?>

	<script type="text/javascript">
	var jrecordValue = 19;
	<?php if($checkBSize!=19) echo 'jrecordValue = '.$checkBSize.';'; ?>
	var jrecord = new JGO.Record(jrecordValue, jrecordValue);
	var jboard = jrecord.jboard;
	var jsetup = new JGO.Setup(jboard, JGO.BOARD.<?php echo $boardSize; ?>Walnut);
	var player = <?php echo 'JGO.'.$playerColor[0]; ?>;
	var ko = false, lastMove = false;
	var lastHover = false, lastX = -1, lastY = -1;
	var moveCounter = 0;
	var move = 0;
	var branch = "";
	var misplays = 0;
	var hoverLocked = false;
	var tryAgainTomorrow = false;
	var doubleXP = false;
	var countDownDate = new Date();
	var sprintEnabled = true;
	var intuitionEnabled = true;
	var rejuvenationEnabled = true;
	var refinementEnabled = true;
	var multipleChoiceSelected = false;
	var safetyLock = false;
	var msg2selected = false;
	var msg2xselected = false;
	var msg3selected = false;
	var msg4selected = false;
	var playedWrong = false;
	var seconds = 0;
	var difficulty = <?php echo $difficulty; ?>;
	var sequence = "|";
	var freePlayMode = false;
	var freePlayMode2 = false;
	var freePlayMode2done = false;
	var rw = false;
	var rwLevel = 0;
	var rwBranch = 0;
	var masterArrayPreI = 0;
	var masterArrayPreJ = 0;
	var rwSwitcher = 2;
	var inPath = false;
	var pathLock = false;
	var reviewEnabled = false;
	var set159 = false;
	var theComment = "";
	var moveHasComment = false;
	var isIncorrect = false;
	var josekiHero = false;
	var josekiLevel = 1;
	var thumbsUpSelected = false;
	var thumbsDownSelected = false;
	var thumbsUpSelected2 = false;
	var thumbsDownSelected2 = false;
	var mode = 1;
	var timeModeEnabled = true;
	var timeUp = false;
	var moveTimeout = 360;
	var authorProblem = false;
	var tcount = 0.0;
	var isCorrect = false;
	var whiteMoveAfterCorrect = false;
	var whiteMoveAfterCorrectI = 0;
	var whiteMoveAfterCorrectJ = 0;
	var reviewModeActive = false;
	var ui = <?php echo $ui; ?>;
	var userXP = <?php echo $user['User']['xp']; ?>;
	var prevButtonLink = <?php echo $prev; ?>;
	var nextButtonLink = <?php echo $next; ?>;
	var soundsEnabled2 = true;
	var isMutable = true;
	var deleteNextMoveGroup = false;
	var file = "<?php echo $file; ?>";
	var clearFile = "<?php echo $set['Set']['title'].' - '.$t['Tsumego']['num']; ?>";
	var tsumegoFileLink = "<?php echo $t['Tsumego']['id']; ?>";
	var author = "<?php echo $t['Tsumego']['author']; ?>";
	var globalSvg = null;
	var besogoFullBoard = false;
	var besogoCorner = null;
	var besogoFullBoardWidth = 0;
	var besogoFullBoardHeight = 0;
	var besogoBoardWidth = 0;
	var besogoBoardHeight = 0;
	var besogoBoardWidth2 = 0;
	var besogoBoardHeight2 = 0;
	var besogoBoardWidth3 = 0;
	var besogoBoardHeight3 = 0;
	var besogoPlayerColor = "black";
	var disableAutoplay = false;
	var globalTreePanel = null;
	var favorite = "<?php echo $favorite; ?>";
	var besogoMode2Solved = false;
	var disableAutoplay = false;
	
	
	<?php
	if(isset($_SESSION['loggedInUser'])){
		echo 'var besogoUserId = '.$_SESSION['loggedInUser']['User']['id'].';';
	}
	
	if($pl==1) echo 'besogoPlayerColor = "white";';

	if($authorx==$_SESSION['loggedInUser']['User']['name'] && $isSandbox) echo 'authorProblem = true;';
	if($firstRanks!=0) echo 'document.cookie = "mode=3";';
	if($mode==3){
		echo 'seconds = 0.0;';
		echo 'var besogoMode3Next = '.$next.';';
	}
		echo '
		';
		if($t['Tsumego']['set_id']==159 || $t['Tsumego']['set_id']==161) echo 'set159 = true;';
		if($t['Tsumego']['set_id']==161) echo 'josekiHero = true;';
		echo 'josekiLevel = '.$josekiLevel.';';
	?>

	<?php if($mode==2){ ?>
		var eloScore = <?php echo $eloScore; ?>;
	<?php } ?>

	<?php
		if($corner=='t' || $corner=='b' || $corner=='full board'){
			echo '$("#plus2").css("left", "340px");';
		}

		if($ui==1) echo '$("#ms1").prop("checked", true);';
		else echo '$("#ms2").prop("checked", true);';
	?>

	<?php if($mode!=3){ ?>
		function incrementSeconds(){
			seconds += 1;
		}
		var secondsx = setInterval(incrementSeconds, 1000);
	<?php }else{ ?>
		function incrementSeconds(){
			seconds += 0.1;
		}
		var secondsx = setInterval(incrementSeconds, 100);
	<?php } ?>
	//$('#CommentMessage').val('');
	$(".adminCommentPanel").hide();
	$(".modify-description-panel").hide();
	$(".tsumegoNavi-middle2").hide();
	$(".tsumegoNavi-middle2").hide();
	$(".reviewNavi").hide();
	$("#reviewButton").hide();
	$("#reviewButton2").hide();
	<?php if(($t['Tsumego']['set_id']==159 || $t['Tsumego']['set_id']==161) && $isSemeai){
			echo 'document.getElementById("multipleChoice1").innerHTML ="'.$partArray[0].'";';
			echo 'document.getElementById("multipleChoice2").innerHTML ="'.$partArray[1].'";';
			echo 'document.getElementById("multipleChoice3").innerHTML ="'.$partArray[2].'";';
			echo 'document.getElementById("multipleChoice4").innerHTML ="'.$partArray[3].'";';
	} ?>

	//°
	<?php if($mode==2){ ?>
	var rangeInput = document.getElementById("rangeInput");
	const Slider = document.querySelector('input[name=rangeInput]');

	if(difficulty==1){
		$('#sliderText').css({"color":"hsl(138, 47%, 50%)"});
		$('#sliderText').text("very easy");
		Slider.style.setProperty('--SliderColor', 'hsl(138, 47%, 50%)');
	}else if(difficulty==2){
		$('#sliderText').css({"color":"hsl(138, 31%, 50%)"});
		$('#sliderText').text("easy");
		Slider.style.setProperty('--SliderColor', 'hsl(138, 31%, 50%)');
	}else if(difficulty==3){
		$('#sliderText').css({"color":"hsl(138, 15%, 50%)"});
			$('#sliderText').text("casual");
			Slider.style.setProperty('--SliderColor', 'hsl(138, 15%, 50%)');
	}else if(difficulty==4){
		$('#sliderText').css({"color":"hsl(138, 0%, 47%)"});
			$('#sliderText').text("regular");
			Slider.style.setProperty('--SliderColor', 'hsl(138, 0%, 60%)');
	}else if(difficulty==5){
		$('#sliderText').css({"color":"hsl(0, 31%, 50%)"});
			$('#sliderText').text("challenging");
			Slider.style.setProperty('--SliderColor', 'hsl(0, 31%, 50%)');
	}else if(difficulty==6){
		$('#sliderText').css({"color":"hsl(0, 52%, 50%)"});
			$('#sliderText').text("difficult");
			Slider.style.setProperty('--SliderColor', 'hsl(0, 47%, 50%)');
	}else if(difficulty==7){
		$('#sliderText').css({"color":"hsl(0, 66%, 50%)"});
			$('#sliderText').text("very difficult");
			Slider.style.setProperty('--SliderColor', 'hsl(0, 63%, 50%)');
	}else{
		$('#sliderText').css({"color":"hsl(138, 0%, 47%)"});
			$('#sliderText').text("regular");
			Slider.style.setProperty('--SliderColor', 'hsl(138, 0%, 60%)');
	}


	rangeInput.addEventListener('change', function(){
		const Slider = document.querySelector('input[name=rangeInput]');
		document.cookie = "difficulty="+this.value;
		if(this.value==1){
			$('#sliderText').css({"color":"hsl(138, 47%, 50%)"});
			$('#sliderText').text("very easy");
			Slider.style.setProperty('--SliderColor', 'hsl(138, 47%, 50%)');
		}else if(this.value==2){
			$('#sliderText').css({"color":"hsl(138, 31%, 50%)"});
			$('#sliderText').text("easy");
			Slider.style.setProperty('--SliderColor', 'hsl(138, 31%, 50%)');
		}else if(this.value==3){
			$('#sliderText').css({"color":"hsl(138, 15%, 50%)"});
			$('#sliderText').text("casual");
			Slider.style.setProperty('--SliderColor', 'hsl(138, 15%, 50%)');
		}else if(this.value==4){
			$('#sliderText').css({"color":"hsl(138, 0%, 47%)"});
			$('#sliderText').text("regular");
			Slider.style.setProperty('--SliderColor', 'hsl(138, 0%, 60%)');
		}else if(this.value==5){
			$('#sliderText').css({"color":"hsl(0, 34%, 50%)"});
			$('#sliderText').text("challenging");
			Slider.style.setProperty('--SliderColor', 'hsl(0, 34%, 50%)');
		}else if(this.value==6){
			$('#sliderText').css({"color":"hsl(0, 52%, 50%)"});
			$('#sliderText').text("difficult");
			Slider.style.setProperty('--SliderColor', 'hsl(0, 47%, 50%)');
		}else if(this.value==7){
			$('#sliderText').css({"color":"hsl(0, 66%, 50%)"});
			$('#sliderText').text("very difficult");
			Slider.style.setProperty('--SliderColor', 'hsl(0, 63%, 50%)');
		}else{
			$('#sliderText').css({"color":"#616161"});
			$('#sliderText').text("regular");
			Slider.style.setProperty('--SliderColor', 'hsl(138, 0%, 60%)');
		}
	});
	<?php } ?>
	$(".modify-description").click(function(e){
		e.preventDefault();
		$(".modify-description-panel").toggle(250);
	});

	<?php
	if($potionSuccess){
		$negative1 = $user['User']['damage']*(-1);
		echo 'document.cookie = "misplay='.$negative1.'";';
		//echo 'alert(\'You found a potion, your hearts have been restored.\');';
		echo 'window.location = "/tsumegos/play/'.$t['Tsumego']['id'].'?potionAlert=1";';
	}

	if($mode==1) echo 'mode = 1;';
	if($mode==2) echo 'mode = 2;';
	if($mode==3) echo 'mode = 3;';
	if($mode==1){
	if(isset($rep['Reputation']['value'])){
		if($rep['Reputation']['value']==1) echo 'var thumbsUpSelected2 = true;';
		if($rep['Reputation']['value']==-1) echo 'var thumbsDownSelected2 = true;';
	}

	}elseif($mode==2){
		echo '
			$(".tsumegoNavi1").hide();
			$(".tsumegoNavi-middle").hide();
			$(".tsumegoNavi-middle2").show();
			$(".mode1").css({"padding-top":"8px"});
			//$("#playTitle").hide();
			$(".selectable-text").hide();
			$("#commentSpace").hide();
			$("#msg1").hide();
			$("#account-bar-user > a").css({color:"#d19fe4"});
			$("#reviewButton").hide();
			$("#reviewButton2").hide();
		';
	}elseif($mode==3){
		echo '$("#account-bar-user > a").css({color:"#ca6658"});';
	}

	for($i=count($showComment)-1; $i>=0; $i--){
		echo '
		$("#myselect'.$i.'").change(function(){
			$("#CommentStatus'.$i.'").val($("#myselect'.$i.' option:selected").text());
		});

		$("#adminComment'.$i.'").click(function(e){
			e.preventDefault();
			$("#adminCommentPanel'.$i.'").toggle(250);
		});
		';
	}

	if($t['Tsumego']['status']=='setS2' || $t['Tsumego']['status']=='setC2' || $t['Tsumego']['status']=='setW2') echo 'var showCommentSpace = true;';
	else echo 'var showCommentSpace = false;';
	if($_SESSION['loggedInUser']['User']['isAdmin']>0) echo 'var showCommentSpace = true;';
	if($set['Set']['public']==0) echo 'var showCommentSpace = true;';
	if($goldenTsumego) echo 'var goldenTsumego = true;';
	else echo 'var goldenTsumego = false;';

	$sandboxCheck = 'document.getElementById("currentElement").style.backgroundColor = "green";';

	if($t['Tsumego']['set_id']==11969 || $t['Tsumego']['set_id']==29156 || $t['Tsumego']['set_id']==31813 || $t['Tsumego']['set_id']==33007
	|| $t['Tsumego']['set_id']==71790 || $t['Tsumego']['set_id']==74761 || $t['Tsumego']['set_id']==81578 || $t['Tsumego']['set_id']==88156){
		echo 'var sprintLockedInSecretArea =true;';
	}else{
		echo 'var sprintLockedInSecretArea = false;';
	}

	if($firstPlayer=='w') echo 'player = JGO.'.$playerColor[1].';';

	if($t['Tsumego']['status'] == 'setF2' || $t['Tsumego']['status'] == 'setX2') echo 'var locked=true; tryAgainTomorrow = true;';
	else echo 'var locked=false;';

	if($dailyMaximum){
		echo 'var locked=true; tryAgainTomorrow = true;';
		echo '
			document.getElementById("status").innerHTML = "<h3><b>You reached the daily maximum for non-premium users.</b></h3>";
			document.getElementById("status").style.color = "#000";
			document.getElementById("xpDisplay").innerHTML = "&nbsp;";
		';
	}
	if($suspiciousBehavior){
		echo 'var locked=true; tryAgainTomorrow = true;';
		echo '
			document.getElementById("status").innerHTML = "<h3><b>Your account is temporarily locked.</b></h3>";
			document.getElementById("status").style.color = "red";
			document.getElementById("xpDisplay").innerHTML = "&nbsp;";
		';
	}

	if($t['Tsumego']['status']=='setS2' || $t['Tsumego']['status']=='setC2' || $maxNoUserLevel){
		echo 'var noXP=true;';
	}else{
		echo 'var noXP=false;';
	}

	for($i=0; $i<count($black); $i++){
		if($i%2 == 0){
			echo 'jboard.setType(new JGO.Coordinate('.$black[$i].', '.$black[$i+1].'), JGO.'.$playerColor[0].');';
		}
	}
	for($i=0; $i<count($white); $i++){
		if($i%2 == 0){
			echo 'jboard.setType(new JGO.Coordinate('.$white[$i].', '.$white[$i+1].'), JGO.'.$playerColor[1].');';
		}
	}

	if($t['Tsumego']['set_id']==109 || $t['Tsumego']['set_id']==156 || $t['Tsumego']['set_id']==159 || $t['Tsumego']['set_id']==161){
		if($additionalInfo['lastPlayed'][0]!=99) echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['lastPlayed'][0].', '.$additionalInfo['lastPlayed'][1].'), JGO.MARK.CIRCLE);';
		for($i=0; $i<count($additionalInfo['triangle']); $i++){
			echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['triangle'][$i][0].', '.$additionalInfo['triangle'][$i][1].'), JGO.MARK.TRIANGLE);';
		}
		for($i=0; $i<count($additionalInfo['square']); $i++){
			echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['square'][$i][0].', '.$additionalInfo['square'][$i][1].'), JGO.MARK.SQUARE);';
		}
	}

	?>if(josekiHero){<?php
		for($i=0; $i<count($visual); $i++){
			echo 'if(josekiLevel<3) jboard.setMark(new JGO.Coordinate('.$visual[$i][0].', '.$visual[$i][1].'), JGO.MARK.CIRCLE);';
		}
	?>}<?php

	//BOARD ORIENTATION
	      if($corner=='tl'){echo 'jsetup.view(0, 0, 9, 9);';
	}else if($corner=='br'){echo 'jsetup.view(10, 10, 9, 9);';
	}else if($corner=='bl'){echo 'jsetup.view(0, 10, 9, 9);';
	}else if($corner=='tr'){echo 'jsetup.view(10, 0, 9, 9);';
	}else if($corner=='b'){echo 'jsetup.view(0, 10, 19, 9);';
	}else if($corner=='t'){echo 'jsetup.view(0, 0, 19, 9);';
	}else{} // Full Board
?>

	$(document).ready(function(){

		<?php
			if($ui==1) echo 'document.cookie = "ui=1";';
			elseif($ui==2) echo 'document.cookie = "ui=2";';

			if($mode==1) echo 'document.cookie = "mode=1";';
			if($mode==2) echo 'document.cookie = "mode=2";';
			if($mode==3) echo 'document.cookie = "mode=3";';

			if($mode==3){
				echo 'notMode3 = false;';
				echo '$("#account-bar-xp").text("'.$raName.'");';
				?>
				<?php $barPercent = ($crs/$stopParameter)*100; ?>
				$("#xp-increase-fx").css("display","inline-block");
				$("#xp-bar-fill").css("box-shadow", "-5px 0px 10px #fff inset");
				<?php echo '$("#xp-bar-fill").css("width","'.$barPercent.'%");'; ?>
				$("#xp-increase-fx").fadeOut(0);
				$("#xp-bar-fill").css({"-webkit-transition":"all 0.0s ease","box-shadow":""});
				<?php
			}

			if($refresh=='1') echo 'window.location = "/";';
			if($refresh=='2') echo 'window.location = "/sets";';
			if($refresh=='3') echo 'window.location = "/sets/view/'.$t['Tsumego']['set_id'].'";';
			if($refresh=='4') echo 'window.location = "/users/highscore";';
			if($refresh=='5') echo 'window.location = "/comments";';
			if($refresh=='6') echo 'window.location = "/sets/beta";';
			if($refresh=='7') echo 'window.location = "/users/leaderboard";';
			if($refresh=='8') echo 'window.location = "/tsumegos/play/'.$t['Tsumego']['id'].'";';
		?>
		loadBar();
		<?php
		if($t['Tsumego']['status'] == 'setF2' || $t['Tsumego']['status'] == 'setX2'){
			echo '
				document.getElementById("status").innerHTML = "<h2>Try again tomorrow</h2>";
				tryAgainTomorrow = true;
				document.getElementById("status").style.color = "#e03c4b";
				document.getElementById("xpDisplay").innerHTML = "&nbsp;";
			';
		}
		if($isSemeai){
			echo '
				tryAgainTomorrow = true;
				locked = true;
			';
		}
		if($doublexp!=null && !$goldenTsumego){
			echo 'doubleXP = true; countDownDate = '.$doublexp.';';
		}

		if($t['Tsumego']['status']=='setS2' || $t['Tsumego']['status']=='setC2'){
			$reviewEnabled = true;
			echo 'reviewEnabled = true;';
		}
		if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['isAdmin']==1){
				if($isSandbox){
					//$reviewEnabled = true;
					//echo 'reviewEnabled = true;';
				}
			}
		}
		if($reviewCheat){
			$reviewEnabled = true;
			echo 'reviewEnabled = true;';
		}

		?>
		if(ui==2){
			
		}else{
			if(reviewEnabled) $("#reviewButton").show();
		}
		
		var now = new Date().getTime();
		var distance = countDownDate - now;
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds2 = Math.floor((distance % (1000 * 60)) / 1000);
		if (distance >= 0 && sprintLockedInSecretArea){
				window.location.href = "/sets";
		}
		<?php
		if($stopParameter2==0) echo 'tcount = 30.0;';
		elseif($stopParameter2==1) echo 'tcount = 60.0;';
		elseif($stopParameter2==2) echo 'tcount = 240.0;';
		else echo 'tcount = 0.0;';
		?>

		var tcounter = 250;
		if(mode==3){
			tcounter = 100;
			moveTimeout = 50;
		}

		var x = setInterval(function(){
			if(mode==1){
				if(doubleXP){
					var now = new Date().getTime();
					var distance = countDownDate - now;
					var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					var seconds2 = Math.floor((distance % (1000 * 60)) / 1000);
					var timeOutput;
					if(minutes > 2) document.cookie = "extendedSprint="+minutes;
					if(distance >= 0){
						if(!sprintLockedInSecretArea){
							if(seconds2<10)  timeOutput = minutes + ":0" + seconds2;
							else 			timeOutput = minutes + ":" + seconds2;
							document.getElementById("status2").style.color = "blue";
							document.getElementById("status2").innerHTML = "<h3>Double XP "+timeOutput+"</h3>";
							document.getElementById("xpDisplay").style.color = "blue";
							<?php
							if(!$goldenTsumego) echo 'document.getElementById("xpDisplay").innerHTML = \'<font size="4">'.$t['Tsumego']['difficulty'].'×2 XP</font>\';';
							else echo 'document.getElementById("xpDisplay").innerHTML = \'<font size="4">'.$t['Tsumego']['difficulty'].' XP</font>\';';
							?>
							document.cookie = "sprint=1";
						}else{
							window.location.href = "/sets";
						}
					}else{
						clearInterval(x);
						<?php
						if(isset($sprintActivated)) echo 'document.cookie = "sprint=2";';
						if($t['Tsumego']['status']=='setS2' || $t['Tsumego']['status']=='setC2'){
							 echo '
								document.getElementById("xpDisplay").style.color = "green";
								document.getElementById("xpDisplay").innerHTML = \'<font size="4"><b>Solved</b> ('.$t['Tsumego']['difficulty'].' XP) '.$sandboxComment.'</font>\';
							';
						}else if($t['Tsumego']['status']=='setW2' || $t['Tsumego']['status']=='setX2'){
							echo '
								document.getElementById("xpDisplay").style.color = "'.$xpDisplayColor.'";
								document.getElementById("xpDisplay").innerHTML = \'<font size="4">  '.$t['Tsumego']['difficulty'].' XP (1/2) '.$sandboxComment.'</font>\';
							';
						}else{
							echo '
								document.getElementById("xpDisplay").style.color = "'.$xpDisplayColor.'";
								document.getElementById("xpDisplay").innerHTML = \'<font size="4">  '.$t['Tsumego']['difficulty'].' XP '.$sandboxComment.'</font>\';
							';
						}
						?>
						doubleXP = false;
					}
				}else{
					<?php
						if($t['Tsumego']['status']=='setS2' || $t['Tsumego']['status']=='setC2'){
							 echo '
								document.getElementById("xpDisplay").style.color = "green";
								document.getElementById("xpDisplay").innerHTML = \'<font size="4"><b>Solved</b> ('.$t['Tsumego']['difficulty'].' XP) '.$sandboxComment.'</font>\';
							';
						}else if($t['Tsumego']['status']=='setW2' || $t['Tsumego']['status']=='setX2'){
							echo '
								document.getElementById("xpDisplay").style.color = "'.$xpDisplayColor.'";
								document.getElementById("xpDisplay").innerHTML = \'<font size="4">  '.$t['Tsumego']['difficulty'].' XP (1/2) '.$sandboxComment.'</font>\';
							';
						}else{
							echo '
								document.getElementById("xpDisplay").style.color = "'.$xpDisplayColor.'";
								document.getElementById("xpDisplay").innerHTML = \'<font size="4">  '.$t['Tsumego']['difficulty'].' XP '.$sandboxComment.'</font>\';
							';
						}
					?>
				}
			}else if(mode==3){
				if(timeModeEnabled){
					tcount-=0.1;
					tcount = tcount.toFixed(1);
					tcountMin = Math.floor(tcount/60);
					tcountSec = tcount%60;
					tcountSec = tcountSec.toFixed(1);
					if(tcountSec<10) tplace = "0";
					else tplace = "";

					$("#time-mode-countdown").html(tcountMin+":"+tplace+tcountSec);

					if(tcount == 0){
						timeUp = true;
						locked = true;
						tryAgainTomorrow = true;
						document.cookie = "rank=<?php echo $mode3ScoreArray[2]; ?>";
						document.cookie = "misplay=1";
						$("#time-mode-countdown").css("color","#e03c4b");
						document.getElementById("status").style.color = "#e03c4b";
						document.getElementById("status").innerHTML = "<h2>Time up</h2>";
						clearInterval(x);
					}
				}else{
					clearInterval(x);
				}
			}else{
				//if(eloScore!=0) document.getElementById("xpDisplay").innerHTML = '<font size="4">'+<?php echo $t['Tsumego']['userWin']; ?>+'%</font>';
				//else document.getElementById("xpDisplay").innerHTML = '<font size="4">Recently visited</font>';
			}
		}, tcounter);

		$('#target').click(function(e){
			if(locked==true){
				<?php
				if($mode==1 || $mode==3) if($next!='0' && !$isSemeai) echo 'window.location = "/tsumegos/play/'.$next.'";';
				if($mode==2) echo 'window.location = "/tsumegos/play/'.$nextMode['Tsumego']['id'].'";';
				?>
			}
		});

		if(!showCommentSpace) $("#commentSpace").hide();
		$("#msg2").hide();
		$("#show").click(function(){
			if(!msg2selected){
				$("#msg2").fadeIn(250);
				document.getElementById("greyArrow1").src = "/img/greyArrow2.png";
			}else{
				$("#msg2").fadeOut(250);
				document.getElementById("greyArrow1").src = "/img/greyArrow1.png";
			}
			msg2selected = !msg2selected;
		});

		$("#show2").click(function(){
			if(!msg2xselected){
				$("#msg2x").fadeIn(250);
				document.getElementById("greyArrow").src = "/img/greyArrow2.png";
			}else{
				$("#msg2x").fadeOut(250);
				document.getElementById("greyArrow").src = "/img/greyArrow1.png";
			}
			msg2xselected = !msg2xselected;
		});
		$("#msg3").hide();
		$("#show3").click(function(){
			if(!msg3selected){
				$("#msg3").fadeIn(250);
				document.getElementById("greyArrow2").src = "/img/greyArrow2.png";
			}else{
				$("#msg3").fadeOut(250);
				document.getElementById("greyArrow2").src = "/img/greyArrow1.png";
			}
			msg3selected = !msg3selected;
		});
		$("#msg4").hide();
		$("#show4").click(function(){
			if(!msg4selected){
				$("#msg4").fadeIn(250);
				document.getElementById("greyArrow4").src = "/img/greyArrow2.png";
			}else{
				$("#msg4").fadeOut(250);
				document.getElementById("greyArrow4").src = "/img/greyArrow1.png";
			}
			msg4selected = !msg4selected;
		});
		$('#targetLockOverlay').click(function(){
			window.location.href = "/tsumegos/play/"+nextButtonLink;
		});
	});

	<?php if($ui==1){ ?>
	<?php if($sgfErrorMessage===''){ ?>
	jsetup.create("board", function(canvas){
		canvas.addListener("click", function(coord, ev){
			noLastMark = false;
			if(!locked){
				var opponent = (player == JGO.BLACK) ? JGO.WHITE : JGO.BLACK;
				//if(noXP) alert(player);

				var illegalMove = false;
				if(lastHover){
				  jboard.setType(new JGO.Coordinate(lastX, lastY), JGO.CLEAR);
				}
				lastHover = false;
				var play = jboard.playMove(coord, player, ko);
				sequence += coord+"-"+seconds+"|";
				if(play.success){
				  node = jrecord.createNode(true);
				  node.info.captures[player] += play.captures.length;
				  node.setType(coord, player);
				  node.setType(play.captures, JGO.CLEAR); // clear opponent's stones

				  <?php
					  if($t['Tsumego']['set_id']==109 || $t['Tsumego']['set_id']==156 || $t['Tsumego']['set_id']==159 || $t['Tsumego']['set_id']==161){
						echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['lastPlayed'][0].', '.$additionalInfo['lastPlayed'][1].'), JGO.MARK.CLEAR);';
						for($i=0; $i<count($additionalInfo['triangle']); $i++){
							echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['triangle'][$i][0].', '.$additionalInfo['triangle'][$i][1].'), JGO.MARK.CLEAR);';
						}
						for($i=0; $i<count($additionalInfo['square']); $i++){
							echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['square'][$i][0].', '.$additionalInfo['square'][$i][1].'), JGO.MARK.CLEAR);';
						}
					  }
				  ?>

				  if(lastMove) node.setMark(lastMove, JGO.MARK.NONE);
				  if(ko) node.setMark(ko, JGO.MARK.NONE); // clear previous ko mark
				  node.setMark(coord, JGO.MARK.CIRCLE); // mark move
				  lastMove = coord;
				  if(play.ko) node.setMark(play.ko, JGO.MARK.CIRCLE);
					//ko = play.ko;
				  ko = false;
				  player = opponent;

				}else illegalMove = true;
				if(!rw){
					if(!illegalMove){
						if(soundsEnabled) document.getElementsByTagName("audio")[0].play();
						hoverLocked = true;
						setTimeout(function(){
							var c2;
							<?php
								$fn = 1;
								for($i=0; $i<count($masterArray); $i++){
									$ma7 = str_split($masterArray[$i][7]);
									if(is_numeric($ma7[0]) && $ma7[1]=='-') $moveHasComment = 'moveHasComment = false;';
									else $moveHasComment = 'moveHasComment = true;';
									if(count($ma7)<2) $moveHasComment = 'moveHasComment = false;';
									if($t['Tsumego']['set_id']==31813) $moveHasComment = 'moveHasComment = false;';
									for($k=count($coordPlaces[$i])-1; $k>=0; $k--){
										$coordP = explode('/', $coordPlaces[$i][$k]);
										if(count($coordP)>1){
											$a = substr($masterArray[$i][7], 0, $coordP[0]);
											$b = '<a href=\"#\" onmouseover=\"commentCoordinateIn'.$fn.'()\" onmouseout=\"commentCoordinateOut'.$fn.'()\" return false;>';
											//$b = '<a >';
											$c = substr($masterArray[$i][7], $coordP[0], $coordP[1]-$coordP[0]+1);
											$d = '</a>';
											$e = substr($masterArray[$i][7], $coordP[1]+1, strlen($masterArray[$i][7])-1);
											$masterArray[$i][7] = $a.$b.$c.$d.$e;
											$fn++;
										}
									}
									$cVisual = '';
									$cVisualCount = 0;
									for($z=0; $z<count($visuals[$i]); $z++){
										$cVisual .= 'cVisual'.$z.' = new JGO.Coordinate(parseInt('.$visuals[$i][$z][0].'), parseInt('.$visuals[$i][$z][1].'));';
										$cVisualCount++;
									}
									$cVisual .= 'cVisualCount='.$cVisualCount.';';
									//§
									$w = '';
									//Incorrect
									if($masterArray[$i][8]!=='+'){
										if($masterArray[$i][8]==='w'){
											$w = 'document.getElementById("status").style.color = "#e03c4b";
												document.getElementById("status").innerHTML = "<h2>Incorrect</h2>";
												if(mode==1)document.getElementById("theComment").style.cssText = "display:block;border:thick double #e03c4b;";
												isIncorrect = true;
												if(mode==3) document.cookie = "rank='.$mode3ScoreArray[1].'";
												if(mode==3) locked = true;
												if(mode==3) tryAgainTomorrow = true;
												if(mode==3) document.cookie = "misplay=1";
												if(mode==3) seconds = seconds.toFixed(1);
												if(mode==3) secondsy = seconds*10*'.$t['Tsumego']['id'].';
												if(mode==3) document.cookie = "seconds="+secondsy;
												if(mode==3) timeModeEnabled = false;
												if(mode==3) $("#time-mode-countdown").css("color","#e45663");
												if(!noXP){
													if(!freePlayMode && !authorProblem){
													';
														$m2 = '';
														if($mode==2){
															$elo2 = $user['User']['elo_rating_mode']-$eloScore;
															$m2 = '
															runXPBar(false);
															sequence += "incorrect|";
															document.cookie = "misplay='.$eloScore.'";
															document.cookie = "sequence="+sequence;
															tryAgainTomorrow = true;
															locked = true;
															$("#skipButton").text("Next");
															ulvl = '.$user['User']['level'].';
															runXPNumber("account-bar-xp", '.$user['User']['elo_rating_mode'].', '.$elo2.', 1000, ulvl);
															';
														}
														$w .= 'misplays++;
														document.cookie = "misplay="+misplays;
														if(document.getElementById("refreshLinkToStart")) document.getElementById("refreshLinkToStart").href = "/tsumegos/play/'.$lv.'?refresh=1";
														if(document.getElementById("refreshLinkToSets")) document.getElementById("refreshLinkToSets").href = "/tsumegos/play/'.$lv.'?refresh=2";
														if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/'.$lv.'?refresh=3";
														if(document.getElementById("refreshLinkToHighscore")) document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/'.$lv.'?refresh=4";
														if(document.getElementById("refreshLinkToDiscuss")) document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/'.$lv.'?refresh=5";
														if(document.getElementById("refreshLinkToSandbox")) document.getElementById("refreshLinkToSandbox").href = "/tsumegos/play/'.$lv.'?refresh=6";
														if(mode==1) updateHealth();
														if(mode==1 || mode==2) secondsy = seconds;
														if(mode==3) secondsy = seconds*10*'.$t['Tsumego']['id'].';
														document.cookie = "seconds="+secondsy;
														'.$m2.'
													}
													freePlayMode = true;
													freePlayMode2 = true;
													if('.$health.' - misplays<0){
														document.getElementById("currentElement").style.backgroundColor = "#e03c4b";
														document.getElementById("status").innerHTML = "<h2>Try again tomorrow</h2>";
														tryAgainTomorrow = true;
														locked = true;
													}
													if(goldenTsumego){
														document.cookie = "refinement=-1";
														window.location.href = "/tsumegos/play/'.$t['Tsumego']['id'].'";
													}
												}
											';
										}
										echo '
										if(coord.i=='.$masterArray[$i][0].'&&coord.j=='.$masterArray[$i][1].'
										&& move=='.$masterArray[$i][2].' && branch=="'.$masterArray[$i][3].'"){
											c2 = new JGO.Coordinate('.$masterArray[$i][4].', '.$masterArray[$i][5].');
											'.$w.'
											branch = "'.$masterArray[$i][6].'";
											theComment = "'.$masterArray[$i][7].'";
											'.$moveHasComment.'
											if(soundsEnabled) document.getElementsByTagName("audio")[0].play();
											'.$cVisual.'
										}else ';
									}else{
										//Correct!
										if($mode==1 || $mode==3){
											echo '
											if(coord.i=='.$masterArray[$i][0].'&&coord.j=='.$masterArray[$i][1].'
											&& move=='.$masterArray[$i][2].' && branch=="'.$masterArray[$i][3].'"){
												'.$sandboxCheck.'
												document.getElementById("status").style.color = "green";
												document.getElementById("status").innerHTML = "<h2>Correct!</h2>";
												document.getElementById("xpDisplay").style.color = "white";
												if(set159){document.getElementById("theComment").style.cssText = "visibility:visible;color:green;";
												document.getElementById("theComment").innerHTML = "xxx";}
												'.$moveHasComment.'
												if(moveHasComment){isCorrect=true;document.getElementById("theComment").style.cssText = "display:block;border:thick double green;";
												}else{document.getElementById("theComment").style.cssText = "display:none;border:thick double green;";}
												document.getElementById("theComment").innerHTML = "'.$masterArray[$i][7].'";
												$("#commentSpace").show();
												branch = "'.$masterArray[$i][6].'";
												locked = true;
												if(mode==3) document.cookie = "rank='.$mode3ScoreArray[0].'";
												if(mode==3) seconds = seconds.toFixed(1);
												if(mode==3) secondsy = seconds*10*'.$t['Tsumego']['id'].';
												if(mode==3) document.cookie = "seconds="+secondsy;
												if(mode==3) timeModeEnabled = false;
												if(mode==3) document.cookie = "score='.$score1.'";
												if(mode==3) document.cookie = "preId='.$t['Tsumego']['id'].'";
												if(mode==3) $("#time-mode-countdown").css("color","green");
												if(mode==3) $("#reviewButton").show();
												if(mode==3) $("#reviewButton-inactive").hide();
												if(mode==3) runXPBar(true);
												noLastMark = true;
												if(!isNaN("'.$masterArray[$i][4].'")){
													whiteMoveAfterCorrect = true;
													whiteMoveAfterCorrectI = "'.$masterArray[$i][4].'";
													whiteMoveAfterCorrectJ = "'.$masterArray[$i][5].'";
												}
												if(!noXP){
													if(!doubleXP){
														x2 = "'.$score1.'";
														x3 = 1;
													}else{
														x2 = "'.$score2.'";
														x3 = 2;
													}
													if(goldenTsumego){
														x2 = "'.$score1.'";
														x3 = 1;
													}
													updateCookie("score=",x2);
													$("#skipButton").text("Next");
													document.getElementById("refreshLinkToStart").href = "/tsumegos/play/'.$lv.'?refresh=1";
													document.getElementById("refreshLinkToSets").href = "/tsumegos/play/'.$lv.'?refresh=2";
													if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/'.$lv.'?refresh=3";
													document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/'.$lv.'?refresh=4";
													document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/'.$lv.'?refresh=5";
													document.getElementById("refreshLinkToSandbox").href = "/tsumegos/play/'.$lv.'?refresh=6";
													xpReward = ('.$t['Tsumego']['difficulty'].'*x3) + '.$user['User']['xp'].';
													userNextlvl = '.$user['User']['nextlvl'].';
													ulvl = '.$user['User']['level'].';
													if(mode==1 || mode==2) secondsy = seconds;
													if(mode==3) secondsy = seconds*10*'.$t['Tsumego']['id'].';
													document.cookie = "seconds="+secondsy;
													if(xpReward>userNextlvl){
														xpReward = userNextlvl;
														ulvl = ulvl + 1;
													}
													if(mode==1) runXPBar(true);
													if(mode==1) runXPNumber("account-bar-xp", userXP, xpReward, 1000, ulvl);
													noXP = true;
												}else{
													if(mode==1){
														secondsy = seconds;
														document.cookie = "correctNoPoints=1";
														document.cookie = "seconds="+secondsy;
													}
												}
											}else ';
										}elseif($mode==2 && $eloScore!=0){
											if($eloScore>100) $eloScore = 100;
											$elo2 = $user['User']['elo_rating_mode']+$eloScore;
											echo '
											if(coord.i=='.$masterArray[$i][0].'&&coord.j=='.$masterArray[$i][1].'
											&& move=='.$masterArray[$i][2].' && branch=="'.$masterArray[$i][3].'"){
												'.$sandboxCheck.'
												document.getElementById("status").style.color = "green";
												document.getElementById("status").innerHTML = "<h2>Correct!</h2>";
												document.getElementById("xpDisplay").style.color = "white";
												$("#commentSpace").show();
												branch = "'.$masterArray[$i][6].'";
												locked = true;
												noLastMark = true;
												if(!isNaN("'.$masterArray[$i][4].'")){
													whiteMoveAfterCorrect = true;
													whiteMoveAfterCorrectI = "'.$masterArray[$i][4].'";
													whiteMoveAfterCorrectJ = "'.$masterArray[$i][5].'";
												}
												if(!noXP){
													if(!doubleXP){
														x2 = "'.$score1.'";
														x3 = 1;
													}else{
														x2 = "'.$score2.'";
														x3 = 2;
													}
													if(goldenTsumego){
														x2 = "'.$score1.'";
														x3 = 1;
													}
													sequence += "correct|";
													updateCookie("score=","'.$score3.'");
													secondsy = seconds;
													if(mode==3) secondsy = seconds*10*'.$t['Tsumego']['id'].';
													document.cookie = "seconds="+secondsy;
													document.cookie = "sequence="+sequence;
													userElo = '.$elo2.';

													$("#skipButton").text("Next");
													document.getElementById("refreshLinkToStart").href = "/tsumegos/play/'.$lv.'?refresh=1";
													document.getElementById("refreshLinkToSets").href = "/tsumegos/play/'.$lv.'?refresh=2";
													if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/'.$lv.'?refresh=3";
													document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/'.$lv.'?refresh=4";
													document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/'.$lv.'?refresh=5";
													document.getElementById("refreshLinkToSandbox").href = "/tsumegos/play/'.$lv.'?refresh=6";
													xpReward = ('.$t['Tsumego']['difficulty'].'*x3) + '.$user['User']['xp'].';
													userNextlvl = '.$user['User']['nextlvl'].';
													ulvl = '.$user['User']['level'].';
													if(xpReward>userNextlvl){
														xpReward = userNextlvl;
														ulvl = ulvl + 1;
													}
													runXPBar(true);';
													echo 'runXPNumber("account-bar-xp", '.$user['User']['elo_rating_mode'].', '.$elo2.', 1000, ulvl);';
													echo 'noXP = true;
												}
											}else ';
										}
									}
								}
									//Incorrect no branch
									if($mode==1 || $mode==3){
										echo '{
										branch = "no";
										document.getElementById("status").style.color = "#e03c4b";
										document.getElementById("status").innerHTML = "<h2>Incorrect</h2>";
										if(mode==3) document.cookie = "rank='.$mode3ScoreArray[1].'";
										if(mode==3) locked = true;
										if(mode==3) document.cookie = "misplay=1";
										if(mode==3) seconds = seconds.toFixed(1);
										if(mode==3) secondsy = seconds*10*'.$t['Tsumego']['id'].';
										if(mode==3) document.cookie = "seconds="+secondsy;
										if(mode==3) timeModeEnabled = false;
										if(mode==3) $("#time-mode-countdown").css("color","#e45663");
										noLastMark = true;
										if(!noXP){
											if(!freePlayMode && !authorProblem){
												misplays++;
												document.cookie = "misplay="+misplays;
												if(mode==1 || mode==2) secondsy = seconds;
												if(mode==3) secondsy = seconds*10*'.$t['Tsumego']['id'].';
												document.cookie = "seconds="+secondsy;
												if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/'.$lv.'?refresh=3";
												document.getElementById("refreshLinkToStart").href = "/tsumegos/play/'.$lv.'?refresh=1";
												document.getElementById("refreshLinkToSets").href = "/tsumegos/play/'.$lv.'?refresh=2";
												document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/'.$lv.'?refresh=4";
												document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/'.$lv.'?refresh=5";
												document.getElementById("refreshLinkToSandbox").href = "/tsumegos/play/'.$lv.'?refresh=6";
												hoverLocked = false;
												if(mode==1) updateHealth();
											}
											freePlayMode = true;
											if('.$health.' - misplays<0){
												document.getElementById("currentElement").style.backgroundColor = "#e03c4b";
												document.getElementById("status").innerHTML = "<h2>Try again tomorrow</h2>";
												tryAgainTomorrow = true;
												locked = true;
											}
											if(goldenTsumego){
												document.cookie = "refinement=-1";
												window.location.href = "/tsumegos/play/'.$t['Tsumego']['id'].'";
											}
										}
										}';
									}elseif($mode==2){
										$elo2 = $user['User']['elo_rating_mode']-$eloScore;
										echo '{
										branch = "no";
										document.getElementById("status").style.color = "#e03c4b";
										document.getElementById("status").innerHTML = "<h2>Incorrect</h2>";
										noLastMark = true;
										if(!noXP){
											sequence += "incorrect|";
											document.cookie = "sequence="+sequence;
											document.cookie = "preId='.$t['Tsumego']['id'].'";
											playedWrong = true;
											runXPBar(false);
											$("#skipButton").text("Next");
											document.cookie = "misplay='.$eloScore.'";
											document.cookie = "seconds="+seconds;
											if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/'.$lv.'?refresh=3";
											document.getElementById("refreshLinkToStart").href = "/tsumegos/play/'.$lv.'?refresh=1";
											document.getElementById("refreshLinkToSets").href = "/tsumegos/play/'.$lv.'?refresh=2";
											document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/'.$lv.'?refresh=4";
											document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/'.$lv.'?refresh=5";
											document.getElementById("refreshLinkToSandbox").href = "/tsumegos/play/'.$lv.'?refresh=6";
											hoverLocked = false;
											tryAgainTomorrow = true;
											locked = true;
											freePlayMode = true;
											if('.$health.' - misplays<0){
												document.getElementById("currentElement").style.backgroundColor = "#e03c4b";
												document.getElementById("status").innerHTML = "<h2>Try again tomorrow</h2>";
											}
											if(goldenTsumego){
												document.cookie = "refinement=-1";
												window.location.href = "/tsumegos/play/'.$t['Tsumego']['id'].'";
											}
											ulvl = '.$user['User']['level'].';
											runXPNumber("account-bar-xp", '.$user['User']['elo_rating_mode'].', '.$elo2.', 1000, ulvl);
										}
										}';
									}

									echo 'document.cookie = "preId='.$t['Tsumego']['id'].'";';

									$whoPlays1 = 1;
									if($firstPlayer=='w') $whoPlays1 = 0;
									$whoPlays2 = 0;
									if($firstPlayer=='w') $whoPlays2 = 1;
							?>
							if(whiteMoveAfterCorrect){
								c2 = new JGO.Coordinate(whiteMoveAfterCorrectI, whiteMoveAfterCorrectJ);


							}
								var play = jboard.playMove(c2, <?php echo 'JGO.'.$playerColor[$whoPlays1]; ?>, ko);
								node = jrecord.createNode(true);
								jboard.setType(c2, <?php echo 'JGO.'.$playerColor[$whoPlays1]; ?>);
								node.setType(play.captures, JGO.CLEAR);
								if(!noLastMark) node.setMark(c2, JGO.MARK.CIRCLE);
								node.setMark(coord, JGO.MARK.NONE);

							if(josekiHero && move==0){
								<?php for($i=0; $i<count($visual); $i++){
									echo 'jboard.setMark(new JGO.Coordinate('.$visual[$i][0].', '.$visual[$i][1].'), JGO.MARK.CLEAR);';
								} ?>
							}

							if(josekiHero && josekiLevel<2){
								if(cVisualCount>0) node.setMark(cVisual0, JGO.MARK.CIRCLE);
								if(cVisualCount>1) node.setMark(cVisual1, JGO.MARK.CIRCLE);
								if(cVisualCount>2) node.setMark(cVisual2, JGO.MARK.CIRCLE);
								if(cVisualCount>3) node.setMark(cVisual3, JGO.MARK.CIRCLE);
								if(cVisualCount>4) node.setMark(cVisual4, JGO.MARK.CIRCLE);
								if(cVisualCount>5) node.setMark(cVisual5, JGO.MARK.CIRCLE);
								if(cVisualCount>6) node.setMark(cVisual6, JGO.MARK.CIRCLE);
								if(cVisualCount>7) node.setMark(cVisual7, JGO.MARK.CIRCLE);
								if(cVisualCount>8) node.setMark(cVisual8, JGO.MARK.CIRCLE);
								if(cVisualCount>9) node.setMark(cVisual9, JGO.MARK.CIRCLE);
								if(cVisualCount>10) node.setMark(cVisual10, JGO.MARK.CIRCLE);
							}else if(josekiLevel==2){
								if(cVisualCount==1) node.setMark(cVisual0, JGO.MARK.CIRCLE);
							}
							if(moveHasComment){
								if(!isCorrect){
									if(!isIncorrect) document.getElementById("theComment").style.cssText = "display:block;border:thick double grey;";
									document.getElementById("theComment").innerHTML = theComment;
								}
							}else{
								document.getElementById("theComment").style.cssText = "display:none;";
							}

							if(freePlayMode2 && !freePlayMode2done){
								if(player==JGO.BLACK) player=JGO.WHITE;
								else player=JGO.BLACK;
								freePlayMode2done = true;
							}

							if(!freePlayMode && !freePlayMode2) player = <?php echo 'JGO.'.$playerColor[$whoPlays2]; ?>;

							if(mode==3 && move>=1 && locked==false){
								tcount++;
								tcount++;
								seconds--;
								seconds--;
								$("#plus2").show();
								$("#plus2").fadeOut(600);
							}
							move++;
							hoverLocked = false;
						}, moveTimeout);
					}
				}else{
					hoverLocked = true;
					<?php
					echo 'if(rwLevel==0 && !pathLock){';
					for($i=0; $i<count($visual); $i++){
						echo 'if(coord.i=='.$visual[$i][0].'&&coord.j=='.$visual[$i][1].'){';
						echo 'currentI='.$visual[$i][0].';';
						echo 'currentJ='.$visual[$i][1].';';

						for($j=0; $j<count($visual); $j++){
							echo 'if(currentI=='.$visual[$j][0].'&&currentJ=='.$visual[$j][1].'){}else{';
								echo 'jboard.setType(new JGO.Coordinate('.$visual[$j][0].', '.$visual[$j][1].'), JGO.CLEAR);';
								echo 'jboard.setMark(new JGO.Coordinate('.$visual[$j][0].', '.$visual[$j][1].'), JGO.MARK.NONE);';
							echo '}';
						}
						if($visual[$i][4]!=='+'){
							echo 'if("'.$visual[$i][3].'"=="+") jboard.setMark(new JGO.Coordinate('.$visual[$i][4].', '.$visual[$i][5].'), JGO.MARK.CORRECT);';
							echo 'else jboard.setMark(new JGO.Coordinate('.$visual[$i][4].', '.$visual[$i][5].'), JGO.MARK.INCORRECT);';
							echo 'masterArrayPreI='.$visual[$i][4].';masterArrayPreJ='.$visual[$i][5].';';
						}
						echo 'rwBranch="'.$visual[$i][6].'";';
						echo 'rwLevel++;';
						echo '}else{';
							echo 'inPath=false;';
								for($k=0; $k<count($visual); $k++){
									echo 'if(coord.i=='.$visual[$k][0].'&&coord.j=='.$visual[$k][1].'){
										inPath=true;
									}';
								}
							echo 'if(!inPath){';
								for($k=0; $k<count($visual); $k++){
									echo 'jboard.setType(new JGO.Coordinate('.$visual[$k][0].', '.$visual[$k][1].'), JGO.CLEAR);';
									echo 'jboard.setMark(new JGO.Coordinate('.$visual[$k][0].', '.$visual[$k][1].'), JGO.MARK.NONE);';
								}
								echo 'pathLock=true;';
							echo '}';
						echo '}';
					}
					echo '}else if(rwLevel%2==1 && !pathLock){';
						for($i=0; $i<count($masterArray); $i++){
							echo 'if(('.$masterArray[$i][2].'*2+(-(rwLevel%2-2))==rwLevel) && (rwBranch=="'.$masterArray[$i][6].'")){
								if(coord.i==masterArrayPreI&&coord.j==masterArrayPreJ){
									if(rwLevel%rwSwitcher==0){';
										for($j=0; $j<count($visuals[$i]); $j++){
											echo 'if("'.$visuals[$i][$j][3].'"=="+") jboard.setMark(new JGO.Coordinate('.$visuals[$i][$j][0].', '.$visuals[$i][$j][1].'), JGO.MARK.CORRECT);';
											echo 'else jboard.setMark(new JGO.Coordinate('.$visuals[$i][$j][0].', '.$visuals[$i][$j][1].'), JGO.MARK.INCORRECT);';
										}
										echo 'rwLevel++;';
									echo '}';
								echo '}else{';
									echo 'if(rwLevel%rwSwitcher==0){';
										if($masterArray[$i][8]!=='+'){
											echo 'jboard.setType(new JGO.Coordinate('.$masterArray[$i][4].', '.$masterArray[$i][5].'), JGO.CLEAR);';
											echo 'jboard.setMark(new JGO.Coordinate('.$masterArray[$i][4].', '.$masterArray[$i][5].'), JGO.MARK.NONE);';

										}
										echo 'pathLock=true;';
									echo '}';
								echo '}';
							echo '}';
						}
					echo '}else if(rwLevel%2==0 && !pathLock){';
						for($i=0; $i<count($masterArray); $i++){
							echo 'if(('.$masterArray[$i][2].'*2+(-(rwLevel%2-2))==rwLevel) && (rwBranch=="'.$masterArray[$i][6].'")){';
								for($j=0; $j<count($visuals[$i]); $j++){
									echo 'if(coord.i=='.$visuals[$i][$j][0].'&&coord.j=='.$visuals[$i][$j][1].'){}else{';
										echo 'if(jboard.getType(new JGO.Coordinate('.$visuals[$i][$j][0].', '.$visuals[$i][$j][1].'))==0){';
											echo 'jboard.setType(new JGO.Coordinate('.$visuals[$i][$j][0].', '.$visuals[$i][$j][1].'), JGO.CLEAR);';
											echo 'jboard.setMark(new JGO.Coordinate('.$visuals[$i][$j][0].', '.$visuals[$i][$j][1].'), JGO.MARK.NONE);';
										echo '}';
									echo '}';
								}
								for($j=0; $j<count($visuals[$i]); $j++){
									echo 'if(coord.i=='.$visuals[$i][$j][0].'&&coord.j=='.$visuals[$i][$j][1].'){';
										echo 'if(rwLevel%rwSwitcher==0){';
											if($visuals[$i][$j][4]!=='+'){
												echo 'if("'.$visuals[$i][$j][3].'"=="+") jboard.setMark(new JGO.Coordinate('.$visuals[$i][$j][4].', '.$visuals[$i][$j][5].'), JGO.MARK.CORRECT);';
												echo 'else jboard.setMark(new JGO.Coordinate('.$visuals[$i][$j][4].', '.$visuals[$i][$j][5].'), JGO.MARK.INCORRECT);';
												echo 'masterArrayPreI='.$visuals[$i][$j][4].';masterArrayPreJ='.$visuals[$i][$j][5].';';
											}
											echo 'rwBranch="'.$visuals[$i][$j][6].'";';
											echo 'rwLevel++;';
										echo '}';
									echo '}else{';
										echo 'inPath=false;';
										echo 'if(rwLevel%rwSwitcher==0){';
											for($k=0; $k<count($visuals[$i]); $k++){
												echo 'if(coord.i=='.$visuals[$i][$k][0].'&&coord.j=='.$visuals[$i][$k][1].'){
													inPath=true;
												}else{

												}';
											}

											echo 'if(!inPath){';
												if($masterArray[$i][8]!=='+'){
												}
												echo 'pathLock=true;';
											echo '}';
										echo '}';
									echo '}';
								}
							echo '}';
						}
					echo '}rwSwitcher=(rwSwitcher==1)?2:1;';
					?>
				}
			}else{
				if(!safetyLock){
					<?php
					if($mode==1 || $mode==3) if($next!='0' && !$isSemeai) echo 'window.location = "/tsumegos/play/'.$next.'";';
					if($mode==2) echo 'window.location = "/tsumegos/play/'.$nextMode['Tsumego']['id'].'";';
					?>
				}
				safetyLock = true;
			}
		});

		canvas.addListener("mousemove", function(coord, ev){
			if(!locked){
				if(!hoverLocked){
					if(coord.i == -1 || coord.j == -1 || (coord.i == lastX && coord.j == lastY))
						return;

					if(lastHover)
						jboard.setType(new JGO.Coordinate(lastX, lastY), JGO.CLEAR);
					lastX = coord.i;
					lastY = coord.j;
					if(jboard.getType(coord) == JGO.CLEAR && jboard.getMark(coord) == JGO.MARK.NONE){
						jboard.setType(coord, player == JGO.WHITE ? JGO.DIM_WHITE : JGO.DIM_BLACK);
						lastHover = true;
					}else{
						lastHover = false;
					}
				}
			}
		});

		canvas.addListener("mouseout", function(ev){
			if(!locked){
				if(lastHover) jboard.setType(new JGO.Coordinate(lastX, lastY), JGO.CLEAR);
				lastHover = false;
			}
		});
	});
	<?php }else{ ?>
		$("#errorMessageOuter").show();
		$("#errorMessage").show();
		$("#errorMessage").text("<?php echo $sgfErrorMessage; ?>");

	<?php } ?>
	<?php } ?>

	function reset(){
		if(!tryAgainTomorrow) locked = false;
		hoverLocked = false;
		<?php
			if($ui!=2){
				echo 'player = JGO.'.$playerColor[$whoPlays2].';';
			}
		?>
		
		//player = <?php echo 'JGO.'.$playerColor[$whoPlays2]; ?>;
		opponent = (player == JGO.BLACK) ? JGO.WHITE : JGO.BLACK;
		ko = false, lastMove = false;
		lastHover = false, lastX = -1, lastY = -1;
		moveCounter = 0;
		isCorrect = false;
		isIncorrect = false;
		whiteMoveAfterCorrect = false;
		whiteMoveAfterCorrectI = 0;
		whiteMoveAfterCorrectJ = 0;
		disableAutoplay = false;
		branch = "";
		rw = false;
		boardSize = 19;
		<?php if($checkBSize!=19) echo 'boardSize = '.$checkBSize.';'; ?>
		var i, j;
		for (i=0;i<boardSize; i++){
			for (j=0;j<boardSize; j++){
				jboard.setType(new JGO.Coordinate(i, j), JGO.CLEAR);
				jboard.setMark(new JGO.Coordinate(i, j), JGO.MARK.NONE);
			}
		}
		tStatus = "<?php echo $t['Tsumego']['status']; ?>";
		if(tStatus=="setS2"||tStatus=="setC2") heartLoss = false;
		else heartLoss = true;

		if(move==0) heartLoss = false;
		if(noXP==true||freePlayMode==true||locked==true||authorProblem==true) heartLoss = false;
		if(mode==2) heartLoss = false;

		freePlayMode = false;
		freePlayMode2 = false;
		freePlayMode2done = false;
		if(heartLoss){
			misplays++;
			document.cookie = "misplay="+misplays;
			updateHealth();
		}
		move = 0;

		<?php
			for($i=0; $i<count($black); $i++){
				if($i%2 == 0){
					echo 'jboard.setType(new JGO.Coordinate('.$black[$i].', '.$black[$i+1].'), JGO.'.$playerColor[0].');';
				}
			}
			for($i=0; $i<count($white); $i++){
				if($i%2 == 0){
					echo 'jboard.setType(new JGO.Coordinate('.$white[$i].', '.$white[$i+1].'), JGO.'.$playerColor[1].');';
				}
			}
		?>

		if(josekiHero){<?php
			for($i=0; $i<count($visual); $i++){
				echo 'jboard.setMark(new JGO.Coordinate('.$visual[$i][0].', '.$visual[$i][1].'), JGO.MARK.CIRCLE);';
			}
		?>}

		<?php
		if($t['Tsumego']['set_id']==109 || $t['Tsumego']['set_id']==156 || $t['Tsumego']['set_id']==159 || $t['Tsumego']['set_id']==161){
			echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['lastPlayed'][0].', '.$additionalInfo['lastPlayed'][1].'), JGO.MARK.CIRCLE);';
			for($i=0; $i<count($additionalInfo['triangle']); $i++){
				echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['triangle'][$i][0].', '.$additionalInfo['triangle'][$i][1].'), JGO.MARK.TRIANGLE);';
			}
			for($i=0; $i<count($additionalInfo['square']); $i++){
				echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['square'][$i][0].', '.$additionalInfo['square'][$i][1].'), JGO.MARK.SQUARE);';
			}
		}
		?>
		document.getElementById("status").innerHTML = "";
		document.getElementById("theComment").style.cssText = "display:none;";
	}

	function skip(){
		if( $("#skipButton").text()!="Next" ) {
			document.cookie = "skip=1";
			document.cookie = "seconds="+seconds;
		}
		<?php echo 'window.location.href = "/tsumegos/play/'.$nextMode['Tsumego']['id'].'";'; ?>
	}

	function runXPBar(increase){
		<?php
			if($mode==1){
				$newXP = ($user['User']['xp'] + $t['Tsumego']['difficulty'])/$user['User']['nextlvl']*100;
				echo '
				if(!doubleXP) x2 = 1;
				else x2 = 2;
				userXP = '.$user['User']['xp'].';
				userDifficulty = '.$t['Tsumego']['difficulty'].'*x2;
				userNextlvl = '.$user['User']['nextlvl'].';
				newXP2 = (userXP+userDifficulty)/userNextlvl*100;
				newXP = '.$newXP.';
				if(newXP2>=100){
					newXP2=100;
					//if(soundsEnabled){setTimeout(function(){document.getElementsByTagName("audio")[1].play();},800);}
				}
				$("#xp-bar-fill").css({"width":newXP2+"%"});';
				?>
				$("#xp-bar-fill").css("-webkit-transition","all 1s ease");
				$("#xp-increase-fx").fadeIn(0);$("#xp-bar-fill").css({"-webkit-transition":"all 1s ease","box-shadow":""});
				setTimeout(function(){
					$("#xp-increase-fx").fadeOut(500);$("#xp-bar-fill").css({"-webkit-transition":"all 1s ease","box-shadow":""});
				},1000);
			<?php
			}elseif($mode==2){
				echo '
				if(!doubleXP) x2 = 1;
				else x2 = 2;
				userDifficulty = '.$t['Tsumego']['difficulty'].'*x2;
				userNextlvl = '.$user['User']['nextlvl'].';
				if(increase) newXP2 = '.substr($user['User']['elo_rating_mode'], -2).'+ '.$eloScore.';
				else newXP2 = '.substr($user['User']['elo_rating_mode'], -2).'- '.$eloScore.';
				if(newXP2>=100){
					newXP2=100;
					//if(soundsEnabled){setTimeout(function(){document.getElementsByTagName("audio")[1].play();},800);}
				}
				$("#xp-bar-fill").css({"width":newXP2+"%"});';
				?>
				$("#xp-bar-fill").css("-webkit-transition","all 1s ease");
				$("#xp-increase-fx").fadeIn(0);$("#xp-bar-fill").css({"-webkit-transition":"all 1s ease","box-shadow":""});
				setTimeout(function(){
					$("#xp-increase-fx").fadeOut(500);$("#xp-bar-fill").css({"-webkit-transition":"all 1s ease","box-shadow":""});
				},1000);
			<?php
			}elseif($mode==3){
				$xxx2 = (($crs+1)/$stopParameter)*100;
				if($xxx2>100) $xxx2 = 100;
				echo '
				$("#xp-bar-fill").css({"width":"'.$xxx2.'%"});';
				?>
				$("#xp-bar-fill").css("-webkit-transition","all 1s ease");
				$("#xp-increase-fx").fadeIn(0);$("#xp-bar-fill").css({"-webkit-transition":"all 1s ease","box-shadow":""});
				setTimeout(function(){
					$("#xp-increase-fx").fadeOut(500);$("#xp-bar-fill").css({"-webkit-transition":"all 1s ease","box-shadow":""});
				},1000);
			<?php
			}
		?>
	}

	function runXPNumber(id, start, end, duration, ulvl){
		userXP = end;
		userLevel = ulvl;
		var range = end - start;
		var current = start;
		var increment = end > start? 1 : -1;
		var stepTime = Math.abs(Math.floor(duration / range));
		var obj = document.getElementById(id);
		var timer = setInterval(function(){
			current += increment;
			<?php
			if($mode==1 || $mode==3) echo 'obj.innerHTML = current+"/'.$user['User']['nextlvl'].'";';
			elseif($mode==2) echo 'obj.innerHTML = current;';
			?>
			if(current == end){
				clearInterval(timer);
			}
		}, stepTime);
	}

	function updateHealth(){
		<?php
			$m = 1;
			while($health>0){
				$h = $health-1;
				echo 'if(misplays=='.$m.')document.getElementById("heart'.$h.'").src = "/img/'.$emptyHeart.'.png"; ';
				$health--;
				$m++;
			}
		?>
	}

	function sprint(){
		if(sprintEnabled){
			doubleXP = true;
			countDownDate = new Date();
			countDownDate.setMinutes(countDownDate.getMinutes() + 2);
			document.cookie = "doublexp="+countDownDate.getTime();
			document.cookie = "sprint=1";
			document.getElementById("sprint").src = "/img/hp1x.png";
			document.getElementById("sprint").style = "cursor: context-menu;";

			var x = setInterval(function(){
				if(mode==1 || $mode==3){
					if(doubleXP){
						var now = new Date().getTime();
						var distance = countDownDate - now;
						var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
						var seconds = Math.floor((distance % (1000 * 60)) / 1000);
						var timeOutput;
						if(minutes>2) document.cookie = "extendedSprint="+minutes;
						if(distance>=0){
							if(!sprintLockedInSecretArea){
								if(seconds<10)  timeOutput = minutes + ":0" + seconds;
								else 			timeOutput = minutes + ":" + seconds;
								document.getElementById("status2").innerHTML = "<h3>Double XP "+timeOutput+"</h3>";
								document.getElementById("status2").style.color = "blue";
								document.getElementById("xpDisplay").style.color = "blue";
								<?php
								if(!$goldenTsumego) echo 'document.getElementById("xpDisplay").innerHTML = \'<font size="4">'.$t['Tsumego']['difficulty'].'×2 XP</font>\';';
								else echo 'document.getElementById("xpDisplay").innerHTML = \'<font size="4">'.$t['Tsumego']['difficulty'].' XP</font>\';';
								?>
								document.cookie = "sprint=1";
							}else{
								window.location.href = "/sets";
							}
						}else{
							clearInterval(x);
							<?php
							if(isset($sprintActivated)) echo 'document.cookie = "sprint=2";';
							if($t['Tsumego']['status']=='setS2' || $t['Tsumego']['status']=='setC2'){
								echo '
									document.getElementById("xpDisplay").style.color = "green";
									document.getElementById("xpDisplay").innerHTML = \'<font size="4"><b>Solved</b> ('.$t['Tsumego']['difficulty'].' XP) '.$sandboxComment.'</font>\';
								';
							}else if($t['Tsumego']['status']=='setW2' || $t['Tsumego']['status']=='setX2'){
								echo '
									document.getElementById("xpDisplay").style.color = "'.$xpDisplayColor.'";
									document.getElementById("xpDisplay").innerHTML = \'<font size="4">  '.$t['Tsumego']['difficulty'].' XP (1/2) '.$sandboxComment.'</font>\';
								';
							}else{
								echo '
									document.getElementById("xpDisplay").style.color = "'.$xpDisplayColor.'";
									document.getElementById("xpDisplay").innerHTML = \'<font size="4">  '.$t['Tsumego']['difficulty'].' XP '.$sandboxComment.'</font>\';
								';
							}
							?>
							doubleXP = false;
						}
					}
				}else{
					if(eloScore!=0) document.getElementById("xpDisplay").innerHTML = '<font size="4">'+<?php echo $t['Tsumego']['userWin']; ?>+'%</font>';
					else document.getElementById("xpDisplay").innerHTML = '<font size="4">Recently visited</font>';
				}
			}, 250);

			sprintEnabled = false;
		}
	}

	<?php if($sgfErrorMessage===''){ ?>
	function intuition(){
		if(intuitionEnabled){
			<?php echo 'jboard.setMark(new JGO.Coordinate('.$intuitionMove[0].', '.$intuitionMove[1].'), JGO.MARK.CORRECT);'; ?>
			document.cookie = "intuition=1";
			document.getElementById("intuition").src = "/img/hp2x.png";
			document.getElementById("intuition").style = "cursor: context-menu;";
			intuitionEnabled = false;
		}
	}
	<?php } ?>

	function rejuvenation(){
		if(rejuvenationEnabled){
			<?php
				for($i=0; $i<$user['User']['health']; $i++) {
					echo 'document.getElementById("heart'.$i.'").src = "/img/'.$fullHeart.'.png";';
				}
				$negative = $user['User']['damage']*(-1);
				echo 'document.cookie = "misplay='.$negative.'";';
			?>
			misplays = 0;
			document.cookie = "rejuvenation=1";
			document.getElementById("rejuvenation").src = "/img/hp3x.png";
			document.getElementById("rejuvenation").style = "cursor: context-menu;";
			<?php if(isset($intuitionEnabled) &&!$intuitionEnabled) echo 'document.cookie = "intuition=2";'; ?>
			intuitionEnabled = true;
			rejuvenationEnabled = false;
			<?php echo 'window.location = "/tsumegos/play/'.$t['Tsumego']['id'].'";'; ?>
		}
	}

	function refinement(){
		if(refinementEnabled){
			document.cookie = "refinement=1";
			document.getElementById("refinement").src = "/img/hp4x.png";
			document.getElementById("refinement").style = "cursor: context-menu;";
			<?php echo 'window.location.href = "/tsumegos/play/'.$g['Tsumego']['id'].'";'; ?>
		}
		refinementEnabled = false;
	}

	if(document.querySelector("input[name=favCheckbox]")){
		var checkbox = document.querySelector("input[name=favCheckbox]");
		checkbox.addEventListener('change', function(){
			if(this.checked){
				<?php if(!$favorite){ ?>
					document.cookie = "favorite=<?php echo $t['Tsumego']['id']; ?>";
					document.getElementById("refreshLinkToStart").href = "/tsumegos/play/<?php echo $lv ?>?refresh=1";
					document.getElementById("refreshLinkToSets").href = "/tsumegos/play/<?php echo $lv ?>?refresh=2";
					document.getElementById("playTitleA").href = "/tsumegos/play/<?php echo $lv ?>?refresh=3";
					document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/<?php echo $lv ?>?refresh=4";
					document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/'.$lv.'?refresh=5";
					document.getElementById("refreshLinkToSandbox").href = "/tsumegos/play/'.$lv.'?refresh=6";
				<?php }else{ ?>
					document.cookie = "favorite=0";
					document.getElementById("refreshLinkToStart").href = "/";
					document.getElementById("refreshLinkToSets").href = "/sets";
					document.getElementById("playTitleA").href = "/sets/view/<?php echo $t['Tsumego']['set_id']; ?>";
					document.getElementById("refreshLinkToHighscore").href = "/users/highscore";
					document.getElementById("refreshLinkToDiscuss").href = "/comments";
					document.getElementById("refreshLinkToSandbox").href = "/sets/beta";
				<?php } ?>
				document.getElementById("favCheckbox2").setAttribute("title", "Marked as favorite");
			}else{
				<?php if(!$favorite){ ?>
					document.cookie = "favorite=0";
					document.getElementById("refreshLinkToStart").href = "/";
					document.getElementById("refreshLinkToSets").href = "/sets";
					document.getElementById("playTitleA").href = "/sets/view/<?php echo $t['Tsumego']['set_id']; ?>";
					document.getElementById("refreshLinkToHighscore").href = "/users/highscore";
					document.getElementById("refreshLinkToDiscuss").href = "/comments";
					document.getElementById("refreshLinkToSandbox").href = "/sets/beta";
				<?php }else{ ?>
					document.cookie = "favorite=-<?php echo $t['Tsumego']['id']; ?>";
					document.getElementById("refreshLinkToStart").href = "/tsumegos/play/<?php echo $lv ?>?refresh=1";
					document.getElementById("refreshLinkToSets").href = "/tsumegos/play/<?php echo $lv ?>?refresh=2";
					document.getElementById("playTitleA").href = "/tsumegos/play/<?php echo $lv ?>?refresh=3";
					document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/<?php echo $lv ?>?refresh=4";
					document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/'.$lv.'?refresh=5";
					document.getElementById("refreshLinkToSandbox").href = "/tsumegos/play/'.$lv.'?refresh=6";
				<?php } ?>
				document.getElementById("favCheckbox2").setAttribute("title", "Mark as favorite");
			}
		});
	}

	function modeCheckbox(v){
		if(v==1){
			document.cookie = "ui=1";
			window.location = "/tsumegos/play/"+<?php echo $nextMode['Tsumego']['id']; ?>+"?ui=1";
		}else if(v==2){
			document.cookie = "ui=2";
			window.location = "/tsumegos/play/"+<?php echo $nextMode['Tsumego']['id']; ?>+"?ui=2";
		}
	}

	function txx(v){
		if(v==1){
			document.cookie = "mode=3";
		}else if(v==2){
			document.cookie = "mode=1";
		}
		window.location = "/tsumegos/play/<?php echo $next; ?>";
	}

	function sprintHover(){
		if(sprintEnabled) document.getElementById("sprint").src = '/img/hp1h.png';
	}
	function sprintNoHover(){
		if(sprintEnabled) document.getElementById("sprint").src = "/img/hp1.png";
	}
	function intuitionHover(){
		if(intuitionEnabled) document.getElementById("intuition").src = '/img/hp2h.png';
	}
	function intuitionNoHover(){
		if(intuitionEnabled) document.getElementById("intuition").src = "/img/hp2.png";
	}
	function rejuvenationHover(){
		if(rejuvenationEnabled) document.getElementById("rejuvenation").src = '/img/hp3h.png';
	}
	function rejuvenationNoHover(){
		if(rejuvenationEnabled) document.getElementById("rejuvenation").src = "/img/hp3.png";
	}
	function refinementHover(){
		if(refinementEnabled) document.getElementById("refinement").src = '/img/hp4h.png';
	}
	function refinementNoHover(){
		if(refinementEnabled) document.getElementById("refinement").src = "/img/hp4.png";
	}
	function thumbsUpHover(){
		if(!thumbsUpSelected && !thumbsUpSelected2) document.getElementById("thumbs-up").src = '/img/thumbs-up.png';
	}
	function thumbsUpNoHover(){
		if(!thumbsUpSelected && !thumbsUpSelected2) document.getElementById("thumbs-up").src = '/img/thumbs-up-inactive.png';
	}
	function thumbsDownHover(){
		if(!thumbsDownSelected && !thumbsDownSelected2) document.getElementById("thumbs-down").src = '/img/thumbs-down.png';
	}
	function thumbsDownNoHover(){
		if(!thumbsDownSelected && !thumbsDownSelected2) document.getElementById("thumbs-down").src = '/img/thumbs-down-inactive.png';
	}
	function thumbsUp(){
		<?php echo 'document.cookie = "reputation='.$t['Tsumego']['id'].'";'; ?>
		document.getElementById("thumbs-up").src = '/img/thumbs-up.png';
		document.getElementById("thumbs-down").src = '/img/thumbs-down-inactive.png';
		thumbsUpSelected = true;
		thumbsDownSelected = false;
		thumbsDownSelected2 = false;
	}
	function thumbsDown(){
		<?php echo 'document.cookie = "reputation=-'.$t['Tsumego']['id'].'";'; ?>
		document.getElementById("thumbs-down").src = '/img/thumbs-down.png';
		document.getElementById("thumbs-up").src = '/img/thumbs-up-inactive.png';
		thumbsDownSelected = true;
		thumbsUpSelected = false;
		thumbsUpSelected2 = false;
	}

	function selectA(){
		if(!multipleChoiceSelected){
			<?php
				echo $a1;
				echo $x2;
				echo $multipleChoiceCorrect;
			?>
			multipleChoiceSelected = true;
		}
	}
	function selectB(){
		if(!multipleChoiceSelected){
			<?php
				echo $b1;
				echo $x2;
				echo $multipleChoiceCorrect;
			?>
			multipleChoiceSelected = true;
		}
	}
	function selectC(){
		if(!multipleChoiceSelected){
			<?php
				echo $c1;
				echo $x2;
				echo $multipleChoiceCorrect;
			?>
			multipleChoiceSelected = true;
		}
	}
	function selectD(){
		if(!multipleChoiceSelected){
			<?php
				echo $d1;
				echo $x2;
				echo $multipleChoiceCorrect;
			?>
			multipleChoiceSelected = true;
		}
	}

	function selectFav(){
		document.getElementById("ans2").innerHTML = "";
	}

	/*
	$(document).keydown(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '82'){
			reset();
		}
	});
	*/
	function m1hover(){
		$("#modeSwitcher1 label").css("background-color", "#5dcb89");
	}
	function m1noHover(){
		if(ui==1) $("#modeSwitcher1 label").css("background-color", "#54b97c");
		else $("#modeSwitcher1 label").css("background-color", "#5b5d60");
	}
	function m2hover(){
		$("#modeSwitcher2 label").css("background-color", "#ca7a6f");
	}
	function m2noHover(){
		if(ui==2) $("#modeSwitcher2 label").css("background-color", "#ca6658");
		else $("#modeSwitcher2 label").css("background-color", "#5b5d60");
	}
	function goMode3x(){
		<?php echo 'window.location.href = "/ranks/overview";'; ?>
	}

	function review(){
		if(reviewEnabled){
			hoverLocked = true;
			rw = true;
			if(!tryAgainTomorrow) locked = false;
			freePlayMode = false;

			<?php
				if($ui!=2){
					echo 'player = JGO.'.$playerColor[$whoPlays2].';';
				}
			?>
			
			
			opponent = (player == JGO.BLACK) ? JGO.WHITE : JGO.BLACK;
			ko = false, lastMove = false;
			lastHover = false, lastX = -1, lastY = -1;
			moveCounter = 0;
			move = 0;
			rwLevel = 0;
			rwBranch = 0;
			rwSwitcher = 2;
			inPath = false;
			pathLock = false;

			$(".reviewNavi").fadeIn(250);

			boardSize = 19;
			<?php if($checkBSize!=19) echo 'boardSize = '.$checkBSize.';'; ?>
			var i, j;
			for (i=0;i<boardSize; i++) {
				for (j=0;j<boardSize; j++) {
					jboard.setType(new JGO.Coordinate(i, j), JGO.CLEAR);
					jboard.setMark(new JGO.Coordinate(i, j), JGO.MARK.NONE);
				}
			}

			document.getElementById("status").innerHTML = "";
			<?php
				for($i=0; $i<count($black); $i++){
					if($i%2 == 0){
						echo 'jboard.setType(new JGO.Coordinate('.$black[$i].', '.$black[$i+1].'), JGO.'.$playerColor[0].');';
					}
				}
				for($i=0; $i<count($white); $i++){
					if($i%2 == 0){
						echo 'jboard.setType(new JGO.Coordinate('.$white[$i].', '.$white[$i+1].'), JGO.'.$playerColor[1].');';
					}
				}
			?>

			<?php
			if($t['Tsumego']['set_id']==109 || $t['Tsumego']['set_id']==156 || $t['Tsumego']['set_id']==159 || $t['Tsumego']['set_id']==161){
				echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['lastPlayed'][0].', '.$additionalInfo['lastPlayed'][1].'), JGO.MARK.CIRCLE);';
				for($i=0; $i<count($additionalInfo['triangle']); $i++){
					echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['triangle'][$i][0].', '.$additionalInfo['triangle'][$i][1].'), JGO.MARK.TRIANGLE);';
				}
				for($i=0; $i<count($additionalInfo['square']); $i++){
					echo 'jboard.setMark(new JGO.Coordinate('.$additionalInfo['square'][$i][0].', '.$additionalInfo['square'][$i][1].'), JGO.MARK.SQUARE);';
				}
			}
			?>
			<?php
			for($i=0; $i<count($visual); $i++){
				if($visual[$i][3] === '+') echo 'jboard.setMark(new JGO.Coordinate('.$visual[$i][0].', '.$visual[$i][1].'), JGO.MARK.CORRECT);';
				else echo 'jboard.setMark(new JGO.Coordinate('.$visual[$i][0].', '.$visual[$i][1].'), JGO.MARK.INCORRECT);';
			}
			?>
			document.getElementById("theComment").style.cssText = "display:none;";
		}
	}

	<?php
	$fn = 1;
	for($i=0; $i<count($coordMarkers); $i++){
		//for($j=0; $j<count($coordMarkers[$i]); $j++){
		for($j=count($coordMarkers[$i])-1; $j>=0; $j--){
			//echo 'alert("!'.$e[$j].'");';
			if(strlen($coordMarkers[$i][$j])>2){
				$c = explode('-', $coordMarkers[$i][$j]);
				echo 'function commentCoordinateIn'.$fn.'(){jboard.setMark(new JGO.Coordinate('.$c[0].', '.$c[1].'), JGO.MARK.SELECTED);}';
				echo 'function commentCoordinateOut'.$fn.'(){jboard.setMark(new JGO.Coordinate('.$c[0].', '.$c[1].'), JGO.MARK.NONE);}';
				$fn++;
			}
		}
	}
	$fn1 = 1;
	for($i=0; $i<count($commentCoordinates); $i++){
		$n2x = explode(' ', $commentCoordinates[$i]);
		if(count($n2x)>0){
			$fn2 = 1;
			for($j=count($n2x)-1; $j>=0; $j--){
				$n2xx = explode('-', $n2x[$j]);
				if(strlen($n2xx[0])>0 && strlen($n2xx[1])>0){
					echo 'function ccIn'.$fn1.$fn2.'(){jboard.setMark(new JGO.Coordinate('.$n2xx[0].', '.$n2xx[1].'), JGO.MARK.SELECTED);}';
					echo 'function ccOut'.$fn1.$fn2.'(){jboard.setMark(new JGO.Coordinate('.$n2xx[0].', '.$n2xx[1].'), JGO.MARK.NONE);}';
					$fn2++;
				}
			}
		}
		$fn1++;
	}

	$fn1 = 999;
	$n2x = explode(' ', $sT[1]);
	if(count($n2x)>0){
		$fn2 = 1;
		for($j=count($n2x)-1; $j>=0; $j--){
			$n2xx = explode('-', $n2x[$j]);
			if(strlen($n2xx[0])>0 && strlen($n2xx[1])>0){
				echo 'function ccIn'.$fn1.$fn2.'(){jboard.setMark(new JGO.Coordinate('.$n2xx[0].', '.$n2xx[1].'), JGO.MARK.SELECTED);}';
				echo 'function ccOut'.$fn1.$fn2.'(){jboard.setMark(new JGO.Coordinate('.$n2xx[0].', '.$n2xx[1].'), JGO.MARK.NONE);}';
				$fn2++;
			}
		}
	}
	$fn1++;

	?>

	function displayResult(result){
		if(result=='S'){
			if(mode!=2){//mode 1 and 3 correct
				<?php echo $sandboxCheck; ?>
				document.getElementById("status").style.color = "green";
				document.getElementById("status").innerHTML = "<h2>Correct!</h2>";
				document.getElementById("xpDisplay").style.color = "white";
				if(set159){document.getElementById("theComment").style.cssText = "visibility:visible;color:green;";
				document.getElementById("theComment").innerHTML = "xxx";}
				if(moveHasComment){isCorrect=true;document.getElementById("theComment").style.cssText = "display:block;border:thick double green;";
				}else{document.getElementById("theComment").style.cssText = "display:none;border:thick double green;";}
				$("#commentSpace").show();
				//locked = true;
				if(mode==3){
					document.cookie = "rank=<?php echo $mode3ScoreArray[0]; ?>";
					//seconds = seconds.toFixed(1);
					secondsy = seconds*10*<?php echo $t['Tsumego']['id']; ?>;
					document.cookie = "seconds="+secondsy;
					timeModeEnabled = false;
					document.cookie = "score=<?php echo $score1; ?>";
					document.cookie = "preId=<?php echo $t['Tsumego']['id']; ?>";
					$("#time-mode-countdown").css("color","green");
					$("#reviewButton").show();
					$("#reviewButton-inactive").hide();
					runXPBar(true);
				}
				noLastMark = true;
				reviewEnabled = true;
				$("#besogo-review-button-inactive").attr("id","besogo-review-button");
				if(!noXP){
					if(!doubleXP){
						x2 = "<?php echo $score1; ?>";
						x3 = 1;
					}else{
						x2 = "<?php echo $score2; ?>";
						x3 = 2;
					}
					if(goldenTsumego){
						x2 = "<?php echo $score1; ?>";
						x3 = 1;
					}
					updateCookie("score=",x2);
					$("#skipButton").text("Next");
					document.getElementById("refreshLinkToStart").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=1";
					document.getElementById("refreshLinkToSets").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=2";
					if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=3";
					document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=4";
					document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=5";
					xpReward = (<?php echo $t['Tsumego']['difficulty']; ?>*x3) + <?php echo $user['User']['xp']; ?>;
					userNextlvl = <?php echo $user['User']['nextlvl']; ?>;
					ulvl = <?php echo $user['User']['level']; ?>;
					if(mode==1 || mode==2) secondsy = seconds;
					if(mode==3) secondsy = seconds*10*<?php echo $t['Tsumego']['id']; ?>;
					document.cookie = "seconds="+secondsy;
					if(xpReward>userNextlvl){
						xpReward = userNextlvl;
						ulvl = ulvl + 1;
					}
					if(mode==1) runXPBar(true);
					if(mode==1) runXPNumber("account-bar-xp", userXP, xpReward, 1000, ulvl);
					noXP = true;
				}else{
					if(mode==1){
						secondsy = seconds;
						document.cookie = "correctNoPoints=1";
						document.cookie = "seconds="+secondsy;
					}
				}
			}else if(eloScore!=0){//mode 2 correct
				if(eloScore>100) eloScore = 100;
				elo2 = <?php echo $user['User']['elo_rating_mode']; ?>+eloScore;
				document.getElementById("status").style.color = "green";
				document.getElementById("status").innerHTML = "<h2>Correct!</h2>";
				document.getElementById("xpDisplay").style.color = "white";
				$("#commentSpace").show();
				//locked = true;
				noLastMark = true;
				besogoMode2Solved = true;
				reviewEnabled = true;
				$("#besogo-review-button-inactive").attr("id","besogo-review-button");
				$("#besogo-next-button-inactive").attr("id","besogo-next-button");
				if(!noXP){
					sequence += "correct|";
					updateCookie("score=","<?php echo $score3; ?>");
					secondsy = seconds;
					document.cookie = "seconds="+secondsy;
					document.cookie = "sequence="+sequence;
					document.getElementById("refreshLinkToStart").href = "/tsumegos/play/'.$lv.'?refresh=1";
					document.getElementById("refreshLinkToSets").href = "/tsumegos/play/'.$lv.'?refresh=2";
					if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/'.$lv.'?refresh=3";
					document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/'.$lv.'?refresh=4";
					document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/'.$lv.'?refresh=5";
					document.getElementById("refreshLinkToSandbox").href = "/tsumegos/play/'.$lv.'?refresh=6";
					xpReward = (<?php echo $t['Tsumego']['difficulty']; ?>) + <?php echo $user['User']['xp']; ?>;
					userNextlvl = <?php echo $user['User']['nextlvl']; ?>;
					ulvl = <?php echo $user['User']['level']; ?>;
					if(xpReward>userNextlvl){
						xpReward = userNextlvl;
						ulvl = ulvl + 1;
					}
					runXPBar(true);
					runXPNumber("account-bar-xp", <?php echo $user['User']['elo_rating_mode']; ?>, elo2, 1000, ulvl);
					noXP = true;
				}
			}
		}else{//mode 1 and 3 incorrect
			if(mode!=2){
				branch = "no";
				document.getElementById("status").style.color = "#e03c4b";
				document.getElementById("status").innerHTML = "<h2>Incorrect</h2>";
				if(mode==3){
					document.cookie = "rank=<?php echo $mode3ScoreArray[1]; ?>";
					//locked = true;
					document.cookie = "misplay=1";
					seconds = seconds.toFixed(1);
					secondsy = seconds*10*<?php echo $t['Tsumego']['id']; ?>;
					document.cookie = "seconds="+secondsy;
					timeModeEnabled = false;
					$("#time-mode-countdown").css("color","#e45663");
				}
				noLastMark = true;
				if(!noXP){
					if(!freePlayMode && !authorProblem){
						misplays++;
						document.cookie = "misplay="+misplays;
						if(mode==1 || mode==2) secondsy = seconds;
						if(mode==3) secondsy = seconds*10*<?php echo $t['Tsumego']['id']; ?>;
						document.cookie = "seconds="+secondsy;
						if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=3";
						document.getElementById("refreshLinkToStart").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=1";
						document.getElementById("refreshLinkToSets").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=2";
						document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=4";
						document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=5";
						hoverLocked = false;
						if(mode==1) updateHealth();
					}
					freePlayMode = true;
					if(mode==1){
						if(<?php echo $user['User']['health'] - $user['User']['damage']; ?> - misplays<0){
							document.getElementById("currentElement").style.backgroundColor = "#e03c4b";
							document.getElementById("status").innerHTML = "<h2>Try again tomorrow</h2>";
							tryAgainTomorrow = true;
							//locked = true;
						}
					}
					if(goldenTsumego){
						document.cookie = "refinement=-1";
						window.location.href = "/tsumegos/play/<?php echo $t['Tsumego']['id']; ?>";
					}
				}
			}else{//mode 2 incorrect
				elo2 = <?php echo $user['User']['elo_rating_mode']; ?>-eloScore;
				branch = "no";
				document.getElementById("status").style.color = "#e03c4b";
				document.getElementById("status").innerHTML = "<h2>Incorrect</h2>";
				noLastMark = true;
				$("#besogo-next-button-inactive").attr("id","besogo-next-button");
				if(!noXP){
					sequence += "incorrect|";
					document.cookie = "sequence="+sequence;
					playedWrong = true;
					runXPBar(false);
					$("#skipButton").text("Next");
					document.cookie = "misplay="+eloScore;
					document.cookie = "seconds="+seconds;
					if(document.getElementById("playTitleA")) document.getElementById("playTitleA").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=3";
					document.getElementById("refreshLinkToStart").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=1";
					document.getElementById("refreshLinkToSets").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=2";
					document.getElementById("refreshLinkToHighscore").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=4";
					document.getElementById("refreshLinkToDiscuss").href = "/tsumegos/play/<?php echo $lv; ?>?refresh=5";
					hoverLocked = false;
					tryAgainTomorrow = true;
					//locked = true;
					freePlayMode = true;
					ulvl = <?php echo $user['User']['level']; ?>;
					runXPNumber("account-bar-xp", <?php echo $user['User']['elo_rating_mode']; ?>, elo2, 1000, ulvl);
				}
			}
		}
		document.cookie = "preId=<?php echo $t['Tsumego']['id']; ?>";
	}

	function toggleBoardLock(t){
		if(t){
			let besogoBoardHeight = $('.besogo-board').height() + "px";
			$("#targetLockOverlay").css("width", "633px");
			$("#targetLockOverlay").css("height", besogoBoardHeight);
			$("#targetLockOverlay").css("z-index", "1000");
			
		}else{
			$("#targetLockOverlay").css("width", "0");
			$("#targetLockOverlay").css("height", "0");
			$("#targetLockOverlay").css("z-index", "-1");
		}
	}

	</script>
	<?php if($ui==2){ ?>
	<script type="text/javascript">
	(function() {
	  var options = { },
		  searchString = location.search.substring(1), // Drop question mark
		  params = searchString.split("&"),
		  div = document.getElementById('target'), // Target div
		  i, value; // Scratch iteration variables

	  for (i = 0; i < params.length; i++)
	  {
		value = params[i].split("="); // Splits on all "=" symbols
		options[value.shift()] = value.join("="); // First "=" separates value from name, rest are part of value
	  }
	  <?php 
	  if($_SESSION['loggedInUser']['User']['isAdmin']>0) echo 'options.panels = "tree+control+tool";';//echo 'options.panels = "tree+control+tool+comment+file";';
	  else 'options.panels = "tree+control";';
	  ?> 
	  options.tsumegoPlayTool = 'auto';
	  options.realstones = true;
	  options.nowheel = true;
	  options.nokeys = true;
	  
	  const cornerArray = ['top-left', 'top-right', 'bottom-left', 'bottom-right'];
	  shuffledCornerArray = cornerArray.sort((a, b) => 0.5 - Math.random());
	  options.corner = shuffledCornerArray[0];
	  
	  besogoCorner = options.corner;
	  options.theme = '<?php echo $choice[0][1]; ?>';
	  options.themeParameters = ['<?php echo $choice[0][2]; ?>', '<?php echo $choice[0][3]; ?>'];
	  options.coord = 'western';
	  // COORDS = 'none numeric western eastern pierre corner eastcor'.split(' '),
	  options.sgf = 'https://<?php echo $_SERVER['HTTP_HOST']; ?>/'+'<?php echo $file; ?>';
	  //options.sgf = 'https://<?php echo $_SERVER['HTTP_HOST']; ?>/'+'<?php echo $file; ?>'+'<?php echo $requestProblem; ?>';
	  if (options.theme) addStyleLink('https://<?php echo $_SERVER['HTTP_HOST']; ?>/besogo/css/board-'+options.theme+'.css');
		//addStyleLink('css/board-' + options.theme + '.css');
	  if (options.height && options.width && options.resize === 'fixed')
	  {
		div.style.height = options.height + 'px';
		div.style.width = options.width + 'px';
	  }
	  besogo.create(div, options);

	  function addStyleLink(cssURL)
	  {
		var element = document.createElement('link');
		element.href = cssURL;
		element.type = 'text/css';
		element.rel = 'stylesheet';
		
		document.head.appendChild(element);
	  }
	})();
	
			//$(".besogo-tsumegoPlayTool input:nth-last-child(1)").attr('id', 'besogo-tsumegoPlayTool-rButton');
		
		if(mode==2) $("#targetLockOverlay").css('top', '235px');
		//$(".besogo-tsumegoPlayTool input:nth-last-child(2)").attr('id', 'besogo-tsumegoPlayTool-rButton');
		//$(".besogo-tsumegoPlayTool input:nth-last-child(2)").attr('class', 'besogo-tsumegoPlayTool-rButton2');
		//if(nextButtonLink==0) $(".besogo-tsumegoPlayTool input:nth-last-child(2)").attr('class', 'besogo-tsumegoPlayTool-rButton2');
	
	</script>
	<?php } ?>
	<style>
	.besogo-panels{
		display: none;
		flex-basis: 50%;
	}
	</style>
