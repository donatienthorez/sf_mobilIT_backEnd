<?php

namespace MainBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationsController extends Controller
{
    public function listAction(ParamFetcher $paramFetcher)
    {
        $responsible = $paramFetcher->get('responsible') === '1' ? $this->getUser() : null;
        $qb = $this
            ->get('pitech_main.holiday_request.helper')
            ->getHolidaysQueryBuilder($responsible);

        $paginatedHolidayRequests = $this
            ->get('pitech_main.paginator')
            ->paginateData('PitechMainBundle:HolidayRequest', $paramFetcher, 'holidayrequest', $qb);

        $paginatedHolidayRequests->setItems(
            $this
                ->get('pitech_main.holiday_request.adapter')
                ->getModels($paginatedHolidayRequests->getItems())
        );

        return $paginatedHolidayRequests;
    }
}
