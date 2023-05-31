	
	<div align="center">
		<?php 
			//echo '<pre>';print_r($us);echo '</pre>';
		?>
	</div>
	<div id="login-box2" class="users form">
		
		<div class="right4" style="width:900px">
		<div class="right2a">
			<div style="text-decoration:underline;font-size:22px;" align="center">Rating Mode - Configuration</div><br><br>
			<div style="font-size:16px">
			○ The users start at 900 rating (12 kyu).<br><br>
			○ The base score for solving a problem decreases by the user's activity.<br><br>
			○ The base score increases once a day and adds up when the user is inactive for several days.<br><br>
			○ For calculating the final score of a problem, the user's rating gets compared to the tsumego's rating. A higher tsumego rating gives a higher score, 
			a lower tsumego rating gives a lower score.<br><br>
			○ A tsumego can gain or lose rating points too, depending on how the users perform on it.<br><br><br>
			<hr><br>
			<div style="text-decoration:underline;font-size:22px;" align="center">New Features</div><br><br>
			<table border="0" width="100%">
			<tr>
			<td style="vertical-align: top;">
			<font size="4px">(1) Difficulty Modifier</font><br><br>
			If you want to get problem recommendations that are not around your rating, you can adjust the modifier. 
			While problems below your rating can give you a warm up before going to the higher ranks, problems above your rating can give you
			more points when you are able to solve them. You can control the flow of tsumego problems to your preference. The modifier comes in 7 steps: very easy, easy, 
			casual, regular, challenging, difficult and very difficult.<br><br><br>
			
			<font size="4px">(2) Rating Mode History</font><br><br>
			As you maybe noticed, the problem page doesn't have a title anymore. It is made unavailable to know the collection, the number or the id before
			trying to solve the problem. This makes the competition more fair.
			However, after the user has tried to solve the problem, it appears on the history page. This gives details about the fails and successes and
			- most importantly - gives an opportunity to study the problems that appeared for the user in the rating mode.
			</td>
			<td><div align="right">
			<img src="/img/rm-overview.PNG" alt="overview new features" title="overview new features" width="420px">
			</div></td>
			</tr>
			</table>
			<hr><br>
			<table border="0" width="100%">
			<tr>
			<td width="400px" style="vertical-align: top;">
			
			<font size="4px">Difficulty Modifier - how it works</font><br><br>
			You can see in the image on the right how the different settings affect the recommended problems. While it is always random, which problem gets actually displayed,
			it starts the search for a fitting problem around the rank that you configured. In this example, the user has a rating of 1500.
			</td>
			<td><div align="left">
			<img src="/img/rm-difficulty.png" alt="Difficulty Modifier - how it works" title="Difficulty Modifier - how it works" ><br>
			</div></td>
			</tr>
			</table>
			<hr><br>
			<table border="0" width="100%">
			<tr>
			<td style="vertical-align: top;">
			<font size="4px">Rating Mode History Page</font><br><br>
			When you go to your personal Rating Mode history page, you can see the problems that appeared for you. You find the problem's title with a link to the problem 
			in the level mode, where you can look at it again. Further, you find details about your rating, the tusmego rating, the change in your rating, 
			the time that you spent and the time/date of the entry.
			</td>
			<td><div align="left">
			<img src="/img/rm-history.PNG" alt="Rating Mode History page" title="Rating Mode History page"  width="530px"><br>
			</div></td>
			</tr>
			</table><br>
			
			
		</div>
			
		</div>
		</div>
	</div>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	
	<br><br>
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
			document.getElementById("donateH").src = '/img/PayPal-Donate-ButtonH.png';
		}	
		function donateNoHover(){
			document.getElementById("donateH").src = "/img/PayPal-Donate-Button.png";
		}
	</script>