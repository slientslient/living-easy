<?php


namespace app\controller;


class Page
{
  public function index()
  {
      return View::fetch('index');
  }
}