<?php

declare(strict_types=1);

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TailwindFieldExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('row_attr', ['class' => 'mb-4']);
        $resolver->setDefault('label_attr', ['class' => 'block text-sm font-medium text-gray-700 mb-1']);
        $resolver->setNormalizer(
            'attr',
            function (Options $o, $value) {
                $base = [
                    'class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500',
                ];

                return array_merge($base, $value ?? []);
            },
        );
    }
}