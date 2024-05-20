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
            '-dEmbedAllFonts=true', // Garantindo que todas as fontes sejam incorporadas
            '-dSubsetFonts=true', // Subconjunto de fontes para reduzir o tamanho do arquivo
            '-dDetectDuplicateImages=true', // Detectar e remover imagens duplicadas
            '-dDownsampleColorImages=true',
            '-dColorImageResolution=' . $this->getImageDPI($this->quality), // Reduzindo a resolução das imagens coloridas para 72 DPI
            '-dDownsampleGrayImages=true',
            '-dGrayImageResolution=' . $this->getImageDPI($this->quality), // Reduzindo a resolução das imagens em escala de cinza para 72 DPI
            '-dDownsampleMonoImages=true',
            '-dMonoImageResolution=300', // Mantendo a resolução das imagens monocromáticas em 300 DPI
            '-dOptimize=true',
            '-dCompressionQuality=80', // Ajustando a qualidade de compressão para 80
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
        $this->quality = $quality;

        return $this->getOutput();
    }


    public function getOutput()
    {
        $this->run();
        //ToDo: Implementar o metodo que obtem o STREAM em vez de salvar o arquivo.
        return match ($this->output) {
            OutputTypeEnum::STREAM, OutputTypeEnum::FILE => $this->outputName,
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
}
