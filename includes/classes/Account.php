<?php
    // This class handles all user account operations like registration and validation
    class Account {
        // Store the database connection object
        // Private means only methods inside this class can access it
        private $con;

        // Array to store any validation errors that occur
        // Will be empty if all validations pass
        private $errorArray = array();

        // Constructor - runs automatically when we create a new Account object
        // Takes a database connection as parameter
        public function __construct($con) {
            $this->con = $con; // Save the database connection for later use
        }

        // Main registration method that handles the entire signup process
        // Takes all form fields as parameters: first name, last name, username, etc.
        public function register($fn, $ln ,$un, $em, $em2, $pw, $pw2) {
            // Run all validation checks
            $this->validateFirstName($fn);    // Check if first name is valid
            $this->validateLastName($ln);     // Check if last name is valid
            $this->validateUsername($un);     // Check if username is valid and unique
            $this->validateEmails($em, $em2); // Check if emails match and are valid
            $this->validatePasswords($pw, $pw2); // Check if passwords match and are valid

            // If no errors were found during validation ($errorArray is empty)
            if(empty($this->errorArray)) {
                // Insert the new user into the database
                return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
            }
            return false; // Return false if any validation failed
        }

        public function login($un, $pw) {
            $pw = hash("sha512", $pw);

            $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");

            // Bind the actual values to the placeholders
            $query->bindValue(":un", $un);
            $query->bindValue(":pw", $pw);

            // Execute the query and return true/false based on success
            $query->execute();

            if($query->rowCount() == 1) {
                return true;
            }

            array_push($this->errorArray, Constants::$loginFailed);
            return false;


        }

        // Method to insert a new user into the database
        private function insertUserDetails($fn, $ln ,$un, $em, $pw) {
            // Hash the password for security using SHA-512 algorithm
            // Never store plain text passwords in database
            $pw = hash("sha512", $pw);

            // Prepare SQL statement to prevent SQL injection
            // Use placeholders (:fn, :ln, etc.) for safe value insertion
            $query = $this->con->prepare("INSERT INTO users (firstName, lastName, username, email, password) 
                                        VALUES (:fn, :ln, :un, :em, :pw)");

            // Bind the actual values to the placeholders
            $query->bindValue(":fn", $fn);
            $query->bindValue(":ln", $ln);
            $query->bindValue(":un", $un);
            $query->bindValue(":em", $em);
            $query->bindValue(":pw", $pw);

            // Execute the query and return true/false based on success
            return $query->execute();
        }

        // Validation methods below check each input field
        // Each method adds error messages to $errorArray if validation fails

        private function validateFirstName($fn) {
            // Check if name length is between 2 and 25 characters
            if(strlen($fn) < 2 || strlen($fn) > 25) {
                // Add error message from Constants class if validation fails
                array_push($this->errorArray, Constants::$firstNameCharacters);
            }
        }
        
        // Similar validation for last name
        private function validateLastName($ln) {
            if(strlen($ln) < 2 || strlen($ln) > 25) {
                array_push($this->errorArray, Constants::$lastNameCharacters);
            }
        }
  
        // Username validation includes length check and uniqueness check
        private function validateUsername($un) {
            // First check length
            if(strlen($un) < 2 || strlen($un) > 25) {
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;
            }

            // Then check if username already exists in database
            $query = $this->con->prepare("SELECT * FROM users WHERE username=:un");
            $query->bindValue(":un", $un);
            $query->execute();
            
            if($query->rowCount() != 0) {
                array_push($this->errorArray, Constants::$usernameTaken);
            }
        }
        
        // Email validation checks matching emails, format, and uniqueness
        private function validateEmails($em, $em2) {
            // Check if both email addresses match
            if ($em != $em2) {
                array_push($this->errorArray, Constants::$emailsDontMatch);
                return;
            }

            // Check if email format is valid using PHP's built-in filter
            if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }

            // Check if email is already registered
            $query = $this->con->prepare("SELECT * FROM users WHERE email=:em");
            $query->bindValue(":em", $em);
            $query->execute();
            
            if($query->rowCount() != 0) {
                array_push($this->errorArray, Constants::$emailTaken);
            }
        }

        // Password validation checks matching passwords and length
        private function validatePasswords($pw, $pw2) {
            if ($pw != $pw2) {
                array_push($this->errorArray, Constants::$passwordsDontMatch);
                return;
            }

            if(strlen($pw) < 5 || strlen($pw) > 25) {
                array_push($this->errorArray, Constants::$passwordLength);
            }
        }

        // Public method to get specific error messages
        // Used by the registration form to display errors to user
        public function getError($error) {
            if(in_array($error, $this->errorArray)) {
                return "<span class='errorMessage'>$error</span>";
            }
        }
    }
?>