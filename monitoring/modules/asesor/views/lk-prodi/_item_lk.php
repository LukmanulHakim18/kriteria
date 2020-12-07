<?php
/**
 * @var $this yii\web\View
 * @var $untuk string
 * @var $modelAttribute
 * @var $modelNarasi
 * @var $item
 * @var $dokMO
 */

use common\models\Constants;

?>
<div class="lk-content">
    <div class="row">
        <div class="col-lg-12">


            <h5>Tabel <?= $item->tabel ?> <?= $item->nama ?></h5>
            <p><?= $item->petunjuk ?></p>

            <?= $modelNarasi->$modelAttribute ?>

            <?php if (!empty($item->keterangan)): ?>
                <h6>Keterangan</h6>
                <?= $item->keterangan ?>
            <?php endif; ?>


        </div>
    </div>


    <?= $this->render('_dokumen', [
        'lkProdi' => $lkProdi,
        'prodi' => $prodi,
        'item' => $item,
        'path' => $path,
        'dokUploadModel' => $dokUploadModel,
        'dokTextModel' => $dokTextModel,
        'dokLinkModel' => $dokLinkModel,
        'kriteria' => $kriteria,
        'jenis' => Constants::SUMBER,
        'lkCollection' => $lkCollection,
        'untuk' => $untuk
    ]) ?>
    <?= $this->render('_dokumen', [
        'lkProdi' => $lkProdi,
        'prodi' => $prodi,
        'item' => $item,
        'path' => $path,
        'dokUploadModel' => $dokUploadModel,
        'dokTextModel' => $dokTextModel,
        'dokLinkModel' => $dokLinkModel,
        'kriteria' => $kriteria,
        'jenis' => Constants::PENDUKUNG,
        'lkCollection' => $lkCollection,
        'untuk' => $untuk
    ]) ?>

    <!--                                Tabel dokumen lainnya-->
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th colspan="2" class="text-left">Dokumen Lainnya</th>
            <th>
            </th>
        </tr>
        </thead>
        <thead class="thead-dark">
        <tr>
            <th>No.</th>
            <th colspan="2">Dokumen</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $details = $lkCollection->where('jenis_dokumen', Constants::LAINNYA)->where('kode_dokumen',
            $item->tabel)->values()->all();

        if (!empty($details)) :
            foreach ($details as $k => $v) :?>
                <?= $this->render('_dokumen_item', [
                    'path' => $path,
                    'kriteria' => $kriteria,
                    'v' => $v,
                    'prodi' => $prodi,
                    'lkProdi' => $lkProdi,
                    'jenis' => Constants::LAINNYA,
                    'untuk' => $untuk
                ]) ?>
            <?php
            endforeach;
        else:
            echo '<tr><td>Tidak ada dokumen</td></tr>';
        endif ?>
        </tbody>
    </table>

</div>

