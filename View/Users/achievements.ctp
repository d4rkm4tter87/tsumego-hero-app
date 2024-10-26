
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
		<a class="new-button buttonx-current" href="/users/achievements">achievements</a>
		<a class="new-button new-buttonx" href="/users/added_tags">tags</a>
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
					Achievement Highscore
				</p>
				</div>
	</tr>
	<tr>
	<br>
		<th width="60px">Place</th>
		<th width="220px" align="left">&nbsp;Name</th>
		<th width="150px">Completed</th>
	</tr>
	<?php
		$place = 1;
		for($i=count($uaNum)-1; $i>=count($uaNum)-100; $i--){
			echo '
				<tr class="color9d">';
					echo '
					<td align="center">
						#'.$place.'
					</td>
					<td>
						'.$uName[$i].'
					</td>
					<td align="center">
						'.$uaNum[$i].'/'.$aNum.'
					</td>
				</tr>
			';
			$place++;
		}
	?>
	</table>
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
	
	
	
