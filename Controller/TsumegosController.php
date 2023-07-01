<?php

class TsumegosController extends AppController{
    public $helpers = array('Html', 'Form');

	public function play($id = null){
		$_SESSION['page'] = 'play';
		$this->loadModel('User');
		$this->LoadModel('Set');
		$this->LoadModel('TsumegoStatus');
		$this->LoadModel('Comment');
		$this->LoadModel('UserBoard');
		$this->LoadModel('TsumegoAttempt');
		$this->LoadModel('Favorite');
		$this->LoadModel('AdminActivity');
		$this->LoadModel('TsumegoRatingAttempt');
		$this->LoadModel('Activate');
		$this->LoadModel('Joseki');
		$this->LoadModel('Reputation');
		$this->LoadModel('Rank');
		$this->LoadModel('RankSetting');
		
		$noUser;
		$noLogin;
		$noLoginStatus;
		$rejuvenation = false;
		$doublexp = null;
		$exploit = null;
		$dailyMaximum = false;
		$suspiciousBehavior = false;
		$refinementUT = null;
		$half = '';
		$inFavorite = false;
		$isSandbox = false;
		$goldenTsumego = false;
		$refresh = null;
		$mode = 1;
		$noTr = false;
		$range = array();
		$difficulty = 4;
		$oldmin = -600;
		$oldmax = 500;
		$newmin = 0.1;
		$newmax = 2;
		$potion = 0;
		$potionPercent = 0;
		$potionPercent2 = 0;
		$potionSuccess = false;
		$potionActive = false;
		$reviewCheat = false;
		$commentCoordinates = array();
		$josekiLevel = 1;
		$rankTs = array();
		$ranks = array();
		$firstRanks = 0;
		$currentRank = null;
		$currentRankNum = 0;
		$r10 = 0;
		$stopParameter = 0;
		$stopParameter2 = 0;
		$mode3ScoreArray = array();
		$trs = array();
		$potionAlert = false;
		$ui = 1;
		$eloScore = 0;
		$range2 = array();
		
		if(isset($this->params['url']['potionAlert'])){
			$potionAlert = true;
		}
		
		if(isset($this->params['url']['ui'])){
			if($this->params['url']['ui']==2) $ui = 2;
			else $ui = 1;
		}
		if(isset($_COOKIE['ui']) && $_COOKIE['ui'] != '0'){
			$ui = $_COOKIE['ui'];
			unset($_COOKIE['ui']);
		}
		
		if(isset($this->params['url']['modelink'])){
			if($this->params['url']['modelink']==1) $tlength=15;
			elseif($this->params['url']['modelink']==2) $tlength=16;
			elseif($this->params['url']['modelink']==3) $tlength=17;
			
			if(isset($this->params['url']['modelink'])) $_COOKIE['mode'] = 3;
			
			$tcharacters = '0123456789abcdefghijklmnopqrstuvwxyz';
			$tcharactersLength = strlen($tcharacters);
			$trandomString = '';
			for($i=0;$i<$tlength;$i++){
				$trandomString .= $tcharacters[rand(0, $tcharactersLength - 1)];
			}
			
			$_SESSION['loggedInUser']['User']['activeRank'] = $trandomString;
			$u = $this->User->findById($_SESSION['loggedInUser']['User']['id']);
			$u['User']['activeRank'] =  $trandomString;
			$this->User->save($u);
		}
		
		if(isset($_SESSION['loggedInUser'])){
			$_SESSION['loggedInUser']['User']['mode'] = 1;
			$u =  $this->User->findById($_SESSION['loggedInUser']['User']['id']);
		
			if(isset($_COOKIE['mode']) && $_COOKIE['mode'] != '0'){
				if(strlen($_SESSION['loggedInUser']['User']['activeRank'])>=15){
					if($_COOKIE['mode']!=3){//switch 3=>2, 3=>1
						$ranks = $this->Rank->find('all', array('conditions' => array('session' => $_SESSION['loggedInUser']['User']['activeRank'])));
						if(count($ranks)!=10){
							for($i=0;$i<count($ranks);$i++){
								$this->Rank->delete($ranks[$i]['Rank']['id']);
							}
						}
						$_SESSION['loggedInUser']['User']['activeRank'] = 0;
						$u['User']['activeRank'] = 0;
						$this->User->save($u);
					}
				}else{
					if($_COOKIE['mode']==3){
						$_COOKIE['mode'] = 1;
					}
				}
				$_SESSION['loggedInUser']['User']['mode'] = $_COOKIE['mode'];	
				$mode = $_COOKIE['mode'];
				
			}
			unset($_COOKIE['mode']);
		}else{
			$nextMode = $this->Tsumego->findById(15352);
			$mode = 1;
		}
		
		if(isset($_SESSION['loggedInUser'])){
			if(strlen($_SESSION['loggedInUser']['User']['activeRank'])>=15){
				if(strlen($_SESSION['loggedInUser']['User']['activeRank'])==15){
					$stopParameter = 10;
					$stopParameter2 = 0;
				}elseif(strlen($_SESSION['loggedInUser']['User']['activeRank'])==16){
					$stopParameter = 10;
					$stopParameter2 = 1;
				}elseif(strlen($_SESSION['loggedInUser']['User']['activeRank'])==17){
					$stopParameter = 10;
					$stopParameter2 = 2;
				}
				$mode = 3;
				$_SESSION['loggedInUser']['User']['mode'] = 3;
				$ranks = $this->Rank->find('all', array('conditions' =>  array('session' => $_SESSION['loggedInUser']['User']['activeRank'])));
				if(count($ranks)==0){
					$r = $this->params['url']['rank'];
					if($r=='5d'){ $r1=0.1; $r2=22; }
					elseif($r=='4d'){ $r1=22; $r2=26.5; }
					elseif($r=='3d'){ $r1=26.5; $r2=30; }
					elseif($r=='2d'){ $r1=30; $r2=34; }
					elseif($r=='1d'){ $r1=34; $r2=38; }
					elseif($r=='1k'){ $r1=38; $r2=42; }
					elseif($r=='2k'){ $r1=42; $r2=46; }
					elseif($r=='3k'){ $r1=46; $r2=50; }
					elseif($r=='4k'){ $r1=50; $r2=54.5; }
					elseif($r=='5k'){ $r1=54.5; $r2=58.5; }
					elseif($r=='6k'){ $r1=58.5; $r2=63; }
					elseif($r=='7k'){ $r1=63; $r2=67; }
					elseif($r=='8k'){ $r1=67; $r2=70.8; }
					elseif($r=='9k'){ $r1=70.8; $r2=74.8; }
					elseif($r=='10k'){ $r1=74.8; $r2=79; }
					elseif($r=='11k'){ $r1=79; $r2=83.5; }
					elseif($r=='12k'){ $r1=83.5; $r2=88; }
					elseif($r=='13k'){ $r1=88; $r2=92; }
					elseif($r=='14k'){ $r1=92; $r2=96; }
					elseif($r=='15k'){ $r1=96; $r2=100; }
					else{ $r1=96; $r2=100; }
					
					$rs = $this->RankSetting->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
					$allowedRs = array();
					for($i=0; $i<count($rs); $i++){
						if($rs[$i]['RankSetting']['status']==1) array_push($allowedRs, $rs[$i]['RankSetting']['set_id']);
					}
					
					$rankTs = $this->Tsumego->find('all', array(
						'conditions' =>  array(
							'set_id' => $allowedRs,
							'userWin >' => $r1,
							'userWin <=' => $r2
						)
					));
					
					shuffle($rankTs);
					for($i=0; $i<$stopParameter; $i++){
						$rm = array();
						$rm['Rank']['session'] = $_SESSION['loggedInUser']['User']['activeRank'];
						$rm['Rank']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
						$rm['Rank']['tsumego_id'] = $rankTs[$i]['Tsumego']['id'];;
						$rm['Rank']['rank'] = $r;
						$rm['Rank']['num'] = $i+1;
						$rm['Rank']['currentNum'] = 1;
						$this->Rank->create();
						$this->Rank->save($rm);
					}
					$currentRankNum = 1;
					$firstRanks = 1;
				}else{
					for($i=0; $i<count($ranks); $i++){
						$ranks[$i]['Rank']['currentNum']++;
						$this->Rank->save($ranks[$i]);
					}
					$currentNum = $ranks[0]['Rank']['currentNum'];
					$tsid = null;
					for($i=0; $i<count($ranks); $i++){
						if($ranks[$i]['Rank']['num'] == $currentNum) $tsid = $ranks[$i]['Rank']['tsumego_id'];
					}
					$currentRank = $this->Tsumego->findById($tsid);
					$firstRanks = 2;
					
					if($currentNum==$stopParameter+1) $r10=1;
					
					$currentRankNum = $currentNum;
				}
			}
		}
		if(isset($this->params['url']['refresh'])) $refresh = $this->params['url']['refresh'];
		if(!is_numeric($id)) $id = 15352;
		if(!empty($rankTs)){
			$id = $rankTs[0]['Tsumego']['id'];
			$mode = 3;
		}elseif($firstRanks==2){
			$id = $currentRank['Tsumego']['id'];
			$mode = 3;
		}
		
		if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['mode']==0) $_SESSION['loggedInUser']['User']['mode'] = 1;
			
			if(isset($this->params['url']['mode'])){
				$_SESSION['loggedInUser']['User']['mode'] = $this->params['url']['mode'];	
				$mode = $this->params['url']['mode'];
			}
			
			$difficulty = $u['User']['t_glicko'];
			if(isset($_COOKIE['difficulty']) && $_COOKIE['difficulty'] != '0'){
				$difficulty = $_COOKIE['difficulty'];
				$u['User']['t_glicko'] = $_COOKIE['difficulty'];
				unset($_COOKIE['difficulty']);
			}
			
