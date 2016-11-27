<?php
	class Password extends FormItem {
		private $min,$max;
		public function getFieldHTML () {
			return "<input name=\"" . $this->getName() . "\" type=\"password\" class=\"" . $this->getClasses() ."\"" . $this->getAttrs() . ">\n";
		}
		
		protected function notFilled(){
			return empty($_POST[$this->getName()]);
		}
		
		public function setLength ($min,$max){
			$this->validationMethod = "length";
			$this->min = $min;
			$this->max = $max;
		}
		
		public function validate(){
			$requiredValidation = parent::validate();
			$value = $_POST[$this->getName()];
			switch($this->validationMethod){
				case "length":
					if(strlen($value)<$this->min || strlen($value)>$this->max){
						$this->setErrorMessage("Password must be between " . $this->min . " and " . $this->max . " characters.");
						return false;	
					}
				break;
			}
			return $requiredValidation;
		}
	}