<?php


namespace common\models\forms\user;


use InvalidArgumentException;
use Yii;
use yii\base\Model;
use yii\bootstrap\ActiveForm;
use yii\db\Exception;

class CreateUserForm extends Model
{

    public $username;
    public $password;
    public $email;
    public $status;
    public $is_admin;
    public $is_institusi;
    public $is_fakultas;
    public $is_prodi;

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
            'username' => 'Username (Nip/Nik)',
            'is_admin' => 'Akses Admin',
            'is_institusi' => 'Akses Institusi',
            'is_fakultas' => 'Akses Fakultas',
            'is_prodi' => 'Akses Prodi',
            'id_fakultas' => 'Fakultas',
            'id_prodi' => 'Prodi',
        ];
    }

    public function rules(): array
    {
        return [

            [['username', 'password', 'email', 'status', 'is_admin', 'is_institusi', 'is_fakultas', 'is_prodi', 'nama_lengkap',], 'required'],
            [['id_fakultas', 'id_prodi'], 'safe']
        ];
    }

    public function addUser()
    {
        $user = new User();
        $user->scenario = 'create';

        $profil = new ProfilUser();

        $user->setAttributes(['username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,
            'is_admin' => $this->is_admin,
            'is_institusi' => $this->is_institusi,
            'is_fakultas' => $this->is_fakultas,
            'is_prodi' => $this->is_prodi], false);
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $profil->setAttributes(['nama_lengkap' => $this->nama_lengkap,
            'id_fakultas' => $this->id_fakultas, 'id_prodi' => $this->id_prodi], false);


        $transaction = Yii::$app->db->beginTransaction();

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
            $transaction->commit();

            $auth = Yii::$app->getAuthManager();

            if ($user->is_admin) {
                if ($user->is_prodi && $user->is_fakultas && $user->is_institusi){
                    $role = $auth->getRole('adminLpm');
                    $auth->assign($role, $user->id);
                }
                elseif ($user->is_institusi) {
                    $role = $auth->getRole('adminInstitusi');
                    $auth->assign($role, $user->id);
                } elseif ($user->is_fakultas) {
                    $role = $auth->getRole('adminFakultas');
                    $auth->assign($role, $user->id);
                } elseif ($user->is_prodi) {
                    $role = $auth->getRole('adminProdi');
                    $auth->assign($role, $user->id);
                }

            } else {
                if ($user->is_institusi) {
                    $role = $auth->getRole('userInstitusi');
                    $auth->assign($role, $user->id);
                } elseif ($user->is_fakultas) {
                    $role = $auth->getRole('userFakultas');
                    $auth->assign($role, $user->id);
                } elseif ($user->is_prodi != null) {
                    $role = $auth->getRole('userProdi');
                    $auth->assign($role, $user->id);
                }
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

        return $user;
    }

}