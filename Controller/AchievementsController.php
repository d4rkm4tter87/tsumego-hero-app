<?php
class AchievementsController extends AppController {

	public function index(){
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
				$a[$i]['Achievement']['unlocked'] = true;
				$a[$i]['Achievement']['created'] = $existingAs[$a[$i]['Achievement']['id']]['AchievementStatus']['created'];
				$date=date_create($a[$i]['Achievement']['created']);
				$a[$i]['Achievement']['created'] = date_format($date,"d.m.Y H:i");
			}
		}
		$this->set('a', $a);
    }
	
	public function view($id=null){
		$this->LoadModel('AchievementStatus');
		$a = $this->Achievement->findById($id);
		$as = array();
		$aCount = count($this->AchievementStatus->find('all', array('conditions' => array('achievement_id' => $id))));
		if(isset($_SESSION['loggedInUser'])){
			$as = $this->AchievementStatus->find('first', array('conditions' => array('achievement_id' => $id, 'user_id' => $_SESSION['loggedInUser']['User']['id'])));
		}
		if(!empty($as)){
			$date = date_create($as['AchievementStatus']['created']);
			$as['AchievementStatus']['created'] = date_format($date,"d.m.Y H:i");
		}
		$this->set('a', $a);
		$this->set('as', $as);
		$this->set('aCount', $aCount);
	}
	
}




