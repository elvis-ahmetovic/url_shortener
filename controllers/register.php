<?php
require('../config/init.php');

if(isset($_POST['register']))
{
    $user = new User; // User object
    
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $rePassword = filter_input(INPUT_POST, 're-password', FILTER_SANITIZE_STRING);

    // Check if email are empty
    if(empty($email))
    {
        // Error message
        $message = "Email is required";
        header('Location: ../register.php?error=' . $message);
        exit();
    }

    // Check if password are empty
    elseif(empty($password))
    {
        // Error message
        $message = "Password is required";
        header('Location: ../register.php?error=' . $message);
        exit();
    }

    // Check if password are empty
    elseif(empty($rePassword))
    {
        // Error message
        $message = "Repeat password is required";
        header('Location: ../register.php?error=' . $message);
        exit();
    }

    //check if passwords match up
    if(Validation::passwordMatch($password, $rePassword))
    {
        // Error message
        $message = "Passwords do not match";
        header('Location: ../register.php?error=' . $message);
        exit();
    }

    /* Check if email is valid */
    if(Validation::validEmail($email))
    {
        // Error message
        $message = "Enter valid email";
        header('Location: ../register.php?error=' . $message);
        exit();
    }

    // Check if email already exists in database
    if(Validation::emailExists($email))
    {
        // Error message
        $message = "This email is already in use";
        header('Location: ../register.php?error=' . $message);
        exit();
    }
    else
    {
        // set email
        $user->setEmail($email);
    }

    // Check min length of password
    if(Validation::minLength($password))
    {
        // Error message
        $message = "Password minimum length is 6 characters";
        header('Location: ../register.php?error=' . $message);
        exit();
    }
    else
    {
        // set password
        $user->setPassword($password);
    }
    
    
    try
    {
        // If user succassfully registered
        if($user->register())
        {
            // Redirect to login page with success message
            $message = "You are succassefully registered! Now you can sign in.";
            header('Location: ../login.php?success=' . $message);
        } 
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
}
