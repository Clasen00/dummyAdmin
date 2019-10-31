<?php

class IndexController extends Controller
{
    public function index()
    {
        $home = $this->model('User');

        $this->view('home', ['title' => $home->title]);
    }
}