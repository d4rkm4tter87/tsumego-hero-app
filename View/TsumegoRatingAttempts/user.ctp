

<div align="center">
<p class="title"><br> 
	Rating Mode History of <?php echo $uname; ?>
<br><br> 
</p>


<table width="85%" border="0" class="userstatstable">
	
	<tr>
					<th width="30%"><div align="left">tsumego</div></th>
					<th width="12%">user rating</th>
					<th width="12%">tsumego rating</th>
					<th width="12%">variance</th>
					<th width="12%">time spent</th>
					<th width="22%"><div align="right">time | date</div></th>
				
				
				
				
	</tr>
	<?php
		for($i=0; $i<count($trs); $i++){
			if($trs[$i]['TsumegoRatingAttempt']['tsumego_elo']!=null){
				if($trs[$i]['TsumegoRatingAttempt']['status']=='F'){
					$trs[$i]['TsumegoRatingAttempt']['user_deviation'] = '<font style="font-weight:800;color:red;">-'.$trs[$i]['TsumegoRatingAttempt']['user_deviation'].'</font>';
				}elseif($trs[$i]['TsumegoRatingAttempt']['status']=='S'){
					$trs[$i]['TsumegoRatingAttempt']['user_deviation'] = '<font style="font-weight:800;color:green;">+'.$trs[$i]['TsumegoRatingAttempt']['user_deviation'].'</font>';
				}
				if($trs[$i]['TsumegoRatingAttempt']['user_deviation']==null) $trs[$i]['TsumegoRatingAttempt']['user_deviation'] = 0;
				
				echo '<tr>';
					echo '<td colspan="6">';
						echo '<div class="sandboxComment" id="comment0"><table class="sandboxTable2" width="100%" border="0">
								<tr>';
									echo '<td width="30%">';
										echo '<div align="left">'.$trs[$i]['TsumegoRatingAttempt']['title'].'</div>';
									echo '</td>';
									echo '<td width="12%">';
										echo '<div align="center">'.$trs[$i]['TsumegoRatingAttempt']['user_elo'].'</div>';
									echo '</td>';
									echo '<td width="12%">';
										echo '<div align="center">'.$trs[$i]['TsumegoRatingAttempt']['tsumego_elo'].'</div>';
									echo '</td>';
									echo '<td width="12%">';
										echo '<div align="center">'.$trs[$i]['TsumegoRatingAttempt']['user_deviation'].'</div>';
									echo '</td>';
									echo '<td width="12%">';
										echo '<div align="center">'.$trs[$i]['TsumegoRatingAttempt']['seconds'].'</div>';
									echo '</td>';
									echo '<td width="22%">';
										echo '<div align="right">'.$trs[$i]['TsumegoRatingAttempt']['created'].'</div>';
									echo '</td>';
						echo '</tr>
						</table>
						</div>';
						//echo '<div id="space0"><br></div>';
					echo '</td>';
					
				echo '</tr>';
			}
		}

	?>
	</table>
</div>

<?php
	//echo '<pre>'; print_r($trs); echo '</pre>';
?>