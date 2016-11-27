<?php
	class Captcha extends FormItem {
		private $html,$sitekey,$secret;
		
		public function __construct($sitekey,$secret){
			parent::__construct("recaptcha","");
			$this->html = "<div class=\"g-recaptcha\" data-sitekey=\"" . $sitekey . "\"></div><br />";
			$this->sitekey = $sitekey;
			$this->secret = $secret;
		}
		
		public function getFieldHTML () {
			return $this->html;
		}
		
		public function getError(){
				if(isset($this->errorMessage)){
					return new Alert($this->errorMessage,"danger");
				}
				return "";
		}
		
		public function validate(){
			$captcha = $_POST['g-recaptcha-response'];
			$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $this->secret . "&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
        	if(!$response['success']){
				$this->setErrorMessage("The CAPTCHA did not validate, please try again.");
				return false;
			} else {
				return true;
			}
		}
		
		protected function notFilled(){
			return false;
		}
	}