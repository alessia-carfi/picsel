<?php
class DatabaseHelper {
    private $db;
    
    public function __construct($servername, $username, $password, $dbname) {
        $this->db = new mysqli($servername, $username, $password, $dbname);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }
    
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM USR WHERE email=? AND `password`=? LIMIT 1;");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id, $p_iva, $name, $nickname, $db_email, $db_password, $image);
        $stmt->fetch();
        
        if ($stmt->num_rows() == 1) {
            if ($this->checkbrute($user_id)) {
                //User has been trying to bruteforce access; user's account is deactivate.
                return false;
            } else {
                if ($db_password = $password) {
                    //Login successful
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $nickname;
                    $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
                    return true;
                } else {
                    //Save login attempt to check for bruteforce later 
                    $now = time();
                    $this->db->query("INSERT INTO login_attempts (user_id, `time`) VALUES ('$user_id', '$now')");
                }
            }
        } else {
            return false; //User does not exist
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
    
    private function checkbrute($user_id) {
        $now = time();
        $valid_attempts = $now - (2 * 60 * 60); //Attempts in the past 2 hours
        $stmt = $this->db->prepare("SELECT `time` FROM login_attempts WHERE user_id=? AND `time` > $valid_attempts");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows() > 5;
    }


    public function getPostById($post_id) {
        $stmt = $this->db->prepare("SELECT * FROM POST JOIN USR ON USR.user_id=POST.user_id WHERE post_id = ?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            $post = mysqli_fetch_assoc($result);
        } else {
            echo "Post not found";
            exit;
        }
        return $post;
    }

    public function getCommentsByPostId($post_id) {
        $stmt = $this->db->prepare("SELECT * FROM COMMENT WHERE post_id= ?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = array();
        while ($comment = mysqli_fetch_assoc($result)) {
            $comments[] = $comment;
        }
        return $comments;
    }

    public function setProfileImage($image, $user_id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']['error'])) {
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $img = file_get_contents($_FILES['image']['tmp_name']);
                $stmt = $this->db->prepare("UPDATE USR SET image=? WHERE user_id=?");
                $stmt->bind_param("bi", $img, $user_id);
                $stmt->execute();
                echo "Image changed!";
            } else {
                echo "Upload failed with error code " . $_FILES['image']['error'];
            }
        }
    }
    
}
?>