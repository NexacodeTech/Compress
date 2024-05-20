<?php

namespace NexacodeTech\Compress;

use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;

class CompressImage implements Interfaces\ICompress
{

    public function compress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '', $quality = QualityEnum::MEDIUM)
    {
        return 'b';
    }

    public function decompress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '')
    {
        // TODO: Implement decompress() method.
    }
}
