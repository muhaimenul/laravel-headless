<?php
/**
 * Created by Muhaimenul Islam.
 * User: muhaimenul
 * Date: 7/10/21
 * Time: 12:30 AM
 */


namespace App\Services;


use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Muhaimenul\Laracrud\Services\CrudGenerator;

class UserService extends Service
{
    public function setModel()
    {
        $this->model = new User();
    }

    /**
     * @param array $data
     * @return User
     */
    public function createUser(array $data)
    {

        // hash password before create
        if(isset($data['password'])) $data['password'] = Hash::make($data['password']);

        return $this->create($data);

    }

    /**
     * @param User $user
     * @return string
     */
    public function createToken(User $user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }


}
