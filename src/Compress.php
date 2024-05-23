<?php

namespace NexacodeTech\Compress;

use Exception;
use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;
use Symfony\Component\Process\Process;

class Compress
{


    protected CompressPDF $pdf;
    protected CompressImage $image;
    private QualityEnum $quality;

    public function __construct(public CompressTypeEnum $fileType)
    {
        $this->pdf = new CompressPDF();
        $this->image = new CompressImage();
        $this->checkDependencies();
    }

    /**
     * @throws Exception
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

    private function commandExists($command): bool
    {
        $process = new Process(['which', $command]);
        $process->run();

        if (!$process->isSuccessful()) {
            return false;
        }

        return !empty(trim($process->getOutput()));
    }

    /**
     * @throws Exception
     */
    private function checkDependencies(): void
    {
        if ($this->fileType == CompressTypeEnum::PDF) {
            if (!$this->commandExists('gs')) {
                throw new Exception('Ghostscript is required to compress PDF files');
            }
        }

        if ($this->fileType == CompressTypeEnum::IMAGE) {
            if (!$this->commandExists('convert')) {
                throw new Exception('ImageMagick is required to compress image files');
            }
        }
    }
}
