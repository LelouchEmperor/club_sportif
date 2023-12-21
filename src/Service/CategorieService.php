<?php
// src/Service/CategorieService.php
class CategorieService
{
    private $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    public function getAllCategories()
    {
        return $this->categorieRepository->findAll();
    }

    public function getCategoryById($id)
    {
        return $this->categorieRepository->find($id);
    }

    public function saveCategory(Categorie $categorie)
    {
        $this->categorieRepository->save($categorie);
    }

    public function deleteCategory(Categorie $categorie)
    {
        $this->categorieRepository->delete($categorie);
    }
}
