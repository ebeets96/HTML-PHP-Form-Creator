<?php
	class Alert {
		private $html;
		public function __construct($message,$alert_type="info"){
			$this->html = "";
			if(!empty($message)){
				$this->html = "<div class=\"alert alert-$alert_type\" role=\"alert\">";
				$this->html .= $message;
				$this->html .= "</div>";
			}
		}
		
		public function __toString(){
        	return $this->html;
		}
	}