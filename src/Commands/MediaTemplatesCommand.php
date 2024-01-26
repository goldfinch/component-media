<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Services\Templater;
use Goldfinch\Taz\Console\GeneratorCommand;

#[AsCommand(name: 'vendor:component-media:templates')]
class MediaTemplatesCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:component-media:templates';

    protected $description = 'Publish [goldfinch/component-media] templates';

    protected $no_arguments = true;

    protected function execute($input, $output): int
    {
        $templater = Templater::create($input, $output, $this, 'goldfinch/component-media');

        $theme = $templater->defineTheme();

        if (is_string($theme)) {

            $componentPath = BASE_PATH . '/vendor/goldfinch/component-media/templates/Goldfinch/Component/Media/';
            $themePath = 'themes/' . $theme . '/templates/Goldfinch/Component/Media/';

            $files = [
                [
                    'from' => $componentPath . 'Blocks/MediaBlock.ss',
                    'to' => $themePath . 'Blocks/MediaBlock.ss',
                ],
                [
                    'from' => $componentPath . 'MediaSegment.ss',
                    'to' => $themePath . 'MediaSegment.ss',
                ],
            ];

            return $templater->copyFiles($files);
        } else {
            return $theme;
        }
    }
}
