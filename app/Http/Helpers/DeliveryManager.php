<?php

namespace App\Http\Helpers;

use App\Models\Delivery;

class DeliveryManager
{
    public static function removeDeliveryFromBrigade($delivery)
    {
        if (!is_null($delivery->brigade_id))
        {
            foreach (Delivery::where('date', $delivery->date)->where('brigade_id', $delivery->brigade_id)->get() as $sameBrigadeDelivery)
            {
                if ($sameBrigadeDelivery->order >= $delivery->order)
                {
                    $sameBrigadeDelivery->order = $sameBrigadeDelivery->order - 1;
                    $sameBrigadeDelivery->save();
                }
            }

            $delivery->brigade_id = null;
            $delivery->order = null;
            $delivery->save();
        }
    }

    public static function addDeliveryToBrigade($delivery, $brigade_id, $order)
    {
        if (!is_null($delivery->brigade_id))
        {
            //Перетянули из другой бригады
            if ($delivery->brigade_id != $brigade_id)
            {
                self::removeDeliveryFromBrigade($delivery);
            }
            else
            {
                //Просто дернули, ничего меняться не должно
                if ($delivery->order == $order)
                {
                    return;
                }
            }
        }

        foreach (Delivery::where('date', $delivery->date)->where('brigade_id', $brigade_id)->get() as $sameBrigadeDelivery)
        {
            //Новая доставка
            if (is_null($delivery->brigade_id) || is_null($delivery->order))
            {
                if ($order <= $sameBrigadeDelivery->order)
                {
                    $sameBrigadeDelivery->order = $sameBrigadeDelivery->order + 1;
                    $sameBrigadeDelivery->save();
                }

                continue;
            }

            //Перемещаем наверх
            if ($delivery->order > $order)
            {
                if ($order <= $sameBrigadeDelivery->order && $sameBrigadeDelivery->order <= $delivery->order)
                {
                    $sameBrigadeDelivery->order = $sameBrigadeDelivery->order + 1;
                    $sameBrigadeDelivery->save();
                }
            }
            //Перемещаем вниз
            else
            {
                if ($delivery->order <= $sameBrigadeDelivery->order && $sameBrigadeDelivery->order <= $order)
                {
                    $sameBrigadeDelivery->order = $sameBrigadeDelivery->order - 1;
                    $sameBrigadeDelivery->save();
                }
            }
        }

        $delivery->brigade_id = $brigade_id;
        $delivery->order = $order;
        $delivery->save();
    }
}
