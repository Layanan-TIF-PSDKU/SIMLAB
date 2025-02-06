<?php

namespace App\Libraries;
use Myth\Auth\Authorization\AuthorizeInterface;

class MyAuthorize implements AuthorizeInterface
{
    public function inGroup($groups, int $userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('auth_groups_users');

        $builder->select('group_id')
                ->where('user_id', $userId);

        $result = $builder->get()->getResultArray();

        $userGroups = [];
        foreach ($result as $row) {
            $userGroups[] = $row['group_id'];
        }

        if (is_string($groups)) {
            $groups = [$groups];
        }

        return count(array_intersect($groups, $userGroups)) > 0;
    }
}
?>