<?php
	class TextArea extends FormItem {
		private $value;
		
		public function __construct($name="",$label="",$classes=array(),$id=""){
			parent::__construct($name,$label,$classes,$id);
			$this->value = "";
		}
		
		public function getFieldHTML () {
			return "<textarea rows=\"5\" name=\"" . $this->getName() . "\" class=\"" . $this->getClasses() ."\"" . $this->getAttrs() . ">" . $this->value . "</textarea>\n";
		}
		
		public function validate(){
			$value = $_POST[$this->getName()];
			$this->value = $value;
			return parent::validate();
		}
		
		protected function notFilled(){
			return trim($_POST[$this->getName()])=="";
		}
	}