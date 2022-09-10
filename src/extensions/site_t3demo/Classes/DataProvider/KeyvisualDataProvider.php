<?php

declare(strict_types=1);

namespace B13\SiteT3demo\DataProvider;

use Smic\Webcomponents\DataProvider\AbstractDataProvider;
use Smic\Webcomponents\DataProvider\Traits\FileReferences;
use Smic\Webcomponents\DataProvider\Traits\Image;
use TYPO3\CMS\Core\Resource\AbstractFile;
use TYPO3\CMS\Core\Resource\FileReference;

class KeyvisualDataProvider extends AbstractDataProvider
{
    use FileReferences;
    use Image;

    public function getProperties(): ?array
    {
        $image = $this->loadFileReference('image', (int)$this->inputData['uid']);
        if (!$image instanceof FileReference || $image->getType() !== AbstractFile::FILETYPE_IMAGE) {
            return null;
        }
        return [
            'header' => $this->inputData['header'],
            'imageSrc' => $this->getImageUri($image, '706c', '474c'),
            'text' => nl2br($this->inputData['bodytext']),
        ];
    }

    public function getTagName(): ?string
    {
        return 'my-keyvisual';
    }
}
