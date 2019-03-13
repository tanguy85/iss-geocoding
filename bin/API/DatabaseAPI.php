<?php

    require_once '../bin/PDO/DBConnection.php';

    class DatabaseAPI extends DBConnection{

        public function connectUser($username, $password){
            $this->connectDB();
            // $password = hash('sha256', $password);
            $stmt = $this->connection->prepare("SELECT id, username, firstname, surname, email, address, zip_code, country FROM users where username = :username AND password = :password");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_OBJ);
            var_dump($result);


            if (!empty($result)) {
                while($result = $stmt->fetch(PDO::FETCH_OBJ)){
                    session_start();
                    $_SESSION['id'] = $result->id;
                    $_SESSION['username'] = $result->username;
                    $_SESSION['password'] = $result->password;
                    $_SESSION['firstname'] = $result->firstname;
                    $_SESSION['surname'] = $result->surname;
                    $_SESSION['email'] = $result->email;
                    $_SESSION['address'] = $result->address;
                    $_SESSION['zip_code'] = $result->zip_code;
                    $_SESSION['country'] = $result->country;
                }
                header('Location: ../pages/home.php');
            }
            else {
                header('Location: ../index.php?error=1');
            }
        }
    }