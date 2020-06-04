<?php
/**
 * @var $profil Profil
 */

use common\models\Profil;

?>

<div class="table-responsive">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Isi</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Visi</td>
                <td><?=$profil->visi?></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Misi</td>
                <td><?=$profil->misi?></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Tujuan</td>
                <td><?=$profil->tujuan?></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Sasaran</td>
                <td><?=$profil->sasaran?></td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Motto</td>
                <td><?=$profil->motto?></td>
                <td></td>
            </tr>
            <tr>
                <td>6</td>
                <td>Sambutan</td>
                <td><?=$profil->sambutan?></td>
                <td></td>
            </tr>
            <tr>
                <td>7</td>
                <td>Struktur Organisasi</td>
                <td><?=$profil->struktur_organisasi?></td>
                <td></td>
            </tr>

        </tbody>
    </table>
</div>
