<?php
	abstract class FormItem {
		protected $id,$name,$label,$classes,$attrs,$required,$validationMethod,$errorMessage;
		
		public function __construct($name="",$label="",$classes=array(),$id=""){
			$this->setId($id);
			$this->setClasses($classes);
			$this->addClass("form-control");
			$this->attrs = array();
			$this->setName($name);
			$this->setLabel($label);
			$this->setRequired(false);
			$this->validationMethod = "none";
			$this->errorMessage = "";
		}
		
		public function setId($id){
			$this->id = $id;
		}
		
		public function getId(){
			return $this->id;
		}
		
		public function setLabel($label){
			$this->label = $label;	
		}
		
		public function getLabel(){
			return $this->label;
		}
		
		public function setName($name){
			$this->name = $name;	
		}
		
		public function getName(){
			return $this->name;
		}
		
		public function addClass($class){
			$this->classes[] = $class;	
		}
		
		public function setClasses(Array $classes){
			$this->classes = $classes;	
		}
		
		public function getClasses(){
			$classString = "";
			foreach($this->classes as $class) {
				$classString .= $class . " ";
			}
			return trim($classString);
		}
		
		public function addAttr($attr,$value){
			$this->attrs[$attr] = $value;
		}
		
		public function getAttr($attr){
			if(isset($this->attrs[$attr]))
				return $this->attrs[$attr];
			else
				return "";
		}
		
		public function getAttrs(){
			$attrString = "";
			foreach($this->attrs as $key => $attr) {
				$attrString .= $key . "=\"" . $attr . "\" ";
			}
			return " " . trim($attrString);
		}
		
		protected function setErrorMessage($message){
			$this->errorMessage .= "<li>" . $message . "</li>";
		}
		
		public function hasError(){
			if(isset($_POST[$this->getName()]) && !empty($this->errorMessage)){
				return true;	
			}
		}
		
		public function hasSuccess(){
			if(isset($_POST[$this->getName()]) && empty($this->errorMessage)){
				return true;	
			}
		}
		
		public function getError(){
				if(isset($this->errorMessage)){
					return new Alert($this->errorMessage,"danger");
				}
				return "";
		}
		
		public function setRequired($value = true){
			$this->required = $value;
		}
		
		public function getRequired (){
			return $this->required;
		}
		
		public function validate(){
			if( $this->getRequired() && $this->notFilled() ){
				$this->setErrorMessage("This is a required field.");
				return false;
			}
			return true;
		}
		
		public function getValue(){
			if(isset($_POST[$this->getName()]))
				return $_POST[$this->getName()];
			else
				return null;
		}
		
		public function resetInfo(){
			$this->setClasses(array("form-control"));
			$this->attrs = array();
			unset($_POST[$this->getName()]);
		}
		
		abstract public function getFieldHTML();
		abstract protected function notFilled();
	}