<?php
require_once __DIR__ . '/../crest/crest.php';

function getUsers()
{
    $result = CRest::call('user.get', [
        'select' => ['*', 'UF_*'],
    ]);
    $users = $result['result'];

    return $users;
}
function get_filtered_users($filter = [], $select = [], $order = [])
{
    $result = CRest::call('user.get', [
        'filter' => $filter,
        'select' => $select ?? ['*', 'UF_*'],
        'order' => $order,
    ]);
    $users = $result['result'];

    return $users;
}

function get_user_fields()
{
    $result = CRest::call('user.fields', ['select' => ['*', 'UF_*']]);

    return $result['result'];
}

function get_custom_user_fields()
{
    $result = CRest::call('user.userfield.list');

    return $result;
}

function getUser($user_id)
{
    $result = CRest::call('user.get', ['ID' => $user_id]);
    $user = $result['result'][0];

    return $user;
}

function getCurrentUser()
{
    $result = CRest::call('user.current');
    $user = $result['result'];

    return $user;
}
