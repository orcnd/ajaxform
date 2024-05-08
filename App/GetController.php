<?php 
namespace App;

use Rakit\Validation;
use Rakit\Validation\Validator;

class GetController
{
    /**
     * Init the class
     *
     * @param string $address address
     * 
     * @return string
     */
    public static function init(string $address):string
    {
        // check route exists
        if (method_exists(__CLASS__, $address)===false) {
            $address='home';
        }
        return self::$address();
    }

    /**
     * Home controller
     *
     * @return string
     */
    static function home():string
    {
        return view('home');
    }


    static function welcome():string 
    {
        return view('welcome');
    }
    static function auth():string 
    {
        if (auth()::check()) {
            return 'welcome ' . auth()::user()->name 
                . ' - <a href="#" hx-get="?page=logout" hx-target="#container"> logout</a>'
            ;
        }
        return 'you need to <a href="#" hx-get="?page=register" hx-target="#container">register</a>
         or <a href="#" hx-target="#container" hx-get="?page=login">login</a>';
    }

    static function logout() 
    {
        auth()::logout();
        return self::auth();
    }

    /**
     * Register Page
     *
     * @return string
     */
    static function register():string 
    {
        $data=[];
        
        if (isset($_POST['register'])) {
            $validator= new Validator;
            $validation= $validator->make(
                $_POST, [
                'name' => 'min:2|required',
                'email' => 'required|email',
                'password' => 'required|min:6'
                ]
            );
            $validation->validate();

            if ($validation->fails()) {
                $data['validation']=$validation;
                $data['validationErrors']=$validation->errors();
                return view('register', $data);
            } else {
                User::firstOrCreate(
                    [
                    'email' => $_POST['email']
                    ], [
                    'name' => $_POST['name'],
                    'password' => md5($_POST['password'])
                    ]
                );
                auth()->login($_POST['email'], $_POST['password']);
                return view('welcome');
            }
        }
        return view('register', $data);
    }

    /**
     * Login page
     *
     * @return string
     */    
    static function login():string 
    {
        $data=[];
        if (isset($_POST['login'])) {
            $validator= new Validator;
            $validation= $validator->make(
                $_POST, [
                'email' => 'required|email',
                'password' => 'required|min:6'
                ]
            );
            $validation->validate();

            if ($validation->fails()) {
                $data['validation']=$validation;
                $data['validationErrors']=$validation->errors();
                return view('login', $data);
            } else {
                if (auth()->login($_POST['email'], $_POST['password'])) {
                    return view('welcome');
                }
                $data['loginFail']=true;
                return view('login', $data);
            }
        }
        return view('login', $data);
    }
}