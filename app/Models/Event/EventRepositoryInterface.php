<?php

namespace App\Models\Event;

interface EventRepositoryInterface
{
    public function getAllOrders();
    public function getEventById(int $eventId);
    public function deleteOrder($orderId);
    public function createOrder(array $orderDetails);
    public function updateOrder($orderId, array $newDetails);
    public function getFulfilledOrders();
}
