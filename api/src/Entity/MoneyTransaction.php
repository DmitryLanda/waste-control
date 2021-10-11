<?php

namespace App\Entity;

use App\Repository\MoneyTransactionRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpenseRepository::class)
 * @ORM\Table(name="money_transactions")
 */
class MoneyTransaction
{
    public const TYPE_INCOME = 'income';
    public const TYPE_EXPENSE = 'expense';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private float $value;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $category;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type = self::TYPE_EXPENSE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = abs($value);

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = strtolower($category);

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
