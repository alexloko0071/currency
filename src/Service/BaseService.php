<?php

namespace App\Service;


use App\DTO\EuroDto;
use App\Entity\CurrencyEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class BaseService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EuroDto
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getEuroValue(): EuroDto
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('cur, type')
            ->from(CurrencyEntity::class, 'cur')
            ->join('cur.formatType', 'type')
            ->orderBy('cur.order')
            ->getQuery();

        /** @var CurrencyEntity[] $euros */
        $euros = $query->getResult();

        $euroDto = new EuroDto();

        foreach ($euros as $euro) {
            $parserService = $euro->getFormatType()->getParserService();

            if ($parserService->getDataFromUrl($euro->getUrl()) === false) {
                continue;
            } else {
                $euroDto->id = $euro->getId();
                $euroDto->value = $parserService->getValue($euro->getUrl());

                break;
            }
        }

        if (empty($euroDto->id)) {
            throw new EntityNotFoundException('No available resources ');
        }

        return $euroDto;
    }

    /**
     * @param int $id
     * @param int $orderNumber
     * @throws \Exception
     */
    public function setOrderNumber(int $id, int $orderNumber)
    {
        try {
            $query = $this->entityManager->createQueryBuilder()
                ->select('cur')
                ->from(CurrencyEntity::class, 'cur')
                ->orderBy('cur.order')
                ->getQuery();

            /** @var CurrencyEntity[] $currencies */
            $currencies = $query->getResult();

            $currentCurrencies = array_values(array_filter(
                $currencies, function ($item) use ($id) {
                    /** @var CurrencyEntity $item */
                    return ($item->getId() === $id);
                }
            ));

            if (empty($currentCurrencies)) {
                throw new EntityNotFoundException('currency is not found');
            }
            /** @var CurrencyEntity $currentCurrency */
            $currentCurrency = $currentCurrencies[0];

            /** в зависимости от направления (из 1 в 3 или из 3 в 1 напр.) делаем соотв. логику */
            foreach ($currencies as $currency) {
                if ($currentCurrency->getOrder() > $orderNumber) {
                    if ($currency->getOrder() >= $orderNumber && $currency->getOrder() < $currentCurrency->getOrder()) {
                        $currency->setOrder($currency->getOrder() + 1);
                    }
                } else {
                    if ($currency->getOrder() <= $orderNumber && $currency->getOrder() > $currentCurrency->getOrder()) {
                        $currency->setOrder($currency->getOrder() - 1);
                    }
                }
            }

            $currentCurrency->setOrder($orderNumber);
            $this->entityManager->persist($currentCurrency);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception('Ошибка при сохранении');
        }
    }
}