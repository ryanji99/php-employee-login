<?php

namespace Model;

class UserModel extends Model
{
    public function loginAction()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $match = $this->gateway->findUserByUsername($username);
        if ($match) {
            $password_check = password_verify($password, $match['password']);

            if ($password_check) {
                $this->gateway->updateNumLogins($username);
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;
                $_SESSION["logins"] = $match['numLogin'];
                $_SESSION["firstName"] = $match['firstName'];
                $_SESSION["lastName"] = $match['lastName'];
                if ($match['twofa'] === 1) {
                    $_SESSION["2fa"] = $match['twofa'];
                }
                return true;
            }
        }
        return false;
    }

    public function registerAction()
    {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $dateOfBirth = $_POST['dateOfBirth'];
        $question1 = $_POST['question1'];
        $answer1 = $_POST['answer1'];
        $question2 = $_POST['question2'];
        $answer2 = $_POST['answer2'];

        // Prepare a select statement
        $return = $this->gateway->findUserByEmail($email);
        if (!is_null($return)) {
            $_SESSION['errors']['repEmailErr'] = "This email is already taken.\nTry a different email.";
        }
        if (empty($_SESSION['errors'])) {
            $hash = md5(rand(0, 1000));
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $hashed_answer1 = sha1($answer1);
            $hashed_answer2 = sha1($answer2);

            // $twofatoken = \Utils\Base32Static::encode(\Utils\Base32Static::getRandomString());

            $insert = $this->gateway->insertUser($firstName, $lastName, $email, $username, $hashed_password, $dateOfBirth, $question1, $hashed_answer1, $question2, $hashed_answer2, $hash);
            if ($insert) {
                //Spaghetti for the mailer
                $_SESSION["email"] = $email;
                $_SESSION["firstName"] = $firstName;
                $_SESSION["hash"] = $hash;
                //Spaghetti for the mailer
                return true;
            } else {
                $_SESSION['errors']['error'] = "Something went wrong. Please try again later.";
            }
        } else
            echo "Your email is taken! Try a different email!";
    }

    public function validateEmailRequest($username, $hash)
    {
        $return = $this->gateway->getSecurityQuestions($username, $hash);
        if (!is_null($return)) {
            return $return;
        }
    }

    public function validateSecurityQuestions($username)
    {
        $return = $this->gateway->getSecurityAnswers($username);
        if (!is_null($return)) {
            return $return;
        }
    }

    public function changePassword($hashed_password, $username)
    {
        $return = $this->gateway->changePassword($hashed_password, $username);
        if (!is_null($return)) {
            return $return;
        }
    }
    public function activateAccount($email, $hash)
    {
        $return = $this->gateway->activateAccount($email, $hash);
        if (!is_null($return)) {
            return $return;
        }
    }
    public function set2FA($username)
    {
        if ($_POST['2fa'] === "no")
            $onoff = 0;
        if ($_POST['2fa'] === "yes")
            $onoff = 1;

        $return = $this->gateway->set2FA($username, $onoff);
        if (!is_null($return)) {
            return $return;
        }
    }

    public function get2FAtoken($username)
    {
        $return = $this->gateway->get2FAtoken($username);
        if (!is_null($return)) {
            return $return;
        }
    }
}
