<?php

namespace Avolutions\Database;

class ColumnDecimal extends Column
{
    public function __construct(
        string $name,
        int $precision,
        int $scale,
        ?string $length = null,
        ?string $default = null,
        string $null = Column::NOT_NULL,
        bool $primaryKey = false,
        bool $autoIncrement = false
    ) {
        $columnTypeFormat = sprintf('%s(%d,%d)', ColumnType::DECIMAL, $precision, $scale);
        parent::__construct($name, $columnTypeFormat, $length, $default, $null, $primaryKey, $autoIncrement);
    }

}