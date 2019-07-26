<?php


namespace common\models\forms\user;


use InvalidArgumentException;
use yii\base\Model;

class UserPasswordForm extends Model
{

    public $oldPassword;
    public $newPassword;
    public $repeatPassword;

    private $_user;


    /**
     * @return array
     */
    public function attributeLabels() :array
    {
        return [
            'oldPassword' => 'Password Lama',
            'newPassword' => 'Password Baru',
            'repeatPassword' => 'Konfirmasi Password Baru'
        ];
    }

    public function rules() :array
    {
        return [
            [['oldPassword','newPassword','repeatPassword'],'required'],
            ['oldPassword','findPassword'],
            ['repeatPassword','compare','compareAttribute' => 'newPassword'],
        ];
    }

    public function findPassword($attribute, $params): void
    {

        $password = $this->_user->password_hash;
        if($password !== $this->oldPassword){
            $this->addError($attribute,'Password lama tidak sesuai dengan database');
        }
    }
    public function __construct($id, $config = [])
    {

        if (empty($id)) {
            throw new InvalidArgumentException('User tidak ditemukan');
        }

        $this->_user = User::findOne($id);
        if (!$this->_user) {
            throw new InvalidArgumentException('User yang dicari tidak ada');
        }

        parent::__construct($config);
    }

    public function updatePassword()
    {

        $user = $this->_user;
        $user->setPassword($this->newPassword);

        return $user->save()? $user: null;


    }

}