<?php

namespace Goldfinch\Component\Media\Blocks;

use Goldfinch\Fielder\Fielder;
use Goldfinch\Blocks\Models\BlockElement;
use Goldfinch\Component\Media\Models\MediaSegment;

class MediaBlock extends BlockElement
{
    private static $table_name = 'MediaBlock';
    private static $singular_name = 'Media';
    private static $plural_name = 'Media';

    private static $db = [];

    private static $inline_editable = false;
    private static $description = '';
    private static $icon = 'font-icon-block-carousel';
    // private static $disable_pretty_anchor_name = false;
    // private static $displays_title_in_template = true;

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
