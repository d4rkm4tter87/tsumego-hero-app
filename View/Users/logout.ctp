<script type="text/javascript">
	setCookie("z_hash", "1");
	localStorage.setItem("z_hash", "1");
	//localStorage.removeItem("z_sess");
	//localStorage.removeItem("z_user_hash");
	window.location.href = "/";
	function setCookie(cookie, value=""){
		let paths = ["/", "/sets", "/sets/view", "/tsumegos/play", "/users", "/users/view"];
		for(let i=0;i<paths.length;i++)
			document.cookie = cookie+"="+value+";SameSite=none;Secure=false;path="+paths[i];
	}
</script>