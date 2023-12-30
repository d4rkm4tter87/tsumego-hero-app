	
	<script src ="/js/previewBoard.js"></script>
	<div align="center">
	<p class="title">
		<br>
		Similar problem search for <?php echo $title; ?>
		<br>
	</p>
	
	<table width="40%" border="0">
	<tr>
	<td width="51%">
	<div class="slidecontainer">
	  <input type="range" min="0" max="6" value="<?php echo $maxDifference; ?>" class="slider" id="rangeInput" name="rangeInput">
	  <div id="sliderText"></div>
	</div>
	</td>
	<td width="49%">
		<?php
			if($includeSandbox=='true')
				$includeSandbox = 'checked="checked"';
			if($includeColorSwitch=='true')
				$includeColorSwitch = 'checked="checked"';
		?>
		<input type="checkbox" value="1" id="i1" <?php echo $includeSandbox; ?>>
		<label for="i1">Include sandbox</label><br>
		<input type="checkbox" value="2" id="i2" <?php echo $includeColorSwitch; ?>>
		<label for="i2">Include color switch</label>
	</td>
	</tr>
	</table>
	<a id="command0" class="default-submit-button">Search</a><br><br>
	</div>
	<table width="100%" border="0" class="duplicateSearchTable">
	<tr>
	<td width="50%">
		<div align="right">
		<?php echo '<a href="/tsumegos/play/'.$t['Tsumego']['id'].'">'.$title.'</a><br><br>'; ?>
		<div id="tooltipSvg-1"></div>
		</div>
	</td>
	<td width="50%">
	<?php 
		for($i=0; $i<count($similarArr); $i++){
			if($similarDiff[$i]==0) $description1 = 'No difference. ';
			else if($similarDiff[$i]==1) $description1 = $similarDiff[$i].' stone different. ';
			else $description1 = $similarDiff[$i].' stones different. ';
			echo '<a href="/tsumegos/play/'.$similarId[$i].'">'.$similarTitle[$i].'</a><br>';
			echo $description1;
			echo $similarDiffType[$i].'<br>';
			echo '<div id="tooltipSvg'.$i.'"></div><br>';
		}
		if(count($similarArr)==0)
			echo 'No problems found.';
	?>
	</td>
	</tr>
	</table>
	<?php	
	//echo '<pre>'; print_r($t); echo '</pre>';
	?>
	<script>
		let similarArr = [];
		<?php
		echo 'let tSgfArr = [];';
		for($y=0; $y<count($tSgfArr); $y++){
			echo 'tSgfArr['.$y.'] = [];';
			for($x=0; $x<count($tSgfArr[$y]); $x++){
				echo 'tSgfArr['.$y.'].push("'.$tSgfArr[$x][$y].'");';
			}
		}
		
		for($a=0; $a<count($similarArr); $a++){
			echo 'similarArr['.$a.'] = [];';
			for($y=0; $y<count($similarArr[$a]); $y++){
				echo 'similarArr['.$a.']['.$y.'] = [];';
				for($x=0; $x<count($similarArr[$a][$y]); $x++){
					echo 'similarArr['.$a.']['.$y.'].push("'.$similarArr[$a][$x][$y].'");';
				}
			}
		}
		echo 'createPreviewBoard(-1, tSgfArr, '.$tSgfArrInfo[0].', '.$tSgfArrInfo[1].', '.$tSgfArrBoardSize.');';
		for($i=0; $i<count($similarArr); $i++){
			echo 'createPreviewBoard('.$i.', similarArr['.$i.'], '.$similarArrInfo[$i][0].', '.$similarArrInfo[$i][1].', '.$similarArrBoardSize[$i].');';
		}
		?>
		
	var rangeInput = document.getElementById("rangeInput");
	const Slider = document.querySelector('input[name=rangeInput]');
	let sliderText = [];
	sliderText[0] = "No difference";
	sliderText[1] = "1 or less stones different";
	sliderText[2] = "2 or less stones different";
	sliderText[3] = "3 or less stones different";
	sliderText[4] = "4 or less stones different";
	sliderText[5] = "5 or less stones different";
	sliderText[6] = "6 or less stones different";

	$('#sliderText').css({"color":"#2575df"});
	$('#sliderText').text(sliderText[<?php echo $maxDifference; ?>]);
	Slider.style.setProperty('--SliderColor', '#2575df');

	rangeInput.addEventListener('change', function(){
		const Slider = document.querySelector('input[name=rangeInput]');
		if(this.value==0){
			$('#sliderText').css({"color":"#2575df"});
			$('#sliderText').text(sliderText[0]);
			Slider.style.setProperty('--SliderColor', '#2575df');
		}else if(this.value==1){
			$('#sliderText').css({"color":"#2575df"});
			$('#sliderText').text(sliderText[1]);
			Slider.style.setProperty('--SliderColor', '#2575df');
		}else if(this.value==2){
			$('#sliderText').css({"color":"#2575df"});
			$('#sliderText').text(sliderText[2]);
			Slider.style.setProperty('--SliderColor', '#2575df');
		}else if(this.value==3){
			$('#sliderText').css({"color":"#2575df"});
			$('#sliderText').text(sliderText[3]);
			Slider.style.setProperty('--SliderColor', '#2575df');
		}else if(this.value==4){
			$('#sliderText').css({"color":"#2575df"});
			$('#sliderText').text(sliderText[4]);
			Slider.style.setProperty('--SliderColor', '#2575df');
		}else if(this.value==5){
			$('#sliderText').css({"color":"#2575df"});
			$('#sliderText').text(sliderText[5]);
			Slider.style.setProperty('--SliderColor', '#2575df');
		}else{
			$('#sliderText').css({"color":"#2575df"});
			$('#sliderText').text(sliderText[6]);
			Slider.style.setProperty('--SliderColor', '#2575df');
		}
	});
	$("#command0").click(function(){
		let range = $('#rangeInput').val();
		let sandbox = document.getElementById('i1').checked;
		let colorSwitch = document.getElementById('i2').checked;
		window.location.href="/tsumegos/duplicatesearch/<?php echo $t['Tsumego']['id']; ?>?diff="+range+"&sandbox="+sandbox+"&colorSwitch="+colorSwitch;
	});
	</script>
	<style>.duplicateSearchTable td{vertical-align: top;padding:14px;}</style>