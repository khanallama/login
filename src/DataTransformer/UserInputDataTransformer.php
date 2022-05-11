<?php


namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\User;

final class UserInputDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $input = new User();
        $input->setEmail($data->email);
        $input->setFirstname($data->firstname);
        $input->setLastname($data->lastname);
        $input->setPhone($data->phone);


        return $input;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        // in the case of an input, the value given here is an array (the JSON decoded).
        // if it's a book we transformed the data already
        if ($data instanceof User) {
          return false;
        }

        return User::class === $to && null !== ($context['input']['class'] ?? null);
    }
}