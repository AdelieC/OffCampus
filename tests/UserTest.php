<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private array $trueUserFields = array(
        'email'=>'true@test.com',
        'userName'=>'Username1',
        'password'=>'Pa$$w0rd',
        'birthDate'=>'1990-07-11',
        'firstName'=>'Firstname',
        'lastName'=>'Last-name',
        'telephone'=>null
    );
    private array $falseUserFields = array(
        'email'=>null,
        'userName'=>180,
        'password'=>0,
        'birthDate'=>0,
        'firstName'=>15,
        'lastName'=>0,
        'telephone'=>'azeretyuijdfcvghbjrfghdfhghjkkdfcghbjjkcfghbjjkedfrghbhjjkedfrghjjk'
    );

    /**
     * @throws \Exception
     */
    public function testIsTrue(): void
    {
        $user = new User();
        $user
            ->setEmail($this->trueUserFields['email'])
            ->setUserName($this->trueUserFields['userName'])
            ->setPassword($this->trueUserFields['password'])
            ->setBirthDate(new \DateTime($this->trueUserFields['birthDate']))
            ->setFirstName($this->trueUserFields['firstName'])
            ->setLastName($this->trueUserFields['lastName'])
            ->setTelephone($this->trueUserFields['telephone']);

        $this->assertEquals($user->getEmail(), $this->trueUserFields['email']);
        $this->assertEquals($user->getUsername(), $this->trueUserFields['userName']);
        $this->assertEquals($user->getPassword(), $this->trueUserFields['password']);
        $this->assertEquals($user->getBirthDate(), new \DateTime($this->trueUserFields['birthDate']));
        $this->assertEquals($user->getFirstName(), $this->trueUserFields['firstName']);
        $this->assertEquals($user->getLastName(), $this->trueUserFields['lastName']);
        $this->assertEquals($user->getTelephone(), $this->trueUserFields['telephone']);
    }
    public function testIsFalse(): void
    {

    }

    /**
     * @throws \Exception
     */
    public function testIsEmpty(): void
    {

    }
}
