<?php
	if(isset($_SESSION['loggedInUser'])){
		echo '<script type="text/javascript">window.location.href = "/sets";</script>';
	}
?>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<br>
<div align="center">
Sign in with:<br><br><br>
<a class="new-button"  href="/users/login">Name</a>
<a class="new-button-inactive">Email</a>
</div>
<div id="login-box" class="users form">
	<div class="left signin">
		<?php echo $this->Session->flash(); ?>
		 <h1>Sign in</h1>
		<?php echo $this->Form->create('User', array('action' => 'login2')); ?>
		<label for="UserEmail"></label>
		<div class="input text required">
			<label for="UserEmail"></label>
			<input name="data[User][email]" maxlength="50" placeholder="Email" type="text" id="UserEmail" required="required"/>
		</div>
		<label for="UserPassword"></label>
		<div class="input password required">
			<label for="UserPw"></label>
			<input name="data[User][pw]" type="password" placeholder="Password" id="UserPw" required="required"/>
		</div>
		<?php echo $this->Form->end('Submit'); ?>
		Need an account?<br>
		<a href="/users/add">Sign Up</a><br><br>
		Forgot password?<br>
		<a href="/users/resetpassword">Reset</a>
<br><br>
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
	</div>
	<div class="right">
	</div>
</div>
<br>

<script>
		var cacheLifetime = new Date();
		cacheLifetime.setTime(cacheLifetime.getTime()+1*1*1*5*1000);
		cacheLifetime = cacheLifetime.toUTCString()+"";

		setCookie("z_hash", "0");
		localStorage.setItem("z_hash", "0");
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
		function setCookie(cookie, value=""){
			let paths = ["/", "/sets", "/sets/view", "/tsumegos/play", "/users", "/users/view"];
			for(let i=0;i<paths.length;i++)
				document.cookie = cookie+"="+value+";SameSite=none;Secure=false;expires="+cacheLifetime+";path="+paths[i];
		}
	</script>