<?php

namespace NexacodeTech\Compress;

use NexacodeTech\Compress\Enums\OutputTypeEnum;
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
            '-sOutputFile=' . $this->outputName,
            $this->file
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    public function compress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '')
    {
        $this->file = $file;
        $this->output = $output;
        $this->outputName = $outputName;

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
