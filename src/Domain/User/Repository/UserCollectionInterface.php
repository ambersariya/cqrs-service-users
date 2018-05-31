<?php
/**
 * Created by PhpStorm.
 * User: Danish Javed
 * Date: 31/05/2018
 * Time: 10:35
 */

namespace App\Domain\User\Repository;


interface UserCollectionInterface
{

    public function existsEmail($email);
}