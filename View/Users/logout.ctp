<?php ?>


<script type="text/javascript">
	setCookie("PHPSESSID", "0");
	setCookie("hash", "0");
	window.location.href = "/";
	function setCookie(cookie, value=""){
		let paths = ["/", "/sets", "/sets/view", "/tsumegos/play", "/users", "/users/view"];
		for(let i=0;i<paths.length;i++)
			document.cookie = cookie+"="+value+";SameSite=none;Secure=false;path="+paths[i];
	}
</script>