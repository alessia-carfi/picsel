<?php
include_once __DIR__ . "/../account_utils.php";
sec_session_start();

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

    public function checkSignupEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM USR WHERE email=?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return ['success' => true, 'message' => 'In use'];
            } else {
                return ['success' => true, 'message' => 'Not in use'];
            }
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }

    public function checkSignupUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM USR WHERE nickname=?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return ['success' => true, 'message' => 'In use'];
            } else {
                return ['success' => true, 'message' => 'Not in use'];
            }
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
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

    public function getPostsByUserIdWithLiked($from_userid) {
        $stmt = $this->db->prepare("SELECT POST.post_id, POST.game_id, POST.text, POST.image, POST.likes, POST.comments, POST.user_id, USR.nickname, LIKED.type from POST JOIN USR ON USR.user_id=POST.user_id LEFT JOIN LIKED ON LIKED.post_id=POST.post_id AND LIKED.user_id=? WHERE USR.user_id=?");
        $stmt->bind_param('ii', $from_userid, $_SESSION['user_id']);
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
        $stmt = $this->db->prepare("SELECT `type` FROM LIKED WHERE LIKED.user_id=? and LIKED.post_id=?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            return "None";
        }
        
        // Post has been liked if type=true, it's been disliked if type=false
        return $result->fetch_assoc()['type'] ? "Up" : "Down";
    }

    public function votePost($post_id, $type) {
        $prevVoteType = $this->getPostVoteType($post_id);
        switch ($prevVoteType) {
            case "None":
                $stmt = $this->db->prepare("INSERT INTO LIKED (`post_id`, `user_id`, `type`) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $post_id, $_SESSION['user_id'], $type);
                if ($stmt->execute()) {
                    return $this->updatePostVoteCount($post_id, $type, 1);
                } else {
                    return ['success' => false, 'message' => 'Error: ' . $stmt->error];
                }
            case "Up":
                return $type ? $this->removeLiked($post_id, $type) : $this->updateLiked($post_id, $type);
            case "Down":
                return $type ? $this->updateLiked($post_id, $type) : $this->removeLiked($post_id, $type);
        }
    }

    
    public function getPostByIdAndLikes($post_id) {
        $stmt = $this->db->prepare("SELECT POST.post_id, POST.game_id, POST.text, POST.image, POST.likes, POST.comments, POST.user_id, USR.nickname, LIKED.type from POST JOIN USR ON USR.user_id=POST.user_id LEFT JOIN LIKED ON LIKED.post_id=POST.post_id AND LIKED.user_id=? WHERE USR.user_id=?");
        $stmt->bind_param("ii", $post_id, $_SESSION['user_id']);
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

    private function removeLiked($post_id, $type) {
        $stmt = $this->db->prepare("DELETE FROM LIKED WHERE post_id=? AND user_id=?");
        $stmt->bind_param("ii", $post_id, $_SESSION['user_id']);
        if ($stmt->execute()) {
            return $this->updatePostVoteCount($post_id, !$type, 1);
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }

    private function updateLiked($post_id, $type) {
        $stmt = $this->db->prepare("UPDATE LIKED SET `type`=? WHERE post_id=? AND user_id=?");
        $stmt->bind_param("iii", $type, $post_id, $_SESSION['user_id']);
        if ($stmt->execute()) {
            return $this->updatePostVoteCount($post_id, $type, 2);
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }
    

    // If the post had received an upvote already and changes to a downvote, the likes counter goes down by 2 (removes
    // the +1 point of the upvote, then removes another point for the downvote), and vice versa.
    public function updatePostVoteCount($post_id, $type, $multiplier) {
        $old_likes = $this->getPostByIdAndLikes($post_id)['likes'];
        if ($type) {
            $new_likes = $old_likes + ($multiplier * $this::UP);
        } else {
            $new_likes = $old_likes + ($multiplier * $this::DOWN);
        }
    
        $stmt = $this->db->prepare("UPDATE POST SET likes=? WHERE POST.post_id=?");
        $stmt->bind_param("ii", $new_likes, $post_id);
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
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