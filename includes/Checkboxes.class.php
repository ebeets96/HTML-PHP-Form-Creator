<?php
	class Checkboxes extends FormItem {
		
		private $options;
		
		public function addOption($text, $value=''){
			if(trim($value)=='')
				$value = preg_replace('/\s+/', '', $text);
			if(isset($this->options[$value]))
				die("An element with that value has already been added");	
			$this->options[$value] = $text;
		}
		
		public function getFieldHTML () {
			$returnvalue = '<div class="checkbox">';
			foreach($this->options as $value=>$option){
				$returnvalue .= '<label class="checkbox-inline"><input type="checkbox" name="' . $this->getName() . '[]" ' . $this->getAttrs() . ' value="' . $value . '">' . $option . '</label>';
			}
			$returnvalue .= "</div>";
			return $returnvalue;
		}
		
		protected function notFilled(){
			return count($this->getValue())==0;
		}
	}