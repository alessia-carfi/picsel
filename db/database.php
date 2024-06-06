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
        $stmt = $this->db->prepare("SELECT * FROM USR WHERE email=? LIMIT 1;");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id, $name, $nickname, $db_email, $db_password, $salt, $image);
        $stmt->fetch();
        $password = hash('sha512', $password.$salt);
        
        if ($stmt->num_rows() == 1) {
            if ($this->checkbrute($user_id)) {
                //User has been trying to bruteforce access; user's account is deactivate.
                return false;
            } else {
                if ($db_password == $password) {
                    //Login successful
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    $nickname = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $nickname);
                    $_SESSION['username'] = $nickname;
                    $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
                    return true;
                } else {
                    //Save login attempt to check for bruteforce later 
                    $now = time();
                    $this->db->query("INSERT INTO login_attempts (user_id, `time`) VALUES ('$user_id', '$now')");
                    return false;
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
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password = hash('sha512', $password.$random_salt);
        $stmt = $this->db->prepare("INSERT INTO USR (name, nickname, email, `password`, salt) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $username, $email, $password, $random_salt);
        return $stmt->execute();
    }

    public function addNewPost($text, $image, $game_id) {
        $stmt = $this->db->prepare("INSERT INTO `POST` (`text`, `image`, likes, comments, user_id, game_id)
                                    VALUES (?, ?, 0, 0, ?, ?)");
        $stmt->bind_param("ssii", $text, $image, $_SESSION['user_id'], $game_id);
        if($stmt->execute()) {
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "Error: " . $stmt->error ];
        }
    }

    public function addNewGame($name, $desc, $user_id, $image, $tags) {
        $stmt = $this->db->prepare("INSERT INTO GAME (`name`, `description`, `user_id`, `image`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $name, $desc, $user_id, $image);
        if ($stmt->execute()) {
            $game_id = $this->db->insert_id;
            foreach ($tags as $tag) {
                $stmt = $this->db->prepare("INSERT INTO HAS_TAG (`name`, game_id) VALUES (?, ?)");
                $stmt->bind_param("si", $tag, $game_id);
                $stmt->execute();
            }
            return ["success" => true];
        } 
        return ["success" => false, "message" => "Error: " . $stmt->error ];
    }
    
    public function getPostsByUserId($from_userid) {
        $stmt = $this->db->prepare("SELECT POST.post_id, POST.game_id, POST.text, POST.image, POST.likes, POST.comments, POST.user_id, USR.nickname, USR.image as usrimage  from POST JOIN USR ON USR.user_id=POST.user_id WHERE USR.user_id=?");
        $stmt->bind_param('i', $from_userid);
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

    public function getPostsByGameId($game_id) {
        $stmt = $this->db->prepare("SELECT  POST.post_id, POST.game_id, POST.text, POST.image, POST.likes, POST.comments, POST.user_id, USR.nickname, USR.image as usrimage 
                                    FROM POST LEFT JOIN USR ON USR.user_id=POST.user_id
                                    WHERE POST.game_id=?");
        $stmt->bind_param('i', $game_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public function getExplorePosts($limit) {
        /* Gets posts from games with the same tags as your followed games */
        $stmt = $this->db->prepare("SELECT POST.post_id, POST.game_id, POST.text, POST.image, POST.likes, POST.comments, POST.user_id, USR.nickname, USR.image as usrimage 
                                    FROM POST LEFT JOIN USR ON USR.user_id=POST.user_id
                                    WHERE POST.game_id IN
                                    (SELECT game_id FROM HAS_TAG WHERE name IN
                                        (SELECT name FROM HAS_TAG WHERE game_id IN
                                            (SELECT game_id FROM FOLLOWS_GAME WHERE user_id=?)
                                        )
                                    )
                                    ORDER BY RAND()
                                    LIMIT ?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            return $this->getRandomPosts($limit);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRandomPosts($limit) {
        $stmt = $this->db->prepare("SELECT POST.post_id, POST.game_id, POST.text, POST.image, POST.likes, POST.comments, POST.user_id, USR.nickname, USR.image as usrimage 
                                    FROM POST LEFT JOIN USR ON USR.user_id=POST.user_id
                                    ORDER BY RAND()
                                    LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result(); 

        return $result->fetch_all(MYSQLI_ASSOC);              
    }

    public function getFollowedUsers() {
        $stmt = $this->db->prepare("SELECT USR.name, USR.nickname, USR.image, USR.user_id FROM USR JOIN FOLLOWS_USER 
                                    ON USR.user_id=FOLLOWS_USER.Fol_user_id WHERE FOLLOWS_USER.user_id=?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function followingUser($user_id) {
        return $this->isUserFollowed($user_id) ?
                $this->unfollowUser($user_id) :
                $this->followUser($user_id);
    }

    public function isUserFollowed($user_id){
        $stmt = $this->db->prepare("SELECT * FROM FOLLOWS_USER WHERE user_id=? AND Fol_user_id=?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows == 1;
    }

    public function followUser($user_id) {
        $stmt = $this->db->prepare("INSERT INTO FOLLOWS_USER (user_id, Fol_user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $_SESSION['user_id'], $user_id);
        if ($stmt->execute()) {
            return $this->addNotification($user_id, "started following you.");
        } else {
            return ["success" => false, "message" => "Error: " . $stmt->error ];
        }
    }

    public function unfollowUser($user_id) {
        $stmt = $this->db->prepare("DELETE FROM FOLLOWS_USER WHERE user_id=? AND Fol_user_id=?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $user_id);
        if ($stmt->execute()) {
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "Error: " . $stmt->error ];
        }
    }

    public function followingGame($game_id) {
        $isfollowed = $this->isUserSubscribed($game_id);
        switch ($isfollowed) {
            case false:
                return $this->followGame($game_id);
            case true:
                return $this->unfollowGame($game_id);
        }
    }

    public function isUserSubscribed($game_id){
        $stmt = $this->db->prepare("SELECT * FROM FOLLOWS_GAME WHERE user_id=? AND game_id=?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $game_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows == 1;
    }

    public function followGame($game_id) {
        $stmt = $this->db->prepare("INSERT INTO FOLLOWS_GAME (game_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $game_id,  $_SESSION['user_id']);
        if ($stmt->execute()) {
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "Error: " . $stmt->error ];
        }
    }

    public function unfollowGame($game_id) {
        $stmt = $this->db->prepare("DELETE FROM FOLLOWS_GAME WHERE user_id=? AND game_id=?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $game_id);
        if ($stmt->execute()) {
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "Error: " . $stmt->error ];
        }
    }

    public function getNotifications() {
        $stmt = $this->db->prepare("SELECT * FROM `NOTIFICATION` WHERE user_id=?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFollowedGames() {
        $stmt = $this->db->prepare("SELECT * FROM FOLLOWS_GAME JOIN GAME
                                    ON GAME.game_id=FOLLOWS_GAME.game_id WHERE FOLLOWS_GAME.user_id=?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllGames() {
        $stmt = $this->db->prepare("SELECT * FROM GAME");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getGameFromId($id) {
        $stmt = $this->db->prepare("SELECT * from GAME where game_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC)[0];
    }

    public function getUserFromId($id) {
        $stmt = $this->db->prepare("SELECT * FROM USR WHERE user_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC)[0];
    }
    
    public function getSavedPosts() {
        $stmt = $this->db->prepare("SELECT POST.post_id, POST.game_id, POST.text, 
                                           POST.image, POST.likes, POST.comments, POST.user_id, USR.nickname, USR.image as usrimage 
                                           FROM (POST JOIN USR ON POST.user_id=USR.user_id)
                                           RIGHT JOIN SAVED ON POST.post_id=SAVED.post_id WHERE SAVED.user_id=? 
                                           GROUP BY POST.post_id");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
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

    public function isPostSaved($post_id) {
        $stmt = $this->db->prepare("SELECT * FROM SAVED WHERE post_id=? AND user_id=?");
        $stmt->bind_param("ii", $post_id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows == 1;
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

    public function savePost($post_id) {
        $stmt = $this->db->prepare("INSERT INTO SAVED (post_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $post_id, $_SESSION['user_id']);
        if ($stmt->execute()) {
            return $this->addNotification($this->getPostById($post_id)['user_id'], "saved your post.");
        } else {
            return ["success" => false, "message" => "Error: " . $stmt->error ];
        }
    }

    public function unsavePost($post_id) {
        $stmt = $this->db->prepare("DELETE FROM SAVED WHERE post_id=? AND user_id=?");
        $stmt->bind_param("ii", $post_id, $_SESSION['user_id']);
        if ($stmt->execute()) {
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "Error: " . $stmt->error ];
        }
    }
    
    public function getPostById($post_id) {
        $stmt = $this->db->prepare("SELECT POST.post_id, POST.game_id, POST.text, POST.image, POST.likes, POST.comments, POST.user_id, USR.nickname, USR.image as usrimage  from POST JOIN USR ON USR.user_id=POST.user_id WHERE POST.post_id=?");
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
    public function setProfileImage($image) {
        $stmt = $this->db->prepare("UPDATE USR SET image=? WHERE user_id=?");
        $stmt->bind_param("si", $image, $_SESSION['user_id']);
        $stmt->execute();
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }

    public function getProfileImage($user_id) {
        $stmt = $this->db->prepare("SELECT image FROM USR WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()['image'];
    }

    public function setProfileNickname($nickname) {
        $stmt = $this->db->prepare("UPDATE USR SET nickname=? WHERE user_id=?");
        $stmt->bind_param("si", $nickname, $_SESSION['user_id']);
        if ($stmt->execute()) {
            $_SESSION['username'] = $nickname;
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }

    public function getProfileNickname($user_id) {
        $stmt = $this->db->prepare("SELECT nickname FROM USR WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()['nickname'];
    }

    public function setProfileName($name) {
        $stmt = $this->db->prepare("UPDATE USR SET name=? WHERE user_id=?");
        $stmt->bind_param("si", $name, $_SESSION['user_id']);
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }

    public function getProfileName($user_id) {
        $stmt = $this->db->prepare("SELECT name FROM USR WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()['name'];
    }

    
    public function removeNotification($id) {
        $stmt = $this->db->prepare("DELETE FROM `NOTIFICATION` WHERE notification_id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return ["success" => true];
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }

    public function getHomePosts($limit) {
        $stmt = $this->db->prepare("SELECT POST.post_id, POST.game_id, POST.text, POST.image, POST.likes, POST.comments, POST.user_id, USR.nickname, USR.image as usrimage 
                                    FROM POST LEFT JOIN USR ON USR.user_id=POST.user_id 
                                    WHERE 
                                        POST.game_id IN (SELECT game_id FROM FOLLOWS_GAME WHERE user_id=?) 
                                        OR 
                                        POST.user_id IN (SELECT Fol_user_id from FOLLOWS_USER WHERE user_id=?)
                                    ORDER BY RAND()
                                    LIMIT ?");
        $stmt->bind_param("iii", $_SESSION['user_id'], $_SESSION['user_id'], $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function createComment($text, $post_id) {
        $stmt = $this->db->prepare("INSERT INTO COMMENT (post_id, user_id, text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $post_id, $_SESSION['user_id'], $text);
        if ($stmt->execute()) {
            return $this->updateCommentCount($post_id);
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }

    public function getPostsFromSearch($searchText) {
        $stmt = $this->db->prepare("SELECT POST.post_id, POST.game_id, POST.text, POST.image, POST.likes, POST.comments, POST.user_id, USR.nickname, USR.image as usrimage FROM POST JOIN USR ON USR.user_id=POST.user_id JOIN GAME ON GAME.game_id=POST.game_id WHERE POST.text LIKE ? OR USR.nickname LIKE ? OR GAME.name LIKE ? OR USR.name LIKE ?");

        if ($searchText[0] != '%') $searchText = '%' . $searchText;
        if ($searchText[strlen($searchText) - 1] != '%') $searchText = $searchText . '%';

        $stmt->bind_param("ssss", $searchText, $searchText, $searchText, $searchText);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNumberOfPostsFromGame($game_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM POST WHERE game_id=?");
        $stmt->bind_param("i", $game_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()['count'];
    }

    public function getNumberOfPostsFromUser($user_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM POST WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()['count'];
    }

    public function getNumberOfSubscribers($game_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM FOLLOWS_GAME WHERE game_id=?");
        $stmt->bind_param("i", $game_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()['count'];
    }

    public function getNumberOfFollowers($user_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM FOLLOWS_USER WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()['count'];
    }

    public function getNumberOfFollowedUser($user_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM FOLLOWS_USER WHERE Fol_user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()['count'];
    }

    public function getNumberOfSubs($user_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM FOLLOWS_GAME WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()['count'];
    }
    
    private function updateCommentCount($post_id) {
        $stmt = $this->db->prepare("UPDATE POST SET comments=? WHERE POST.post_id=?");
        $old_comms = $this->getPostById($post_id)['comments'];
        $new_comms = $old_comms + 1;
        $stmt->bind_param("ii", $new_comms, $post_id);
        if ($stmt->execute()) {
            return $this->addNotification($this->getPostById($post_id)['user_id'], "commented on your post.");
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }
    
    private function addNotification($user_id, $text) {
        $stmt = $this->db->prepare("INSERT INTO `NOTIFICATION` (`name`, `text`, `user_id`) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $_SESSION['username'], $text, $user_id);
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }

    public function getAllTagsGame($game_id){
        $stmt = $this->db->prepare("SELECT * FROM HAS_TAG WHERE game_id=?");
        $stmt->bind_param("i", $game_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllTags() {
        $stmt = $this->db->prepare("SELECT * FROM TAG");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tags = array();
        while ($tag = mysqli_fetch_assoc($result)) {
            $tags[] = $tag;
        }
        return $tags;
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
    private function updatePostVoteCount($post_id, $type, $multiplier) {
        $old_likes = $this->getPostById($post_id)['likes'];
        if ($type) {
            $amount = $multiplier * $this::UP;
        } else {
            $amount = $multiplier * $this::DOWN;
        }

        $new_likes = $old_likes + $amount;
        $stmt = $this->db->prepare("UPDATE POST SET likes=? WHERE POST.post_id=?");
        $stmt->bind_param("ii", $new_likes, $post_id);
        if ($stmt->execute()) {
            if($type) {
                if($this->addNotification($this->getPostById($post_id)['user_id'], "liked your post.") == ['success' => true]) {
                    return ['success' => true, 'amount' => $amount];
                } else {
                    return ['success' => false, 'message' => 'Error: failed to send notification'];
                }
            } else { 
                return ['success' => true, 'amount' => $amount];
            }
        } else {
            return ['success' => false, 'message' => 'Error: ' . $stmt->error];
        }
    }
}
?>