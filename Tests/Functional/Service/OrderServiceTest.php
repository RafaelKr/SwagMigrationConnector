<?php
/**
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagMigrationConnector\Tests\Functional\Service;

use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    public function test_read_orders_should_be_successful()
    {
        $orderService = Shopware()->Container()->get('swag_migration_connector.service.order_service');

        $orders = $orderService->getOrders();

        $this->assertCount(2, $orders);

        $this->assertArrayHasKey('attributes', $orders[0]);
        $this->assertArrayHasKey('_locale', $orders[0]);
        $this->assertArrayHasKey('customer', $orders[0]);
        $this->assertArrayHasKey('billingaddress', $orders[0]);
        $this->assertArrayHasKey('shippingaddress', $orders[0]);
        $this->assertArrayHasKey('payment', $orders[0]);
        $this->assertArrayHasKey('details', $orders[0]);
    }

    public function test_read_orders_with_offset_should_be_successful()
    {
        $orderService = Shopware()->Container()->get('swag_migration_connector.service.order_service');

        $orders = $orderService->getOrders(1);

        $this->assertCount(1, $orders);

        $order = $orders[0];

        $this->assertSame('57', $order['id']);
        $this->assertSame('20002', $order['ordernumber']);
        $this->assertSame('4', $order['payment']['id']);
    }

    public function test_read_orders_with_limit_should_be_successful()
    {
        $orderService = Shopware()->Container()->get('swag_migration_connector.service.order_service');

        $orders = $orderService->getOrders(0, 2);

        $this->assertCount(2, $orders);

        $order = $orders[0];
        $this->assertSame('15', $order['id']);
        $this->assertSame('19.00', $order['details'][1]['tax']['tax']);

        $order = $orders[1];
        $this->assertSame('57', $order['id']);
        $this->assertSame('19.00', $order['details'][1]['tax']['tax']);
    }

    public function test_read_orders_with_offset_and_limit_should_be_successful()
    {
        $orderService = Shopware()->Container()->get('swag_migration_connector.service.order_service');

        $orders = $orderService->getOrders(2, 1);

        $this->assertCount(0, $orders);
    }

    public function test_read_with_out_of_bounds_offset_should_offer_empty_array()
    {
        $orderService = Shopware()->Container()->get('swag_migration_connector.service.order_service');

        $orders = $orderService->getOrders(30);

        $this->assertEmpty($orders);
    }
}
