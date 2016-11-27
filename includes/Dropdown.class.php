<?php
	class Dropdown extends FormItem {
		
		private $options;
		
		public function addOption($text, $value=''){
			if(trim($value)=='')
				$value = preg_replace('/\s+/', '', $text);
			if(isset($this->options[$value]))
				die("An element with that value has already been added");	
				
				$this->options[$value] = $text;
		}
		
		public function getFieldHTML () {
			$returnvalue = "<select name=\"" . $this->getName() . "\" class=\"" . $this->getClasses() ."\"" . $this->getAttrs() . ">";
			$returnvalue .= '<option value="none">Please Select an Option</option>';	
			$currentSelection = $this->getValue();
			foreach($this->options as $value=>$option){
				$returnvalue .= '<option value="' . $value . '"';
				if($currentSelection == $value)
					$returnvalue .= ' selected';
				$returnvalue .= '>' . $option . '</option>';	
			}
			
			$returnvalue .= "</select>";
			return $returnvalue;
		}
		
		protected function notFilled(){
			return $this->getValue()=="none";
		}
	}