<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;

class PayDay
{
    public function jourDePaye(User $u, UserRepository $ur): ?int
    {
        $now = new DateTime();
        $payValue = 300;
        if ($u->getLastPayDay() == null) {
            $u->setMoney($u->getMoney() + $payValue );
            $u->setLastPayDay($now);
            $ur->add($u);
            return "300"; 
        }
        $interval = $now->diff($u->getLastPayDay());
        if ($interval->days > 0) {
            $u->setMoney($u->getMoney() + $payValue );
            $u->setLastPayDay($now);
            $ur->add($u);
            return "300"; 
        }
        return "-1";
    }
}
