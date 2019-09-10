<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 06.09.2019
 * Time: 13:43
 */

use App\Models\Users;
use App\Models\Types;

class SeederController extends ControllerBase
{
        public function seeding()
        {
            $type1 = new Types();
            $type1->save(['type' => 'admin'], ['type']);
            $type2 = new Types();
            $type2->save(['type' => 'client'], ['type']);

            for($i = 1; $i <= 6; $i++) {
                $user = new Users();
                $userArrData = [
                    'firstName' => 'user' . $i . '-fst_name',
                    'lastName' => 'luser' . $i . '-lst_name',
                    'email' => 'user' . $i . '@example.com',
                    'password' => $this->security->hash('user' . $i . '@example.com'),
                    'type_id' => $i > 3 ? 2 : 1,
                ];
                $user->save($userArrData, array_keys($userArrData));
                $user->setPassword($this->security->hash($userArrData['password']));
            }

            for($i = 1; $i <= 6; $i++) {
                $k = rand(1, 5);
                for ($j = 1; $j <= $k; $j++) {
                    $addressesData = [
                        'city' => 'city' . $i . '-' . $j,
                        'postcode' => rand(10000, 99999),
                        'region' => 'region' . $i . '-' . $j,
                        'street' => 'street' . $i . '-' . $j,
                        'user_id' => $i,
                    ];
                    $address = new Addresses();
                    $address->save($addressesData, array_keys($addressesData));
                }
            }
        }
}