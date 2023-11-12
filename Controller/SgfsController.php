<?php
class SgfsController extends AppController {

	public function index(){
		$_SESSION['title'] = 'Tsumego Hero';
		$_SESSION['page'] = 'play';
		$sgfs = $this->Sgf->find('all');
		echo '<pre>'; print_r($sgfs); echo '</pre>';
		$this->set('sgfs', $sgfs);
    }
	
	public function view($id=null){
		$_SESSION['title'] = 'Tsumego Hero';
		$_SESSION['page'] = 'play';
		$this->loadModel('Tsumego');
		$this->loadModel('Set');
		$this->loadModel('User');
		$name = '';
		$ux = '';
		$type = 'tsumego';
		$id2 = $id;
		$id /= 1337;
		
		if(isset($this->params['url']['delete'])){
			$sDel = $this->Sgf->findById($this->params['url']['delete']);
			if($_SESSION['loggedInUser']['User']['id'] == $sDel['Sgf']['user_id']){
				$this->Sgf->delete($sDel['Sgf']['id']);
			}
		}
		
		$t = $this->Tsumego->findById($id);
		$set = $this->Set->findById($t['Tsumego']['set_id']);
		$name = $set['Set']['title'].' '.$set['Set']['title2'].' '.$t['Tsumego']['num'];
		
		if(isset($this->params['url']['user'])){
			$s = $this->Sgf->find('all', array('order' => 'created DESC','limit' => 500,'conditions' => array('user_id' => $this->params['url']['user'])));
			$type = 'user';
		}else{
			$s = $this->Sgf->find('all', array('order' => 'created DESC','limit' => 500,'conditions' => array('tsumego_id' => $id)));
		}
		
		for($i=0; $i<count($s); $i++){
			$s[$i]['Sgf']['sgf'] = str_replace("\n", '"+"\n"+"', $s[$i]['Sgf']['sgf']);
			$u = $this->User->findById($s[$i]['Sgf']['user_id']);
			$s[$i]['Sgf']['user'] = $u['User']['name'];
			$ux = $u['User']['name'];
			$t = $this->Tsumego->findById($s[$i]['Sgf']['tsumego_id']);
			$set = $this->Set->findById($t['Tsumego']['set_id']);
			$s[$i]['Sgf']['title'] = $set['Set']['title'].' '.$set['Set']['title2'].' #'.$t['Tsumego']['num'];;
			
			if($s[$i]['Sgf']['user']=='noUser') 
				$s[$i]['Sgf']['user'] = 'automatically generated';
			if($_SESSION['loggedInUser']['User']['id'] == $s[$i]['Sgf']['user_id'])
				$s[$i]['Sgf']['delete'] = true;
			else
				$s[$i]['Sgf']['delete'] = false;
		}
		
		$this->set('ux', $ux);
		$this->set('type', $type);
		$this->set('name', $name);
		$this->set('s', $s);
		$this->set('id', $id);
		$this->set('id2', $id2);
		$this->set('tNum', $t['Tsumego']['num']);
	}
	
}




