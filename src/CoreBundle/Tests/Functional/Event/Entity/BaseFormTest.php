<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/21/18
 * Time: 12:36 AM
 */

namespace CoreBundle\Tests\Functional\Event\Entity;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Tests\Functional\Util\WebTestCase;

/**
 * @package CoreBundle\Tests\Functional\Event\Entity
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link    https://pierrelouislegrand.fr
 */
abstract class BaseFormTest extends WebTestCase
{

    /**
     * @return array
     */
    public function exceptionProvider(): array
    {
        $oldDate = '1993-22-11 21:00:00';

        return array(
            'no key'             => array(array(), array('data.name', 'data.startDate', 'data.endDate')),
            'blank name'         => array($this->buildParametersArray(false), array('data.name')),
            'short name'         => array($this->buildParametersArray('hi'), array('data.name')),
            'long name'          => array($this->buildParametersArray(str_repeat('a', 51)), array('data.name')),
            'blank start date'   => array($this->buildParametersArray(null, false), array('data.startDate')),
            'invalid start date' => array($this->buildParametersArray(null, 'invalid'), array('children[startDate]')),
            'old start date'     => array($this->buildParametersArray(null, $oldDate), array('children[startDate]')),
            'blank end date'     => array($this->buildParametersArray(null, null, false), array('data.endDate')),
            'invalid end date'   => array($this->buildParametersArray(null, null, 'invalid'), array('children[endDate]')),
            'old end date'       => array($this->buildParametersArray(null, null, $oldDate), array('children[endDate]')),
            'date order'         => array($this->buildParametersArray(null, '2100-01-02 00:00:00', '2100-01-01 00:00:00'), array('data.endDate')),
        );
    }

    /**
     * @param null|mixed $name
     * @param null|mixed $startDate
     * @param null|mixed $endDate
     * @return array
     */
    protected function buildParametersArray($name = null, $startDate = null, $endDate = null): array
    {
        $data = array();

        $format = Event::DATE_FORMAT;
        $dt     = new \DateTime('now');
        $startDate === null && $startDate = (clone $dt)->setTime(21,  0,  0)->format($format);
        $endDate   === null && $endDate   = (clone $dt)->setTime(23, 59, 59)->format($format);
        $name      === null && $name      = 'event';

        $name      === false || $data['name']      = $name;
        $startDate === false || $data['startDate'] = $startDate;
        $endDate   === false || $data['endDate']   = $endDate;

        return $data;
    }

}
