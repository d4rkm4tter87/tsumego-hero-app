
<?php
	$noImage = false;
	
	if($isFav) $noImage = true;
	if($set['Set']['id']==11969 || $set['Set']['id']==29156 || $set['Set']['id']==31813 || $set['Set']['id']==33007 
	|| $set['Set']['id']==71790 || $set['Set']['id']==74761 || $set['Set']['id']==81578 || $set['Set']['id']==88156){
		$noImage = true;
		if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['secretArea1']==0 && $set['Set']['id']==11969) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea2']==0 && $set['Set']['id']==29156) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea3']==0 && $set['Set']['id']==31813) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea4']==0 && $set['Set']['id']==33007) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea5']==0 && $set['Set']['id']==71790) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea6']==0 && $set['Set']['id']==74761) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea7']==0 && $set['Set']['id']==81578) echo '<script type="text/javascript">window.location.href = "/";</script>';
			if($_SESSION['loggedInUser']['User']['secretArea10']=='0' && $set['Set']['id']==88156) echo '<script type="text/javascript">window.location.href = "/";</script>';
		}else{
			echo '<script type="text/javascript">window.location.href = "/";</script>';
		}
	}
	if($set['Set']['public']==0){
		if(isset($_SESSION['loggedInUser'])){
		}else{
			echo '<script type="text/javascript">window.location.href = "/";</script>';
		}
	}
	if(isset($formRedirect)) echo '<script type="text/javascript">window.location.href = "/sets/view/'.$set['Set']['id'].'";</script>';
