<?php


namespace akreditasi\models;


use Carbon\Carbon;
use yii\base\Model;
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
            [['struktur'], 'file', 'skipOnEmpty' => false],
        ];
    }

    public function upload($jenis,$id)
    {
        if (!$this->validate()) {
            return false;
        }
            $timestamp = Carbon::now()->timestamp;
            $filename = $timestamp . '-'. $this->struktur->baseName . '.' . $this->struktur->extension;
            $path = \Yii::getAlias("@uploadStruktur/$jenis/$id");

            return $this->struktur->saveAs($path.'/' . $filename);
    }
}