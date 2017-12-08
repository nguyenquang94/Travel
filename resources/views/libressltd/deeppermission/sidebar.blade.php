
@include("layouts.elements.sidebar_item_multi_open", ["title" => "Role & Permission", "icon" => "fa fa-user ", "id" => "sidebar_dp"])
@include("layouts.elements.sidebar_item_single", ["title" => "User Role", "icon" => "fa fa-user ", "url" => "/user_role", "id" => "sidebar_dp_user_role"])
@include("layouts.elements.sidebar_item_single", ["title" => "Role", "icon" => "fa fa-user ", "url" => "/role", "id" => "sidebar_dp_role"])
@include("layouts.elements.sidebar_item_single", ["title" => "Permission", "icon" => "fa fa-user ", "url" => "/permission", "id" => "sidebar_dp_permission"])
@include("layouts.elements.sidebar_item_single", ["title" => "Group Permission", "icon" => "fa fa-user ", "url" => "/permission/group", "id" => "sidebar_dp_group_permission"])
@include("layouts.elements.sidebar_item_single", ["title" => "Setting", "icon" => "fa fa-user ", "url" => "/permission/setting", "id" => "sidebar_dp_setting

"])
@include("layouts.elements.sidebar_item_multi_close")