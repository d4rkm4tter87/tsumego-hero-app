<?php
class SetsController extends AppController{

    public $helpers = array('Html', 'Form');
	public $title = 'tsumego-hero.com';

	public function duplicates($id=null){
		$this->LoadModel('Tsumego');
		$this->LoadModel('Sgf');
		$this->LoadModel('Duplicate');
		$this->LoadModel('SetConnection');
		
		$_SESSION['page'] = 'sandbox';
		$_SESSION['title'] = 'Tsumego Hero - Duplicates';
		
		$tIds = array();
		$d2 = array();
		
		if(isset($this->params['url']['unmark'])){
			$unmark = $this->Duplicate->find('all', array('conditions' => array('dGroup' => $this->params['url']['unmark'])));
			for($i=0; $i<count($unmark); $i++)
				$this->Duplicate->delete($unmark[$i]['Duplicate']['id']);
		}
		
		//$ts = $this->Tsumego->find('all', array('order' => 'num ASC', 'conditions' => array('set_id' => $id)));
		$ts = $this->findTsumegoSet($id);
		$set = $this->Set->findById($ts[0]['Tsumego']['set_id']);
		for($i=0; $i<count($ts); $i++)
			array_push($tIds, $ts[$i]['Tsumego']['id']);
		$d0 = $this->Duplicate->find('all', array('conditions' => array('tsumego_id' => $tIds)));
		
		$d = array();
		for($i=0; $i<count($d0); $i++){
			$d01 = $this->Duplicate->find('all', array('conditions' => array(
				'dGroup' => $d0[$i]['Duplicate']['dGroup'],
				'NOT' => array('tsumego_id' => $d0[$i]['Duplicate']['tsumego_id'])
			)));
			array_push($d, $d0[$i]);
			for($j=0; $j<count($d01); $j++){
				array_push($d, $d01[$j]);
			}
		}
		
		
		$dNew = array();
		for($i=0; $i<count($d); $i++){
			$dNewMatch = false;
			for($j=0; $j<count($dNew); $j++){
				if($i!=$j){
					if($d[$i]['Duplicate']['id']==$dNew[$j]['Duplicate']['id'])
						$dNewMatch = true;
				}
			}
			if(!$dNewMatch)
				array_push($dNew, $d[$i]);
		}
		//echo '<pre>'; print_r(count($d)); echo '</pre>';
		//echo '<pre>'; print_r(count($dNew)); echo '</pre>';
		$d = $dNew;
		$similarArr = array();
		$similarArrInfo = array();
		$similarArrBoardSize = array();
		
		$counter2 = 0;
		$counter = -1;
		
		$currentGroup = -1;
		for($i=0; $i<count($d); $i++){
			if($currentGroup!=$d[$i]['Duplicate']['dGroup']){
				$counter++;
				$d2[$counter] = array();
			}
			$td = $this->Tsumego->findById($d[$i]['Duplicate']['tsumego_id']);
			$scT = $this->SetConnection->find('first', array('conditions' => array('tsumego_id' => $td['Tsumego']['id'])));$td['Tsumego']['set_id'] = $scT['SetConnection']['set_id'];

			$setx = $this->Set->findById($td['Tsumego']['set_id']);
			$td['Tsumego']['title'] = $setx['Set']['title'].' - '.$td['Tsumego']['num'];
			$td['Tsumego']['dGroup'] = $d[$i]['Duplicate']['dGroup'];
			
			array_push($d2[$counter], $td);
			$currentGroup = $d[$i]['Duplicate']['dGroup'];
			
			$sgf = $this->Sgf->find('first', array('order' => 'created DESC', 'conditions' =>  array('tsumego_id' => $td['Tsumego']['id'])));
			$sgfArr = $this->processSGF($sgf['Sgf']['sgf']);
			
			array_push($similarArr, $sgfArr[0]);
			array_push($similarArrInfo, $sgfArr[2]);
			array_push($similarArrBoardSize, $sgfArr[3]);
		}
		
		$this->set('id', $id);
		$this->set('set', $set);
		$this->set('ts', $ts);
		$this->set('d', $d);
		$this->set('d2', $d2);
		$this->set('similarArr', $similarArr);
		$this->set('similarArrInfo', $similarArrInfo);
		$this->set('similarArrBoardSize', $similarArrBoardSize);
	}
	
	public function duplicatesearch(){
		$this->LoadModel('Tsumego');
		$this->LoadModel('Duplicate');
		$_SESSION['page'] = 'sandbox';
		$_SESSION['title'] = 'Duplicate Search Results';
		$s = $this->Set->find('all', array('order' => 'created DESC', 'conditions' => array(
			'OR' => array(
				array('public' => 1),
				array('public' => 0)
			)
		)));
		for($i=0; $i<count($s); $i++){
			//$ts = $this->Tsumego->find('all', array('conditions' => array('set_id' => $s[$i]['Set']['id'])));
			$ts = $this->findTsumegoSet($s[$i]['Set']['id']);		
			$tsIds = array();
			for($j=0; $j<count($ts); $j++){
				array_push($tsIds, $ts[$j]['Tsumego']['id']);
			}
			$d = $this->Duplicate->find('all', array('conditions' => array('tsumego_id' => $tsIds)));
			$s[$i]['Set']['dNum'] = count($d);
		}
		
		$ds1 = file_get_contents('ds1.txt');
		$all = $this->Tsumego->find('all', array('order' => 'id ASC'));
		
		$this->set('progress', $progress);
		$this->set('s', $s);
	}

	public function beta(){
		$this->LoadModel('User');
		$this->LoadModel('Tsumego');
		$this->LoadModel('TsumegoStatus');
		$this->LoadModel('Comment');
		$this->LoadModel('Favorite');
		$this->LoadModel('Comment');
		$this->LoadModel('UserSaMap');
		$this->LoadModel('SetConnection');

		$_SESSION['page'] = 'sandbox';
		$_SESSION['title'] = 'Tsumego Hero - Collections';

		if(isset($this->params['url']['restore'])){
			$restore = $this->Set->findById($this->params['url']['restore']);
			if($restore['Set']['public']==-1){
				$restore['Set']['public']=0;
				$this->Set->save($restore);
			}
		}
		$sa = $this->UserSaMap->find('all');

		$setsX = $this->Set->find('all', array(
			'fields' => array('Set.id', 'Set.title', 'Set.title2', 'Set.author', 'Set.description', 'Set.folder', 'Set.difficulty', 'Set.image', 'Set.order', 'Set.created', 'Set.color' ),
			'order' => array('Set.order'),
			'conditions' => array('public' => 0)
		));

		$secretPoints = 0;
		$removeMap = array();

		$removeMap[135] = 1;
		
		if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['id']==72){
				unset($removeMap[135]);
			}

			$u = $this->User->findById($_SESSION['loggedInUser']['User']['id']);
			if($_SESSION['loggedInUser']['User']['level'] >= 70){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 65){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 60){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 55){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 50){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 45){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 40){ $secretPoints++; }

			if($secretPoints>=7){ $u['User']['secretArea7'] = 1; $_SESSION['loggedInUser']['User']['secretArea7'] = 1; }
			if($secretPoints>=6){ $u['User']['secretArea6'] = 1; $_SESSION['loggedInUser']['User']['secretArea6'] = 1; }
			if($secretPoints>=5){ $u['User']['secretArea5'] = 1; $_SESSION['loggedInUser']['User']['secretArea5'] = 1; }
			if($secretPoints>=4){ $u['User']['secretArea4'] = 1; $_SESSION['loggedInUser']['User']['secretArea4'] = 1; }
			if($secretPoints>=3){ $u['User']['secretArea3'] = 1; $_SESSION['loggedInUser']['User']['secretArea3'] = 1; }
			if($secretPoints>=2){ $u['User']['secretArea2'] = 1; $_SESSION['loggedInUser']['User']['secretArea2'] = 1; }
			if($secretPoints>=1){ $u['User']['secretArea1'] = 1; $_SESSION['loggedInUser']['User']['secretArea1'] = 1; }

