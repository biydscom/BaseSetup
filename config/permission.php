<?php

use Spatie\Permission\DefaultTeamResolver;

return [

    'models' => [

        'permission' => App\Models\Permission::class,

        'role' => App\Models\Role::class,

    ],

    'table_names' => [

        'roles' => 'roles',

        'permissions' => 'permissions',

        'model_has_permissions' => 'model_has_permissions',

        'model_has_roles' => 'model_has_roles',

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        'model_morph_key' => 'model_id',
        'team_foreign_key' => 'team_id',
    ],

    'register_permission_check_method' => true,

    'register_role_check_method' => true,

    'register_ability_check_method' => false,

    'enable_wildcard_permission' => false,

    'cache' => [

        'expiration_time' => 3600,

        'key' => 'spatie.permission.cache',

        'store' => 'redis',

        'model_resolver' => DefaultTeamResolver::class,
    ],

    'teams' => false,

    'use_passport_client_credentials_strategy' => false,

    'testing' => [
        'always_reset_cache_to_default_state' => true,
    ],
];
