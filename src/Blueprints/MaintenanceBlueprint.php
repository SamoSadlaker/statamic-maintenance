<?php

namespace SamoSadlaker\StatamicMaintenance\Blueprints;

use Statamic\Facades\Blueprint;

class MaintenanceBlueprint
{
    public function __invoke()
    {
        return Blueprint::make()->setContents([
            'tabs' => [
                'main' => [
                    'display' => 'Main',
                    'sections' => [
                        [
                            'display' => 'Maintenance',
                            'fields' => [
                                [
                                    'handle' => 'maintenance_enabled',
                                    'field' => [
                                        'type' => 'toggle',
                                        'display' => 'Enabled',
                                        'instructions' => 'Enable or disable maintenance mode.',
                                        'width' => 50,
                                    ],
                                ],
                                [
                                    'handle' => 'maintenance_use_default_page',
                                    'field' => [
                                        'type' => 'toggle',
                                        'display' => 'Use default maintenance page',
                                        'instructions' => 'Enable to use the addon\'s built-in page, or disable to choose a custom template.',
                                        'width' => 50,
                                        'default' => true,
                                    ],
                                ],
                                [
                                    'handle' => 'maintenance_page',
                                    'field' => [
                                        'type' => 'template',
                                        'display' => 'Custom Maintenance Page',
                                        'instructions' => 'The template to display when maintenance mode is enabled.',
                                        'width' => 100,
                                        'always_save' => true,
                                        'if' => ['maintenance_use_default_page' => false],
                                    ],
                                ],
                                [
                                    'handle' => 'maintenance_title',
                                    'field' => [
                                        'type' => 'text',
                                        'display' => 'Title',
                                        'instructions' => 'The title to display on the maintenance page.',
                                        'width' => 100,
                                        'validate' => 'required',
                                        'default' => 'Maintenance Mode',
                                    ],
                                ],
                                [
                                    'handle' => 'maintenance_message',
                                    'field' => [
                                        'type' => 'bard',
                                        'display' => 'Message',
                                        'instructions' => 'The message to display on the maintenance page.',
                                        'width' => 100,
                                        'buttons' => ['h2', 'h3', 'bold', 'italic', 'link', 'unorderedlist', 'orderedlist', 'quote', 'anchor', 'alignleft', 'aligncenter', 'alignright', 'alignjustify'],
                                        'validate' => 'required',
                                        'smart_typography' => true,
                                        'remove_empty_nodes' => true,
                                        'link_noopener' => true,
                                        'link_noreferrer' => true,
                                        'target_blank' => true,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
