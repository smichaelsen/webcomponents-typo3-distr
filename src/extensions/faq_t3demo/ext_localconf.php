<?php

defined('TYPO3_MODE') or die();

(function () {
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class)
        ->registerIcon(
            'mimetypes-x-faq_t3demo',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:faq_t3demo/Resources/Public/Icons/mimetypes-x-faq_t3demo.svg']
        );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['tx-faq_t3demo'] = \B13\FaqT3demo\Hooks\DataHandlerCacheHook::class;
})();
