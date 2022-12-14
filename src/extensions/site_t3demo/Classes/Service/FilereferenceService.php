<?php

declare(strict_types=1);

namespace B13\SiteT3demo\Service;

/*
 * This file is part of TYPO3 CMS-extension site_t3demo by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FilereferenceService
{
    public static function resolveFilereferences($field, $table, $uid)
    {
        $queryBuilder = self::getQueryBuilder('sys_file_reference');
        $references = $queryBuilder
            ->select('*')
            ->from('sys_file_reference')
            ->orderBy('sorting_foreign')
            ->where(
                $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('tablenames', $queryBuilder->createNamedParameter($table)),
                $queryBuilder->expr()->eq('fieldname', $queryBuilder->createNamedParameter($field))
            )
            ->executeQuery()
            ->fetchAllAssociative();
        foreach ($references as $key => $reference) {
            // add the database record for the original/referenced file
            $queryBuilder = self::getQueryBuilder('sys_file');
            $originalFile = $queryBuilder
                ->select('*')
                ->from('sys_file')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($reference['uid_local']))
                )
                ->executeQuery()
                ->fetchAllAssociative();
            $references[$key]['originalFile'] = $originalFile[0];
            // add the database record for the original file's metadata
            $queryBuilder = self::getQueryBuilder('sys_file_metadata');
            $originalFileMetaData = $queryBuilder
                ->select('*')
                ->from('sys_file_metadata')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($reference['uid_local']))
                )
                ->executeQuery()
                ->fetchAllAssociative();
            $references[$key]['originalFileMetaData'] = $originalFileMetaData[0];
        }
        return $references;
    }

    public static function countNumberOfVisibleFilereferences($field, $table, $uid)
    {
        $queryBuilder = self::getQueryBuilder('sys_file_reference');
        $queryBuilder->getRestrictions()
            ->add(GeneralUtility::makeInstance(HiddenRestriction::class));
        $references = $queryBuilder
            ->count('uid')
            ->from('sys_file_reference')
            ->orderBy('sorting_foreign')
            ->where(
                $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('tablenames', $queryBuilder->createNamedParameter($table)),
                $queryBuilder->expr()->eq('fieldname', $queryBuilder->createNamedParameter($field))
            )
            ->executeQuery()
            ->fetchOne();
        return $references;
    }

    protected static function getQueryBuilder(string $table): QueryBuilder
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder->getRestrictions()
            ->removeAll()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        return $queryBuilder;
    }
}
