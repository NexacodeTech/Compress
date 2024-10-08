<?php

namespace NexacodeTech\Compress\Interfaces;

use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;

interface ICompress
{
    public function compress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '', $quality = QualityEnum::MEDIUM);

    public function run(): string;

    public function getOutput();

    public function isValid($filePath): bool;
}