			if($_SESSION['loggedInUser']['User']['secretArea10']==0) $removeMap[88156] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea7']==0) $removeMap[81578] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea6']==0) $removeMap[74761] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea5']==0) $removeMap[71790] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea4']==0) $removeMap[33007] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea3']==0) $removeMap[31813] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea2']==0) $removeMap[29156] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea1']==0) $removeMap[11969] = 1;
		}else{
			$removeMap[11969] = 1;
			$removeMap[29156] = 1;
			$removeMap[31813] = 1;
			$removeMap[33007] = 1;
			$removeMap[71790] = 1;
			$removeMap[74761] = 1;
			$removeMap[81578] = 1;
			$removeMap[88156] = 1;
		}

		$sets = array();
		for($i=0; $i<count($setsX); $i++){
			if(!isset($removeMap[$setsX[$i]['Set']['id']])) array_push($sets, $setsX[$i]);
		}
		if(isset($_SESSION['loggedInUser'])){
			$uts = $this->TsumegoStatus->find('all', array('conditions' =>  array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			$utsMap = array();
			for($l=0; $l<count($uts); $l++){
				$utsMap[$uts[$l]['TsumegoStatus']['tsumego_id']] = $uts[$l]['TsumegoStatus']['status'];
			}
		}

		$globalSolvedCounter = 0;
		
		$overallCounter = 0;
		for($i=0; $i<count($sets); $i++){
			$ts = $this->findTsumegoSet($sets[$i]['Set']['id']);
			$sets[$i]['Set']['anz'] = count($ts);
			$counter = 0;

			if(isset($_SESSION['loggedInUser'])){
				for($k=0; $k<count($ts); $k++){
					if(isset($utsMap[$ts[$k]['Tsumego']['id']])){
						if($utsMap[$ts[$k]['Tsumego']['id']] == 'S' || $utsMap[$ts[$k]['Tsumego']['id']] == 'W' || $utsMap[$ts[$k]['Tsumego']['id']] == 'C'){
							$counter++;
							$globalSolvedCounter++;
						}
					}
				}
			}else{
				if(isset($_SESSION['noLogin'])){
					$noLogin = $_SESSION['noLogin'];
					$noLoginStatus = $_SESSION['noLoginStatus'];
					for($g=0; $g<count($noLogin); $g++){
						for($f=0; $f<count($ts); $f++){
							if($ts[$f]['Tsumego']['id']==$noLogin[$g]){
								$ts[$f]['Tsumego']['status'] = $noLoginStatus[$g];
								if($noLoginStatus[$g]=='S' || $noLoginStatus[$g]=='W' || $noLoginStatus[$g]=='C'){
									$counter++;
								}
							}
						}
					}
				}
			}

			$date = new DateTime($sets[$i]['Set']['created']);
			$month = date("F", strtotime($sets[$i]['Set']['created']));
			$setday = $date->format('d. ');
			$setyear = $date->format('Y');
			if($setday[0]==0) $setday = substr($setday, -3);
			$sets[$i]['Set']['created'] = $date->format('Ymd');
			$sets[$i]['Set']['createdDisplay'] = $setday.$month.' '.$setyear;
			$percent = 0;
			if(count($ts)>0) $percent = $counter/count($ts)*100;
			$overallCounter += count($ts);
			$sets[$i]['Set']['solvedNum'] = $counter;
			$sets[$i]['Set']['solved'] = round($percent, 1);
			$sets[$i]['Set']['solvedColor'] = $this->getSolvedColor($sets[$i]['Set']['solved']);
			$sets[$i]['Set']['topicColor'] = $sets[$i]['Set']['color'];
			$sets[$i]['Set']['difficultyColor'] = $this->getDifficultyColor($sets[$i]['Set']['difficulty']);
			$sets[$i]['Set']['sizeColor'] = $this->getSizeColor($sets[$i]['Set']['anz']);
			$sets[$i]['Set']['dateColor'] = $this->getDateColor($sets[$i]['Set']['created']);
		}

		$sortOrder = 'null';
		$sortColor = 'null';

		if(isset($_SESSION['loggedInUser'])){
			if(isset($_COOKIE['sortOrder']) && $_COOKIE['sortOrder']!= 'null'){
				$u['User']['sortOrder'] = $_COOKIE['sortOrder'];
				$sortOrder = $_COOKIE['sortOrder'];
				$_COOKIE['sortOrder'] = 'null';
				unset($_COOKIE['sortOrder']);
			}
			if(isset($_COOKIE['sortColor']) && $_COOKIE['sortColor']!= 'null'){
				$u['User']['sortColor'] = $_COOKIE['sortColor'];
				$sortColor = $_COOKIE['sortColor'];
				$_COOKIE['sortColor'] = 'null';
				unset($_COOKIE['sortColor']);
			}
			$this->User->save($u);
		}

		$accessList = $this->User->find('all', array('conditions' => array('completed' => 1)));
		$access = array();
		for($i=0; $i<count($accessList); $i++){
			array_push($access, $accessList[$i]['User']['name']);
		}

		$adminsList = $this->User->find('all', array('order' => 'id ASC', 'conditions' => array('isAdmin >' => 0)));
		$admins = array();
		for($i=0; $i<count($adminsList); $i++){
			array_push($admins, $adminsList[$i]['User']['name']);
		}

		$this->set('sortOrder', $sortOrder);
		$this->set('sortColor', $sortColor);
		$this->set('admins', $admins);
		$this->set('access', $access);
        $this->set('sets', $sets);
        $this->set('overallCounter', $overallCounter);
    }

	public function create($tid=null){
		$this->LoadModel('Tsumego');
		$this->LoadModel('SetConnection');
		$redirect = false;
		$t = array();
		if(isset($this->data['Set'])){
			$s = $this->Set->find('all', array('order' => 'id DESC'));
			$ss = array();
			for($i=0;$i<count($s);$i++){
				if($s[$i]['Set']['id']<6472) array_push($ss, $s[$i]);
			}

			$seed = str_split('abcdefghijklmnopqrstuvwxyz0123456789');
			shuffle($seed);
			$rand = '';
			foreach (array_rand($seed, 6) as $k) $rand .= $seed[$k];
			$hashName = '6473k339312/_'.$rand.'_'.$this->data['Set']['title'];
			$hashName2 = '_'.$rand.'_'.$this->data['Set']['title'];

			$set = array();
			$set['Set']['id'] = $ss[0]['Set']['id']+1;
			$set['Set']['title'] = $this->data['Set']['title'];
			$set['Set']['public'] = 0;
			$set['Set']['image'] = 'b1.png';
			$set['Set']['folder'] = $hashName2;
			$set['Set']['difficulty'] = 4;
			$set['Set']['author'] = 'various creators';
			$set['Set']['order'] = 999;

			$this->Set->create();
			$this->Set->save($set);

			$tMax = $this->Tsumego->find('first', array('order' => 'id DESC'));

			$t = array();
			$t['Tsumego']['id'] = $tMax['Tsumego']['id']+1;
			$t['Tsumego']['set_id'] = 206;
			$t['Tsumego']['num'] = 1;
			$t['Tsumego']['difficulty'] =  4;
			$t['Tsumego']['variance'] =  100;
			$t['Tsumego']['description'] =  'b to kill';
			$t['Tsumego']['author'] =  $_SESSION['loggedInUser']['User']['name'];
			$this->Tsumego->create();
			$this->Tsumego->save($t);
			
			$sc = array();
			$sc['SetConnection']['set_id'] = $ss[0]['Set']['id']+1;
			$sc['SetConnection']['tsumego_id'] = $tMax['Tsumego']['id']+1;
			$sc['SetConnection']['num'] = 1;
			$this->SetConnection->create();
			$this->SetConnection->save($sc);

			mkdir($hashName, 0777);
			copy('6473k339312/__new/1.sgf', $hashName.'/1.sgf');

			$redirect = true;
		}
		$this->set('t', $t);
		$this->set('redirect', $redirect);
	}

	public function remove($id){
		$this->LoadModel('Tsumego');
		$redirect = false;

		if(isset($this->data['Set'])){
			if(strpos(';'.$this->data['Set']['hash'], '6473k339312-')==1){
				$set = str_replace('6473k339312-', '', $this->data['Set']['hash']);

				$s = $this->Set->findById($set);
				if($s['Set']['public']==0 || $s['Set']['public']==-1) $this->Set->delete($set);

				//$ts = $this->Tsumego->find('all', array('conditions' => array('set_id' => $set)));
				$ts = $this->findTsumegoSet($set);	
				if(count($ts)<50){
					for($i=0;$i<count($ts);$i++){
						$this->Tsumego->delete($ts[$i]['Tsumego']['id']);
					}
				}
				$redirect = true;
			}
		}


		$this->set('t', $t);
		$this->set('redirect', $redirect);
	}

	public function add($tid){
		$this->LoadModel('Tsumego');

		if(isset($this->data['Tsumego'])){
			$t = array();
			$t['Tsumego']['num'] = $this->data['Tsumego']['num'];
			$t['Tsumego']['difficulty'] =  $this->data['Tsumego']['difficulty'];
			//$t['Tsumego']['set_id'] =  $this->data['Tsumego']['set_id'];
			$t['Tsumego']['variance'] =  $this->data['Tsumego']['variance'];
			$t['Tsumego']['description'] =  $this->data['Tsumego']['description'];
			$this->Tsumego->save($t);
		}
		$ts = $this->findTsumegoSet($tid);	
		//$ts = $this->Tsumego->find('all', array('order' => 'num DESC', 'conditions' => array('set_id' => $tid)));
		$this->set('t', $ts[0]);
	}


	private function newDate($date=null){
		$this->LoadModel('Tsumego');
		//$ts = $this->Tsumego->find('all', array('conditions' => array('set_id' => 94)));
		$ts = $this->findTsumegoSet(94);	
		for($i=0; $i<count($ts); $i++){
			if($ts[$i]['Tsumego']['num']>200 && $ts[$i]['Tsumego']['num']<=300){
				$ts[$i]['Tsumego']['created'] = $date;
				$this->Tsumego->save($ts[$i]);
			}
		}
	}

	public function index(){
		$this->LoadModel('User');
		$this->LoadModel('Tsumego');
		$this->LoadModel('TsumegoStatus');
		$this->LoadModel('Favorite');
		$this->LoadModel('AchievementCondition');
		$this->LoadModel('SetConnection');

		$_SESSION['page'] = 'set';
		$_SESSION['title'] = 'Tsumego Hero - Collections';

		$setsX = $this->Set->find('all', array(
			'order' => array('Set.order'),
			'conditions' => array('public' => 1)
		));

		$secretPoints = 0;
		$removeMap = array();
		$favorite = null;
		$overallCounter = 0;
		$achievementUpdate = 0;

		$removeMap[6473] = 1;

		if(isset($_SESSION['loggedInUser']['User']['id'])){
			if(isset($_COOKIE['sandbox']) && $_COOKIE['sandbox']!='0'){
				$ux = $this->User->findById($_SESSION['loggedInUser']['User']['id']);
				$ux['User']['reuse1'] = $_COOKIE['sandbox'];
				$_SESSION['loggedInUser']['User']['reuse1'] = $_COOKIE['sandbox'];
				$this->User->save($ux);
			}

			$u = $this->User->findById($_SESSION['loggedInUser']['User']['id']);

			if($_SESSION['loggedInUser']['User']['premium'] >= 1){
				$_SESSION['loggedInUser']['User']['secretArea7']=1;
				$_SESSION['loggedInUser']['User']['secretArea9']=1;
				$u['User']['secretArea7']=1;
				$u['User']['secretArea9']=1;
				unset($removeMap[6473]);
			}

			//if($_SESSION['loggedInUser']['User']['level'] >= 70){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 65){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 60){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 55){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 50){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 45){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 40){ $secretPoints++; }
			//$secretPoints += $_SESSION['loggedInUser']['User']['premium'];
			//if($secretPoints>=7){ $u['User']['secretArea7'] = 1; $_SESSION['loggedInUser']['User']['secretArea7'] = 1; }
			if($secretPoints>=6){ $u['User']['secretArea6'] = 1; $_SESSION['loggedInUser']['User']['secretArea6'] = 1; }
			if($secretPoints>=5){ $u['User']['secretArea5'] = 1; $_SESSION['loggedInUser']['User']['secretArea5'] = 1; }
			if($secretPoints>=4){ $u['User']['secretArea4'] = 1; $_SESSION['loggedInUser']['User']['secretArea4'] = 1; }
			if($secretPoints>=3){ $u['User']['secretArea3'] = 1; $_SESSION['loggedInUser']['User']['secretArea3'] = 1; }
			if($secretPoints>=2){ $u['User']['secretArea2'] = 1; $_SESSION['loggedInUser']['User']['secretArea2'] = 1; }
			if($secretPoints>=1){ $u['User']['secretArea1'] = 1; $_SESSION['loggedInUser']['User']['secretArea1'] = 1; }

			if($_SESSION['loggedInUser']['User']['secretArea10']==0) $removeMap[88156] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea7']==0) $removeMap[81578] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea6']==0) $removeMap[74761] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea5']==0) $removeMap[71790] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea4']==0) $removeMap[33007] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea3']==0) $removeMap[31813] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea2']==0) $removeMap[29156] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea1']==0) $removeMap[11969] = 1;
		}else{
			$removeMap[11969] = 1;
			$removeMap[29156] = 1;
			$removeMap[31813] = 1;
			$removeMap[33007] = 1;
			$removeMap[71790] = 1;
			$removeMap[74761] = 1;
			$removeMap[81578] = 1;
			$removeMap[88156] = 1;
		}
		$removeMap[42] = 1;
		$removeMap[72] = 1;
		$removeMap[73] = 1;
		$removeMap[74] = 1;
		$removeMap[75] = 1;
		$removeMap[76] = 1;
		$removeMap[77] = 1;
		$removeMap[78] = 1;
		$removeMap[79] = 1;
		$removeMap[80] = 1;

		$sets = array();
		for($i=0; $i<count($setsX); $i++){
			if(!isset($removeMap[$setsX[$i]['Set']['id']])) array_push($sets, $setsX[$i]);
		}
		if(isset($_SESSION['loggedInUser'])){
			$uts = $this->TsumegoStatus->find('all', array('conditions' =>  array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			$idMap = array();
			$statusMap = array();
			for($i=0; $i<count($uts); $i++){
				array_push($idMap, $uts[$i]['TsumegoStatus']['tsumego_id']);
				array_push($statusMap, $uts[$i]['TsumegoStatus']['status']);
			}
			$utsMap = array();
			for($l=0; $l<count($uts); $l++){
				$utsMap[$uts[$l]['TsumegoStatus']['tsumego_id']] = $uts[$l]['TsumegoStatus']['status'];
			}
		}
		/*
		$globalSolvedCounter = 0;
		$globalCounter = count($this->Tsumego->find('all'));
		$invisibleSets = $this->getInvisibleSets();
		for($i=0; $i<count($invisibleSets); $i++){
			$invisibleSet[$i] = count($this->Tsumego->find('all', array('conditions' => array('set_id' => $invisibleSets[$i]))));
			$globalCounter-=$invisibleSet[$i];
		}
		*/
		for($i=0; $i<count($sets); $i++){
			$ts = $this->findTsumegoSet($sets[$i]['Set']['id']);
			$sets[$i]['Set']['anz'] = count($ts);
			$counter = 0;

			if(isset($_SESSION['loggedInUser'])){
				for($k=0; $k<count($ts); $k++){
					if(isset($utsMap[$ts[$k]['Tsumego']['id']])){
						if($utsMap[$ts[$k]['Tsumego']['id']] == 'S' || $utsMap[$ts[$k]['Tsumego']['id']] == 'W' || $utsMap[$ts[$k]['Tsumego']['id']] == 'C'){
							$counter++;
							$globalSolvedCounter++;
						}
					}
				}
			}else{
				if(isset($_SESSION['noLogin'])){
					$noLogin = $_SESSION['noLogin'];
					$noLoginStatus = $_SESSION['noLoginStatus'];
					for($g=0; $g<count($noLogin); $g++){
						for($f=0; $f<count($ts); $f++){
							if($ts[$f]['Tsumego']['id']==$noLogin[$g]){
								$ts[$f]['Tsumego']['status'] = $noLoginStatus[$g];
								if($noLoginStatus[$g]=='S' || $noLoginStatus[$g]=='W' || $noLoginStatus[$g]=='C'){
									$counter++;
								}
							}
						}
					}
				}
			}

			$date = new DateTime($sets[$i]['Set']['created']);
			$month = date("F", strtotime($sets[$i]['Set']['created']));
			$setday = $date->format('d. ');
			$setyear = $date->format('Y');
			if($setday[0]==0) $setday = substr($setday, -3);
			$sets[$i]['Set']['created'] = $date->format('Ymd');
			$sets[$i]['Set']['createdDisplay'] = $setday.$month.' '.$setyear;

			$percent = $counter/count($ts)*100;
			$sets[$i]['Set']['solvedNum'] = $counter;
			$sets[$i]['Set']['solved'] = round($percent, 1);
			$sets[$i]['Set']['solvedColor'] = $this->getSolvedColor($sets[$i]['Set']['solved']);
			$sets[$i]['Set']['topicColor'] = $sets[$i]['Set']['color'];
			$sets[$i]['Set']['difficultyColor'] = $this->getDifficultyColor($sets[$i]['Set']['difficulty']);
			$sets[$i]['Set']['difficultyRank'] = $this->getTsumegoRank($sets[$i]['Set']['difficulty']);
			$sets[$i]['Set']['sizeColor'] = $this->getSizeColor($sets[$i]['Set']['anz']);
			$sets[$i]['Set']['dateColor'] = $this->getDateColor($sets[$i]['Set']['created']);
			
			if($sets[$i]['Set']['solved']>=100) $overallCounter++;
		}
		$sortOrder = 'null';
		$sortColor = 'null';

		if(isset($_SESSION['loggedInUser'])){
			if($overallCounter>=10){
				$aCondition = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
					'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 'set'
				)));
				if($aCondition==null) $aCondition = array();
				$aCondition['AchievementCondition']['category'] = 'set';
				$aCondition['AchievementCondition']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
				$aCondition['AchievementCondition']['value'] = $overallCounter;
				$this->AchievementCondition->save($aCondition);
			}
			
			if(isset($_COOKIE['sortOrder']) && $_COOKIE['sortOrder']!= 'null'){
				$u['User']['sortOrder'] = $_COOKIE['sortOrder'];
				$sortOrder = $_COOKIE['sortOrder'];
				$_COOKIE['sortOrder'] = 'null';
				unset($_COOKIE['sortOrder']);
			}
			if(isset($_COOKIE['sortColor']) && $_COOKIE['sortColor']!= 'null'){
				$u['User']['sortColor'] = $_COOKIE['sortColor'];
				$sortColor = $_COOKIE['sortColor'];
				$_COOKIE['sortColor'] = 'null';
				unset($_COOKIE['sortColor']);
				unset($_COOKIE['sortColor']);
			}
			$this->User->save($u);

			$favorite = $this->Favorite->find('all', array('conditions' => array('user_id' => $u['User']['id'])));
			
			$achievementUpdate = $this->checkSetCompletedAchievements();
			if(count($achievementUpdate)>0) $this->updateXP($_SESSION['loggedInUser']['User']['id'], $achievementUpdate);
		}
		
		if($favorite!=null){
			$difficultyCount = 0;
			$solvedCount = 0;
			$sizeCount = 0;
			for($i=0; $i<count($favorite); $i++){
				$tx = $this->Tsumego->findById($favorite[$i]['Favorite']['tsumego_id']);
				$difficultyCount += $tx['Tsumego']['difficulty'];
				//$utx = $this->TsumegoStatus->find('first', array('conditions' =>  array('tsumego_id' => $favorite[$i]['Favorite']['tsumego_id'], 'user_id' => $_SESSION['loggedInUser']['User']['id'])));
				$utx = $this->findUt($favorite[$i]['Favorite']['tsumego_id'], $uts, $idMap);
				if($utx['TsumegoStatus']['status'] == 'S' || $utx['TsumegoStatus']['status'] == 'W' || $utx['TsumegoStatus']['status'] == 'C') $solvedCount++;
				$sizeCount++;
			}
			$difficultyCount /= $sizeCount;
			if($difficultyCount<=2) $difficultyCount = 1;
			else if($difficultyCount>2 && $difficultyCount<=3) $difficultyCount = 2;
			else if($difficultyCount>3 && $difficultyCount<=4) $difficultyCount = 3;
			else if($difficultyCount>4 && $difficultyCount<=6) $difficultyCount = 4;
			else if($difficultyCount>6) $difficultyCount = 5;


			$percent = $solvedCount/$sizeCount*100;
			$fav[0]['Set']['solvedNum'] = $sizeCount;
			$fav[0]['Set']['solved'] = round($percent, 1);
			$fav[0]['Set']['solvedColor'] = '#eee';
			$fav[0]['Set']['difficultyColor'] = '#eee';
			$fav[0]['Set']['sizeColor'] = $this->getSizeColor($sizeCount);

			$fav[0]['Set']['id'] = 1;
			$fav[0]['Set']['title'] = 'Favorites';
			$fav[0]['Set']['title2'] = null;
			$fav[0]['Set']['author'] = $_SESSION['loggedInUser']['User']['name'];
			$fav[0]['Set']['description'] = '';
			$fav[0]['Set']['folder'] = '';
			$fav[0]['Set']['difficulty'] = '';
			$fav[0]['Set']['image'] = 'fav';
			$fav[0]['Set']['order'] = 0;
			$fav[0]['Set']['public'] = 1;
			$fav[0]['Set']['created'] = 20190507;
			$fav[0]['Set']['t'] = '222';
			$fav[0]['Set']['anz'] = $sizeCount;
			$fav[0]['Set']['createdDisplay'] = '7. May 2019';
			$fav[0]['Set']['topicColor'] = '#eee';
			$fav[0]['Set']['dateColor'] = '#eee';

			$sets = array_merge($fav, $sets);
		}
		
		$this->set('sortOrder', $sortOrder);
		$this->set('sortColor', $sortColor);
        $this->set('sets', $sets);
        $this->set('achievementUpdate', $achievementUpdate);
    }
	
	public function ui($id=null){
		$s = $this->Set->findById($id);
		$redirect = false;

		if(isset($_FILES['adminUpload'])){
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randstring = 'set_';
			for($i=0; $i<6; $i++){
				$randstring .= $characters[rand(0,strlen($characters))];
			}
			$filename = $randstring.'_'.$_FILES['adminUpload']['name'];
			//echo '<pre>'; print_r($filename); echo '</pre>';

			$errors= array();
			$file_name = $_FILES['adminUpload']['name'];
			$file_size =$_FILES['adminUpload']['size'];
			$file_tmp =$_FILES['adminUpload']['tmp_name'];
			$file_type=$_FILES['adminUpload']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['adminUpload']['name'])));
			$extensions= array("png", "jpg");

			if(in_array($file_ext,$extensions)=== false) $errors[]="png/jpg allowed.";
			if($file_size > 2097152) $errors[]='The file is too large.';

			if(empty($errors)==true){
				$uploadfile = $_SERVER['DOCUMENT_ROOT'].'/app/webroot/img/'.$filename;
				move_uploaded_file($file_tmp, $uploadfile);
			}else{
				print_r($errors);
			}

			$s['Set']['image'] = $filename;
			$this->Set->save($s);

			$redirect = true;
		}

		$this->set('id', $id);
		$this->set('s', $s);
		$this->set('redirect', $redirect);
	}

    public function view($id=null){
		$this->LoadModel('Tsumego');
		$this->LoadModel('TsumegoStatus');
		$this->LoadModel('Favorite');
		$this->LoadModel('AdminActivity');
		$this->LoadModel('Joseki');
		$this->LoadModel('TsumegoAttempt');
		$this->LoadModel('ProgressDeletion');
		$this->LoadModel('Achievement');
		$this->LoadModel('AchievementStatus');
		$this->LoadModel('AchievementCondition');
		$this->LoadModel('Sgf');
		$this->LoadModel('SetConnection');
		$_SESSION['page'] = 'set';
		
		$josekiOrder = 0;
		$tsIds = array();
		$refreshView = false;
		$avgTime = 0;
		$accuracy = 0;
		$formChange = false;
		$achievementUpdate = array();

		if(isset($_SESSION['loggedInUser']['User']['id'])){if($_SESSION['loggedInUser']['User']['isAdmin']>0){
			$aad = $this->AdminActivity->find('first', array('order' => 'id DESC'));
			if($aad['AdminActivity']['file'] == '/delete'){
				$scDelete = $this->SetConnection->find('first', array('order' => 'created DESC','conditions' => array('tsumego_id' => $aad['AdminActivity']['tsumego_id'])));
				$this->SetConnection->delete($scDelete['SetConnection']['id']);
				$this->Tsumego->delete($aad['AdminActivity']['tsumego_id']);
				$aad['AdminActivity']['file'] = 'description';
				$this->AdminActivity->save($aad);
			}
		}}

		if(isset($this->params['url']['add'])){
			$overallCount = $this->Tsumego->find('first', array('order' => 'id DESC'));
			$scTcount = $this->SetConnection->find('first', array('conditions' => array('set_id' => $id, 'num' => 1)));
			$setCount = $this->Tsumego->findById($scTcount['SetConnection']['tsumego_id']);
			$setCount['Tsumego']['id'] = $overallCount['Tsumego']['id'] + 1;
			$setCount['Tsumego']['set_id'] = $scTcount['SetConnection']['set_id'];
			$setCount['Tsumego']['num'] += 1;
			$setCount['Tsumego']['variance'] = 100;
			if($_SESSION['loggedInUser']['User']['id'] == 72) $setCount['Tsumego']['author'] = 'Joschka Zimdars';
			elseif($_SESSION['loggedInUser']['User']['id'] == 1206) $setCount['Tsumego']['author'] = 'Innokentiy Zabirov';
			elseif($_SESSION['loggedInUser']['User']['id'] == 3745) $setCount['Tsumego']['author'] = 'Dennis Olevanov';
			else $setCount['Tsumego']['author'] = $_SESSION['loggedInUser']['User']['name'];
			$this->Tsumego->create();
			$this->Tsumego->save($setCount);

			$adminActivity = array();
			$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$adminActivity['AdminActivity']['tsumego_id'] = 0;
			$adminActivity['AdminActivity']['file'] = 'description';
			$adminActivity['AdminActivity']['answer'] = 'Added problem for '.$set['Set']['title'];
			$this->AdminActivity->save($adminActivity);
		}

		if(isset($this->params['url']['show'])){
			if($this->params['url']['show']=='order') $josekiOrder = 1;
			if($this->params['url']['show']=='num') $josekiOrder = 0;
		}

		if($id!=1){
			$set = $this->Set->find('first', array('conditions' =>  array('id' => $id)));
			$ts = array();
			$scTs = $this->SetConnection->find('all', array('conditions' => array('set_id' => $set['Set']['id'])));
			
			$set['Set']['difficultyRank'] = $this->getTsumegoRank($set['Set']['difficulty']);
			
			for($i=0; $i<count($scTs); $i++){
				$scT = $this->Tsumego->findById($scTs[$i]['SetConnection']['tsumego_id']);
				$scT['Tsumego']['set_id'] = $scTs[$i]['SetConnection']['set_id'];
				$scT['Tsumego']['num'] = $scTs[$i]['SetConnection']['num'];
				$scT['Tsumego']['duplicateLink'] = '';
				$scTs2 = $this->SetConnection->find('all', array('conditions' => array('tsumego_id' => $scT['Tsumego']['id'])));
				for($j=0;$j<count($scTs2);$j++)
					if(count($scTs2)>1 && $scTs2[$j]['SetConnection']['set_id']==$set['Set']['id'])
						$scT['Tsumego']['duplicateLink'] = '?sid='.$scT['Tsumego']['set_id'];
				array_push($ts, $scT);
			}
			$tsBuffer = array();
			$tsBufferLowest=10000;
			$tsBufferHighest=0;
			for($i=0; $i<count($ts); $i++){
				$tsBuffer[$ts[$i]['Tsumego']['num']] = $ts[$i];
				if($ts[$i]['Tsumego']['num']<$tsBufferLowest)
					$tsBufferLowest = $ts[$i]['Tsumego']['num'];
				if($ts[$i]['Tsumego']['num']>$tsBufferHighest)
					$tsBufferHighest = $ts[$i]['Tsumego']['num'];
			}
			$ts = array();
			for($i=$tsBufferLowest; $i<=$tsBufferHighest; $i++)
				if(isset($tsBuffer[$i]))
					array_push($ts, $tsBuffer[$i]);
			
			$allVcActive = true;
			$allVcInactive = true;
			$allArActive = true;
			$allArInactive = true;
			$allPassActive = true;
			$allPassInactive = true;
			
			for($i=0; $i<count($ts); $i++){
				if($ts[$i]['Tsumego']['virtual_children']==0)
					$allVcActive = false;
				if($ts[$i]['Tsumego']['virtual_children']==1)
					$allVcInactive = false;
				if($ts[$i]['Tsumego']['alternative_response']==0)
					$allArActive = false;
				if($ts[$i]['Tsumego']['alternative_response']==1)
					$allArInactive = false;
				if($ts[$i]['Tsumego']['pass']==0)
					$allPassActive = false;
				if($ts[$i]['Tsumego']['pass']==1)
					$allPassInactive = false;
			}
			
			for($i=0; $i<count($ts); $i++) array_push($tsIds, $ts[$i]['Tsumego']['id']);
			
			if($set['Set']['public']==0) $_SESSION['page'] = 'sandbox';
			$this->set('isFav', false);

			if(isset($this->params['url']['sort'])){
				if($this->params['url']['sort']==1){
					$tsId = array();
					$tsNum = array();
					$tsOrder = array();
					for($i=0; $i<count($ts); $i++){
						array_push($tsId, $ts[$i]['Tsumego']['id']);
						array_push($tsNum, $ts[$i]['Tsumego']['num']);
						array_push($tsOrder, $ts[$i]['Tsumego']['order']);
					}
					array_multisort($tsOrder, $tsId, $tsNum);

					$nr = 1;
					for($i=0; $i<count($tsId); $i++){
						$tsu = $this->Tsumego->findById($tsId[$i]);
						if($tsu['Tsumego']['num']!=$nr) rename('6473k339312/joseki/'.$tsu['Tsumego']['num'].'.sgf','6473k339312/joseki/'.$tsu['Tsumego']['num'].'x.sgf');
						$nr++;
					}
					$nr = 1;
					for($i=0; $i<count($tsId); $i++){
						$tsu = $this->Tsumego->findById($tsId[$i]);
						if($tsu['Tsumego']['num']!=$nr){
							rename('6473k339312/joseki/'.$tsu['Tsumego']['num'].'x.sgf','6473k339312/joseki/'.$nr.'.sgf');
							$tsu['Tsumego']['num'] = $nr;
							$this->Tsumego->save($tsu);
						}
						$nr++;
					}
				}
			}
			if(isset($this->params['url']['rename'])){
				if($this->params['url']['rename']==1){
					$tsId = array();
					$tsNum = array();
					$tsOrder = array();
					for($i=0; $i<count($ts); $i++){
						array_push($tsId, $ts[$i]['Tsumego']['id']);
						array_push($tsNum, $ts[$i]['Tsumego']['num']);
						array_push($tsOrder, $ts[$i]['Tsumego']['order']);
					}
					array_multisort($tsOrder, $tsId, $tsNum);
					$nr = 1;
					for($i=0; $i<count($tsId); $i++){
						$j = $this->Joseki->find('first', array('conditions' =>  array('tsumego_id' => $tsId[$i])));
						$j['Joseki']['order'] = $nr;
						$this->Joseki->save($j);
						$nr++;
					}
				}
			}
			if(isset($this->params['url']['b'])){
				if($this->params['url']['b']==1){

				}
			}
			if(isset($this->data['Set']['title'])){
				if($set['Set']['title']!=$this->data['Set']['title']) $formChange = true;
				if($set['Set']['title2']!=$this->data['Set']['title2']) $formChange = true;
				$this->Set->create();
				$changeSet = $set;
				$changeSet['Set']['title'] = $this->data['Set']['title'];
				$changeSet['Set']['title2'] = $this->data['Set']['title2'];
				$this->set('data', $changeSet['Set']['title']);
				$this->Set->save($changeSet, true);
				$set = $this->Set->findById($id);
				$adminActivity = array();
				$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
				$adminActivity['AdminActivity']['tsumego_id'] = $ts[0]['Tsumego']['id'];
				$adminActivity['AdminActivity']['file'] = 'settings';
				$adminActivity['AdminActivity']['answer'] = 'Edited meta data for set '.$set['Set']['title'];
			}
			if(isset($this->data['Set']['description'])){
				if($set['Set']['description']!=$this->data['Set']['description']) $formChange = true;
				$this->Set->create();
				$changeSet = $set;
				$changeSet['Set']['description'] = $this->data['Set']['description'];
				$this->set('data', $changeSet['Set']['description']);
				$this->Set->save($changeSet, true);
				$set = $this->Set->findById($id);
				$adminActivity = array();
				$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
				$adminActivity['AdminActivity']['tsumego_id'] = $ts[0]['Tsumego']['id'];
				$adminActivity['AdminActivity']['file'] = 'settings';
				$adminActivity['AdminActivity']['answer'] = 'Edited meta data for set '.$set['Set']['title'];
			}
			if(isset($this->data['Set']['color'])){
				if($set['Set']['color']!=$this->data['Set']['color']) $formChange = true;
				$this->Set->create();
				$changeSet = $set;
				$changeSet['Set']['color'] = $this->data['Set']['color'];
				$this->set('data', $changeSet['Set']['color']);
				$this->Set->save($changeSet, true);
				$set = $this->Set->findById($id);
				$adminActivity = array();
				$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
				$adminActivity['AdminActivity']['tsumego_id'] = $ts[0]['Tsumego']['id'];
				$adminActivity['AdminActivity']['file'] = 'settings';
				$adminActivity['AdminActivity']['answer'] = 'Edited meta data for set '.$set['Set']['title'];
				$this->AdminActivity->save($adminActivity);
			}
			if(isset($this->data['Set']['order'])){
				if($set['Set']['order']!=$this->data['Set']['order']) $formChange = true;
				$this->Set->create();
				$changeSet = $set;
				$changeSet['Set']['order'] = $this->data['Set']['order'];
				$this->set('data', $changeSet['Set']['order']);
				$this->Set->save($changeSet, true);
				$set = $this->Set->findById($id);
				$adminActivity = array();
				$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
				$adminActivity['AdminActivity']['tsumego_id'] = $ts[0]['Tsumego']['id'];
				$adminActivity['AdminActivity']['file'] = 'settings';
				$adminActivity['AdminActivity']['answer'] = 'Edited meta data for set '.$set['Set']['title'];
				$this->AdminActivity->save($adminActivity);
			}
			if(isset($this->data['Settings'])){
				if($this->data['Settings']['r38'] == 'on'){
					for($i=0; $i<count($ts); $i++){
						$ts[$i]['Tsumego']['virtual_children'] = 1;
						$this->Tsumego->save($ts[$i]);
					}
					$allVcActive = true;
					$adminActivity = array();
					$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$adminActivity['AdminActivity']['tsumego_id'] = $ts[0]['Tsumego']['id'];
					$adminActivity['AdminActivity']['file'] = 'settings';
					$adminActivity['AdminActivity']['answer'] = 'Turned on merge recurring positions for set '.$set['Set']['title'];
					$this->AdminActivity->save($adminActivity);
					
				}
				if($this->data['Settings']['r38'] == 'off'){
					for($i=0; $i<count($ts); $i++){
						$ts[$i]['Tsumego']['virtual_children'] = 0;
						$this->Tsumego->save($ts[$i]);
					}
					$allVcInactive = true;
					$adminActivity = array();
					$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$adminActivity['AdminActivity']['tsumego_id'] = $ts[0]['Tsumego']['id'];
					$adminActivity['AdminActivity']['file'] = 'settings';
					$adminActivity['AdminActivity']['answer'] = 'Turned off merge recurring positions for set '.$set['Set']['title'];
					$this->AdminActivity->save($adminActivity);
				}
				if($this->data['Settings']['r39'] == 'on'){
					for($i=0; $i<count($ts); $i++){
						$ts[$i]['Tsumego']['alternative_response'] = 1;
						$this->Tsumego->save($ts[$i]);
					}
					$allArActive = true;
					$adminActivity = array();
					$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$adminActivity['AdminActivity']['tsumego_id'] = $ts[0]['Tsumego']['id'];
					$adminActivity['AdminActivity']['file'] = 'settings';
					$adminActivity['AdminActivity']['answer'] = 'Turned on alternative response mode for set '.$set['Set']['title'];
					$this->AdminActivity->save($adminActivity);
				}
				if($this->data['Settings']['r39'] == 'off'){
					for($i=0; $i<count($ts); $i++){
						$ts[$i]['Tsumego']['alternative_response'] = 0;
						$this->Tsumego->save($ts[$i]);
					}
					$allArInactive = true;
					$adminActivity = array();
					$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$adminActivity['AdminActivity']['tsumego_id'] = $ts[0]['Tsumego']['id'];
					$adminActivity['AdminActivity']['file'] = 'settings';
					$adminActivity['AdminActivity']['answer'] = 'Turned off alternative response mode for set '.$set['Set']['title'];
					$this->AdminActivity->save($adminActivity);
				}
				if($this->data['Settings']['r43'] == 'yes'){
					for($i=0; $i<count($ts); $i++){
						$ts[$i]['Tsumego']['pass'] = 1;
						$this->Tsumego->save($ts[$i]);
					}
					$allPassActive = true;
					$adminActivity = array();
					$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$adminActivity['AdminActivity']['tsumego_id'] = $ts[0]['Tsumego']['id'];
					$adminActivity['AdminActivity']['file'] = 'settings';
					$adminActivity['AdminActivity']['answer'] = 'Enabled passing for set '.$set['Set']['title'];
					$this->AdminActivity->save($adminActivity);
				}
				if($this->data['Settings']['r43'] == 'no'){
					for($i=0; $i<count($ts); $i++){
						$ts[$i]['Tsumego']['pass'] = 0;
						$this->Tsumego->save($ts[$i]);
					}
					$allPassInactive = true;
					$adminActivity = array();
					$adminActivity['AdminActivity']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$adminActivity['AdminActivity']['tsumego_id'] = $ts[0]['Tsumego']['id'];
					$adminActivity['AdminActivity']['file'] = 'settings';
					$adminActivity['AdminActivity']['answer'] = 'Disabled passing for set '.$set['Set']['title'];
					$this->AdminActivity->save($adminActivity);
				}
				$this->set('formRedirect', true);
			}
			if(isset($this->data['Tsumego'])){
				if(!$formChange){
					$scFormChange = $this->SetConnection->find('first', array('order' => 'num DESC', 'conditions' => array('set_id' => $id)));
					$tFormChange = $this->Tsumego->findById($scFormChange['SetConnection']['tsumego_id']);
					$tf = array();
					$tf['Tsumego']['num'] = $this->data['Tsumego']['num'];
					$tf['Tsumego']['difficulty'] = 40;
					$tf['Tsumego']['set_id'] =  $id;
					$tf['Tsumego']['variance'] =  $this->data['Tsumego']['variance'];
					$tf['Tsumego']['description'] =  $this->data['Tsumego']['description'];
					$tf['Tsumego']['hint'] =  $this->data['Tsumego']['hint'];
					$tf['Tsumego']['author'] =  $this->data['Tsumego']['author'];
					$tf['Tsumego']['elo_rating_mode'] = $tFormChange['Tsumego']['elo_rating_mode'];
					if(is_numeric($this->data['Tsumego']['num'])){
						if($this->data['Tsumego']['num']>=0){
							$this->Tsumego->create();
							$this->Tsumego->save($tf);
							$tfSetHighestId = $this->Tsumego->find('first', array('order' => 'id DESC'));
							$tfSetConnection = array();
							$tfSetConnection['SetConnection']['set_id'] = $id;
							$tfSetConnection['SetConnection']['tsumego_id'] = $tfSetHighestId['Tsumego']['id'];
							$tfSetConnection['SetConnection']['num'] = $this->data['Tsumego']['num'];
							$this->SetConnection->create();
							$this->SetConnection->save($tfSetConnection);
						}
					}
					$tsIds = array();
					//$ts = $this->Tsumego->find('all', array('order' => 'num', 'direction' => 'DESC', 'conditions' => array('set_id' => $id)));
					$ts = $this->findTsumegoSet($id);
					for($i=0; $i<count($ts); $i++) 
						array_push($tsIds, $ts[$i]['Tsumego']['id']);
				}
			}
		}else{
			$allUts = $this->TsumegoStatus->find('all', array('conditions' =>  array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			$idMap = array();
			$statusMap = array();
			for($i=0; $i<count($allUts); $i++){
				array_push($idMap, $allUts[$i]['TsumegoStatus']['tsumego_id']);
				array_push($statusMap, $allUts[$i]['TsumegoStatus']['status']);
			}
			$fav = $this->Favorite->find('all', array('order' => 'created',	'direction' => 'DESC', 'conditions' =>  array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			
			if(count($fav)>0)
				$achievementUpdate = $this->checkSetAchievements(-1);
			
			$ts = array();
			$difficultyCount = 0;
			$solvedCount = 0;
			$sizeCount = 0;
			for($i=0; $i<count($fav); $i++){
				$tx = $this->Tsumego->find('first', array('conditions' =>  array('id' => $fav[$i]['Favorite']['tsumego_id'])));
				$difficultyCount += $tx['Tsumego']['difficulty'];
				$utx = $this->findUt($fav[$i]['Favorite']['tsumego_id'], $allUts, $idMap);
				if($utx['TsumegoStatus']['status'] == 'S' || $utx['TsumegoStatus']['status'] == 'W' || $utx['TsumegoStatus']['status'] == 'C') $solvedCount++;
				$sizeCount++;
				array_push($ts, $tx);
			}
			for($i=0; $i<count($allUts); $i++){
				for($j=0; $j<count($ts); $j++){
					if($allUts[$i]['TsumegoStatus']['tsumego_id'] == $ts[$j]['Tsumego']['id']){
						$ts[$j]['Tsumego']['status'] = $allUts[$i]['TsumegoStatus']['status'];
					}
				}
			}

			$difficultyCount /= $sizeCount;
			if($difficultyCount<=2) $difficultyCount = 1;
			else if($difficultyCount>2 && $difficultyCount<=3) $difficultyCount = 2;
			else if($difficultyCount>3 && $difficultyCount<=4) $difficultyCount = 3;
			else if($difficultyCount>4 && $difficultyCount<=6) $difficultyCount = 4;
			else if($difficultyCount>6) $difficultyCount = 5;

			$percent = $solvedCount/$sizeCount*100;

			$set = array();
			$set['Set']['id'] = 1;
			$set['Set']['title'] = 'Favorites';
			$set['Set']['title2'] = null;
			$set['Set']['author'] = $_SESSION['loggedInUser']['User']['name'];
			$set['Set']['description'] = '';
			$set['Set']['folder'] = '';
			$set['Set']['difficulty'] = $difficultyCount;
			$set['Set']['image'] = 'fav';
			$set['Set']['order'] = 0;
			$set['Set']['public'] = 1;
			$set['Set']['created'] = 20180322;
			$set['Set']['t'] = '222';
			$set['Set']['anz'] = (int) 50;
			$set['Set']['createdDisplay'] = '22. March 2018';
			$set['Set']['solvedNum'] = $sizeCount;
			$set['Set']['solved'] = round($percent, 1);
			$set['Set']['solvedColor'] = '#eee';
			$set['Set']['topicColor'] = '#eee';
			$set['Set']['difficultyColor'] = '#eee';
			$set['Set']['sizeColor'] = '#eee';
			$set['Set']['dateColor'] = '#eee';

			$this->set('isFav', true);
		}
		$_SESSION['title'] = $set['Set']['title'].' on Tsumego Hero';
		$set['Set']['anz'] = count($ts);

		if(isset($_SESSION['loggedInUser']['User']['id'])){
			$uts = $this->TsumegoStatus->find('all', array('conditions' =>  array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'],
				'tsumego_id' => $tsIds
			)));
			$ur = $this->TsumegoAttempt->find('all', array('order' => 'created DESC', 'conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'],
				'tsumego_id' => $tsIds
			)));
			for($i=0; $i<count($uts); $i++){
				for($j=0; $j<count($ts); $j++){
					if($uts[$i]['TsumegoStatus']['tsumego_id'] == $ts[$j]['Tsumego']['id']){
						$ts[$j]['Tsumego']['status'] = $uts[$i]['TsumegoStatus']['status'];
					}
				}
			}
			for($i=0; $i<count($ts); $i++){
				$urTemp = array();
				$urSum = '';
				$ts[$i]['Tsumego']['seconds'] = 0;
				for($j=0; $j<count($ur); $j++){
					if($ts[$i]['Tsumego']['id'] == $ur[$j]['TsumegoAttempt']['tsumego_id']){
						array_push($urTemp, $ur[$j]);

						if($ur[$j]['TsumegoAttempt']['solved']==1){
							$ts[$i]['Tsumego']['seconds'] = $ur[$j]['TsumegoAttempt']['seconds'];
						}
						if($ur[$j]['TsumegoAttempt']['solved']==0){
							$mis = $ur[$j]['TsumegoAttempt']['misplays'];

							if($mis==0) $mis=1;
							while($mis>0){
								$urSum.='F';
								$mis--;
							}
						}else{
							$urSum.=$ur[$j]['TsumegoAttempt']['solved'];
						}
					}
					
				}
				$ts[$i]['Tsumego']['performance'] = $urSum;
			}
			$counter = 0;
			for($j=0; $j<count($uts); $j++){
				for($k=0; $k<count($ts); $k++){
					if($uts[$j]['TsumegoStatus']['tsumego_id']==$ts[$k]['Tsumego']['id'] && ($uts[$j]['TsumegoStatus']['status']=='S' || $uts[$j]['TsumegoStatus']['status']=='W' || $uts[$j]['TsumegoStatus']['status']=='C')){
						$counter++;
					}
				}
			}
			$percent = $counter/count($ts)*100;
			$set['Set']['solved'] = round($percent, 1);
		}

		if(!isset($_SESSION['loggedInUser'])){
			$counter = 0;
			if(isset($_SESSION['noLogin'])){
				$noLogin = $_SESSION['noLogin'];
				$noLoginStatus = $_SESSION['noLoginStatus'];
				for($i=0; $i<count($noLogin); $i++){
					for($f=0; $f<count($ts); $f++){
						if($ts[$f]['Tsumego']['id']==$noLogin[$i]){
							$ts[$f]['Tsumego']['status'] = $noLoginStatus[$i];
							if($noLoginStatus[$i]=='S' || $noLoginStatus[$i]=='W' || $noLoginStatus[$i]=='C'){
								$counter++;
							}
						}
					}
				}
			}
			$percent = $counter/count($ts)*100;
			$set['Set']['solved'] = round($percent, 1);
		}

		$scTt = $this->SetConnection->find('first', array('conditions' => array('set_id' => $set['Set']['id'], 'num' => 1)));
		if($scTt!=null)
			$t = $this->Tsumego->findById($scTt['SetConnection']['tsumego_id']);
		else
			$t = null;
		if($t==null) $t = $ts[0];
		$set['Set']['t'] = $t['Tsumego']['id'];
		
		$tfs = $this->findTsumegoSet($id);
		$scoring = true;
		if(isset($_SESSION['loggedInUser'])){
			if(isset($this->data['Comment']['reset'])){
				if($this->data['Comment']['reset']=='reset'){
					for($i=0; $i<count($ur); $i++){
						$this->TsumegoAttempt->delete($ur[$i]['TsumegoAttempt']['id']);
					}
					for($i=0; $i<count($uts); $i++){
						$this->TsumegoStatus->delete($uts[$i]['TsumegoStatus']['id']);
					}
					$pr = array();
					$pr['ProgressDeletion']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
					$pr['ProgressDeletion']['set_id'] = $id;
					$this->ProgressDeletion->create();
					$this->ProgressDeletion->save($pr);
					$refreshView = true;
				}
			}
			$pd = $this->ProgressDeletion->find('all', array('conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'],
				'set_id' => $id
			)));
			$pdCounter = 0;
			for($i=0; $i<count($pd); $i++){
				$date = date_create($pd[$i]['ProgressDeletion']['created']);
				$pd[$i]['ProgressDeletion']['d'] = $date->format('Y').'-'.$date->format('m');
				if(date('Y-m')==$pd[$i]['ProgressDeletion']['d']) $pdCounter++;
			}

			$urSecCounter = 0;
			$urSecAvg = 0;
			$pSsum = 0;
			$pFsum = 0;
			for($i=0; $i<count($ts); $i++){
				$tss = 0;
				if($ts[$i]['Tsumego']['seconds']=='' || $ts[$i]['Tsumego']['seconds']==0){
					if($ts[$i]['Tsumego']['status']=='S' || $ts[$i]['Tsumego']['status']=='C' || $ts[$i]['Tsumego']['status']=='W')
						$tss = 60;
					else
						$tss = 0;
				}else{
					$tss = $ts[$i]['Tsumego']['seconds'];
				}
				$urSecAvg += $tss;
				$urSecCounter++;
				
				$tss2 = 'F';
				if($ts[$i]['Tsumego']['performance']==''){
					if($ts[$i]['Tsumego']['status']=='S' || $ts[$i]['Tsumego']['status']=='C' || $ts[$i]['Tsumego']['status']=='W')
						$tss2 = 'F';
					else
						$tss2 = '';
				}else{
					$tss2 = $ts[$i]['Tsumego']['performance'];
				}
				$pS = substr_count($tss2, '1');
				$pF = substr_count($tss2, 'F');
				$pSsum += $pS;
				$pFsum += $pF;
			}
			
			if($urSecCounter==0)
				$avgTime = 60;
			else
				$avgTime = round($urSecAvg/$urSecCounter, 2);
			if($pSsum+$pFsum == 0)
				$accuracy = 0;
			else
				$accuracy = round($pSsum/($pSsum+$pFsum)*100, 2);
			
			$avgTime2 = $avgTime; 
			
			$achievementUpdate2 = array();
			if($set['Set']['solved']>=100){
				if($set['Set']['id']!=210){
					$this->updateAchievementConditions($set['Set']['id'], $avgTime2, $accuracy);
					$achievementUpdate1 = $this->checkSetAchievements($set['Set']['id']);
				}
				if($id==50||$id==52||$id==53||$id==54){
					$achievementUpdate2 = $this->setAchievementSpecial('cc1');
				}else if($id==41||$id==49||$id==65||$id==66){
					$achievementUpdate2 = $this->setAchievementSpecial('cc2');
				}else if($id==186||$id==187||$id==196||$id==203){
					$achievementUpdate2 = $this->setAchievementSpecial('cc3');
				}else if($id==190||$id==193||$id==198){
					$achievementUpdate2 = $this->setAchievementSpecial('1000w1');
				}else if($id==216){
					$achievementUpdate2 = $this->setAchievementSpecial('1000w2');
				}
				$achievementUpdate = array_merge($achievementUpdate1, $achievementUpdate2);
			}
			if(count($achievementUpdate)>0) $this->updateXP($_SESSION['loggedInUser']['User']['id'], $achievementUpdate);
			
			$acS = $this->AchievementCondition->find('first', array('order' => 'value ASC', 'conditions' => array(
				'set_id' => $id, 'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => 's'
			)));
			$acA = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array(
				'set_id' => $id, 'user_id' => $_SESSION['loggedInUser']['User']['id'], 'category' => '%'
			)));
		}else{
			$scoring = false;
		}
		
		$tooltipSgfs = array();
		$tooltipInfo = array();
		$tooltipBoardSize = array();
		for($i=0; $i<count($ts); $i++){
			$tts = $this->Sgf->find('all', array('limit' => 1, 'order' => 'created DESC', 'conditions' => array('tsumego_id' => $ts[$i]['Tsumego']['id'])));
			$tArr = $this->processSGF($tts[0]['Sgf']['sgf']);
			array_push($tooltipSgfs, $tArr[0]);
			array_push($tooltipInfo, $tArr[2]);
			array_push($tooltipBoardSize, $tArr[3]);
		}
		
		
		$this->set('tfs', $tfs[count($tfs)-1]);
		$this->set('ts', $ts);
		$this->set('set', $set);
		$this->set('josekiOrder', $josekiOrder);
		$this->set('refreshView', $refreshView);
		$this->set('avgTime', $avgTime);
		$this->set('accuracy', $accuracy);
		$this->set('scoring', $scoring);
        $this->set('allVcActive', $allVcActive);
        $this->set('allVcInactive', $allVcInactive);
        $this->set('allArActive', $allArActive);
        $this->set('allArInactive', $allArInactive);
		$this->set('allPassActive', $allPassActive);
        $this->set('allPassInactive', $allPassInactive);
        $this->set('pdCounter', $pdCounter);
		$this->set('acS', $acS);
		$this->set('acA', $acA);
		$this->set('achievementUpdate', $achievementUpdate);
		$this->set('tooltipSgfs', $tooltipSgfs);
		$this->set('tooltipInfo', $tooltipInfo);
		$this->set('tooltipBoardSize', $tooltipBoardSize);
    }
	
	public function download_archive(){
		
		$s = $this->Set->find('all', array('order' => 'id ASC', 'conditions' => array(
			'OR' => array(
				array('public' => 1),
				array('public' => 0)
			)
		)));
		
		$text = file_get_contents('download_archive.txt');
		
		echo '<pre>'; print_r($text); echo '</pre>';
		echo '<pre>'; print_r($s[$text]['Set']['id']); echo '</pre>';
		echo '<pre>'; print_r(count($s)); echo '</pre>';
		
		$text2 = $text+1;
		file_put_contents('download_archive.txt', $text2);
		
		$this->set('text', $text);
		$this->set('s', $s);
	}
	
	public function download_archive2($id=null){
		$this->loadModel('Tsumego');
		$this->loadModel('SetConnection');
		$this->loadModel('Sgf');
		
		$title='';
		$t=array();
		
		if($_SESSION['loggedInUser']['User']['id']==72){
			$s = $this->Set->findById($id);
			$title = $s['Set']['title'].' '.$s['Set']['title2'];
			
			$title = str_replace(':', '', $title);
			
			if($s['Set']['public']!=1)
				$title .= ' (sandbox)';
			
			mkdir('download_archive/'.$title);
			
			$ts = array();
			$scTs = $this->SetConnection->find('all', array('conditions' => array('set_id' => $id)));
			
			for($i=0; $i<count($scTs); $i++){
				$scT = $this->Tsumego->findById($scTs[$i]['SetConnection']['tsumego_id']);
				$scT['Tsumego']['set_id'] = $scTs[$i]['SetConnection']['set_id'];
				$scT['Tsumego']['num'] = $scTs[$i]['SetConnection']['num'];
				$scT['Tsumego']['duplicateLink'] = '';
				$scTs2 = $this->SetConnection->find('all', array('conditions' => array('tsumego_id' => $scT['Tsumego']['id'])));
				for($j=0;$j<count($scTs2);$j++)
					if(count($scTs2)>1 && $scTs2[$j]['SetConnection']['set_id']==$set['Set']['id'])
						$scT['Tsumego']['duplicateLink'] = '?sid='.$scT['Tsumego']['set_id'];
				
				array_push($ts, $scT);
			}
			
			$tsBuffer = array();
			$tsBufferLowest=10000;
			$tsBufferHighest=0;
			for($i=0; $i<count($ts); $i++){
				$tsBuffer[$ts[$i]['Tsumego']['num']] = $ts[$i];
				if($ts[$i]['Tsumego']['num']<$tsBufferLowest)
					$tsBufferLowest = $ts[$i]['Tsumego']['num'];
				if($ts[$i]['Tsumego']['num']>$tsBufferHighest)
					$tsBufferHighest = $ts[$i]['Tsumego']['num'];
			}
			
			
			$t = array();
			for($i=$tsBufferLowest; $i<=$tsBufferHighest; $i++)
				if(isset($tsBuffer[$i]))
					array_push($t, $tsBuffer[$i]);
			
			for($i=0; $i<count($t); $i++){
				$t[$i]['Tsumego']['title'] = $s['Set']['title'].' '.$t[$i]['Tsumego']['num'];
				$sgf = $this->Sgf->find('first', array('order' => 'created DESC', 'conditions' =>  array('tsumego_id' => $t[$i]['Tsumego']['id'])));
				$sgf['Sgf']['sgf'] = str_replace("\r", '', $sgf['Sgf']['sgf']);
				//$sgf['Sgf']['sgf'] = str_replace("\n", '"+"\n"+"', $sgf['Sgf']['sgf']);
				$t[$i]['Tsumego']['sgf'] = $sgf['Sgf']['sgf'];
				
				file_put_contents('download_archive/'.$title.'/'.$t[$i]['Tsumego']['title'].'.sgf', $t[$i]['Tsumego']['sgf']);
			}
		}
		
		$this->set('title', $title);
		$this->set('t', $t);
	}
	
	public function updateAchievementConditions($sid, $avgTime, $accuracy){
		$uid = $_SESSION['loggedInUser']['User']['id'];
		$acS = $this->AchievementCondition->find('first', array('order' => 'value ASC', 'conditions' => array('set_id' => $sid, 'user_id' => $uid, 'category' => 's')));
		$acA = $this->AchievementCondition->find('first', array('order' => 'value DESC', 'conditions' => array('set_id' => $sid, 'user_id' => $uid, 'category' => '%')));
		
		if($acS==null){
			$aCond = array();
			$aCond['AchievementCondition']['user_id'] = $uid;
			$aCond['AchievementCondition']['set_id'] = $sid;
			$aCond['AchievementCondition']['value'] = $avgTime;
			$aCond['AchievementCondition']['category'] = 's';
			$this->AchievementCondition->create();
			$this->AchievementCondition->save($aCond);
		}else{
			if($avgTime < $acS['AchievementCondition']['value']){
				$acS['AchievementCondition']['value'] = $avgTime;
				$this->AchievementCondition->save($acS);
			}
		}
		if($acA==null){
			$aCond = array();
			$aCond['AchievementCondition']['user_id'] = $uid;
			$aCond['AchievementCondition']['set_id'] = $sid;
			$aCond['AchievementCondition']['value'] = $accuracy;
			$aCond['AchievementCondition']['category'] = '%';
			$this->AchievementCondition->create();
			$this->AchievementCondition->save($aCond);
		}else{
			if($accuracy > $acA['AchievementCondition']['value']){
				$acA['AchievementCondition']['value'] = $accuracy;
				$this->AchievementCondition->save($acA);
			}
		}
	}
	
	public function beta2(){
		$this->LoadModel('User');
		$this->LoadModel('Tsumego');
		$this->LoadModel('TsumegoStatus');

		$_SESSION['page'] = 'sandbox';
		$_SESSION['title'] = 'Deleted Collections';

		if(isset($this->params['url']['remove'])){
			$remove = $this->Set->findById($this->params['url']['remove']);
			if($remove['Set']['public']==0){
				$remove['Set']['public']=-1;
				$this->Set->save($remove);
			}
		}

		$setsX = $this->Set->find('all', array(
			'order' => array('Set.order'),
			'conditions' => array('public' => -1)
		));

		$secretPoints = 0;
		$removeMap = array();

		if(isset($_SESSION['loggedInUser'])){
			$u = $this->User->findById($_SESSION['loggedInUser']['User']['id']);
			if($_SESSION['loggedInUser']['User']['level'] >= 70){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 65){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 60){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 55){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 50){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 45){ $secretPoints++; }
			if($_SESSION['loggedInUser']['User']['level'] >= 40){ $secretPoints++; }

			//$secretPoints += $_SESSION['loggedInUser']['User']['premium'];

			if($secretPoints>=7){ $u['User']['secretArea7'] = 1; $_SESSION['loggedInUser']['User']['secretArea7'] = 1; }
			if($secretPoints>=6){ $u['User']['secretArea6'] = 1; $_SESSION['loggedInUser']['User']['secretArea6'] = 1; }
			if($secretPoints>=5){ $u['User']['secretArea5'] = 1; $_SESSION['loggedInUser']['User']['secretArea5'] = 1; }
			if($secretPoints>=4){ $u['User']['secretArea4'] = 1; $_SESSION['loggedInUser']['User']['secretArea4'] = 1; }
			if($secretPoints>=3){ $u['User']['secretArea3'] = 1; $_SESSION['loggedInUser']['User']['secretArea3'] = 1; }
			if($secretPoints>=2){ $u['User']['secretArea2'] = 1; $_SESSION['loggedInUser']['User']['secretArea2'] = 1; }
			if($secretPoints>=1){ $u['User']['secretArea1'] = 1; $_SESSION['loggedInUser']['User']['secretArea1'] = 1; }

			if($_SESSION['loggedInUser']['User']['secretArea10']==0) $removeMap[88156] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea7']==0) $removeMap[81578] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea6']==0) $removeMap[74761] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea5']==0) $removeMap[71790] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea4']==0) $removeMap[33007] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea3']==0) $removeMap[31813] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea2']==0) $removeMap[29156] = 1;
			if($_SESSION['loggedInUser']['User']['secretArea1']==0) $removeMap[11969] = 1;
		}else{
			$removeMap[11969] = 1;
			$removeMap[29156] = 1;
			$removeMap[31813] = 1;
			$removeMap[33007] = 1;
			$removeMap[71790] = 1;
			$removeMap[74761] = 1;
			$removeMap[81578] = 1;
			$removeMap[88156] = 1;
		}

		$sets = array();
		for($i=0; $i<count($setsX); $i++){
			if(!isset($removeMap[$setsX[$i]['Set']['id']])) array_push($sets, $setsX[$i]);
		}
		if(isset($_SESSION['loggedInUser'])){
			$uts = $this->TsumegoStatus->find('all', array('conditions' =>  array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			$utsMap = array();
			for($l=0; $l<count($uts); $l++){
				$utsMap[$uts[$l]['TsumegoStatus']['tsumego_id']] = $uts[$l]['TsumegoStatus']['status'];
			}
		}

		for($i=0; $i<count($sets); $i++){
			$ts = $this->findTsumegoSet($sets[$i]['Set']['id']);	
			$sets[$i]['Set']['anz'] = count($ts);
			$counter = 0;

			if(isset($_SESSION['loggedInUser'])){
				for($k=0; $k<count($ts); $k++){
					if(isset($utsMap[$ts[$k]['Tsumego']['id']])){
						if($utsMap[$ts[$k]['Tsumego']['id']] == 'S' || $utsMap[$ts[$k]['Tsumego']['id']] == 'W' || $utsMap[$ts[$k]['Tsumego']['id']] == 'C'){
							$counter++;
							$globalSolvedCounter++;
						}
					}
				}
			}else{
				if(isset($_SESSION['noLogin'])){
					$noLogin = $_SESSION['noLogin'];
					$noLoginStatus = $_SESSION['noLoginStatus'];
					for($g=0; $g<count($noLogin); $g++){
						for($f=0; $f<count($ts); $f++){
							if($ts[$f]['Tsumego']['id']==$noLogin[$g]){
								$ts[$f]['Tsumego']['status'] = $noLoginStatus[$g];
								if($noLoginStatus[$g]=='S' || $noLoginStatus[$g]=='W' || $noLoginStatus[$g]=='C'){
									$counter++;
								}
							}
						}
					}
				}
			}

			$date = new DateTime($sets[$i]['Set']['created']);
			$month = date("F", strtotime($sets[$i]['Set']['created']));
			$setday = $date->format('d. ');
			$setyear = $date->format('Y');
			if($setday[0]==0) $setday = substr($setday, -3);
			$sets[$i]['Set']['created'] = $date->format('Ymd');
			$sets[$i]['Set']['createdDisplay'] = $setday.$month.' '.$setyear;

			if(count($ts)>0)
				$percent = $counter/count($ts)*100;
			$sets[$i]['Set']['solvedNum'] = $counter;
			$sets[$i]['Set']['solved'] = round($percent, 1);
			$sets[$i]['Set']['solvedColor'] = $this->getSolvedColor($sets[$i]['Set']['solved']);
			$sets[$i]['Set']['topicColor'] = $sets[$i]['Set']['color'];
			$sets[$i]['Set']['difficultyColor'] = $this->getDifficultyColor($sets[$i]['Set']['difficulty']);
			$sets[$i]['Set']['sizeColor'] = $this->getSizeColor($sets[$i]['Set']['anz']);
			$sets[$i]['Set']['dateColor'] = $this->getDateColor($sets[$i]['Set']['created']);

		}

		$sortOrder = 'null';
		$sortColor = 'null';

		if(isset($_SESSION['loggedInUser'])){
			if($globalCounter==$globalSolvedCounter){
				$u['User']['secretArea10'] = 1;
				$_SESSION['loggedInUser']['User']['secretArea10'] = 1;
				$firstGod = $this->User->findById($u['User']['id']);
				$firstGod['User']['secretArea10'] = 1;
				$this->User->save($firstGod);
			}

			if(isset($_COOKIE['sortOrder']) && $_COOKIE['sortOrder']!= 'null'){
				$u['User']['sortOrder'] = $_COOKIE['sortOrder'];
				$sortOrder = $_COOKIE['sortOrder'];
				$_COOKIE['sortOrder'] = 'null';
				unset($_COOKIE['sortOrder']);
			}
			if(isset($_COOKIE['sortColor']) && $_COOKIE['sortColor']!= 'null'){
				$u['User']['sortColor'] = $_COOKIE['sortColor'];
				$sortColor = $_COOKIE['sortColor'];
				$_COOKIE['sortColor'] = 'null';
				unset($_COOKIE['sortColor']);
			}
			$this->User->save($u);
		}
		
		//echo '<pre>'; print_r($setsX); echo '</pre>';
		$this->set('sets', $setsX);
		$this->set('sortOrder', $sortOrder);
		$this->set('sortColor', $sortColor);
    }

	private function findUt($id=null, $allUts=null, $map=null){
		$currentUt = array_search($id, $map);
		$ut = $allUts[$currentUt];
		if($currentUt==0) if($id!=$map[0]) $ut = null;
		return $ut;
	}

	private function getHealth($lvl = null)
  {
    return ($lvl / 5) + 10;
  }

	private function getXPJump($lvl = null){
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

	private function getDifficultyColor($difficulty = null){
		if($difficulty==1) return '#33cc33';
		if($difficulty==2) return '#709533';
		if($difficulty==3) return '#2e3370';
		if($difficulty==4) return '#ac5d33';
		if($difficulty==5) return '#e02e33';
		return 'white';
	}

	private function getSizeColor($size = null){
		$colors = array();
		array_push($colors, '#cc6600');
		array_push($colors, '#ac4e26');
		array_push($colors, '#963e3e');
		array_push($colors, '#802e58');
		array_push($colors, '#60167d');
		if($size<30) return $colors[0];
		else if($size<60) return $colors[1];
		else if($size<110) return $colors[2];
		else if($size<202) return $colors[3];
		else return $colors[4];
	}

	private function getDateColor($date = null){
		$current = '20180705';
		$dist = $current - $date;

		if($dist<7) return '#0033cc';
		if($dist<100) return '#0f33ad';
		if($dist<150) return '#1f338f';
		if($dist<200) return '#2e3370';
		if($dist<300) return '#3d3352';
		if($dist<400) return '#4c3333';
		if($dist<500) return '#57331f';
		return '#663300';
	}

	private function getSolvedColor($percent = null){
		$colors = array();

		array_push($colors, '#333333');
		array_push($colors, '#2e3d47');
		array_push($colors, '#2b4252');
		array_push($colors, '#29475c');
		array_push($colors, '#264c66');
		array_push($colors, '#245270');
		array_push($colors, '#21577a');
		array_push($colors, '#1f5c85');
		array_push($colors, '#1c618f');
		array_push($colors, '#1a6699');

		array_push($colors, '#176ba3');
		array_push($colors, '#1470ad');
		array_push($colors, '#1275b8');
		array_push($colors, '#0f7ac2');
		array_push($colors, '#0d80cc');
		array_push($colors, '#0a85d6');
		array_push($colors, '#088ae0');
		array_push($colors, '#058feb');
		array_push($colors, '#0394f5');
		array_push($colors, '#0099ff');

		array_push($colors, '#039cf8');
		array_push($colors, '#069ef2');
		array_push($colors, '#09a1eb');
		array_push($colors, '#0ca4e4');
		array_push($colors, '#10a6dd');
		array_push($colors, '#13a9d6');
		array_push($colors, '#16acd0');
		array_push($colors, '#19afc9');
		array_push($colors, '#1cb1c2');
		array_push($colors, '#1fb4bc');

		array_push($colors, '#22b7b5');
		array_push($colors, '#25b9ae');
		array_push($colors, '#28bca7');
		array_push($colors, '#2bbfa0');
		array_push($colors, '#2ec29a');
		array_push($colors, '#32c493');
		array_push($colors, '#35c78c');
		array_push($colors, '#38ca86');
		array_push($colors, '#3bcc7f');
		array_push($colors, '#3ecf78');
		$steps = 2.5;
		for($i=0; $i<count($colors); $i++){
			if($percent<=$steps) return $colors[$i];
			$steps += 2.5;
		}
		return '#333333';
	}
}

?>
