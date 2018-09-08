<?php
namespace app\models;

use Yii;
use app\models\User;



/**
Signup form
 */
class SignupForm extends Model
{
	public $username;
	public $email;
	public $password;
	public $nombre;
	public $temp;
	public $che;
	public $id_sucursal;


	/**
	* @inheritdoc
		     */
		    public function rules()
		    {
		return [
				            ['username', 'trim'],
				            ['username', 'required'],
				            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Este nombre de usuario ya existe.'],
				            ['username', 'string', 'min' => 2, 'max' => 255],

		['email', 'trim'],
				            ['email', 'required'],
				            ['email', 'email'],
				            ['email', 'string', 'max' => 255],
				            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Este email ya existe.'],

		['password', 'required'],
				            ['password', 'string', 'min' => 6],
		        ['nombre','required'],
		        ['nombre','string'],
		        ];
	}

	/**
	* Signs user up.
		     *
		     * @return User|null the saved model or null if saving fails
		     */
	public function signup()
	{
		if (!$this->validate()) {
			return null;
		}

		$user = new User();
		$user->username = $this->username;
		$user->nombre = $this->nombre;
		$user->email = $this->email;
		$user->temp = $this->temp;
		$user->id_sucursal = $this->id_sucursal;
		$user->setPassword($this->password);
		$user->generateAuthKey();

		return $user->save() ? $user : null;
	}
}
