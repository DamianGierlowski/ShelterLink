<?php

namespace App\Model\Security;

use Symfony\Component\Validator\Constraints as Assert;

class LoginModel
{
    private string $email;
    #[Assert\NotBlank]
    private string $password;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): LoginModel
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): LoginModel
    {
        $this->password = $password;
        return $this;
    }

}
