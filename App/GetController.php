<?php 
namespace App;

use GdImage;
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

    /**
     * Welcome page
     *
     * @return string
     */
    static function welcome():string 
    {
        return view('welcome');
    }

    /**
     * Auth check 
     *
     * @return string
     */
    static function auth():string 
    {
        return view("auth");
    }

    /**
     * Logout 
     *
     * @return string
     */
    static function logout():string
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
                $_POST+$_FILES, [
                'name' => 'min:2|required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'avatar' => 'uploaded_file:0,500K,png,jpeg'
                ]
            );
            $validation->validate();

            if ($validation->fails()) {
                $data['validation']=$validation;
                $data['validationErrors']=$validation->errors();
                return view('register', $data);
            }
            $valid = $validation->getValidData();

            //upload action
            $avatarName=null;
            
            if ($valid['avatar']!==null) {
                switch ($valid['avatar']['type']) {
                case 'image/jpeg': 
                    $gd=imagecreatefromjpeg($valid['avatar']['tmp_name']);
                    $extension='jpg';
                    break;
                case 'image/png': 
                    $gd=imagecreatefrompng($valid['avatar']['tmp_name']);
                    $extension='png';
                    break;
                default:
                    $gd=null;
                    $extension=null;
                    break;
                }
                if ($gd && $extension!==null) {
                    //store as compressed jpeg
                    $avatarName=md5(microtime().rand()).'.jpg';
                    //make it avatar size
                    $gd=self::_imageResize($gd, 64, 64);
                    imagejpeg($gd, 'Avatars/'.$avatarName, 81);
                }
            }

            User::firstOrCreate(
                [
                'email' => $valid['email']
                ], [
                'name' => $valid['name'],
                'password' => md5($valid['password']),
                'avatar' => $avatarName
                ]
            );
            auth()->login($valid['email'], $valid['password']);
            return view('welcome');
        }
        return view('register', $data);
    }

    /**
     * Resize GD image
     *
     * @param GdImage $image  image
     * @param integer $width  width
     * @param integer $height height
     * 
     * @return GdImage
     */
    private static function _imageResize(
        GdImage $image, int $width, int $height
    ):GdImage {
        $oldWidth = imagesx($image);
        $oldHeight = imagesy($image);
        $temp = imagecreatetruecolor($width, $height);
        imagecopyresampled(
            $temp, $image, 0, 0, 0, 0, 
            $width, $height, 
            $oldWidth, $oldHeight
        );
        return $temp;
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
            } 
            $valid = $validation->getValidData();
            if (auth()->login($valid['email'], $valid['password'])) {
                return view('welcome');
            }
            $data['loginFail']=true;
            return view('login', $data);
        
        }
        return view('login', $data);
    }

    /**
     * User List
     *
     * @return string
     */
    static function users():string 
    {
        $data=User::all();
        $hash=md5(serialize($data));
        header('Etag: ' . $hash);

        //give the last modified date for polling caching
        $lastModifiedDate=User::select('updated_at')
            ->orderByDesc('updated_at')->pluck('updated_at')->first();
        if ($lastModifiedDate) {
            $lastModified=strtotime($lastModifiedDate);
            header(
                "Last-Modified: ".
                gmdate("D, d M Y H:i:s", $lastModified)." GMT"
            );
        }
        
        return view("users", ['data'=>$data]);
    }
}
