<?php
	class Hidden extends FormItem {
		private $value;
		
		public function __construct($name,$value){
			parent::__construct($name,"");
			$this->setValue($value);
		}
		
		public function setValue($value){
			$this->value = $value;
		}
		
		public function getFieldHTML () {
			return "<input type=\"hidden\" name=\"" . $this->getName() . "\" value=\"" . $this->value . "\">\n";
		}
		public function validate(){
			return true;
		}
		
		protected function notFilled(){
			return false;
		}
	}