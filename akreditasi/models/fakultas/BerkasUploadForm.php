<?php


namespace akreditasi\models\fakultas;


use Carbon\Carbon;
use common\models\Constants;
use Faker\Provider\File;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class BerkasUploadForm extends Model
{

    /**
     * @var UploadedFile[]
     */
    public $berkas;

    public function rules()
    {
        return [
            ['berkas','file','maxSize'=>Constants::MAX_UPLOAD_SIZE(),'extensions'=>Constants::ALLOWED_EXTENSIONS,'skipOnEmpty'=>false,'maxFiles'=>20]
        ];
    }

    /**
     * @param $path
     * @return array
     * returned array formated like this.
     * <code>
     * [
     *    [ 'isi_berkas'=>'',
     *      'bentuk_berkas'=>'',
     *    ]
     * ]
     *
     * </code>
     */
    public function upload($path){
        $now = Carbon::now()->timestamp;
        FileHelper::createDirectory($path);
        $files= [];
        foreach ($this->berkas as /** @var UploadedFile $file */ $file){
            $filename = "$now-{$file->baseName}.{$file->extension}";
            if($file->saveAs("$path/$filename")){
                $files[] = ['isi_berkas'=>$filename,'bentuk_berkas'=>$file->extension];
            }
        }

        return $files;
    }
}