<?php

namespace NexacodeTech\Compress;

use NexacodeTech\Compress\Enums\OutputTypeEnum;

class CompressImage implements Interfaces\ICompress
{

    public function compress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '')
    {
        return 'b';
    }

    public function decompress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '')
    {
        // TODO: Implement decompress() method.
    }
}
