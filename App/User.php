<?php 
namespace App;

/**
 * User object
 */
class User extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable =['email' , 'name', 'password'];
}