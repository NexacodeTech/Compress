<?php

namespace NexacodeTech\Compress;

use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;

class CompressImage implements Interfaces\ICompress
{
    public function compress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '', $quality = QualityEnum::MEDIUM)
    {
        // TODO: Implement compress() method.
    }

    public function run(): string
    {
        // TODO: Implement run() method.
    }

    public function getOutput()
    {
        // TODO: Implement getOutput() method.
    }
}
