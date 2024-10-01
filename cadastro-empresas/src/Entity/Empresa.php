<?php

namespace App\Entity;

use App\Repository\EmpresaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
class Empresa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $cnpj = null;

    #[ORM\Column(length: 255)]
    private ?string $endereco = null;

    #[ORM\OneToMany(mappedBy: 'empresa', targetEntity: Socio::class, cascade: ['persist', 'remove'])]
    private $socios;

    /**
     * @var Collection<int, Socio>
     */
    #[ORM\OneToMany(targetEntity: Socio::class, mappedBy: 'empresa', orphanRemoval: true)]
    private Collection $y;

    public function __construct()
    {
        $this->y = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): static
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): static
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * @return Collection<int, Socio>
     */
    public function getY(): Collection
    {
        return $this->y;
    }

    public function addY(Socio $y): static
    {
        if (!$this->y->contains($y)) {
            $this->y->add($y);
            $y->setEmpresa($this);
        }

        return $this;
    }

    public function removeY(Socio $y): static
    {
        if ($this->y->removeElement($y)) {
            if ($y->getEmpresa() === $this) {
                $y->setEmpresa(null);
            }
        }

        return $this;
    }

    public function getSocios()
    {
        return $this->socios;
    }

    public function setSocios($socios)
    {
        $this->socios = $socios;
    }
}