			if($mode==2){
				$trs = $this->TsumegoRatingAttempt->find('all', array('order' => 'created DESC', 'conditions' => array(
					'user_id' => $_SESSION['loggedInUser']['User']['id'],
					'recent' => 1,
					'OR' => array(
						array('status' => 'S'),
						array('status' => 'F')
					)
				)));
				
				$recentlyPlayed = array();
				for($i=0; $i<count($trs); $i++){
					array_push($recentlyPlayed, $trs[$i]['TsumegoRatingAttempt']['tsumego_id']);
				}
				$trCount = 0;
				for($i=0; $i<count($trs); $i++){
					$trCurrent = substr($trs[$i]['TsumegoRatingAttempt']['created'], 0, 7);
					if(date('Y-m') == $trCurrent) $trCount++;
				}
				
				$or = array();
				$publicSets = $this->Set->find('all', array('conditions' => array('public' => 1)));
				for($i=0; $i<count($publicSets); $i++) array_push($or, $publicSets[$i]['Set']['id']);
			
				if($difficulty==1) $adjustDifficulty = -450;
				elseif($difficulty==2) $adjustDifficulty = -300;
				elseif($difficulty==3) $adjustDifficulty = -150;
				elseif($difficulty==4) $adjustDifficulty = 0;
				elseif($difficulty==5) $adjustDifficulty = 150;
				elseif($difficulty==6) $adjustDifficulty = 300;
				elseif($difficulty==7) $adjustDifficulty = 450;
				else $adjustDifficulty = 0;
				
				$eloRange = $u['User']['elo_rating_mode'] + $adjustDifficulty;

				$rangeIncrement = 0;
				
				if($eloRange<900) $rangeMin = 300;
				else $rangeMin = 101;
				$eloRangeMin = 0;
				$eloRangeMax = 100;
				$tolerance = $trCount*0.03;
				
				if($eloRange>=2900){$eloRangeMin=0; $eloRangeMax=23+$tolerance;}//$td = '9d';
				elseif($eloRange>=2800){$eloRangeMin=0; $eloRangeMax=23+$tolerance;}//$td = '8d';
				elseif($eloRange>=2700){$eloRangeMin=0; $eloRangeMax=23+$tolerance;}//$td = '7d';
				elseif($eloRange>=2600){$eloRangeMin=0; $eloRangeMax=23+$tolerance;}//$td = '6d';
				elseif($eloRange>=2500){$eloRangeMin=0; $eloRangeMax=23+$tolerance;}//$td = '5d';
				elseif($eloRange>=2400){$eloRangeMin=23.1-$tolerance; $eloRangeMax=26+$tolerance;}//$td = '4d'; 
				elseif($eloRange>=2300){$eloRangeMin=26.1-$tolerance; $eloRangeMax=29+$tolerance;}//$td = '3d';
				elseif($eloRange>=2200){$eloRangeMin=29.1-$tolerance; $eloRangeMax=32+$tolerance;}//$td = '2d'; 
				elseif($eloRange>=2100){$eloRangeMin=32.1-$tolerance; $eloRangeMax=35+$tolerance;}//$td = '1d';
				elseif($eloRange>=2000){$eloRangeMin=35.1-$tolerance; $eloRangeMax=38+$tolerance;}//$td = '1k'; 
				elseif($eloRange>=1900){$eloRangeMin=38.1-$tolerance; $eloRangeMax=42+$tolerance;}//$td = '2k';
				elseif($eloRange>=1800){$eloRangeMin=42.1-$tolerance; $eloRangeMax=46+$tolerance;}//$td = '3k'; 
				elseif($eloRange>=1700){$eloRangeMin=46.1-$tolerance; $eloRangeMax=50+$tolerance;}//$td = '4k';
				elseif($eloRange>=1600){$eloRangeMin=50.1-$tolerance; $eloRangeMax=55+$tolerance;}//$td = '5k';
				elseif($eloRange>=1500){$eloRangeMin=55.1-$tolerance; $eloRangeMax=60+$tolerance;}//$td = '6k';
				elseif($eloRange>=1400){$eloRangeMin=60.1-$tolerance; $eloRangeMax=65+$tolerance;}//$td = '7k'; 
				elseif($eloRange>=1300){$eloRangeMin=65.1-$tolerance; $eloRangeMax=70+$tolerance;}//$td = '8k';
				elseif($eloRange>=1200){$eloRangeMin=70.1-$tolerance; $eloRangeMax=75+$tolerance;}//$td = '9k';
				elseif($eloRange>=1100){$eloRangeMin=75.1-$tolerance; $eloRangeMax=80+$tolerance;}//$td = '10k';
				elseif($eloRange>=1000){$eloRangeMin=80.1-$tolerance; $eloRangeMax=85+$tolerance;}//$td = '11k';
				elseif($eloRange>=900){$eloRangeMin=85.1-$tolerance; $eloRangeMax=90+$tolerance;}//$td = '12k';
				else{$eloRangeMin=90.1-$tolerance; $eloRangeMax=100;}//$td = '20k';
			
				while(count($range)<$rangeMin){
					$range = $this->Tsumego->find('all', array('order' => 'elo_rating_mode ASC', 'conditions' => array(
						'userWin >=' => $eloRangeMin-$rangeIncrement,
						'userWin <=' => $eloRangeMax+$rangeIncrement,
						'OR' => array('set_id' => $or),
						'NOT' => array(
							'id' => $recentlyPlayed,
							'userWin' => 0,
							'set_id' => array(42, 109, 113, 114, 115, 122, 124, 127, 139, 143, 145, 6473, 11969, 29156, 31813, 33007, 71790, 74761, 81578, 88156)
						)
					)));
					$rangeIncrement+=50;
				}
				
				for($i=0; $i<count($range); $i++){
					array_push($range2, $range[$i]['Tsumego']['elo_rating_mode']);
				}
				
				shuffle($range);
				$nextMode = $range[0];
				
				if(isset($_COOKIE['preId']) && $_COOKIE['preId']!=0){
					$id = $nextMode['Tsumego']['id'];
				}else{
					if(isset($_COOKIE['skip']) && $_COOKIE['skip']!='0') $id = $nextMode['Tsumego']['id'];
					else $id = $_SESSION['lastVisit'];
				}
			}
		}
		if(isset($this->params['url']['refresh'])) $refresh = $this->params['url']['refresh'];
		
		$t = $this->Tsumego->findById($id);
		
		$fSet = $this->Set->find('first', array('conditions' => array('id' => $t['Tsumego']['set_id'])));
		if($t==null) $t = $this->Tsumego->findById($_SESSION['lastVisit']);
		
		if($mode==1 || $mode==3){
			$nextMode = $t;
		}
		
		if(isset($this->params['url']['rcheat'])) if($this->params['url']['rcheat']==1) $reviewCheat = true;
		
		$this->Session->write('lastVisit', $id);
		if(!empty($this->data)){
			if(isset($this->data['Comment']['status'])){
				$adminActivity = array();
				$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
				$adminActivity['AdminActivity']['tsumego_id'] = $t['Tsumego']['id'];
				$adminActivity['AdminActivity']['file'] = $t['Tsumego']['num'];
				$adminActivity['AdminActivity']['answer'] = $this->data['Comment']['status'];
				$this->AdminActivity->save($adminActivity);
				$this->Comment->save($this->data, true);
			}elseif(isset($this->data['Comment']['modifyDescription'])){
				$adminActivity = array();
				$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
				$adminActivity['AdminActivity']['tsumego_id'] = $t['Tsumego']['id'];
				$adminActivity['AdminActivity']['file'] = 'description';
				$adminActivity['AdminActivity']['answer'] = 'Description: '.$this->data['Comment']['modifyDescription'].' '.$this->data['Comment']['modifyHint'];
				$t['Tsumego']['description'] = $this->data['Comment']['modifyDescription'];
				$t['Tsumego']['hint'] = $this->data['Comment']['modifyHint'];
				$t['Tsumego']['author'] = $this->data['Comment']['modifyAuthor'];
				
				$this->Tsumego->save($t, true);
				
				if($this->data['Comment']['deleteProblem']=='delete'){
					$adminActivity['AdminActivity']['answer'] = 'Problem deleted. ('.$t['Tsumego']['set_id'].'-'.$t['Tsumego']['id'].')';
					$adminActivity['AdminActivity']['file'] = '/delete';
				}
				$this->AdminActivity->save($adminActivity);
			}elseif(isset($this->data['Study'])){
				$study = $this->data['Study']['study1'].';'.$this->data['Study']['study2'].';'.$this->data['Study']['study3'].';'.$this->data['Study']['study4'];
				$t['Tsumego']['semeaiType'] = $this->data['Study']['studyCorrect'];
				$t['Tsumego']['part'] = $study;
				$this->Tsumego->save($t, true);
			}else{
				$this->Comment->create();
				$this->Comment->save($this->data, true);
			}
			$this->set('formRedirect', true);
		}
		
		if(isset($_SESSION['loggedInUser'])){if($_SESSION['loggedInUser']['User']['isAdmin']>0){
			$aad = $this->AdminActivity->find('first', array('order' => 'id DESC'));
			if($aad['AdminActivity']['file'] == '/delete'){
				$this->set('deleteProblem2', true);
			}
		}}
		
		if(isset($this->params['url']['favorite'])) $inFavorite = true;
		
		if(isset($this->params['url']['deleteComment'])){
			$deleteComment = $this->Comment->findById($this->params['url']['deleteComment']);
			if(isset($this->params['url']['changeComment'])){
				if($this->params['url']['changeComment']==1) $deleteComment['Comment']['status'] = 97;
				elseif($this->params['url']['changeComment']==2) $deleteComment['Comment']['status'] = 98;
				elseif($this->params['url']['changeComment']==3) $deleteComment['Comment']['status'] = 96;
			}else $deleteComment['Comment']['status'] = 99;
			$adminActivity = array();
			$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$adminActivity['AdminActivity']['tsumego_id'] = $t['Tsumego']['id'];
			$adminActivity['AdminActivity']['file'] = $t['Tsumego']['num'];
			$adminActivity['AdminActivity']['answer'] = $deleteComment['Comment']['status'];
			$this->AdminActivity->save($adminActivity);
			$this->Comment->save($deleteComment);
		}
		
		if(isset($_FILES['game'])){
			$errors= array();
			$file_name = $_FILES['game']['name'];
			$file_size =$_FILES['game']['size'];
			$file_tmp =$_FILES['game']['tmp_name'];
			$file_type=$_FILES['game']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['game']['name'])));
			$extensions= array("sgf");

			if(in_array($file_ext,$extensions)=== false){
			 $errors[]="Only SGF files are allowed.";
			}

			if($file_size > 2097152){
			 $errors[]='The file is too large.';
			}

			$cox = count($this->Comment->find('all', array('conditions' => (array('tsumego_id' => $id)))));
			if(empty($fSet['Set']['title2'])) $title2 = '';
			else $title2 = '-';
			$file_name = $fSet['Set']['title'].$title2.$fSet['Set']['title2'].'-'.$t['Tsumego']['num'].'-'.$cox.'.sgf';

			$sgfComment = array();
			$this->Comment->create();
			$sgfComment['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$sgfComment['tsumego_id'] = $t['Tsumego']['id'];
			$file_name = str_replace('#', 'num', $file_name); 
			$sgfComment['message'] = '<a href="/files/ul1/'.$file_name.'">SGF</a>';
			$sgfComment['created'] = date('Y-m-d H:i:s');
			$this->Comment->save($sgfComment);

			if(empty($errors)==true){
			  $uploadfile = $_SERVER['DOCUMENT_ROOT'].'/app/webroot/files/ul1/'.$file_name;
			 move_uploaded_file($file_tmp, $uploadfile);
			}else{
			 print_r($errors);
			}
		}
		
		if(isset($_FILES['adminUpload'])){
			$errors= array();
			$file_name = $_FILES['adminUpload']['name'];
			$file_size =$_FILES['adminUpload']['size'];
			$file_tmp =$_FILES['adminUpload']['tmp_name'];
			$file_type=$_FILES['adminUpload']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['adminUpload']['name'])));
			$extensions= array("sgf");

			if(in_array($file_ext,$extensions)=== false) $errors[]="Only SGF files are allowed.";
			if($file_size > 2097152) $errors[]='The file is too large.';
			$fSet = $this->Set->find('first', array('conditions' => array('id' => $t['Tsumego']['set_id'])));
			
			$this->AdminActivity->create();
			$adminActivity = array();
			$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$adminActivity['AdminActivity']['tsumego_id'] = $t['Tsumego']['id'];
			$adminActivity['AdminActivity']['file'] = $t['Tsumego']['num'];
			$adminActivity['AdminActivity']['answer'] = $file_name;
			$this->AdminActivity->save($adminActivity);

			$t['Tsumego']['variance'] = 0;
			$this->Tsumego->save($t, true);

			if(empty($errors)==true){
				$uploadfile = $_SERVER['DOCUMENT_ROOT'].'/app/webroot/6473k339312/'.$fSet['Set']['folder'].'/'.$t['Tsumego']['num'].'.sgf';
				move_uploaded_file($file_tmp, $uploadfile);
			}else{
				print_r($errors);
			}
		}
		
		$t['Tsumego']['difficulty'] = ceil($t['Tsumego']['difficulty']*$fSet['Set']['multiplier']);
		
		if(isset($_SESSION['loggedInUser'])){
			unset($_SESSION['noUser']);
			unset($_SESSION['noLogin']);
			unset($_SESSION['noLoginStatus']);
			if(isset($_COOKIE['sandbox']) && $_COOKIE['sandbox']!='0'){
				$ux = $this->User->findById($_SESSION['loggedInUser']['User']['id']);
				$ux['User']['reuse1'] = $_COOKIE['sandbox'];
				$_SESSION['loggedInUser']['User']['reuse1'] = $_COOKIE['sandbox'];
				$this->User->save($ux);
			}
		}else{
			if(isset($_SESSION['noLogin'])){
				$noLogin = $_SESSION['noLogin'];
				$noLoginStatus = $_SESSION['noLoginStatus'];
				if(!in_array($t['Tsumego']['id'], $noLogin)){
					array_push($noLogin, $t['Tsumego']['id']);
					array_push($noLoginStatus, 'V');
				}
				$_SESSION['noLogin'] = $noLogin;
				$_SESSION['noLoginStatus'] = $noLoginStatus;
			}else{
				$_SESSION['noLogin'] = array($id);
				$_SESSION['noLoginStatus'] = array('V');
			}
			$u['User'] = array();
			$u['User']['id'] = 33;
			$u['User']['name'] = 'noUser';
			$u['User']['level'] = 1;
			$u['User']['mode'] = 0;
			$u['User']['elo_rating_mode'] = 100;
			$u['User']['xp'] = 0;
			$u['User']['nextlvl'] = 1000;
			$u['User']['health'] = 10;
			
			if(isset($_SESSION['noUser'])){
				$noUser = $_SESSION['noUser'];
				$u['User']['damage'] =  $_SESSION['noUser']['damage'];
			}else{
				$noUser = array('id' => 33, 'level' => 1, 'xp' => 0, 'nextlvl' => 50, 'health' => 10, 'damage' => 0);
				$u['User']['damage'] = 0;
				$_SESSION['noUser'] = $noUser;
			}
		}
		
		if(isset($_COOKIE['skip']) && $_COOKIE['skip'] != '0'){
			$u['User']['readingTrial']--;	
			unset($_COOKIE['skip']);
		}
		
		$sandboxSets = $this->Set->find('all', array('conditions' => array('public' => 0)));
		for($i=0; $i<count($sandboxSets); $i++){
			if($t['Tsumego']['set_id'] == $sandboxSets[$i]['Set']['id']) $isSandbox = true;
		}
		if($t['Tsumego']['set_id'] == 161) $isSandbox = false;
		
		$co = $this->Comment->find('all', array('conditions' => (array('tsumego_id' => $id))));
		$counter1 = 1;
		for($i=0; $i<count($co); $i++){
			$cou = $this->User->findById($co[$i]['Comment']['user_id']);
			$co[$i]['Comment']['user'] = $cou['User']['name'];
			$cad = $this->User->findById($co[$i]['Comment']['admin_id']);
			if($cad!=null){
				if($cad['User']['id'] == 73) $cad['User']['name'] = 'Admin';
				$co[$i]['Comment']['admin'] = $cad['User']['name'];
			}
			$date = new DateTime($co[$i]['Comment']['created']);
			$month = date("F", strtotime($co[$i]['Comment']['created']));
			$tday = $date->format('d. ');
			$tyear = $date->format('Y');
			$tClock = $date->format('H:i');
			if($tday[0]==0) $tday = substr($tday, -3);
			$co[$i]['Comment']['created'] = $tday.$month.' '.$tyear.'<br>'.$tClock;
			$array = $this->commentCoordinates($co[$i]['Comment']['message'], $counter1, true);
			$co[$i]['Comment']['message'] = $array[0];
			array_push($commentCoordinates, $array[1]);
			$counter1++;
			$array = $this->commentCoordinates($co[$i]['Comment']['status'], $counter1, true);
			$co[$i]['Comment']['status'] = $array[0];
			array_push($commentCoordinates, $array[1]);
			$counter1++;
		}
		if($mode==1){
			if(isset($_SESSION['loggedInUser']) && !isset($_SESSION['noLogin'])){
				$allUts = $this->TsumegoStatus->find('all', array('conditions' => array('user_id' => $u['User']['id'])));
				$idMap = array();
				$statusMap = array();
				for($i=0; $i<count($allUts); $i++){
					array_push($idMap, $allUts[$i]['TsumegoStatus']['tsumego_id']);
					array_push($statusMap, $allUts[$i]['TsumegoStatus']['status']);
				}
				$ut = $this->findUt($id, $allUts, $idMap);
			}else{
				$allUts = null;
				$ut = null;
			}
		}elseif($mode==2){
			$allUts1 = $this->TsumegoStatus->find('first', array('conditions' => array('user_id' => $u['User']['id'], 'tsumego_id' => $t['Tsumego']['id'])));
			$_SESSION['loggedInUser']['User']['mode'] = 2;
			$allUts = array();
			$allUts2 = array();
			$allUts2['TsumegoStatus']['id'] = 59;
			$allUts2['TsumegoStatus']['user_id'] = 72;
			$allUts2['TsumegoStatus']['tsumego_id'] = 572;
			$allUts2['TsumegoStatus']['status'] = 'V';
			$allUts2['TsumegoStatus']['created'] = '2018-02-07 16:35:10';
			array_push($allUts, $allUts1);
			array_push($allUts, $allUts2);
			$ut = $allUts[0];
			
			$old_u = array();
			$old_u['old_r'] = $u['User']['elo_rating_mode'];
			$old_u['old_rd'] = $u['User']['rd'];
			$old_t = array();
			$old_t['old_r'] = $t['Tsumego']['elo_rating_mode'];
			$old_t['old_rd'] = $t['Tsumego']['rd'];
			
			$ratingDeviationArray = $this->compute_rating($old_u, $old_t, 0);
			
			$diff = $t['Tsumego']['elo_rating_mode'] - $u['User']['elo_rating_mode'];
			if($diff<=-600) $diff = -595;
			$newV = (($diff-$oldmin)/($oldmax-$oldmin))*($newmax-$newmin);
			
			$this->set('diff', $diff);
			$this->set('newV', $newV);
			$this->set('ratingDeviationArray', $ratingDeviationArray);
			
			$eloScore = round($ratingDeviationArray[0][1]*$newV);
			if($eloScore<1) $eloScore = 1;
			
			if(!in_array($t['Tsumego']['id'], $recentlyPlayed)){
				$tr = array();
				$this->TsumegoRatingAttempt->create();
				$tr['TsumegoRatingAttempt']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
				$tr['TsumegoRatingAttempt']['tsumego_id'] = $t['Tsumego']['id'];
				$tr['TsumegoRatingAttempt']['status'] = 'V';
				$tr['TsumegoRatingAttempt']['user_elo'] = $_SESSION['loggedInUser']['User']['elo_rating_mode'];
				$tr['TsumegoRatingAttempt']['tsumego_elo'] = $t['Tsumego']['elo_rating_mode'];
				$this->TsumegoRatingAttempt->save($tr);
				$noTr = true;
			}
		}elseif($mode==3){
			$allUts1 = $this->TsumegoStatus->find('first', array('conditions' => array('user_id' => $u['User']['id'], 'tsumego_id' => $t['Tsumego']['id'])));
			$allUts = array();
			$allUts2 = array();
			$allUts2['TsumegoStatus']['id'] = 59;
			$allUts2['TsumegoStatus']['user_id'] = 72;
			$allUts2['TsumegoStatus']['tsumego_id'] = 572;
			$allUts2['TsumegoStatus']['status'] = 'V';
			$allUts2['TsumegoStatus']['created'] = '2018-02-07 16:35:10';
			array_push($allUts, $allUts1);
			array_push($allUts, $allUts2);
			$ut = $allUts[0];
		}
		
		if(isset($ut['TsumegoStatus']['status'])){
			if($ut['TsumegoStatus']['status']=='G') $goldenTsumego = true;
		}
		if(isset($_COOKIE['preId'])){
			$preTsumego = $this->Tsumego->findById($_COOKIE['preId']);
			$utPre = $this->findUt($_COOKIE['preId'], $allUts, $idMap);
			if($_COOKIE['preId']==$id){
				if($refresh==null) $refresh = 8;
			}				
		}else $utPre = $this->findUt(15352, $allUts, $idMap);
		
		if($mode==1 || $mode==3){
			if(isset($_COOKIE['preId']) && $_COOKIE['preId']==$t['Tsumego']['id']){
				if($_COOKIE['score']!=0){
					$_COOKIE['score'] = $this->decrypt($_COOKIE['score']);
					$scoreArr = explode('-', $_COOKIE['score']);
					$isNum = $preTsumego['Tsumego']['num']==$scoreArr[0];
					$isSet = $preTsumego['Tsumego']['set_id']==$scoreArr[2];
					if($isNum && $isSet) $ut['TsumegoStatus']['status'] = 'S';
				}				
				if($_COOKIE['misplay']!=0){
					if($u['User']['damage']+$_COOKIE['misplay'] > $u['User']['health']){
						if($utPre['TsumegoStatus']['status']!='W') $ut['TsumegoStatus']['status'] = 'F';
						else $ut['TsumegoStatus']['status'] = 'X';
					}	
				}
			}
		}elseif($mode==2){
			if(isset($_COOKIE['preId']) && $_COOKIE['preId']==$t['Tsumego']['id']){
			}
		}
		if($mode==3){
			$mode3Score1 = $this->encrypt($t['Tsumego']['num'].'-solved-'.$t['Tsumego']['set_id']);
			$mode3Score2 = $this->encrypt($t['Tsumego']['num'].'-failed-'.$t['Tsumego']['set_id']);
			$mode3Score3 = $this->encrypt($t['Tsumego']['num'].'-timeout-'.$t['Tsumego']['set_id']);
			$mode3Score4 = $this->encrypt($t['Tsumego']['num'].'-skipped-'.$t['Tsumego']['set_id']);
			array_push($mode3ScoreArray, $mode3Score1);
			array_push($mode3ScoreArray, $mode3Score2);
			array_push($mode3ScoreArray, $mode3Score3);
			array_push($mode3ScoreArray, $mode3Score4);
		}
		
		
		$favorite = $this->Favorite->find('first', array('conditions' => array('user_id' => $u['User']['id'], 'tsumego_id' => $id)));
		
		if(isset($_COOKIE['favorite']) && $_COOKIE['favorite'] != '0'){
			if(isset($_SESSION['loggedInUser'])){
				if($_COOKIE['favorite']>0){
					$fav = $this->Favorite->find('first', array('conditions' => array('user_id' => $u['User']['id'], 'tsumego_id' => $_COOKIE['favorite'])));
					if($fav==null){
						$fav = array();
						$fav['Favorite']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
						$fav['Favorite']['tsumego_id'] = $_COOKIE['favorite'];
						$fav['Favorite']['created'] = date('Y-m-d H:i:s');
						$this->Favorite->create();
						$this->Favorite->save($fav);
					}
				}else{
					$favId = $_COOKIE['favorite'] * -1;
					$favDel = $this->Favorite->find('first', array('conditions' => array('user_id' => $u['User']['id'], 'tsumego_id' => $favId)));
					$this->Favorite->delete($favDel['Favorite']['id']);
				}
				unset($_COOKIE['favorite']);
			}
		}
		
		if(isset($_COOKIE['sound']) && $_COOKIE['sound'] != '0'){
			$_SESSION['loggedInUser']['User']['sound'] = $_COOKIE['sound'];
			$u['User']['sound'] = $_COOKIE['sound'];
			unset($_COOKIE['sound']);
		}
		
		if(isset($_COOKIE['rank']) && $_COOKIE['rank'] != '0'){
			$drCookie = $this->decrypt($_COOKIE['rank']);
			$drCookie2 = explode('-', $drCookie);
			$_COOKIE['rank'] = $drCookie2[1];
		}
		
		//Incorrect
		if(isset($_COOKIE['misplay']) && $_COOKIE['misplay'] != 0){
			if($_COOKIE['misplay']<0 && $mode!=3){
				if($u['User']['usedRejuvenation'] == 0){
					$u['User']['damage'] += $_COOKIE['misplay'];
					$u['User']['rejuvenation'] = 0;
					$rejuvenation = true;
				}					
			}else{
				if($mode==1 && $u['User']['id']!=33){
					if(isset($_SESSION['loggedInUser']['User']['id'])){
						$this->TsumegoAttempt->create();
						$ur1 = array();

						$ur1['TsumegoAttempt']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
						$ur1['TsumegoAttempt']['tsumego_id'] = $_COOKIE['preId'];
						$ur1['TsumegoAttempt']['gain'] = 0;
						$ur1['TsumegoAttempt']['seconds'] = $_COOKIE['seconds'];
						$ur1['TsumegoAttempt']['solved'] = '0';
						$ur1['TsumegoAttempt']['misplays'] = $_COOKIE['misplay'];
						$this->TsumegoAttempt->save($ur1);

					}
				}
				if($mode==1 || $mode==3){
					if($mode==1) $u['User']['damage'] += $_COOKIE['misplay'];
					
					if(isset($_COOKIE['rank']) && $_COOKIE['rank'] != '0'){
						$ranks = $this->Rank->find('all', array('conditions' =>  array('session' => $_SESSION['loggedInUser']['User']['activeRank'])));
						$currentNum = $ranks[0]['Rank']['currentNum'];
						for($i=0; $i<count($ranks); $i++){
							if($ranks[$i]['Rank']['num'] == $currentNum-1){
								$ranks[$i]['Rank']['result'] = $_COOKIE['rank'];
								$ranks[$i]['Rank']['seconds'] = $_COOKIE['seconds']/10/$_COOKIE['preId'];
								$this->Rank->save($ranks[$i]);
							}
						}
					}
				}elseif($mode==2){
					$userEloBefore = $u['User']['elo_rating_mode'];
					$tsumegoEloBefore = $preTsumego['Tsumego']['elo_rating_mode'];
					$newV = 1;
					
					if($u['User']['elo_rating_mode']-$_COOKIE['misplay'] < 100) $u['User']['elo_rating_mode'] = 100;
					else $u['User']['elo_rating_mode'] -= $_COOKIE['misplay'];
					if(isset($_COOKIE['preId'])){
						$u = $this->compute_initial_user_rd($u);
						//$this->compute_initial_user_rd($t);
						$old_u = array();
						$old_u['old_r'] = $u['User']['elo_rating_mode'];
						$old_u['old_rd'] = $u['User']['rd'];
						$old_t = array();
						$old_t['old_r'] = $preTsumego['Tsumego']['elo_rating_mode'];
						$old_t['old_rd'] = $preTsumego['Tsumego']['rd'];
						$ratingDeviationArray = $this->compute_rating($old_u, $old_t, 0);
						$u['User']['rd'] = round($ratingDeviationArray[0][1]);
						$preTsumego['Tsumego']['elo_rating_mode'] += round($ratingDeviationArray[1][1]);
						$trFail = $this->TsumegoRatingAttempt->find('first', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'], 'tsumego_id' => $t['Tsumego']['id'])));
						$trFail['TsumegoRatingAttempt']['status'] = 'F';
						$trFail['TsumegoRatingAttempt']['user_id'] = $u['User']['id'];
						$trFail['TsumegoRatingAttempt']['user_elo'] = $u['User']['elo_rating_mode'];
						$trFail['TsumegoRatingAttempt']['user_deviation'] = $ratingDeviationArray[0][1];
						$trFail['TsumegoRatingAttempt']['tsumego_id'] = $preTsumego['Tsumego']['id'];
						$trFail['TsumegoRatingAttempt']['tsumego_elo'] = $tsumegoEloBefore;
						$trFail['TsumegoRatingAttempt']['tsumego_deviation'] = round($ratingDeviationArray[1][1]);
						$trFail['TsumegoRatingAttempt']['seconds'] = $_COOKIE['seconds'];
						if(isset($_COOKIE['sequence']) && $_COOKIE['sequence'] != 0) $trFail['TsumegoRatingAttempt']['sequence'] = $_COOKIE['sequence'];
						
						$this->Tsumego->save($preTsumego);
						$this->TsumegoRatingAttempt->save($trFail);
					}
				}
			}
			if($u['User']['damage']>$u['User']['health']){
				if($utPre==null){
					$utPre['TsumegoStatus'] = array();
					$utPre['TsumegoStatus']['user_id'] = $u['User']['id'];
					$utPre['TsumegoStatus']['tsumego_id'] = $_COOKIE['preId'];
				}
				
				if($utPre['TsumegoStatus']['status']=='W') $utPre['TsumegoStatus']['status'] = 'X';//W => X
				else if($utPre['TsumegoStatus']['status']=='V') $utPre['TsumegoStatus']['status'] = 'F';// V => F
				else if($utPre['TsumegoStatus']['status']=='G') $utPre['TsumegoStatus']['status'] = 'F';// G => F
				else if($utPre['TsumegoStatus']['status']=='S') $utPre['TsumegoStatus']['status'] = 'S';//S => S
				
				$utPre['TsumegoStatus']['created'] = date('Y-m-d H:i:s');
				
				if(isset($_SESSION['loggedInUser'])){
					if(!isset($utPre['TsumegoStatus']['status'])) $utPre['TsumegoStatus']['status'] = 'V';
					$this->TsumegoStatus->save($utPre);
					$preUt = array_search($utPre['TsumegoStatus']['tsumego_id'], $idMap);
					$allUts[$preUt]['TsumegoStatus']['status'] = $utPre['TsumegoStatus']['status'];
					
					if($_SESSION['loggedInUser']['User']['premium']>0 || $_SESSION['loggedInUser']['User']['level']>=50){
						if($u['User']['potion']!=-69){
							$_SESSION['loggedInUser']['User']['potion']++;
							$u['User']['potion']++;
							$potion = $_SESSION['loggedInUser']['User']['potion'];
							$potionPercent = 0;
							$potionPercent2 = 0;
							$potionSuccess = false;
							if($potion>=5){
								$potionPercent = $potion*.5;
								$potionPercent2 = rand(0,100);
								$potionSuccess = $potionPercent>$potionPercent2;
							}
							if($potionSuccess){
								$u['User']['usedRejuvenation'] = 0;
								$u['User']['potion'] = -69;
							}
						}
					}
				}
				$u['User']['damage'] = $u['User']['health'];
				if(!isset($_SESSION['loggedInUser'])){
					for($i=0; $i<count($noLogin); $i++){
						if($noLogin[$i]==$_COOKIE['preId']){
							$noLoginStatus[$i] = 'F';
							$_SESSION['noLoginStatus'] = $noLoginStatus;
						}				
					}
				}
			}
			$noUser['damage'] = $u['User']['damage'];
			unset($_COOKIE['misplay']);
			unset($_COOKIE['sequence']);
		}
		//Correct!
		if(isset($_COOKIE['score']) && $_COOKIE['score'] != '0'){
			$_COOKIE['score'] = $this->decrypt($_COOKIE['score']);
			$scoreArr = explode('-', $_COOKIE['score']);
			$isNum = $preTsumego['Tsumego']['num']==$scoreArr[0];
			$isSet = $preTsumego['Tsumego']['set_id']==$scoreArr[2];
			$_COOKIE['score'] = $scoreArr[1];
			if($isNum && $isSet){
				if($mode==1 || $mode==3){
					if(isset($_SESSION['loggedInUser']) && !isset($_SESSION['noLogin'])){
						$exploit = $this->UserBoard->find('first', array('conditions' => array('user_id' => $u['User']['id'], 'b1' => $_COOKIE['preId'])));
						$ub = array();
						$ub['UserBoard']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
						$ub['UserBoard']['b1'] = $_COOKIE['preId'];
						$this->UserBoard->create();
						$this->UserBoard->save($ub);
						
						$tPre = $this->Tsumego->find('first', array('conditions' => array('id' => $_COOKIE['preId'])));
						
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
					
					if($mode==3){
						$exploit=null;
						$suspiciousBehavior=false;
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
								$noUser['xp'] = $u['User']['xp']; 
								$noUser['level'] = $u['User']['level'];
								$noUser['nextlvl'] = $u['User']['nextlvl'];
								$noUser['health'] = $u['User']['health'];
								$_SESSION['loggedInUser']['User']['level'] = $u['User']['level'];
							}else{
								$u['User']['xp'] = $xpOld;
								$u['User']['ip'] = $_SERVER['REMOTE_ADDR'];
								$noUser['xp'] = $u['User']['xp'];
							}
						}
						if($mode==1 && $u['User']['id']!=33){
							if(isset($_SESSION['loggedInUser']['User']['id'])){
								$this->TsumegoAttempt->create();
								$ur = array();
								
								$ur['TsumegoAttempt']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
								$ur['TsumegoAttempt']['tsumego_id'] = $_COOKIE['preId'];
								$ur['TsumegoAttempt']['gain'] = $_COOKIE['score'];
								$ur['TsumegoAttempt']['seconds'] = $_COOKIE['seconds'];
								$ur['TsumegoAttempt']['solved'] = '1';
								$this->TsumegoAttempt->save($ur);
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
					}else{
					}
					if(isset($_SESSION['noLogin'])){
						for($i=0; $i<count($noLogin); $i++){
							if($noLogin[$i]==$_COOKIE['preId']){
								$noLoginStatus[$i] = 'S';
								$_SESSION['noLoginStatus'] = $noLoginStatus;
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
						$preUt = array_search($utPre['TsumegoStatus']['tsumego_id'], $idMap);
						$allUts[$preUt]['TsumegoStatus']['status'] = $utPre['TsumegoStatus']['status'];
					}
				}elseif($mode==2 && $_COOKIE['transition']!=1){
					$userEloBefore = $u['User']['elo_rating_mode'];
					$tsumegoEloBefore = $preTsumego['Tsumego']['elo_rating_mode'];
					$diff = $preTsumego['Tsumego']['elo_rating_mode'] - $u['User']['elo_rating_mode'];
					$newV = (($diff-$oldmin)/($oldmax-$oldmin))*($newmax-$newmin);
					
					$u = $this->compute_initial_user_rd($u);
					//$this->compute_initial_user_rd($t);
					$old_u = array();
					$old_u['old_r'] = $u['User']['elo_rating_mode'];
					$old_u['old_rd'] = $u['User']['rd'];
					$old_t = array();
					$old_t['old_r'] = $preTsumego['Tsumego']['elo_rating_mode'];
					$old_t['old_rd'] = $preTsumego['Tsumego']['rd'];
					$ratingDeviationArray = $this->compute_rating($old_u, $old_t, 1);
					$u['User']['rd'] = round($ratingDeviationArray[0][1]);
					
					if(intval($_COOKIE['score']>100)) $_COOKIE['score'] = 100;
					if($_COOKIE['seconds']>0){
						$u['User']['elo_rating_mode'] += intval($_COOKIE['score']);
						$user_deviation = intval($_COOKIE['score']);
					}else{
						$user_deviation = 0;
					}
					
					$u['User']['solved2']++; 
					$trSuccess = $this->TsumegoRatingAttempt->find('first', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'], 'tsumego_id' => $t['Tsumego']['id'])));
					$trSuccess['TsumegoRatingAttempt']['status'] = 'S';
					$trSuccess['TsumegoRatingAttempt']['user_id'] = $u['User']['id'];
					$trSuccess['TsumegoRatingAttempt']['user_elo'] = $u['User']['elo_rating_mode'];
					$trSuccess['TsumegoRatingAttempt']['user_deviation'] = $user_deviation;
					$trSuccess['TsumegoRatingAttempt']['tsumego_id'] = $preTsumego['Tsumego']['id'];
					$trSuccess['TsumegoRatingAttempt']['tsumego_elo'] = $tsumegoEloBefore;
					$trSuccess['TsumegoRatingAttempt']['tsumego_deviation'] = round($ratingDeviationArray[1][1]);
					$trSuccess['TsumegoRatingAttempt']['seconds'] = $_COOKIE['seconds'];
					$trSuccess['TsumegoRatingAttempt']['sequence'] = $_COOKIE['sequence'];
					$this->Tsumego->save($preTsumego);
					$this->TsumegoRatingAttempt->save($trSuccess);
				}
			}else{
				$u['User']['penalty'] += 1;
			}
			unset($_COOKIE['score']);
			unset($_COOKIE['preId']);
			unset($_COOKIE['transition']);
			unset($_COOKIE['sequence']);
		}
		
		if(isset($_COOKIE['correctNoPoints']) && $_COOKIE['correctNoPoints'] != '0'){
			if($u['User']['id']!=33){
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
		
		if(isset($_COOKIE['doublexp']) && $_COOKIE['doublexp'] != '0'){
			if($u['User']['usedSprint']==0){
				$doublexp = $_COOKIE['doublexp'];
			}
			unset($_COOKIE['doublexp']);
		}
		
		if(isset($_COOKIE['sprint']) && $_COOKIE['sprint'] != '0'){
			$u['User']['sprint'] = 0;
			if($_COOKIE['sprint']==1) $this->set('sprintActivated', true);
			if($_COOKIE['sprint']==2) $u['User']['usedSprint'] = 1;
			unset($_COOKIE['sprint']);
		}
		if(isset($_COOKIE['intuition']) && $_COOKIE['intuition'] != '0'){
			if($_COOKIE['intuition']=='1') $u['User']['intuition'] = 0;
			if($_COOKIE['intuition']=='2') $u['User']['intuition'] = 1;
			unset($_COOKIE['intuition']);
		}
		if(isset($_COOKIE['rejuvenation']) && $_COOKIE['rejuvenation'] != '0'){
			$u['User']['rejuvenation'] = 0;
			$u['User']['usedRejuvenation'] = 1;
			unset($_COOKIE['rejuvenation']);
		}
		
		if(isset($_COOKIE['extendedSprint']) && $_COOKIE['extendedSprint'] != '0'){
			$u['User']['penalty'] += 1;
			unset($_COOKIE['extendedSprint']);
		}
		
		if(isset($_COOKIE['refinement']) && $_COOKIE['refinement'] != '0'){
			if($_COOKIE['refinement']>0){
				if($u['User']['usedRefinement']==0){
					$refinementUT = $this->findUt($id, $allUts, $idMap);
					if($refinementUT==null){
						$this->TsumegoStatus->create();
						$refinementUT['TsumegoStatus']['user_id'] = $u['User']['id'];
						$refinementUT['TsumegoStatus']['tsumego_id'] = $id;
					}
					$refinementUT['TsumegoStatus']['created'] = date('Y-m-d H:i:s');
					$refinementUT['TsumegoStatus']['status'] = 'G';
					$this->TsumegoStatus->save($refinementUT);
					if(empty($ut)) $ut = $refinementUT;
					else $ut['TsumegoStatus']['status'] = 'G';
					$goldenTsumego = true;
					$u['User']['usedRefinement'] = 1;
				}
			}else{
				$resetRefinement = $this->findUt($id, $allUts, $idMap);
				if($resetRefinement!=null){
					$resetRefinement['TsumegoStatus']['status'] = 'V';
					$this->TsumegoStatus->save($resetRefinement);
				}
				if(empty($ut)) $ut = $resetRefinement;
				else $ut['TsumegoStatus']['status'] = 'V';
				$goldenTsumego = false;
			}
			$u['User']['refinement'] = 0;
			unset($_COOKIE['refinement']);
		}
		
		if($rejuvenation){
			$utr = $this->TsumegoStatus->find('all', array('conditions' =>  array('status' => 'F', 'user_id' => $u['User']['id'])));
			for($i=0; $i<count($utr); $i++){
				$utr[$i]['TsumegoStatus']['status'] = 'V';
				$this->TsumegoStatus->create();
				$this->TsumegoStatus->save($utr[$i]);
			}
			$utrx = $this->TsumegoStatus->find('all', array('conditions' =>  array('status' => 'X', 'user_id' => $u['User']['id'])));
			for($j=0; $j<count($utrx); $j++){
				$utrx[$j]['TsumegoStatus']['status'] = 'W';
				$this->TsumegoStatus->create();
				$this->TsumegoStatus->save($utrx[$j]);
			}
		}
		
		if(isset($_COOKIE['reputation']) && $_COOKIE['reputation'] != '0'){
			$reputation = $_COOKIE['reputation'];
			$reputation = array();
			$reputation['Reputation']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$reputation['Reputation']['tsumego_id'] = abs($_COOKIE['reputation']);
			if($_COOKIE['reputation']>0) $reputation['Reputation']['value'] = 1;
			else $reputation['Reputation']['value'] = -1;
			$this->Reputation->create();
			$this->Reputation->save($reputation);
			unset($_COOKIE['reputation']);
		}
		
		$_SESSION['loggedInUser']['User']['activeRank'] = $u['User']['activeRank'];
		$_SESSION['loggedInUser']['User']['premium'] = $u['User']['premium'];
		$_SESSION['loggedInUser']['User']['completed'] = $u['User']['completed'];
		$_SESSION['loggedInUser']['User']['level'] = $u['User']['level'];
		$_SESSION['loggedInUser']['User']['secretArea1'] = $u['User']['secretArea1'];
		$_SESSION['loggedInUser']['User']['secretArea2'] = $u['User']['secretArea2'];
		$_SESSION['loggedInUser']['User']['secretArea3'] = $u['User']['secretArea3'];
		$_SESSION['loggedInUser']['User']['secretArea4'] = $u['User']['secretArea4'];
		$_SESSION['loggedInUser']['User']['secretArea5'] = $u['User']['secretArea5'];
		$_SESSION['loggedInUser']['User']['secretArea6'] = $u['User']['secretArea6'];
		$_SESSION['loggedInUser']['User']['secretArea7'] = $u['User']['secretArea7'];
		$_SESSION['loggedInUser']['User']['secretArea8'] = $u['User']['secretArea8'];
		$_SESSION['loggedInUser']['User']['secretArea9'] = $u['User']['secretArea9'];
		$_SESSION['loggedInUser']['User']['secretArea10'] = $u['User']['secretArea10'];
		
		if(isset($noUser)) $_SESSION['noUser'] = $noUser;
		if(isset($_SESSION['loggedInUser']) && $u['User']['id']!=33){
			$u['User']['mode'] = $_SESSION['loggedInUser']['User']['mode'];
			$u['User']['created'] = date('Y-m-d H:i:s');
			$this->User->save($u);
		}		
		
		if($mode==1 || $mode==3){
			if($ut==null && isset($_SESSION['loggedInUser'])){
				$this->TsumegoStatus->create();
				$ut['TsumegoStatus'] = array();
				$ut['TsumegoStatus']['user_id'] = $u['User']['id'];
				$ut['TsumegoStatus']['tsumego_id'] = $id;
				$ut['TsumegoStatus']['status'] = 'V';
				$this->TsumegoStatus->save($ut);
			}
		}elseif($mode==2){
			$ut['TsumegoStatus'] = array();
			$ut['TsumegoStatus']['user_id'] = $u['User']['id'];
			$ut['TsumegoStatus']['tsumego_id'] = $id;
			$ut['TsumegoStatus']['status'] = 'V';
		}
		
		$set = $this->Set->findById($t['Tsumego']['set_id']);
		$ts = $this->Tsumego->find('all', array('order' => 'num',	'direction' => 'DESC', 'conditions' =>  array('set_id' => $set['Set']['id'])));
		$anzahl = $ts[count($ts)-1]['Tsumego']['num'];
		$_SESSION['title'] = $set['Set']['title'].' '.$t['Tsumego']['num'].'/'.$anzahl.' on Tsumego Hero';
		
		$prev = 0;
		$next = 0;
		$tsBack = array();
		$tsNext = array();
		
		if(!$inFavorite){
			for($i=0; $i<count($ts); $i++){
				if($ts[$i]['Tsumego']['id'] == $t['Tsumego']['id']){
					$a = 5;
					while($a>0){
						if($i-$a >= 0){
							array_push($tsBack, $ts[$i-$a]);
							if($a==1) $prev = $ts[$i-$a]['Tsumego']['id'];
							$newUT = $this->findUt($ts[$i-$a]['Tsumego']['id'], $allUts, $idMap);
							if(!isset($newUT['TsumegoStatus']['status'])) $newUT['TsumegoStatus']['status'] = 'N';
							$tsBack[count($tsBack)-1]['Tsumego']['status'] = 'set'.$newUT['TsumegoStatus']['status'].'1';
						}
						$a--;
					}
					$bMax = 10 - count($tsBack);
					$b = 1;
					if($ts[0]['Tsumego']['id']==$t['Tsumego']['id']) $bMax++;
					while($b <= $bMax){
						if($i+$b < count($ts)){
							array_push($tsNext, $ts[$i+$b]);
							if($b==1) $next = $ts[$i+$b]['Tsumego']['id'];
							$newUT = $this->findUt($ts[$i+$b]['Tsumego']['id'], $allUts, $idMap);
							if(!isset($newUT['TsumegoStatus']['status'])) $newUT['TsumegoStatus']['status'] = 'N';
							$tsNext[count($tsNext)-1]['Tsumego']['status'] = 'set'.$newUT['TsumegoStatus']['status'].'1';
						}
						$b++;
					}
					if(count($tsNext)<5 || $t['Tsumego']['id'] == $ts[count($ts)-6]['Tsumego']['id']){
						$tsBack = array();
						$a = 5 + (5-count($tsNext));
						$a++;
						while($a > 0){
							if($i-$a >= 0){
								array_push($tsBack, $ts[$i-$a]);
								if($a==1) $prev = $ts[$i-$a]['Tsumego']['id'];
								$newUT = $this->findUt($ts[$i-$a]['Tsumego']['id'], $allUts, $idMap);
								if(!isset($newUT['TsumegoStatus']['status'])) $newUT['TsumegoStatus']['status'] = 'N';
								$tsBack[count($tsBack)-1]['Tsumego']['status'] = 'set'.$newUT['TsumegoStatus']['status'].'1';
							}
							$a--;
						}
					}
					if((count($tsBack)<5 || $t['Tsumego']['id'] == $ts[5]['Tsumego']['id']) && $ts[0]['Tsumego']['id']!=$t['Tsumego']['id']){
						$tsNextAdjust = count($tsNext) + 1;
						$tsNext = array();
						$b = 1;
						while($b <= $tsNextAdjust){
							if($i+$b < count($ts)){
								array_push($tsNext, $ts[$i+$b]);
								if($b==1) $next = $ts[$i+$b]['Tsumego']['id'];
								$newUT = $this->findUt($ts[$i+$b]['Tsumego']['id'], $allUts, $idMap);
								if(!isset($newUT['TsumegoStatus']['status'])) $newUT['TsumegoStatus']['status'] = 'N';
								$tsNext[count($tsNext)-1]['Tsumego']['status'] = 'set'.$newUT['TsumegoStatus']['status'].'1';
							}
							$b++;
						}
					}
				}
			}
			$inFavorite = '';
		}else{
			$fav = $this->Favorite->find('all', array('order' => 'created',	'direction' => 'DESC', 'conditions' =>  array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			$ts = array();
			for($i=0; $i<count($fav); $i++){
				$tx = $this->Tsumego->findById($fav[$i]['Favorite']['tsumego_id']);
				array_push($ts, $tx);
			}
			for($i=0; $i<count($ts); $i++){
				if($ts[$i]['Tsumego']['id'] == $t['Tsumego']['id']){
					$a = 5;
					while($a>0){
						if($i-$a >= 0){
							array_push($tsBack, $ts[$i-$a]);
							if($a==1) $prev = $ts[$i-$a]['Tsumego']['id'];
							$newUT = $this->findUt($ts[$i-$a]['Tsumego']['id'], $allUts, $idMap);
							if(!isset($newUT['TsumegoStatus']['status'])) $newUT['TsumegoStatus']['status'] = 'N';
							$tsBack[count($tsBack)-1]['Tsumego']['status'] = 'set'.$newUT['TsumegoStatus']['status'].'1';
						}
						$a--;
					}
					$bMax = 10 - count($tsBack);
					$b = 1;
					if($ts[0]['Tsumego']['id']==$t['Tsumego']['id']) $bMax++;
					while($b <= $bMax){
						if($i+$b < count($ts)){
							array_push($tsNext, $ts[$i+$b]);
							if($b==1) $next = $ts[$i+$b]['Tsumego']['id'];
							$newUT = $this->findUt($ts[$i+$b]['Tsumego']['id'], $allUts, $idMap);
							if(!isset($newUT['TsumegoStatus']['status'])) $newUT['TsumegoStatus']['status'] = 'N';
							$tsNext[count($tsNext)-1]['Tsumego']['status'] = 'set'.$newUT['TsumegoStatus']['status'].'1';
						}
						$b++;
					}
					if(count($tsNext)<5 || $t['Tsumego']['id'] == $ts[count($ts)-6]['Tsumego']['id']){
						$tsBack = array();
						$a = 5 + (5-count($tsNext));
						$a++;
						while($a > 0){
							if($i-$a >= 0){
								array_push($tsBack, $ts[$i-$a]);
								if($a==1) $prev = $ts[$i-$a]['Tsumego']['id'];
								$newUT = $this->findUt($ts[$i-$a]['Tsumego']['id'], $allUts, $idMap);
								if(!isset($newUT['TsumegoStatus']['status'])) $newUT['TsumegoStatus']['status'] = 'N';
								$tsBack[count($tsBack)-1]['Tsumego']['status'] = 'set'.$newUT['TsumegoStatus']['status'].'1';
							}
							$a--;
						}
					}
					if((count($tsBack)<5 || $t['Tsumego']['id'] == $ts[5]['Tsumego']['id']) && $ts[0]['Tsumego']['id']!=$t['Tsumego']['id']){
						$tsNextAdjust = count($tsNext) + 1;
						$tsNext = array();
						$b = 1;
						while($b <= $tsNextAdjust){
							if($i+$b < count($ts)){
								array_push($tsNext, $ts[$i+$b]);
								if($b==1) $next = $ts[$i+$b]['Tsumego']['id'];
								$newUT = $this->findUt($ts[$i+$b]['Tsumego']['id'], $allUts, $idMap);
								if(!isset($newUT['TsumegoStatus']['status'])) $newUT['TsumegoStatus']['status'] = 'N';
								$tsNext[count($tsNext)-1]['Tsumego']['status'] = 'set'.$newUT['TsumegoStatus']['status'].'1';
							}
							$b++;
						}
					}
				}
			}
			$inFavorite = '?favorite=1';
		}
		$tsFirst = $ts[0];
		$isInArray = -1;
		for($i=0; $i<count($tsBack); $i++){
			if($tsBack[$i]['Tsumego']['id'] == $tsFirst['Tsumego']['id']) $isInArray = $i;
		}
		if($isInArray!=-1){
			unset($tsBack[$isInArray]);
			$tsBack = array_values($tsBack);
		}
		$newUT = $this->findUt($ts[0]['Tsumego']['id'], $allUts, $idMap);
		if(!isset($newUT['TsumegoStatus']['status'])) $newUT['TsumegoStatus']['status'] = 'N';
		$tsFirst['Tsumego']['status'] = 'set'.$newUT['TsumegoStatus']['status'].'1';;		
		if($t['Tsumego']['id'] == $tsFirst['Tsumego']['id']) $tsFirst = null;
		
		$tsLast = $ts[count($ts)-1];
		$isInArray = -1;
		for($i=0; $i<count($tsNext); $i++){
			if($tsNext[$i]['Tsumego']['id'] == $tsLast['Tsumego']['id']) $isInArray = $i;
		}
		if($isInArray!=-1){
			unset($tsNext[$isInArray]);
			$tsNext = array_values($tsNext);
		}
		$newUT = $this->findUt($ts[count($ts)-1]['Tsumego']['id'], $allUts, $idMap);
		if(!isset($newUT['TsumegoStatus']['status'])) $newUT['TsumegoStatus']['status'] = 'N';
		$tsLast['Tsumego']['status'] = 'set'.$newUT['TsumegoStatus']['status'].'1';
		if($t['Tsumego']['id'] == $tsLast['Tsumego']['id']) $tsLast = null;
		
		// current tsumego
		if(isset($_SESSION['loggedInUser'])){
			if(!isset($ut['TsumegoStatus']['status'])) $t['Tsumego']['status'] = 'V';
			$t['Tsumego']['status'] = 'set'.$ut['TsumegoStatus']['status'].'2';
			$half='';
			if($ut['TsumegoStatus']['status']=='W' || $ut['TsumegoStatus']['status']=='X'){
				$t['Tsumego']['difficulty'] = ceil($t['Tsumego']['difficulty']/2);
				$half='(1/2)';
			}	
		}else{
			$t['Tsumego']['status'] = 'setV2';
		}
		
		if(!isset($t['Tsumego']['file']) || $t['Tsumego']['file']=='') $t['Tsumego']['file'] = $t['Tsumego']['num'];
		$file = '6473k339312/'.$set['Set']['folder'].'/'.$t['Tsumego']['file'].'.sgf';
		if($t['Tsumego']['variance']==100) $file = '6473k339312/easycapture/1.sgf';
		
		$orientation = null;
		$colorOrientation = null;
		if(isset($this->params['url']['orientation'])) $orientation = $this->params['url']['orientation'];
		if(isset($this->params['url']['playercolor'])) $colorOrientation = $this->params['url']['playercolor'];
		
		$checkBSize = 19;
		for($i=2; $i<=19; $i++){
			if(strpos(';'.$set['Set']['title'], $i.'x'.$i)){
				$checkBSize = $i;
			}
		}
		
		$masterArrayBW = $this->processSGF(
			$file, 
			$t['Tsumego']['minLib'], 
			$t['Tsumego']['maxLib'], 
			$t['Tsumego']['variance'], 
			$t['Tsumego']['libertyCount'], 
			$t['Tsumego']['semeaiType'], 
			$t['Tsumego']['set_id'], 
			$orientation,
			$checkBSize
		);

		if(!isset($_SESSION['loggedInUser'])) $u['User'] = $noUser;
		
		$navi = array();
		array_push($navi, $tsFirst);
		for($i=0; $i<count($tsBack); $i++) array_push($navi, $tsBack[$i]);
		array_push($navi, $t);
		for($i=0; $i<count($tsNext); $i++) array_push($navi, $tsNext[$i]);
		array_push($navi, $tsLast);
		
		if($t['Tsumego']['set_id']==161){
			$joseki = $this->Joseki->find('first', array('conditions' =>  array('tsumego_id' => $t['Tsumego']['id'])));
			$josekiLevel = $joseki['Joseki']['hints'];
			for($i=0; $i<count($navi); $i++){
				$j = $this->Joseki->find('first', array('conditions' =>  array('tsumego_id' => $navi[$i]['Tsumego']['id'])));
				$navi[$i]['Tsumego']['type'] = $j['Joseki']['type'];
				$navi[$i]['Tsumego']['thumbnail'] = $j['Joseki']['thumbnail'];
				
			}
		}
		
		if(isset($_SESSION['noLogin'])){
			for($i=0; $i<count($navi); $i++){
				for($j=0; $j<count($noLogin); $j++){
					if($navi[$i]['Tsumego']['id'] == $noLogin[$j]){
						$navi[$i]['Tsumego']['status'] = 'set'.$noLoginStatus[$j].substr($navi[$i]['Tsumego']['status'], -1);
					}
				}
			}
			for($j=0; $j<count($noLogin); $j++){
				if($noLogin[$j]==$t['Tsumego']['id'] && ($noLoginStatus[$j]=='S' || $noLoginStatus[$j]=='W' || $noLoginStatus[$j]=='C')){
					$t['Tsumego']['status'] = 'setS2';
				}
				if($noLogin[$j]==$t['Tsumego']['id'] && $noLoginStatus[$j]=='F'){
					$t['Tsumego']['status'] = 'setF2';
				}
			}
		}
		if($u['User']['health']>=8){
			$fullHeart = 'heart1small';
			$emptyHeart = 'heart2small';
		}else{
			$fullHeart = 'heart1';
			$emptyHeart = 'heart2';
		}
		if(isset($_SESSION['loggedInUser'])){
			$this->set('sprintEnabled', $u['User']['sprint']);
			$this->set('intuitionEnabled', $u['User']['intuition']);
			$this->set('rejuvenationEnabled', $u['User']['rejuvenation']);
			$this->set('refinementEnabled', $u['User']['refinement']);
			$this->set('maxNoUserLevel', false);
			
			if($u['User']['reuse4']==0) $_SESSION['loggedInUser']['User']['reuse4'] = 0;
			if($_SESSION['loggedInUser']['User']['premium']>0) $_SESSION['loggedInUser']['User']['reuse4'] = 0;
			if($_SESSION['loggedInUser']['User']['reuse4']==1) $dailyMaximum = true;
			if($_SESSION['loggedInUser']['User']['reuse5']==1) $suspiciousBehavior = true;
		}else{
			if($noUser['level']>=10) $this->set('maxNoUserLevel', true);
			else $this->set('maxNoUserLevel', false);
		}
		if($isSandbox || $t['Tsumego']['set_id']==51){
			$this->set('sandboxXP', $t['Tsumego']['difficulty']);
			$t['Tsumego']['difficulty2'] = $t['Tsumego']['difficulty'];
			$t['Tsumego']['difficulty'] = 10;
		}
		
		if($goldenTsumego) $t['Tsumego']['difficulty'] *= 8;
		
		$or = array();
		$publicSets = $this->Set->find('all', array('conditions' => array('public' => 1)));
		for($i=0; $i<count($publicSets); $i++) array_push($or, $publicSets[$i]['Set']['id']);
		
		$gDifficulty = rand(4,8);
		$refinementT = $this->Tsumego->find('all', array('limit' => 1000, 'conditions' => array(
			'OR' => array('set_id' => $or),
			'NOT' => array(
				'set_id' => array(42, 113, 114, 115, 11969, 29156, 31813, 33007, 71790, 74761, 81578, 88156),
				'difficulty' => array(1, 2, 3)
			),
		)));
		
		$hasAnyFavorite = $this->Favorite->find('first', array('conditions' => array('user_id' => $u['User']['id'])));
		
		$folderString = $t['Tsumego']['num'].'number'.$set['Set']['folder'];
		$hash = $this->encrypt($folderString);
		
		$score1 = $t['Tsumego']['num'].'-'.$t['Tsumego']['difficulty'].'-'.$t['Tsumego']['set_id'];
		$score1 = $this->encrypt($score1);
		$t2 = $t['Tsumego']['difficulty']*2;
		$score2 = $t['Tsumego']['num'].'-'.$t2.'-'.$t['Tsumego']['set_id'];
		$score2 = $this->encrypt($score2);
		if($mode==2){
			if(!$noTr) $eloScore = 0;
			$score3 = $t['Tsumego']['num'].'-'.$eloScore.'-'.$t['Tsumego']['set_id'];
			$score3 = $this->encrypt($score3);
			$t2 = $eloScore*2;
			$score4 = $t['Tsumego']['num'].'-'.$t2.'-'.$t['Tsumego']['set_id'];
			$score4 = $this->encrypt($score4);
			$this->set('score3', $score3);
			$this->set('score4', $score4);
		}
		shuffle($refinementT);
		
		$activate = true;
		if(isset($_SESSION['loggedInUser'])){
			$rep = $this->Reputation->find('first', array('order' => 'id DESC','conditions' => array('tsumego_id' => $id, 'user_id' => $_SESSION['loggedInUser']['User']['id'])));
			$rep2 = $this->Reputation->find('all', array('order' => 'id DESC','conditions' => array('tsumego_id' => $id, 'user_id' => $_SESSION['loggedInUser']['User']['id'])));
			if(count($rep2>1)){
				for($i=1;$i<count($rep2);$i++){
					$this->Reputation->delete($rep2[$i]['Reputation']['id']);
				}
			}
			$this->set('rep', $rep);
			
			if($_SESSION['loggedInUser']['User']['premium']>0 || $_SESSION['loggedInUser']['User']['level']>=50){
				if($u['User']['potion']!=-69){
					if($u['User']['health']-$u['User']['damage']<=0) $potionActive = true;
				}
			}
		
			if(!isset($_SESSION['loggedInUser']['User']['id']) && isset($_SESSION['loggedInUser']['User']['premium'])){
				unset($_SESSION['loggedInUser']);
			}
			if($_SESSION['loggedInUser']['User']['isAdmin']<1) $ui = 1;
		}
		
		$admins = $this->User->find('all', array('conditions' => array('isAdmin' => 1)));
		if($mode==2 || $mode==3) $_SESSION['title'] = 'Tsumego Hero';
		if($isSandbox) $t['Tsumego']['userWin'] = 0;
		
		$crs = 0;
		if($mode==3){
			$t['Tsumego']['status'] = 'setV2';
			for($i=0;$i<count($ranks);$i++){
				if($ranks[$i]['Rank']['result']=='solved') $crs++;
			}
		}
		
		if(isset($this->params['url']['rank'])) $raName = $this->params['url']['rank'];
		else{
			if(!isset($ranks[0]['Rank']['rank'])) $ranks[0]['Rank']['rank'] = '';
			$raName = $ranks[0]['Rank']['rank'];
		}
		
		if($mode==1) $_SESSION['page'] = 'level mode';
		elseif($mode==2) $_SESSION['page'] = 'rating mode';
		elseif($mode==3) $_SESSION['page'] = 'time mode';
		
		//echo '<pre>'; print_r(($crs/$stopParameter)*100); echo '</pre>';
		//echo '<pre>'; print_r($choice); echo '</pre>';
		
		
		$this->set('raName', $raName);
		$this->set('crs', $crs);
		$this->set('admins', $admins);
		$this->set('refresh', $refresh);
		$this->set('anz', $anzahl);
		$this->set('showComment', $co);	
		$this->set('orientation', $orientation);
		$this->set('colorOrientation', $colorOrientation);
		$this->set('g', $refinementT[0]);
		$this->set('favorite', $favorite!=null);
		$this->set('hasAnyFavorite', $hasAnyFavorite!=null);
		$this->set('inFavorite', $inFavorite);
		$this->set('dailyMaximum', $dailyMaximum);
		$this->set('suspiciousBehavior', $suspiciousBehavior);
		$this->set('isSandbox', $isSandbox);
		$this->set('goldenTsumego', $goldenTsumego);
		$this->set('masterArray', $masterArrayBW[0]);
		$this->set('black', $masterArrayBW[1]);
		$this->set('white', $masterArrayBW[2]);
		$this->set('corner', $masterArrayBW[3]);
		$this->set('intuitionMove', $masterArrayBW[4]);
		$this->set('fullHeart', $fullHeart);
		$this->set('emptyHeart', $emptyHeart);
		$this->set('isSemeai', $masterArrayBW[5]);
		$this->set('blackSubtractedLiberties', $masterArrayBW[6]);
		$this->set('whiteSubtractedLiberties', $masterArrayBW[7]);
		$this->set('firstPlayer', $masterArrayBW[9]);
		$this->set('additionalInfo', $masterArrayBW[10]);
		$this->set('libertyCount', $t['Tsumego']['libertyCount']);
		$this->set('semeaiType', $t['Tsumego']['semeaiType']);
		$this->set('insideLiberties', $t['Tsumego']['insideLiberties']);
		$this->set('doublexp', $doublexp);
		$this->set('half', $half);
		$this->set('set', $set);
		$this->set('barPercent', $u['User']['xp']/$u['User']['nextlvl']*100);
		$this->set('user', $u);
		$this->set('t', $t);
		$this->set('score1', $score1);
		$this->set('score2', $score2);
		$this->set('navi', $navi);
		$this->set('prev', $prev);
		$this->set('next', $next);
		$this->set('hash', $hash);
		$this->set('nextMode', $nextMode);
		$this->set('mode', $mode);
		$this->set('rating', $u['User']['elo_rating_mode']);
		$this->set('eloScore', $eloScore);
		$this->set('activate', $activate);
		$this->set('tsumegoElo', $t['Tsumego']['elo_rating_mode']);
		$this->set('trs', $trs);
		$this->set('difficulty', $difficulty);
		$this->set('range', $range2);
		$this->set('potion', $potion);
		$this->set('potionSuccess', $potionSuccess);
		$this->set('potionActive', $potionActive);
		$this->set('visual', $masterArrayBW[11]);
		$this->set('visuals', $masterArrayBW[12]);
		$this->set('reviewCheat', $reviewCheat);
		$this->set('coordMarkers', $masterArrayBW[13]);
		$this->set('coordPlaces', $masterArrayBW[14]);
		$this->set('commentCoordinates', $commentCoordinates);
		$this->set('part', $t['Tsumego']['part']);
		$this->set('sT', $masterArrayBW[15]);
		$this->set('josekiLevel', $josekiLevel);
		$this->set('checkBSize', $checkBSize);
		$this->set('rankTs', $rankTs);
		$this->set('ranks', $ranks);
		$this->set('currentRank', $currentRank);
		$this->set('currentRankNum', $currentRankNum);
		$this->set('firstRanks', $firstRanks);
		$this->set('r10', $r10);
		$this->set('stopParameter', $stopParameter);
		$this->set('stopParameter2', $stopParameter2);
		$this->set('mode3ScoreArray', $mode3ScoreArray);
		$this->set('potionAlert', $potionAlert);
		$this->set('sgfErrorMessage', $masterArrayBW[16]);
		$this->set('file', $file);
		$this->set('ui', $ui);
    }
	
	private function findUt($id=null, $allUts=null, $map=null){
		$currentUt = array_search($id, $map);
		$ut = $allUts[$currentUt];
		if($currentUt==0) if($id!=$map[0]) $ut = null;
		return $ut;
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
	
	private function processSGF($file=null, $minLib=null, $maxLib=null, $variance=null, $libertyCount=null, $semeaiType=null, $setID=null, $orientation=null, $checkBSize=null){
		$alphabet1 = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		$alphabet2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		
		$black = array();
		$white = array();
		$cornerShuffle = array('tl', 'tr', 'bl', 'br');
		$cornerShuffle2 = array('t', 'b');
		$corner = array();
		$correctBranch;
		$correctMove = array();
		$visual = array();
		$vCorrect = array();
		$visuals = array();
		$blackLiberties = null;
		$whiteLiberties = null;
		$bMinus = '';
		$wMinus = '';
		$sT = array();
		$semeai = false;
		$setIDfullGame = false;
		$bMinus = '';
		$wMinus = '';
		$firstPlayer = '';
		$playerNames = array();
		$lastPlayed = array();
		$triangleMarker = array();
		$squareMarker = array();
		$additionalInfo = array();
		$saveText = array();
		$stIndex = 0;
		$playerNamesText = 0;
		$sgfErrorMessage = '';
		
		if(!file_exists($file)){
			$file = '6473k339312/Gokyo-Shumyo-4/153.sgf';
			$sgfErrorMessage = 'Error: File not found.';
		}
		//$sgfErrorMessage = 'Error: File not found.';
		
		$sgf = file_get_contents($file);
		$aw = strpos($sgf, 'AW');
		$ab = strpos($sgf, 'AB');
		$tr = strpos($sgf, 'TR');
		$sq = strpos($sgf, 'SQ');
		$seq1 = strpos($sgf, ';B');
		$seq2 = strpos($sgf, ';W');
		
		
		if($seq1==null) $sgfErrorMessage = 'Error: File conversion error.';
		//elseif(strpos($sgf, 'C[')<$seq1 && strpos($sgf, 'C[')!==0) $sgfErrorMessage = 'Error: File conversion error.';
		elseif($aw===0 || $ab===0) $sgfErrorMessage = 'Error: File conversion error.';
		
		if($sgfErrorMessage===''){
		
		$modifiedBSize = false;
		if($checkBSize!=19) $modifiedBSize = true;
		//fängt b oder w an
		
		if($setID==161){
			if($seq1<$seq2){
				if(strpos($sgf, ';B')-1 != strpos($sgf, '(;B')){
					$sgf = substr_replace($sgf, '(', strpos($sgf, ';B'), 0);
					$sgf .= ')';
				}
			}
			if($seq2<$seq1){
				if(strpos($sgf, ';W')-1 != strpos($sgf, '(;W')){
					$sgf = substr_replace($sgf, '(', strpos($sgf, ';W'), 0);
					$sgf .= ')';
				}
			}
		}
		if($seq1<$seq2) $firstPlayer = 'b';
		else $firstPlayer = 'w';
		if($seq1==null) $firstPlayer = 'w';
		if($seq2==null) $firstPlayer = 'b';
		//semeai
		$sequencesSign = strpos($sgf, ';B');
		
		if($setID==159 || $setID==161) $setIDfullGame = true;
		if(strpos($sgf, '#')) $semeai = true;
		if($semeai){
			if($setIDfullGame==false){
				$p1 = substr($sgf, 0, $aw);
				$p2 = substr($sgf, $aw, $ab-$aw);
				$p3 = substr($sgf, $ab, $tr-$ab);
				$p4 = substr($sgf, $tr, $sq-$tr);
				$p5 = substr($sgf, $sq, $sequencesSign-$sq);
				$p6 = substr($sgf, $sequencesSign);
				$sStatusB;
				$sStatusW;
				if($semeaiType == 1){
					$minLib += $variance;
					$maxLib -= $variance;
					$sStatusB = rand($minLib,$maxLib);
					$sStatusWmin = $sStatusB - $variance;
					$sStatusWmax = $sStatusB + $variance;
					$sStatusW = rand($sStatusWmin,$sStatusWmax);
				}
				else if($semeaiType == 2){
					$sStatusB = rand(0,$libertyCount);
					$sStatusW = rand(0,$libertyCount);
				}else if($semeaiType == 3){
					$minLib += $variance;
					$maxLib -= $variance;
					$sStatusB = rand($minLib,$maxLib);
					$sStatusWmin = $sStatusB - $variance;
					$sStatusWmax = $sStatusB + $variance;
					$sStatusW = rand($sStatusWmin,$sStatusWmax);
				}else if($semeaiType == 4){
					$sStatusB = rand(0,$variance);
					$sStatusW = rand(0,$variance);
				}else if($semeaiType == 5){
					$minLib += $variance;
					$maxLib -= $variance;
					$sStatusB = rand($minLib,$maxLib);
					$sStatusWmin = $sStatusB - $variance;
					$sStatusWmax = $sStatusB + $variance;
					$sStatusW = rand($sStatusWmin,$sStatusWmax);
				}else if($semeaiType == 6){
					$sStatusB = rand(0,$variance);
					$sStatusW = rand(0,$variance);
				}
				
				$bMinus = $sStatusB;
				$wMinus = $sStatusW;
				
				$trX = str_split(substr($p4, 2), 4);
				shuffle($trX);
				$pos = 0;
				while($sStatusB!=0){
					$p3 .= $trX[$pos];
					$pos++;
					$sStatusB--;
				}
				$sqX = str_split(substr($p5, 2), 4);
				for($i=0;$i<count($sqX);$i++){
					if(strlen($sqX[$i])<4) unset($sqX[$i]);
				}
				shuffle($sqX);
				$pos = 0;
				while($sStatusW!=0){
					$p2 .= $sqX[$pos];
					$pos++;
					$sStatusW--;
				}
				$sgf = $p1.$p2.$p3.' '.$p6;
				$aw = strpos($sgf, 'AW');
				$ab = strpos($sgf, 'AB');
			}
		}
		
		$sgfArr = str_split($sgf);
		
		//remove comments + markers
		/*kommentare aus dem sgfArr schreiben*/
		
		//echo '<pre>';print_r($sgfArr);echo '</pre>';
		//echo '<pre>';print_r(implode($sgfArr));echo '</pre>';
		
		for($i=0; $i<count($sgfArr); $i++){
			if($sgfArr[$i]=='C' && $sgfArr[$i+1]=='[' && $sgfArr[$i+2]!='+'){
				$j=0;
				if($i>$seq1){
					$saveText[$stIndex]['i'] = $i-3;
					$saveText[$stIndex]['j'] = $sgfArr[$i-3].$sgfArr[$i-2];
					$saveText[$stIndex]['#'] = array();
					$saveText[$stIndex]['C'] = array();
				}
				array_push($saveText[$stIndex]['#'], $sgfArr[$i-5]);
				array_push($saveText[$stIndex]['#'], $sgfArr[$i-4]);
				array_push($saveText[$stIndex]['#'], $sgfArr[$i-3]);
				array_push($saveText[$stIndex]['#'], $sgfArr[$i-2]);
				array_push($saveText[$stIndex]['#'], $sgfArr[$i-1]);
				while($sgfArr[$i+$j]!=']'){
					if($j>1){
						if($i<$seq1){
							array_push($playerNames, $sgfArr[$i+$j]);
						}else{ 
							array_push($saveText[$stIndex]['C'], $sgfArr[$i+$j]);
						}
					}
					$sgfArr[$i+$j]='°';
					$j++;
				}
				$sgfArr[$i+$j]='°';
				if($i>$seq1){
					$saveText[$stIndex]['#'] = implode($saveText[$stIndex]['#']);
					$saveText[$stIndex]['C'] = implode($saveText[$stIndex]['C']);
					$stIndex++;
				}
			}
			if($sgfArr[$i]=='C' && $sgfArr[$i+1]=='[' && $sgfArr[$i+2]=='+'){
				$j=0;
				$saveText[$stIndex]['i'] = $i-3;
				$saveText[$stIndex]['j'] = $sgfArr[$i-3].$sgfArr[$i-2];
				$saveText[$stIndex]['#'] = array();
				$saveText[$stIndex]['C'] = array();
				array_push($saveText[$stIndex]['#'], $sgfArr[$i-5]);
				array_push($saveText[$stIndex]['#'], $sgfArr[$i-4]);
				array_push($saveText[$stIndex]['#'], $sgfArr[$i-3]);
				array_push($saveText[$stIndex]['#'], $sgfArr[$i-2]);
				array_push($saveText[$stIndex]['#'], $sgfArr[$i-1]);
				while($sgfArr[$i+$j]!=']'){
					if($j>1){
						array_push($saveText[$stIndex]['C'], $sgfArr[$i+$j]);
					}
					$j++;
				}
				$saveText[$stIndex]['#'] = implode($saveText[$stIndex]['#']);
				$saveText[$stIndex]['C'] = implode($saveText[$stIndex]['C']);
				$stIndex++;
			}
			if($sgfArr[$i]=='C' && $sgfArr[$i+1]=='R' && $sgfArr[$i+2]=='['){
				array_push($lastPlayed, $sgfArr[$i+3]);
				array_push($lastPlayed, $sgfArr[$i+4]);
				$sgfArr[$i]='';
				$sgfArr[$i+1]='°';
				$sgfArr[$i+2]='°';
				$sgfArr[$i+3]='°';
				$sgfArr[$i+4]='°';
				$sgfArr[$i+5]='°';
			}
			if($sgfArr[$i]=='R' && $sgfArr[$i+1]=='E' && $sgfArr[$i+2]=='['){
				$j=0;
				while($sgfArr[$i+$j]!=']'){
					$sgfArr[$i+$j]='°';
					$j++;
				}
				$sgfArr[$i+$j]='°';
			}
			if($sgfArr[$i]=='T' && $sgfArr[$i+1]=='R' && $sgfArr[$i+2]=='['){
				$sgfArr[$i]='°';
				$sgfArr[$i+1]='°';
				$j=2;
				$coords = array();
				while(!ctype_upper($sgfArr[$i+$j])){
					if(ctype_lower($sgfArr[$i+$j])){
						if(ctype_lower($sgfArr[$i+$j+1])){
							$coords = array();
							array_push($coords, $sgfArr[$i+$j]);
						}else{
							array_push($coords, $sgfArr[$i+$j]);
							array_push($triangleMarker, $coords);
						}
					}
					$sgfArr[$i+$j]='°';
					$j++;
				}
			}
			if($sgfArr[$i]=='S' && $sgfArr[$i+1]=='Q' && $sgfArr[$i+2]=='['){
				$sgfArr[$i]='°';
				$sgfArr[$i+1]='°';
				$j=2;
				$coords = array();
				while(!ctype_upper($sgfArr[$i+$j])){
					if(ctype_lower($sgfArr[$i+$j])){
						if(ctype_lower($sgfArr[$i+$j+1])){
							$coords = array();
							array_push($coords, $sgfArr[$i+$j]);
						}else{
							array_push($coords, $sgfArr[$i+$j]);
							array_push($squareMarker, $coords);
						}
					}
					$sgfArr[$i+$j]='°';
					$j++;
				}
			}
			if($sgfArr[$i]=='P' && $sgfArr[$i+1]=='L' && $sgfArr[$i+2]=='['){
				$j=0;
				while($sgfArr[$i+$j]!=']'){
					$sgfArr[$i+$j]='°';
					$j++;
				}
				$sgfArr[$i+$j]='°';
			}
		}
		$playerNames = implode($playerNames);
		//echo '<pre>';print_r(implode($sgfArr));echo '</pre>';
		//echo '<pre>';print_r($saveText);echo '</pre>';
		
		//Real Game Boards
		if($setID==109 || $modifiedBSize || $setIDfullGame){
			$a1 = array_flip($alphabet1);
			if(isset($lastPlayed[0])){
				$lastPlayed[0] = $a1[$lastPlayed[0]];
				$lastPlayed[1] = $a1[$lastPlayed[1]];
			}else{
				$lastPlayed[0] = 99;
				$lastPlayed[1] = 99;
				
			}
			
			for($i=0; $i<count($triangleMarker); $i++) {
				$triangleMarker[$i][0] = $a1[$triangleMarker[$i][0]];
				$triangleMarker[$i][1] = $a1[$triangleMarker[$i][1]];
			}
			for($i=0; $i<count($squareMarker); $i++) {
				$squareMarker[$i][0] = $a1[$squareMarker[$i][0]];
				$squareMarker[$i][1] = $a1[$squareMarker[$i][1]];
			}
			$playerNamesMode = 0;
			if(strpos($playerNames, 'vs')){
				$playerNames = split(' vs ', $playerNames);
				$playerNamesMode = 0;
			}else{
				$playerNames = split(';', $playerNames);
				$playerNamesMode = 1;
			}
			
			$additionalInfo['playerNames'] = $playerNames;
			$additionalInfo['lastPlayed'] = $lastPlayed;
			$additionalInfo['triangle'] = $triangleMarker;
			$additionalInfo['square'] = $squareMarker;
			$additionalInfo['mode'] = $playerNamesMode;
			
			$sgfArr2 = array();
			$jump=0;
			$jumpArr = array();
			for($i=0; $i<count($sgfArr); $i++){
				if($sgfArr[$i]!='°'){
					array_push($sgfArr2, $sgfArr[$i]);
					if($sgfArr[$i]=='A' && $sgfArr[$i+1]=='W' && $sgfArr[$i+2]=='[') $aw = $i-$jump;
					if($sgfArr[$i]=='A' && $sgfArr[$i+1]=='B' && $sgfArr[$i+2]=='[') $ab = $i-$jump;
					array_push($jumpArr, '-');
				}else{
					$jump++;
					array_push($jumpArr, '°');
				}
			}
			$sgfArr = $sgfArr2;
			//echo '<pre>';print_r($jumpArr);echo '</pre>';
			//echo '<pre>';print_r($saveText);echo '</pre>';
			$ju = 0;
			for($i=0; $i<count($jumpArr); $i++){
				if($jumpArr[$i]=='°') $ju++;
				for($j=0; $j<count($saveText); $j++){
					if($i==$saveText[$j]['i']) $saveText[$j]['i'] -= $ju;
				}
			}
		}
		
		//Initial Position Black
		for($i=$ab+2; $i<count($sgfArr); $i++){
			if($sgfArr[$i]=='A'){
				break;
			}else if($sgfArr[$i]=='(' || $sgfArr[$i]==';'){
				array_pop($black);
				break;
			}else{
				if($sgfArr[$i]!='[' && $sgfArr[$i]!=']'){
					array_push($black, $sgfArr[$i]);
				}
			}
		}
		//Initial Position White
		for($i=$aw+2; $i<count($sgfArr); $i++){
			if($sgfArr[$i]=='A'){
				break;
			}else if($sgfArr[$i]=='(' || $sgfArr[$i]==';'){
				array_pop($white);
				break;
			}else{
				if($sgfArr[$i]!='[' && $sgfArr[$i]!=']'){
					array_push($white, $sgfArr[$i]);
				}
			}
		}
		
		$openBranch = 0;
		$noBranchCheck = false;
		for($i=$ab; $i<count($sgfArr); $i++){
			if($sgfArr[$i]==';'){
				$noBranchCheck = true;
				$openBranch = $i;
				break;
			}
			if($sgfArr[$i]=='('){
				$openBranch = $i;
				break;
			}
		}
		
		//keine Variationen vorhanden
		if($noBranchCheck){
			array_push($sgfArr, '');
			for($i=count($sgfArr); $i>$openBranch; $i--){
				$sgfArr[$i] = $sgfArr[$i-1];
			}
			$sgfArr[$openBranch] = '(';
			$sgfArr[count($sgfArr)-2] = ')';
			for($i=$ab; $i<count($sgfArr); $i++) {
				if($sgfArr[$i]=='('){
					$openBranch = $i;
					break;
				}
			}
		}
		
		//comments findet nur +comment
		for($i=$openBranch; $i<count($sgfArr); $i++){
			if($sgfArr[$i]=='C'){
				$r=1;
				while($sgfArr[$i+$r]!=']'){
					if(ctype_lower($sgfArr[$i+$r])) $sgfArr[$i+$r] = '~';
					$r++;
				}
			}
		}
		$depth = 0;
		$newBranch = false;
		$branches = array();
		$b = 0;
		
		//aus sgfArr das branches array machen
		
		
		if(count($saveText)==1 && $setIDfullGame && $semeai){
			$saveText[0]['i']++;
			if($setIDfullGame){
				$sT = str_replace('#', '', $saveText[0]['C']);
				$sT = str_replace('+', '', $sT);
				
				$sT = $this->commentCoordinates($sT, 999, false);
				$additionalInfo['semeaiText']=$sT[0];
				
			}
		}
		
		//echo '<pre>';print_r($saveText);echo '</pre>';
		
		$saveText2 = array();
		$saveText2[0]=array();
		$saveText2[1]=array();
		$saveText2[2]=array();
		$saveText2[3]=array();
		$branchesCounter = 0;
		for($i=$openBranch; $i<count($sgfArr); $i++){
			if(ctype_alpha($sgfArr[$i])&&ctype_lower($sgfArr[$i]) || $sgfArr[$i]=='(' || $sgfArr[$i]==')' || $sgfArr[$i]=='+'){ //alphabetisch lowercase sind die koordinaten
				if(!isset($branches[$b])){
					$branches[$b] = array();
					$branchesCounter = 0;
				}
				for($m=0; $m<count($saveText); $m++){
					//echo '<pre>';print_r($i);echo '</pre>';
					if($saveText[$m]['i']==$i-1){
						
						array_push($saveText2[0], $b);
						array_push($saveText2[1], $branchesCounter);
						array_push($saveText2[2], $saveText[$m]['C']);
						//array_push($saveText2[3], $sgfArr[$i-1].$sgfArr[$i]);
					}
				}
				array_push($branches[$b], $sgfArr[$i]);
				$branchesCounter++;
				
				if($sgfArr[$i]=='+'){
					array_push($branches[$b], $sgfArr[$i]);
				}
				if($sgfArr[$i]=='§'){
					array_push($branches[$b], $sgfArr[$i]);
				}
			}
			if($depth==0){
				if($sgfArr[$i]==')'){
					$newBranch = false;
					$b++;
				}
				if($sgfArr[$i]=='('){
					if($newBranch){
						$depth++;
					}else{
						$newBranch = true;
					}	
				}
			}else{
				if($sgfArr[$i]==')'){
					$depth--;
				}
				if($sgfArr[$i]=='('){
					$depth++;
				}
			}
		}
		array_pop($branches);
		
		//echo '<pre>';print_r($saveText2);echo '</pre>';
		//echo '<pre>';print_r($branches);echo '</pre>';
		
		//remove white's options 
		$moreWhiteOptions = true;
		while($moreWhiteOptions){
			$moreWhiteOptions = false;
			for($h=0; $h<count($branches); $h++){
				$coordCounter = 0;
				$optionSearcher1 = false;
				$optionSearcher2 = false;
				$options = array();
				$depth = 0;
				$nextPos = 0;
				$firstChoice = false;//nur eine w option
				for($i=0; $i<count($branches[$h]); $i++){
					//echo $branches[$h][$i];
					if($branches[$h][$i]=='(' && ($coordCounter+2)%4==0 && $firstChoice==false){
						$firstChoice = true;
						$moreWhiteOptions = true;
						$optionSearcher1 = true;
						$optionSearcher2 = true;
					}
					if($optionSearcher2){
						if($branches[$h][$i]=='('){
							$depth++;
						}else if($branches[$h][$i]==')'){
							$depth--;
						}else{
							
						}
						
						if($depth==-1){
							$optionSearcher2 = false;
						}else{
							if(!isset($options[$nextPos]))
								$options[$nextPos] = array();
							array_push($options[$nextPos], $i);
						}
						if($depth==0){
							$nextPos++;
						}
					}
					
					if(ctype_lower($branches[$h][$i]) || $branches[$h][$i]=='+'){
						$coordCounter++;
					}else{
						$coordCounter = 0;
					}
				}
				if($optionSearcher1){
					$chosenPath = rand(0, count($options)-1);
					for($o=0; $o<count($options); $o++){
						if($o!=$chosenPath){
							for($p=0; $p<count($options[$o]); $p++){
								$branches[$h][$options[$o][$p]] = '~';
							}
						}
					}
					$branches[$h][$options[$chosenPath][0]] = '~';
					$branches[$h][$options[$chosenPath][count($options[$chosenPath])-1]] = '~';
					for($b=count($branches[$h])-1; $b>=0; $b--){
						if($branches[$h][$b]=='~'){
							unset($branches[$h][$b]);
						}
					}
					$branches[$h] = array_values($branches[$h]);
				}
			}
		}
		
		$superBranch = 'A';
		$moveList = array();
		$previousBranchList = array();
		for($h=0; $h<count($branches); $h++){
			$sb = $superBranch;
			$superBranch++;
			$levels = array();
			$moveLevel = array();
			$c1;
			$depth = 0;
			$move = 0;
			$moveCounter = 0;
			$moveList[$h] = array();
			$previousBranchList[$h] = array();
			$branches[$h][0] .= $sb;
			for($i=1; $i<count($branches[$h])-1; $i++){
				if($branches[$h][$i]=='('){
					$depth++;
					if(isset($levels[$depth-1])){
						$levels[$depth-1]++;
					}else{
						$levels[$depth-1] = 'A';
					}
					$branches[$h][$i] .= $sb;
					for($j=0; $j<$depth; $j++) {
						$branches[$h][$i] .= $levels[$j];
					}
					$moveLevel[$depth-1] = $move;
				}else if($branches[$h][$i]==')'){
					$k = 0;
					if(strlen($branches[$h][$i-1])==1 && $branches[$h][$i-1]!=')'){
						while(isset($branches[$h][$i+$k]) && $branches[$h][$i+$k]==')'){
							$k++;
						}
					}
					$l = 0;
					while($k>1){
						unset($levels[$depth-$l-1]);
						$l++;
						$k--;
					}
					$move = $moveLevel[$depth-1];
					$depth--;
				}else if(ctype_lower($branches[$h][$i]) || $branches[$h][$i]=='+'){
					$moveCounter++;
					if($moveCounter==4){
						$r = 0;
						while(strlen($branches[$h][$i-$r])==1){
							$r++;
						}
						if($r>4){
							array_push($previousBranchList[$h], substr($branches[$h][$i-$r], 1));
						}else{
							array_push($previousBranchList[$h], substr($branches[$h][$i-$r], 1, -1));	
						}
						array_push($moveList[$h], $move);
						$move++;
						$moveCounter = 0;
					}
				}
			}
		}
		
		//echo '<pre>';print_r($black);echo '</pre>';
		//echo '<pre>';print_r($white);echo '</pre>';
		
		//Corner
		if($modifiedBSize) $orientation='topleft';
		
		if($orientation=='topleft') $c=0;
		elseif($orientation=='topright') $c=1;
		elseif($orientation=='bottomleft') $c=2;
		elseif($orientation=='bottomright') $c=3;
		elseif($orientation=='top') $c2=0;
		elseif($orientation=='bottom') $c2=1;
		else{
			$c = rand(0,3);
			$c2 = rand(0,1);
		}
		$corner = $cornerShuffle[$c];
		
		$lowestLetterX = 'z';
		$lowestLetterY = 'z';
		$highestLetterX = 'a';
		$highestLetterY = 'a';
		$xy = true;
		for($i=0; $i<count($black); $i++){
			if($xy){
				if($black[$i]<$lowestLetterX) $lowestLetterX = $black[$i];
				if($black[$i]>$highestLetterX) $highestLetterX = $black[$i];
			}else{
				if($black[$i]>$highestLetterY) $highestLetterY = $black[$i];
				if($black[$i]<$lowestLetterY) $lowestLetterY = $black[$i];
			}
			$xy = !$xy;
		}
		$xy = true;
		for($i=0; $i<count($white); $i++){
			if($xy){
				if($white[$i]<$lowestLetterX) $lowestLetterX = $white[$i];
				if($white[$i]>$highestLetterX) $highestLetterX = $white[$i];
			}else{
				if($white[$i]>$highestLetterY) $highestLetterY = $white[$i];
				if($white[$i]<$lowestLetterY) $lowestLetterY = $white[$i];
			}
			$xy = !$xy;
		}
		//echo $lowestLetterX.' '.$highestLetterX.' '.$lowestLetterY.' '.$highestLetterY.' ';
		//In der Mitte des Brettes Koordinate erweitern um größeres Brett zu bekommen.
		//Endgame problems
		//if($setID!=63){
			if($lowestLetterX=='j' || $lowestLetterX=='k') $lowestLetterX='i';
			if($lowestLetterY=='j' || $lowestLetterY=='k') $lowestLetterY='i';
			if($highestLetterX=='j' || $highestLetterX=='i') $highestLetterX='k';
			if($highestLetterY=='j' || $highestLetterY=='i') $highestLetterY='k';
		//}
		$tl = array($lowestLetterX, $lowestLetterY);
		$tr = array($highestLetterX, $lowestLetterY);
		$bl = array($lowestLetterX, $highestLetterY);
		$br = array($highestLetterX, $highestLetterY);
		$frame = array($tl, $tr, $bl, $br);
		
		for($i=0; $i<count($frame); $i++){
				 if($frame[$i][0]<'j' && $frame[$i][1]<'j') $frame[$i] = 'tl';
			else if($frame[$i][0]>'j' && $frame[$i][1]<'j') $frame[$i] = 'tr';
			else if($frame[$i][0]<'j' && $frame[$i][1]>'j') $frame[$i] = 'bl';
			else if($frame[$i][0]>'j' && $frame[$i][1]>'j') $frame[$i] = 'br';
		}
		//echo '<pre>';print_r($frame);echo '</pre>';
		if(count(array_unique($frame))==2){
			if(in_array('tr', $frame)&&in_array('tl', $frame) || in_array('br', $frame)&&in_array('bl', $frame)) $corner = $cornerShuffle2[$c2];
			else $corner = 'full board';
		}elseif(count(array_unique($frame))>2){
			$corner = 'full board';
		}
		$xy = false;
		$cornerVar = true;
		if($corner=='t' || $corner=='b') $cornerVar = false;
		$alphabet1 = array_flip($alphabet1);
		for($i=0; $i<count($black); $i++){
			$black[$i] = $alphabet1[$black[$i]];
			
			if($corner != 'full board'){
				if($black[$i]>8&&$cornerVar || $black[$i]>8&&!$cornerVar&&$xy){
					$black[$i] = 18-$black[$i];
				}
			}
				  if($corner=='tl'){$black[$i] = $black[$i];
			}else if($corner=='br'){$black[$i] = 18-$black[$i];
			}else if($corner=='tr' && !$xy){$black[$i] = 18-$black[$i];
			}else if($corner=='bl' && $xy){$black[$i] = 18-$black[$i];
			}else if($corner=='t'){$black[$i] = $black[$i];
			}else if($corner=='b'){$black[$i] = 18-$black[$i];
			}else{$black[$i] = $black[$i];}
			$xy = !$xy;
		}
		for($i=0; $i<count($white); $i++){
			$white[$i] = $alphabet1[$white[$i]];
			
			if($corner != 'full board'){
				if($white[$i]>8&&$cornerVar || $white[$i]>8&&!$cornerVar&&$xy){
					$white[$i] = 18-$white[$i];
				}
			}
				  if($corner=='tl'){$white[$i] = $white[$i];
			}else if($corner=='br'){$white[$i] = 18-$white[$i];
			}else if($corner=='tr' && !$xy){$white[$i] = 18-$white[$i];
			}else if($corner=='bl' && $xy){$white[$i] = 18-$white[$i];
			}else if($corner=='t'){$white[$i] = $white[$i];
			}else if($corner=='b'){$white[$i] = 18-$white[$i];
			}else{$white[$i] = $white[$i];}
			$xy = !$xy;
		}
		
		for($i=0; $i<count($branches); $i++){
			for($j=0; $j<count($branches[$i]); $j++){
				if(ctype_alpha($branches[$i][$j])){
					$branches[$i][$j] = $alphabet1[$branches[$i][$j]];
					
					if($corner != 'full board'){
						if($branches[$i][$j]>8&&$cornerVar || $branches[$i][$j]>8&&!$cornerVar&&$xy){
							$branches[$i][$j] = 18-$branches[$i][$j];
						}
					}
						  if($corner=='tl'){$branches[$i][$j] = $branches[$i][$j];	
					}else if($corner=='br'){$branches[$i][$j] = 18-$branches[$i][$j];	
					}else if($corner=='tr' && !$xy){$branches[$i][$j] = 18-$branches[$i][$j];
					}else if($corner=='bl' && $xy){$branches[$i][$j] = 18-$branches[$i][$j];
					}else if($corner=='t'){$branches[$i][$j] = $branches[$i][$j];	
					}else if($corner=='b'){$branches[$i][$j] = 18-$branches[$i][$j];	
					}else{$branches[$i][$j] = $branches[$i][$j];}
					$xy = !$xy;
				}
			}
		}
		
		$moveList1d = array();
		$previousBranchList1d = array();
		for($i=0; $i<count($moveList); $i++){
			for($j=0; $j<count($moveList[$i]); $j++){
				array_push($moveList1d, $moveList[$i][$j]);
				array_push($previousBranchList1d, $previousBranchList[$i][$j]);
			}
		}
		$masterArray = array();
		$pos = 0;
		$numCounter = 0;
		
		//echo '<pre>';print_r($branches);echo '</pre>';
		
		//final conversion into masterArray
		for($i=0; $i<count($branches); $i++){
			$lastBranch;
			for($j=0; $j<count($branches[$i]); $j++){
				$commentEnabled = false;
				$commentIndex = 0;
				if(is_numeric($branches[$i][$j])){
					$numCounter++;
				}else{
					$numCounter = 0;
				}
				if(strlen($branches[$i][$j])!=1 && !is_numeric($branches[$i][$j])){
					$lastBranch = $branches[$i][$j];
					$masterArray[$pos] = array();
					array_push($masterArray[$pos], $branches[$i][$j+1]);
					array_push($masterArray[$pos], $branches[$i][$j+2]);
					array_push($masterArray[$pos], $moveList1d[$pos]);
					array_push($masterArray[$pos], $previousBranchList1d[$pos]);
					array_push($masterArray[$pos], $branches[$i][$j+3]);
					array_push($masterArray[$pos], $branches[$i][$j+4]);
					array_push($masterArray[$pos], substr($branches[$i][$j], 1));
					array_push($masterArray[$pos], $i.'-'.$j);
					
					if($masterArray[$pos][4]==='+'){
						array_push($masterArray[$pos], '+');
						//echo '<pre>'; print_r($lastBranch.'-'.$branches[$i][$j+4].'-'.$branches[$i][$j+5]); echo '</pre>'; 
						if($branches[$i][$j+4]==='+' && is_numeric($branches[$i][$j+5])){
							$masterArray[$pos][4] = $branches[$i][$j+5];
							$masterArray[$pos][5] = $branches[$i][$j+6];
						}
					}elseif($branches[$i][$j+5]===')'){
						array_push($masterArray[$pos], 'w');
					}else{
						array_push($masterArray[$pos], '');
					}
					
					$pos++;
				}else{
					if($numCounter>4 && ($numCounter-1)%4==0){
						$masterArray[$pos] = array();
						array_push($masterArray[$pos], $branches[$i][$j]);
						array_push($masterArray[$pos], $branches[$i][$j+1]);
						array_push($masterArray[$pos], $moveList1d[$pos]);
						array_push($masterArray[$pos], $previousBranchList1d[$pos]);
						array_push($masterArray[$pos], $branches[$i][$j+2]);
						array_push($masterArray[$pos], $branches[$i][$j+3]);
						array_push($masterArray[$pos], substr($lastBranch, 1));
						array_push($masterArray[$pos], $i.'-'.$j);
						
						if($masterArray[$pos][4]==='+'){
							array_push($masterArray[$pos], '+');
							//echo '<pre>'; print_r($lastBranch.'!-'.$branches[$i][$j+3].'-'.$branches[$i][$j+4]); echo '</pre>'; 
							if($branches[$i][$j+3]==='+' && is_numeric($branches[$i][$j+4])){
								$masterArray[$pos][4] = $branches[$i][$j+4];
								$masterArray[$pos][5] = $branches[$i][$j+5];
							}
						}elseif($branches[$i][$j+4]===')'){
							array_push($masterArray[$pos], 'w');
						}else{
							array_push($masterArray[$pos], '');
						}
						
						$pos++;
					}
				}
			}
		}
		
		for($i=0; $i<count($masterArray); $i++){
			//intuition
			if($masterArray[$i][8]==='+') $correctBranch = $masterArray[$i][6];
			//level 0
			if($masterArray[$i][2]==0) array_push($visual, $masterArray[$i]);
			//lösungen
			if($masterArray[$i][8]==='+') array_push($vCorrect, $masterArray[$i]);
			$masterArray[$i][9] = $this->compileBoardState($black, $white, $masterArray[$i], $masterArray, $i);
		}
		//BB -> B
		$correctBranch = $correctBranch[0];
		//geht durch lösungen
		for($i=0; $i<count($vCorrect); $i++){
			for($j=0; $j<count($masterArray); $j++){
				//findet zweig der lösung auf level 0
				if($masterArray[$j][6][0]==$vCorrect[$i][6][0] && $masterArray[$j][2]==0){
					//fügt auf level 0 ein + hinzu
					for($k=0; $k<count($visual); $k++) if($visual[$k][6]==$masterArray[$j][6][0]) $visual[$k][3]='+';
				}
			}
		}
		
		$noCorrectFound = true;
		//intuition move
		for($i=0; $i<count($masterArray); $i++){
			if($masterArray[$i][6]===$correctBranch && $masterArray[$i][2]===0){
				array_push($correctMove, $masterArray[$i][0]);
				array_push($correctMove, $masterArray[$i][1]);
			}
			if($masterArray[$i][4]===')' || $masterArray[$i][5]===')') $sgfErrorMessage= 'Error: Ending branch not set correctly.';
			if($masterArray[$i][8]==='+') $noCorrectFound = false;
		}
		if($noCorrectFound) $sgfErrorMessage= 'Error: There is no solution.';
		//echo '<pre>';print_r($saveText2);echo '</pre>';
		
		for($n=0; $n<count($saveText2[0]); $n++){
			$distance = array();
			$distance2 = array();
			$distance3 = array();
			$lowest = -100;
			$lowestPos = 0;
			for($m=0; $m<count($masterArray); $m++){
				$t = explode('-', $masterArray[$m][7]);
				if(!isset($t[1])) $t[1] = '';
				$distance[$m] = $t[0].'-'.$saveText2[0][$n].'|'.$t[1].'-'.$saveText2[1][$n];
				$distance2[$m] = $t[0]-$saveText2[0][$n];
				$distance3[$m] = $t[1]-$saveText2[1][$n];
				
				if($t[0]-$saveText2[0][$n]==0){
					if($t[1]-$saveText2[1][$n]>$lowest && $t[1]-$saveText2[1][$n]<1){
						$lowest = $t[1]-$saveText2[1][$n];
						$lowestPos = $m;
					}
				}
			}
			$masterArray[$lowestPos][7] = str_replace('+', '', $saveText2[2][$n]);
		}
		
		$coordPlaces = array();
		$coordMarkers = array();
		
		for($i=0; $i<count($masterArray); $i++){
			array_push($visuals, $this->findNextMoves($masterArray, $masterArray[$i]));
			
			$coords = explode(' ', $this->findCoords($masterArray[$i][7]));
			$cd = '';
			$places = '';
			for($j=0; $j<count($coords); $j++){
				if(!strpos($coords[$j], '/')) $cd .= $coords[$j].' ';
				else $places .= $coords[$j].' ';
			}
			if(substr($cd, -1)==' ') $cd = substr($cd, 0, -1);
			if(substr($places, -1)==' ') $places = substr($places, 0, -1);
			array_push($coordMarkers, $cd);
			array_push($coordPlaces, $places);
		}
		for($i=0; $i<count($coordMarkers); $i++){
			$e = explode(' ', $coordMarkers[$i]);
			for($j=0; $j<count($e); $j++){
				$e[$j] = str_split($e[$j]);
				$e2 = array();
				$coord1 = -1;
				$coord2 = -1;
				for($k=0; $k<count($e[$j]); $k++){
					if(preg_match('/[0-9]/', $e[$j][$k])) array_push($e2, $e[$j][$k]);
					if(preg_match('/[a-tA-T]/', $e[$j][$k])) $coord1 = $this->convertCoord($e[$j][$k]);
				}
				$coord2 = $this->convertCoord2(implode($e2));
				if($coord1!=-1 &&$coord2!=-1) $e[$j] = $coord1.'-'.$coord2;
			}
			$coordMarkers[$i] = $e;
		}
		for($i=0; $i<count($coordPlaces); $i++){
			$coordPlaces[$i] = explode(' ', $coordPlaces[$i]);
		}
		
		/*
		$fn = 1;
		for($i=0; $i<count($masterArray); $i++){
		for($k=count($coordPlaces[$i])-1; $k>=0; $k--){
			$coordP = explode('/', $coordPlaces[$i][$k]);
			$a = substr($masterArray[$i][7], 0, $coordP[0]);
			$b = '<a href="#" onmouseover="commentCoordinateIn'.$fn.'()" onmouseout="commentCoordinateOut'.$fn.'()" return false;>';
			$b = '<a >';
			$c = substr($masterArray[$i][7], $coordP[0], $coordP[1]-$coordP[0]+1);
			$d = '</a>';
			$e = substr($masterArray[$i][7], $coordP[1]+1, strlen($masterArray[$i][7])-1);
			$masterArray[$i][7] = $a.$b.$c.$d.$e;
			$fn++;
		}
		}
		*/
		//echo '<pre>';print_r($masterArray);echo '</pre>';
		//echo '<pre>';print_r($visual);echo '</pre>';
		//echo '<pre>';print_r($visuals);echo '</pre>';
		
		if($modifiedBSize) $corner='full board';
		
		}
		
		$masterArrayBW = array();
		array_push($masterArrayBW, $masterArray);
		array_push($masterArrayBW, $black);
		array_push($masterArrayBW, $white);
		array_push($masterArrayBW, $corner);
		array_push($masterArrayBW, $correctMove);
		array_push($masterArrayBW, $semeai);
		array_push($masterArrayBW, $bMinus);
		array_push($masterArrayBW, $wMinus);
		array_push($masterArrayBW, $wMinus);
		array_push($masterArrayBW, $firstPlayer);
		array_push($masterArrayBW, $additionalInfo);
		array_push($masterArrayBW, $visual);
		array_push($masterArrayBW, $visuals);
		array_push($masterArrayBW, $coordMarkers);
		array_push($masterArrayBW, $coordPlaces);
		array_push($masterArrayBW, $sT);
		array_push($masterArrayBW, $sgfErrorMessage);
		return $masterArrayBW;
	}
	
	private function compileBoardState($black=null, $white=null, $m=null, $ms=null, $index=null){
		$array = array();
		$bString = '';
		for($i=0; $i<count($black); $i++){
			if($i%2==0){
				array_push($array, 'B-'.$black[$i].'-'.$black[$i+1].';');
			}
		}
		for($i=0; $i<count($white); $i++){
			if($i%2==0){
				array_push($array, 'W-'.$white[$i].'-'.$white[$i+1].';');
			}
		}
		
		$array2 = array();
		array_push($array2, 'B-'.$ms[$index][0].'-'.$ms[$index][1].';');
		if(is_numeric($ms[$index][4])) array_push($array2, 'W-'.$ms[$index][4].'-'.$ms[$index][5].';');
		
		$parent = $ms[$index][3];
		$layer = $ms[$index][2];
		while($layer!=0){
			$layer--;
			for($i=0; $i<count($ms); $i++){
				if($ms[$i][6]==$parent && $ms[$i][2]==$layer){
					array_push($array2, 'B-'.$ms[$i][0].'-'.$ms[$i][1].';');
					array_push($array2, 'W-'.$ms[$i][4].'-'.$ms[$i][5].';');
					$parent = $ms[$i][3];
				}
			}
			
		}
		
		//$array3 = array_merge($array, $array2);
		$array3 = $array2;
		sort($array3);
		
		for($i=0; $i<count($array3); $i++){
			$bString .= $array3[$i];
		}
		
		return $bString;
	}
	
	private function findCoords($master=null){
		$m = str_split($master);
		$n = '';
		for($i=0; $i<count($m); $i++){
			if(preg_match('/[a-tA-T]/', $m[$i]) && is_numeric($m[$i+1])){
				if(!preg_match('/[a-tA-T]/', $m[$i-1]) && !is_numeric($m[$i-1])){
					if(is_numeric($m[$i+2])){
						if(!preg_match('/[a-tA-T]/', $m[$i+3]) && !is_numeric($m[$i+3])){
							$n .= $m[$i].$m[$i+1].$m[$i+2].' '.$i.'/'.($i+2).' ';
						}
					}else{
						if(!preg_match('/[a-tA-T]/', $m[$i+2])){
							$n .= $m[$i].$m[$i+1].' '.$i.'/'.($i+1).' ';
						}
					}
				}
			}			
		}
		if(substr($n, -1)==' ') $n = substr($n, 0, -1);
		return $n;
	}
	
	private function commentCoordinates($c=null, $counter=null, $noSyntax=null){
		$m = str_split($c);
		$n = '';
		$n2 = '';
		$hasLink = false;
		for($i=0; $i<count($m); $i++){
			if(preg_match('/[a-tA-T]/', $m[$i]) && is_numeric($m[$i+1])){
				if(!preg_match('/[a-tA-T]/', $m[$i-1]) && !is_numeric($m[$i-1])){
					if(is_numeric($m[$i+2])){
						if(!preg_match('/[a-tA-T]/', $m[$i+3]) && !is_numeric($m[$i+3])){
							$n .= $m[$i].$m[$i+1].$m[$i+2].' ';
							$n2 .= $i.'/'.($i+2).' ';
						}
					}else{
						if(!preg_match('/[a-tA-T]/', $m[$i+2])){
							$n .= $m[$i].$m[$i+1].' ';
							$n2 .= $i.'/'.($i+1).' ';
						}
					}
				}
			}
			if($m[$i]=='<' && $m[$i+1]=='/' && $m[$i+2]=='a' && $m[$i+3]=='>') $hasLink=true;
		}
		if(substr($n, -1)==' ') $n = substr($n, 0, -1);
		if(substr($n2, -1)==' ') $n2 = substr($n2, 0, -1);
		
		if($hasLink) $n2=array();
		
		if(strlen($n2)>1){
			$n2x = explode(' ', $n2);
			$fn = 1;
			for($i=count($n2x)-1; $i>=0; $i--){
				$n2xx = explode('/', $n2x[$i]);
				$a = substr($c, 0, $n2xx[0]);
				//echo $a.'<br>';
				if($noSyntax) $b = '<a href="#" onmouseover="ccIn'.$counter.$fn.'()" onmouseout="ccOut'.$counter.$fn.'()" return false;>';
				else $b = '<a href=\"#\" onmouseover=\"ccIn'.$counter.$fn.'()\" onmouseout=\"ccOut'.$counter.$fn.'()\" return false;>';
				//echo $b.'<br>';
				$cx = substr($c, $n2xx[0], $n2xx[1]-$n2xx[0]+1);
				//echo $c.'<br>';
				$d = '</a>';
				$e = substr($c, $n2xx[1]+1, strlen($c)-1);
				//echo $e.'<br>';
				$c = $a.$b.$cx.$d.$e;
				$fn++;
			}
		}
		
		$xx = explode(' ', $n);
		$coord1 = 0;
		$finalCoord = '';
		for($i=0; $i<count($xx); $i++){
			if(strlen($xx[$i])>1){
				$xxxx = array();
				$xxx = str_split($xx[$i]);
				for($j=0; $j<count($xxx); $j++){
					if(preg_match('/[0-9]/', $xxx[$j])) array_push($xxxx, $xxx[$j]);
					if(preg_match('/[a-tA-T]/', $xxx[$j])) $coord1 = $this->convertCoord($xxx[$j]);
				}
				$coord2 = $this->convertCoord2(implode($xxxx));
				if($coord1!=-1 &&$coord2!=-1) $finalCoord .= $coord1.'-'.$coord2.' ';
			}
		}
		if(substr($finalCoord, -1)==' ') $finalCoord = substr($finalCoord, 0, -1);
		
		$array = array();
		array_push($array, $c);
		array_push($array, $finalCoord);
		return $array;
	}
	
	private function findNextMoves($master=null, $m=null){
		$a = array();
		$solves = array();
		$root = $m[6];
		$rootlen = strlen($root);
		$level = $m[2];
		if($m[8]!=='w'){
			for($i=0; $i<count($master); $i++){
				if(substr($master[$i][6], 0, $rootlen) === $root){
					if($master[$i][2]==$level+1){
						array_push($a, $master[$i]);
					}
					if($master[$i][8]==='+'){
						array_push($solves, $master[$i]);
					}
				}
				
			}
			$subrootlen = strlen($a[0][6]);
			for($i=0; $i<count($a); $i++){
				for($j=0; $j<count($solves); $j++){
					if(substr($solves[$j][6], 0, $subrootlen) === $a[$i][6]) $a[$i][3] = '+';
				}
			}
		}
		return $a;
	}
	
	private function convertCoord($l=null){
		switch(strtolower($l)){
			case 'a': return 0;
			case 'b': return 1;
			case 'c': return 2;
			case 'd': return 3;
			case 'e': return 4;
			case 'f': return 5;
			case 'g': return 6;
			case 'h': return 7;
			case 'j': return 8;
			case 'k': return 9;
			case 'l': return 10;
			case 'm': return 11;
			case 'n': return 12;
			case 'o': return 13;
			case 'p': return 14;
			case 'q': return 15;
			case 'r': return 16;
			case 's': return 17;
			case 't': return 18;
		}
		return 0;
	}
	private function convertCoord2($n=null){
		switch($n){
			case '0': return 19;
			case '1': return 18;
			case '2': return 17;
			case '3': return 16;
			case '4': return 15;
			case '5': return 14;
			case '6': return 13;
			case '7': return 12;
			case '8': return 11;
			case '9': return 10;
			case '10': return 9;
			case '11': return 8;
			case '12': return 7;
			case '13': return 6;
			case '14': return 5;
			case '15': return 4;
			case '16': return 3;
			case '17': return 2;
			case '18': return 1;
		}
		return 0;
	}
	
	private function encrypt($str=null){
		$secret_key = 'my_simple_secret_keyx';
		$secret_iv = 'my_simple_secret_ivx';
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
		return base64_encode(openssl_encrypt($str, $encrypt_method, $key, 0, $iv));
	}
	
	private function decrypt($str=null){
		$string = $str;
		$secret_key = 'my_simple_secret_keyx';
		$secret_iv = 'my_simple_secret_ivx';
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16);
		return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		//$outputArr = explode("number", $output);
	}
	
	// Returns 2 updated ratings, RD initialization for user has to be done manually before this function
	// old_u is an array [old_r, old_rd] for the user and old_t for the tsumego
	// Success is given from the point of view of the user and is 1.0 or 0
	private function compute_rating($old_u, $old_t, $success){
		$old_u['old_rd'] += 40;
		$new_u = $this->compute_single_rating($old_u, $old_t, $success);
		$new_u[1] -= 40;
		
		$new_t = $this->compute_single_rating($old_t, $old_u, 1.0 - $success);
		
		return array($new_u, $new_t);
	}

	// Computes the rating of the first provided one given its own success
	private function compute_single_rating($old_1, $old_2, $success){
		
		$r_1 = $old_1['old_r'];
		$rd_1 = $old_1['old_rd'];
		$r_2 = $old_2['old_r'];
		$rd_2 = $old_2['old_rd'];

		$g_rd = $this->g_rd($rd_2);
		$E_s = $this->E_s($r_1, $r_2, $g_rd_2);

		$d_sq = 1.0 / (Q**2 * $g_rd**2 * $E_s * (1.0 - $E_s));

		$new_rd = 1 / sqrt(1 / $rd_1**2 + 1 / $d_sq);

		$coeff = Q / (1 / $r_1**2 + 1 / $d_sq);
		$new_rating = $r_1 + $coeff * $g_rd * ($success - $E_s);
		return array($new_rating, $new_rd);
	}

	private function g_rd($rd) {
		return 1.0 / sqrt(1.0 + 3.0 * Q**2 * $rd**2 / pi() ** 2);
	}

	private function E_s($r_0, $r_i, $g_rd_i) {
		return 1.0 / (1.0 + 10.0 ** ($g_rd_i * ($r_0 - $r_i) / -400.0));
	}

	// Computes the rating deviation of a user after t days
	// Resets days not played to 0
	// Does nothing if the user already played rating mode today
	// This function has to be called before computing the new user rating and RD
	// TODO do we also do it for tsumego and not only for user ?
	private function compute_initial_user_rd($user){
		if(false){
			$t = $user['User']['t_glicko'];
			$old_rd = $user['User']['rd'];

			// Computes new RD after some time
			$current_rd = min(sqrt($old_rd**2 + C**2 * $t), INITIAL_RD);
			// Resets counter for next day
			$user['User']['t_glicko'] = 0;
			// Assigns initial RD for the day
			$user['User']['rd'] = $current_rd;
			
		}
		return $user;
	}

}

?>


