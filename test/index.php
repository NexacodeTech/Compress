<?php
use NexacodeTech\Compress\Compress;
use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;

$compress = Compress::make(CompressTypeEnum::PDF);


$compress->compress('files/100mb.pdf', OutputTypeEnum::STREAM, 'files/100mb_compressed.pdf');
