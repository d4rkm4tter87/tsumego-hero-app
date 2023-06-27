<?php
App::uses('Controller', 'Controller');

define('INITIAL_RATING', 1000.0);
define('INITIAL_RD', 300.0);
define('C', 30.0);
define('Q', 0.0057564);

class AppController extends Controller{

	public function getInvisibleSets(){
		$this->LoadModel('Set');
		$invisibleSets = array();
		$in = $this->Set->find('all', array('conditions' => array('public' => 0)));
		for($i=0; $i<count($in); $i++){
			array_push($invisibleSets, $in[$i]['Set']['id']);
		}
		/*
		array_push($invisibleSets, 68);//Problems from Professional Games
		array_push($invisibleSets, 83);//KPA 4 sandbox
		array_push($invisibleSets, 85);//TD 1 sandbox
		array_push($invisibleSets, 95);//TD 2 sandbox
		array_push($invisibleSets, 96);//TD 2 sandbox
		array_push($invisibleSets, 97);//TD 3 sandbox
		array_push($invisibleSets, 98);//TD 3 sandbox
		array_push($invisibleSets, 99);//TD 2 sandbox
		array_push($invisibleSets, 100);//TD 3 sandbox
		array_push($invisibleSets, 102);//intro
		array_push($invisibleSets, 103);//intro
		array_push($invisibleSets, 110);//Tesuji Sandbox
		array_push($invisibleSets, 111);//Tesuji Sandbox
		array_push($invisibleSets, 112);//Cho Int Sandbox
		array_push($invisibleSets, 116);//easy capture Sandbox
		array_push($invisibleSets, 118);//Cho Int Sandbox
		array_push($invisibleSets, 119);//Cho Adv Sandbox
		array_push($invisibleSets, 120);//Gokyo Shumyo Sandbox
		array_push($invisibleSets, 121);//Endgame Sandbox
		array_push($invisibleSets, 123);//Gokyo Shumyo Sandbox
		array_push($invisibleSets, 125);//Gokyo Shumyo Sandbox
		array_push($invisibleSets, 126);//Tsumego Master
		array_push($invisibleSets, 128);
		array_push($invisibleSets, 129);
		array_push($invisibleSets, 130);
		array_push($invisibleSets, 131);
		array_push($invisibleSets, 132);
		array_push($invisibleSets, 133);
		array_push($invisibleSets, 134);
		array_push($invisibleSets, 135);
		array_push($invisibleSets, 136);
		array_push($invisibleSets, 88156);//Hand of God
		*/
		return $invisibleSets;
	}
	
	public function getDeletedSets(){
		$dSets = array();
		$de = $this->Set->find('all', array('conditions' => array('public' => -1)));
		for($i=0; $i<count($de); $i++){
			array_push($dSets, $de[$i]['Set']['id']);
		}
		/*
		array_push($dSets, 58);//Counting Liberties & Winning Capturing Races
		array_push($dSets, 62);//Level Up 1
		array_push($dSets, 63);//Endgame
		array_push($dSets, 91);//Level Up 2
		array_push($dSets, 51);//CC Advanced
		array_push($dSets, 56);//CC Advanced
		array_push($dSets, 57);//CC Advanced
		
		auch gelöscht:
		72 1001L&D
		73 1001L&D
		74 1001L&D
		75 1001L&D
		76 1001L&D
		77 1001L&D
		78 tesuji
		79 tesuji
		80 tesuji
		*/
		
		return $dSets;
	}
	
