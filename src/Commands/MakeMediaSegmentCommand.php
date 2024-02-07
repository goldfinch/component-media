<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Services\Templater;
use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;

#[AsCommand(name: 'make:media-segment')]
class MakeMediaSegmentCommand extends GeneratorCommand
{
    protected static $defaultName = 'make:media-segment';

    protected $description = 'Make new media segment';

    protected $no_arguments = true;

    protected function execute($input, $output): int
    {
        $segmentName = $this->askClassNameQuestion('Name of the segment (eg: Hero, Intro)', $input, $output);

        if (!$segmentName) {
            return Command::FAILURE;
        }

        $segmentName = strtolower($segmentName);

        $fs = new Filesystem();

        $templater = Templater::create($input, $output, $this, 'goldfinch/component-media');
        $theme = $templater->defineTheme();

        $fs->copy(
            BASE_PATH .
                '/vendor/goldfinch/component-media/components/segment.json',
            'app/_schema/media-'.$segmentName.'.json',
        );

        $fs->copy(
            BASE_PATH .
                '/vendor/goldfinch/component-media/components/segment.ss',
            'themes/'.$theme.'/templates/Components/Media/'.$segmentName.'.ss',
        );

        // find config
        $config = $this->findYamlConfigFileByName('app-component-media');

        // create new config if not exists
        if (!$config) {

            $command = $this->getApplication()->find('make:config');
            $command->run(new ArrayInput([
                'name' => 'component-media',
                '--plain' => true,
                '--after' => 'goldfinch/component-media',
                '--namesuffix' => 'app-',
            ]), $output);

            $config = $this->findYamlConfigFileByName('app-component-media');
        }

        $ucfirst = ucfirst($segmentName);

        // update config
        $this->updateYamlConfig(
            $config,
            'Goldfinch\Component\Media\Models\MediaSegment' . '.segment_types.' . $segmentName,
            [
                'label' => $ucfirst,
                'image' => true,
                'images' => true
            ],
        );

        return Command::SUCCESS;
    }
}
