<?php
/**
 * @var $this yii\web\View
 * @var $lkCollection yii2mod\collection\Collection
 * @var $jenis string
 * @var $item common\models\kriteria9\lk\TabelLk
 */

$jenisUc = \yii\helpers\StringHelper::mb_ucfirst($jenis);
$attr = 'dokumen_' . $jenis;
?>


<!--                            Tabel dokumen sumber-->
<table class="table">
    <thead class="thead-light">
    <tr>
        <th colspan="3" class="text-center">Dokumen <?= $jenisUc ?></th>
    </tr>
    </thead>
    <thead class="thead-dark">
    <tr>
        <th>Kode</th>
        <th colspan="2">Dokumen</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($item->$attr as $keyDoksum => $doksum) :

    $clear = trim($doksum->kode);
    $kodeSumber = '_' . str_replace('.', '_', $clear);

    if (!empty($doksum->kode)) : ?>

        <tr>
            <th scope="row"><?= $doksum->kode ?></th>
            <td>
                <p style="font-size: 14px;font-weight: 400"><?= $doksum->dokumen ?></p>
            </td>
            <td class="pull-right">
            </td>
        </tr>


    <?php else :
        echo '<tr><td>Tidak ada dokumen</td></tr>';
    endif; ?>
    <?php


    $details = $lkCollection->where('kode_dokumen', $doksum->kode)->where('jenis_dokumen', $jenis)->values()->all();
    foreach ($details as $k => $v) : ?>

        <?= $this->render('_dokumen_item', [
            'path' => $path,
            'kriteria' => $kriteria,
            'v' => $v,
            'prodi' => $prodi,
            'lkProdi' => $lkProdi,
            'jenis' => $jenis,
            'untuk' => $untuk
        ]) ?>

    <?php
    endforeach;
    ?>

    </tbody>
    <?php endforeach; ?>
</table>
