<?php

declare(strict_types=1);

namespace BGPHP\BgProcessing\Command;

use League\Tactician\Bernard\QueueableCommand;

final class RegisterUser implements QueueableCommand
{
    private $emailAddress;
    private $password;

    public function __construct(string $emailAddress, string $password)
    {
        $this->emailAddress = $emailAddress;
        $this->password = $password;
    }

    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getName()
    {
        return 'RegisterUser';
    }
}