	public function uotd(){//routine1
		$this->LoadModel('User');
		$this->LoadModel('DayRecord');
		$this->LoadModel('TsumegoAttempt');
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
		$this->DayRecord->save($dateUser);
		
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
	
	public function userRefresh($range = null){
		$this->LoadModel('User');
		$this->LoadModel('TsumegoStatus');
		if($range==1){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id <' => 1000
			)));
		}elseif($range==2){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 1000,
				'id <' => 2000
			)));
		}elseif($range==3){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 2000,
				'id <' => 3000
			)));
		}elseif($range==4){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 3000,
				'id <' => 4000
			)));
		}elseif($range==5){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 4000,
				'id <' => 5000
			)));
		}elseif($range==6){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 5000,
				'id <' => 6000
			)));
		}elseif($range==7){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 6000,
				'id <' => 7000
			)));
		}elseif($range==8){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 7000,
				'id <' => 8000
			)));
		}elseif($range==9){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 8000,
				'id <' => 9000
			)));
		}elseif($range==10){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 9000,
				'id <' => 10000
			)));
		}elseif($range==11){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 10000,
				'id <' => 11000
			)));
		}elseif($range==12){
			$u = $this->User->find('all', array('order' => 'id DESC', 'conditions' =>  array(
				'id >=' => 11000
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
		
		//$dr = $this->DayRecord->find('first', array('conditions' =>  array('date' => '2022-11-21')));
		//$dr['DayRecord']['tsumego'] = 21713;
		//$this->DayRecord->save($dr);
		
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
		//if(count($s)<=1){
		if(false){
			if($s!=null){
				$id = $this->publishSingle($s['Schedule']['tsumego_id'], $s['Schedule']['set_id'], $s['Schedule']['date']);
				$s['Schedule']['tsumego_id'] = $id;
				$s['Schedule']['published'] = 1;
				$this->Schedule->save($s);
				return $id;
			}else return 0;
		}else{
			for($i=0; $i<count($s); $i++){
				$id = $this->publishSingle($s[$i]['Schedule']['tsumego_id'], $s[$i]['Schedule']['set_id'], $s[$i]['Schedule']['date']);
				$s[$i]['Schedule']['tsumego_id'] = $id;
				$s[$i]['Schedule']['published'] = 1;
				$this->Schedule->save($s[$i]);
			}
			return $id;
		}
	}
	
	public function publishSingle($t=null, $to=null, $date=null){
		$this->LoadModel('Tsumego');
		$ts = $this->Tsumego->findById($t);
		$id = $this->Tsumego->find('first', array('limit' => 1, 'order' => 'id DESC'));
		$id = $id['Tsumego']['id'];
		$id += 1;
		$sid = $ts['Tsumego']['id'];
		$ts['Tsumego']['id'] = $id;
		$ts['Tsumego']['set_id'] = $to;
		$ts['Tsumego']['created'] = $date.' 22:00:00';
		$ts['Tsumego']['solved'] = 0;
		$ts['Tsumego']['failed'] = 0;
		$ts['Tsumego']['userWin'] = 0;
		$ts['Tsumego']['userLoss'] = 0;
		$this->Tsumego->create();
		$this->Tsumego->save($ts);
		$this->Tsumego->delete($sid);
		return $id;
	}
	
	public function getTsumegoOfTheDay(){
		$this->loadModel('TsumegoAttempt');
		$this->loadModel('TsumegoRatingAttempt');
		$this->loadModel('Schedule');
		$this->loadModel('Tsumego');
		
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
	
	function beforeFilter(){
		$this->loadModel('User');
		$this->loadModel('Activate');
		$this->loadModel('Tsumego');
		$this->loadModel('TsumegoRatingAttempt');
		$this->loadModel('Set');
		$this->loadModel('Rank');
		//200 hrs
		//server
		ini_set('session.gc_maxlifetime', 7200000);
		//client
		session_set_cookie_params(7200000);

		$highscoreLink = 'highscore';
    	if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['id']==33) unset($_SESSION['loggedInUser']);
            $loggedInUser = $_SESSION['loggedInUser'];
            $this->set('loggedInUser', $loggedInUser);
    	}
		
		if(isset($_SESSION['loggedInUser']['User']) && !isset($_SESSION['loggedInUser']['User']['id'])) unset($_SESSION['loggedInUser']);
		
		$u = null;
		if(isset($_SESSION['loggedInUser'])){
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
		
		$mode = 1;
		if(isset($_COOKIE['mode']) && $_COOKIE['mode']!='0'){
			if($_COOKIE['mode']==1) $mode = 1;
			else $mode = 2;
		}
		if(isset($_SESSION['loggedInUser']['User']['mode'])){
			if($_SESSION['loggedInUser']['User']['mode']==2) $mode = 2;
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
			
			//Tsumego Grandmaster
		
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
			
			$boardPositions[1] = 1;
			$boardPositions[2] = 2;
			$boardPositions[3] = 3;
			$boardPositions[4] = 4;
			$boardPositions[5] = 5;
			$boardPositions[6] = 6;
			$boardPositions[7] = 7;
			$boardPositions[8] = 8;
			$boardPositions[9] = 9;
			$boardPositions[10] = 10;
			$boardPositions[11] = 11;
			$boardPositions[12] = 12;
			$boardPositions[13] = 13;
			$boardPositions[14] = 14;
			$boardPositions[15] = 15;
			$boardPositions[16] = 16;
			$boardPositions[17] = 17;
			$boardPositions[18] = 18;
			$boardPositions[19] = 19;
			$boardPositions[20] = 20;
			$boardPositions[21] = 33;
			$boardPositions[22] = 21;
			$boardPositions[23] = 22;
			$count = 24;
			if(isset($_SESSION['loggedInUser'])){
				if($_SESSION['loggedInUser']['User']['premium']>=1){
					$boardPositions[24] = 34;
					$boardPositions[25] = 35;
					$boardPositions[26] = 36;
					$boardPositions[27] = 37;
					$boardPositions[28] = 38;
					$boardPositions[29] = 39;
					$boardPositions[30] = 40;
					$boardPositions[31] = 41;
					$boardPositions[32] = 42;
					$boardPositions[33] = 43;
					$boardPositions[34] = 44;
					$boardPositions[35] = 45;
					
					$boardPositions[36] = 47;
					$boardPositions[37] = 48;
					$boardPositions[38] = 49;
					$boardPositions[39] = 50;
					$boardPositions[40] = 51;
					$boardPositions[41] = 52;
					$boardPositions[42] = 53;
					$boardPositions[43] = 54;
					$count = 44;
				}
				
				if($_SESSION['loggedInUser']['User']['secretArea1']==1) $boardPositions[$count] = 23;
				if($_SESSION['loggedInUser']['User']['secretArea2']==1) $boardPositions[$count+1] = 24;
				if($_SESSION['loggedInUser']['User']['secretArea3']==1) $boardPositions[$count+2] = 25;
				if($_SESSION['loggedInUser']['User']['secretArea4']==1) $boardPositions[$count+3] = 26;
				if($_SESSION['loggedInUser']['User']['secretArea5']==1) $boardPositions[$count+4] = 27;
				if($_SESSION['loggedInUser']['User']['secretArea6']==1) $boardPositions[$count+5] = 28;
				if($_SESSION['loggedInUser']['User']['secretArea7']==1) $boardPositions[$count+6] = 29;
				if($_SESSION['loggedInUser']['User']['secretArea10']==1) $boardPositions[$count+7] = 30;
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
			$enabledBoards[11] = 'checked';
			$enabledBoards[12] = 'checked';
			$enabledBoards[13] = 'checked';
			$enabledBoards[14] = '';
			$enabledBoards[15] = '';
			$enabledBoards[16] = '';
			$enabledBoards[17] = 'checked';
			$enabledBoards[18] = 'checked';
			$enabledBoards[19] = 'checked';
			$enabledBoards[20] = '';
			$enabledBoards[21] = 'checked';
			$enabledBoards[22] = 'checked';
			$enabledBoards[23] = '';
			
			$boardPositions[1] = 1;
			$boardPositions[2] = 2;
			$boardPositions[3] = 3;
			$boardPositions[4] = 4;
			$boardPositions[5] = 5;
			$boardPositions[6] = 6;
			$boardPositions[7] = 7;
			$boardPositions[8] = 8;
			$boardPositions[9] = 9;
			$boardPositions[10] = 10;
			$boardPositions[11] = 11;
			$boardPositions[12] = 12;
			$boardPositions[13] = 13;
			$boardPositions[14] = 14;
			$boardPositions[15] = 15;
			$boardPositions[16] = 16;
			$boardPositions[17] = 17;
			$boardPositions[18] = 18;
			$boardPositions[19] = 19;
			$boardPositions[20] = 20;
			$boardPositions[21] = 33;
			$boardPositions[22] = 21;
			$boardPositions[23] = 22;
		}
		/*
		//echo '<pre>'; print_r($_SESSION['loggedInUser']['User']['lastHighscore']); echo '</pre>';
		$ra = null;
		$crs = 0;
		$crsAll = 0;
		if($_SESSION['loggedInUser']['User']['mode'] == 3){
			$ra = $this->Rank->find('all', array('conditions' => array('session' => $_SESSION['loggedInUser']['User']['activeRank'])));
			for($i=0;$i<count($ra);$i++){
				if($ra[$i]['Rank']['result']=='solved') $crs++;
				$crsAll++;
			}
		}
		
		echo '<pre>'; print_r($crsAll); echo '</pre>';
		echo '<pre>'; print_r($ra[0]['Rank']['rank']); echo '</pre>';
		*/
		
		//echo '<pre>'; print_r($_SESSION['loggedInUser']['User']['mode']); echo '</pre>';
		
		$nextDay = new DateTime('tomorrow');
		$this->set('mode', $mode);
		$this->set('nextDay', $nextDay->format('m/d/Y'));
		$this->set('boardNames', $boardNames);
		$this->set('enabledBoards', $enabledBoards);
		$this->set('boardPositions', $boardPositions);
		$this->set('highscoreLink', $highscoreLink);
    }
	
	function afterFilter(){
		$this->loadModel('Rank');
		if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['page']!='time mode' && $_SESSION['loggedInUser']['User']['mode'] == 3 || $_SESSION['page']!='time mode' && strlen($_SESSION['loggedInUser']['User']['activeRank'])==15){
				$ranks = $this->Rank->find('all', array('conditions' => array('session' => $_SESSION['loggedInUser']['User']['activeRank'])));
				for($i=0;$i<count($ranks);$i++){
					$this->Rank->delete($ranks[$i]['Rank']['id']);
				}
				$_SESSION['loggedInUser']['User']['activeRank'] = 0;
				$_SESSION['loggedInUser']['User']['mode'] = 1;
			}
		}
	}
	
}



