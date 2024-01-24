<?php

namespace Goldfinch\Component\Media\Models;

use Goldfinch\Fielder\Fielder;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use Goldfinch\Component\Media\Blocks\MediaBlock;
use Goldfinch\Component\Media\Configs\MediaConfig;
use Goldfinch\JSONEditor\ORM\FieldType\DBJSONText;

class MediaSegment extends DataObject
{
    private static $table_name = 'MediaSegment';
    private static $singular_name = 'media segment';
    private static $plural_name = 'media segments';

    private static $db = [
        'Title' => 'Varchar',
        'Type' => 'Varchar',
        'Parameters' => DBJSONText::class,
    ];

    private static $has_many = [
        'Blocks' => MediaBlock::class,
    ];

    private static $has_one = [
        'Image' => Image::class,
    ];

    private static $many_many = [
        'Images' => Image::class,
    ];

    private static $many_many_extraFields = [
        'Images' => [
            'SortExtra' => 'Int',
        ],
    ];

    private static $owns = ['Image', 'Images'];

    private static $summary_fields = [
        'MediaThumbnail' => 'First media',
        'Title' => 'Title',
        'Type' => 'Type',
    ];

    public function fielder(Fielder $fielder): void
    {
        $fielder->remove(['Parameters']);

        $fielder->require(['Title', 'Type']);

        $fielder->fields([
            'Root.Main' => [
                $fielder->dropdown(
                    'Type',
                    'Type',
                    $this->getSegmentListOfTypes() ?? [],
                ),
                ($imageField = $fielder->wrapper(...$fielder->media('Image'))),
                ($imagesField = $fielder->wrapper(
                    ...$fielder->mediaSortable('Images'),
                )),
            ],
        ]);

        if ($this->ID && $this->Type) {
            $schemaParamsPath =
                BASE_PATH . '/app/_schema/' . 'media-' . $this->Type . '.json';

            if (file_exists($schemaParamsPath)) {
                $schemaParams = file_get_contents($schemaParamsPath);

                $fielder->fields([
                    'Root.Main' => [
                        $fielder->json(
                            'Parameters',
                            null,
                            [],
                            '{}',
                            null,
                            $schemaParams,
                        ),
                    ],
                ]);
            }
        }

        $i = 0;
        $imageSegment = $this->getSegmentListOfTypes('image');
        if ($imageSegment) {
            foreach ($imageSegment as $key => $state) {
                if ($state) {
                    if ($i === 0) {
                        $imageField = $imageField
                            ->displayIf('Type')
                            ->isEqualTo($key);
                    } else {
                        $imageField = $imageField->orIf('Type')->isEqualTo($key);
                    }
                    $i++;
                }
            }
            if ($i > 0) {
                $imageField->end();
            }
        }

        $i = 0;
        $imagesSegment = $this->getSegmentListOfTypes('images');
        if ($imagesSegment) {
            foreach ($imagesSegment as $key => $state) {
                if ($state) {
                    if ($i === 0) {
                        $imagesField = $imagesField
                            ->displayIf('Type')
                            ->isEqualTo($key);
                    } else {
                        $imagesField = $imagesField->orIf('Type')->isEqualTo($key);
                    }
                    $i++;
                }
            }
            if ($i > 0) {
                $imagesField->end();
            }
        }

        $fielder->dataField('Image')->setFolderName('media');
        $fielder->dataField('Images')->setFolderName('media');

        $cfg = MediaConfig::current_config();

        if (!class_exists('DNADesign\Elemental\Models\BaseElement')) {
            $fielder->remove('Blocks');
        }
    }

    public function getSegmentListOfTypes($key = 'label')
    {
        $types = $this->config()->get('segment_types');

        if ($types && count($types)) {
            return array_map(function ($n) use ($key) {
                return $n[$key];
            }, $types);
        }

        return null;
    }

    public function getSegmentTypeConfig($param = null)
    {
        $types = $this->config()->get('segment_types');

        if (
            $types &&
            count($types) &&
            $this->Type &&
            isset($types[$this->Type])
        ) {
            if ($param) {
                if (isset($types[$this->Type][$param])) {
                    return $types[$this->Type][$param];
                } else {
                    return null;
                }
            } else {
                return $types[$this->Type];
            }
        }

        return null;
    }

    public function MediaThumbnail()
    {
        if ($this->getSegmentTypeConfig('image')) {
            if ($this->Image()->exists()) {
                return $this->Image()->FitMax(300, 150);
            }
        } elseif ($this->getSegmentTypeConfig('images')) {
            if ($this->Images()->exists() && $this->Images()->Count()) {
                return $this->Images()
                    ->First()
                    ->FitMax(300, 150);
            }
        } else {
            if ($this->Image()->exists()) {
                return $this->Image()->FitMax(300, 150);
            } elseif ($this->Images()->exists() && $this->Images()->Count()) {
                return $this->Images()
                    ->First()
                    ->FitMax(300, 150);
            }
        }
    }

    public function RenderSegmentMedia()
    {
        if ($this->Disabled) {
            return;
        }

        $partialFile = 'Components/Media/' . $this->Type;

        if (ss_theme_template_file_exists($partialFile)) {
            return $this->Type ? $this->renderWith($partialFile) : null;
        } else {
            return $this->renderWith('Goldfinch/Component/Media/MediaSegment');
        }

        return null;
    }

    public function onBeforeWrite()
    {
        $changed = $this->getChangedFields();

        if (isset($changed['Type'])) {
            if ($changed['Type']['before'] != $changed['Type']['after']) {
                $this->Parameters = '';
            }
        }

        parent::onBeforeWrite();
    }
}
