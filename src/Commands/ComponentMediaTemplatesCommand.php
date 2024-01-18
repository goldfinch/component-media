<?php

namespace Goldfinch\Component\Media\Commands;

use Symfony\Component\Finder\Finder;
use Goldfinch\Taz\Services\InputOutput;
use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\ChoiceQuestion;

#[AsCommand(name: 'templates:component-media')]
class ComponentMediaTemplatesCommand extends GeneratorCommand
{
    protected static $defaultName = 'templates:component-media';

    protected $description = 'Publish component-media templates into your theme folder';

    protected function execute($input, $output): int
    {
        // parent::execute($input, $output);

        $io = new InputOutput($input, $output);

        $themes = Finder::create()
            ->in(THEMES_PATH)
            ->depth(0)
            ->directories();

        $ssTheme = null;

        if (!$themes || !$themes->count()) {
            $io->text('Themes not found');

            return Command::SUCCESS;
        } elseif ($themes->count() > 1) {
            // choose theme

            $availableThemes = [];

            foreach ($themes as $theme) {
                $availableThemes[] = $theme->getFilename();
            }

            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Which templete?',
                $availableThemes,
                0,
            );
            $question->setErrorMessage('Theme %s is invalid.');
            $theme = $helper->ask($input, $output, $question);
        } else {
            foreach ($themes as $themeItem) {
                $theme = $themeItem->getFilename();
            }
        }

        if (isset($theme) && $theme) {
            $this->copyTemplates($theme);

            $io->text('Done');

            return Command::SUCCESS;
        }
    }

    private function copyTemplates($theme)
    {
        $fs = new Filesystem();

        $fs->copy(
            BASE_PATH .
                '/vendor/goldfinch/component-media/templates/Goldfinch/Component/Media/Blocks/MediaBlock.ss',
            'themes/' .
                $theme .
                '/templates/Goldfinch/Component/Media/Blocks/MediaBlock.ss',
        ); // , true);

        $fs->copy(
            BASE_PATH .
                '/vendor/goldfinch/component-media/templates/Goldfinch/Component/Media/Models/Nest/MediaSegment.ss',
            'themes/' .
                $theme .
                '/templates/Goldfinch/Component/Media/Models/Nest/MediaSegment.ss',
        ); // , true);

        $fs->copy(
            BASE_PATH .
                '/vendor/goldfinch/component-media/templates/Goldfinch/Component/Media/Pages/Nest/Media.ss',
            'themes/' .
                $theme .
                '/templates/Goldfinch/Component/Media/Pages/Nest/Media.ss',
        ); // , true);
    }
}