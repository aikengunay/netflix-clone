<?php
/**
 * PreviewProvider Class
 * This class handles the generation and display of video previews on the website
 * It's responsible for showing thumbnails and preview videos for movies/shows
 */
class PreviewProvider {
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

    /**
     * Creates and displays a preview video for a given entity (movie/show)
     * If no entity is provided, it will randomly select one from the database
     * @param $entity - The Entity object containing movie/show information
     */
    public function createPreviewVideo($entity) {
        // If no specific entity was passed in, get a random one from the database
        if($entity == null) {
            $entity = $this->getRandomEntity();
        }

        // Extract all needed information from the entity object
        $id = $entity->getId();          // Unique identifier for the movie/show
        $name = $entity->getName();       // Title of the movie/show
        $preview = $entity->getPreview(); // Preview video URL
        $thumbnail = $entity->getThumbnail(); // Thumbnail image URL
        
        return "<div class='previewContainer'>
            <img src='$thumbnail' class='previewImage' hidden>
            <video autoplay muted class='previewVideo'>
                <source src='$preview' type='video/mp4'>
            </video>
        </div>";
    }

    /**
     * Gets a random entity (movie/show) from the database
     * Uses MySQL's RAND() function to ensure random selection
     * @return Entity - Returns a new Entity object with the random movie/show data
     */
    private function getRandomEntity() {
        // Prepare SQL query to select one random row from the entities table
        // Using prepare() helps prevent SQL injection attacks
        $query = $this->con->prepare("SELECT * FROM entities ORDER BY RAND() LIMIT 1");
        
        // Execute the prepared query to actually get the data
        $query->execute();

        // Fetch one row from the result as an associative array
        // PDO::FETCH_ASSOC makes the result an array with column names as keys
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        // Create and return a new Entity object with the random data
        // This converts the raw database row into a useful object
        return new Entity($this->con, $row);
    }
}
?>