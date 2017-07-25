<?php

namespace Simplon\PhinxProxy\Traits;

use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Db\Table;

/**
 * @package Simplon\PhinxProxy\Traits
 */
class MigrateUtil
{
    /**
     * @param Table $table
     * @param string $columnName
     * @param int $length
     *
     * @return Table
     */
    public static function addTokenAwareColumns(Table $table, string $columnName = 'token', int $length = 12): Table
    {
        return $table->addColumn($columnName, 'string', ['limit' => $length]);
    }

    /**
     * @param Table $table
     * @param bool $nullable
     * @param string $columnName
     *
     * @return Table
     */
    public static function addMetaJsonAwareColumns(Table $table, bool $nullable = true, string $columnName = 'meta_json'): Table
    {
        return $table->addColumn($columnName, 'json', ['null' => $nullable]);
    }

    /**
     * @param AdapterInterface $adapter
     * @param Table $table
     * @param string $jsonColumnName
     * @param string $jsonQuery
     * @param string $columnName
     * @param string $mysqlNativeType
     * @param array $additionalColumnsToIndex
     */
    public static function addJsonIndexColumn(AdapterInterface $adapter, Table $table, string $jsonColumnName, string $jsonQuery, string $columnName, string $mysqlNativeType, array $additionalColumnsToIndex = []): void
    {
        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $adapter->execute('ALTER TABLE ' . $table->getName() . ' ADD ' . $columnName . ' ' . $mysqlNativeType . ' AS (JSON_UNQUOTE(' . $jsonColumnName . '->"' . $jsonQuery . '")) AFTER `' . $jsonColumnName . '`');

        array_unshift($additionalColumnsToIndex, $columnName);

        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $adapter->execute('ALTER TABLE ' . $table->getName() . ' ADD INDEX (' . implode(',', $additionalColumnsToIndex) . ')');
    }

    /**
     * @param Table $table
     * @param bool $nullable
     * @param string $columnName
     *
     * @return Table
     */
    public static function addMetaJsonAwareTextColumns(Table $table, bool $nullable = true, string $columnName = 'meta_json'): Table
    {
        return $table->addColumn($columnName, 'text', ['null' => $nullable]);
    }

    /**
     * @param Table $table
     * @param bool $nullable
     * @param string $columnName
     *
     * @return Table
     */
    public static function addMetaJsonAwareTextLongColumns(Table $table, bool $nullable = true, string $columnName = 'meta_json'): Table
    {
        return $table->addColumn($columnName, 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => $nullable]);
    }

    /**
     * @param Table $table
     * @param bool $withUpdated
     * @param string $createdColumnName
     * @param string $updatedColumnName
     *
     * @return Table
     */
    public static function addTimeAwareColumns(Table $table, bool $withUpdated = true, string $createdColumnName = 'created_at', string $updatedColumnName = 'updated_at'): Table
    {
        $table->addColumn($createdColumnName, 'integer', ['limit' => 10, 'signed' => false]);

        if ($withUpdated)
        {
            $table->addColumn($updatedColumnName, 'integer', ['limit' => 10, 'signed' => false]);
        }

        return $table;
    }

    /**
     * @param Table $table
     * @param string $columnName
     *
     * @return Table
     */
    public static function addForeignIdAwareColumns(Table $table, string $columnName): Table
    {
        return $table->addColumn($columnName, 'integer', ['limit' => 10, 'signed' => false]);
    }
}