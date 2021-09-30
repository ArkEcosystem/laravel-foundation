<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Table;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Extension\Table\TableCell;
use League\CommonMark\Extension\Table\TableCellRenderer;
use League\CommonMark\Extension\Table\TableRow;
use League\CommonMark\Extension\Table\TableRowRenderer;
use League\CommonMark\Extension\Table\TableSection;
use League\CommonMark\Extension\Table\TableSectionRenderer;
use League\CommonMark\Extension\Table\TableStartParser;

final class TableExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addBlockStartParser(new TableStartParser())
            ->addRenderer(Table::class, new TableRenderer())
            ->addRenderer(TableSection::class, new TableSectionRenderer())
            ->addRenderer(TableRow::class, new TableRowRenderer())
            ->addRenderer(TableCell::class, new TableCellRenderer());
    }
}
