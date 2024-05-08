<?php 
namespace App;
use App\User;
class Auth
{
    /**
     * User as variable
     */
    static User $user;

    /**
     * Checks if user has auth
     *
     * @return boolean
     */
    public static function check():bool 
    {
        @session_start();
        // search in session 
        if (isset($_SESSION['userId'])) {
            //gather the user
            $user=User::find(intval($_SESSION['userId']));
            if ($user) {
                self::$user=$user;
                return true;
            }
        }
        return false;
    }


    /**
     * Gives auth user
     *
     * @return object|null
     */
    public static function user() :User|null 
    {
        // try to get auth data
        if (self::$user===null) {
            self::check();
        }
        return self::$user;
    }

    /**
     * Login user
     *
     * @param string $email    email 
     * @param string $password password
     * 
     * @return User|null
     */
    public static function login(string $email, string $password):User|null
    {
        $user=User::where('email', $email)->first();
        if ($user && $user->password===md5($password)) {
            @session_start();
            $_SESSION['userId']=$user->id;
            return $user;
        }
        return null;
    }

    /**
     * Logs out
     *
     * @return void
     */
    public static function logout() 
    {
        @session_start();
        $_SESSION['userId']=null;
    }
}