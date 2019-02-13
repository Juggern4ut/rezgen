<?php
	/**
	* Erstellt ein PNG eines roten Einzahlungsscheins nach Vorlage der Schweiz
	* @author Lukas Meier
	*/
	class rezgen{
		private $_imagePath;
		private $_fontPath;

		private $_account;
		private $_amount;

		private $_recipient = array();
		private $_payer = array();
		
		private $_paymentReason;

		public function __construct(){
			$this->_imagePath = dirname(__FILE__).'/res/img/es.png';
			$this->_fontPath = dirname(__FILE__).'/res/font/excalib.ttf';
		}

		/**
		* Definiert die Adresse des Empfängers
		* @param String $name Vor- und Nachname des Empfängers
		* @param String $street Strasse und Hausnummer des Empfängers
		* @param String $location Postleitzahl und Ortschaft des Empfängers
		* @param String $company Firmenname des Empfängers. Wird ignoriert falls false
		* @return void
		*/
		public function setRecipient($name, $street, $location, $company=false){
			$this->_recipient["name"] = $name;
			$this->_recipient["company"] = $company;
			$this->_recipient["street"] = $street;
			$this->_recipient["location"] = $location;
		}

		/**
		* Definiert die Adresse des Überweisers
		* @param String $name Vor- und Nachname des Überweisers
		* @param String $street Strasse und Hausnummer des Überweisers
		* @param String $location Postleitzahl und Ortschaft des Überweisers
		* @return void
		*/
		public function setPayer($name, $street, $location){
			$this->_payer["name"] = $name;
			$this->_payer["street"] = $street;
			$this->_payer["location"] = $location;
		}

		/**
		* Definiert die Kontonummer
		* @param String $account Kontonummer
		* @return void
		*/
		public function setAccount($account){
			$this->_account = $account;
		}

		/**
		* Definiert die Kosten auf dem Einzahlungsschein
		* @param String|Float $amount Zu bezahlender Betrag
		* @return void
		*/
		public function setAmount($amount){
			$this->_amount = str_split(strrev(number_format($amount, 2, '', '')));
		}

		/**
		* Definiert den Zahlungszweck
		* @param String $reason Der Zahlungszweck
		* @return void
		*/
		public function setPaymentReason($reason){
			$arrayWords = explode(' ', $reason);
			$maxLineLength = 34;
			$currentLength = 0;
			$index = 0;

			foreach ($arrayWords as $word) {
				$wordLength = strlen($word) + 1;

				if (($currentLength + $wordLength) <= $maxLineLength) {
					$arrayOutput[$index] .= $word . ' ';
					$currentLength += $wordLength;
				} else {
					$index += 1;
					$currentLength = $wordLength;
					$arrayOutput[$index] = $word.' ';
				}
			}

			$this->_paymentReason = $arrayOutput;
		}

		/**
		* Generiert den Einzahlungsschein mit den definierten Daten und gibt diesen aus
		* @return void
		*/
		public function generate(){
			header("Content-Type: image/png");
			$image = imagecreatefrompng($this->_imagePath);
			$textColor = imagecolorallocate($image, 0, 0, 0);
			$fontPath = $this->_fontPath;

			//RECIPIENT
			$fontSize = 15;
			$fontSizeSmall = 11;
			$lineHeight = 25;
			$lineHeightSmall = 20;
			$lineY = 75;
			foreach ($this->_recipient as $value) {
				if($value !== false){
					imagettftext($image, $fontSize, 0, 13, $lineY, $textColor, $fontPath, $value);
					imagettftext($image, $fontSize, 0, 365, $lineY, $textColor, $fontPath, $value);			
					$lineY+=$lineHeight;
				}
			}

			//PAYER
			$lineHeight = 38;
			$lineY = 385;
			foreach ($this->_payer as $value) {
				if($value !== false){
					imagettftext($image, $fontSize, 0, 13, $lineY, $textColor, $fontPath, $value);
					imagettftext($image, $fontSize, 0, 715, $lineY-72, $textColor, $fontPath, $value);			
					$lineY+=$lineHeight;
				}
			}

			//ACCOUNT
			imagettftext($image, $fontSize, 0, 150, 265, $textColor, $fontPath, $this->_account);
			imagettftext($image, $fontSize, 0, 502, 265, $textColor, $fontPath, $this->_account);
			
			//AMOUNT
			$lineY = 314;
			$lineX = 313;
			$count = 0;
			foreach($this->_amount as $number){
				imagettftext($image, $fontSize, 0, $lineX, $lineY, $textColor, $fontPath, $number);
				imagettftext($image, $fontSize, 0, $lineX+354, $lineY, $textColor, $fontPath, $number);
				$lineX-= 29.3;
				$count++;
				if($count === 2){
					$lineX-= 29.3;
				}
			}

			//PAYMENTREASON
			$lineY = 75;
			$lineX = 715;
			foreach ($this->_paymentReason as $line) {
				imagettftext($image, $fontSizeSmall, 0, $lineX, $lineY, $textColor, $fontPath, $line);
				$lineY+=$lineHeightSmall;
			}

			imagepng($image);
			imagedestroy($image);
		}
	}
?>