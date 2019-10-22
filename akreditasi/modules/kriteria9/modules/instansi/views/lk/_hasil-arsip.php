<?php

/**
 * @var $lk K9LkInstitusi
 * @var $url array
 */

use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use yii\bootstrap4\Html;

?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Hasil Pencarian
                <h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <?php if (!$lk) : echo "Tidak ada Data"; else: ?>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Akreditasi</th>
                        <th>Tahun</th>
                        <th>Lembaga</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>1</td>
                        <td><?= $lk->akreditasiInstitusi->akreditasi->nama ?></td>
                        <td><?= $lk->akreditasiInstitusi->akreditasi->tahun ?></td>
                        <td><?= $lk->akreditasiInstitusi->akreditasi->lembaga ?></td>
                        <td><?= Html::a('<i class="la la-folder"></i> Lihat', $url, ['class' => ['btn btn-default btn-pill btn-elevate btn-elevate-air']]) ?></td>
                    </tr>

                    </tbody>
                </table>

            <?php endif; ?>

        </div>
    </div>

    <!--end::Form-->
</div>

