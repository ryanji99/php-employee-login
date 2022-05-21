<?php

namespace DataGateway;

class UsersTableDataGateway extends TableDataGateway
{
    protected $db;
    public function __construct(\db $db)
    {
        $this->db = $db;
    }

    public function findUserByUsername($username) //Returns NULL when no user found
    {
        $stmt = $this->db->prepare('SELECT firstName, lastName, password, numLogin, twofa, hash, email FROM users_list WHERE username = ?');
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function findUserByEmail($email) //Returns NULL when no user found
    {
        $stmt = $this->db->prepare('SELECT firstName, username FROM users_list WHERE email = ?');
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    public function updateNumLogins($username)
    {
        $stmt = $this->db->prepare("UPDATE users_list SET numLogin = numLogin + 1 WHERE username = ?");
        $stmt->bind_param("s", $username);
        return mysqli_stmt_execute($stmt);
    }

    public function insertUser($firstName, $lastName, $email, $username, $hashed_password, $dateOfBirth, $question1, $hashed_answer1, $question2, $hashed_answer2, $hash)
    {
        $stmt = $this->db->prepare("INSERT INTO users_list(firstName, lastName, email, username, password, dateOfBirth, question1, answer1, question2, answer2, hash) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssisiss", $firstName, $lastName, $email, $username, $hashed_password, $dateOfBirth, $question1, $hashed_answer1, $question2, $hashed_answer2, $hash,);
        return mysqli_stmt_execute($stmt);
    }

    //password_success.php
    public function changePassword($hashed_password, $username)
    {
        $stmt = $this->db->prepare("UPDATE users_list SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $hashed_password, $username);
        return mysqli_stmt_execute($stmt);
    }

    //registration_success.php
    public function activateAccount($email, $hash)
    {
        $stmt = $this->db->prepare("UPDATE users_list SET status = '1' WHERE email = ? AND hash = ? AND status = '0'");
        $stmt->bind_param("ss", $email, $hash);
        return mysqli_stmt_execute($stmt);
    }

    //security.php
    public function getSecurityQuestions($username, $hash)
    {
        $stmt = $this->db->prepare('SELECT question1, question2 FROM users_list WHERE username= ? AND hash= ?');
        $stmt->bind_param("ss", $username, $hash);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    //reset_pass.php
    public function getSecurityAnswers($username)
    {
        $stmt = $this->db->prepare('SELECT answer1, answer2 FROM users_list WHERE username = ?');
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function set2FA($username, $onoff)
    {
        $stmt = $this->db->prepare("UPDATE users_list SET twofa = ? WHERE username = ?");
        $stmt->bind_param("ss", $onoff, $username);
        return mysqli_stmt_execute($stmt);
    }

    public function get2FAtoken($username)
    {
        $stmt = $this->db->prepare('SELECT twofatoken FROM users_list WHERE username = ? LIMIT 1;');
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
