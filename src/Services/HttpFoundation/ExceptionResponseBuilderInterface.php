<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 10:50
 */

namespace App\Services\HttpFoundation;


use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package App\Services\HttpFoundation
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface ExceptionResponseBuilderInterface
{

    /** @var string */
    const MESSAGE = 'An exception occurred in kernel.';

    /**
     * @param \Exception $exception
     * @return JsonResponse
     */
    function build(\Exception $exception): JsonResponse;

}
