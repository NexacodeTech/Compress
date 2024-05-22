<?php
require_once './vendor/autoload.php';

use NexacodeTech\Compress\Compress;
use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;

$compress = Compress::make(CompressTypeEnum::IMAGE);

$compress->setQuality(QualityEnum::LOW);
$content = $compress->compress('files/panorama.jpg', OutputTypeEnum::FILE, 'files/compressed.jpg');
