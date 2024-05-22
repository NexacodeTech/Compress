<?php

namespace NexacodeTech\Compress;

use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CompressImage implements Interfaces\ICompress
{
    private $file;
    private OutputTypeEnum $output;
    /**
     * @var mixed|string
     */
    private mixed $outputName;
    private QualityEnum $quality;


    public function compress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '', $quality = QualityEnum::MEDIUM)
    {
        $this->file = $file;
        $this->output = $output;
        $this->outputName = $outputName;
        $this->quality = $quality;

        return $this->getOutput();
    }

    public function run(): string
    {
        $proccess = new Process([
            'convert',
            $this->file,
            '-quality',
            $this->getQuality($this->quality) . "%",
            $this->outputName
        ]);

        $proccess->run();

        if (!$proccess->isSuccessful()) {
            throw new ProcessFailedException($proccess);
        }

        return $proccess->getOutput();
    }

    public function getOutput()
    {
        $this->run();
        return match ($this->output) {
            OutputTypeEnum::STREAM => file_get_contents($this->outputName),
            OutputTypeEnum::FILE => $this->outputName,
        };
    }

    private function getQuality(QualityEnum $quality): int
    {
        return match ($quality) {
            QualityEnum::LOW => 20,
            QualityEnum::MEDIUM => 40,
            QualityEnum::HIGH => 60,
            QualityEnum::VERY_HIGH => 80,
            QualityEnum::MAXIMUM => 100,
            default => 50,
        };
    }
}
