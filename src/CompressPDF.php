<?php

namespace NexacodeTech\Compress;

use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;
use NexacodeTech\Compress\Interfaces\ICompress;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CompressPDF implements ICompress
{

    private $file;
    private OutputTypeEnum $output;
    /**
     * @var mixed|string
     */
    private mixed $outputName;
    private int $quality;

    private function run(): string
    {

        $process = new Process([
            'gs',
            '-sDEVICE=pdfwrite',
            '-dCompatibilityLevel=1.4',
            '-dPDFSETTINGS=/screen',
            '-dNOPAUSE',
            '-dQUIET',
            '-dBATCH',
            '-dSAFER',
            '-dEncodeColorImages=false',
            '-dEncodeGrayImages=false',
            '-dAutoFilterColorImages=false',
            '-dColorImageFilter=/FlateEncode',
            '-dAutoFilterGrayImages=false',
            '-dGrayImageFilter=/FlateEncode',
            '-dDownsampleColorImages=true',
            '-dDownsampleGrayImages=true',
            '-dDownsampleMonoImages=true',
            '-dColorImageResolution=300',
            '-dGrayImageResolution=300',
            '-dMonoImageResolution=600',
            '-dColorImageDownsampleThreshold=1.0',
            '-dGrayImageDownsampleThreshold=1.0',
            '-dMonoImageDownsampleThreshold=1.0',
            '-dColorImageDownsampleType=/Bicubic',
            '-dGrayImageDownsampleType=/Bicubic',
            '-dMonoImageDownsampleType=/Bicubic',
            '-dOptimize=true',
            '-dCompressionQuality=' . $this->quality,
            '-sOutputFile=' . $this->outputName,
            $this->file
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    public function compress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '', $quality = QualityEnum::MEDIUM)
    {
        $this->file = $file;
        $this->output = $output;
        $this->outputName = $outputName;
        $this->quality = $quality->value;

        return $this->getOutput();
    }

    public function decompress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '')
    {

    }

    private function getOutput()
    {
        return match ($this->output) {
            OutputTypeEnum::STREAM => $this->run(),
            OutputTypeEnum::FILE => $this->outputName
        };
    }
}
