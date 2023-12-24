<?php

#[Route('/licencie')] // Route pour accéder aux licencies

class licencieController extends Controller
{

    public function __construct(private readonly)
    {
        $this->folder = "licencie";
    }
    public function index()
    {
        $this->render("index");
    }
    public function add()
    {
        $this->render("add");
    }
    public function edit()
    {
        $this->render("edit");
    }
    public function delete()
    {
        $this->render("delete");
    }


}