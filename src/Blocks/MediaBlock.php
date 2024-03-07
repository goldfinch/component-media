<?php

namespace Goldfinch\Component\Media\Blocks;

use DNADesign\Elemental\Models\BaseElement;
use Goldfinch\Helpers\Traits\BaseElementTrait;
use Goldfinch\Component\Media\Models\MediaSegment;

class MediaBlock extends BaseElement
{
    use BaseElementTrait;

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

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fielder = $fields->fielder($this);

        $fielder->fields([
            'Root.Main' => [$fielder->objectLink('Segment')],
        ]);

        return $fields;
    }
}
