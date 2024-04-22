<?php
class DatabaseHelper {
    private $db;

    public function __construct($servername, $username, $password, $dbname) {
        $this->db = new mysqli($servername, $username, $password, $dbname);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }
    public function getRandomPosts($n) {
        $stmt = $this->db->prepare("SELECT text, image, tag_id, nickname FROM post, user ORDER BY RAND() LIMIT ?");
        $stmt->bind_param('i', $n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostsByUserId($userid) {
        $stmt = $this->db->prepare("SELECT * from POST JOIN USR ON USR.user_id=POST.user_id WHERE USR.user_id=?");
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostsByTag($tag) {
        $stmt = $this->db->prepare("SELECT text, image, tag_id, nickname from post, user WHERE tag=?");
        $stmt->bind_param('s', $tag);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getSuggestedPosts($userid) {
        // Questa è per i consigliati, che propongono post che riguardano
        // giochi con tag uguali ai giochi che segui
        $stmt = $this->db->prepare("JOIN ");
    }

    public function getGameFromId($id) {
        $stmt = $this->db->prepare("SELECT name from GAME where game_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()['name'];
    }

    public function getSavedPostsFromUser($userid) {
        /*TODO*/
    }

    public function insertPost() {
        /*TODO*/
    }

}
?>