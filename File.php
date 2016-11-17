<?php
	class File extends FormItem {
		public function getFieldHTML () {
			return "<input type=\"file\" name=\"" . $this->getName() . "\">\n";
		}
		public function validate(){
			return true;
		}
		
		protected function notFilled(){
			return false;
		}
	}