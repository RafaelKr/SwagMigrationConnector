<?php
/**
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__ . '/../../../../autoload.php';

class SwagMigrationConnectorTestKernel extends \Shopware\Kernel
{
    public static function start()
    {
        $kernel = new self(\getenv('SHOPWARE_ENV') ?: 'testing', true);
        $kernel->boot();

        $container = $kernel->getContainer();
        $container->get('plugins')->Core()->ErrorHandler()->registerErrorHandler(\E_ALL | \E_STRICT);

        if (!self::isPluginInstalledAndActivated()) {
            exit('Error: The plugin is not installed or activated, tests aborted!');
        }
        Shopware()->Loader()->registerNamespace('SwagMigrationConnector', __DIR__ . '/../');
    }

    /**
     * @return bool
     */
    private static function isPluginInstalledAndActivated()
    {
        /** @var \Doctrine\DBAL\Connection $db */
        $db = Shopware()->Container()->get('dbal_connection');
        $sql = "SELECT active FROM s_core_plugins WHERE name='SwagMigrationConnector'";
        $active = $db->fetchColumn($sql);

        return (bool) $active;
    }
}

SwagMigrationConnectorTestKernel::start();
