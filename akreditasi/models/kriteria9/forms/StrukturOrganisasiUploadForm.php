<?php


namespace akreditasi\models\kriteria9\forms;


use Carbon\Carbon;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class StrukturOrganisasiUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $struktur;

    public function rules()
    {
        return [
            [['struktur'], 'file', 'skipOnEmpty' => true],
        ];
    }

    public function upload($jenis,$id)
    {
        if (!$this->validate()) {
            return false;
        }
        $path = \Yii::getAlias("@uploadStruktur/$jenis/$id");
        FileHelper::createDirectory($path);
        $timestamp = Carbon::now()->timestamp;
        $filename = $timestamp . '-'. $this->struktur->baseName . '.' . $this->struktur->extension;

            return $this->struktur->saveAs($path.'/' . $filename)?$filename: false;
    }
}