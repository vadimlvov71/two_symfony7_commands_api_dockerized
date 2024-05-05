<?php

namespace App\Validations;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * [Validation of crud OPENAPI]
 */
class Validation
{
    /**
     * @param string $condition
     * @param null|int $user_id
     * 
     * @return Collection
     */
    public static function getConstrains($condition = "all", $database_group_name = null): Collection
    {
        //if ($condition == "edit") {
            $constraints = new Assert\Collection([
                'name' => [
                    new Assert\NotBlank()
                ],
                'email' => [
                    new Assert\Email()
                ],
                'group_name' => [
                    new Assert\NotBlank(),
                   // new Assert\EqualTo($database_group_name)
                ],
               
               
            ]);
            /*
        } else if ($condition == "delete") {
            $constraints = new Assert\Collection([
                'user_id' => [
                    new Assert\IdenticalTo($user_id)
                ],
                'status' => [
                    new Assert\IdenticalTo("todo")
                ],
            ]);
        } else if ($condition == "status") {
            $constraints = new Assert\Collection([
                'id' => [
                    new Assert\NotBlank()
                ],
                'user_id' => [
                    new Assert\IdenticalTo($user_id)
                ],
                'status' => [
                    new Assert\Optional()
                ],
            ]);
        } else {
            $constraints = new Assert\Collection([
                'title' => [
                    new Assert\NotBlank()
                ],
                'description' => [
                    new Assert\NotBlank()
                ],
                'user_id' => [
                    new Assert\NotBlank()
                ],
                'priority' => [
                    new Assert\Type('int'),
                    new Assert\GreaterThan(0),
                    new Assert\LessThanOrEqual(5)
                ],
                'status' => [
                    new Assert\Choice(['todo', 'done'])
                ],
                'parent_id' => [
                    new Assert\Optional()
                ]
            ]);
        }
        */
        return  $constraints;
    }
}