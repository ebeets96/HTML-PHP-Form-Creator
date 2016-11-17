<?php
	class HTML extends FormItem {
		private $html;
		
		public function __construct($html){
			parent::__construct("customHTML","");
			$this->html = $html;
		}
		
		public function getFieldHTML () {
			return $this->html;
		}
		public function validate(){
			return true;
		}
		
		protected function notFilled(){
			return false;
		}
	}