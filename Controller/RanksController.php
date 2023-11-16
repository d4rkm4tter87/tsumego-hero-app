<?php
class RanksController extends AppController {

	public function overview(){
		$this->loadModel('Tsumego');
		$this->loadModel('User');
		$this->loadModel('RankOverview');
		$this->loadModel('RankSetting');
		$this->loadModel('Set');
		$_SESSION['title'] = 'Time Mode - Select';
		$_SESSION['page'] = 'time mode';
		
		$lastMode = 3;
		$tsumegos = array();
		$settings = array();
		$settings['title'] = array();
		$settings['id'] = array();
		$settings['checked'] = array();
		$ro = $this->RankOverview->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
		$sets = $this->Set->find('all', array('conditions' => array('public' => 1)));
		$rs = $this->RankSetting->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
		
		if(isset($_SESSION['loggedInUser'])){
			$u = $this->User->findById($_SESSION['loggedInUser']['User']['id']);
			$lastMode = $u['User']['lastMode'];
		}
		
		if($rs==null){
			for($i=0;$i<count($sets);$i++){
				$unlocked = true;
				if($sets[$i]['Set']['id']==11969 && $_SESSION['loggedInUser']['User']['secretArea1']==0) $unlocked = false;
				elseif($sets[$i]['Set']['id']==29156 && $_SESSION['loggedInUser']['User']['secretArea2']==0) $unlocked = false;
				elseif($sets[$i]['Set']['id']==31813 && $_SESSION['loggedInUser']['User']['secretArea3']==0) $unlocked = false;
				elseif($sets[$i]['Set']['id']==33007 && $_SESSION['loggedInUser']['User']['secretArea4']==0) $unlocked = false;
				elseif($sets[$i]['Set']['id']==71790 && $_SESSION['loggedInUser']['User']['secretArea5']==0) $unlocked = false;
				elseif($sets[$i]['Set']['id']==74761 && $_SESSION['loggedInUser']['User']['secretArea6']==0) $unlocked = false;
				elseif($sets[$i]['Set']['id']==81578 && $_SESSION['loggedInUser']['User']['secretArea7']==0) $unlocked = false;
				elseif($sets[$i]['Set']['id']==6473 && $_SESSION['loggedInUser']['User']['secretArea9']==0) $unlocked = false;
				elseif($sets[$i]['Set']['id']==88156 && $_SESSION['loggedInUser']['User']['secretArea10']==0) $unlocked = false;
				if($unlocked){
					$this->RankSetting->create();
					$rsNew = array();
					$rsNew['RankSetting']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$rsNew['RankSetting']['set_id'] = $sets[$i]['Set']['id'];
					$y = $sets[$i]['Set']['id'];
					if($y==42 || $y==109 || $y==114 || $y==143 || $y==172 || $y==29156 || $y==33007 || $y==74761){
						$rsNew['RankSetting']['status'] = 0;
					}else{
						$rsNew['RankSetting']['status'] = 1;
					}
					$this->RankSetting->save($rsNew);
				}
			}
			$rs = $this->RankSetting->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
		}
		
		if(isset($this->data['Settings'])){
			if(count($this->data['Settings']>=41)){
				$rds0 = $this->RankSetting->find('all', array('conditions' => array(
					'user_id' => $_SESSION['loggedInUser']['User']['id']
				)));
				for($i=0;$i<count($rds0);$i++){
					$rds0[$i]['RankSetting']['status'] = 0;
					$this->RankSetting->save($rds0[$i]);
				}
				foreach($this->data['Settings'] as $ds){
					$rds = $this->RankSetting->find('first', array('conditions' => array(
						'user_id' => $_SESSION['loggedInUser']['User']['id'],
						'set_id' => $ds
					)));
					$rds['RankSetting']['status'] = 1;
					$this->RankSetting->save($rds);
				}
			}
		}
		
		
		/*
		if($_SESSION['loggedInUser']['User']['secretArea1']==0 && $t['Tsumego']['set_id']==11969) echo '<script type="text/javascript">window.location.href = "/";</script>';
		if($_SESSION['loggedInUser']['User']['secretArea2']==0 && $t['Tsumego']['set_id']==29156) echo '<script type="text/javascript">window.location.href = "/";</script>';
		if($_SESSION['loggedInUser']['User']['secretArea3']==0 && $t['Tsumego']['set_id']==31813) echo '<script type="text/javascript">window.location.href = "/";</script>';
		if($_SESSION['loggedInUser']['User']['secretArea4']==0 && $t['Tsumego']['set_id']==33007) echo '<script type="text/javascript">window.location.href = "/";</script>';
		if($_SESSION['loggedInUser']['User']['secretArea5']==0 && $t['Tsumego']['set_id']==71790) echo '<script type="text/javascript">window.location.href = "/";</script>';
		if($_SESSION['loggedInUser']['User']['secretArea6']==0 && $t['Tsumego']['set_id']==74761) echo '<script type="text/javascript">window.location.href = "/";</script>';
		if($_SESSION['loggedInUser']['User']['secretArea7']==0 && $t['Tsumego']['set_id']==81578) echo '<script type="text/javascript">window.location.href = "/";</script>';
		if($_SESSION['loggedInUser']['User']['secretArea9']==0 && $t['Tsumego']['set_id']==6473) echo '<script type="text/javascript">window.location.href = "/";</script>';
		if($_SESSION['loggedInUser']['User']['secretArea10']==0 && $t['Tsumego']['set_id']==88156) echo '<script type="text/javascript">window.location.href = "/";</script>';
		*/
		for($i=0;$i<count($sets);$i++){
			$unlocked = true;
			if($sets[$i]['Set']['id']==11969 && $_SESSION['loggedInUser']['User']['secretArea1']==0) $unlocked = false;
			elseif($sets[$i]['Set']['id']==29156 && $_SESSION['loggedInUser']['User']['secretArea2']==0) $unlocked = false;
			elseif($sets[$i]['Set']['id']==31813 && $_SESSION['loggedInUser']['User']['secretArea3']==0) $unlocked = false;
			elseif($sets[$i]['Set']['id']==33007 && $_SESSION['loggedInUser']['User']['secretArea4']==0) $unlocked = false;
			elseif($sets[$i]['Set']['id']==71790 && $_SESSION['loggedInUser']['User']['secretArea5']==0) $unlocked = false;
			elseif($sets[$i]['Set']['id']==74761 && $_SESSION['loggedInUser']['User']['secretArea6']==0) $unlocked = false;
			elseif($sets[$i]['Set']['id']==81578 && $_SESSION['loggedInUser']['User']['secretArea7']==0) $unlocked = false;
			elseif($sets[$i]['Set']['id']==6473 && $_SESSION['loggedInUser']['User']['secretArea9']==0) $unlocked = false;
			elseif($sets[$i]['Set']['id']==88156 && $_SESSION['loggedInUser']['User']['secretArea10']==0) $unlocked = false;
			if($unlocked){
				array_push($settings['title'], $sets[$i]['Set']['title'].' '.$sets[$i]['Set']['title2']);
				array_push($settings['id'], $sets[$i]['Set']['id']);
				
				$settingsSingle = $this->RankSetting->find('all', array('conditions' => array(
					'user_id' => $_SESSION['loggedInUser']['User']['id'],
					'set_id' => $sets[$i]['Set']['id']
				)));
				if(count($settingsSingle>1)){
					for($j=0;$j<count($settingsSingle);$j++){
						if($j!=0) $this->RankSetting->delete($settingsSingle[$j]['RankSetting']['id']);
					}
				}
				if($settingsSingle[0]['RankSetting']['status']==1){
					$tx = $this->Tsumego->find('all', array('conditions' => array('set_id' => $sets[$i]['Set']['id'])));
					for($j=0;$j<count($tx);$j++){
						array_push($tsumegos, $tx[$j]);
					}
					array_push($settings['checked'], 'checked');
				}else{
					array_push($settings['checked'], '');
				}
			}
		}
		
		$modes = array();
		$modes[0] = array();
		$modes[1] = array();
		$modes[2] = array();
		for($i=0;$i<3;$i++){
			$rank = 15;
			$j=0;
			while($rank>-5){
				$kd = 'k';
				$rank2 = $rank;
				if($rank>=1) $kd = 'k';
				else{ 
					$rank2 = ($rank-1)*(-1);
					$kd = 'd';
				}
				$modes[$i][$j] = $rank2.$kd;
				$rank--;
				$j++;
			}
		}
		
		$locks = array();
		$locks[0] = array();
		$locks[1] = array();
		$locks[2] = array();
		
		for($h=0;$h<count($modes);$h++){
			for($i=0;$i<count($modes[$h]);$i++){
				$locks[$h][$i] = '';
			}
		}
		
		$locks[0][0] = 'x';
		$locks[1][0] = 'x';
		$locks[2][0] = 'x';
		for($h=0;$h<count($modes);$h++){
			for($i=0;$i<count($modes[$h]);$i++){
				for($j=0;$j<count($ro);$j++){
					if($modes[$h][$i]==$ro[$j]['RankOverview']['rank'] && $ro[$j]['RankOverview']['mode']==$h && $ro[$j]['RankOverview']['status']=='s'){
						$locks[$h][$i] = 'x';
						$locks[$h][$i+1] = 'x';
					}
				}
			}
		}
		
		$points = array();
		$points[0] = array();
		$points[1] = array();
		$points[2] = array();
		
		for($i=0;$i<3;$i++){
			for($j=0;$j<count($modes[$i]);$j++){
				$points[$i][$j] = 'x';
			}
		}
		
		for($i=0;$i<3;$i++){
			for($j=0;$j<count($points[$i]);$j++){
				$rox = $this->RankOverview->find('all', array('conditions' =>  array(
					'user_id' => $_SESSION['loggedInUser']['User']['id'], 
					'rank' => $modes[$i][$j],
					'mode' => $i
				)));
				$highest = 0;
				for($k=0;$k<count($rox);$k++){
					if($rox[$k]['RankOverview']['points'] > $highest){
						$highest = $rox[$k]['RankOverview']['points'];
						$points[$i][$j] = $rox[$k]['RankOverview']['points'].'/'.$rox[$k]['RankOverview']['status'];
					}
				}
			}
		}
		
		$rx = array();
		array_push($rx, '15k');
		array_push($rx, '14k');
		array_push($rx, '13k');
		array_push($rx, '12k');
		array_push($rx, '11k');
		array_push($rx, '10k');
		array_push($rx, '9k');
		array_push($rx, '8k');
		array_push($rx, '7k');
		array_push($rx, '6k');
		array_push($rx, '5k');
		array_push($rx, '4k');
		array_push($rx, '3k');
		array_push($rx, '2k');
		array_push($rx, '1k');
		array_push($rx, '1d');
		array_push($rx, '2d');
		array_push($rx, '3d');
		array_push($rx, '4d');
		array_push($rx, '5d');
		$rxx = array();
		for($i=0;$i<count($rx);$i++){
			$rxx[$rx[$i]] = array();
		}
		
		for($i=0;$i<count($tsumegos);$i++){
			if($tsumegos[$i]['Tsumego']['userWin']!=0){
				if($tsumegos[$i]['Tsumego']['userWin']>=0 && $tsumegos[$i]['Tsumego']['userWin']<=22) array_push($rxx['5d'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=26.5) array_push($rxx['4d'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=30) array_push($rxx['3d'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=34) array_push($rxx['2d'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=38) array_push($rxx['1d'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=42) array_push($rxx['1k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=46) array_push($rxx['2k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=50) array_push($rxx['3k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=54.5) array_push($rxx['4k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=58.5) array_push($rxx['5k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=63) array_push($rxx['6k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=67) array_push($rxx['7k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=70.8) array_push($rxx['8k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=74.8) array_push($rxx['9k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=79) array_push($rxx['10k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=83.5) array_push($rxx['11k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=88) array_push($rxx['12k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=92) array_push($rxx['13k'], $tsumegos[$i]);
				elseif($tsumegos[$i]['Tsumego']['userWin']<=96) array_push($rxx['14k'], $tsumegos[$i]);
				else array_push($rxx['15k'], $tsumegos[$i]);
			}
		}
		
		$rxxCount = array();
		array_push($rxxCount, count($rxx['15k']));
		array_push($rxxCount, count($rxx['14k']));
		array_push($rxxCount, count($rxx['13k']));
		array_push($rxxCount, count($rxx['12k']));
		array_push($rxxCount, count($rxx['11k']));
		array_push($rxxCount, count($rxx['10k']));
		array_push($rxxCount, count($rxx['9k']));
		array_push($rxxCount, count($rxx['8k']));
		array_push($rxxCount, count($rxx['7k']));
		array_push($rxxCount, count($rxx['6k']));
		array_push($rxxCount, count($rxx['5k']));
		array_push($rxxCount, count($rxx['4k']));
		array_push($rxxCount, count($rxx['3k']));
		array_push($rxxCount, count($rxx['2k']));
		array_push($rxxCount, count($rxx['1k']));
		array_push($rxxCount, count($rxx['1d']));
		array_push($rxxCount, count($rxx['2d']));
		array_push($rxxCount, count($rxx['3d']));
		array_push($rxxCount, count($rxx['4d']));
		array_push($rxxCount, count($rxx['5d']));
		
		//echo '<pre>'; print_r($rxxCount); echo '</pre>'; 
		$lowestMode = array();
		for($i=0;$i<count($locks);$i++){
			for($j=0;$j<count($locks[$i]);$j++){
				if($locks[$i][$j]=='x') $lowestMode[$i] = $j;
			}
		}
		for($i=0;$i<count($lowestMode);$i++){
			$lowestMode[$i] =$rx[$lowestMode[$i]]; 
		}
		
		$achievementUpdate = $this->checkTimeModeAchievements();
		if(count($achievementUpdate)>0) $this->updateXP($_SESSION['loggedInUser']['User']['id'], $achievementUpdate);
		
		$this->set('lastMode', $lastMode);
		$this->set('lowestMode', $lowestMode);
		$this->set('modes', $modes);
		$this->set('locks', $locks);
		$this->set('points', $points);
		$this->set('rxxCount', $rxxCount);
		$this->set('settings', $settings);
		$this->set('ro', $ro);
		$this->set('achievementUpdate', $achievementUpdate);
	}
	
	public function result($hash=null){
		$this->loadModel('Tsumego');
		$this->loadModel('Set');
		$this->loadModel('RankOverview');
		$_SESSION['title'] = 'Time Mode - Result';
		$_SESSION['page'] = 'time mode';
		$sess = $_SESSION['loggedInUser']['User']['activeRank'];
		$_SESSION['loggedInUser']['User']['activeRank'] = 0;
		$_SESSION['loggedInUser']['User']['mode'] = 1;
		
		$ranks = $this->Rank->find('all', array('conditions' =>  array('session' => $sess)));
		$solved = 0;
		$c = 0;
		$points = array();
		$ro = array();
		$roxBefore = array();
		
		$stopParameter = 0;
		$stopParameterNum = 10;
		$stopParameterPass = 0;
		$stopParameterSec = 0;
		if(strlen($sess)==15){
			$stopParameter = 0;
			$stopParameterNum = 10;
			$stopParameterPass = 8;
			$stopParameterSec = 30;
		}elseif(strlen($sess)==16){
			$stopParameter = 1;
			$stopParameterNum = 10;
			$stopParameterPass = 8;
			$stopParameterSec = 60;
		}elseif(strlen($sess)==17){
			$stopParameter = 2;
			$stopParameterNum = 10;
			$stopParameterPass = 8;
			$stopParameterSec = 240;
		}
		
		$modes = array();
		$modes[0] = array();
		$modes[1] = array();
		$modes[2] = array();
		for($i=0;$i<3;$i++){
			$rank = 15;
			$j=0;
			while($rank>-5){
				$kd = 'k';
				$rank2 = $rank;
				if($rank>=1) $kd = 'k';
				else{ 
					$rank2 = ($rank-1)*(-1);
					$kd = 'd';
				}
				$modes[$i][$j] = $rank2.$kd;
				$rank--;
				$j++;
			}
		}
		
		if($ranks!=null){
			$openCard1 = -1;
			$openCard2 = -1;
			$cardV = 0;
			if($stopParameter==0) $cardV = 0;
			elseif($stopParameter==1) $cardV = 1;
			elseif($stopParameter==2) $cardV = 2;
			
			for($i=0;$i<count($modes[$cardV]);$i++){
				if($ranks[0]['Rank']['rank']==$modes[$cardV][$i]){
					$openCard1 = $cardV;
					$openCard2 = $i;
				}
			}
			for($i=0;$i<count($ranks);$i++){
				$t = $this->Tsumego->findById($ranks[$i]['Rank']['tsumego_id']);
				$s = $this->Set->findById($t['Tsumego']['set_id']);
				
				$ranks[$i]['Rank']['tsumegoNum'] = $t['Tsumego']['num'];
				$ranks[$i]['Rank']['set1'] = $s['Set']['title'];
				$ranks[$i]['Rank']['set2'] = $s['Set']['title2'];
				
				$ranks[$i]['Rank']['seconds'] = round($ranks[$i]['Rank']['seconds'], 1);
				$rx = $stopParameterSec-$ranks[$i]['Rank']['seconds'];
				
				$ranksMinutes = floor($rx/60);
				$ranksSeconds = $rx%60;
				
				$ranksDecimal = $rx-floor($rx);
				$ranksDecimal = round($ranksDecimal, 1);
				$ranksDecimal *= 10;
				
				$points[$i] = $this->calculatePoints($rx, $stopParameterSec);
				if($rx>=10){
					$rx1 = '';
				}else{
					$rx1 = '0';
					if($ranksMinutes>0) $rx1 = '00';
				}
				
				$ranks[$i]['Rank']['seconds'] = $ranksMinutes.':'.$rx1.$ranksSeconds.'.'.$ranksDecimal;
				$ranks[$i]['Rank']['points'] = $points[$i];
				
				if($ranks[$i]['Rank']['result'] == 'failed' || $ranks[$i]['Rank']['result'] == 'timeout' || $ranks[$i]['Rank']['result'] == 'skipped'){
					$c++;
					$points[$i] = 0;
					$ranks[$i]['Rank']['points'] = 0;
					if($ranks[$i]['Rank']['result'] == 'timeout' || $ranks[$i]['Rank']['result'] == 'skipped') $ranks[$i]['Rank']['seconds'] = '0:00.0';
				}elseif($ranks[$i]['Rank']['result'] == 'solved'){
					$solved++;
				}else{
					$c++;
				}
				$rSingle = $this->Rank->findById($ranks[$i]['Rank']['id']);
				$rSingle['Rank']['points'] = $ranks[$i]['Rank']['points'];
				$this->Rank->save($rSingle);
			}
			
			$sum = 0;
			for($i=0;$i<count($points);$i++){
				$sum+=$points[$i];
			}
			
			$roxBefore = $this->RankOverview->find('all', array('conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'],
				'rank' => $ranks[0]['Rank']['rank'],
				'mode' => $stopParameter,
				'status' => 's'
			)));
			
			$ro = array();
			$ro['RankOverview']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$ro['RankOverview']['session'] = $sess;
			$ro['RankOverview']['rank'] = $ranks[0]['Rank']['rank'];
			if($solved>=$stopParameterPass) $ro['RankOverview']['status'] = 's';
			else $ro['RankOverview']['status'] = 'f';
			$ro['RankOverview']['mode'] = $stopParameter;
			$ro['RankOverview']['points'] = $sum;
			$this->RankOverview->create();
			$this->RankOverview->save($ro);
		}
		
		/*$all2 = $this->RankOverview->find('all', array('conditions' =>  array(
			'user_id' => $_SESSION['loggedInUser']['User']['id'],
			'mode' => 2
		)));
		$all1 = $this->RankOverview->find('all', array('conditions' =>  array(
			'user_id' => $_SESSION['loggedInUser']['User']['id'],
			'mode' => 1
		)));
		$all0 = $this->RankOverview->find('all', array('conditions' =>  array(
			'user_id' => $_SESSION['loggedInUser']['User']['id'],
			'mode' => 0
		)));
		
		$all = array();
		$all[0] = array();
		$all[1] = array();
		$all[2] = array();
		for($i=0;$i<count($all2);$i++){
			
		}*/
		$sessArray = array();
		$sessArray[0] = array();
		$sessArray[1] = array();
		$sessArray[2] = array();
		for($i=0;$i<3;$i++){
			$rank = 15;
			$j=0;
			while($rank>-5){
				$kd = 'k';
				$rank2 = $rank;
				if($rank>=1) $kd = 'k';
				else{ 
					$rank2 = ($rank-1)*(-1);
					$kd = 'd';
				}
				$sessArray[$i][$j] = $rank2.$kd;
				$rank--;
				$j++;
			}
		}
		
		$allR = $this->Rank->find('all', array('conditions' =>  array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
		
		for($i=0;$i<3;$i++){
			for($j=0;$j<count($modes[$i]);$j++){
				$rox = $this->RankOverview->find('all', array('conditions' =>  array(
					'user_id' => $_SESSION['loggedInUser']['User']['id'], 
					'rank' => $modes[$i][$j],
					'mode' => $i
				)));
				$highest = 0;
				$highestId = 0;
				for($k=0;$k<count($rox);$k++){
					if($rox[$k]['RankOverview']['points'] > $highest){
						$sessArray[$i][$j] = $rox[$k]['RankOverview']['session'];
						$highest = $rox[$k]['RankOverview']['points'];
						$highestId = $rox[$k]['RankOverview']['id'];
						$modes[$i][$j] = $rox[$k];
						if($modes[$i][$j]['RankOverview']['status']=='s') $modes[$i][$j]['RankOverview']['status'] = 'passed';
						elseif($modes[$i][$j]['RankOverview']['status']=='f') $modes[$i][$j]['RankOverview']['status'] = 'failed';
						if($modes[$i][$j]['RankOverview']['mode']==2) $modes[$i][$j]['RankOverview']['mode'] = 'Slow';
						elseif($modes[$i][$j]['RankOverview']['mode']==1) $modes[$i][$j]['RankOverview']['mode'] = 'Fast';
						elseif($modes[$i][$j]['RankOverview']['mode']==0) $modes[$i][$j]['RankOverview']['mode'] = 'Blitz';
						$date = new DateTime($modes[$i][$j]['RankOverview']['created']);
						$month = $date->format('m.');
						$tday = $date->format('d.');
						$tyear = $date->format('Y');
						$tClock = $date->format('H:i');
						if($tday[0]==0) $tday = substr($tday, -3);
						$modes[$i][$j]['RankOverview']['created'] = $tClock.' '.$tday.$month.$tyear;
					}
				}
				for($k=0;$k<count($rox);$k++){
					if($rox[$k]['RankOverview']['id']!=$highestId && $sess!=$rox[$k]['RankOverview']['session']){
						$this->RankOverview->delete($rox[$k]['RankOverview']['id']);
						$rDel = $this->Rank->find('all', array('conditions' => array('session' => $rox[$k]['RankOverview']['session'])));
						for($l=0;$l<count($rDel);$l++){
							//$this->Rank->delete($rDel[$l]['Rank']['id']);
						}
					}
				}
			}
		}
		
		$allR = array();
		for($h=0;$h<count($modes);$h++){
			$allR[$h] = array();
			for($i=0;$i<count($modes[$h]);$i++){
				if($h==$openCard1 && $i==$openCard2){
					$allR[$h][$i] = $this->Rank->find('all', array('order' => 'num ASC', 'conditions' => array('session' => $modes[$h][$i]['RankOverview']['session'])));
					for($j=0;$j<count($allR[$h][$i]);$j++){
						$tx = $this->Tsumego->findById($allR[$h][$i][$j]['Rank']['tsumego_id']);
						$sx = $this->Set->findById($tx['Tsumego']['set_id']);
						$foundSkipped = false;
						$timeFieldColor = '#e03c4b';
						if($h==0) $ss = 30;
						elseif($h==1) $ss = 60;
						elseif($h==2) $ss = 240;
						$allR[$h][$i][$j]['Rank']['tsumego'] = $sx['Set']['title'].' '.$sx['Set']['title2'].' - '.$tx['Tsumego']['num'];
						if($allR[$h][$i][$j]['Rank']['result']=='solved') $hh = 'green';
						else $hh = '#e03c4b';
						if($allR[$h][$i][$j]['Rank']['result']=='timeout') $allR[$h][$i][$j]['Rank']['seconds'] = $ss;
						if($allR[$h][$i][$j]['Rank']['result']=='skipped') $foundSkipped = true;
						if($allR[$h][$i][$j]['Rank']['result']=='solved') $timeFieldColor = 'green';
						$allR[$h][$i][$j]['Rank']['result'] = '<b style="color:'.$hh.';">'.$allR[$h][$i][$j]['Rank']['result'].'</b>';
						$allR[$h][$i][$j]['Rank']['seconds'] = round($allR[$h][$i][$j]['Rank']['seconds'], 1);
						$rx = $ss-$allR[$h][$i][$j]['Rank']['seconds'];
						$ranksMinutes = floor($rx/60);
						$ranksSeconds = $rx%60;
						$ranksDecimal = $rx-floor($rx);
						$ranksDecimal = round($ranksDecimal, 1);
						$ranksDecimal *= 10;
						if($rx>=10){
							$rx1 = '';
						}else{
							$rx1 = '0';
							if($ranksMinutes>0) $rx1 = '00';
						}
						$allR[$h][$i][$j]['Rank']['seconds'] = $ranksMinutes.':'.$rx1.$ranksSeconds.'.'.$ranksDecimal;
						if($foundSkipped){
							$allR[$h][$i][$j]['Rank']['seconds'] = '0:00.0';
						}
						$allR[$h][$i][$j]['Rank']['seconds'] = '<font style="color:'.$timeFieldColor.';">'.$allR[$h][$i][$j]['Rank']['seconds'].'</font>';
					}
				}
			}
		}
		
		for($h=0;$h<count($modes[$_SESSION['loggedInUser']['User']['lastMode']-1]);$h++){
			if(isset($modes[$_SESSION['loggedInUser']['User']['lastMode']-1][$h]['RankOverview'])) $lastModeV = $modes[$_SESSION['loggedInUser']['User']['lastMode']-1][$h]['RankOverview']['rank'];
		}
		
		//echo '<pre>'; print_r($lastModeV); echo '</pre>';
		//echo '<pre>'; print_r($allR); echo '</pre>';
		//echo '<pre>'; print_r($all); echo '</pre>';
		//echo '<pre>'; print_r(count($all)); echo '</pre>';
		
		//echo '<pre>'; print_r($openCard1); echo '</pre>';
		//echo '<pre>'; print_r($openCard2); echo '</pre>';
		//echo '<pre>'; print_r($sessArray); echo '</pre>';
		//echo '<pre>'; print_r($ranks[0]['Rank']['session']); echo '</pre>';
		$sessionFound = false;
		for($i=0;$i<count($sessArray);$i++){
			for($j=0;$j<count($sessArray[$i]);$j++){
				if($sessArray[$i][$j]==$ranks[0]['Rank']['session']) $sessionFound = true;
			}
		}
		//echo '<pre>'; print_r($ro); echo '</pre>';
		//echo '<pre>'; print_r($roxBefore); echo '</pre>';
		
		if(count($roxBefore)>0) $newUnlock = false;
		else $newUnlock = true;
		
		$this->set('c', $c);
		$this->set('solved', $solved);
		$this->set('ranks', $ranks);
		$this->set('points', $points);
		$this->set('stopParameterNum', $stopParameterNum);
		$this->set('stopParameterPass', $stopParameterPass);
		$this->set('modes', $modes);
		$this->set('allR', $allR);
		$this->set('openCard1', $openCard1);
		$this->set('openCard2', $openCard2);
		$this->set('lastModeV', $lastModeV);
		$this->set('sessionFound', $sessionFound);
		$this->set('ro', $ro);
		$this->set('newUnlock', $newUnlock);
	}

	private function calculatePoints($time=null, $max=null){
		$rx = 0;
		if($max==240){
			$rx = 20+round($time/3);
		}elseif($max==60){
			$rx = 40+round($time);
		}elseif($max==30){
			$rx = 40+round($time*2);
		}
		return $rx;
	}
	
}




