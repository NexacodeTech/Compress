<?php
require_once './vendor/autoload.php';
use NexacodeTech\Compress\Compress;
use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;

$compress = Compress::make(CompressTypeEnum::PDF);
$compress->setQuality(QualityEnum::LOW);
$compress->compress('files/100mb.pdf', OutputTypeEnum::STREAM, 'files/100mb_compressed.pdf');
