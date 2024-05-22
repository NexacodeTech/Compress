<?php

namespace NexacodeTech\Compress;

use Exception;
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
    private QualityEnum $quality;

    public function run(): string
    {

        $process = new Process([
            'gs',
            '-sDEVICE=pdfwrite',
            '-dCompatibilityLevel=1.4',
            '-dPDFSETTINGS=' . $this->getPDFSettings($this->quality),
            '-dNOPAUSE',
            '-dQUIET',
            '-dBATCH',
            '-dSAFER',
            '-dEmbedAllFonts=true',
            '-dSubsetFonts=true',
            '-dDetectDuplicateImages=true',
            '-dDownsampleColorImages=true',
            '-dColorImageResolution=' . $this->getImageDPI($this->quality), // Reduzindo a resolução das imagens coloridas para 72 DPI
            '-dDownsampleGrayImages=true',
            '-dGrayImageResolution=' . $this->getImageDPI($this->quality), // Reduzindo a resolução das imagens em escala de cinza para 72 DPI
            '-dDownsampleMonoImages=true',
            '-dMonoImageResolution=300',
            '-dOptimize=true',
            '-dCompressionQuality=80',
            '-sOutputFile=' . $this->outputName,
            $this->file
        ]);


        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    /**
     * @throws Exception
     */
    public function compress($file, OutputTypeEnum $output = OutputTypeEnum::STREAM, $outputName = '', $quality = QualityEnum::MEDIUM)
    {
        if (!$this->isValid($file)) {
            throw new Exception('Invalid PDF file');
        }
        $this->file = $file;
        $this->output = $output;
        $this->outputName = $outputName;
        $this->quality = $quality;

        return $this->getOutput();
    }


    public function getOutput()
    {
        $this->run();
        //ToDo: Implementar o metodo que obtem o STREAM em vez de salvar o arquivo.
        return match ($this->output) {
            OutputTypeEnum::STREAM => file_get_contents($this->outputName),
            OutputTypeEnum::FILE => $this->outputName,
        };
    }

    private function getPDFSettings(QualityEnum $quality): string
    {
        return match ($quality) {
            QualityEnum::LOW => '/screen',
            QualityEnum::MEDIUM => '/ebook',
            QualityEnum::HIGH => '/printer',
            QualityEnum::VERY_HIGH => '/prepress',
            QualityEnum::MAXIMUM => '/prepress'
        };
    }

    private function getImageDPI(QualityEnum $quality): string
    {
        return (string)match ($quality) {
            QualityEnum::LOW => 72,
            QualityEnum::MEDIUM => 150,
            QualityEnum::HIGH => 300,
            QualityEnum::VERY_HIGH => 600,
            QualityEnum::MAXIMUM => 1200
        };
    }

    public function isValid($filePath): bool
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return false;
        }

        $mimeType = mime_content_type($filePath);

        return $mimeType === 'application/pdf';
    }
}
