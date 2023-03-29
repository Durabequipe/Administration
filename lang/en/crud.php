<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'projects' => [
        'name' => 'Projects',
        'index_title' => 'Projects List',
        'new_title' => 'New Project',
        'create_title' => 'Create Project',
        'edit_title' => 'Edit Project',
        'show_title' => 'Show Project',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'videos' => [
        'name' => 'Videos',
        'index_title' => 'Videos List',
        'new_title' => 'New Video',
        'create_title' => 'Create Video',
        'edit_title' => 'Edit Video',
        'show_title' => 'Show Video',
        'inputs' => [
            'project_id' => 'Project',
            'path' => 'Path',
            'thumbnail' => 'Thumbnail',
            'position_id' => 'Position',
            'is_main' => 'Is Main',
        ],
    ],

    'interacts' => [
        'name' => 'Interacts',
        'index_title' => 'Interacts List',
        'new_title' => 'New Interact',
        'create_title' => 'Create Interact',
        'edit_title' => 'Edit Interact',
        'show_title' => 'Show Interact',
        'inputs' => [
            'video_id' => 'Video',
            'link_to' => 'Interact With',
            'content' => 'Content',
            'position_id' => 'Position',
        ],
    ],

    'positions' => [
        'name' => 'Positions',
        'index_title' => 'Positions List',
        'new_title' => 'New Position',
        'create_title' => 'Create Position',
        'edit_title' => 'Edit Position',
        'show_title' => 'Show Position',
        'inputs' => [
            'x' => 'X',
            'y' => 'Y',
            'zindex' => 'Zindex',
            'type' => 'Type',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
