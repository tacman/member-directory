<?php

namespace App\Request;

use App\Entity\MemberStatus;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Survos\CoreBundle\Entity\RouteParametersInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class AppValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        // get the argument type (e.g. BookingId)
        $argumentType = $argument->getType();
        if (! is_subclass_of($argumentType, RouteParametersInterface::class)) {
            return [];
        }
        $shortName = (new \ReflectionClass($argumentType))->getShortName();
        $idField = lcfirst($shortName) . 'Id'; // e.g. memberStatusId

        if ($request->attributes->has($idField)) {
            $idFieldValue = $request->attributes->get($idField);
        } else {
            $idFieldValue = null;
            $this->logger->warning(sprintf("%s not found in %s", $idField, $argumentType));
        }

        switch ($argumentType) {
            case MemberStatus::class:
                $repository = $this->entityManager->getRepository($argumentType);
                // Find the entity by its uniqueParameters.
                $value = $repository->findOneBy(['code' => $idFieldValue]);
                break;
            default:
                $value = null;
        }

        $request->attributes->set($argument->getName(), $value);
        return [$value];
    }

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger
    ) {
    }
}
