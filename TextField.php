<?php
	class TextField extends FormItem {
		private $minNum,$maxNum,$regex,$regexReadable;
		
		public function getFieldHTML () {
			return "<input name=\"" . $this->getName() . "\" type=\"text\" class=\"" . $this->getClasses() ."\"" . $this->getAttrs() . ">\n";
		}
		
		public function regexFormat($regex,$readableFormat){
			$this->regex = $regex;
			$this->regexReadable = $readableFormat;
			$this->validationMethod = "regex";	
		}
		
		public function emailFormat(){
			$this->validationMethod = "email";
		}
		
		public function phoneFormat(){
			$this->validationMethod = "phone";
		}
		
		public function numberFormat($min,$max){
			$this->validationMethod = "number";
			$this->minNum = $min;
			$this->maxNum = $max;
		}
		
		public function validate(){
			$requiredValidation = parent::validate();
			$value = $_POST[$this->getName()];
			$this->addAttr("value",$value);
			switch($this->validationMethod){
				case "email":
					if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
						$this->setErrorMessage("Please enter a valid email address");
						return false;
					} else {
						return $requiredValidation;
					}
				break;
				
				case "phone":
					if($requiredValidation && 
						preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i",$value)){
						return true;
					} else {
						$this->setErrorMessage("Please enter a valid phone number");
						return false;
					}
				break;
				
				case "number":
					if($requiredValidation && ($value >= $this->minNum && $value <= $this->maxNum)){
						return true;
					} else {
						$this->setErrorMessage("Please enter a number between " . $this->minNum . " and " . $this->maxNum . ".");
						return false;
					}
				break;
				case "regex":
					if($requiredValidation && 
						preg_match($this->regex,$value)){
						return true;
					} else {
						$this->setErrorMessage("Please enter a value in the format " . $this->regexReadable . ".");
						return false;
					}
				break;
			}
			return $requiredValidation;
		}
		
		protected function notFilled(){
			return trim($_POST[$this->getName()])=="";
		}
	}