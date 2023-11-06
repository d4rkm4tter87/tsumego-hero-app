
	<div align="center" class="highscore">
	
	<table border="0" width="100%">
		<tr>
			<td width="23%" valign="top">
				<font size="3px" style="font-weight:400;">Signed in users today: <?php echo $uNum; ?></font>
			</td>
			<td width="53%" valign="top">
				<div align="center">
				<br>
				<a class="new-button new-buttonx" href="/users/highscore">level</a>
				<a class="new-button new-buttonx" href="/users/rating">rating</a>
				<a class="new-button new-buttonx" href="/users/highscore3">time</a>
				<a class="new-button new-buttonx" href="/users/achievements">achievements</a>
				<a class="new-button buttonx-current" href="/users/leaderboard">daily</a>
				<br><br>
				</div>
			</td>
			<td width="23%" valign="top">
				<div align="right">	
				<font size="3px" style="font-weight:400;font-style:italic;">* Users can't be user of the day two times in a row.</font>
				</div>
			</td>
		</tr>
	</table>
	<table border="0" width="100%">
		<tr>
			<td width="33%" valign="top">
			</td>
			<td width="33%" valign="top">
				<div align="center">	
				<p class="title">
					Daily Highscore
				<br><br> 
				</p>
				</div>
			</td>
			<td width="33%" valign="top">
			</td>
		</tr>
	</table>
	
	
	<?php 

	$d1 = date(' d, Y');
	$d1day = date('d. ');
	$d1year = date('Y');
	if($d1day[0]==0) $d1day = substr($d1day, -3);
	$d2 = date('Y-m-d H:i:s');
	$month = date("F", strtotime(date('Y-m-d')));
	$d1 = $d1day.$month.' '.$d1year;

	echo $d1;
	//echo $dayRecord['DayRecord']['id'];
	?>
	
	<br><br>
	<table>
	<?php
		//echo '<pre>';print_r($a);echo '</pre>';
		
		for($i=0; $i<=count($a); $i++){
			if($a[$i]['User']['reuse3']>0){
				$bgColor = '#fff';
				if($i==0) $bgColor = '#ffec85';
				if($i==1) $bgColor = '#939393';
				if($i==2) $bgColor = '#c28d47';
				if($i==3) $bgColor = '#85e35d';
				if($i==4) $bgColor = '#85e35d';
				if($i==5) $bgColor = '#85e35d';
				if($i==6) $bgColor = '#85e35d';
				if($i==7) $bgColor = '#85e35d';
				if($i==8) $bgColor = '#85e35d';
				if($i==9) $bgColor = '#85e35d';
				if($i==10) $bgColor = '#85e35d';
				if($i==11) $bgColor = '#85e35d';
				if($i==12) $bgColor = '#85e35d';
				if($i==13) $bgColor = '#85e35d';
				if($i==14) $bgColor = '#85e35d';
				if($i==15) $bgColor = '#85e35d';
				if($i==16) $bgColor = '#85e35d';
				if($i==17) $bgColor = '#85e35d';
				if($i==18) $bgColor = '#85e35d';
				if($i==19) $bgColor = '#85e35d';
				if($i==20) $bgColor = '#9cf974';
				if($i==21) $bgColor = '#9cf974';
				if($i==22) $bgColor = '#9cf974';
				if($i==23) $bgColor = '#9cf974';
				if($i==24) $bgColor = '#9cf974';
				if($i==25) $bgColor = '#9cf974';
				if($i==26) $bgColor = '#9cf974';
				if($i==27) $bgColor = '#9cf974';
				if($i==28) $bgColor = '#9cf974';
				if($i==29) $bgColor = '#9cf974';
				if($i>=30) $bgColor = '#b6f998';
				if($i>=40) $bgColor = '#d3f9c2';
				if($i>=50) $bgColor = '#e8f9e0';
				
				if($a[$i]['User']['name'] == $dayRecord) $a[$i]['User']['name'].=' *';
				
				echo '
					<tr style="background-color:'.$bgColor.';">
						<td align="right" style="padding:10px;">
							<b>'.($i+1).'</b>
						</td>
						<td style="padding:10px;" width="200px">
							<b>'.$a[$i]['User']['name'].'</b>
						</td>
						<td align="right" style="padding:10px;font-weight:400;">
							'.$a[$i]['User']['reuse2'].' solved
						</td>
						<td align="right" style="padding:10px;">
							<b>'.$a[$i]['User']['reuse3'].' XP</b>
						</td>
					</tr>
				';
			}
		}
	?>
	</table>
	<br><br>
		
	
	</div>
	<div align="center">
	<div class="accessList" style="font-weight:400;">
	Admins: 
	<?php
		for($i=0; $i<count($admins); $i++){
			echo $admins[$i];
			if($i<count($admins)-1) echo ', ';
		}
	?>
	<br><br>
	
	</div>
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
		</script>
		
		
		
		
