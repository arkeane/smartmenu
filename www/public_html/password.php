
<?php
function isValidPassword($password)
{
    if (strlen($password) < 8) {
        return false;
    }
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/\d/', $password);
    if (!$hasUppercase || !$hasLowercase) {
        return false;
    }
    return true;
}
