<?php

namespace NexacodeTech\Compress;

use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;

class Compress
{


    protected CompressPDF $pdf;
    protected CompressImage $image;
    private QualityEnum $quality;

    public function __construct(public CompressTypeEnum $fileType)
    {
        $this->pdf = new CompressPDF();
        $this->image = new CompressImage();
    }

    /**
     * @throws \Exception
     */
    public function compress(string $file, OutputTypeEnum $outputType, $output = ''): string
    {
        return match ($this->fileType) {
            CompressTypeEnum::PDF => $this->pdf->compress($file, $outputType, $output, $this->quality),
            CompressTypeEnum::IMAGE => $this->image->compress($file, $outputType, $output, $this->quality),
        };
    }

    public static function make(CompressTypeEnum $fileType): self
    {
        return new self($fileType);
    }

    public function setQuality(QualityEnum $quality): static
    {
        $this->quality = $quality;
        return $this;
    }
}
