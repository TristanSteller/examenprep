<?php
include_once "db.class.php";

session_start();

class User extends DbConnection{

    public function __construct(){
 
        parent::__construct();
    }

    public function register($username, $email, $password, $repeat_password)
    {
        try {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error = "Invalid email";
            }
            if(!$password == $repeat_password){
                $error += ", Passwords don't match";
            }

            if (strlen($password) <= 6){
                $error = ", Choose a password longer then 6 character";
            }
            
            if(!isset($error)){
                $namecheck = $this->connection->prepare("SELECT username FROM users WHERE username = :username");
                $namecheck->bindParam(':username', $username);
                $namecheck->execute();

                if($namecheck->rowCount() > 0){
                    echo "Username already taken";
                    return;
                }

                $emailcheck = $this->connection->prepare("SELECT email FROM users WHERE email = :email");
                $emailcheck->bindParam(':email', $email);
                $emailcheck->execute();
                if($emailcheck->rowCount() > 0){
                    echo "Email already taken";
                    return;
                }

                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Define query to insert values into the users table
                $sql = "INSERT INTO users(username, email, password) VALUES(:user_name, :user_email, :user_password)";

                // Prepare the statement
                $query = $this->connection->prepare($sql);

                // Bind parameters
                $query->bindParam(":user_name", $username);
                $query->bindParam(":user_email", $email);
                $query->bindParam(":user_password", $hashed_password);

                // Execute the query
                if($query->execute()){
                    $this->login($username, $password);
                }

                
            }else{
                echo $error;
                exit();
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
 
    public function login($username, $password)
    {
        try {
            // Define query to insert values into the users table
            $sql = "SELECT * FROM users WHERE username=:user_name LIMIT 1";

            // Prepare the statement
            $query = $this->connection->prepare($sql);

            // Bind parameters
            $query->bindParam(":user_name", $username);

            // Execute the query
            $query->execute();

            // Return row as an array indexed by both column name
            $returned_row = $query->fetch(PDO::FETCH_ASSOC);

            // Check if row is actually returned
            if ($query->rowCount() > 0) {
                // Verify hashed password against entered password
                if (password_verify($password, $returned_row['password'])) {
                    // Define session on successful login
                    $_SESSION['user_id'] = $returned_row['id'];
                    return true;
                } else {
                    // Define failure
                    return false;
                }
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function is_logged_in() {
        // Check if user session has been set
        if (isset($_SESSION['user_id'])) {
            return true;
        }
    }

    public function get_user_data() {
        if  (!isset($_SESSION['user_id'])) {
            return false;
        }
        else {
            try {
                $sql = "SELECT * FROM users WHERE id=:user_id LIMIT 1";

                // Prepare the statement
                $query = $this->connection->prepare($sql);

                // Bind parameters
                $query->bindParam(":user_id", $_SESSION['user_id']);

                // Execute the query
                $query->execute();

                // Return row as an array indexed by both column name
                $returned_row = $query->fetch(PDO::FETCH_ASSOC);
                $user_data = array(
                    'user_id' => $returned_row['id'],
                    'username' => $returned_row['username'],
                    'email' => $returned_row['email']
                );
                return $user_data;
            } catch(PDOException $e){
                echo $e;
            }
        }
    }
}