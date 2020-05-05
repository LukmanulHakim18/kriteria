<?php
/**
 * Project: mutu-v2.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 8/21/2019
 * Time: 10:50 AM
 */

namespace common\models;

class Constants
{

    const JENJANG = [
      'S1'=> 'S1', 'S2'=>'S2'
    ];

    const JENIS_AKREDITASI =[
        'prodi'=>'Program Studi',
        'institusi'=> 'Perguruan Tinggi'
    ];

    const STANDAR7 = '7standar';
    const KRITERIA9 = '9kriteria';

    const SUMBER = 'sumber';
    const PENDUKUNG = 'pendukung';
    const LAINNYA = 'lainnya';
    const TEMPLATE = 'template';

    const LINK = 'link';
    const TEXT = 'text';

    const BORANG = [
        self::STANDAR7 => '7 Standar',
        self::KRITERIA9 => '9 Kriteria'
    ];

    const PRODI = 'prodi';
    const INSTITUSI = 'institusi';
    const FAKULTAS = 'fakultas';

    const ALLOWED_EXTENSIONS = ['jpg','jpeg','png','pdf','docx','doc','gif','ppt','pptx','xls','xlsx', 'zip','txt','csv','odt','ods'];
    const MAX_UPLOAD_SIZE = 30000*1024;
    const IMAGE_EXTENSIONS = ['jpg','jpeg','png','gif','bmp','tiff'];
}