	<script src="/dist/shuffle.js"></script>
	<?php
	
	if(isset($sortOrder) && $sortOrder!= 'null'){
		if($sortOrder=='00') echo '<script src="/js/demos/adding-removing00.js"></script>';
		if($sortOrder=='10') echo '<script src="/js/demos/adding-removing11.js"></script>';
		if($sortOrder=='20') echo '<script src="/js/demos/adding-removing21.js"></script>';
		if($sortOrder=='30') echo '<script src="/js/demos/adding-removing30.js"></script>';
		if($sortOrder=='40') echo '<script src="/js/demos/adding-removing40.js"></script>';
		if($sortOrder=='11') echo '<script src="/js/demos/adding-removing10.js"></script>';
		if($sortOrder=='21') echo '<script src="/js/demos/adding-removing20.js"></script>';
		if($sortOrder=='31') echo '<script src="/js/demos/adding-removing31.js"></script>';
		if($sortOrder=='41') echo '<script src="/js/demos/adding-removing41.js"></script>';
	}else echo '<script src="/js/demos/adding-removing00.js"></script>';
	
	
		if(isset($_SESSION['loggedInUser'])){
		}else{
			echo '<script type="text/javascript">window.location.href = "/";</script>';
		}
	
	
		$active0 = '';
		$active1 = '';
		$active2 = '';
		$active3 = '';
		$active4 = '';
		
		if(isset($sortOrder) && $sortOrder!= 'null'){
			if($sortOrder=='00'){
				$active0 = 'active';
			}
			if($sortOrder=='10'){
				$active1 = 'active';
			}
			if($sortOrder=='20'){
				$active2 = 'active';
			}
			if($sortOrder=='30'){
				$active3 = 'active';
			}
			if($sortOrder=='40'){
				$active4 = 'active';
			}
			if($sortOrder=='11'){
				$active1 = 'active';
			}
			if($sortOrder=='21'){
				$active2 = 'active';
			}
			if($sortOrder=='31'){
				$active3 = 'active';
			}
			if($sortOrder=='41'){
				$active4 = 'active';
			}
		}else{
			$active0 = 'active';
		}
		
		if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['id']==72){
				//echo '<pre>';print_r($sh);echo '</pre>';
			}
		}
		
	?>
	<div align="center" class="display1" style="padding-top:10px;">
		
	<div id="sandbox">
	<h4>Admin Panel</h4>
		<div align="left">
		Collections that you find here are not yet published and need to be checked for improvement.
		While solving them, please look for misplays and bugs.<br><br>
		<?php
		if(isset($_SESSION['loggedInUser'])){if($_SESSION['loggedInUser']['User']['isAdmin']>0){
		?>
		<div align="left">
			If you have questions about creating/editing/deleting content or comments:
			<a class="historyLink2" href="/files/Admin-Guide.pdf" target="_blank">
				Admin-Guide.pdf
			</a>
			<br><br>
			<table width="100%">
			<tr>
			<td>
				<a href="/sets/create">Create Set</a>
			</td>
			<td>
				<a href="/sets/remove">Delete Set</a>
			</td>
			</tr>
			</table>
		</div>
		<?php }} ?>
		</div>
	</div>	
	<section class="scontainer">
	  <div class="row">
		<div class="col-12@sm">
		  <div id="my-shuffle" class="items">
			<?php 
				for($i=0; $i<count($sets); $i++){
					if($sets[$i]['Set']['solved']==0) $solvedBar = '000';
					else if($sets[$i]['Set']['solved']<2.5) $solvedBar = '025';
					else if($sets[$i]['Set']['solved']<5) $solvedBar = '050';
					else if($sets[$i]['Set']['solved']<7.5) $solvedBar = '075';
					else if($sets[$i]['Set']['solved']<10) $solvedBar = '010';
					else if($sets[$i]['Set']['solved']<12.5) $solvedBar = '125';
					else if($sets[$i]['Set']['solved']<15) $solvedBar = '150';
					else if($sets[$i]['Set']['solved']<17.5) $solvedBar = '175';
					else if($sets[$i]['Set']['solved']<20) $solvedBar = '200';
					else if($sets[$i]['Set']['solved']<22.5) $solvedBar = '225';
					else if($sets[$i]['Set']['solved']<25) $solvedBar = '250';
					else if($sets[$i]['Set']['solved']<27.5) $solvedBar = '275';
					else if($sets[$i]['Set']['solved']<30) $solvedBar = '300';
					else if($sets[$i]['Set']['solved']<32.5) $solvedBar = '325';
					else if($sets[$i]['Set']['solved']<35) $solvedBar = '350';
					else if($sets[$i]['Set']['solved']<37.5) $solvedBar = '375';
					else if($sets[$i]['Set']['solved']<40) $solvedBar = '400';
					else if($sets[$i]['Set']['solved']<42.5) $solvedBar = '425';
					else if($sets[$i]['Set']['solved']<45) $solvedBar = '450';
					else if($sets[$i]['Set']['solved']<47.5) $solvedBar = '475';
					else if($sets[$i]['Set']['solved']<50) $solvedBar = '500';
					else if($sets[$i]['Set']['solved']<52.5) $solvedBar = '525';
					else if($sets[$i]['Set']['solved']<55) $solvedBar = '550';
					else if($sets[$i]['Set']['solved']<57.5) $solvedBar = '575';
					else if($sets[$i]['Set']['solved']<60) $solvedBar = '600';
					else if($sets[$i]['Set']['solved']<62.5) $solvedBar = '625';
					else if($sets[$i]['Set']['solved']<65) $solvedBar = '650';
					else if($sets[$i]['Set']['solved']<67.5) $solvedBar = '675';
					else if($sets[$i]['Set']['solved']<70) $solvedBar = '700';
					else if($sets[$i]['Set']['solved']<72.5) $solvedBar = '725';
					else if($sets[$i]['Set']['solved']<75) $solvedBar = '750';
					else if($sets[$i]['Set']['solved']<77.5) $solvedBar = '775';
					else if($sets[$i]['Set']['solved']<80) $solvedBar = '800';
					else if($sets[$i]['Set']['solved']<82.5) $solvedBar = '825';
					else if($sets[$i]['Set']['solved']<85) $solvedBar = '850';
					else if($sets[$i]['Set']['solved']<87.5) $solvedBar = '850';
					else if($sets[$i]['Set']['solved']<90) $solvedBar = '875';
					else if($sets[$i]['Set']['solved']<92.5) $solvedBar = '900';
					else if($sets[$i]['Set']['solved']<95) $solvedBar = '925';
					else if($sets[$i]['Set']['solved']<97.5) $solvedBar = '950';
					else if($sets[$i]['Set']['solved']<100) $solvedBar = '975';
					else $solvedBar = '100';
					
					if($sets[$i]['Set']['id']==11969 || $sets[$i]['Set']['id']==29156 || $sets[$i]['Set']['id']==31813 || $sets[$i]['Set']['id']==33007 
					|| $sets[$i]['Set']['id']==71790 || $sets[$i]['Set']['id']==74761 || $sets[$i]['Set']['id']==81578 || $sets[$i]['Set']['id']==88156
					|| $sets[$i]['Set']['id']==135
					){
						$secretAreaBg = 'sa';
					}else{
						$secretAreaBg = '';
					}
					$s = 's';
					if($sets[$i]['Set']['id']==31813) $s = '';
					
					if($sets[$i]['Set']['solved']==100) $completed=' Completed';
					else $completed='';
					echo '
						<div id="set'.$sets[$i]['Set']['id'].'" class="box box'.$solvedBar.$secretAreaBg.' '.$completed.'" data-reviews="'.$sets[$i]['Set']['created'].'" data-problems="'.$sets[$i]['Set']['anz'].'" 
						data-difficulty="'.$sets[$i]['Set']['difficulty'].'" data-solved="'.$sets[$i]['Set']['solved'].'" 
						style="background-color:'.$sets[$i]['Set']['topicColor'].';">
							<a href="/sets/view/'.$sets[$i]['Set']['id'].'" style="text-decoration:none;color:white;">
								<div style="text-decoration:none;">
									<p class="title">'.$sets[$i]['Set']['title'].'</p>
									<p class="titleBy">by '.$sets[$i]['Set']['author'].'</p> 
									<b>'.$sets[$i]['Set']['title2'].'</b>';
									if($sets[$i]['Set']['id']!=58 && $sets[$i]['Set']['id']!=68 && $sets[$i]['Set']['id']!=140) echo '<br><br>';
									else echo '<br>';
									echo '<table border="0" width="100%" style="padding-top:19px;color:white">
										<tr>
											<td width="50%">
												<div class="display1" align="center"><b>'.$sets[$i]['Set']['anz'].' Problem'.$s.'<br>Solved: '.$sets[$i]['Set']['solved'].'%</b></div>
											</td>
											<td>
											</td>
										</tr>
									</table>
									<br>
								</div>
							</a>
						</div>
						
					';
				}
			?>
		  </div>
		</div>
	  </div>
	</section>
	<br><br>
	<div>
	<?php
	echo 'The sandbox contains '.$overallCounter.' problems.';
	?>
	</div>
	<br><br>
	<div class="accessList">
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
		/*
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
		*/
		function topicColor() {
			<?php
				for($i=0; $i<count($sets); $i++) {
					echo '
						document.getElementById("set'.$sets[$i]['Set']['id'].'").style.transition = "all 1s"; 
						document.getElementById("set'.$sets[$i]['Set']['id'].'").style.backgroundColor = "'.$sets[$i]['Set']['topicColor'].'";
					';
				}
			?>
			
			document.cookie = "sortColor=0";
			var btnContainer = document.getElementById("sorter2");
			var btns = btnContainer.getElementsByClassName("btn");
			for (var i = 0; i < btns.length; i++){
				btns[i].className = btns[i].className.replace("btn active","btn");
			}
			btns[0].className = btns[0].className.replace("btn","btn active");
		}
		function solvedColor() {
			<?php
				for($i=0; $i<count($sets); $i++) {
					echo '
						document.getElementById("set'.$sets[$i]['Set']['id'].'").style.transition = "all 1s"; 
						document.getElementById("set'.$sets[$i]['Set']['id'].'").style.backgroundColor = "'.$sets[$i]['Set']['solvedColor'].'";
					';
				}
			?>
			
			document.cookie = "sortColor=1";
			
			var btnContainer = document.getElementById("sorter2");
			var btns = btnContainer.getElementsByClassName("btn");
			for (var i = 0; i < btns.length; i++){
				btns[i].className = btns[i].className.replace("btn active","btn");
			}
			btns[1].className = btns[1].className.replace("btn","btn active");
			
		}
		
		function difficultyColor() {
			<?php
				for($i=0; $i<count($sets); $i++) {
					echo '
						document.getElementById("set'.$sets[$i]['Set']['id'].'").style.transition = "all 1s"; 
						document.getElementById("set'.$sets[$i]['Set']['id'].'").style.backgroundColor = "'.$sets[$i]['Set']['difficultyColor'].'";
					';
				}
			?>
			
			document.cookie = "sortColor=2";
			var btnContainer = document.getElementById("sorter2");
			var btns = btnContainer.getElementsByClassName("btn");
			for (var i = 0; i < btns.length; i++){
				btns[i].className = btns[i].className.replace("btn active","btn");
			}
			btns[2].className = btns[2].className.replace("btn","btn active");
		}
		function sizeColor() {
			<?php
				for($i=0; $i<count($sets); $i++) {
					echo '
						document.getElementById("set'.$sets[$i]['Set']['id'].'").style.transition = "all 1s"; 
						document.getElementById("set'.$sets[$i]['Set']['id'].'").style.backgroundColor = "'.$sets[$i]['Set']['sizeColor'].'";
					';
				}
			?>
			
			document.cookie = "sortColor=3";
			var btnContainer = document.getElementById("sorter2");
			var btns = btnContainer.getElementsByClassName("btn");
			for (var i = 0; i < btns.length; i++){
				btns[i].className = btns[i].className.replace("btn active","btn");
			}
			btns[3].className = btns[3].className.replace("btn","btn active");
		}
		function dateColor() {
			<?php
				for($i=0; $i<count($sets); $i++) {
					echo '
						document.getElementById("set'.$sets[$i]['Set']['id'].'").style.transition = "all 1s"; 
						document.getElementById("set'.$sets[$i]['Set']['id'].'").style.backgroundColor = "'.$sets[$i]['Set']['dateColor'].'";
					';
				}
			?>
			
			document.cookie = "sortColor=4";
			var btnContainer = document.getElementById("sorter2");
			var btns = btnContainer.getElementsByClassName("btn");
			for (var i = 0; i < btns.length; i++){
				btns[i].className = btns[i].className.replace("btn active","btn");
			}
			btns[4].className = btns[4].className.replace("btn","btn active");
		}
		function topicButton2() {
			document.cookie = "sortOrder=00";
		}
		function progressButton2() {
			document.getElementById("progressButton2").innerHTML = '<input type="radio" name="sort-value" value="most-solved" onclick="progressButton1()" /> Progress -&nbsp;';
			document.cookie = "sortOrder=11";
		}
		function progressButton1() {
			document.getElementById("progressButton2").innerHTML = '<input type="radio" name="sort-value" value="most-solved" onclick="progressButton2()" /> Progress +';
			document.cookie = "sortOrder=10";
		}
		function difficultyButton2() {
			document.getElementById("difficultyButton2").innerHTML = '<input type="radio" name="sort-value" value="most-difficulty" onclick="difficultyButton1()" /> Difficulty +';
			document.cookie = "sortOrder=20";
		}
		function difficultyButton1() {
			document.getElementById("difficultyButton2").innerHTML = '<input type="radio" name="sort-value" value="most-difficulty" onclick="difficultyButton2()" /> Difficulty -&nbsp;';
			document.cookie = "sortOrder=21";
		}
		function sizeButton2() {
			document.getElementById("sizeButton2").innerHTML = '<input type="radio" name="sort-value" value="most-problems" onclick="sizeButton1()" /> Size -&nbsp;';
			document.cookie = "sortOrder=31";
		}
		function sizeButton1() {
			document.getElementById("sizeButton2").innerHTML = '<input type="radio" name="sort-value" value="most-problems" onclick="sizeButton2()" /> Size +';
			document.cookie = "sortOrder=30";
		}
		function dateButton2() {
			document.getElementById("dateButton2").innerHTML = '<input type="radio" name="sort-value" value="most-reviews" onclick="dateButton1()" /> Date -&nbsp;';
			document.cookie = "sortOrder=41";
		}
		function dateButton1() {
			document.getElementById("dateButton2").innerHTML = '<input type="radio" name="sort-value" value="most-reviews" onclick="dateButton2()" /> Date +';
			document.cookie = "sortOrder=40";
		}
	</script>

