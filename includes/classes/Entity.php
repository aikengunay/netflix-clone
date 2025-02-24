<?php
/**
 * Entity Class
 * Represents a media entity (like a movie or TV show) in the system
 * Handles fetching and storing entity data from the database
 */
class Entity {
    // Database connection object for database operations
    private $con;
    // Stores the entity's data retrieved from the database
    private $sqlData;

    /**
     * Constructor - Creates a new Entity object
     * @param $con - Database connection object (PDO)
     * @param $input - Either an ID (integer) or array of entity data
     */
    public function __construct($con, $input) {
        // Store the database connection for later use
        $this->con = $con;
    
        // Check if we received pre-loaded data or need to fetch from database
        if (is_array($input)) {
            // If input is already an array, use it directly
            $this->sqlData = $input;
        }
        else {
            // If input is an ID, fetch the entity data from database
            // Prepare the SQL query with a placeholder :id for safety
            $query = $this->con->prepare("SELECT * FROM entities WHERE id=:id");
            // Bind the actual ID value to the placeholder
            $query->bindValue(":id", $input);
            // Execute the query
            $query->execute();

            // Fetch the result as an associative array
            // This creates an array where column names are the keys
            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Gets the unique identifier of the entity
     * @return int - The entity's ID from the database
     */
    public function getId() {
        return $this->sqlData["id"];
    }
    
    /**
     * Gets the name/title of the entity
     * @return string - The entity's name
     */
    public function getName() {
        return $this->sqlData["name"];
    }
    
    /**
     * Gets the thumbnail image path for the entity
     * @return string - URL or path to the thumbnail image
     */
    public function getThumbnail() {
        return $this->sqlData["thumbnail"];
    }
    
    /**
     * Gets the preview video path for the entity
     * @return string - URL or path to the preview video
     */
    public function getPreview() {
        return $this->sqlData["preview"];
    }
}
?>