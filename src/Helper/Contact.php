<?php

namespace Hoochicken\Module\Qlcontact\Site\Helper;

class Contact
{
    private int $id;
    private string $name;
    private string $email;
    private string $telephone;
    private string $position;
    private string $misc;
    private int $catId;
    private string $image;

    public function __construct($id, string $name, string $email, string $telephone, string $position, string $misc, int $catId, string $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->position = $position;
        $this->misc = $misc;
        $this->catId = $catId;
        $this->image = $image;
    }

    public static function init(array $data): self
    {
        return new self((int)$data['id'], $data['name'], $data['email'], $data['telephone'], $data['position'], $data['misc'], (int)$data['catid'], (string)$data['image']);
    }

    public function getMisc(): string
    {
        return $this->misc;
    }

    public function setMisc(string $misc): void
    {
        $this->misc = $misc;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCatId(): int
    {
        return $this->catId;
    }

    public function setCatId(string $catId): void
    {
        $this->catId = $catId;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function existsImage(): bool
    {
        return file_exists(JPATH_BASE . '/' . $this->image);
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
}
