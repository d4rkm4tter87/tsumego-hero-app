<?php
	if(isset($_SESSION['loggedInUser'])){
		if($_SESSION['loggedInUser']['User']['isAdmin']<1){
			echo '<script type="text/javascript">window.location.href = "/";</script>';
		}	
	}else{
		echo '<script type="text/javascript">window.location.href = "/";</script>';
	}
	?>
	<div class="homeRight">	
	<h1>Set mark by tsumego id</h1>
	<?php
	echo '<div>';
	echo $this->Form->create('Mark');
	echo '<table border="0">';
	echo '<tr>';
	echo '<td>';
	echo $this->Form->input('tsumego_id', array('label' => '', 'type' => 'text', 'placeholder' => 'id'));
	echo '</td><td>';
	echo '<div class="submit"><input value="Submit" type="submit"></div>';
	echo '</td>';
	echo '<tr>';
	echo '</table>';
	echo '</div>';
	?>
	<br>
	<hr>
	<h1>Marked as duplicate:</h1>
		<?php if(!empty($marks)){ ?>
		<font color="gray"><i>(main/duplicate)</i></font>
		<table class="statsTable" border="0" width="100%">
		<?php
		for($i=0; $i<count($marks); $i++){
			echo '<tr>';
			echo '<td id="t0">
			<input type="radio" id="r'.$marks[$i]['Tsumego']['id'].'" name="data[Settings][r41]" value="'.$marks[$i]['Tsumego']['title'].'">
			<input type="checkbox" id="c'.$marks[$i]['Tsumego']['id'].'">
			</td>';
			echo '<td id="t1">
				<li class="set'.$marks[$i]['Tsumego']['status'].'1" style="margin-top:4px;">
					<a href="/tsumegos/play/'.$marks[$i]['Tsumego']['id'].'">'.$marks[$i]['Tsumego']['num'].'</a>
				</li>
			</td>';
			echo '<td id="t2">'.$marks[$i]['Tsumego']['title'].' </td>';
			echo '<td id="t3"><a href="/users/duplicates/?remove='.$marks[$i]['Tsumego']['id'].'">remove</a></td>';
			echo '</tr>';
		}
		?>
		</table>
		<br>
		<div id="createD1"><br></div>
		<div id="createD2"><br></div>
		<br>
		<a id="submitDuplicates" class="default-submit-button-inactive">Create duplicates</a>
		<?php }else{ ?>
			<br>
			There are no duplicate marks.
		<?php } ?>
	</div>
	<script>
	let markIds = [];
	let markNames = [];
	let added = [];
	let main = 0;
	let urlParams = "";
	<?php
		for($i=0; $i<count($marks); $i++){
			echo 'markIds['.$i.'] ='.$marks[$i]['Tsumego']['id'].';';
			echo 'markNames['.$i.'] ="'.$marks[$i]['Tsumego']['title'].'";';
		}
	?>
	<?php for($i=0; $i<count($marks); $i++){ ?>
		$("#c<?php echo $marks[$i]['Tsumego']['id']; ?>").change(function(){
			if ($(this).is(":checked")){
				addMark(<?php echo $i; ?>);
			}else{
				removeMark(<?php echo $i; ?>);
			}
		});
		$("#r<?php echo $marks[$i]['Tsumego']['id']; ?>").change(function(){
			main = <?php echo $marks[$i]['Tsumego']['id']; ?>;
			setUrlParams();
			$("#createD1").html("main: <b>"+$("#r<?php echo $marks[$i]['Tsumego']['id']; ?>").val() + "</b>");
			displayValid(checkValid());
		});
	<?php } ?>
	function addMark(m){
		added.push(m);
		displayMarks();
		displayValid(checkValid());
	}
	function removeMark(m){
		let a = [];
		for(i=0; i<added.length; i++){
			if(added[i]!==m)
				a.push(added[i]);
		}
		added = a;
		displayMarks();
		displayValid(checkValid());
	}
	function displayMarks(){
		let str = "duplicate group: ";
		for(i=0; i<added.length; i++){
			str = str + "<b>" + markNames[added[i]] + "</b>";
			if(i!==added.length-1)
				str += ", ";
		}
		$("#createD2").html(str);
		setUrlParams();
	}
	function setUrlParams(){
		urlParams = "?main=" + main + "&duplicates=";
		for(i=0; i<added.length; i++){
			urlParams = urlParams + markIds[added[i]];
			if(i!==added.length-1)
				urlParams += "-";
		}
	}
	function checkValid(){
		let valid = false;
		if(main===0 || added.length<2)
			return false;
		for(i=0; i<added.length; i++){
			if(markIds[added[i]]===main)
				valid = true;
		}
		return valid;
	}
	function displayValid(v){
		if(v){
			$("#submitDuplicates").addClass("default-submit-button");
			$("#submitDuplicates").removeClass("default-submit-button-inactive");
			$("#submitDuplicates").attr("href", "/users/duplicates/"+urlParams);
		}else{
			$("#submitDuplicates").removeClass("default-submit-button");
			$("#submitDuplicates").addClass("default-submit-button-inactive");
			$("#submitDuplicates").removeAttr("href");
		}
	}
	</script>
	<div class="homeLeft" style="border-right:1px solid #a0a0a0;">
	<h1>Duplicates</h1>
		<?php
			if($aMessage!=null)
				echo $aMessage;
			for($i=0; $i<count($d); $i++){
				echo '<hr><table class="statsTable" border="0" width="100%">';
				for($j=0; $j<count($d[$i]); $j++){
					echo '<tr>';
					echo '<td id="t1">
						<li class="set'.$d[$i][$j]['Tsumego']['status'].'1" style="margin-top:4px;">
							<a href="/tsumegos/play/'.$d[$i][$j]['Tsumego']['id'].'">'.$d[$i][$j]['Tsumego']['num'].'</a>
						</li>
					</td>';
					echo '<td id="t2">'.$d[$i][$j]['Tsumego']['title'].'</td>';
					if($j==0)
						$mainOrNot = '<div id="mainLine'.$i.'"><a class="ml" id="mainLineA'.$i.'">main</a></div>
						<div class="mainLineX'.$i.'"><input type="text" id="mainCommand'.$d[$i][$j]['Tsumego']['id'].'" value="main" size="6" maxlength="6"></div>';
					else
						$mainOrNot = '<div class="mainLineX'.$i.'"><input type="text" id="mainCommand'.$d[$i][$j]['Tsumego']['id'].'" value="" size="6" maxlength="6"></div>';
					echo '<td id="t3">'.$mainOrNot.'</td>';
					echo '</tr>';
				}
				echo '</table>';
				echo '<div id="duplicateFooter'.$i.'" align="right"><i>commands: main, remove</i> &nbsp;&nbsp;&nbsp; 
				<a id="command'.$i.'" class="default-submit-button">Submit</a></div>';
			}
		?>
	</div>
	<script>
		let commandGroups = [];
		let temp;
		<?php for($i=0; $i<count($d); $i++){ ?>
			$("#mainLineA<?php echo $i; ?>").click(function(){
				$(".mainLineX<?php echo $i; ?>").css("display", "block");
				$("#duplicateFooter<?php echo $i; ?>").css("display", "block");
				$("#mainLine<?php echo $i; ?>").css("display", "none");
			});
			temp = [];
			<?php for($j=0; $j<count($d[$i]); $j++){ ?>
				temp.push(<?php echo $d[$i][$j]['Tsumego']['id']; ?>);
			<?php } ?>
			commandGroups.push(temp);
			$("#command<?php echo $i; ?>").click(function(){
				let found = false;
				for(x=0; x<commandGroups[<?php echo $i; ?>].length; x++){
					if($("#mainCommand"+commandGroups[<?php echo $i; ?>][x]).val() === "remove"){
						window.location.href = "/users/duplicates/?removeDuplicate="+commandGroups[<?php echo $i; ?>][x];
						found = true;
						break;
					}
				}
				if(!found){
					for(x=0; x<commandGroups[<?php echo $i; ?>].length; x++){
						if($("#mainCommand"+commandGroups[<?php echo $i; ?>][x]).val() === "main"){
							window.location.href = "/users/duplicates/?setMain="+commandGroups[<?php echo $i; ?>][x];
							break;
						}
					}
				}
			});
		<?php } ?>
	</script>
	<style>
		<?php for($i=0; $i<count($d); $i++){
			echo '.mainLineX'.$i.'{display:none;}';
			echo '#duplicateFooter'.$i.'{display:none;margin:11px;}';
		} ?>
		.ml{text-decoration:underline;cursor:pointer;}
		#t0{margin:0;padding:0;width:55px;}
		#t1{text-align:left;width:77px;}
		#t2{text-align:left;}
		#t3{text-align:right;width:52px;}
	</style>
	<?php
	//echo date('Y-m-d H:i:s');
	?>