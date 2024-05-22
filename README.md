# Compress Library

A biblioteca `Compress` permite a compressão de imagens e PDFs com facilidade. Suporta diferentes níveis de qualidade e modos de saída.

## Instalação

Para instalar a biblioteca, utilize o Composer para adicionar o pacote `nexacodetech/compress` ao seu projeto:

```bash
composer require nexacodetech/compress
```

## Uso

### Comprimindo Imagens

Para comprimir uma imagem, utilize o seguinte código:

```php
use NexacodeTech\Compress\Compress;
use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;

$compress = Compress::make(CompressTypeEnum::IMAGE);

$compress->setQuality(QualityEnum::LOW);
$content = $compress->compress('files/panorama.jpg', OutputTypeEnum::FILE, 'files/compressed.jpg');
```

#### Qualidade

Os níveis de qualidade disponíveis são:

- `QualityEnum::LOW`
- `QualityEnum::MEDIUM`
- `QualityEnum::MEDIUM`
- `QualityEnum::HIGH`
- `QualityEnum::VERY_HIGH`
- `QualityEnum::MAXIMUM`

#### Tipo de Saída

Os tipos de saída disponíveis são:

- `OutputTypeEnum::FILE` - Salva o arquivo comprimido.
- `OutputTypeEnum::STREAM` - Retorna o conteúdo comprimido como um stream.

### Comprimindo PDFs

Para comprimir um arquivo PDF, a única modificação necessária é alterar o tipo de compressão para `PDF`:

```php
use NexacodeTech\Compress\Compress;
use NexacodeTech\Compress\Enums\CompressTypeEnum;
use NexacodeTech\Compress\Enums\QualityEnum;
use NexacodeTech\Compress\Enums\OutputTypeEnum;

$compress = Compress::make(CompressTypeEnum::PDF);

$compress->setQuality(QualityEnum::LOW);
$content = $compress->compress('files/document.pdf', OutputTypeEnum::FILE, 'files/compressed.pdf');
```

## Contribuição

Se desejar contribuir para este projeto, sinta-se à vontade para abrir um pull request ou relatar problemas na página de [issues](https://github.com/nexacodetech/compress/issues).

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
