<?php
	class Radio extends FormItem {
		
		private $options,$selectedValue;
		
		public function addOption($text, $value='',$selected=false){
			if(trim($value)=='')
				$value = preg_replace('/\s+/', '', $text);
				
			if(isset($this->options[$value]))
				die("An element with that value has already been added");	
				
			$this->options[$value] = $text;
			if($selected)
				$this->setSelected($value);
		}
		
		public function setSelected($value){
			$this->selectedValue = $value;
		}
		
		public function getFieldHTML () {
			$returnvalue = "";
			foreach($this->options as $value=>$text){
				$returnvalue .= "<br />";
				$returnvalue .= "<label><input type=\"radio\"";
				if($this->selectedValue == $value){
					$returnvalue .= " checked ";
				}
				$returnvalue .= "name=\"" . $this->getName() . "\"" . $this->getAttrs() . " value=\"" . $value . "\"> ";
				$returnvalue .= $text . "</label>";
			}
			return $returnvalue;
		}
		
		protected function notFilled(){
			$bools = array("false","true");
			return !isset($this->options[$_POST[$this->getName()]]);
		}
		
		public function validate(){
			if(!isset($_POST[$this->getName()]))
				return false;
			$this->selectedValue = $_POST[$this->getName()];
			if( $this->getRequired() && $this->notFilled() ){
				$this->setErrorMessage("This is a required field.");
				return false;
			}
			return true;
		}
	}