<?php
	class Form {
	
		private $form_title,$action,$method,$form_items,$submitted,$errorMessage,$success;
		
		public function __construct($title,$action=null,$class=array()){
			$this->form_title = preg_replace('/\s+/', '', $title);
			if($action==null)
				$this->action = $_SERVER['PHP_SELF'];
			else
				$this->action = $action;
			$this->method = "post";
			$this->form_items = array();
			$this->submitted = isset($_POST[$this->form_title]);
			$this->success = "";
		}
		
		public function addFormItem(FormItem $item){
			$this->form_items[] = $item;
		}
		
		public function addFormItems($items){
			foreach(func_get_args() as $item){
				$this->form_items[] = $item;
			}
		}
		
		public function getFormHTML(){
			if(empty($this->success)){
				$html = $this->getError();
				$html .= "\n<form method=\"" . $this->method . "\" action=\"" . $this->action . "\" enctype=\"multipart/form-data\">\n";
				foreach($this->form_items as $item){
					if($this->submitted)
						$html .= $item->getError();
						
					if($item->hasSuccess()){
						$validationClasses = " has-success";	
					} else if($item->hasError()){
						$validationClasses = " has-danger";
					} else {
						$validationClasses = "";
					}
					if(get_class($item)!="Hidden" && get_class($item)!="HTML" && $item->getAttr("hide_label")!="true" ){
						$html .= "\t<div class=\"form-group" . $validationClasses . "\">\n";
						$html .= "\t\t<label for=\"" . $item->getName() . "\">" . $item->getLabel() . " <em>" . $item->getHint() . "</em></label>\n";
					} else if ($item->getAttr("hide_label")=="true"){
						$html .= "\t<div class=\"form-group" . $validationClasses . "\">\n";	
					}
					$html .= "\t\t" . $item->getFieldHTML();
					if(get_class($item)!="Hidden" && get_class($item)!="HTML"){
						$html .= "\t</div>\n";
					} else if ($item->getAttr("hide_label")=="true"){
						$html .= "\t</div>\n";
					}
				}
				$html .= "<input type=\"hidden\" name=\"" . $this->form_title . "\" value=\"true\">\n";
				$html .= "</form>\n";
				return $html;
			} else {
				return $this->success;	
			}
		}
		
		public function addError($message){
			$this->errorMessage .= "<li>" . $message . "</li>";
		}
		
		public function getError(){
				if(isset($this->errorMessage)){
					return new Alert($this->errorMessage,"danger");
				}
				return "";
		}
		
		public function process(){
			if($this->submitted){
				$validation = true;
				foreach($this->form_items as $item){
					if(!$item->validate()){
						$validation = false;
						$item->addClass("form-control-danger");
					} else{
						$item->addClass("form-control-success");
					}
				}
				return $validation;
			}
			return false;
		}
		
		public function getSubmittedValuesAsHTML(){
			$html = "";
			if($this->submitted){
				foreach($this->form_items as $item){
					$html .= "<p><strong>" . $item->getLabel() . "</strong></p>";
					$html .= "<p>" . htmlentities($item->getValue()) . "</p>";
				}
			}
			return $html;
		}
		
		public function clearValues() {
			foreach($this->form_items as $item){
				$item->resetInfo();
			}
		}
		
		public function setSuccess($message){
			$this->success .= $message;
		}
	}