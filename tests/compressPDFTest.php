<?php

use PHPUnit\Framework\TestCase;
use NexacodeTech\Compress\Compress;
use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;

class compressPDFTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testPDFCompression()
    {
        $inputFile = "tests/files/20mb.pdf";
        $outputFile = 'tests/files/20mb_compressed.pdf';

        $this->assertFileExists($inputFile, "O arquivo de entrada não existe.");

        $compress = Compress::make(CompressTypeEnum::PDF);
        $compress->setQuality(QualityEnum::LOW);

        $content = $compress->compress($inputFile, OutputTypeEnum::FILE, $outputFile);

        $this->assertFileExists($outputFile, "O arquivo de saída não foi criado.");

        $this->assertNotNull($content, "O conteúdo comprimido é nulo.");

        $inputFileSize = filesize($inputFile);
        $outputFileSize = filesize($outputFile);

        $this->assertGreaterThan(0, $outputFileSize, "O arquivo de saída está vazio.");

        $this
            ->assertTrue($outputFileSize < $inputFileSize,
                "O arquivo de saída {$outputFileSize}B não é menor que o arquivo de entrada {$inputFileSize}B."
            );
    }
}
