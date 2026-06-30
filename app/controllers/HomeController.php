<?php

class HomeController extends Controller {

    public function index(): void {
        $this->view('home/index', [
            'isLoggedIn' => $this->isLoggedIn(),
            'userName'   => Session::get('user_nama'),
        ]);
    }
}
