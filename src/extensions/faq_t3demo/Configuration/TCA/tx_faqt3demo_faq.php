<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:faq_t3demo/Resources/Private/Language/locallang_db.xlf:faq',
        'label' => 'question',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'tstamp' => 'tstamp',
        'versioningWS' => false,
        'security' => [
            'ignoreWebMountRestriction' => true
        ],
        'languageField' => 'sys_language_uid',
        'sortby' => 'sorting',
        'origUid' => 't3_origuid',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'disabled'
        ],
        'typeicon_classes' => [
            'default' => 'mimetypes-x-faq_t3demo',
        ],
        'searchFields' => 'question,answer',
        'translationSource' => 'l10n_source',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'transOrigPointerField' => 'l10n_parent'
    ],
    'types' => [
        '1' => [
            'showitem' => '
                question, answer'
        ],
    ],
    'columns' => [
        'disabled' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ]
        ],
        'question' => [
            'label' => 'LLL:EXT:faq_t3demo/Resources/Private/Language/locallang_db.xlf:faq.question',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'max' => 255
            ],
            'l10n_mode' => 'prefixLangTitle'
        ],
        'answer' => [
            'label' => 'LLL:EXT:faq_t3demo/Resources/Private/Language/locallang_db.xlf:faq.answer',
            'config' => [
                'type' => 'text',
                'eval' => 'trim,required',
                'cols' => 80,
                'rows' => 15,
                'enableRichtext' => true
            ],
            'l10n_mode' => 'prefixLangTitle'
        ]
    ],
];
