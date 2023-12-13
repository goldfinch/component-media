<?php

namespace Goldfinch\Component\Media\Models;

use Goldfinch\Component\Media\Blocks\MediaBlock;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use Goldfinch\JSONEditor\Forms\JSONEditorField;
use Goldfinch\JSONEditor\ORM\FieldType\DBJSONText;
use Goldfinch\FocusPointExtra\Forms\UploadFieldWithExtra;
use Goldfinch\FocusPointExtra\Forms\SortableUploadFieldWithExtra;

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

    private static $owns = [
        'Image',
        'Images',
    ];

    private static $summary_fields = [
        'MediaThumbnail' => 'First media',
        'Title' => 'Title',
        'Type' => 'Type',
    ];

    // private static $belongs_to = [];
    // private static $belongs_many_many = [];

    // private static $default_sort = null;
    // private static $indexes = null;
    // private static $casting = [];
    // private static $defaults = [];

    // private static $field_labels = [];
    // private static $searchable_fields = [];

    // private static $cascade_deletes = [];
    // private static $cascade_duplicates = [];

    // * goldfinch/helpers
    // private static $field_descriptions = [];
    private static $required_fields = [
        'Title',
    ];

    public function getSegmentListOfTypes($key = 'label')
    {
        $types = $this->config()->get('segment_types');

        if ($types && count($types))
        {
            return array_map(function($n) use ($key) {
                return $n[$key];
            }, $types);
        }

        return null;
    }

    public function getSegmentTypeConfig($param = null)
    {
        $types = $this->config()->get('segment_types');

        if ($types && count($types) && $this->Type && isset($types[$this->Type]))
        {
            if ($param)
            {
                if (isset($types[$this->Type][$param]))
                {
                    return $types[$this->Type][$param];
                }
                else
                {
                    return null;
                }
            }
            else
            {
                return $types[$this->Type];
            }
        }

        return null;
    }

    public function MediaThumbnail()
    {
        if ($this->getSegmentTypeConfig('image'))
        {
            if ($this->Image()->exists())
            {
                return $this->Image()->FitMax(300,150);
            }
        }
        else if ($this->getSegmentTypeConfig('images'))
        {
            if ($this->Images()->exists() && $this->Images()->Count())
            {
                return $this->Images()->First()->FitMax(300,150);
            }
        }
        else
        {
            if ($this->Image()->exists())
            {
                return $this->Image()->FitMax(300,150);
            }
            else if ($this->Images()->exists() && $this->Images()->Count())
            {
                return $this->Images()->First()->FitMax(300,150);
            }
        }
    }

    public function RenderSegmentMedia()
    {
        if ($this->Disabled)
        {
            return;
        }

        $partialFile = 'Components/Media/' . $this->Type;

        if (ss_theme_template_file_exists($partialFile))
        {
            return $this->Type ? $this->renderWith($partialFile) : null;
        }
        else
        {
            return $this->renderWith('Goldfinch/Component/Media/MediaSegment');
        }

        return null;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Image',
            'Images',
            'Parameters',
        ]);

        $fields->addFieldsToTab(
            'Root.Main',
            [
                DropdownField::create(
                    'Type',
                    'Type',
                    $this->getSegmentListOfTypes(),
                ),
                $imageField = Wrapper::create(
                    ...UploadFieldWithExtra::create('Image', 'Image', $fields, $this)->getFields(),
                ),
                $imagesField = Wrapper::create(
                    ...SortableUploadFieldWithExtra::create('Images', 'Images', $fields, $this)->getFields(),
                ),
            ]
        );

        if ($this->ID && $this->Type)
        {
            $schemaParamsPath = BASE_PATH . '/app/_schema/' . 'media-' . $this->Type . '.json';

            if (file_exists($schemaParamsPath))
            {
                $schemaParams = file_get_contents($schemaParamsPath);

                $fields->addFieldsToTab(
                    'Root.Main',
                    [
                        JSONEditorField::create('Parameters', 'Parameters', $this, [], '{}', null, $schemaParams),
                    ]
                );
            }
        }

        $i = 0;
        foreach ($this->getSegmentListOfTypes('image') as $key => $state)
        {
            if ($state)
            {
                if ($i === 0)
                {
                    $imageField = $imageField->displayIf('Type')->isEqualTo($key);
                }
                else
                {
                    $imageField = $imageField->orIf('Type')->isEqualTo($key);
                }
                $i++;
            }

        }
        if ($i > 0)
        {
            $imageField->end();
        }

        $i = 0;
        foreach ($this->getSegmentListOfTypes('images') as $key => $state)
        {
            if ($state)
            {
                if ($i === 0)
                {
                    $imagesField = $imagesField->displayIf('Type')->isEqualTo($key);
                }
                else
                {
                    $imagesField = $imagesField->orIf('Type')->isEqualTo($key);
                }
                $i++;
            }
        }
        if ($i > 0)
        {
            $imagesField->end();
        }

        return $fields;
    }

    // public function validate()
    // {
    //     $result = parent::validate();

    //     // $result->addError('Error message');

    //     return $result;
    // }

    public function onBeforeWrite()
    {
        $changed = $this->getChangedFields();

        if (isset($changed['Type']))
        {
            if ($changed['Type']['before'] != $changed['Type']['after'])
            {
                $this->Parameters = '';
            }
        }

        parent::onBeforeWrite();
    }

    // public function canView($member = null)
    // {
    //     return Permission::check('CMS_ACCESS_Company\Website\MyAdmin', 'any', $member);
    // }

    // public function canEdit($member = null)
    // {
    //     return Permission::check('CMS_ACCESS_Company\Website\MyAdmin', 'any', $member);
    // }

    // public function canDelete($member = null)
    // {
    //     return Permission::check('CMS_ACCESS_Company\Website\MyAdmin', 'any', $member);
    // }

    // public function canCreate($member = null, $context = [])
    // {
    //     return Permission::check('CMS_ACCESS_Company\Website\MyAdmin', 'any', $member);
    // }
}
