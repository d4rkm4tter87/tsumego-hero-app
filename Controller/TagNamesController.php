<?php
class TagNamesController extends AppController{
	public function add(){
		$alreadyExists = false;
		if(isset($this->data['TagName'])){
			$exists = $this->TagName->find('first', array('conditions' => array('name' => $this->data['TagName']['name'])));
			if($exists==null){
				$tn = array();
				$tn['TagName']['name'] = $this->data['TagName']['name'];
				$tn['TagName']['description'] = $this->data['TagName']['description'];
				$tn['TagName']['hint'] = $this->data['TagName']['hint'];
				$tn['TagName']['link'] = $this->data['TagName']['link'];
				$tn['TagName']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
				$tn['TagName']['approved'] = 0;
				$this->TagName->save($tn);
				$saved = $this->TagName->find('first', array('conditions' => array('name' => $this->data['TagName']['name'])));
			}else{
				$alreadyExists = true;
			}
			$this->set('saved', $saved['TagName']['id']);
		}
		$allTags = $this->getAllTags([]);

		$this->set('allTags', $allTags);
		$this->set('alreadyExists', $alreadyExists);
	}
	
	public function view($id=null){
		$tn = $this->TagName->findById($id);
		$allTags = $this->getAllTags([]);
		$this->set('allTags', $allTags);
		$this->set('tn', $tn);
	}

	public function edit($id=null){
		$tn = $this->TagName->findById($id);
		if(isset($this->data['TagName'])){
			$tn['TagName']['description'] = $this->data['TagName']['description'];
			$tn['TagName']['hint'] = $this->data['TagName']['hint'];
			$tn['TagName']['link'] = $this->data['TagName']['link'];
			$tn['TagName']['user_id'] = $_SESSION['loggedInUser']['User']['id'];
			$this->TagName->save($tn);
			$this->set('saved', $tn['TagName']['id']);
		}
		$setHint = array();
		if($tn['TagName']['hint'] == 1){
			$setHint[0] = 'checked="checked"';
			$setHint[1] = '';
		}else{
			$setHint[0] = '';
			$setHint[1] = 'checked="checked"';
		}

		$allTags = $this->getAllTags([]);

		$this->set('allTags', $allTags);
		$this->set('setHint', $setHint);
		$this->set('tn', $tn);
	}

	public function delete($id){
		$this->LoadModel('Tag');
		$tn = $this->TagName->findById($id);

		if(isset($this->data['TagName'])){
			if($this->data['TagName']['delete']==$id){
				$tags = $this->Tag->find('all', array('conditions' => array('tag_name_id' => $id)));
				for($i=0; $i<count($tags); $i++)
					$this->Tag->delete($tags[$i]['Tag']['id']);
				$this->TagName->delete($id);
				$this->set('del', 'del');
			}
		}

		$this->set('tn', $tn);
	}

	public function index(){

	}
}




