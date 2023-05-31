	<div align="center">
		<?php 
		/*if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['premium']>0){
				echo '<br>You have a tier '.$_SESSION['loggedInUser']['User']['premium'].' account.<br>';
				if($_SESSION['loggedInUser']['User']['secretArea7']==0) echo 'You haven\'t found all secret areas.<br>';
				else{
					echo 'You have found all secret areas.<br>';
				}
			}
		}*/
		?>
	</div>
	<div id="login-box2" class="users form">
		<div class="left2 signin">
			<u><b>10,00 € Tsumego Hero Premium (lifetime)</b></u><br><br>
		
			Thank you for considering a donation! If you support Tsumego Hero, the following rewards await you:<br>
			<br>
			
			<table>
				<tr>
					<td>
						<img src="/img/hero powers.png" alt="Secret Area: Ko Gems" title="Secret Area: Ko Gems"><br>
					</td>
					<td>
						<b>Secret Area: Ko Gems</b><br>
					</td>
				</tr>
				<tr>
					<td>
						<img src="/img/hero powers.png" alt="Secret Area: Tsumego Grandmaster" title="Potion"><br>
					</td>
					<td>
						<b>Secret Area: Tsumego Grandmaster</b><br>
					</td>
				</tr>
				<tr>
					<td>
						<img src="/img/hp5.png" alt="Hero Power: Potion" title="Hero Power: Potion"><br>
					</td>
					<td>
						<b>Hero Power: Potion</b><br>Might refill hearts.<br>
					</td>
				</tr>
				<tr>
					<td>
						<img src="/img/hp4.png" alt="Hero Power: Refinement" title="Hero Power: Refinement"><br>
					</td>
					<td>
						<b>Hero Power: Refinement</b><br>Creates a golden Tsumego.<br>
					</td>
				</tr>
				<tr>
					<td>
						<img src="/img/Unbenannt4.png" alt="Download SGFs" title="Download SGFs"><br>
					</td>
					<td>
						<b>Download SGFs</b><br>Download the files of the problems.<br>
					</td>
				</tr>
				<tr>
					<td>
						<img src="/img/hero power sandbox.png" alt="Sandbox" title="Sandbox"><br>
					</td>
					<td>
						<b>Sandbox</b><br>Contains hundreds of unpublished problems.<br>
					</td>
				</tr>
				<tr>
					<td>
						<img src="/img/Unbenannt5.png" alt="Board Designs" title="Board Designs"><br><br>
					</td>
					<td>
						<b>21 additional board designs</b><br><br>
					</td>
				</tr>
			</table>
			
			
			
		</div>
		<div class="right2">
			<div align="center" style="padding-top:200px;">
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick" />
				<input type="hidden" name="hosted_button_id" value="RC7Z3QUNS9H4E" />
				<input type="image" id="donateH" src="https://tsumego-hero.com/img/PayPal-Donate-Button.png" onmouseover="donateHover()" onmouseout="donateNoHover()" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
				<img alt="" border="0" src="https://www.paypal.com/en_EN/i/scr/pixel.gif" width="1" height="1" />
				</form>
			</div>
		</div>
	</div>
	<div align="center" style="color:#444;">
	If you prefer to send your donation directly to my bank account,<br> please contact <a style="color:#5e3fee;" href="mailto:me@joschkazimdars.com">me@joschkazimdars.com</a>.
	
	</div>
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