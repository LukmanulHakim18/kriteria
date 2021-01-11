<?php


namespace common\jobs;


use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

class LedProdiCompleteExportJob extends BaseObject implements JobInterface
{

    /**
     * @param Queue $queue
     * @return mixed|void
     */
    public function execute($queue)
    {
        // TODO: Implement execute() method.
    }
}
