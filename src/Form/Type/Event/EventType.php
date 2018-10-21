<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 3:32 PM
 */

namespace App\Form\Type\Event;


use App\Entity\Event\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @package App\Form\Type\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link    https://pierrelouislegrand.fr
 */
class EventType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dateTimeOptions = array('widget' => 'single_text', 'date_format' => Event::DATE_FORM_FORMAT);

        $builder
            ->add('name',      TextType::class)
            ->add('startDate', DateTimeType::class, $dateTimeOptions)
            ->add('endDate',   DateTimeType::class, $dateTimeOptions)
        ;
    }


}