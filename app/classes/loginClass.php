<?php


class Login extends Database{

public function loginUser($email, $password){
    try{
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM users WHERE user_email = '$email' LIMIT 1";

        $statement = $this->conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        if(count($result) > 0){
            if($result[0]->user_password == $password){
                if($result[0]->validation == 1){

                    session_start();
                    $_SESSION['user_id'] = $result[0]->user_id;
                    $_SESSION['user_email'] = $result[0]->user_email;
                    $_SESSION['user_phone'] = $result[0]->phone_number;
                    $_SESSION['user_address'] = $result[0]->user_address;
                    $_SESSION['user_rank'] = $result[0]->rank;
                    $_SESSION['user_name'] = $result[0]->username;
                    $_SESSION['user_url'] = $result[0]->user_urlAddress;
                    $_SESSION['user_image'] = $result[0]->profile_picture;
                    $_SESSION['join_date'] = $result[0]->join_date;
                    $_SESSION['validation'] = $result[0]->validation;
                    $_SESSION['user_about'] = $result[0]->user_about;
                    $_SESSION['user_cin'] = $result[0]->user_cin;
                    return 1;
                    
                }else{
                    return 4;
                }

            }else{
                return 2;
            }
        }else{
            return 3;
        }

    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

public function getUserRank(){
    return $_SESSION['user_rank'];
}

public function findUser($email){
    try{
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM users WHERE user_email = '$email' LIMIT 1";

        $statement = $this->conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        if(count($result) > 0){
            return 1;
            die();

        }else{
            return 2;
            die();
        }

    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

public function updatePassword($email, $password){
    try{
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM users WHERE user_email = '$email' LIMIT 1";

        $statement = $this->conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        if(count($result) > 0){
            $sql = "UPDATE users SET user_password = '$password' WHERE user_email = '$email'";

            $statement = $this->conn->prepare($sql);
            $statement->execute();

            return 1;
            die();

        }else{
            return 2;
            die();

        }

    }catch(PDOException $e){
        echo $e->getMessage();
    } 
}

public function logoutUser(){
    try{
        session_reset();
        session_destroy();

        return true;

    }catch(PDOException $e){
        echo $e->getMessage();
    } 
}

}