?>
	<div class="homeRight">
		<p class="title4">Problems</p>
		<br>
		<?php
		if($set['Set']['id']!=1) $fav = '';
		else $fav = '?favorite=1';
		
		if($set['Set']['id']!=58 && $set['Set']['id']!=62 && $set['Set']['id']!=91 && $set['Set']['id']!=72 && $set['Set']['id']!=73 && $set['Set']['id']!=74 
		&& $set['Set']['id']!=75 && $set['Set']['id']!=76 && $set['Set']['id']!=77 && $set['Set']['id']!=78 && $set['Set']['id']!=79 && $set['Set']['id']!=80
		&& $set['Set']['id']!=51 && $set['Set']['id']!=56 && $set['Set']['id']!=57 && $set['Set']['id']!=119 
		&& $set['Set']['id']!=119 && $set['Set']['id']!=126 && $set['Set']['id']!=129 && $set['Set']['id']!=134 && $set['Set']['id']!=135){
			$beta2 = false;
		}else $beta2 = true;
		if($_SESSION['loggedInUser']['User']['id']==72) $beta2 = false;
		
		if(!$beta2){
			$josekiThumb = '';
			$josekiThumb2 = '';
			for($i=0; $i<count($ts); $i++){
				if(!isset($ts[$i]['Tsumego']['status'])) $ts[$i]['Tsumego']['status'] = 'N';
				if($josekiOrder==0){
					$num = $ts[$i]['Tsumego']['num'];
					$num = '<div class="setViewButtons1">'.$num.'</div>';
					$persormanceS = substr_count($ts[$i]['Tsumego']['performance'], '1');
					$persormanceF = substr_count($ts[$i]['Tsumego']['performance'], 'F');
					if($persormanceS==0 && $persormanceF==0) $num2 = '-';
					else $num2 = $persormanceS.'/'.$persormanceF;
					$num2 = '<div class="setViewButtons2">'.$num2.'</div>';
					if($ts[$i]['Tsumego']['seconds']=='') $num3 = '-';
					else $num3 = $ts[$i]['Tsumego']['seconds'].'s';
					$num3 = '<div class="setViewButtons3">'.$num3.'</div>';
				}
				elseif($josekiOrder==1) $num = $ts[$i]['Tsumego']['order'];
				if($set['Set']['id']==161){
					$jt = 'josekiThumb1.png';
					if($ts[$i]['Tsumego']['type']==1) $jt = 'josekiThumb1.png';
					elseif( $ts[$i]['Tsumego']['type']==2) $jt = 'josekiThumb2.png';
					$josekiThumb = '<br><img src="/img/'.$jt.'" width="45px"><span id="tooltip-span"><img width="200px" alt="" src="/img/thumbs/'.$ts[$i]['Tsumego']['thumbnail'].'.PNG"/></span>';
					$josekiThumb2 = 'class="tooltip"';
					$josekiButton = 'style="background-image: url(\'/img/viewButton3.png\');"';
				}
				
				echo '<li class="set'.$ts[$i]['Tsumego']['status'].'1" '.$josekiButton.'>
					<a '.$josekiThumb2.' href="/tsumegos/play/'
					.$ts[$i]['Tsumego']['id'].$fav.'">'.$num.$num2.$num3.$josekiThumb.'</a></li>';
			}
		}
		
		if($set['Set']['public']==0){
			if(isset($_SESSION['loggedInUser'])){
				if($_SESSION['loggedInUser']['User']['isAdmin']>0){
					
					//echo '<li class="setA1"><a href="/sets/view/'.$set['Set']['id'].'?add=1">+</a></li>';
					
					echo '<div align="left" width="100%">';
					
					echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
					if(isset($_SESSION['loggedInUser'])){
						if($_SESSION['loggedInUser']['User']['id']==72 && $set['Set']['id']==161){
							if($josekiOrder==0) echo '<a class="new-button new-buttonx" href="/sets/view/161?show=order">show order</a>';
							elseif($josekiOrder==1) echo '<a class="new-button new-buttonx" href="/sets/view/161?show=num">show num</a>';
							
							echo '<a class="new-button new-buttonx" href="/sets/view/161?sort=1">sort</a>';
							echo '<a class="new-button new-buttonx" href="/sets/view/161?rename=1">rename</a>';
							echo '<br><br>';
						}
					}
					
					echo '</div>';
				}
			}
		}
		?>
	</div>
	
	<div class="homeLeft">
		<?php 
		//if($set['Set']['title2']==null) $set['Set']['title2'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<p class="title4">'.$set['Set']['title'].'</p>';?>
		<div class="new1">
		<table border="0" width="100%">
		<tr>
			<td style="vertical-align:top;">
				<?php 
				
				$saNum;
				$tierReward = array();
				$tierReward[11] = '';
				$tierReward[10] = 'Premium Reward.';
				$tierReward[9] = 'Level 40 Reward.';
				$tierReward[8] = 'Level 45 Reward.';
				$tierReward[7] = 'Level 50 Reward.';
				$tierReward[6] = 'Level 55 Reward.';
				$tierReward[5] = 'Level 60 Reward.';
				$tierReward[4] = 'Premium Reward.';
				$tierReward[3] = 'Level 70 Reward.';
				
				if($set['Set']['image']=='sa-pretty.jpg') $saNum=9;
				else if($set['Set']['image']=='sa-hunting.jpg') $saNum=8;
				else if($set['Set']['image']=='sa-ghost.jpg') $saNum=7;
				else if($set['Set']['image']=='sa-carnage.jpg') $saNum=6;
				else if($set['Set']['image']=='sa-invisible.png') $saNum=5;
				else if($set['Set']['image']=='sa-giant.jpg') $saNum=4;
				else if($set['Set']['image']=='sa-resistance.jpg') $saNum=3;
				else $saNum=11;
				
				if($saNum+$user['User']['premium']>10) $accessOutput = $tierReward[10];
				else $accessOutput = $tierReward[$saNum+$user['User']['premium']];
				
				if($saNum==11) $accessOutput = '';
				if($accessOutput!='')echo $accessOutput.'<br><br>';
				echo $set['Set']['description']; 
				
				?>
			</td>
				<?php 
				if($set['Set']['id']!=1) $fav = '';
				else $fav = '&fav=1';
				if(!$noImage){
					if($set['Set']['image'][2]!='-'){
						echo '
						<td width="195px" style="vertical-align:top;"><div align="center">
						<a href="/tsumegos/play/'.$set['Set']['t'].'">
						<img height="252" width="182" style="border:1px solid black" src="/img/'. $set['Set']['image'].'" 
						alt="Tsumego Collection: '.$set['Set']['title'].'" title="Tsumego Collection: '.$set['Set']['title'].'">
						</a>
						</div></td>
						';
						
					}else{
						echo '
						<td width="195px" style="vertical-align:bottom;padding-bottom:17px;"><div align="center">
						<a href="/tsumegos/play/'.$set['Set']['t'].'">
						<img height="252" width="182" style="border:1px solid black" src="/img/'. $set['Set']['image'].'" 
						alt="Tsumego Collection: '.$set['Set']['title'].'" title="Tsumego Collection: '.$set['Set']['title'].'" width="210">
						</a>
						</div></td>
						';
					}
				}
				?>
				<?php if($isFav) echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>'; ?>
		</tr>
		<tr>
			<td style="vertical-align:top;">
				<table width="100%">
					<tr>
						<td style="vertical-align:top;" width="50%">
						<div align="center">
						<br>
						<?php 
							if(isset($set['Set']['solved'])){
								$solvedColor = '#a7a7a7';
								if($set['Set']['solved']>0){
									$solvedColor = '#247bb5';
								}
								if($set['Set']['solved']==100){ 
									$solvedColor = '#3ecf78';
								}
							}
							echo '<b>'.$set['Set']['anz'].' Problems<br>'; 
							
						?>
						</div>
						</td>
						<td style="vertical-align:bottom;" width="50%">
						<div align="center">
							<br>
							Difficulty: 
							<?php 
							echo '<b>'.$set['Set']['difficulty'].'</b>';
							//echo '<img src="/img/stars'. $set['Set']['difficulty'].'.png" alt="Tsumego difficulty: '. $set['Set']['difficulty'].'" title="Tsumego difficulty: '. $set['Set']['difficulty'].'">'; 
							
							?>
						</div>
						</td>
					</tr>
				</table>
			</td>
			<td style="vertical-align:top;">
				<div align="center"> 
				<br><br>
					<?php		
					echo '<a class="new-button new-buttonx" style="top:-16px;position:relative;" href="/tsumegos/play/'.$set['Set']['t'].'">Start</a>';
					?>
				</div>
			</td>
		</tr>
		<tr>
		<td>
		<br>
		<div align="center">
		<?php if(isset($_SESSION['loggedInUser'])){ ?>
		<?php
		if($set['Set']['solved']>100) $set['Set']['solved'] = 100;
		echo '<div class="setViewCompleted"><b>Completed: '.$set['Set']['solved'].'%</b></div><br>';
		echo '<div class="setViewAccuracy"><b>Accuracy: '.$accuracy.'%</b></div><br>';
		echo '<div class="setViewTime"><b>Avg. Time: '.$avgTime.'s</b></div>';
		} ?>
		</div>
		</td>
		
		<td>
		<?php if($delNum<=4){ ?>
		<div id="msg1x"><a id="showx">Reset<img id="greyArrow1" src="/img/greyArrow1.png"></a></div>
		<br>
		<?php } ?>
		</td>
		</tr>
		<tr>
		<td>
		<?php if($scoring){ ?>
		<div align="center">
		<br>
		<br>
		<a id="numbersButton" class="new-button-time" onclick="d1();">Numbers</a>
		<a id="ratioButton" class="new-button-time" onclick="d2();">Accuracy</a>
		<a id="timeButton" class="new-button-time" onclick="d3();">Time</a>
		<br>
		<br>
		<div id="numbersInfo">
			The problem numbers are displayed.
		</div>
		<div id="ratioInfo">
			The solved and failed (s/f) attempts are displayed.
		</div>
		<div id="timeInfo">
			The time (in seconds) for solving is displayed.
		</div>
		</div>
		<br>
		<?php } ?>
		</td>
		<td>
		<?php if($delNum<=4){ ?>
		<div id="msg2x">
		Type "reset" to remove all your progress on this collection. This can be used 4 times per month.<br><br>
		<?php
			echo $this->Form->create('Comment');
			echo $this->Form->input('reset', array('label' => '', 'type' => 'text', 'placeholder' => 'reset'));
			echo $this->Form->end('Submit');
		?>
		</div>
		<?php } ?>
		</td>
		</tr>
		<?php
		//if($set['Set']['public']==0){
		if(true){
			if($_SESSION['loggedInUser']['User']['isAdmin']==1){
				echo '<tr><td colspan="2">
				<div class="admin-panel">
				<div align="center"><h1> Admin Panel </h1></div>
				<br>
				<table width="100%">
				<tr>
				<td>';
				if($set['Set']['public']==0){
					echo '<a id="show">Edit Title<img id="greyArrow2" src="/img/greyArrow1.png"></a><br>
					<div id="msg1">';
						echo $this->Form->create('Set');
						echo $this->Form->input('title', array('label' => '', 'type' => 'text', 'placeholder' => 'Title', 'value' => $set['Set']['title']));
						echo $this->Form->input('title2', array('label' => '', 'type' => 'text', 'placeholder' => 'Title2', 'value' => $set['Set']['title2']));
						echo '<div class="submit"><input style="margin:0px;" value="Submit" type="submit"></div><br>';
					echo '</div>';
					echo '<a id="show2">Edit Description<img id="greyArrow3" src="/img/greyArrow1.png"></a><br>
					<div id="msg2">';
						echo $this->Form->create('Set');
						echo $this->Form->input('description', array('label' => '', 'type' => 'textarea', 'placeholder' => 'Description', 'value' => $set['Set']['description']));
						echo '<div class="submit"><input style="margin:0px;" value="Submit" type="submit"></div><br>';
					echo '</div>';
					echo '<a id="show3">Edit Color<img id="greyArrow4" src="/img/greyArrow1.png"></a><br>
					<div id="msg3">';
						echo $this->Form->create('Set');
						echo $this->Form->input('color', array('label' => '', 'type' => 'text', 'placeholder' => 'color', 'value' => $set['Set']['color']));
						echo '<div class="submit"><input style="margin:0px;" value="Submit" type="submit"></div><br>';
						echo '<i><a href="https://www.w3schools.com/colors/colors_picker.asp" target="_blank">hex color picker</a>&nbsp;(external link)</i><br>';
					echo '</div>';
					echo '<a href="/sets/ui/'.$set['Set']['id'].'">Upload Image</a><br>';
				}
				echo '<a id="show5" class="selectable-text">Settings<img id="greyArrow5" src="/img/greyArrow1.png"></a>';
					$vcOn = '';
					$vcOff = '';
					$arOn = '';
					$arOff = '';
					$vcMessage = '';
					$arMessage = '';
					if($allVcActive){
						$vcMessage = '<font color="#717171">[Merge recurring positions activated on all problems]</font><br>';
						$vcOn = 'checked="checked"';
					}elseif($allVcInactive){
						$vcMessage = '<font color="#717171">[Merge recurring positions deactivated on all problems]</font><br>';
						$vcOff = 'checked="checked"';
					}
					if($allArActive){
						$arMessage = '<font color="#717171">[Alternative Respone Mode activated on all problems]</font><br>';
						$arOn = 'checked="checked"';
					}elseif($allArInactive){
						$arMessage = '<font color="#717171">[Alternative Respone Mode deactivated on all problems]</font><br>';
						$arOff = 'checked="checked"';
					}
					echo '
						<div id="msg5">
							<br>
							'.$vcMessage.'
							'.$arMessage.'
							<form action="" method="POST" enctype="multipart/form-data">
								<table>
									<tr>
										<td>Merge recurring positions</td>
										<td><input type="radio" id="r38" name="data[Settings][r38]" value="on" ><label for="r38">on</label></td>
										<td><input type="radio" id="r38" name="data[Settings][r38]" value="off" ><label for="r38">off</label></td>
									</tr>
									<tr>
										<td>Alternative Response Mode</td>
										<td><input type="radio" id="r39" name="data[Settings][r39]" value="on" ><label for="r39">on</label></td>
										<td><input type="radio" id="r39" name="data[Settings][r39]" value="off" ><label for="r39">off</label></td>
									</tr>
								</table>
								<br>
								<input value="Submit" type="submit"/>
							</form>
						</div>
						<br><br>
					';
				if($set['Set']['public']==0){
					echo '<h1>Add Problem</h1>';
					echo $this->Form->create('Tsumego');
					echo $this->Form->input('num', array('value' => $tfs['Tsumego']['num']+1, 'label' => 'Number: ', 'type' => 'text', 'placeholder' => 'number'));
					echo $this->Form->input('set_id', array('type' => 'hidden', 'value' => $tfs['Tsumego']['set_id']));
					echo $this->Form->input('variance', array('type' => 'hidden', 'value' => 100));
					echo $this->Form->input('description', array('type' => 'hidden', 'value' => $tfs['Tsumego']['description']));
					echo $this->Form->input('hint', array('type' => 'hidden', 'value' => $tfs['Tsumego']['hint']));
					echo $this->Form->input('author', array('type' => 'hidden', 'value' => $tfs['Tsumego']['author']));
					if($set['Set']['id']==161){
						echo $this->Form->input('order', array('value' => $tfs['Tsumego']['num']+1, 'label' => 'Order: ', 'type' => 'text', 'placeholder' => 'order'));
						echo $this->Form->input('type', array('value' => 1, 'label' => 'Type: ', 'type' => 'text', 'placeholder' => 'type'));
						echo $this->Form->input('thumb', array('value' => $tfs['Tsumego']['num']+1, 'label' => 'Thumb: ', 'type' => 'text', 'placeholder' => 'thumb'));
					}
					echo $this->Form->end('Submit');
				}
				echo '</td>';
				echo '<td>';
				if($set['Set']['public']==0){
					echo '<div align="right">
					<a class="new-button new-buttonx" href="/users/userstats3/'.$set['Set']['id'].'">Activities</a>
					</div>';
				}
				echo '</td>
				</tr>
				</table>
				</div>
				</td>
				</tr>';
			}
		}		
		?>
		</table>
		</div>
		
		<?php if(!$isFav) echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>'; ?>
		<br><br>
	</div>


	
	
	<?php if($_SESSION['loggedInUser']['User']['isAdmin']==1){?>
	<script>
	var t1 = false;
	var t2 = false;
	var t3 = false;
	var msg5selected = false;
	$("#msg1").hide();
	$("#msg2").hide();
	$("#msg3").hide();
	$("#msg5").hide();
	
	$("#show").click(function(){
		if(!t1){
			$("#msg1").show();
			document.getElementById("greyArrow2").src = "/img/greyArrow2.png";
		}else{
			$("#msg1").hide();
			document.getElementById("greyArrow2").src = "/img/greyArrow1.png";
		}
		t1=!t1;
	});
	$("#show2").click(function(){
		if(!t2){
			$("#msg2").show();
			document.getElementById("greyArrow3").src = "/img/greyArrow2.png";
		}else{
			$("#msg2").hide();
			document.getElementById("greyArrow3").src = "/img/greyArrow1.png";
		}
		t2=!t2;
	});
	$("#show3").click(function(){
		if(!t3){
			$("#msg3").show();
			document.getElementById("greyArrow4").src = "/img/greyArrow2.png";
		}else{
			$("#msg3").hide();
			document.getElementById("greyArrow4").src = "/img/greyArrow1.png";
		}
		t3=!t3;
	});
	$("#show5").click(function(){
		if(!msg5selected){
			$("#msg5").fadeIn(250);
			document.getElementById("greyArrow5").src = "/img/greyArrow2.png";
		}else{
			$("#msg5").fadeOut(250);
			document.getElementById("greyArrow5").src = "/img/greyArrow1.png";
		}
		msg5selected = !msg5selected;
	});
	</script>
	<?php } ?>
	
	<script>
		var msg2selected = false;
		var msg3selected = false;
		var msg4selected = false;
		var msg5selected = false;
		$("#msg2x").hide();
		$("#ratioInfo").hide();
		$("#timeInfo").hide();
		$("#numbersButton").addClass("new-button-time-inactive");
		$("#numbersButton").removeClass("new-button-time");
		$("#ratioButton").addClass("new-button-time");
		$("#ratioButton").removeClass("new-button-time-inactive");
		$("#timeButton").addClass("new-button-time");
		$("#timeButton").removeClass("new-button-time-inactive");
		
		$("#showx").click(function(){
			if(!msg2selected){
				$("#msg2x").fadeIn(250);
				document.getElementById("greyArrow1").src = "/img/greyArrow2.png";
			}else{
				$("#msg2x").fadeOut(250);
				document.getElementById("greyArrow1").src = "/img/greyArrow1.png";
			}
			msg2selected = !msg2selected;
		});
	
		function d1(){
			$("#numbersButton").addClass("new-button-time-inactive");
			$("#numbersButton").removeClass("new-button-time");
			$("#ratioButton").addClass("new-button-time");
			$("#ratioButton").removeClass("new-button-time-inactive");
			$("#timeButton").addClass("new-button-time");
			$("#timeButton").removeClass("new-button-time-inactive");
			$("#numbersInfo").fadeIn(250);
			$("#ratioInfo").hide();
			$("#timeInfo").hide();
			$(".setViewButtons1").fadeIn(200);
			$(".setViewButtons2").hide();
			$(".setViewButtons3").hide();
			$(".setViewCompleted").css("border", "1px solid #45ac6e");
			$(".setViewAccuracy").css("border", "none");
			$(".setViewTime").css("border", "none");
		}
		function d2(){
			$("#numbersButton").addClass("new-button-time");
			$("#numbersButton").removeClass("new-button-time-inactive");
			$("#ratioButton").addClass("new-button-time-inactive");
			$("#ratioButton").removeClass("new-button-time");
			$("#timeButton").addClass("new-button-time");
			$("#timeButton").removeClass("new-button-time-inactive");
			$("#numbersInfo").hide();
			$("#ratioInfo").fadeIn(250);
			$("#timeInfo").hide();
			$(".setViewButtons1").hide();
			$(".setViewButtons2").fadeIn(200);
			$(".setViewButtons3").hide();
			$(".setViewCompleted").css("border", "none");
			$(".setViewAccuracy").css("border", "1px solid #722394");
			$(".setViewTime").css("border", "none");
		}
		function d3(){
			$("#numbersButton").addClass("new-button-time");
			$("#numbersButton").removeClass("new-button-time-inactive");
			$("#ratioButton").addClass("new-button-time");
			$("#ratioButton").removeClass("new-button-time-inactive");
			$("#timeButton").addClass("new-button-time-inactive");
			$("#timeButton").removeClass("new-button-time");
			$("#numbersInfo").hide();
			$("#ratioInfo").hide();
			$("#timeInfo").fadeIn(250);
			$(".setViewButtons1").hide();
			$(".setViewButtons2").hide();
			$(".setViewButtons3").fadeIn(200);
			$(".setViewCompleted").css("border", "none");
			$(".setViewAccuracy").css("border", "none");
			$(".setViewTime").css("border", "1px solid #b34717");
		}
	
		/*var tooltipSpan = document.getElementById('tooltip-span');

		window.onmousemove = function (e) {
			var x = e.clientX,
				y = e.clientY;
			tooltipSpan.style.top = (y + 20) + 'px';
			tooltipSpan.style.left = (x + 20) + 'px';
		};
		*/
		<?php
			if($refreshView) echo 'window.location.href = "/sets/view/'.$set['Set']['id'].'";';
			
		?>
	</script>