<?php


namespace common\models\forms\user;


use common\models\ProfilUser;
use common\models\User;
use InvalidArgumentException;
use Yii;
use yii\base\Model;
use yii\db\Exception;

class UpdateUserForm extends Model
{


    public $username;
    public $email;
    public $status;
    public $hak_akses;

    public $nama_lengkap;
    public $id_fakultas;
    public $id_prodi;


    /**
     * @var User
     */
    private $_user;

    /**
     * @var ProfilUser
     */
    private $_profilUser;

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'id_fakultas' => 'Fakultas',
            'id_prodi' => 'Prodi',
        ];
    }

    public function __construct($id, $config = [])
    {

        if (empty($id)) {
            throw new InvalidArgumentException('Id tidak boleh kosong');
        }
        $this->_user = User::findOne($id);
        if (!$this->_user) {
            throw new InvalidArgumentException('User tidak Ditemukan');
        }
        $this->_profilUser = $this->_user->profilUser;

        $this->setAttributes([
            'username' => $this->_user->username,
            'email' => $this->_user->email,
            'status' => $this->_user->status,
            'nama_lengkap' => $this->_profilUser->nama_lengkap,
            'id_prodi' => $this->_profilUser->id_prodi,
            'id_fakultas' => $this->_profilUser->id_fakultas,
        ], false);

        $auth = Yii::$app->getAuthManager();
        $r = array_keys($auth->getRolesByUser($this->_user->id));
        $akses = array_combine($r, $r);
        $this->hak_akses = $akses;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [

            [['username', 'email', 'status', 'hak_akses', 'nama_lengkap'], 'required'],
            [['username'],'unique','targetClass' => User::class, 'message' => '{attribute} "{value}" telah digunakan.'],
            [['email'],'unique','targetClass' => User::class,'message' => '{attribute} "{value}" telah digunakan.'],
            [['username', 'password', 'email', 'hak_akses', 'nama_lengkap'], 'string'],

            [['id_fakultas', 'id_prodi'], 'safe']
        ];
    }

    public function updateUser()
    {

        $user = $this->_user;
        $user->scenario = 'update';

        $profil = $this->_profilUser;

        $user->setAttributes(['username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,
        ], false);
        $profil->setAttributes(['nama_lengkap' => $this->nama_lengkap, 'id_fakultas' => $this->id_fakultas, 'id_prodi' => $this->id_prodi]);

        $transaction = \Yii::$app->db->beginTransaction();

        if (!$user->save()) {
            $transaction->rollBack();
            return false;
        }
        $profil->id_user = $user->id;
        if (!$profil->save()) {
            $transaction->rollBack();
            return false;
        }

        try {
            $auth = Yii::$app->getAuthManager();
            $r = array_values($auth->getRolesByUser($user->id));
            foreach ($r as $role) {
                $auth->revoke($role, $user->id);

            }
            $role = $auth->getRole($this->hak_akses);

            try {
                $auth->assign($role, $user->id);
            } catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();

        } catch (Exception $e) {
            var_dump($e->getMessage());
        }


        return $user;
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function getProfilUser()
    {
        return $this->_profilUser;
    }
}