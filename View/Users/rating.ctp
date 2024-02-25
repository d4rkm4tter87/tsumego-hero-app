
<div align="center" class="highscore">

<table border="0" width="100%">
<tr>
	<td width="23%" valign="top">
	</td>
	<td width="53%" valign="top">
		<div align="center">
		<br>
		<a class="new-button new-buttonx" href="/users/highscore">level</a>
		<a class="new-button buttonx-current" href="/users/rating">rating</a>
		<a class="new-button new-buttonx" href="/users/highscore3">time</a>
		<a class="new-button new-buttonx" href="/users/achievements">achievements</a>
		<a class="new-button new-buttonx" href="/users/leaderboard">daily</a>
		<br><br>
		</div>
	</td>
	<td width="23%" valign="top">
		<div align="right">	
		</div>
	</td>
</table>

	
<table class="highscoreTable" border="0">
	<tr>
		<div align="center">	
				<p class="title">
					Rating Highscore
				<br><br> 
				</p>
				</div>
	</tr>
	<tr>
		<!--<th width="55px"></th>-->
		<th width="60px">Place</th>
		<th width="220px" colspan="2" align="left">&nbsp;Name</th>
		<th width="150px">Rank</th>
		<th width="150px">Rating</th>
		<th width="150px">Solved in rating mode</th>
	</tr>
	<?php
		$place = 1;
		for($i=0; $i<count($users); $i++){
			if($users[$i]['User']['name']!='SaberRider' && $users[$i]['User']['name']!='test11' && $users[$i]['User']['elo_rating_mode']!=100 && $users[$i]['User']['elo_rating_mode']!=900){
			if(strlen($users[$i]['User']['name'])>20) $users[$i]['User']['name'] = substr($users[$i]['User']['name'], 0, 20);
			$bgColor = '#dddddd';
			$tableRowColor = 'color13';
			$uType = '';
			if($users[$i]['User']['premium']==1) $uType = '<img alt="Account Type" title="Account Type" src="/img/premium1.png" height="16px">';
			else if($users[$i]['User']['premium']==2) $uType = '<img alt="Account Type" title="Account Type" src="/img/premium2.png" height="16px">';
			
			
			if($users[$i]['User']['elo_rating_mode']>=2900) $td = '9d';
			elseif($users[$i]['User']['elo_rating_mode']>=2800) $td = '8d';
			elseif($users[$i]['User']['elo_rating_mode']>=2700) $td = '7d';
			elseif($users[$i]['User']['elo_rating_mode']>=2600) $td = '6d';
			elseif($users[$i]['User']['elo_rating_mode']>=2500) $td = '5d';
			elseif($users[$i]['User']['elo_rating_mode']>=2400) $td = '4d'; 
			elseif($users[$i]['User']['elo_rating_mode']>=2300) $td = '3d';
			elseif($users[$i]['User']['elo_rating_mode']>=2200) $td = '2d'; 
			elseif($users[$i]['User']['elo_rating_mode']>=2100) $td = '1d';
			elseif($users[$i]['User']['elo_rating_mode']>=2000) $td = '1k'; 
			elseif($users[$i]['User']['elo_rating_mode']>=1900) $td = '2k';
			elseif($users[$i]['User']['elo_rating_mode']>=1800) $td = '3k'; 
			elseif($users[$i]['User']['elo_rating_mode']>=1700) $td = '4k';
			elseif($users[$i]['User']['elo_rating_mode']>=1600) $td = '5k';
			elseif($users[$i]['User']['elo_rating_mode']>=1500) $td = '6k';
			elseif($users[$i]['User']['elo_rating_mode']>=1400) $td = '7k'; 
			elseif($users[$i]['User']['elo_rating_mode']>=1300) $td = '8k';
			elseif($users[$i]['User']['elo_rating_mode']>=1200) $td = '9k';
			elseif($users[$i]['User']['elo_rating_mode']>=1100) $td = '10k';
			elseif($users[$i]['User']['elo_rating_mode']>=1000) $td = '11k';
			elseif($users[$i]['User']['elo_rating_mode']>=900) $td = '12k';
			elseif($users[$i]['User']['elo_rating_mode']>=800) $td = '13k';
			elseif($users[$i]['User']['elo_rating_mode']>=700) $td = '14k';
			elseif($users[$i]['User']['elo_rating_mode']>=600) $td = '15k';
			elseif($users[$i]['User']['elo_rating_mode']>=500) $td = '16k';
			elseif($users[$i]['User']['elo_rating_mode']>=400) $td = '17k';
			elseif($users[$i]['User']['elo_rating_mode']>=300) $td = '18k';
			elseif($users[$i]['User']['elo_rating_mode']>=200) $td = '19k';
			elseif($users[$i]['User']['elo_rating_mode']>=100) $td = '20k';
			else $td = '20k';
			
			if($td=='9d') $tableRowColor = 'color9d';
			elseif($td=='8d') $tableRowColor = 'color8d';
			elseif($td=='7d') $tableRowColor = 'color7d';
			elseif($td=='6d') $tableRowColor = 'color6d';
			elseif($td=='5d') $tableRowColor = 'color5d';
			elseif($td=='4d') $tableRowColor = 'color4d';
			elseif($td=='3d') $tableRowColor = 'color3d';
			elseif($td=='2d') $tableRowColor = 'color2d';
			elseif($td=='1d') $tableRowColor = 'color1d';
			elseif($td=='1k') $tableRowColor = 'color1k';
			elseif($td=='2k') $tableRowColor = 'color2k';
			elseif($td=='3k') $tableRowColor = 'color3k';
			elseif($td=='4k') $tableRowColor = 'color4k';
			elseif($td=='5k') $tableRowColor = 'color5k';
			elseif($td=='6k') $tableRowColor = 'color6k';
			elseif($td=='7k') $tableRowColor = 'color7k';
			elseif($td=='8k') $tableRowColor = 'color8k';
			elseif($td=='9k') $tableRowColor = 'color9k';
			elseif($td=='10k') $tableRowColor = 'color10k';
			elseif($td=='11k') $tableRowColor = 'color11k';
			elseif($td=='12k') $tableRowColor = 'color12k';
			elseif($td=='13k') $tableRowColor = 'color13k';
			elseif($td=='14k') $tableRowColor = 'color14k';
			elseif($td=='15k') $tableRowColor = 'color15k';
			elseif($td=='16k') $tableRowColor = 'color16k';
			elseif($td=='17k') $tableRowColor = 'color17k';
			elseif($td=='18k') $tableRowColor = 'color18k';
			elseif($td=='19k') $tableRowColor = 'color19k';
			elseif($td=='20k') $tableRowColor = 'color20k';
			
			echo '
				<tr class="'.$tableRowColor.'">
					<!--<td align="center"></td>-->
					
					<td align="center">
						#'.$place.'
					</td>
					';
					if($_SESSION['loggedInUser']['User']['id']!=72){
						echo '<td width="225px" align="left">
							'.$users[$i]['User']['name'].'
						</td>';
					}else{
						echo '<td width="225px" align="left">
							<a style="color:black;text-decoration:none;" target="_blank" href="/tsumego_records/user/'.$users[$i]['User']['id'].'">'.$users[$i]['User']['name'].'</a>
						</td>';
					}
					echo '
					<td width="90px">
						'.$uType.'
					</td>
					
					<td align="center">
						'.$td.'
					</td>
					<td align="center">
						'.$users[$i]['User']['elo_rating_mode'].'
					</td>
					<td align="center">
						'.$users[$i]['User']['solved2'].'
					</td>
				</tr>
			';
			$place++;
		}
		}
	?>
	</table>
	<?php
	//echo '<pre>';print_r($_SESSION['loggedInUser']);echo '</pre>';
	/*
	if($_SESSION['loggedInUser']['User']['id']==72){
		echo '<pre>';
		print_r($users2);
		echo '</pre>';
	}
	if(isset($_SESSION['loggedInUser'])){if($_SESSION['loggedInUser']['User']['id']==72){
		echo '<pre>';
		print_r($users);
		echo '</pre>';
	}}
	*/
	?>

	</div>
	<br><br><br><br><br><br>

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
	</script>
	
	
	<?php
	/* if($i==3) $bgColor = '#9e61b6';
			if($i==4) $bgColor = '#9e61b6';
			if($i==5) $bgColor = '#9e61b6';
			if($i==6) $bgColor = '#9e61b6';
			if($i==7) $bgColor = '#9e61b6';
			if($i==8) $bgColor = '#9e61b6';
			if($i==9) $bgColor = '#9e61b6';
			if($i==10) $bgColor = '#ba84cf';
			if($i==11) $bgColor = '#b57dca';
			if($i==12) $bgColor = '#c08ad5';
			if($i==13) $bgColor = '#cb98df';
			if($i==14) $bgColor = '#d1a5e4';
			if($i==15) $bgColor = '#d1aae3';
			if($i==16) $bgColor = '#d2ade3';
			if($i==17) $bgColor = '#d2b3e3';
			if($i==18) $bgColor = '#d2b5e2';
			if($i==19) $bgColor = '#d2bbe2';
			if($i==20) $bgColor = '#d2bee2';
			if($i==21) $bgColor = '#d2c3e1';
			if($i==22) $bgColor = '#d2c1e2';
			if($i==23) $bgColor = '#d2c6e1';
			if($i==24) $bgColor = '#d2c9e1';
			if($i==25) $bgColor = '#d3cce1';
			if($i==26) $bgColor = '#d3cfe1';
			if($i==27) $bgColor = '#d3d1e0';
			if($i==28) $bgColor = '#d3d4e0';
			if($i==29) $bgColor = '#d3d7e0';
				 if($i==3) $bgColor = '#8846a1';
			if($i==4) $bgColor = '#8d4da6';
			if($i==5) $bgColor = '#9354ab';
			if($i==6) $bgColor = '#985ab0';
			if($i==7) $bgColor = '#9e61b6';
			if($i==8) $bgColor = '#a468bb';
			if($i==9) $bgColor = '#a96fc0';
			if($i==10) $bgColor = '#af76c5';
			if($i==11) $bgColor = '#ba84cf';
			if($i==12) $bgColor = '#c691da';
			if($i==13) $bgColor = '#d19fe4';
			if($i==14) $bgColor = '#d1a5e4';
			if($i==15) $bgColor = '#d1aae3';
			if($i==16) $bgColor = '#d2ade3';
			if($i==17) $bgColor = '#d2b3e3';
			if($i==18) $bgColor = '#d2b5e2';
			if($i==19) $bgColor = '#d2bbe2';
			if($i==20) $bgColor = '#d2bee2';
			if($i==21) $bgColor = '#d2c3e1';
			if($i==22) $bgColor = '#d2c1e2';
			if($i==23) $bgColor = '#d2c6e1';
			if($i==24) $bgColor = '#d2c9e1';
			if($i==25) $bgColor = '#d3cce1';
			if($i==26) $bgColor = '#d3cfe1';
			if($i==27) $bgColor = '#d3d1e0';
			if($i==28) $bgColor = '#d3d4e0';
			if($i==29) $bgColor = '#d3d7e0';
			*/
	?>
	
	
	
