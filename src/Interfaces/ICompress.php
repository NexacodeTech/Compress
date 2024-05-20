<?php

namespace NexacodeTech\Compress\Interfaces;

use NexacodeTech\Compress\Enums\OutputTypeEnum;

interface ICompress
{
    public function compress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '');
    public function decompress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '');
}
