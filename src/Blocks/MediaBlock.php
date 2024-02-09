<?php

namespace Goldfinch\Component\Media\Blocks;

use Goldfinch\Fielder\Fielder;
use DNADesign\Elemental\Models\BaseElement;
use Goldfinch\Component\Media\Models\MediaSegment;

class MediaBlock extends BaseElement
{
    private static $table_name = 'MediaBlock';
    private static $singular_name = 'Media';
    private static $plural_name = 'Media';

    private static $db = [];

    private static $inline_editable = false;
    private static $description = 'Media block handler';
    private static $icon = 'font-icon-block-carousel';

    private static $has_one = [
        'Segment' => MediaSegment::class,
    ];

    private static $owns = ['Segment'];

    public function fielder(Fielder $fielder): void
    {
        $fielder->fields([
            'Root.Main' => [$fielder->objectLink('Segment')],
        ]);
    }
}
