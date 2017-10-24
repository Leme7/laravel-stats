<?php

namespace Wnx\LaravelStats\Formatters;

use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
use Wnx\LaravelStats\Statistics\ProjectStatistics;
use Symfony\Component\Console\Helper\TableSeparator;

class TableOutput
{
    /**
     * Console output.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;

    /**
     * Create new instance of TableOutput.
     *
     * @param \Illuminate\Console\OutputStyle $output
     */
    public function __construct(OutputStyle $output)
    {
        $this->output = $output;
    }

    /**
     * Render output from given statistics.
     *
     * @param  ProjectStatistics $statistics
     * @return void
     */
    public function render(ProjectStatistics $statistics)
    {
        $table = new Table($this->output);

        $rows = $statistics->generate();

        $table
            ->setHeaders(['Name', 'Classes', 'Methods', 'Methods/Class', 'Lines', 'LoC', 'LoC/Method'])
            ->setRows($rows->except('Other')->all())
            ->addRow($rows->only('Other')->first())
            ->addRow(new TableSeparator)
            ->addRow($statistics->getTotalRow($rows));

        for ($i = 1; $i <= 6; $i++) {
            $table->setColumnStyle($i, (new TableStyle)->setPadType(STR_PAD_LEFT));
        }

        $table->render();
    }
}
