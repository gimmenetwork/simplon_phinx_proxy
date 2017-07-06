<?php

namespace App\Traits;

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Db\Table;

/**
 * @package App\Traits
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