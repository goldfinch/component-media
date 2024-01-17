<?php

namespace Goldfinch\Component\Media\Blocks;

use Goldfinch\Harvest\Harvest;
use Goldfinch\Harvest\Traits\HarvestTrait;
use DNADesign\Elemental\Models\BaseElement;
use Goldfinch\Component\Media\Models\MediaSegment;

class MediaBlock extends BaseElement
{
    use HarvestTrait;

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

    private static $owns = [
        'Segment',
    ];

    public function harvest(Harvest $harvest)
    {
        $harvest->fields([
            'Root.Main' => [
                $harvest->objectLink('Segment'),
            ]
            ]);
    }

    public function getSummary()
    {
        return $this->getDescription();
    }

    public function getType()
    {
        $default = $this->i18n_singular_name() ?: 'Block';

        return _t(__CLASS__ . '.BlockType', $default);
    }
}
