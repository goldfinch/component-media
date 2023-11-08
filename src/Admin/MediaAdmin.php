<?php

namespace Goldfinch\Component\Media\Admin;

use SilverStripe\Admin\ModelAdmin;
use JonoM\SomeConfig\SomeConfigAdmin;
use Goldfinch\Component\Media\Blocks\MediaBlock;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Goldfinch\Component\Media\Configs\MediaConfig;
use Goldfinch\Component\Media\Models\MediaSegment;

class MediaAdmin extends ModelAdmin
{
    use SomeConfigAdmin;

    private static $url_segment = 'media';
    private static $menu_title = 'Media';
    private static $menu_icon_class = 'bi-images';
    // private static $menu_priority = -0.5;

    private static $managed_models = [
        MediaSegment::class => [
            'title'=> 'Segments',
        ],
        MediaBlock::class => [
            'title'=> 'Blocks',
        ],
        MediaConfig::class => [
            'title'=> 'Settings',
        ],
    ];

    // public $showImportForm = true;
    // public $showSearchForm = true;
    // private static $page_length = 30;

    public function getList()
    {
        $list = parent::getList();

        // ..

        return $list;
    }

    protected function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();

        // ..

        return $config;
    }

    public function getSearchContext()
    {
        $context = parent::getSearchContext();

        // ..

        return $context;
    }

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        // ..

        return $form;
    }

    // public function getExportFields()
    // {
    //     return [
    //         // 'Name' => 'Name',
    //         // 'Category.Title' => 'Category'
    //     ];
    // }
}
