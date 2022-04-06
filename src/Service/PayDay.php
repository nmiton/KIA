<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;

class PayDay
{
    public function jourDePaye(User $u, UserRepository $ur)
    {
        $now = new DateTime();
        if ($u->getLastPayDay() == null) {
            $u->setMoney($u->getMoney() + 300);
            $u->setLastPayDay($now);
            $ur->add($u);
        }
        $interval = $now->diff($u->getLastPayDay());
        if ($interval->days > 0) {
            $u->setMoney($u->getMoney() + 300);
            $u->setLastPayDay($now);
            $ur->add($u);
        }
    }
}
