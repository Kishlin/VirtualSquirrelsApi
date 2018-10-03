<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:10
 */

namespace CoreBundle\Manager;


use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;

/**
 * @package CoreBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
abstract class BaseManager
{

    /** @var LoggerInterface */
    protected $logger;
    /** @var ObjectManager */
    protected $objectManager;

    /**
     * @param LoggerInterface $logger
     * @param ObjectManager   $objectManager
     */
    public function __construct(LoggerInterface $logger, ObjectManager $objectManager)
    {
        $this->logger = $logger;
        $this->objectManager = $objectManager;
    }

    protected function doFlush()
    {
        $this->logger->debug('Flushing entities.', array('method' => 'doFlush', 'class' => self::class));

        $this->objectManager->flush();
    }

}