<?php
require_once './vendor/autoload.php';

use NexacodeTech\Compress\Compress;
use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;

$compress = Compress::make(CompressTypeEnum::PDF);

$compress->setQuality(QualityEnum::LOW);
$compress->compress('files/100mb.pdf', OutputTypeEnum::FILE, 'files/100mb_low.pdf');


$compress->setQuality(QualityEnum::MEDIUM);
$compress->compress('files/100mb.pdf', OutputTypeEnum::FILE, 'files/100mb_medium.pdf');


$compress->setQuality(QualityEnum::HIGH);
$compress->compress('files/100mb.pdf', OutputTypeEnum::FILE, 'files/100mb_high.pdf');


$compress->setQuality(QualityEnum::VERY_HIGH);
$compress->compress('files/100mb.pdf', OutputTypeEnum::FILE, 'files/100mb_very_high.pdf');

$compress->setQuality(QualityEnum::MAXIMUM);
$compress->compress('files/100mb.pdf', OutputTypeEnum::FILE, 'files/100mb_maximum.pdf');
