<?php
class SitesController extends AppController{
    public $helpers = array('Html', 'Form');

	public function index($var=null){
		$_SESSION['page'] = 'home';
		$_SESSION['title'] = 'Tsumego Hero';
		$this->LoadModel('Tsumego');
		$this->LoadModel('Set');
		$this->LoadModel('TsumegoStatus');
		$this->LoadModel('User');
		$this->LoadModel('DayRecord');
		$this->LoadModel('UserBoard');
		$this->LoadModel('Schedule');
		$this->LoadModel('RankOverview');
		
		$ts = $this->Tsumego->find('all', 
			array('order' => array('Tsumego.created'))
		);
		
		$tdates = array();
		$tSum = array();
		
		array_push($tdates, '2021-06-09 22:00:00');
		array_push($tdates, '2021-06-10 22:00:00');
		//array_push($tdates, '2020-11-22 22:00:00');
		
		for($i=0; $i<count($tdates); $i++){
			$ts1 = $this->Tsumego->find('all', array('conditions' =>  array('created' => $tdates[$i])));
			for($j=0; $j<count($ts1); $j++){
				array_push($tSum, $ts1[$j]);
			}
		}
		
		$newTS = array();
		$setIDs = array();
		$setNames = array();
		$setDates = array();
		
		for($i=0; $i<count($tSum); $i++){
			array_push($newTS, $tSum[$i]);
			if(!in_array($tSum[$i]['Tsumego']['set_id'], $setIDs)){
				array_push($setIDs, $tSum[$i]['Tsumego']['set_id']);
				$date = new DateTime($tSum[$i]['Tsumego']['created']);
				$month = date("F", strtotime($tSum[$i]['Tsumego']['created']));
				$tday = $date->format('d. ');
				$tyear = $date->format('Y');
				if($tday[0]==0) $tday = substr($tday, -3);
				$tSum[$i]['Tsumego']['created'] = $tday.$month.' '.$tyear;
				$setDates[$tSum[$i]['Tsumego']['set_id']] = $tSum[$i]['Tsumego']['created'];
			}
		}
		
		$today = date('Y-m-d');
		
		$dateUser = $this->DayRecord->find('first', array('conditions' =>  array('date' => $today)));
		if(count($dateUser)==0) $dateUser = $this->DayRecord->find('first', array('conditions' =>  array('date' => date('Y-m-d', strtotime('yesterday')))));
		
		$totd = $this->Tsumego->findById($dateUser['DayRecord']['tsumego']);
		$newT = $this->Tsumego->findById($dateUser['DayRecord']['newTsumego']);
		$newTschedule = $this->Schedule->find('all', array('conditions' =>  array('date' => $today)));
		
		$scheduleTsumego = array();
		for($i=0; $i<count($newTschedule); $i++){
			array_push($scheduleTsumego, $this->Tsumego->findById($newTschedule[$i]['Schedule']['tsumego_id']));
		}
		
		if(isset($_SESSION['loggedInUser'])){
			if($_SESSION['loggedInUser']['User']['id']==null || $_SESSION['loggedInUser']['User']['name']==null || $_SESSION['loggedInUser']['User']['level']==null){
				unset($_SESSION['loggedInUser']);
			}
			
			$idArray = array();
			array_push($idArray, $totd['Tsumego']['id']);
			for($i=0; $i<count($scheduleTsumego); $i++){
				array_push($idArray, $scheduleTsumego[$i]['Tsumego']['id']);
			}
			//echo '<pre>'; print_r($idArray); echo '</pre>';
			/*
			$uts = $this->TsumegoStatus->find('all', array(
				'order' => 'created DESC', 'conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])
			));
			*/
			$uts = $this->TsumegoStatus->find('all', array('order' => 'created DESC', 'conditions' => array(
				'user_id' => $_SESSION['loggedInUser']['User']['id'],
				'tsumego_id' => $idArray
			)));
			
			for($i=0; $i<count($uts); $i++){
				for($j=0; $j<count($newTS); $j++){
					if($uts[$i]['TsumegoStatus']['tsumego_id'] == $newTS[$j]['Tsumego']['id']){
						$newTS[$j]['Tsumego']['status'] = $uts[$i]['TsumegoStatus']['status'];
					}
				}
				for($j=0; $j<count($scheduleTsumego); $j++){
					if($uts[$i]['TsumegoStatus']['tsumego_id'] == $scheduleTsumego[$j]['Tsumego']['id']){
						$scheduleTsumego[$j]['Tsumego']['status'] = $uts[$i]['TsumegoStatus']['status'];
					}
				}
				
				
				
				if($uts[$i]['TsumegoStatus']['tsumego_id'] == $totd['Tsumego']['id']) $totd['Tsumego']['status'] = $uts[$i]['TsumegoStatus']['status'];
				
				
				if($uts[$i]['TsumegoStatus']['tsumego_id'] == $newT['Tsumego']['id']) $newT['Tsumego']['status'] = $uts[$i]['TsumegoStatus']['status'];
			}
			
			//echo '<pre>'; print_r($scheduleTsumego); echo '</pre>';
			//echo '<pre>'; print_r($totd); echo '</pre>';
			
		}
		if(!isset($_SESSION['loggedInUser'])){
			if(isset($_SESSION['noLogin'])){
				$noLogin = $_SESSION['noLogin'];
				$noLoginStatus = $_SESSION['noLoginStatus'];
				for($i=0; $i<count($noLogin); $i++){
					for($f=0; $f<count($newTS); $f++){
						if($newTS[$f]['Tsumego']['id']==$noLogin[$i]){
							$newTS[$f]['Tsumego']['status'] = $noLoginStatus[$i];
						}
					}
					for($f=0; $f<count($scheduleTsumego); $f++){
						if($scheduleTsumego[$f]['Tsumego']['id']==$noLogin[$i]){
							$scheduleTsumego[$f]['Tsumego']['status'] = $noLoginStatus[$i];
						}
					}
					if($noLogin[$i] == $totd['Tsumego']['id']) $totd['Tsumego']['status'] = $noLoginStatus[$i];
					if($noLogin[$i] == $newT['Tsumego']['id']) $newT['Tsumego']['status'] = $noLoginStatus[$i];
				}
			}
		}
		//$this->set('ts', $newTS);
		if(!isset($totd['Tsumego']['status'])) $totd['Tsumego']['status'] = 'N';
		if(!isset($newT['Tsumego']['status'])) $newT['Tsumego']['status'] = 'N';
		for($i=0; $i<count($scheduleTsumego); $i++){
			if(!isset($scheduleTsumego[$i]['Tsumego']['status'])) $scheduleTsumego[$i]['Tsumego']['status'] = 'N';
		}
		
		for($i=0; $i<count($setIDs); $i++){
			$setNames[$setIDs[$i]] = $this->Set->findById($setIDs[$i]);
		}
		
		$d1 = date(' d, Y');
		$d1day = date('d. ');
		$d1year = date('Y');
		if($d1day[0]==0) $d1day = substr($d1day, -3);
		$d2 = date('Y-m-d H:i:s');
		$month = date("F", strtotime(date('Y-m-d')));
		$d1 = $d1day.$month.' '.$d1year;
		
		$currentQuote = $dateUser['DayRecord']['quote'];
		$userOfTheDay = $this->User->find('first', array('conditions' =>  array('id' => $dateUser['DayRecord']['user_id'])));
		
		$totdS = $this->Set->findById($totd['Tsumego']['set_id']);
		$newTS = $this->Set->findById($newT['Tsumego']['set_id']);
		
		$totd['Tsumego']['set'] = $totdS['Set']['title'];
		$newT['Tsumego']['set'] = $newTS['Set']['title'];
		$totd['Tsumego']['set2'] = $totdS['Set']['title2'];
		$newT['Tsumego']['set2'] = $newTS['Set']['title2'];
		
		$this->set('userOfTheDay', $userOfTheDay['User']['name']);
		$this->set('uotdbg', $dateUser['DayRecord']['userbg']);
		
		//recently visited
		/*if(isset($_SESSION['loggedInUser'])){
			$currentUser = $this->User->find('first', array('conditions' =>  array('id' => $_SESSION['loggedInUser']['User']['id'])));
			$currentUser['User']['created'] = date('Y-m-d H:i:s');
			$this->User->save($currentUser);
			
			$visit = $this->Visit->find('all', 
				array('order' => 'created',	'direction' => 'DESC', 'conditions' =>  array('user_id' => $_SESSION['loggedInUser']['User']['id']))
			);
			
			$setVisit1 = $this->Set->find('first', array('conditions' => array('id' => $visit[count($visit)-1]['Visit']['set_id'])));
			$this->set('visit1', $setVisit1);
			if(count($visit)>1){
				$setVisit2 = $this->Set->find('first', array('conditions' => array('id' => $visit[count($visit)-2]['Visit']['set_id'])));
				$this->set('visit2', $setVisit2);
				if(count($visit)>2){
					$setVisit3 = $this->Set->find('first', array('conditions' => array('id' => $visit[count($visit)-3]['Visit']['set_id'])));
					$this->set('visit3', $setVisit3);
				}
			}
		}*/
		
		$tsumegoDates = array();
		
		$invisibleSets = $this->getInvisibleSets();
		for($j=0; $j<count($ts); $j++){
			if(!in_array($ts[$j]['Tsumego']['set_id'], $invisibleSets) && $ts[$j]['Tsumego']['set_id']!=null) array_push($tsumegoDates, $ts[$j]['Tsumego']['created']);
		}
		
		$this->set('tsumegos', $tsumegoDates);
		$this->set('quote', $currentQuote);
		$this->set('d1', $d1);
		$this->set('setNames', $setNames);
		$this->set('setDates', $setDates);
		$this->set('totd', $totd);
		$this->set('newT', $newT);
		$this->set('scheduleTsumego', $scheduleTsumego);
		$this->set('dateUser', $dateUser);
    }
	
	public function view($id=null){
		$news = $this->Site->find('all');	
		$this->set('news', $news[$id]);
	}
	
	public function impressum(){
		$_SESSION['page'] = 'about';
		$_SESSION['title'] = 'Tsumego Hero - Legal Notice';
	}
	
	public function websitefunctions(){
		$_SESSION['page'] = 'websitefunctions';
		$_SESSION['title'] = 'Tsumego Hero - Website Functions';
	}
	
	public function gotutorial(){
		$_SESSION['page'] = 'gotutorial';
		$_SESSION['title'] = 'Tsumego Hero - Go Tutorial';
	}
	
	public function ugco5ujc(){
	
	}
}




