<?php

declare(strict_types=1);

namespace B13\SiteT3demo\Hooks;

/*
 * This file is part of TYPO3 CMS-extension site_t3demo by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\SiteT3demo\PageConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Datahandler
{
    /**
     * @param array $fieldArray
     * @param string $table
     * @param mixed $id
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $parentObj
     */
    public function processDatamap_preProcessFieldArray(
        &$fieldArray,
        $table,
        $id,
        \TYPO3\CMS\Core\DataHandling\DataHandler $parentObj
    ) {
        if ($table === 'pages') {
            $this->pageDoktypeToBackendLayout($fieldArray);
        }
    }

    /**
     * @param array $fieldArray
     */
    protected function pageDoktypeToBackendLayout(&$fieldArray)
    {
        if (!empty($fieldArray['doktype'])) {
            $pageConfiguration = GeneralUtility::makeInstance(PageConfiguration::class);
            try {
                $backendLayout = $pageConfiguration->getBackendLayout((int)$fieldArray['doktype']);
                $fieldArray['backend_layout'] = $backendLayout;
            } catch (\Exception $e) {
            }
        }
    }
}
