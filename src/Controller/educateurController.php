<?php 

class educateurController extends Controller
{
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
