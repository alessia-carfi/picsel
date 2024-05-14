<?php
include_once "account_utils.php";
if (session_status() !== PHP_SESSION_ACTIVE) {
    sec_session_start();
}

class DatabaseHelper {
    private const UP = 1;
    private const DOWN = -1;
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
        $stmt->bind_result($user_id, $name, $nickname, $db_email, $db_password, $image);
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

    public function register($name, $username, $email, $password, $confirmpassword) {
        if ($password !== $confirmpassword) {
            return false;
        }
        $stmt = $this->db->prepare("INSERT INTO USR (name, nickname, email, `password`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $username, $email, $password);
        $stmt->execute();
        return true;
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
    
    public function getPostVoteType($post_id) {
        $stmt = $this->db->prepare("SELECT type FROM LIKED WHERE LIKED.user_id=? and LIKED.post_id=?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            return "None";
        }
        
        // Post has been liked if type=true, it's been disliked if type=false
        return $result->fetch_assoc()['type'] ? "Up" : "Down";
    }

    public function votePost($post_id, $type, $already_voted) {
        if ($already_voted) {
            $stmt = $this->db->prepare("UPDATE LIKED SET `type`=? WHERE LIKED.user_id=? AND LIKED.post_id=?");
        } else {
            $stmt = $this->db->prepare("INSERT INTO LIKED (`liked`, user_id, post_id) VALUES (?, ?, ?)");
        }
        $stmt->bind_param("iii", $type, $_SESSION['user_id'], $post_id);
        $stmt->execute();
        $stmt->store_result();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return  $affected_rows + $this->updatePostVoteCount($post_id, $type, $already_voted);
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

    private function checkbrute($user_id) {
        $now = time();
        $valid_attempts = $now - (2 * 60 * 60); //Attempts in the past 2 hours
        $stmt = $this->db->prepare("SELECT `time` FROM login_attempts WHERE user_id=? AND `time` > $valid_attempts");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows() > 5;
    }
    
    private function updatePostVoteCount($post_id, $type, $already_voted) {
        $old_likes = $this->getPostById($post_id)['likes'];
    
        // If the post had received an upvote already and changes to a downvote, the likes counter goes down by 2 (removes
        // the +1 point of the upvote, then removes another point for the downvote), and vice versa.
        $multiplier = ($already_voted ? 2 : 1);
        if ($type) {
            $new_likes = $old_likes + ($multiplier * $this::UP);
        } else {
            $new_likes = $old_likes + ($multiplier * $this::DOWN);
        }
    
        $stmt = $this->db->prepare("UPDATE POST SET likes=? WHERE POST.post_id=?");
        $stmt->bind_param("ii", $new_likes, $post_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->affected_rows;
    }
}
?>