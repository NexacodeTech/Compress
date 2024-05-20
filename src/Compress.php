<?php

namespace NexacodeTech\Compress;

use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;

class Compress
{


    protected CompressPDF $pdf;
    protected CompressImage $image;

    public function __construct(public CompressTypeEnum $fileType)
    {
        $this->pdf = new CompressPDF();
        $this->image = new CompressImage();
    }

    public function compress(string $file, OutputTypeEnum $outputType, $outputName = ''): string
    {
        return match ($this->fileType) {
            CompressTypeEnum::PDF => $this->pdf->compress($file, $outputType, $outputName),
            CompressTypeEnum::IMAGE => $this->image->compress($file, $outputType, $outputName),
        };
    }

    public static function make(CompressTypeEnum $fileType): self
    {
        return new self($fileType);
    }


}
