	<div align="center">
	<?php if(
		!isset($_SESSION['loggedInUser']['User']['id'])
		|| isset($_SESSION['loggedInUser']['User']['id']) && $_SESSION['loggedInUser']['User']['premium']<1
	)
		$upgrade = true;
	else
		$upgrade = false;
		?>
	</div>
	<div id="login-box2" class="users form">
		<div class="left2 signin">
			<u><b>20,00 € Tsumego Hero Premium (lifetime)</b></u><br><br>
		
			Thank you for considering  
			<?php
				if($upgrade)
					echo 'an upgrade!';
				else
					echo 'a donation!';
			?>
			 The following rewards await you:<br>
			<br>
			
			<table>
				<tr>
					<td>
						<img src="/img/hero powers.png" alt="Secret Area: Ko Gems" title="Secret Area: Ko Gems"><br>
					</td>
					<td>
						<b>Premium collections (<?php echo $premiumTsumegos; ?> problems):</b><br> 
						<?php
							for($i=0;$i<count($premiumSets);$i++){
								echo $premiumSets[$i]['Set']['title'];
								if($i<count($premiumSets)-1)
									echo ', ';
							}
						?>
						<br>
					</td>
				</tr>
				<tr>
					<td>
						<img src="/img/hero power sandbox.png" alt="Sandbox" title="Sandbox"><br>
					</td>
					<td>
						<b>Sandbox</b><br>Contains <?php echo $overallCounter; ?> unpublished problems.<br>
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
						<img src="/img/hp6.png" alt="Hero Power: Revelation" title="Hero Power: Revelation"><br>
					</td>
					<td>
						<b>Hero Power: Revelation (Level 100)</b><br> Solves a problem, but you don't get any reward.<br>
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
						<img src="/img/Unbenannt7.png" alt="no daily limit" title="no daily limit"><br>
					</td>
					<td>
						<b>No daily limit</b><br>Removes the current limit of 12000 XP.<br>
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
			
			<div class="donate-paypal-right">
				<img src="/img/paypal-icon.png">
				<div class="donate-paypal-right-inner-2">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick" />
					<input type="hidden" name="hosted_button_id" value="RC7Z3QUNS9H4E" />
					<?php if($upgrade){ ?>
						<input type="image" id="donateH" src="/img/PayPal-Upgrade-Button.png" onmouseover="upgradeHover()" onmouseout="upgradeNoHover()" 
						border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Upgrade with PayPal button" />
					<?php }else{ ?>
						<input type="image" id="donateH" src="/img/PayPal-Donate-Button.png" onmouseover="donateHover()" onmouseout="donateNoHover()" 
						border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
					<?php } ?>
					<img alt="" border="0" src="https://www.paypal.com/en_EN/i/scr/pixel.gif" width="1" height="1" />
					</form>
				</div>
				<div class="donate-paypal-right-inner">
						Or to bank account:<br>
						Owner: Joschka Zimdars<br>
						IBAN: DE61200909002740631600<br>
						Bank: PSD Bank Nord eG<br>
						BIC: GENODEF1P08
				</div>
			</div>
		</div>
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
		function upgradeHover(){
			document.getElementById("donateH").src = '/img/PayPal-Upgrade-ButtonH.png';
		}	
		function upgradeNoHover(){
			document.getElementById("donateH").src = "/img/PayPal-Upgrade-Button.png";
		}
	</script>