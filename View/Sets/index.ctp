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
				//echo '<pre>';print_r($test1);echo '</pre>';
			}			
		}
		
	?>
	<div align="center" class="display1">
		
	<section class="scontainer" align="center">
		  <div style="display: none;">
			  <button class="btn" id="prepend"></button>
			  <button class="btn" id="append"></button>
			  <button class="btn" id="remove"></button>
			  <button class="btn" id="randomize"></button>
		  </div>
		  <table border="0">
		  <tr>
			<td class="filterLabel1">Sort by:</td>
			<td class="filterLabel1">Colors by:</td>
		  </tr>
		  
		  <tr>
		  <td>
			  <fieldset class="filter-group1">
				<div class="btn-group" id="sorter">
				<?php
				echo '
				  <label id="topicButton2" class="btn '.$active0.'">
					<input type="radio" name="sort-value" value="dom" onclick="topicButton2()" /> Topic
				  </label>
				  <label id="progressButton2" class="btn '.$active1.'">
					<input type="radio" name="sort-value" value="most-solved" onclick="progressButton2()" /> Progress +
				  </label>
				  <label id="difficultyButton2" class="btn '.$active2.'">
					<input type="radio" name="sort-value" value="most-difficulty" onclick="difficultyButton2()" /> Difficulty -&nbsp;
				  </label>
				   <div style="display: none;">
				  <label class="btn"> 
					<input type="radio" name="sort-value" value="hidden" /> hidden
				  </label>
				  </div>
				   <label id="sizeButton2" class="btn '.$active3.'">
					<input type="radio" name="sort-value" value="most-problems" onclick="sizeButton2()" /> Size +
				  </label>
				 
				';
				?>  
				</div>
			  </fieldset>
		  </td>
		  <td>
			  <fieldset class="filter-group2">
				<div class="btn-group" id="sorter2">
				  <label id="topicColor" class="btn active">
					<input type="radio" onclick="topicColor()" /> Topic
				  </label>
				  <label id="progressColor" class="btn">
					<input type="radio" onclick="solvedColor()" /> Progress
				  </label>
				  <label id="difficultyColor" class="btn">
					<input type="radio" onclick="difficultyColor()" /> Difficulty
				  </label>
				  <label id="sizeColor" class="btn">
					<input type="radio" onclick="sizeColor()" /> Size
				  </label>
				</div>
			  </fieldset>
		    </td>
			</tr>
			</table>
	</section>

	<section class="scontainer">
	  <div class="row">
		<div class="col-6@sm">
		  <div id="my-shuffle" class="items">
			<?php 
				
			
				for($i=0; $i<count($sets); $i++) {
					if($sets[$i]['Set']['id']!=1) $favFont = '';
					else $favFont = 'color:#555;';
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
					|| $sets[$i]['Set']['id']==6473
					){
						$secretAreaBg = 'sa';
					}else{
						$secretAreaBg = '';
					}
					$s = 's';
					if($sets[$i]['Set']['id']==31813) $s = '';
					if($sets[$i]['Set']['anz']==1) $s = '';
					
					if($sets[$i]['Set']['solved']==100) $completed=' Completed';
					else $completed='';
					echo '
						<div id="set'.$sets[$i]['Set']['id'].'" class="box box'.$solvedBar.$secretAreaBg.' '.$completed.'" data-reviews="'
						.$sets[$i]['Set']['created'].'" data-problems="'.$sets[$i]['Set']['anz'].'" 
						data-difficulty="'.$sets[$i]['Set']['difficulty'].'" data-solved="'.$sets[$i]['Set']['solved'].'" 
						style="background-color:'.$sets[$i]['Set']['topicColor'].';">
							<a href="/sets/view/'.$sets[$i]['Set']['id'].'" style="text-decoration:none;color:white;">
								<div style="'.$favFont.'text-decoration:none;">
									<p class="title">'.$sets[$i]['Set']['title'].'</p>
									<p class="titleBy">by '.$sets[$i]['Set']['author'].'</p> 
									<b>'.$sets[$i]['Set']['title2'].'</b>';
									if($sets[$i]['Set']['id']!=58 && $sets[$i]['Set']['id']!=68 && $sets[$i]['Set']['id']!=109) echo '<br><br>';
									else echo '<br>';
									echo '<table border="0" width="100%" style="padding-top:19px;color:white">
										<tr>
											<td width="50%">
												<div class="display1" align="center"><b>'.$sets[$i]['Set']['anz'].' Problem'.$s.'<br>Solved: '.$sets[$i]['Set']['solved'].'%</b></div>
											</td>
											<td>
												<div class="display1" align="center">
												<b>Difficulty:<br>
												'.$sets[$i]['Set']['difficulty'].'
												</div>
												</b>
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
	   <br><br>
	  <p class="title">Problem Count
	  <br><br></p>
	  <?php 
		//echo '<pre>';print_r($sets);echo '</pre>';
		
		echo '<table width="35%" border="0">';
		$summe = 0;
		for($i=0; $i<count($sets); $i++){
			if($sets[$i]['Set']['title']!='Favorites'){
				if($sets[$i]['Set']['id']>1000) $sets[$i]['Set']['title'] = '[Secret Area]';
				echo '<tr><td>'.$sets[$i]['Set']['title'].'</td><td><div align="right">'.$sets[$i]['Set']['anz'].'</div></td></tr>';
				$summe += $sets[$i]['Set']['anz'];
			}
		}
		echo '<tr><td><div style="font-weight:800"><hr>&nbsp;</div></td><td><div align="right" style="font-weight:800"><hr>'.$summe.'*</td></tr></div><tr><td colspan="2">';
		
	  ?>
	  <br>
	  <div align="left"><font size="4" color="grey"><i>*Might not show hidden collections.</i></font></div></td></tr></table>
	</section>
	<br><br>
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

