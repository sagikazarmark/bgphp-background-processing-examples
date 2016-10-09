<?php

namespace BGPHP\BgProcessing\Handler;

use BGPHP\BgProcessing\Command\RegisterUser;

final class RegisterUserHandler
{
    public function handleRegisterUser(RegisterUser $command)
    {
        // Do your core application logic here. Don't actually echo things. :)
        echo "User {$command->getEmailAddress()} successfully registered!\n";
    }
}
