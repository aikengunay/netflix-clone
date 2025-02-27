<?php
class CategoryContainers {
    // Database connection object - used to communicate with the database
    private $con;
    // Stores the currently logged-in user's username
    private $username;

    /**
     * Constructor - initializes the class with database connection and username
     * This is called automatically when creating a new PreviewProvider object
     * @param $con - Database connection (PDO object)
     * @param $username - Current user's username (string)
     */
    public function __construct($con, $username) {
        $this->con = $con;        // Store the database connection for later use
        $this->username = $username;  // Store the username for later use
    }

    public function showAllCategories() {
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>";
        
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $row["name"];
        }
        return $html . "</div>";
    }   
}
?>