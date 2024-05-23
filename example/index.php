<?php
require_once './vendor/autoload.php';

use NexacodeTech\Compress\Compress;
use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;

$compressImage = Compress::make(CompressTypeEnum::IMAGE);

$compressImage->setQuality(QualityEnum::LOW);
$content = $compressImage->compress('files/panorama.jpg', OutputTypeEnum::FILE, 'files/compressed.jpg');


$compressPdf = Compress::make(CompressTypeEnum::PDF);

$compressPdf->setQuality(QualityEnum::LOW);
$content = $compressPdf->compress('files/100mb.pdf', OutputTypeEnum::FILE, 'files/compressed.pdf');
