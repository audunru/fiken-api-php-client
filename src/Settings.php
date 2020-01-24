<?php

namespace audunru\FikenClient;

class Settings
{
    /**
     * The entry point for all Fiken API requests.
     *
     * @var string
     */
    public static $baseUri = 'https://fiken.no/api/v1/';

    /**
     * Fiken username.
     *
     * @var string
     */
    public static $username;

    /**
     * Fiken password.
     *
     * @var string
     */
    public static $password;

    /**
     * Sets the username used for requests.
     *
     * @param string $username
     */
    public static function setUsername($username)
    {
        self::$username = $username;
    }

    /**
     * Sets the password used for requests.
     *
     * @param string $password
     */
    public static function setPassword($password)
    {
        self::$password = $password;
    }
}
