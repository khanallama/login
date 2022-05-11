<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\UserOutputDto;
use App\Entity\User;

final class UserOutputDataTransformer implements DataTransformerInterface
{

    public function transform($data, string $to, array $context = [])
    {
        $output = new UserOutputDto();
        $output->email = $data->getEmail();
        $output->username = $data->getUsername();
        $output->phone = $this->getMaskPhone($data);
        $output->firstname = $data->getFirstname();
        $output->lastname = $data->getLastname();
        $output->createdBy = $data->getCreatedBy();

        return $output;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return UserOutputDto::class === $to && $data instanceof User;
    }


     private function getMaskPhone($data)
    {   $number = $data->getPhone();
        $length = strlen((string)$number);

        $maskedPhone = str_repeat('*', 6) . substr($number, -4);
        return $maskedPhone;
    }
}