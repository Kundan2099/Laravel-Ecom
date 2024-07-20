<?php 

namespace App\Enums;

enum Permission: string
{
    case VIEW_ACCESS = 'VIEW_ACCESS';
    case ADD_ACCESS = 'ADD_ACCESS';
    case EDIT_ACCESS = 'EDIT_ACCESS';
    case DELETE_ACCESS = 'DELETE_ACCESS';

    case VIEW_PROJECT = 'VIEW_PROJECT';
    case ADD_PROJECT = 'ADD_PROJECT';
    case EDIT_PROJECT = 'EDIT_PROJECT';
    case DELETE_PROJECT = 'DELETE_PROJECT';

    case VIEW_CATEGORY = 'VIEW_CATEGORY';
    case ADD_CATEGORY = 'ADD_CATEGORY';
    case EDIT_CATEGORY = 'EDIT_CATEGORY';
    case DELETE_CATEGORY = 'DELETE_CATEGORY';

    case MANAGE_ROLES_AND_PERMISSION = 'MANAGE_ROLES_AND_PERMISSION';

    public function label(): string {
        return ucwords(str_replace('_',' ',strtolower($this->name)));
    }
}