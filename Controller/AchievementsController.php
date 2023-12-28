<?php
class AchievementsController extends AppController {

	public function index(){
		$_SESSION['page'] = 'user';
		$_SESSION['title'] = 'Tsumego Hero - Achievements';
		$this->LoadModel('AchievementStatus');
		$existingAs = array();
		
		$a = $this->Achievement->find('all', array('order' => 'order ASC'));
		
		if(isset($_SESSION['loggedInUser'])){
			$as = $this->AchievementStatus->find('all', array('conditions' => array('user_id' => $_SESSION['loggedInUser']['User']['id'])));
			
			for($i=0; $i<count($as); $i++)
				$existingAs[$as[$i]['AchievementStatus']['achievement_id']] = $as[$i];
		}
		
		for($i=0; $i<count($a); $i++){
			$a[$i]['Achievement']['unlocked'] = false;
			$a[$i]['Achievement']['created'] = '';
			if(isset($existingAs[$a[$i]['Achievement']['id']])){
				if($a[$i]['Achievement']['id']==46)
					$a[$i]['Achievement']['a46value'] = $existingAs[$a[$i]['Achievement']['id']]['AchievementStatus']['value'];
				$a[$i]['Achievement']['unlocked'] = true;
				$a[$i]['Achievement']['created'] = $existingAs[$a[$i]['Achievement']['id']]['AchievementStatus']['created'];
				$date=date_create($a[$i]['Achievement']['created']);
				$a[$i]['Achievement']['created'] = date_format($date,"d.m.Y H:i");
			}
		}
		$this->set('a', $a);
    }
	
	public function view($id=null){
		$_SESSION['page'] = 'user';
		$_SESSION['title'] = 'Tsumego Hero - Achievements';
		$this->LoadModel('AchievementStatus');
		$this->LoadModel('User');
		$a = $this->Achievement->findById($id);
		
		$as = array();
		$asAll = $this->AchievementStatus->find('all', array('order' => 'created DESC','conditions' => array('achievement_id' => $id)));
		$aCount = count($asAll);
		if(isset($_SESSION['loggedInUser'])){
			$as = $this->AchievementStatus->find('first', array('conditions' => array('achievement_id' => $id, 'user_id' => $_SESSION['loggedInUser']['User']['id'])));
		}
		if(!empty($as)){
			$date = date_create($as['AchievementStatus']['created']);
			$as['AchievementStatus']['created'] = date_format($date,"d.m.Y H:i");
		}
		$asAll2 = array();
		$count = 10;
		if(count($asAll)<10) $count = count($asAll);
		if(count($asAll)>10) $andMore = ' and more.';
		else $andMore = '.';
		for($i=0; $i<$count; $i++){
			$u = $this->User->findById($asAll[$i]['AchievementStatus']['user_id']);
			$asAll[$i]['AchievementStatus']['name'] = $u['User']['name'];
			array_push($asAll2, $asAll[$i]);
		}
		$asAll = $asAll2;
		
		$this->set('a', $a);
		$this->set('as', $as);
		$this->set('asAll', $asAll);
		$this->set('aCount', $aCount);
		$this->set('andMore', $andMore);
	}
	
}




