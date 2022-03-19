<?php

require_once('init.php');

class Session
{
    private $user_signed_in;
    private $user_email;
    private $user_firstname;
    private $user_image;

    private $organ_signed_in;
    private $organ_name;
    private $organ_id;
    private $organ_image;

    public function __construct()
    {
        session_start();
        $this->check_login();
    }

    private function check_login()
    {
        if (isset($_SESSION['user_email'])) {
            $this->user_email = $_SESSION['user_email'];
            $this->user_firstname = $_SESSION['user_firstname'];
            if (isset($_SESSION['user_image'])) {
                $this->user_image = $_SESSION['user_image'];
            } else {
                $this->user_image = null;
            }
            $this->user_signed_in = true;
        } elseif (isset($_SESSION['organ_id'])) {
            $this->organ_id = $_SESSION['organ_id'];
            $this->organ_name = $_SESSION['organ_name'];
            $this->organ_image = $_SESSION['organ_image'];
            $this->organ_signed_in = true;
        } else {
            $this->logout();
        }
    }

    public function user_login($user)
    {
        if ($user) {
            $this->user_email = $user->email;
            $this->user_firstname = $user->firstname;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_firstname'] = $user->firstname;
            if ($user->image) {
                $this->user_image=$user->image;
                $_SESSION['user_image'] = $user->image;
            }
            $this->user_signed_in = true;
        }
    }

    public function organ_login($organization)
    {
        if ($organization) {
            $this->id = $organization->id;
            $this->name = $organization->name;
            $_SESSION['organ_id'] = $organization->id;
            $_SESSION['organ_name'] = $organization->name;
            if ($organization->image) {
                $this->organ_image=$organization->image;
                $_SESSION['organ_image'] = $organization->image;
            }
            $this->organ_signed_in = true;
        }
    }

    public function logout()
    {
        unset($_SESSION['user_firstname']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_image']);
        unset($_SESSION['organ_name']);
        unset($_SESSION['organ_id']);
        unset($_SESSION['organ_image']);
        unset($this->user_firstname);
        unset($this->user_email);
        unset($this->user_image);
        unset($this->organ_name);
        unset($this->organ_id);
        unset($this->organ_image);

        $this->organ_signed_in = false;
        $this->user_signed_in = false;
    }

    public function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

}

$session = new Session();

?>

