<?php


namespace common\models\forms\user;


use common\models\User;
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
    public function attributeLabels()
    {
        return [
            'oldPassword' => 'Password Lama',
            'newPassword' => 'Password Baru',
            'repeatPassword' => 'Konfirmasi Password Baru'
        ];
    }

    public function rules()
    {
        return [
            [['oldPassword','newPassword','repeatPassword'],'required'],
            ['repeatPassword','compare','compareAttribute' => 'newPassword','message' => "Password tidak sama."],
            ['oldPassword','findPassword','skipOnEmpty'=>false],

        ];
    }

    public function findPassword($attribute, $params)
    {

        if (!$this->hasErrors()) {
            $user = $this->_user;
            if (!$user || !$user->validatePassword($this->oldPassword)) {
                $this->addError($attribute,'Password lama tidak sesuai dengan database');
                return false;
            }

        }
        return true;


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