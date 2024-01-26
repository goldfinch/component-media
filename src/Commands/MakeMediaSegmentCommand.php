<?php

namespace Goldfinch\Component\Media\Commands;

use Symfony\Component\Finder\Finder;
use Goldfinch\Taz\Services\Templater;
use Goldfinch\Taz\Services\InputOutput;
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
        $io = new InputOutput($input, $output);

        $segmentName = $io->question('Name of the segment (lowercase, dash, A-z0-9)', null, function ($answer) use ($io) {

            if (!is_string($answer) || $answer === null) {
                throw new \RuntimeException(
                    'Invalid name'
                );
            } else if (strlen($answer) < 2) {
                throw new \RuntimeException(
                    'Too short name'
                );
            } else if(!preg_match('/^([A-z0-9\-]+)$/', $answer)) {
                throw new \RuntimeException(
                    'Name can contains letter, numbers and dash'
                );
            }

            return $answer;
        });

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

        if (!$this->setSegmentInConfig($segmentName)) {
            // create config

            $command = $this->getApplication()->find('vendor:component-media:config');

            $arguments = [
                'name' => 'component-media',
            ];

            $greetInput = new ArrayInput($arguments);
            $returnCode = $command->run($greetInput, $output);

            $this->setSegmentInConfig($segmentName);
        }

        $io->right('Media segment has been added');

        return Command::SUCCESS;
    }

    private function setSegmentInConfig($segmentName)
    {
        $rewritten = false;

        $finder = new Finder();
        $files = $finder->in(BASE_PATH . '/app/_config')->files()->contains('Goldfinch\Component\Media\Models\MediaSegment');

        foreach ($files as $file) {

            // stop after first replacement
            if ($rewritten) {
                break;
            }

            if (strpos($file->getContents(), 'segment_types') !== false) {

                $ucfirst = ucfirst($segmentName);

                $newContent = $this->addToLine(
                    $file->getPathname(),
                    'segment_types:','    '.$segmentName.':'.PHP_EOL.'      label: "'.$ucfirst.' image"'.PHP_EOL.'      image: true'.PHP_EOL.'      images: true',
                );

                file_put_contents($file->getPathname(), $newContent);

                $rewritten = true;
            }
        }

        return $rewritten;
    }
}
