<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 10:50
 */

namespace CoreBundle\Services\HttpFoundation;


use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package CoreBundle\Services\HttpFoundation
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface ExceptionResponseBuilderInterface
{

    /**
     * @param \Exception $exception
     * @return JsonResponse
     */
    function build(\Exception $exception): JsonResponse;

}