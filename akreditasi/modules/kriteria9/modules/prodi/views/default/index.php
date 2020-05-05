<?php

/* @var $modelProdi ProgramStudi */

use common\models\ProgramStudi;
use yii\bootstrap4\Html;

$this->title = $modelProdi->nama;


?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Profil Program Studi
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">

                    <?= Html::a('<i class=flaticon2-edit></i> Edit Profil', ['profil/index', 'prodi' => Yii::$app->request->get('prodi')], ['class' => 'btn btn-info btn-elevate btn-elevate-air']); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <table class="table table-striped">

                <tbody>
                <tr>
                    <th scope="row">Kode</th>
                    <td><?= Html::encode($modelProdi->kode) ?></td>
                </tr>
                <tr>
                    <th scope="row">KAPRODI</th>
                    <td><?= Html::encode($modelProdi->kaprodi) ?></td>
                </tr>
                <tr>
                    <th scope="row">Jenjang</th>
                    <td><?= Html::encode($modelProdi->jenjang) ?></td>
                </tr>
                <tr>
                    <th scope="row">Fakultas</th>
                    <td><?= Html::encode($modelProdi->fakultasAkademi->nama) ?></td>
                </tr>
                <tr>
                    <th scope="row">Nomor SK Pendirian</th>
                    <td><?= Html::encode($modelProdi->nomor_sk_pendirian) ?></td>
                </tr>
                <tr>
                    <th scope="row">Tanggal SK Pendirian</th>
                    <td><?= Html::encode($modelProdi->tanggal_sk_pendirian) ?></td>
                </tr>
                <tr>
                    <th scope="row">Bulan berdiri</th>
                    <td><?= Html::encode($modelProdi->bulan_berdiri) ?></td>
                </tr>
                <tr>
                    <th scope="row">Tahun berdiri</th>
                    <td><?= Html::encode($modelProdi->tahun_berdiri) ?></td>
                </tr>
                <tr>
                    <th scope="row">Nomor SK Operasional</th>
                    <td><?= Html::encode($modelProdi->nomor_sk_operasional) ?></td>
                </tr>
                <tr>
                    <th scope="row">Tanggal SK Operasional</th>
                    <td><?= Html::encode($modelProdi->tanggal_sk_operasional) ?></td>
                </tr>
                <tr>
                    <th scope="row">Peringkat BAN-PT Terakhir</th>
                    <td><?= Html::encode($modelProdi->peringkat_banpt_terakhir) ?></td>
                </tr>
                <tr>
                    <th scope="row">Nilai BAN-PT Terakhir</th>
                    <td><?= Html::encode($modelProdi->nilai_banpt_terakhir) ?></td>
                </tr>
                <tr>
                    <th scope="row">Nomor SK BAN-PT</th>
                    <td><?= Html::encode($modelProdi->nomor_sk_banpt) ?></td>
                </tr>
                <tr>
                    <th scope="row">Alamat</th>
                    <td><?= Html::encode($modelProdi->alamat) ?></td>
                </tr>
                <tr>
                    <th scope="row">Kode Pos</th>
                    <td><?= Html::encode($modelProdi->kodepos) ?></td>
                </tr>
                <tr>
                    <th scope="row">Nomor Telpon</th>
                    <td><?= Html::encode($modelProdi->nomor_telp) ?></td>
                </tr>
                <tr>
                    <th scope="row">Homepage</th>
                    <td><?= Html::encode($modelProdi->homepage) ?></td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td><?= Html::encode($modelProdi->email) ?></td>
                </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>
