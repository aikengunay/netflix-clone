<?php
    // This is a PHP class named 'Account' that handles user account-related operations
    class Account {
        // Declare a private property to store the database connection
        // 'private' means this variable can only be accessed within this class
        private $con;
        // Array to store validation errors that occur during account operations
        // When empty, it means no errors were found
        private $errorArray = array();

        // This is a constructor method - it runs automatically when a new Account object is created
        // It takes a database connection ($con) as a parameter
        public function __construct($con) {
            // Store the database connection in the private property
            // '$this' refers to the current instance of the Account class
            $this->con = $con;
        }

        public function register($fn, $ln ,$un, $em, $em2, $pw, $pw2) {
            // Start validation process using Account class
            // Check if first name meets requirements (length, format, etc.)
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateUsername($un);
            $this->validateEmails($em, $em2);
        }

        // This function checks if a first name is valid
        // Parameters:
        //   $fn - the first name to validate (string)
        private function validateFirstName($fn) {
            // Check if the first name length is less than 2 OR greater than 25 characters
            // strlen() is a PHP function that returns the length of a string
            if(strlen($fn) < 2 || strlen($fn) > 25) {
                // If the name is too short or too long, add an error message to the errorArray
                // array_push() adds a new item to the end of an array
                array_push($this->errorArray, Constants::$firstNameCharacters);
            }
        }
        
        private function validateLastName($ln) {
            if(strlen($ln) < 2 || strlen($ln) > 25) {
                array_push($this->errorArray, Constants::$lastNameCharacters);
            }
        }
  
        private function validateUsername($un) {
            if(strlen($un) < 2 || strlen($un) > 25) {
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;
            }
            $query = $this->con->prepare("SELECT * FROM users WHERE username=:un");
            $query->bindValue(":un", $un);
            $query->execute();
            if($query->rowCount() != 0) {
                array_push($this->errorArray, Constants::$usernameTaken);
            }
        }
        
        private function validateEmails($em, $em2) {
            if ($em != $em2) {
                array_push($this->errorArray, Constants::$emailsDontMatch);
                return;
            }
            // perform a filter
            if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }
            $query = $this->con->prepare("SELECT * FROM users WHERE email=:em");
            $query->bindValue(":em", $em);
            $query->execute();
            if($query->rowCount() != 0) {
                array_push($this->errorArray, Constants::$emailTaken);
            }
        }

        // This function checks if a specific error exists in the errorArray
        // Parameters:
        //   $error - the error message to check for (string)
        // Returns:
        //   The error message if it exists in the errorArray, otherwise returns nothing
        public function getError($error) {
            if(in_array($error, $this->errorArray)) {
                return $error;
            }
        }

    }
?>