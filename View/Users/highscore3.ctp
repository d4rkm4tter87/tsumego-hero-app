
<div align="center" class="highscore">

<table border="0" width="100%">
<tr>
	<td width="23%" valign="top">
	</td>
	<td width="53%" valign="top">
		<div align="center">
		<br>
		<a class="new-button new-buttonx" href="/users/highscore">level</a>
		<a class="new-button new-buttonx" href="/users/rating">rating</a>
		<a class="new-button buttonx-current" href="/users/highscore3">time</a>
		<a class="new-button new-buttonx" href="/users/achievements">achievements</a>
		<a class="new-button new-buttonx" href="/users/leaderboard">daily</a>
		<?php if(isset($_SESSION['loggedInUser'])){
		$lastMode = $_SESSION['loggedInUser']['User']['lastMode']-1;
		 }else{
			$lastMode = 2;
		}
		?>
		<br><br>
		</div>
	</td>
	<td width="23%" valign="top">
		<div align="right">	
		</div>
	</td>
</table>
<?php 
	if($params1!='') $lastMode = $params1;
?>
	
<table class="highscoreTable" border="0">
	<tr>
		<div align="center">	
				<p class="title">
					Time Mode Highscore
				<br><br> <br> 
				</p>
				<a id="slowButton" class="new-button-time" onclick="timeMode2();">Slow</a>
				<a id="fastButton" class="new-button-time" onclick="timeMode1();">Fast</a>
				<a id="blitzButton" class="new-button-time" onclick="timeMode0();">Blitz</a>
		</div>
		<br>
		<?php
		for($i=count($modes)-1;$i>=0;$i--){
			if($i==2) echo '<div id="time-mode2x">';
			elseif($i==1) echo '<div id="time-mode1x">';
			elseif($i==0) echo '<div id="time-mode0x">';
			for($j=0;$j<count($modes[$i]);$j++){
				if($modes[$i][$j]=='1') $buttonColor = true;
				else $buttonColor = false;
				if($i==$params1&&$modes2[$i][$j]==$params2) $buttonColor2 = true;
				else $buttonColor2 = false;
				if($buttonColor&&!$buttonColor2) echo '<a class="new-button-time" href="/users/highscore3?category='.$i.'&rank='.$modes2[$i][$j].'">'.$modes2[$i][$j].'</a>';
				elseif($buttonColor2) echo '<a class="new-button-time-inactive">'.$modes2[$i][$j].'</a>';
				else echo '<a class="new-button-time-inactive2">'.$modes2[$i][$j].'</a>';
			}
			echo '</div>';
		}
		?>
		
		
	</tr>
	<tr>
	<br>
		<th width="60px">Place</th>
		<th width="220px" align="left">&nbsp;Name</th>
		<th width="150px">Rank</th>
		<th width="150px">Points</th>
	</tr>
	<?php
		$place = 1;
		for($i=0; $i<count($roAll['user']); $i++){
			

			if(substr($roAll['user'][$i],0,3)=='g__'){
				$roAll['user'][$i] = '<img class="google-profile-image" src="/img/google/'.$roAll['picture'][$i].'">'.substr($roAll['user'][$i],3);
			}else{
				if(strlen($roAll['user'][$i])>20) $roAll['user'][$i] = substr($roAll['user'][$i], 0, 20);
			}



			$bgColor = '#dddddd';
			$tableRowColor = 'timeTableColor10';
			$uType = '';
			
			if($roAll['points'][$i]>950) $tableRowColor = 'timeTableColor1';
			elseif($roAll['points'][$i]>900) $tableRowColor = 'timeTableColor2';
			elseif($roAll['points'][$i]>850) $tableRowColor = 'timeTableColor3';
			elseif($roAll['points'][$i]>800) $tableRowColor = 'timeTableColor4';
			elseif($roAll['points'][$i]>750) $tableRowColor = 'timeTableColor5';
			elseif($roAll['points'][$i]>700) $tableRowColor = 'timeTableColor6';
			elseif($roAll['points'][$i]>650) $tableRowColor = 'timeTableColor7';
			elseif($roAll['points'][$i]>600) $tableRowColor = 'timeTableColor8';
			elseif($roAll['points'][$i]>550) $tableRowColor = 'timeTableColor9';
			elseif($roAll['points'][$i]>500) $tableRowColor = 'timeTableColor10';
			
			if($roAll['result'][$i]=='s') $roAll['result'][$i] = 'passed';
			elseif($roAll['result'][$i]=='f') $roAll['result'][$i] = 'failed';
			
			echo '
				<tr>
					<td align="center" class="timeTableLeft '.$tableRowColor.'">
						#'.$place.'
					</td>
					<td width="225px" align="left" class="timeTableMiddle '.$tableRowColor.'">
						'.$roAll['user'][$i].'
					</td>
					<td width="90px" align="center" class="timeTableMiddle '.$tableRowColor.'">
						'.$rank.'
					</td>
					
					<td align="center" class="timeTableRight '.$tableRowColor.'">
						'.$roAll['points'][$i].'
					</td>
				</tr>
			';
			$place++;
		
		}
	?>
	</table>
	<?php
	?>

	</div>
	<br><br><br><br><br><br>

	<script>
		<?php echo 'var lastMode = '.$lastMode.';';?>
		if(lastMode==0){
			timeMode0();
		}else if(lastMode==1){
			timeMode1();
		}else if(lastMode==2){
			timeMode2();
		}
		function timeMode0(){
			$("#blitzButton").addClass("new-button-time-inactive");
			$("#blitzButton").removeClass("new-button-time");
			$("#fastButton").addClass("new-button-time");
			$("#fastButton").removeClass("new-button-time-inactive");
			$("#slowButton").addClass("new-button-time");
			$("#slowButton").removeClass("new-button-time-inactive");
			$("#time-mode0x").fadeIn(250);
			$("#time-mode1x").hide();
			$("#time-mode2x").hide();
			lastMode = 0;
		}
		function timeMode1(){
			$("#blitzButton").addClass("new-button-time");
			$("#blitzButton").removeClass("new-button-time-inactive");
			$("#fastButton").addClass("new-button-time-inactive");
			$("#fastButton").removeClass("new-button-time");
			$("#slowButton").addClass("new-button-time");
			$("#slowButton").removeClass("new-button-time-inactive");
			$("#time-mode0x").hide();
			$("#time-mode1x").fadeIn(250);
			$("#time-mode2x").hide();
			lastMode = 1;
		}
		function timeMode2(){
			$("#blitzButton").addClass("new-button-time");
			$("#blitzButton").removeClass("new-button-time-inactive");
			$("#fastButton").addClass("new-button-time");
			$("#fastButton").removeClass("new-button-time-inactive");
			$("#slowButton").addClass("new-button-time-inactive");
			$("#slowButton").removeClass("new-button-time");
			$("#time-mode0x").hide();
			$("#time-mode1x").hide();
			$("#time-mode2x").fadeIn(250);
			lastMode = 2;
		}
	
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
	</script>
	
	
	
