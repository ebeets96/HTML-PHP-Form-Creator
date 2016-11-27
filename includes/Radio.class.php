<?php
	class Radio extends FormItem {
		
		private $options,$selectedValue;
		
		public function addOption($text, $value,$selected=false){
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
				$i++;
			}
			return $returnvalue;
		}
		
		protected function notFilled(){
			$bools = array("false","true");
			return !isset($this->options[$_POST[$this->getName()]]);
		}
		
		public function validate(){
			$this->selectedValue = $_POST[$this->getName()];
			if( $this->getRequired() && $this->notFilled() ){
				$this->setErrorMessage("This is a required field.");
				return false;
			}
			return true;
		}
	}