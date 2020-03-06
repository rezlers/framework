<?php


namespace App\Model;


use App\Model\Implementations\User;

interface AccessControlListInterface
{
    /**
     * @param UserInterface $user
     * @return bool
     */
    public static function isGranted(UserInterface $user): bool;

    /**
     * @return string[]
     */
    public static function getRoles(): array;

    /**
     * @param UserInterface $user
     * @param ResourceInterface $resource
     */
    public static function allow(UserInterface $user, ResourceInterface $resource): void;

    /**
     * @param UserInterface $user
     * @param ResourceInterface $resource
     */
    public static function deny(UserInterface $user, ResourceInterface $resource): void;


}