<?php


namespace common\jobs;


use common\models\kriteria9\lk\prodi\K9LkProdi;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class KuantitatifProdiExportJob extends BaseObject implements JobInterface
{


    /** @var K9LkProdi */
    public $lk;
    public $template;


    public function execute($queue)
    {

    }

}
