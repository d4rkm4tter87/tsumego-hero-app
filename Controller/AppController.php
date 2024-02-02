<?php
App::uses('Controller', 'Controller');

define('INITIAL_RATING', 1000.0);
define('INITIAL_RD', 300.0);
define('C', 30.0);
define('Q', 0.0057564);

class AppController extends Controller{
	public function processSGF($sgf){
		$aw = strpos($sgf, 'AW');
		$ab = strpos($sgf, 'AB');
		$boardSizePos = strpos($sgf, 'SZ');
		$boardSize = 19;
		$sgfArr = str_split($sgf);
		if($boardSizePos!=null)
			$boardSize = $sgfArr[$boardSizePos+3].''.$sgfArr[$boardSizePos+4];
		if(substr($boardSize, 1) == ']')
			$boardSize = substr($boardSize, 0, 1);
		
		$black = $this->getInitialPosition($ab, $sgfArr, 'x');
		$white = $this->getInitialPosition($aw, $sgfArr, 'o');
		$stones = array_merge($black, $white);
		
		$board = array();
		for($i=0; $i<19; $i++){
			$board[$i] = array();
			for($j=0; $j<19; $j++){
				$board[$i][$j] = '-';
			}
		}
		
		$lowestX = 18;
		$lowestY = 18;
		$highestX = 0;
		$highestY = 0;
		for($i=0; $i<count($stones); $i++){
			if($stones[$i][0]<$lowestX)
				$lowestX = $stones[$i][0];
			if($stones[$i][0]>$highestX)
				$highestX = $stones[$i][0];
			if($stones[$i][1]<$lowestY)
				$lowestY = $stones[$i][1];
			if($stones[$i][1]>$highestY)
				$highestY = $stones[$i][1];
		}
		//echo '<pre>';print_r($stones);echo '</pre>';
		if(18-$lowestX < $lowestX){
			$stones = $this->xFlip($stones);
		}
		if(18-$lowestY < $lowestY){
			$stones = $this->yFlip($stones);
		}
		$highestX = 0;
		$highestY = 0;
		for($i=0; $i<count($stones); $i++){
			if($stones[$i][0]>$highestX)
				$highestX = $stones[$i][0];
			if($stones[$i][1]>$highestY)
				$highestY = $stones[$i][1];
			$board[$stones[$i][0]][$stones[$i][1]] = $stones[$i][2];
		}
		/*
		for($y=0; $y<count($board); $y++){
			for($x=0; $x<count($board[$y]); $x++){
				echo '&nbsp;&nbsp;'.$board[$x][$y].' ';
			}
			echo '<br>';
		}*/
		$tInfo = array();
		$tInfo[0] = $highestX;
		$tInfo[1] = $highestY;
		
		$arr = array();
		$arr[0] = $board;
		$arr[1] = $stones;
		$arr[2] = $tInfo;
		$arr[3] = $boardSize;
		
		return $arr;
	}
	
	public function xFlip($stones){
		for($i=0; $i<count($stones); $i++)
			$stones[$i][0] = 18-$stones[$i][0];
		return $stones;
	}
	
	public function yFlip($stones){
		for($i=0; $i<count($stones); $i++)
			$stones[$i][1] = 18-$stones[$i][1];
		return $stones;
	}
	
	public function getInitialPositionEnd($pos, $sgfArr){
		$endCondition = 0;
		$currentPos1 = $pos+2;
		$currentPos2 = $pos+5;
		while($sgfArr[$currentPos1]=='[' && $sgfArr[$currentPos2]==']'){
			$endCondition = $currentPos2;
			$currentPos1+=4;
			$currentPos2+=4;
		}
		return $endCondition;
	}
	
