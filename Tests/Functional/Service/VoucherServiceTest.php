<?php
/**
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagMigrationConnector\Tests\Functional\Service;

use PHPUnit\Framework\TestCase;

class VoucherServiceTest extends TestCase
{
    public function testReadShouldBeSuccessful()
    {
        $service = Shopware()->Container()->get('swag_migration_connector.service.voucher_service');

        $vouchers = $service->getVouchers();

        static::assertCount(4, $vouchers);

        $voucher = $vouchers[0];

        static::assertSame([
            'id' => '1',
            'description' => 'Absoluter Gutschein',
            'vouchercode' => 'absolut',
            'numberofunits' => '100',
            'value' => '5',
            'minimumcharge' => '25',
            'shippingfree' => '0',
            'bindtosupplier' => null,
            'valid_from' => null,
            'valid_to' => null,
            'ordercode' => 'GUTABS',
            'modus' => '0',
            'percental' => '0',
            'numorder' => '1',
            'customergroup' => null,
            'restrictarticles' => '',
            'strict' => '0',
            'subshopID' => null,
            'taxconfig' => 'auto',
            'customer_stream_ids' => null,
        ], $voucher);
    }

    public function testReadWithOffsetShouldBeSuccessful()
    {
        $service = Shopware()->Container()->get('swag_migration_connector.service.voucher_service');

        $data = $service->getVouchers(1);

        static::assertCount(3, $data);
    }

    public function testReadWithLimitShouldBeSuccessful()
    {
        $service = Shopware()->Container()->get('swag_migration_connector.service.voucher_service');

        $data = $service->getVouchers(0, 1);

        static::assertCount(1, $data);
    }

    public function testReadWithLimitAndOffsetShouldBeSuccessful()
    {
        $service = Shopware()->Container()->get('swag_migration_connector.service.voucher_service');

        $data = $service->getVouchers(1, 1);

        static::assertCount(1, $data);
    }

    public function testReadWithOutOfBoundsOffsetShouldOfferEmptyArray()
    {
        $service = Shopware()->Container()->get('swag_migration_connector.service.voucher_service');

        $data = $service->getVouchers(10);

        static::assertEmpty($data);
    }
}
