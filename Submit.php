<?php
	class Submit extends FormItem {
		
		private $buttonText;
		
		public function __construct($text="Submit"){
			parent::__construct("submitButton","");
			$this->buttonText = $text;
		}
		
		public function getFieldHTML () {
			return "<input type=\"submit\" class=\"btn btn-primary\" value=\"" . $this->buttonText . "\">\n";
		}
		public function validate(){
			return true;
		}
		
		protected function notFilled(){
			return false;
		}
	}