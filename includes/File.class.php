<?php
	class File extends FormItem {
		protected $fileTypes = array();
		protected $fileExtention;
		
		public function getFieldHTML () {
			return "<input type=\"file\" name=\"" . $this->getName() . "\">\n";
		}
		
		public function setFileTypes($arrayOfFileTypes) {
			$this->fileTypes = $arrayOfFileTypes;
		}
		
		public function validate() {
			$requiredValidation = parent::validate();
			$file = $_FILES[$this->getName()];
			
			if($this->getRequired() || $file["error"] != 4) {
				if($file["error"] != 0) {
					$this->setErrorMessage("An error occured with your file upload: " + $file["error"]);
					return false;
				}
				
				$filename = $file["name"];
				$this->fileExtention = end(explode(".", $filename));
				
				if(!empty($this->fileTypes) && !in_array($this->fileExtention, $this->fileTypes)) {
					$this->setErrorMessage("You did not upload an accepted file type (Accepted Types: " . implode(", ", $this->fileTypes) . ")");		
				}
			}
			return $requiredValidation;
		}
		
		public function saveFileTo($savePath = NULL, $overwrite = false) {
			if($this->notFilled()) {
				return false;
			}
			
			if($savePath == NULL) {
				if (!is_dir("file_uploads")) {
					mkdir("file_uploads");
				}
				$savePath = "file_uploads/" . $_FILES[$this->getName()]["tmp_name"];
			} else {
				$savePath .= "." . $this->fileExtention;	
			}
			
			if($overwrite || !file_exists($savePath))
				return move_uploaded_file($_FILES[$this->getName()]["tmp_name"], $savePath);	
				
			return false;
		}
		
		protected function notFilled() {
			return $_FILES[$this->getName()]["error"] == 4;
		}
	}