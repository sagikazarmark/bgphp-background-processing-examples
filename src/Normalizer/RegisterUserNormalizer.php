<?php

namespace BGPHP\BgProcessing\Normalizer;

use BGPHP\BgProcessing\Command\RegisterUser;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class RegisterUserNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new RegisterUser($data['emailAddress'], $data['password']);
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === RegisterUser::class;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'emailAddress' => $object->getEmailAddress(),
            'password' => $object->getPassword(),
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof RegisterUser;
    }
}
