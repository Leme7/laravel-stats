<?php

namespace Wnx\LaravelStats\Commands;

use Illuminate\Console\Command;
use Wnx\LaravelStats\ClassFinder;
use Wnx\LaravelStats\Formatters\TableOutput;
use Wnx\LaravelStats\Statistics\ProjectStatistics;

class StatsListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Statistics for this Laravel Project';

    /**
     * Execute the console command.
     *
     * @param $finder Wnx\LaravelStats\ClassFinder
     * @return mixed
     */
    public function handle(ClassFinder $finder)
    {
        $statistics = new ProjectStatistics($finder->getComponents());

        (new TableOutput($this->output))->render($statistics);
    }
}
