<?php
	class MultipleFiles extends FormItem {
		private $currentFile;
		public function getFieldHTML () {
			return "<input type=\"file\" name=\"" . $this->getName() . "[]\" multiple=\"\">\n";
		}
		
		protected function notFilled(){
			return !file_exists($_FILES[$this->getName()]['tmp_name'][0]);
		}
		
		public function saveFiles($directory){
			if(isset($_POST)){
				$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
				$max_file_size = 1024*1000; //100 kb
				$count = 0;
				// Loop $_FILES to execute all files
				foreach ($_FILES[$this->getName()]['name'] as $f => $name) {     
					if ($_FILES[$this->getName()]['error'][$f] == 4) {
						continue; // Skip file if any error found
					}	       
					if ($_FILES[$this->getName()]['error'][$f] == 0) {
						move_uploaded_file($_FILES[$this->getName()]['tmp_name'][$f], $directory.$name);
					}
				}
			}
		}
		
		public function putToFTP($ftp_server,$ftp_username,$ftp_userpass){
			// connect and login to FTP server
			$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
			$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
			
			foreach ($_FILES[$this->getName()]['name'] as $f => $name) {     
				if ($_FILES[$this->getName()]['error'][$f] == 4) {
					continue; // Skip file if any error found
				}	       
				if ($_FILES[$this->getName()]['error'][$f] == 0) {
					$fp = fopen($name,"r");
					// upload file
					if (ftp_fput($ftp_conn, "uploads/" . $name , $fp, FTP_ASCII)) {
						echo "Successfully uploaded $file.";
					} else {
						echo "Error uploading $file.";
					}
					// close this connection and file handler
					fclose($fp);	
				}
			}
			ftp_close($ftp_conn);
		}
	}