	public function getInitialPosition($pos, $sgfArr, $color){
		$arr = array();
		$end = $this->getInitialPositionEnd($pos, $sgfArr);
		for($i=$pos+2; $i<$end; $i++){
			if($sgfArr[$i]!='[' && $sgfArr[$i]!=']')
				array_push($arr, strtolower($sgfArr[$i]));
		}
		$alphabet = array_flip(array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'));
		$xy = true;
		$arr2 = array();
		$c = 0;
		for($i=0; $i<count($arr); $i++){
			$arr[$i] = $alphabet[$arr[$i]];
			if($xy){
				$arr2[$c] = array();
				$arr2[$c][0] = $arr[$i];
			}else{
				$arr2[$c][1] = $arr[$i];
				$arr2[$c][2] = $color;
				$c++;
			}
			$xy = !$xy;
		}
		return $arr2;
	}

	public function getInvisibleSets(){
		$this->LoadModel('Set');
		$invisibleSets = array();
		$in = $this->Set->find('all', array('conditions' => array('public' => 0)));
		for($i=0; $i<count($in); $i++){
			array_push($invisibleSets, $in[$i]['Set']['id']);
		}
		return $invisibleSets;
	}
	
	public function getDeletedSets(){
		$dSets = array();
		$de = $this->Set->find('all', array('conditions' => array('public' => -1)));
		for($i=0; $i<count($de); $i++){
			array_push($dSets, $de[$i]['Set']['id']);
		}
		return $dSets;
	}
	
	public function startPageUpdate(){
		$this->LoadModel('User');
		$this->LoadModel('Achievement');
		$this->LoadModel('AchievementStatus');
		$str = '';
		$latest = $this->AchievementStatus->find('all', array('limit' => 6, 'order' => 'created DESC'));
		for($i=0; $i<count($latest); $i++){
			$a = $this->Achievement->findById($latest[$i]['AchievementStatus']['achievement_id']);
			$u = $this->User->findById($latest[$i]['AchievementStatus']['user_id']);
			$latest[$i]['AchievementStatus']['name'] = $a['Achievement']['name'];
			$latest[$i]['AchievementStatus']['color'] = $a['Achievement']['color'];
			$latest[$i]['AchievementStatus']['image'] = $a['Achievement']['image'];
			$latest[$i]['AchievementStatus']['user'] = $u['User']['name'];
			$str.='<div class="quote1"><div class="quote1a"><a href="/achievements/view/'.$a['Achievement']['id'].'"><img src="/img/'.$a['Achievement']['image'].'.png" width="40px"></a></div>';
			$str.='<div class="quote1b">Achievement gained by '.$u['User']['name'].':<br><div class=""><b>'.$a['Achievement']['name'].'</b></div></div></div>';
		}
		
		file_put_contents('mainPageAjax.txt', $str);
		//echo '<pre>'; print_r($latest); echo '</pre>';
	}
	
	public function uotd(){//routine1
		$this->LoadModel('User');
		$this->LoadModel('DayRecord');
		$this->LoadModel('TsumegoAttempt');
		$this->LoadModel('Achievement');
		$this->LoadModel('AchievementCondition');
		$today = date('Y-m-d');
		
		$ux = $this->User->find('first', array('order' => 'reuse3 DESC', 'conditions' => array(
			'NOT' => array(
				'id' => array(33)
			)
		)));
		
		$lastUotd = $this->DayRecord->find('first', array('order' => 'id DESC'));
		
		if($lastUotd['DayRecord']['user_id']==$ux['User']['id']){
			$ux2 = $this->User->find('all', array('limit' => 2, 'order' => 'reuse3 DESC', 'conditions' => array(
				'NOT' => array(
					'id' => array(33)
				)
			)));
			$ux = $ux2[1];
		}
		$recentlyUsed = array();
		$d = 1;
		while($d<=10){
			$ru = $this->DayRecord->find('first', array('conditions' =>  array('date' => date('Y-m-d', strtotime('-'.$d.' days')))));
			array_push($recentlyUsed, $ru);
			$d++; 
		}
		
		$currentQuote = 'q01';
		$newQuote = 'q01';
		$quoteChosen = false;
		while(!$quoteChosen){
			$newQuote = rand(1,45);
			
			if($newQuote<10) $newQuote='q0'.$newQuote;
			else $newQuote='q'.$newQuote;
			
			$f = false;
			for($i=0; $i<count($recentlyUsed); $i++){
				if($newQuote==$recentlyUsed[$i]['DayRecord']['quote']) $f = true;
			}
			if(!$f) $quoteChosen = true;
		}
		//$newQuote = 'q21';
		
		$currentQuote = $newQuote;
		
		$dayUserRand = 1;
		$uotdChosen = false;
		while(!$uotdChosen){
			$dayUserRand = rand(1,39);
			$f = false;
			for($i=0; $i<count($recentlyUsed); $i++){
				if($dayUserRand==$recentlyUsed[$i]['DayRecord']['userbg']) $f = true;
			}
			if(!$f) $uotdChosen = true;
		}
		//$dayUserRand = 37;
		
		$activity = $this->TsumegoAttempt->find('all', array('limit' => 40000, 'conditions' =>  array('DATE(TsumegoAttempt.created)' => date('Y-m-d', strtotime('yesterday')))));
		$visitedProblems = count($activity);
		
		//how many users today
		$usersNum = array();
		$activity = $this->User->find('all', array('limit' => 400, 'order' => 'created DESC'));
		for($i=0; $i<count($activity); $i++){
			$a = new DateTime($activity[$i]['User']['created']);
			if($a->format('Y-m-d')==$today) array_push($usersNum, $activity[$i]['User']);
		}
		
		$gemRand1 = rand(0,2);
		$gemRand2 = rand(0,2);
		$gemRand3 = rand(0,2);
		
		$arch1 = $this->Achievement->findById(111);
		if($gemRand1==0)
			$arch1['Achievement']['description'] = 'Has a chance to trigger once a day on an easy ddk problem.';
		else if($gemRand1==1)
			$arch1['Achievement']['description'] = 'Has a chance to trigger once a day on a regular ddk problem.';
		else if($gemRand1==2)
			$arch1['Achievement']['description'] = 'Has a chance to trigger once a day on a difficult ddk problem.';
		$this->Achievement->save($arch1);
		$arch2 = $this->Achievement->findById(112);
		if($gemRand2==0)
			$arch2['Achievement']['description'] = 'Has a chance to trigger once a day on an easy sdk problem.';
		else if($gemRand2==1)
			$arch2['Achievement']['description'] = 'Has a chance to trigger once a day on a regular sdk problem.';
		else if($gemRand2==2)
			$arch2['Achievement']['description'] = 'Has a chance to trigger once a day on a difficult sdk problem.';
		$this->Achievement->save($arch2);
		$arch3 = $this->Achievement->findById(113);
		if($gemRand3==0)
			$arch3['Achievement']['description'] = 'Has a chance to trigger once a day on an easy dan problem.';
		else if($gemRand3==1)
			$arch3['Achievement']['description'] = 'Has a chance to trigger once a day on a regular dan problem.';
		else if($gemRand3==2)
			$arch3['Achievement']['description'] = 'Has a chance to trigger once a day on a difficult dan problem.';
		$this->Achievement->save($arch3);
		
		$this->DayRecord->create();
		$dateUser = array();
		$dateUser['DayRecord']['user_id'] = $ux['User']['id'];
		$dateUser['DayRecord']['date'] = $today;
		$dateUser['DayRecord']['solved'] = $ux['User']['reuse3'];
		$dateUser['DayRecord']['quote'] = $currentQuote;
		$dateUser['DayRecord']['userbg'] = $dayUserRand;
		$dateUser['DayRecord']['tsumego'] = $this->getTsumegoOfTheDay();
		$dateUser['DayRecord']['newTsumego'] = $this->getNewTsumego();
		$dateUser['DayRecord']['usercount'] = count($usersNum);
		$dateUser['DayRecord']['visitedproblems'] = $visitedProblems;
		$dateUser['DayRecord']['gems'] = $gemRand1.'-'.$gemRand2.'-'.$gemRand3;
		$dateUser['DayRecord']['gemCounter1'] = 0;
		$dateUser['DayRecord']['gemCounter2'] = 0;
		$dateUser['DayRecord']['gemCounter3'] = 0;
		$this->DayRecord->save($dateUser);
		
		$this->AchievementCondition->create();
		$achievementCondition = array();
		$achievementCondition['AchievementCondition']['user_id'] = $ux['User']['id'];
		$achievementCondition['AchievementCondition']['set_id'] = 0;
		$achievementCondition['AchievementCondition']['category'] = 'uotd';
		$achievementCondition['AchievementCondition']['value'] = 1;
		$this->AchievementCondition->save($achievementCondition);
		
		//delete duplicated DayRecords
		$dr = $this->DayRecord->find('all');
		$duplicates = array();
		for($i=0; $i<count($dr); $i++){
			$alreadyFound = array();
			for($j=0; $j<count($dr); $j++){
				if($i!=$j && $dr[$j]['DayRecord']['date']==$dr[$i]['DayRecord']['date']){
					$found = false;
					for($k=0; $k<count($alreadyFound); $k++){
						if($alreadyFound[$k]['DayRecord']['id']==$dr[$i]['DayRecord']['id'] || $alreadyFound[$k]['DayRecord']['id']==$dr[$j]['DayRecord']['id']) $found = true;
					}
					if(!$found){
						array_push($duplicates, $dr[$i]['DayRecord']['date']);
						array_push($alreadyFound, $dr[$i]);
					}
				}	
			}
		}
		$duplicates = array_count_values($duplicates);
		foreach($duplicates as $key => $value){
			while($duplicates[$key]>1){
				$drd = $this->DayRecord->find('first', array('conditions' => array('date' => $key)));
				$this->DayRecord->delete($drd['DayRecord']['id']);
				$duplicates[$key]--;
			}
		}
	}
	
	public function findTsumegoSet($id){
		$this->LoadModel('Tsumego');
		$this->LoadModel('SetConnection');
		$scIds = array();
		$sc = $this->SetConnection->find('all', array('order' => 'num', 'direction' => 'ASC', 'conditions' => array('set_id' => $id)));
		for($i=0; $i<count($sc); $i++)
			array_push($scIds, $sc[$i]['SetConnection']['tsumego_id']);
		$ts = $this->Tsumego->find('all', array('conditions' => array('id' => $scIds)));
		for($i=0; $i<count($ts); $i++){
			$ts[$i]['Tsumego']['set_id'] = $id;
		}
		return $ts;
	}
	
	public function userRefresh($range = null){
		$this->LoadModel('User');
		$this->LoadModel('TsumegoStatus');
		if($range==1){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id <' => 2000
			)));
		}elseif($range==2){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 2000,
				'id <' => 4000
			)));
		}elseif($range==3){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 4000,
				'id <' => 6000
			)));
		}elseif($range==4){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 6000,
				'id <' => 8000
			)));
		}elseif($range==5){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 8000,
				'id <' => 10000
			)));
		}elseif($range==6){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 10000,
				'id <' => 12000
			)));
		}elseif($range==7){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 12000,
				'id <' => 14000
			)));
		}elseif($range==8){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 14000,
				'id <' => 16000
			)));
		}elseif($range==9){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 16000,
				'id <' => 18000
			)));
		}elseif($range==10){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 18000,
				'id <' => 20000
			)));
		}elseif($range==11){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 20000,
				'id <' => 22000
			)));
		}elseif($range==12){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 22000
			)));
		}
		for($i=0; $i<count($u); $i++){
			$this->User->create();
			$u[$i]['User']['reuse2'] = 0;//#
			$u[$i]['User']['reuse3'] = 0;//xp
			$u[$i]['User']['reuse4'] = 0;//daily maximum
			$u[$i]['User']['damage'] = 0;
			$u[$i]['User']['sprint'] = 1;
			$u[$i]['User']['intuition'] = 1;
			$u[$i]['User']['rejuvenation'] = 1;
			$u[$i]['User']['refinement'] = 1;
			$u[$i]['User']['usedSprint'] = 0;
			$u[$i]['User']['usedRejuvenation'] = 0;
			$u[$i]['User']['usedRefinement'] = 0;
			$u[$i]['User']['readingTrial'] = 30;
			$u[$i]['User']['potion'] = 0;
			$u[$i]['User']['promoted'] += 1;
			$u[$i]['User']['lastRefresh'] = date('Y-m-d');
			$this->User->save($u[$i]);
		}
		$uts = $this->TsumegoStatus->find('all', array('conditions' =>  array('status' => 'F')));
		for($i=0; $i<count($uts); $i++){
			$uts[$i]['TsumegoStatus']['status'] = 'V';
			$this->TsumegoStatus->save($uts[$i]);
		}
		$uts = $this->TsumegoStatus->find('all', array('conditions' =>  array('status' => 'X')));
		for($i=0; $i<count($uts); $i++){
			$uts[$i]['TsumegoStatus']['status'] = 'W';
			$this->TsumegoStatus->save($uts[$i]);
		}
	}
	
	public function deleteUserBoards(){
		$this->LoadModel('UserBoard');
		$this->UserBoard->deleteAll(array('1 = 1'));
	}
	
	public function halfXP(){
		$this->LoadModel('TsumegoStatus');
		$this->LoadModel('DayRecord');
		$week = $this->TsumegoStatus->find('all', array('order' => 'created DESC', 'conditions' => array('status' => 'S')));
		$oneWeek = date('Y-m-d H:i:s', strtotime("-7 days"));
		for($i=0; $i<count($week); $i++){
			if($week[$i]['TsumegoStatus']['created'] < $oneWeek){
				if($week[$i]['TsumegoStatus']['status']=='S'){
					$week[$i]['TsumegoStatus']['status'] = 'W';
					$this->TsumegoStatus->save($week[$i]);
				}
			}			
		}
	}
	
	public function getNewTsumego(){
		$this->LoadModel('Schedule');
		$date = date('Y-m-d', strtotime('today'));
		$s = $this->Schedule->find('all', array('conditions' =>  array('date' => $date)));
		for($i=0; $i<count($s); $i++){
			$id = $this->publishSingle($s[$i]['Schedule']['tsumego_id'], $s[$i]['Schedule']['set_id'], $s[$i]['Schedule']['date']);
			$s[$i]['Schedule']['tsumego_id'] = $id;
			$s[$i]['Schedule']['published'] = 1;
			$this->Schedule->save($s[$i]);
		}
		return $id;
	}
	
	public function publishSingle($t=null, $to=null, $date=null){
		$this->LoadModel('Tsumego');
		$this->LoadModel('Sgf');
		$this->LoadModel('SetConnection');
		$this->LoadModel('PublishDate');
		$ts = $this->Tsumego->findById($t);
		
		$id = $this->Tsumego->find('first', array('limit' => 1, 'order' => 'id DESC'));
		$id = $id['Tsumego']['id'];
		$id += 1;
		
		$scT = $this->SetConnection->find('first', array('conditions' => array('tsumego_id' => $ts['Tsumego']['id'])));
		if($scT!=null){
			$scT['SetConnection']['set_id'] = $to;
			$scT['SetConnection']['tsumego_id'] = $id;
			$scT['SetConnection']['num'] = $ts['Tsumego']['num'];
			$this->SetConnection->save($scT);
		}else{
			$scT = array();
			$scT['SetConnection']['set_id'] = $to;
			$scT['SetConnection']['tsumego_id'] = $id;
			$scT['SetConnection']['num'] = $ts['Tsumego']['num'];
			$this->SetConnection->create();
			$this->SetConnection->save($scT);
		}
		
		$sid = $ts['Tsumego']['id'];
		$ts['Tsumego']['id'] = $id;
		//$ts['Tsumego']['set_id'] = $to;
		$ts['Tsumego']['created'] = $date.' 22:00:00';
		$ts['Tsumego']['solved'] = 0;
		$ts['Tsumego']['failed'] = 0;
		$ts['Tsumego']['userWin'] = 0;
		$ts['Tsumego']['userLoss'] = 0;
		$this->Tsumego->create();
		$this->Tsumego->save($ts);
		$this->Tsumego->delete($sid);
		
		$sgfs = $this->Sgf->find('all', array('conditions' => array('tsumego_id' => $t)));
		for($i=0; $i<count($sgfs); $i++){
			$sgfs[$i]['Sgf']['tsumego_id'] = $id;
			$this->Sgf->save($sgfs[$i]);
		}
		
		$x = array();
		$x['PublishDate']['date'] = $date.' 22:00:00';
		$x['PublishDate']['tsumego_id'] = $id;
		$this->PublishDate->create();
		$this->PublishDate->save($x);
		
		return $id;
	}
	
	public function getTsumegoOfTheDay(){
		$this->loadModel('TsumegoAttempt');
		$this->loadModel('TsumegoRatingAttempt');
		$this->loadModel('Schedule');
		$this->loadModel('Tsumego');
		$this->loadModel('SetConnection');
		
		$ut = $this->TsumegoRatingAttempt->find('all', array('limit' => 10000, 'order' => 'created DESC', 'conditions' => array('status' => 'S')));
		$out = $this->TsumegoAttempt->find('all', array('limit' => 30000, 'order' => 'created DESC', 'conditions' => array('gain >=' => 40)));
		
		$date = date('Y-m-d', strtotime('yesterday'));
		$s = $this->Schedule->find('all', array('conditions' =>  array('date' => $date)));
		$ids = array();
		for($i=0; $i<count($ut); $i++){
			$date2 = new DateTime($ut[$i]['TsumegoRatingAttempt']['created']);
			$date2 = $date2->format('Y-m-d');
			if($date===$date2){
				array_push($ids, $ut[$i]['TsumegoRatingAttempt']['tsumego_id']);
			}
		}
		$ids = array_count_values($ids);
		$highest = 0;
		$best = array();
		foreach ($ids as $key => $value){
			if($value>$highest) $highest=$value;
		}
		foreach ($ids as $key => $value){
			if($value==$highest){
				$x = array();
				$x[$key] = $value;
				array_push($best, $x);
			}
		}
		$ids2 = array();
		$out2 = array();
		for($i=0; $i<count($out); $i++){
			$date2 = new DateTime($out[$i]['TsumegoAttempt']['created']);
			$date2 = $date2->format('Y-m-d');
			if($date===$date2){
				array_push($ids2, $out[$i]['TsumegoAttempt']['tsumego_id']);
				array_push($out2, $out[$i]);
			}
		}
		$ids2 = array_count_values($ids2);
		$highest = 0;
		$best2 = array();
		foreach ($ids2 as $key => $value){
			if($value>$highest) $highest=$value;
		}
		$done = false;
		$found = 0;
		$decrement = 0;
		$best3 = array();
		$findNum = 20;
		while(!$done){
			foreach ($ids2 as $key => $value){
				if($value==$highest-$decrement){
					array_push($best2, $key);
					array_push($best3, $value);
					$found++;
				}
			}
			$decrement++;
			if($found<$findNum) $done = false;
			else $done = true;
		}
		$newBest = array();
		for($j=0; $j<$findNum; $j++) $newBest[$j] = array();
		for($i=0; $i<count($out2); $i++){
			for($j=0; $j<$findNum; $j++){
				if($out2[$i]['TsumegoAttempt']['tsumego_id']==$best2[$j]){
					$x = array();
					$x['tid'] = $out2[$i]['TsumegoAttempt']['tsumego_id'];
					$tx = $this->Tsumego->findById($x['tid']);
					$scT = $this->SetConnection->find('first', array('conditions' => array('tsumego_id' => $tx['Tsumego']['id'])));
					$tx['Tsumego']['set_id'] = $scT['SetConnection']['set_id'];
					$x['sid'] = $tx['Tsumego']['set_id'];
					$x['status'] = $out2[$i]['TsumegoAttempt']['solved'];
					$x['seconds'] = $out2[$i]['TsumegoAttempt']['seconds'];

					array_push($newBest[$j], $x);
				}
			}
		}
		for($i=0; $i<count($newBest); $i++){
			$sum = 0;
			for($j=0; $j<count($newBest[$j]); $j++){
				if($newBest[$i][$j]['seconds']!=null){
					if($newBest[$i][$j]['seconds']>300){
						$newBest[$i][$j]['seconds'] = 300;
					}
					$sum += $newBest[$i][$j]['seconds'];
				}
			}
			$sum = $sum * count($newBest[$i]);
			$newBest[$i]['sum'] = $sum;
		}
		$highest = 0;
		$hid = 0;
		for($i=0; $i<count($newBest); $i++){
			if($newBest[$i]['sum']>$highest && $newBest[$i][0]['sid']!=104 && $newBest[$i][0]['sid']!=105 && $newBest[$i][0]['sid']!=117){
				$yesterday = false;
				for($j=0; $j<count($s); $j++){
					if($newBest[$i][0]['tid']==$s[$j]['Schedule']['tsumego_id']) $yesterday = true;
				}
				if(!$yesterday){
					$highest = $newBest[$i]['sum'];
					$hid = $i;
				}
			}
		}
		
		return $newBest[$hid][0]['tid'];
	}
	
	public function ratingMatch($elo){
		if($elo>=3000) $td = 10;//10d
		elseif($elo>=2900) $td = 10;//9d
		elseif($elo>=2800) $td = 10;//8d 
		elseif($elo>=2700) $td = 10;//7d x2700
		elseif($elo>=2600) $td = 9;//6d x2600
		elseif($elo>=2500) $td = 8;//5d x2500
		elseif($elo>=2400) $td = 7;//4d 
		elseif($elo>=2300) $td = 7;//3d x2350
		elseif($elo>=2200) $td = 6;//2d 
		elseif($elo>=2100) $td = 6;//1d x2150
		elseif($elo>=2000) $td = 5;//1k 
		elseif($elo>=1900) $td = 5;//2k x1950
		elseif($elo>=1800) $td = 4;//3k 
		elseif($elo>=1700) $td = 4;//4k x1750
		elseif($elo>=1600) $td = 3;//5k
		elseif($elo>=1500) $td = 3;//6k x1500
		elseif($elo>=1400) $td = 3;//7k 
		elseif($elo>=1300) $td = 2;//8k
		elseif($elo>=1200) $td = 2;//9k x1200
		elseif($elo>=1100) $td = 2;//10k
		elseif($elo>=1000) $td = 1;//11k
		elseif($elo>=900) $td = 1;//12k x900
		elseif($elo>=800) $td = 1;//13k
		elseif($elo>=700) $td = 1;//14k
		elseif($elo>=600) $td = 1;//15k
		elseif($elo>=500) $td = 1;//16k
		elseif($elo>=400) $td = 1;//17k
		elseif($elo>=300) $td = 1;//18k
		elseif($elo>=200) $td = 1;//19k
		elseif($elo>=100) $td = 1;//20k
		else $td = 1;
		return $td;
	}
	
	public function rating2($d){
		if($d==10) $elo = 2700;
		elseif($d==9) $elo = 2600;
		elseif($d==8) $elo = 2500;
		elseif($d==7) $elo = 2350;
		elseif($d==6) $elo = 2150;
		elseif($d==5) $elo = 1950;
		elseif($d==4) $elo = 1750;
		elseif($d==3) $elo = 1500;
		elseif($d==2) $elo = 1200;
		elseif($d==1) $elo = 900;
		else $elo = 1500;
		return $elo;
	}
	
	public function encrypt($str=null){
		$secret_key = 'my_simple_secret_keyx';
		$secret_iv = 'my_simple_secret_ivx';
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
		return base64_encode(openssl_encrypt($str, $encrypt_method, $key, 0, $iv));
	}
	
	public function decrypt($str=null){
		$string = $str;
		$secret_key = 'my_simple_secret_keyx';
		$secret_iv = 'my_simple_secret_ivx';
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16);
		return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}
	
	public function getTsumegoRank($t){
		if($t<=0) return '15k';
		if($t>0 && $t<=22) $tRank='5d';
		elseif($t<=26.5) $tRank='4d';
		elseif($t<=30) $tRank='3d';
		elseif($t<=34) $tRank='2d';
		elseif($t<=38) $tRank='1d';
		elseif($t<=42) $tRank='1k';
		elseif($t<=46) $tRank='2k';
		elseif($t<=50) $tRank='3k';
		elseif($t<=54.5) $tRank='4k';
		elseif($t<=58.5) $tRank='5k';
		elseif($t<=63) $tRank='6k';
		elseif($t<=67) $tRank='7k';
		elseif($t<=70.8) $tRank='8k';
		elseif($t<=74.8) $tRank='9k';
		elseif($t<=79) $tRank='10k';
		elseif($t<=83.5) $tRank='11k';
		elseif($t<=88) $tRank='12k';
		elseif($t<=92) $tRank='13k';
		elseif($t<=96) $tRank='14k';
		else $tRank='15k';
		return $tRank;
	}
	
	public function saveDanSolveCondition($solvedTsumegoRank, $tId){
		$this->loadModel('AchievementCondition');
		if($solvedTsumegoRank=='1d'||$solvedTsumegoRank=='2d'||$solvedTsumegoRank=='3d'||$solvedTsumegoRank=='4d'||$solvedTsumegoRank=='5d'){
			$danSolveCategory = 'danSolve'.$solvedTsumegoRank;
			$danSolveCondition = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => $danSolveCategory
			)));
			if($danSolveCondition==null){
				$danSolveCondition = array();
				$danSolveCondition['AchievementCondition']['value'] = 0;
				$this->AchievementCondition->create();
			}
			$danSolveCondition['AchievementCondition']['category'] = $danSolveCategory;
			$danSolveCondition['AchievementCondition']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$danSolveCondition['AchievementCondition']['set_id'] = $tId;
			$danSolveCondition['AchievementCondition']['value']++;
			
			$this->AchievementCondition->save($danSolveCondition);
			
		}
	}
	
	public function updateSprintCondition($trigger){
		if(isset($_SESSION['loggedInUser']['User']['id'])){
			$sprintCondition = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'sprint'
			)));
			if($sprintCondition==null){
				$sprintCondition = array();
				$sprintCondition['AchievementCondition']['value'] = 0;
				$this->AchievementCondition->create();
			}
			$sprintCondition['AchievementCondition']['category'] = 'sprint';
			$sprintCondition['AchievementCondition']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			if($trigger)
				$sprintCondition['AchievementCondition']['value']++;
			else
				$sprintCondition['AchievementCondition']['value'] = 0;
			$this->AchievementCondition->save($sprintCondition);
		}
	}
	
	public function updateGoldenCondition($trigger){
		$goldenCondition = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
			'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'golden'
		)));
		if($goldenCondition==null){
			$goldenCondition = array();
			$goldenCondition['AchievementCondition']['value'] = 0;
			$this->AchievementCondition->create();
		}
		$goldenCondition['AchievementCondition']['category'] = 'golden';
		$goldenCondition['AchievementCondition']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
		if($trigger)
			$goldenCondition['AchievementCondition']['value']++;
		else
			$goldenCondition['AchievementCondition']['value'] = 0;
		$this->AchievementCondition->save($goldenCondition);
	}
	
	public function setPotionCondition(){
		$potionCondition = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
			'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'potion'
		)));
		if($potionCondition==null){
			$potionCondition = array();
			$this->AchievementCondition->create();
		}
		$potionCondition['AchievementCondition']['category'] = 'potion';
		$potionCondition['AchievementCondition']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
		$potionCondition['AchievementCondition']['value'] = 1;
		$this->AchievementCondition->save($potionCondition);
	}
	
	public function updateGems($r){
		$this->loadModel('DayRecord');
		$this->loadModel('AchievementCondition');
		$datex = new DateTime('today');
		//$datex->modify('-1 day');
		$dateGem = $this->DayRecord->find('first', array('conditions' => array('date' => $datex->format('Y-m-d'))));
		if($dateGem!=null){
			$gems = explode('-', $dateGem['DayRecord']['gems']);
			$gemValue = '';
			$gemValue2 = '';
			$gemValue3 = '';
			$condition1 = 500;
			$condition2 = 200;
			$condition3 = 50;
			$found1 = false;
			$found2 = false;
			$found3 = false;
			if($r=='15k'||$r=='14k'||$r=='13k'||$r=='12k'||$r=='11k'||$r=='10k'){
				if($gems[0]==0)
					$gemValue = '15k';
				else if($gems[0]==1)
					$gemValue = '12k';
				else if($gems[0]==2)
					$gemValue = '10k';
				if($r==$gemValue){
					$dateGem['DayRecord']['gemCounter1']++;
					if($dateGem['DayRecord']['gemCounter1']==$condition1)
						$found1 = true;
				}
			}else if($r=='9k'||$r=='8k'||$r=='7k'||$r=='6k'||$r=='5k'||$r=='4k'||$r=='3k'||$r=='2k'||$r=='1k'){
				if($gems[1]==0){
					$gemValue = '9k';
					$gemValue2 = 'x';
					$gemValue3 = 'y';
				}else if($gems[1]==1){
					$gemValue = '6k';
					$gemValue2 = '5k';
					$gemValue3 = '4k';
				}else if($gems[1]==2){
					$gemValue = 'x';
					$gemValue2 = '2k';
					$gemValue3 = '1k';
				}
				if($r==$gemValue || $r==$gemValue2 || $r==$gemValue3){
					$dateGem['DayRecord']['gemCounter2']++;
					if($dateGem['DayRecord']['gemCounter2']==$condition2)
						$found2= true;
				}
			}else if($r=='1d'||$r=='2d'||$r=='3d'||$r=='4d'||$r=='5d'){
				if($gems[2]==0){
					$gemValue = '1d';
					$gemValue2 = 'x';
					$gemValue3 = 'y';
				}else if($gems[2]==1){
					$gemValue = '2d';
					$gemValue2 = '3d';
					$gemValue3 = '4d';
				}else if($gems[2]==2){
					$gemValue = '5d';
					$gemValue2 = 'x';
					$gemValue3 = 'y';
				}
				if($r==$gemValue || $r==$gemValue2 || $r==$gemValue3){
					$dateGem['DayRecord']['gemCounter3']++;
					if($dateGem['DayRecord']['gemCounter3']==$condition3)
						$found3 = true;
				}
			}
			if($found1){
				$aCondition = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
					'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'emerald'
				)));
				if($aCondition==null){
					$aCondition = array();
					$aCondition['AchievementCondition']['category'] = 'emerald';
					$aCondition['AchievementCondition']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$aCondition['AchievementCondition']['value'] = 1;
					$this->AchievementCondition->save($aCondition);
				}else{
					$dateGem['DayRecord']['gemCounter1']--;
				}
			}else if($found2){
				$aCondition = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
					'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'sapphire'
				)));
				if($aCondition==null){
					$aCondition = array();
					$aCondition['AchievementCondition']['category'] = 'sapphire';
					$aCondition['AchievementCondition']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$aCondition['AchievementCondition']['value'] = 1;
					$this->AchievementCondition->save($aCondition);
				}else{
					$dateGem['DayRecord']['gemCounter2']--;
				}
			}else if($found3){
				$aCondition = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
					'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'ruby'
				)));
				if($aCondition==null){
					$aCondition = array();
					$aCondition['AchievementCondition']['category'] = 'ruby';
					$aCondition['AchievementCondition']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$aCondition['AchievementCondition']['value'] = 1;
					$this->AchievementCondition->save($aCondition);
				}else{
					$dateGem['DayRecord']['gemCounter3']--;
				}
			}
		}
		$this->DayRecord->save($dateGem);
	}
	
	public function checkDanSolveAchievements(){
	if(isset($_SESSION['loggedInUser']['User']['id'])){
		$this->loadModel('Achievement');
		$this->loadModel('AchievementStatus');
		$this->loadModel('AchievementCondition');
		$buffer = $this->AchievementStatus->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
		$ac = $this->AchievementCondition->find('all', array('order' => 'category ASC', 'conditions' => array(
			'user_id' => $_SESSION['loggedInUser']['User']['id'],
			'OR' => array(
				array('category' => 'danSolve1d'),
				array('category' => 'danSolve2d'),
				array('category' => 'danSolve3d'),
				array('category' => 'danSolve4d'),
				array('category' => 'danSolve5d'),
				array('category' => 'emerald'),
				array('category' => 'sapphire'),
				array('category' => 'ruby'),
				array('category' => 'sprint'),
				array('category' => 'golden'),
				array('category' => 'potion')
			)
		)));
		for($i=0;$i<count($ac);$i++){
			if($ac[$i]['AchievementCondition']['category']=='danSolve1d')
				$ac1['1d'] = $ac[$i]['AchievementCondition']['value'];
			else if($ac[$i]['AchievementCondition']['category']=='danSolve2d')
				$ac1['2d'] = $ac[$i]['AchievementCondition']['value'];
			else if($ac[$i]['AchievementCondition']['category']=='danSolve3d')
				$ac1['3d'] = $ac[$i]['AchievementCondition']['value'];
			else if($ac[$i]['AchievementCondition']['category']=='danSolve4d')
				$ac1['4d'] = $ac[$i]['AchievementCondition']['value'];
			else if($ac[$i]['AchievementCondition']['category']=='danSolve5d')
				$ac1['5d'] = $ac[$i]['AchievementCondition']['value'];
			else if($ac[$i]['AchievementCondition']['category']=='emerald')
				$ac1['emerald'] = $ac[$i]['AchievementCondition']['value'];
			else if($ac[$i]['AchievementCondition']['category']=='sapphire')
				$ac1['sapphire'] = $ac[$i]['AchievementCondition']['value'];
			else if($ac[$i]['AchievementCondition']['category']=='ruby')
				$ac1['ruby'] = $ac[$i]['AchievementCondition']['value'];
			else if($ac[$i]['AchievementCondition']['category']=='sprint')
				$ac1['sprint'] = $ac[$i]['AchievementCondition']['value'];
			else if($ac[$i]['AchievementCondition']['category']=='golden')
				$ac1['golden'] = $ac[$i]['AchievementCondition']['value'];
			else if($ac[$i]['AchievementCondition']['category']=='potion')
				$ac1['potion'] = $ac[$i]['AchievementCondition']['value'];
		}
		
		$existingAs = array();
		for($i=0; $i<count($buffer); $i++)
			$existingAs[$buffer[$i]['AchievementStatus']['achievement_id']] = $buffer[$i];
		$as = array();
		$as['AchievementStatus']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
		$updated = array();
		$achievementId = 101;
		if($ac1['1d']>0 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 102;
		if($ac1['2d']>0 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 103;
		if($ac1['3d']>0 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 104;
		if($ac1['4d']>0 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 105;
		if($ac1['5d']>0 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 106;
		if($ac1['1d']>=10 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 107;
		if($ac1['2d']>=10 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 108;
		if($ac1['3d']>=10 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 109;
		if($ac1['4d']>=10 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 110;
		if($ac1['5d']>=10 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 111;
		if(isset($ac1['emerald'])){
			if($ac1['emerald']==1 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
		}
		$achievementId = 112;
		if(isset($ac1['sapphire'])){
			if($ac1['sapphire']==1 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
		}
		$achievementId = 113;
		if(isset($ac1['ruby'])){
			if($ac1['ruby']==1 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
		}
		$achievementId = 114;
		if(!isset($existingAs[$achievementId]) && isset($existingAs[111]) && isset($existingAs[112]) && isset($existingAs[113])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 96;
		if(!isset($existingAs[$achievementId]) && $ac1['sprint']>=30){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 97;
		if(!isset($existingAs[$achievementId]) && $ac1['golden']>=10){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 98;
		if(!isset($existingAs[$achievementId]) && $ac1['potion']>=1){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		for($i=0; $i<count($updated); $i++){
			$a = $this->Achievement->findById($updated[$i]);
			$updated[$i] = array();
			$updated[$i][0] = $a['Achievement']['name'];
			$updated[$i][1] = $a['Achievement']['description'];
			$updated[$i][2] = $a['Achievement']['image'];
			$updated[$i][3] = $a['Achievement']['color'];
			$updated[$i][4] = $a['Achievement']['xp'];
			$updated[$i][5] = $a['Achievement']['id'];
		}
		return $updated;
	}
	}
	
	public function checkProblemNumberAchievements(){
		if(isset($_SESSION['loggedInUser']['User']['id'])){
			$this->loadModel('Achievement');
			$this->loadModel('AchievementStatus');
			$this->loadModel('AchievementCondition');
			$buffer = $this->AchievementStatus->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			$existingAs = array();
			for($i=0; $i<count($buffer); $i++)
				$existingAs[$buffer[$i]['AchievementStatus']['achievement_id']] = $buffer[$i];
			$as = array();
			$as['AchievementStatus']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$updated = array();
			
			$achievementId = 1;
			if($_SESSION['loggedInUser']['User']['solved']>=1000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 2;
			if($_SESSION['loggedInUser']['User']['solved']>=2000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 3;
			if($_SESSION['loggedInUser']['User']['solved']>=3000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 4;
			if($_SESSION['loggedInUser']['User']['solved']>=4000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 5;
			if($_SESSION['loggedInUser']['User']['solved']>=5000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 6;
			if($_SESSION['loggedInUser']['User']['solved']>=6000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 7;
			if($_SESSION['loggedInUser']['User']['solved']>=7000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 8;
			if($_SESSION['loggedInUser']['User']['solved']>=8000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 9;
			if($_SESSION['loggedInUser']['User']['solved']>=9000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 10;
			if($_SESSION['loggedInUser']['User']['solved']>=10000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			//uotd achievement
			$achievementId = 11;
			if(!isset($existingAs[$achievementId])){
				$condition = $this->AchievementCondition->find('first', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'uotd')));
				if($condition!=null){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
			}
			
			for($i=0; $i<count($updated); $i++){
				$a = $this->Achievement->findById($updated[$i]);
				$updated[$i] = array();
				$updated[$i][0] = $a['Achievement']['name'];
				$updated[$i][1] = $a['Achievement']['description'];
				$updated[$i][2] = $a['Achievement']['image'];
				$updated[$i][3] = $a['Achievement']['color'];
				$updated[$i][4] = $a['Achievement']['xp'];
				$updated[$i][5] = $a['Achievement']['id'];
			}
			return $updated;
		}
	}
	
	public function checkNoErrorAchievements(){
		if(isset($_SESSION['loggedInUser']['User']['id'])){
			$this->loadModel('Set');
			$this->loadModel('Tsumego');
			$this->loadModel('Achievement');
			$this->loadModel('AchievementStatus');
			$this->loadModel('AchievementCondition');
			
			$ac = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'err'
			)));
			
			$buffer = $this->AchievementStatus->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			$existingAs = array();
			for($i=0; $i<count($buffer); $i++)
				$existingAs[$buffer[$i]['AchievementStatus']['achievement_id']] = $buffer[$i];
			$as = array();
			$as['AchievementStatus']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$updated = array();
			
			$achievementId = 53;
			if($ac['AchievementCondition']['value']>=10 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 54;
			if($ac['AchievementCondition']['value']>=20 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 55;
			if($ac['AchievementCondition']['value']>=30 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 56;
			if($ac['AchievementCondition']['value']>=50 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 57;
			if($ac['AchievementCondition']['value']>=100 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 58;
			if($ac['AchievementCondition']['value']>=200 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			for($i=0; $i<count($updated); $i++){
				$a = $this->Achievement->findById($updated[$i]);
				$updated[$i] = array();
				$updated[$i][0] = $a['Achievement']['name'];
				$updated[$i][1] = $a['Achievement']['description'];
				$updated[$i][2] = $a['Achievement']['image'];
				$updated[$i][3] = $a['Achievement']['color'];
				$updated[$i][4] = $a['Achievement']['xp'];
				$updated[$i][5] = $a['Achievement']['id'];
			}
			return $updated;
		}
	}
	
	public function checkTimeModeAchievements(){
		$this->loadModel('Achievement');
		$this->loadModel('AchievementStatus');
		$this->loadModel('RankOverview');
		
		$buffer = $this->AchievementStatus->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
		$existingAs = array();
		for($i=0; $i<count($buffer); $i++)
			$existingAs[$buffer[$i]['AchievementStatus']['achievement_id']] = $buffer[$i];
		$as = array();
		$as['AchievementStatus']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
		$updated = array();
		
		$rBlitz = $this->RankOverview->find('all', array('conditions' =>  array('mode' => 0, 'user_id' => $_SESSION['loggedInUser']['User']['id'])));//blitz
		$rFast = $this->RankOverview->find('all', array('conditions' =>  array('mode' => 1, 'user_id' => $_SESSION['loggedInUser']['User']['id'])));//fast
		$rSlow = $this->RankOverview->find('all', array('conditions' =>  array('mode' => 2, 'user_id' => $_SESSION['loggedInUser']['User']['id'])));//slow
		$r = $this->RankOverview->find('all', array('conditions' =>  array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
		
		$timeModeAchievements = array();
		for($i=70;$i<=91;$i++){
			$timeModeAchievements[$i] = false;
		}
		for($i=0;$i<count($r);$i++){
			if($r[$i]['RankOverview']['status']=='s'){
				if($r[$i]['RankOverview']['rank']=='5k'){
					if($r[$i]['RankOverview']['mode']==2) 
						$timeModeAchievements[70] = true;
					else if($r[$i]['RankOverview']['mode']==1) 
						$timeModeAchievements[76] = true;
					else if($r[$i]['RankOverview']['mode']==0) 
						$timeModeAchievements[82] = true;
				}else if($r[$i]['RankOverview']['rank']=='4k'){
					if($r[$i]['RankOverview']['mode']==2) 
						$timeModeAchievements[71] = true;
					else if($r[$i]['RankOverview']['mode']==1) 
						$timeModeAchievements[77] = true;
					else if($r[$i]['RankOverview']['mode']==0) 
						$timeModeAchievements[83] = true;
				}else if($r[$i]['RankOverview']['rank']=='3k'){
					if($r[$i]['RankOverview']['mode']==2) 
						$timeModeAchievements[72] = true;
					else if($r[$i]['RankOverview']['mode']==1) 
						$timeModeAchievements[78] = true;
					else if($r[$i]['RankOverview']['mode']==0) 
						$timeModeAchievements[84] = true;
				}else if($r[$i]['RankOverview']['rank']=='2k'){
					if($r[$i]['RankOverview']['mode']==2) 
						$timeModeAchievements[73] = true;
					else if($r[$i]['RankOverview']['mode']==1) 
						$timeModeAchievements[79] = true;
					else if($r[$i]['RankOverview']['mode']==0) 
						$timeModeAchievements[85] = true;
				}else if($r[$i]['RankOverview']['rank']=='1k'){
					if($r[$i]['RankOverview']['mode']==2) 
						$timeModeAchievements[74] = true;
					else if($r[$i]['RankOverview']['mode']==1) 
						$timeModeAchievements[80] = true;
					else if($r[$i]['RankOverview']['mode']==0) 
						$timeModeAchievements[86] = true;
				}else if($r[$i]['RankOverview']['rank']=='1d'){
					if($r[$i]['RankOverview']['mode']==2) 
						$timeModeAchievements[75] = true;
					else if($r[$i]['RankOverview']['mode']==1) 
						$timeModeAchievements[81] = true;
					else if($r[$i]['RankOverview']['mode']==0) 
						$timeModeAchievements[87] = true;
				}
			}
			if($r[$i]['RankOverview']['points']>=850 && 
			($r[$i]['RankOverview']['rank']=='4k'||$r[$i]['RankOverview']['rank']=='3k'||$r[$i]['RankOverview']['rank']=='2k'||$r[$i]['RankOverview']['rank']=='1k'
			||$r[$i]['RankOverview']['rank']=='1d'||$r[$i]['RankOverview']['rank']=='2d'||$r[$i]['RankOverview']['rank']=='3d'||$r[$i]['RankOverview']['rank']=='4d'
			||$r[$i]['RankOverview']['rank']=='5d'))
				$timeModeAchievements[91] = true;
			if($r[$i]['RankOverview']['points']>=875 && 
			($r[$i]['RankOverview']['rank']=='4k'||$r[$i]['RankOverview']['rank']=='3k'||$r[$i]['RankOverview']['rank']=='2k'||$r[$i]['RankOverview']['rank']=='1k'
			||$r[$i]['RankOverview']['rank']=='1d'||$r[$i]['RankOverview']['rank']=='2d'||$r[$i]['RankOverview']['rank']=='3d'||$r[$i]['RankOverview']['rank']=='4d'
			||$r[$i]['RankOverview']['rank']=='5d'||$r[$i]['RankOverview']['rank']=='5k'||$r[$i]['RankOverview']['rank']=='6k'))
				$timeModeAchievements[90] = true;
			if($r[$i]['RankOverview']['points']>=900 && 
			($r[$i]['RankOverview']['rank']=='4k'||$r[$i]['RankOverview']['rank']=='3k'||$r[$i]['RankOverview']['rank']=='2k'||$r[$i]['RankOverview']['rank']=='1k'
			||$r[$i]['RankOverview']['rank']=='1d'||$r[$i]['RankOverview']['rank']=='2d'||$r[$i]['RankOverview']['rank']=='3d'||$r[$i]['RankOverview']['rank']=='4d'
			||$r[$i]['RankOverview']['rank']=='5d'||$r[$i]['RankOverview']['rank']=='5k'||$r[$i]['RankOverview']['rank']=='6k'||$r[$i]['RankOverview']['rank']=='7k'
			||$r[$i]['RankOverview']['rank']=='8k'))
				$timeModeAchievements[89] = true;	
			if($r[$i]['RankOverview']['points']>=950 && 
			($r[$i]['RankOverview']['rank']=='4k'||$r[$i]['RankOverview']['rank']=='3k'||$r[$i]['RankOverview']['rank']=='2k'||$r[$i]['RankOverview']['rank']=='1k'
			||$r[$i]['RankOverview']['rank']=='1d'||$r[$i]['RankOverview']['rank']=='2d'||$r[$i]['RankOverview']['rank']=='3d'||$r[$i]['RankOverview']['rank']=='4d'
			||$r[$i]['RankOverview']['rank']=='5d'||$r[$i]['RankOverview']['rank']=='5k'||$r[$i]['RankOverview']['rank']=='6k'||$r[$i]['RankOverview']['rank']=='7k'
			||$r[$i]['RankOverview']['rank']=='8k'||$r[$i]['RankOverview']['rank']=='9k'||$r[$i]['RankOverview']['rank']=='10k'))
				$timeModeAchievements[88] = true;	
		}
		
		for($i=70;$i<=91;$i++){
			$achievementId = $i;
			if($timeModeAchievements[$achievementId]==true && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
		}
		
		for($i=0; $i<count($updated); $i++){
			$a = $this->Achievement->findById($updated[$i]);
			$updated[$i] = array();
			$updated[$i][0] = $a['Achievement']['name'];
			$updated[$i][1] = $a['Achievement']['description'];
			$updated[$i][2] = $a['Achievement']['image'];
			$updated[$i][3] = $a['Achievement']['color'];
			$updated[$i][4] = $a['Achievement']['xp'];
			$updated[$i][5] = $a['Achievement']['id'];
		}
		
		return $updated;
	}
	
	public function checkRatingAchievements(){
		if(isset($_SESSION['loggedInUser']['User']['id'])){
			$this->loadModel('User');
			$this->loadModel('Achievement');
			$this->loadModel('AchievementStatus');
			$u = $this->User->findById($_SESSION['loggedInUser']['User']['id']);
			$buffer = $this->AchievementStatus->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			$existingAs = array();
			for($i=0; $i<count($buffer); $i++)
				$existingAs[$buffer[$i]['AchievementStatus']['achievement_id']] = $buffer[$i];
			$as = array();
			$as['AchievementStatus']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$updated = array();
			
			$achievementId = 59;
			if($u['User']['elo_rating_mode']>=1500 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 60;
			if($u['User']['elo_rating_mode']>=1600 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 61;
			if($u['User']['elo_rating_mode']>=1700 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 62;
			if($u['User']['elo_rating_mode']>=1800 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 63;
			if($u['User']['elo_rating_mode']>=1900 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 64;
			if($u['User']['elo_rating_mode']>=2000 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 65;
			if($u['User']['elo_rating_mode']>=2100 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 66;
			if($u['User']['elo_rating_mode']>=2200 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 67;
			if($u['User']['elo_rating_mode']>=2300 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 68;
			if($u['User']['elo_rating_mode']>=2400 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 69;
			if($u['User']['elo_rating_mode']>=2500 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			for($i=0; $i<count($updated); $i++){
				$a = $this->Achievement->findById($updated[$i]);
				$updated[$i] = array();
				$updated[$i][0] = $a['Achievement']['name'];
				$updated[$i][1] = $a['Achievement']['description'];
				$updated[$i][2] = $a['Achievement']['image'];
				$updated[$i][3] = $a['Achievement']['color'];
				$updated[$i][4] = $a['Achievement']['xp'];
				$updated[$i][5] = $a['Achievement']['id'];
			}
			
			return $updated;
		}
	}
	
	public function checkLevelAchievements(){
		if(isset($_SESSION['loggedInUser']['User']['id'])){
			$this->loadModel('Achievement');
			$this->loadModel('AchievementStatus');
			$buffer = $this->AchievementStatus->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			$existingAs = array();
			for($i=0; $i<count($buffer); $i++)
				$existingAs[$buffer[$i]['AchievementStatus']['achievement_id']] = $buffer[$i];
			$as = array();
			$as['AchievementStatus']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$updated = array();
			
			$achievementId = 36;
			if($_SESSION['loggedInUser']['User']['level']>=10 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 37;
			if($_SESSION['loggedInUser']['User']['level']>=20 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 38;
			if($_SESSION['loggedInUser']['User']['level']>=30 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 39;
			if($_SESSION['loggedInUser']['User']['level']>=40 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 40;
			if($_SESSION['loggedInUser']['User']['level']>=50 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 41;
			if($_SESSION['loggedInUser']['User']['level']>=60 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 42;
			if($_SESSION['loggedInUser']['User']['level']>=70 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 43;
			if($_SESSION['loggedInUser']['User']['level']>=80 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 44;
			if($_SESSION['loggedInUser']['User']['level']>=90 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 45;
			if($_SESSION['loggedInUser']['User']['level']>=100 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			$achievementId = 100;
			if($_SESSION['loggedInUser']['User']['premium']>0 && !isset($existingAs[$achievementId])){
				$as['AchievementStatus']['achievement_id'] = $achievementId;
				$this->AchievementStatus->create();
				$this->AchievementStatus->save($as);
				array_push($updated, $achievementId);
			}
			for($i=0; $i<count($updated); $i++){
				$a = $this->Achievement->findById($updated[$i]);
				$updated[$i] = array();
				$updated[$i][0] = $a['Achievement']['name'];
				$updated[$i][1] = $a['Achievement']['description'];
				$updated[$i][2] = $a['Achievement']['image'];
				$updated[$i][3] = $a['Achievement']['color'];
				$updated[$i][4] = $a['Achievement']['xp'];
				$updated[$i][5] = $a['Achievement']['id'];
			}
			return $updated;
		}
	}
	
	public function checkSetCompletedAchievements(){
		$this->loadModel('Set');
		$this->loadModel('Tsumego');
		$this->loadModel('Achievement');
		$this->loadModel('AchievementStatus');
		$this->loadModel('AchievementCondition');
		
		$ac = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
			'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'set'
		)));
		
		$buffer = $this->AchievementStatus->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
		$existingAs = array();
		for($i=0; $i<count($buffer); $i++)
			$existingAs[$buffer[$i]['AchievementStatus']['achievement_id']] = $buffer[$i];
		$as = array();
		$as['AchievementStatus']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
		$updated = array();
		
		$achievementId = 47;
		if($ac['AchievementCondition']['value']>=10 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 48;
		if($ac['AchievementCondition']['value']>=20 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 49;
		if($ac['AchievementCondition']['value']>=30 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 50;
		if($ac['AchievementCondition']['value']>=40 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 51;
		if($ac['AchievementCondition']['value']>=50 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 52;
		if($ac['AchievementCondition']['value']>=60 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		for($i=0; $i<count($updated); $i++){
			$a = $this->Achievement->findById($updated[$i]);
			$updated[$i] = array();
			$updated[$i][0] = $a['Achievement']['name'];
			$updated[$i][1] = $a['Achievement']['description'];
			$updated[$i][2] = $a['Achievement']['image'];
			$updated[$i][3] = $a['Achievement']['color'];
			$updated[$i][4] = $a['Achievement']['xp'];
			$updated[$i][5] = $a['Achievement']['id'];
		}
		return $updated;
	}
	
	public function setAchievementSpecial($s=null){
		$this->loadModel('Set');
		$this->loadModel('Tsumego');
		$this->loadModel('TsumegoStatus');
		$this->loadModel('Achievement');
		$this->loadModel('AchievementStatus');
		$this->loadModel('SetConnection');
		
		$buffer = $this->AchievementStatus->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
		$existingAs = array();
		for($i=0; $i<count($buffer); $i++)
			$existingAs[$buffer[$i]['AchievementStatus']['achievement_id']] = $buffer[$i];
		$as = array();
		$as['AchievementStatus']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
		$updated = array();
		
		$tsIds = array();
		$completed = '';
		if($s=='cc1'){
			$ts1 = $this->findTsumegoSet(50);
			$ts2 = $this->findTsumegoSet(52);
			$ts3 = $this->findTsumegoSet(53);
			$ts4 = $this->findTsumegoSet(54);
			$ts = array_merge($ts1, $ts2, $ts3, $ts4);
			for($i=0; $i<count($ts); $i++) 
				array_push($tsIds, $ts[$i]['Tsumego']['id']);
			$uts = $this->TsumegoStatus->find('all', array('conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'],
				'tsumego_id' => $tsIds
			)));
			$counter = 0;
			for($j=0; $j<count($uts); $j++){
				for($k=0; $k<count($ts); $k++){
					if($uts[$j]['TsumegoStatus']['tsumego_id']==$ts[$k]['Tsumego']['id'] && ($uts[$j]['TsumegoStatus']['status']=='S' 
					|| $uts[$j]['TsumegoStatus']['status']=='W' || $uts[$j]['TsumegoStatus']['status']=='C')){
						$counter++;
					}
				}
			}
			if($counter==count($ts))
				$completed = $s;
		}else if($s=='cc2'){
			$ts1 = $this->findTsumegoSet(41);
			$ts2 = $this->findTsumegoSet(49);
			$ts3 = $this->findTsumegoSet(65);
			$ts4 = $this->findTsumegoSet(66);
			$ts = array_merge($ts1, $ts2, $ts3, $ts4);
			for($i=0; $i<count($ts); $i++) 
				array_push($tsIds, $ts[$i]['Tsumego']['id']);
			$uts = $this->TsumegoStatus->find('all', array('conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'],
				'tsumego_id' => $tsIds
			)));
			$counter = 0;
			for($j=0; $j<count($uts); $j++){
				for($k=0; $k<count($ts); $k++){
					if($uts[$j]['TsumegoStatus']['tsumego_id']==$ts[$k]['Tsumego']['id'] && ($uts[$j]['TsumegoStatus']['status']=='S' 
					|| $uts[$j]['TsumegoStatus']['status']=='W' || $uts[$j]['TsumegoStatus']['status']=='C')){
						$counter++;
					}
				}
			}
			if($counter==count($ts))
				$completed = $s;
		}else if($s=='cc3'){
			$ts1 = $this->findTsumegoSet(186);
			$ts2 = $this->findTsumegoSet(187);
			$ts3 = $this->findTsumegoSet(196);
			$ts4 = $this->findTsumegoSet(203);
			$ts = array_merge($ts1, $ts2, $ts3, $ts4);
			for($i=0; $i<count($ts); $i++) 
				array_push($tsIds, $ts[$i]['Tsumego']['id']);
			$uts = $this->TsumegoStatus->find('all', array('conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'],
				'tsumego_id' => $tsIds
			)));
			$counter = 0;
			for($j=0; $j<count($uts); $j++){
				for($k=0; $k<count($ts); $k++){
					if($uts[$j]['TsumegoStatus']['tsumego_id']==$ts[$k]['Tsumego']['id'] && ($uts[$j]['TsumegoStatus']['status']=='S' 
					|| $uts[$j]['TsumegoStatus']['status']=='W' || $uts[$j]['TsumegoStatus']['status']=='C')){
						$counter++;
					}
				}
			}
			if($counter==count($ts))
				$completed = $s;
		}else if($s=='1000w1'){
			$ts1 = $this->findTsumegoSet(190);
			$ts2 = $this->findTsumegoSet(193);
			$ts3 = $this->findTsumegoSet(198);
			$ts = array_merge($ts1, $ts2, $ts3);
			for($i=0; $i<count($ts); $i++) 
				array_push($tsIds, $ts[$i]['Tsumego']['id']);
			$uts = $this->TsumegoStatus->find('all', array('conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'],
				'tsumego_id' => $tsIds
			)));
			$counter = 0;
			for($j=0; $j<count($uts); $j++){
				for($k=0; $k<count($ts); $k++){
					if($uts[$j]['TsumegoStatus']['tsumego_id']==$ts[$k]['Tsumego']['id'] && ($uts[$j]['TsumegoStatus']['status']=='S' 
					|| $uts[$j]['TsumegoStatus']['status']=='W' || $uts[$j]['TsumegoStatus']['status']=='C')){
						$counter++;
					}
				}
			}
			if($counter==count($ts))
				$completed = $s;
		}
		
		$achievementId = 92;
		if($completed=='cc1' && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 93;
		if($completed=='cc2' && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 94;
		if($completed=='cc3' && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		$achievementId = 95;
		if($completed=='1000w1' && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		for($i=0; $i<count($updated); $i++){
			$a = $this->Achievement->findById($updated[$i]);
			$updated[$i] = array();
			$updated[$i][0] = $a['Achievement']['name'];
			$updated[$i][1] = $a['Achievement']['description'];
			$updated[$i][2] = $a['Achievement']['image'];
			$updated[$i][3] = $a['Achievement']['color'];
			$updated[$i][4] = $a['Achievement']['xp'];
			$updated[$i][5] = $a['Achievement']['id'];
		}
		return $updated;
	}
	
	public function checkSetAchievements($sid=null){
		$this->loadModel('Set');
		$this->loadModel('Tsumego');
		$this->loadModel('Achievement');
		$this->loadModel('AchievementStatus');
		$this->loadModel('AchievementCondition');
		
		//$tNum = count($this->Tsumego->find('all', array('conditions' => array('set_id' => $sid))));
		$tNum = count($this->findTsumegoSet($sid));
		$s = $this->Set->findById($sid);
		$acA = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
			'set_id' => $sid, 'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => '%'
		)));
		$acS = $this->AchievementCondition->find('first', array('order' => 'value ASC', 'conditions' => array(
			'set_id' => $sid, 'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 's'
		)));
		$buffer = $this->AchievementStatus->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
		$existingAs = array();
		for($i=0; $i<count($buffer); $i++)
			$existingAs[$buffer[$i]['AchievementStatus']['achievement_id']] = $buffer[$i];
		$as = array();
		$as['AchievementStatus']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
		$updated = array();
		
		$achievementId = 99;
		if($sid==-1 && !isset($existingAs[$achievementId])){
			$as['AchievementStatus']['achievement_id'] = $achievementId;
			$this->AchievementStatus->create();
			$this->AchievementStatus->save($as);
			array_push($updated, $achievementId);
		}
		if($tNum>=100){
			if($s['Set']['difficulty']<=2){
				$achievementId = 12;
				if($acA['AchievementCondition']['value']>=75 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 13;
				if($acA['AchievementCondition']['value']>=85 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 14;
				if($acA['AchievementCondition']['value']>=95 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 24;
				if($acS['AchievementCondition']['value']<15 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 25;
				if($acS['AchievementCondition']['value']<10 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 26;
				if($acS['AchievementCondition']['value']<5 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
			}else if($s['Set']['difficulty']==3){
				$achievementId = 15;
				if($acA['AchievementCondition']['value']>=75 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 16;
				if($acA['AchievementCondition']['value']>=85 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 17;
				if($acA['AchievementCondition']['value']>=95 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 27;
				if($acS['AchievementCondition']['value']<18 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 28;
				if($acS['AchievementCondition']['value']<13 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 29;
				if($acS['AchievementCondition']['value']<8 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
			}else if($s['Set']['difficulty']==4){
				$achievementId = 18;
				if($acA['AchievementCondition']['value']>=75 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 19;
				if($acA['AchievementCondition']['value']>=85 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 20;
				if($acA['AchievementCondition']['value']>=95 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 30;
				if($acS['AchievementCondition']['value']<30 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 31;
				if($acS['AchievementCondition']['value']<20 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 32;
				if($acS['AchievementCondition']['value']<10 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
			}else{
				$achievementId = 21;
				if($acA['AchievementCondition']['value']>=75 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 22;
				if($acA['AchievementCondition']['value']>=85 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 23;
				if($acA['AchievementCondition']['value']>=95 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 33;
				if($acS['AchievementCondition']['value']<30 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 34;
				if($acS['AchievementCondition']['value']<20 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
				$achievementId = 35;
				if($acS['AchievementCondition']['value']<10 && !isset($existingAs[$achievementId])){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}
			}
			$achievementId = 46;
			if($acA['AchievementCondition']['value']>=100){
				$ac100 = $this->AchievementCondition->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => '%', 'value >=' => 100)));
				$ac100counter = 0;
				for($j=0; $j<count($ac100); $j++)
					if(count($this->findTsumegoSet($ac100[$j]['AchievementCondition']['set_id']))>=100)
						$ac100counter++;
				$as100 = $this->AchievementStatus->find('first', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'], 'achievement_id' => $achievementId)));
				if($as100==null){
					$as['AchievementStatus']['achievement_id'] = $achievementId;
					$as['AchievementStatus']['value'] = 1;
					$this->AchievementStatus->create();
					$this->AchievementStatus->save($as);
					array_push($updated, $achievementId);
				}else if($as100['AchievementStatus']['value']!=$ac100counter){
					$as100['AchievementStatus']['value'] = $ac100counter;
					$this->AchievementStatus->save($as100);
					array_push($updated, $achievementId);
				}
			}
		}
		for($i=0; $i<count($updated); $i++){
			$a = $this->Achievement->findById($updated[$i]);
			$updated[$i] = array();
			$updated[$i][0] = $a['Achievement']['name'];
			$updated[$i][1] = $a['Achievement']['description'];
			$updated[$i][2] = $a['Achievement']['image'];
			$updated[$i][3] = $a['Achievement']['color'];
			$updated[$i][4] = $a['Achievement']['xp'];
			$updated[$i][5] = $a['Achievement']['id'];
		}
		return $updated;
	}
	
	private function getXPJump($lvl=null){
		$j = 10;
		if($lvl>=12) $j = 25;
		if($lvl>=20) $j = 50;
		if($lvl>=40) $j = 100;
		if($lvl>=70) $j = 150;
		if($lvl==100) $j = 50000;
		if($lvl==101) $j = 1150;
		if($lvl>=102) $j = 0;
		return $j;
	}
	
	private function getHealth($lvl = null) {
		$hp = 10;
		if($lvl>=2) $hp = 10;
		if($lvl>=4) $hp = 11;
		if($lvl>=10)$hp = 12;
		if($lvl>=15)$hp = 13;
		if($lvl>=20)$hp = 14;
		if($lvl>=25)$hp = 15;
		if($lvl>=30)$hp = 16;
		if($lvl>=35)$hp = 17;
		if($lvl>=40)$hp = 18;
		if($lvl>=45)$hp = 19;
		if($lvl>=50)$hp = 20;
		if($lvl>=55)$hp = 21;
		if($lvl>=60)$hp = 22;
		if($lvl>=65)$hp = 23;
		if($lvl>=70)$hp = 24;
		if($lvl>=75)$hp = 25;
		if($lvl>=80)$hp = 26;
		if($lvl>=85)$hp = 27;
		if($lvl>=90)$hp = 28;
		if($lvl>=95)$hp = 29;
		if($lvl>=100)$hp = 30;
		return $hp;
    }
	
	public function updateXP($id, $a){
		$this->loadModel('User');
		$xpBonus = 0;
		for($i=0;$i<count($a);$i++){
			$xpBonus += $a[$i][4];
		}
		$u = $this->User->findById($id);
		
		$jumps = array();
		$xStart = 40;
		$xCurrentLvl = 1;
		$xLvlupXp = 10;
		
		for($i=1;$i<102;$i++){
			if($i>=102) $j = 0;
			else if($i==101) $j = 1150;
			else if($i==100) $j = 50000;
			else if($i>=70) $j = 150;
			else if($i>=40) $j = 100;
			else if($i>=20) $j = 50;
			else if($i>=12) $j = 25;
			else $j = 10;
			$xStart+=$j;
			$jumps[$i] = $xStart;
		}
		$next = 0;
		$uLevel = $u['User']['level'];
		$uXp = $u['User']['xp'];
		
		if($uLevel<101) $currentJump = $jumps[$uLevel];
		else $currentJump = 60000;
		
		$firstJump = $currentJump;
		
		if($uXp+$xpBonus>=$currentJump){
			$next = $uXp+$xpBonus-$currentJump;
			$uLevel++;
			if($uLevel<101) $currentJump = $jumps[$uLevel];
			else $currentJump = 60000;
		}
		while($next>=$currentJump){
			$next = $next-$currentJump;
			$uLevel++;
			if($uLevel<101) $currentJump = $jumps[$uLevel];
			else $currentJump = 60000;
		}
		
		$u['User']['level'] = $uLevel;
		if($uXp+$xpBonus<$firstJump) $u['User']['xp'] += $xpBonus;
		else $u['User']['xp'] = $next;
		$u['User']['nextlvl'] = $currentJump;
		
		$this->User->save($u);
	}
	
	function beforeFilter(){
		$this->loadModel('User');
		$this->loadModel('Activate');
		$this->loadModel('Tsumego');
		$this->loadModel('TsumegoRatingAttempt');
		$this->loadModel('Set');
		$this->loadModel('Rank');
		$this->LoadModel('TsumegoStatus');
		$this->LoadModel('Comment');
		$this->LoadModel('UserBoard');
		$this->LoadModel('TsumegoAttempt');
		$this->LoadModel('AdminActivity');
		$this->LoadModel('RankSetting');
		$this->loadModel('Achievement');
		$this->loadModel('AchievementStatus');
		$this->loadModel('AchievementCondition');
		$this->loadModel('SetConnection');
		
		ini_set('session.gc_maxlifetime', 7200000);
		session_set_cookie_params(7200000);
		$highscoreLink = 'highscore';
		$lightDark = 'light';
		$resetCookies = false;
		
    	if(isset($_SESSION['loggedInUser']['User']['id'])){
			if($_SESSION['loggedInUser']['User']['id']==33) unset($_SESSION['loggedInUser']);
            $loggedInUser = $_SESSION['loggedInUser'];
            $this->set('loggedInUser', $loggedInUser);
    	}
		if(isset($_SESSION['loggedInUser']['User']) && !isset($_SESSION['loggedInUser']['User']['id'])) unset($_SESSION['loggedInUser']);
		
		$u = null;
		if(isset($_SESSION['loggedInUser']['User']['id'])){
			$u =  $this->User->findById($_SESSION['loggedInUser']['User']['id']);
			if($u['User']['lastHighscore']==1) $highscoreLink = 'highscore';
			elseif($u['User']['lastHighscore']==2) $highscoreLink = 'rating';
			elseif($u['User']['lastHighscore']==3) $highscoreLink = 'leaderboard';
			elseif($u['User']['lastHighscore']==4) $highscoreLink = 'highscore3';
			
			if(isset($_COOKIE['lastMode']) && $_COOKIE['lastMode'] != 0){
				$u['User']['lastMode'] = $_COOKIE['lastMode'];
				$_SESSION['loggedInUser']['User']['lastMode'] = $_COOKIE['lastMode'];
				$this->User->save($u);
			}
			
			if(isset($_COOKIE['sound']) && $_COOKIE['sound'] != '0'){
				$_SESSION['loggedInUser']['User']['sound'] = $_COOKIE['sound'];
				$u['User']['sound'] = $_COOKIE['sound'];
				$this->User->save($u);
				unset($_COOKIE['sound']);
			}
			$this->set('ac', true);
			$this->set('user', $u);
		}
		
		if(isset($_COOKIE['lightDark']) && $_COOKIE['lightDark'] != '0'){
			$lightDark = $_COOKIE['lightDark'];
		}
		
		$mode = 1;
		if(isset($_COOKIE['mode']) && $_COOKIE['mode']!='0'){
			if($_COOKIE['mode']==1) $mode = 1;
			else $mode = 2;
		}
		if(isset($_SESSION['loggedInUser']['User']['mode'])){
			if($_SESSION['loggedInUser']['User']['mode']==2) $mode = 2;
		}
		
		if(isset($_COOKIE['preId']) && $_COOKIE['preId'] != '0'){
			$preTsumego = $this->Tsumego->findById($_COOKIE['preId']);
			
			$preSc = $this->SetConnection->find('all', array('conditions' => array('tsumego_id' => $_COOKIE['preId'])));
			
			$preTsumego['Tsumego']['set_id'] = $preSc[0]['SetConnection']['set_id'];
			$utPre = $this->TsumegoStatus->find('first', array('conditions' => array('tsumego_id' => $_COOKIE['preId'], 'user_id' => $_SESSION['loggedInUser']['User']['id'])));
		}
		
		if($_COOKIE['sprint']!=1)
			$this->updateSprintCondition(false);
		
		$correctSolveAttempt = false;
		//Correct!
		if(isset($_SESSION['loggedInUser']['User']['id'])){
		if(isset($_COOKIE['mode']) && isset($_COOKIE['score']) && isset($_COOKIE['preId'])){
		if($_COOKIE['mode'] == '1' && $_COOKIE['score'] != '0' && $_COOKIE['preId'] != '0'){
			$u = $this->User->findById($_SESSION['loggedInUser']['User']['id']);
			$suspiciousBehavior=false;
			$exploit=null;
						
			$_COOKIE['score'] = $this->decrypt($_COOKIE['score']);
			$scoreArr = explode('-', $_COOKIE['score']);
			$isNum = $preTsumego['Tsumego']['num']==$scoreArr[0];
			//$isSet = $preTsumego['Tsumego']['set_id']==$scoreArr[2];
			$isSet = true;
			
			$isNumSc = false;
			$isSetSc = false;
			for($i=0;$i<count($preSc);$i++){
				if($preSc[$i]['SetConnection']['set_id']==$preTsumego['Tsumego']['set_id'])
					$isSetSc = true;
				if($preSc[$i]['SetConnection']['num']==$preTsumego['Tsumego']['num'])
					$isNumSc = true;
			}
			$isNum = $isNumSc;
			$isSet = $isSetSc;
			
			$_COOKIE['score'] = $scoreArr[1];
			
			$solvedTsumegoRank = $this->getTsumegoRank($preTsumego['Tsumego']['userWin']);
			
			if($isNum && $isSet){
				if(isset($_COOKIE['preId'])){
					$tPre = $this->Tsumego->findById($_COOKIE['preId']);
					$resetCookies = true;
				}
				
				if($mode==1){
					if(isset($_SESSION['loggedInUser']) && !isset($_SESSION['noLogin'])){
						//$exploit = $this->UserBoard->find('first', array('conditions' => array('user_id' => $u['User']['id'], 'b1' => $_COOKIE['preId'])));
						$ub = array();
						$ub['UserBoard']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
						$ub['UserBoard']['b1'] = $_COOKIE['preId'];
						$this->UserBoard->create();
						$this->UserBoard->save($ub);
						
						if($_COOKIE['score']<3000) ;
						else $_COOKIE['score'] = 0;
						
						if($_COOKIE['score']>=3000){
							$suspiciousBehavior = true;
							//$_SESSION['loggedInUser']['User']['reuse5'] = 1;
							//$u['User']['reuse5'] = 1;
						}
						if($u['User']['reuse3']>10000){
							$_SESSION['loggedInUser']['User']['reuse4'] = 1;
							$u['User']['reuse4'] = 1;
						}
					}
					if($exploit==null && $suspiciousBehavior==false){
						if($mode==1){
							$xpOld = $u['User']['xp'] + (intval($_COOKIE['score']));
							$u['User']['reuse2']++;
							$u['User']['reuse3'] += intval($_COOKIE['score']);
							if($xpOld >= $u['User']['nextlvl']){
								$xpOnNewLvl = -1 * ($u['User']['nextlvl'] - $xpOld);
								$u['User']['xp'] = $xpOnNewLvl;
								$u['User']['level'] += 1;
								$u['User']['nextlvl'] += $this->getXPJump($u['User']['level']);
								$u['User']['health'] = $this->getHealth($u['User']['level']);
								$_SESSION['loggedInUser']['User']['level'] = $u['User']['level'];
							}else{
								$u['User']['xp'] = $xpOld;
								$u['User']['ip'] = $_SERVER['REMOTE_ADDR'];
							}
						}
						if($mode==1 && $u['User']['id']!=33){
							if(isset($_SESSION['loggedInUser']['User']['id'])){
								if(isset($_COOKIE['preId']) && $_COOKIE['preId']!=0){
									$this->TsumegoAttempt->create();
									$ur = array();
									$ur['TsumegoAttempt']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
									$ur['TsumegoAttempt']['tsumego_id'] = $_COOKIE['preId'];
									$ur['TsumegoAttempt']['gain'] = $_COOKIE['score'];
									$ur['TsumegoAttempt']['seconds'] = $_COOKIE['seconds'];
									$ur['TsumegoAttempt']['solved'] = '1';
									$this->TsumegoAttempt->save($ur);
									$correctSolveAttempt = true;
									
									$this->saveDanSolveCondition($solvedTsumegoRank, $preTsumego['Tsumego']['id']);
									$this->updateGems($solvedTsumegoRank);
									if($_COOKIE['sprint']==1)
										$this->updateSprintCondition(true);
									else
										$this->updateSprintCondition(false);
									if($_COOKIE['type']=='g')
										$this->updateGoldenCondition(true);
									$aCondition = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
										'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'err'
									)));
									if($aCondition==null) $aCondition = array();
									$aCondition['AchievementCondition']['category'] = 'err';
									$aCondition['AchievementCondition']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
									$aCondition['AchievementCondition']['value']++;
									$this->AchievementCondition->save($aCondition);
								}
							}
						}
						if(isset($_COOKIE['rank']) && $_COOKIE['rank'] != '0'){
							$ranks = $this->Rank->find('all', array('conditions' =>  array('session' => $_SESSION['loggedInUser']['User']['activeRank'])));
							$currentNum = $ranks[0]['Rank']['currentNum'];
							for($i=0; $i<count($ranks); $i++){
								if($ranks[$i]['Rank']['num'] == $currentNum-1){
									if($_COOKIE['rank']!='solved' && $_COOKIE['rank']!='failed' && $_COOKIE['rank']!='skipped' && $_COOKIE['rank']!='timeout'){
										$_COOKIE['rank']='failed';
									}
									$ranks[$i]['Rank']['result'] = $_COOKIE['rank'];
									$ranks[$i]['Rank']['seconds'] = $_COOKIE['seconds']/10/$_COOKIE['preId'];
									$this->Rank->save($ranks[$i]);
								}
							}
						}
					}
					if($utPre==null){
						$utPre['TsumegoStatus'] = array();
						$utPre['TsumegoStatus']['user_id'] = $u['User']['id'];
						$utPre['TsumegoStatus']['tsumego_id'] = $_COOKIE['preId'];
						$utPre['TsumegoStatus']['status'] = 'V';
					}
					if($utPre['TsumegoStatus']['status'] == 'W') $utPre['TsumegoStatus']['status'] = 'C';
					else $utPre['TsumegoStatus']['status'] = 'S';
				
					$utPre['TsumegoStatus']['created'] = date('Y-m-d H:i:s');
					if(isset($_SESSION['loggedInUser']) && !isset($_SESSION['noLogin'])){
						if(!isset($utPre['TsumegoStatus']['status'])) $utPre['TsumegoStatus']['status'] = 'V';
						$this->TsumegoStatus->save($utPre);
					}
				}
			}else{
				$u['User']['penalty'] += 1;
			}
			unset($_COOKIE['score']);
			unset($_COOKIE['transition']);
			unset($_COOKIE['sequence']);
			unset($_COOKIE['type']);
		}
		}
		}
		
		if(isset($_COOKIE['correctNoPoints']) && $_COOKIE['correctNoPoints'] != '0'){
			if($u['User']['id']!=33 && !$correctSolveAttempt){
				if(isset($_COOKIE['preId']) && $_COOKIE['preId']!=0){
					$this->TsumegoAttempt->create();
					$ur = array();
					$ur['TsumegoAttempt']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$ur['TsumegoAttempt']['tsumego_id'] = $_COOKIE['preId'];
					$ur['TsumegoAttempt']['gain'] = 0;
					$ur['TsumegoAttempt']['seconds'] = $_COOKIE['seconds'];
					$ur['TsumegoAttempt']['solved'] = '1';
					$this->TsumegoAttempt->save($ur);
				}
			}
		}
		
		$boardNames = array();
		$boardNames[1] =  'Pine';
		$boardNames[2] =  'Ash';
		$boardNames[3] =  'Maple';
		$boardNames[4] =  'Shin Kaya';
		$boardNames[5] =  'Birch';
		$boardNames[6] =  'Wenge';
		$boardNames[7] =  'Walnut';
		$boardNames[8] = 'Mahogany';
		$boardNames[9] = 'Blackwood';
		$boardNames[10] = 'Marble 1';
		$boardNames[11] = 'Marble 2';
		$boardNames[12] = 'Marble 3';
		$boardNames[13] = 'Tibet Spruce';
		$boardNames[14] = 'Marble 4';
		$boardNames[15] = 'Marble 5';
		$boardNames[16] = 'Quarry 1';
		$boardNames[17] = 'Flowers';
		$boardNames[18] = 'Nova';
		$boardNames[19] = 'Spring';
		$boardNames[20] = 'Moon';
		$boardNames[21] = 'Apex';
		$boardNames[22] = 'Gold 1';
		$boardNames[23] = 'Amber';
		$count = 24;
		
		if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['premium']>=1){
				$boardNames[24] = 'Marble 6';
				$boardNames[25] = 'Marble 7';
				$boardNames[26] = 'Marble 8';
				$boardNames[27] = 'Marble 9';
				$boardNames[28] = 'Marble 10';
				$boardNames[29] = 'Jade';
				$boardNames[30] = 'Quarry 2';
				$boardNames[31] = 'Black Bricks';
				$boardNames[32] = 'Wallpaper 1';
				$boardNames[33] = 'Wallpaper 2';
				$boardNames[34] = 'Gold & Gray';
				$boardNames[35] = 'Gold & Pink';
				$boardNames[36] = 'Veil';
				$boardNames[37] = 'Tiles';
				$boardNames[38] = 'Mars';
				$boardNames[39] = 'Pink Cloud';
				$boardNames[40] = 'Reptile';
				$boardNames[41] = 'Mezmerizing';
				$boardNames[42] = 'Magenta Sky';
				$boardNames[43] = 'Tsumego Hero';
				$count = 44;
			}
			if($_SESSION['loggedInUser']['User']['secretArea1']==1) $boardNames[$count] = 'Pretty';
			if($_SESSION['loggedInUser']['User']['secretArea2']==1) $boardNames[$count+1] = 'Hunting';
			if($_SESSION['loggedInUser']['User']['secretArea3']==1) $boardNames[$count+2] = 'Haunted';
			if($_SESSION['loggedInUser']['User']['secretArea4']==1) $boardNames[$count+3] = 'Carnage';
			if($_SESSION['loggedInUser']['User']['secretArea5']==1) $boardNames[$count+4] = 'Blind Spot';
			if($_SESSION['loggedInUser']['User']['secretArea6']==1) $boardNames[$count+5] = 'Giants';
			if($_SESSION['loggedInUser']['User']['secretArea7']==1) $boardNames[$count+6] = 'Gems';
			//if($_SESSION['loggedInUser']['User']['secretArea10']==1) $boardNames[$count+7] = 'Hand of God';
			if($_SESSION['loggedInUser']['User']['premium']>0 || $_SESSION['loggedInUser']['User']['secretArea9']==1) $boardNames[$count+7] = 'Grandmaster';
		}
		
		$enabledBoards = array();
		$boardPositions = array();
		
		if(isset($_SESSION['texture1']) || (isset($_COOKIE['texture1']) && $_COOKIE['texture1']!='0')){
			if(isset($_COOKIE['texture1']) && $_COOKIE['texture1']!='0'){
				$textureCookies = array();
				for($i=1;$i<=54;$i++){
					$_SESSION['texture'.$i] = $_COOKIE['texture'.$i];
					array_push($textureCookies, 'texture'.$i);
				}
				$this->set('textureCookies', $textureCookies);
			}
			for($i=1;$i<=54;$i++){
				$enabledBoards[$i] = $_SESSION['texture'.$i];
			}
			if($u!=null){
				for($i=1;$i<=54;$i++){
					if($_SESSION['texture'.$i] == 'checked') $u['User']['texture'.$i] = '1';
					else $u['User']['texture'.$i] = '0';
				}
				$this->User->save($u);
			}
			
			$boardPositions[1] = array(1,'texture1','black34.png','white34.png');
			$boardPositions[2] = array(2,'texture2','black34.png','white34.png');
			$boardPositions[3] = array(3,'texture3','black34.png','white34.png');
			$boardPositions[4] = array(4,'texture4','black.png','white.png');
			$boardPositions[5] = array(5,'texture5','black34.png','white34.png');
			$boardPositions[6] = array(6,'texture6','black.png','white.png');
			$boardPositions[7] = array(7,'texture7','black34.png','white34.png');
			$boardPositions[8] = array(8,'texture8','black.png','white.png');
			$boardPositions[9] = array(9,'texture9','black.png','white.png');
			$boardPositions[10] = array(10,'texture10','black34.png','white34.png');
			$boardPositions[11] = array(11,'texture11','black34.png','white34.png');
			$boardPositions[12] = array(12,'texture12','black34.png','white34.png');
			$boardPositions[13] = array(13,'texture13','black34.png','white34.png');
			$boardPositions[14] = array(14,'texture14','black34.png','white34.png');
			$boardPositions[15] = array(15,'texture15','black.png','white.png');
			$boardPositions[16] = array(16,'texture16','black34.png','white34.png');
			$boardPositions[17] = array(17,'texture17','black34.png','white34.png');
			$boardPositions[18] = array(18,'texture18','black.png','white.png');
			$boardPositions[19] = array(19,'texture19','black34.png','white34.png');
			$boardPositions[20] = array(20,'texture20','black34.png','white34.png');
			$boardPositions[21] = array(33,'texture33','black34.png','white34.png');
			$boardPositions[22] = array(21,'texture21','black.png','whiteKo.png');
			$boardPositions[23] = array(22,'texture22','black34.png','white34.png');
			$count = 24;
			if(isset($_SESSION['loggedInUser'])){
				if($_SESSION['loggedInUser']['User']['premium']>=1){
					$boardPositions[24] = array(34,'texture34','black.png','white.png');
					$boardPositions[25] = array(35,'texture35','black34.png','white34.png');
					$boardPositions[26] = array(36,'texture36','black.png','white.png');
					$boardPositions[27] = array(37,'texture37','black34.png','white34.png');
					$boardPositions[28] = array(38,'texture38','black38.png','white34.png');
					$boardPositions[29] = array(39,'texture39','black.png','white.png');
					$boardPositions[30] = array(40,'texture40','black34.png','white34.png');
					$boardPositions[31] = array(41,'texture41','black34.png','white34.png');
					$boardPositions[32] = array(42,'texture42','black34.png','white42.png');
					$boardPositions[33] = array(43,'texture43','black34.png','white42.png');
					$boardPositions[34] = array(44,'texture44','black34.png','white34.png');
					$boardPositions[35] = array(45,'texture45','black34.png','white42.png');
					
					$boardPositions[36] = array(47,'texture47','black34.png','white34.png');
					$boardPositions[37] = array(48,'texture48','black34.png','white34.png');
					$boardPositions[38] = array(49,'texture49','black.png','white.png');
					$boardPositions[39] = array(50,'texture50','black34.png','white34.png');
					$boardPositions[40] = array(51,'texture51','black34.png','white34.png');
					$boardPositions[41] = array(52,'texture52','black34.png','white34.png');
					$boardPositions[42] = array(53,'texture53','black34.png','white34.png');
					$boardPositions[43] = array(54,'texture54','black54.png','white54.png');
					$count = 44;
				}
				
				if($_SESSION['loggedInUser']['User']['secretArea1']==1) $boardPositions[$count] = array(23,'texture23','black.png','whiteFlower.png');
				if($_SESSION['loggedInUser']['User']['secretArea2']==1) $boardPositions[$count+1] = array(24,'texture24','black24.png','white24.png');
				if($_SESSION['loggedInUser']['User']['secretArea3']==1) $boardPositions[$count+2] = array(25,'texture25','blackGhost.png','white.png');
				if($_SESSION['loggedInUser']['User']['secretArea4']==1) $boardPositions[$count+3] = array(26,'texture26','blackInvis.png','whiteCarnage.png');
				if($_SESSION['loggedInUser']['User']['secretArea5']==1) $boardPositions[$count+4] = array(27,'texture27','black27.png','white27.png');
				if($_SESSION['loggedInUser']['User']['secretArea6']==1) $boardPositions[$count+5] = array(28,'texture28','blackGiant.png','whiteKo.png');
				if($_SESSION['loggedInUser']['User']['secretArea7']==1) $boardPositions[$count+6] = array(29,'texture29','blackKo.png','whiteKo.png');
				if($_SESSION['loggedInUser']['User']['secretArea10']==1) $boardPositions[$count+7] = array(30,'texture55','blackGalaxy.png','whiteGalaxy.png');
			}
		}else{
			$enabledBoards[1] = 'checked';
			$enabledBoards[2] = 'checked';
			$enabledBoards[3] = 'checked';
			$enabledBoards[4] = 'checked';
			$enabledBoards[5] = 'checked';
			$enabledBoards[6] = 'checked';
			$enabledBoards[7] = 'checked';
			$enabledBoards[8] = 'checked';
			$enabledBoards[9] = '';
			$enabledBoards[10] = '';
			$enabledBoards[11] = '';
			$enabledBoards[12] = '';
			$enabledBoards[13] = '';
			$enabledBoards[14] = '';
			$enabledBoards[15] = '';
			$enabledBoards[16] = '';
			$enabledBoards[17] = '';
			$enabledBoards[18] = '';
			$enabledBoards[19] = '';
			$enabledBoards[20] = '';
			$enabledBoards[21] = '';
			$enabledBoards[22] = '';
			$enabledBoards[23] = '';
			
			$boardPositions[1] = array(1,'texture1','black34.png','white34.png');
			$boardPositions[2] = array(2,'texture2','black34.png','white34.png');
			$boardPositions[3] = array(3,'texture3','black34.png','white34.png');
			$boardPositions[4] = array(4,'texture4','black.png','white.png');
			$boardPositions[5] = array(5,'texture5','black34.png','white34.png');
			$boardPositions[6] = array(6,'texture6','black.png','white.png');
			$boardPositions[7] = array(7,'texture7','black34.png','white34.png');
			$boardPositions[8] = array(8,'texture8','black.png','white.png');
			$boardPositions[9] = array(9,'texture9','black.png','white.png');
			$boardPositions[10] = array(10,'texture10','black34.png','white34.png');
			$boardPositions[11] = array(11,'texture11','black34.png','white34.png');
			$boardPositions[12] = array(12,'texture12','black34.png','white34.png');
			$boardPositions[13] = array(13,'texture13','black34.png','white34.png');
			$boardPositions[14] = array(14,'texture14','black34.png','white34.png');
			$boardPositions[15] = array(15,'texture15','black.png','white.png');
			$boardPositions[16] = array(16,'texture16','black34.png','white34.png');
			$boardPositions[17] = array(17,'texture17','black34.png','white34.png');
			$boardPositions[18] = array(18,'texture18','black.png','white.png');
			$boardPositions[19] = array(19,'texture19','black34.png','white34.png');
			$boardPositions[20] = array(20,'texture20','black34.png','white34.png');
			$boardPositions[21] = array(33,'texture33','black34.png','white34.png');
			$boardPositions[22] = array(21,'texture21','black.png','whiteKo.png');
			$boardPositions[23] = array(22,'texture22','black34.png','white34.png');
		}
		
		$achievementUpdate = array();
		if(isset($_SESSION['initialLoading'])){
			$achievementUpdate1 = $this->checkLevelAchievements();
			$achievementUpdate2 = $this->checkProblemNumberAchievements();
			$achievementUpdate3 = $this->checkRatingAchievements();
			$achievementUpdate4 = $this->checkTimeModeAchievements();
			$achievementUpdate5 = $this->checkDanSolveAchievements();
			$achievementUpdate = array_merge($achievementUpdate1, $achievementUpdate2, $achievementUpdate3, $achievementUpdate4, $achievementUpdate5);
			unset($_SESSION['initialLoading']);
		}
		//echo '<pre>'; print_r($_SESSION['loggedInUser']['User']['lastHighscore']); echo '</pre>';
		
		if(count($achievementUpdate)>0) 
			$this->updateXP($_SESSION['loggedInUser']['User']['id'], $achievementUpdate);
		
		$nextDay = new DateTime('tomorrow');
		
		$this->set('mode', $mode);
		$this->set('nextDay', $nextDay->format('m/d/Y'));
		$this->set('boardNames', $boardNames);
		$this->set('enabledBoards', $enabledBoards);
		$this->set('boardPositions', $boardPositions);
		$this->set('highscoreLink', $highscoreLink);
		$this->set('achievementUpdate', $achievementUpdate);
		$this->set('lightDark', $lightDark);
		$this->set('resetCookies', $resetCookies);
    }
	
	function afterFilter(){
		$this->loadModel('Rank');
		if(isset($_SESSION['loggedInUser']['User']['id'])){
			if($_SESSION['page']!='time mode' && $_SESSION['loggedInUser']['User']['mode'] == 3 || $_SESSION['page']!='time mode' && strlen($_SESSION['loggedInUser']['User']['activeRank'])==15){
				$ranks = $this->Rank->find('all', array('conditions' => array('session' => $_SESSION['loggedInUser']['User']['activeRank'])));
				for($i=0;$i<count($ranks);$i++){
					$this->Rank->delete($ranks[$i]['Rank']['id']);
				}
				$_SESSION['loggedInUser']['User']['activeRank'] = 0;
				$_SESSION['loggedInUser']['User']['mode'] = 1;
			}
		}
		
		unset($_COOKIE['sortColor']);
		unset($_COOKIE['sortColor']);
		unset($_COOKIE['sortOrder']);
		unset($_COOKIE['sortOrder']);
	}
	
}



