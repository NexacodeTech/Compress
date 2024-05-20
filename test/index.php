<?php
require_once './vendor/autoload.php';

use NexacodeTech\Compress\Compress;
use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;

$compress = Compress::make(CompressTypeEnum::PDF);

$compress->setQuality(QualityEnum::LOW);
$compress->compress('files/100mb.pdf', OutputTypeEnum::FILE, 'files/100mb_0.pdf');


$compress->compress('files/100mb_0.pdf', OutputTypeEnum::FILE, 'files/100mb_1.pdf');


$compress->compress('files/100mb_1.pdf', OutputTypeEnum::FILE, 'files/100mb_2.pdf');


$compress->compress('files/100mb_2.pdf', OutputTypeEnum::FILE, 'files/100mb_3.pdf');

$compress->compress('files/100mb_3.pdf', OutputTypeEnum::FILE, 'files/100mb_4.pdf');
