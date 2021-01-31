<?php

namespace App\Controllers;

use App\Models\Users;
use Config\Services;

//INGAT HARUS EXTENDS BASECONTROLLER
class UsersController extends BaseController
{
  protected $users;
  public function __construct()
  {
    $this->users = new Users();
  }
  public function index()
  {
    //buat akses halaman tanpa cari
    $user = $this->users;
    if ($this->request->getVar('searchKeyword')) {
      $user = $this->users->search($this->request->getVar('searchKeyword'));
    }

    $currentPage = $this->request->getVar('page_users') ? $this->request->getVar('page_users') : 1;
    $countItem = 3;
    $data = [
      'title' => 'Data users',
      //ambil semua
      // 'users' => $this->users->findAll(),

      //pagination tanpa cari
      // 'users' => $this->users->paginate($countItem, 'users'),

      //pagination dengan cari
      'users' => $user->paginate($countItem, 'users'),
      'pager' => $this->users->pager,
      'currentPage' => $currentPage,
      'countItem' => $countItem
    ];

    return view('index', $data);
  }

  public function create()
  {
    $data = [
      'title' => 'Tambah users',
      'validation' => Services::validation()
    ];

    return view('/form', $data);
  }

  public function store()
  {
    if (!$this->validate([
      //menampilkan error default
      // 'name' => 'required|is_unique[users.name]'

      //menampilkan error custom
      'name' => [
        'rules' => 'required|is_unique[users.name]',
        'errors' => [
          'required' => '{field} harus diisi!',
          'is_unique' => '{field} sudah ada!'
        ]
      ],
      'img' => [
        'rules' => 'mime_in[img,image/jpg,image/jpeg,image/png]',
        'errors' => [
          'mime_in' => 'format tidak didukung'
        ]
      ]
    ])) {
      return redirect()->to('/user')->withInput();
    }

    $nama='';
    $img = $this->request->getFile('img');

    if (!$img->getError() == 4) {
      //jika menggunakan nama asli file(ci otomatis rename
      //penomoran apabila ada yang sama)
      //bebas mo pindah dlu atau set nama dlu
      // $img->move('storage/img');
      // $nama = $img->getName();
  
      //use random name
      //posisi harus sama
      $nama = $img->getRandomName();
      $img->move('storage/img', $nama);
    }
    
    //BUDAYAKAN SEBELUM SAVE CEK MODEL DULU
    //SUDAH DITAMBAH BELOM FILENYA
    $this->users->save([
      'name' => $this->request->getVar('name'),
      'address' => $this->request->getVar('address'),
      'photo' => $nama
    ]);

    session()->setFlashdata('flash', 'berhasil');
    
    return redirect()->to('/');
  }

  public function edit($id)
  {
    $data = [
      'title' => 'Edit users',
      'user' => $this->users->getUser($id),
      'validation' => Services::validation()
    ];

    return view('/form', $data);
  }

  public function update($id, $nama = '')
  {
    $rulesName = 'required';
    $lastName = $this->users->getLastName($id);
    if ($lastName->name == $this->request->getVar('name')) {
      $rulesName = 'required|is_unique[users.name]';
    }


    if (!$this->validate([
      //menampilkan error default
      // 'name' => 'required|is_unique[users.name]'

      //menampilkan error custom
      'name' => [
        'rules' => $rulesName,
        'errors' => [
          'required' => '{field} harus diisi!',
          'is_unique' => '{field} sudah ada!'
        ]
      ],
      'img' => [
        'rules' => 'mime_in[img,image/jpg,image/jpeg,image/png]',
        'errors' => [
          'mime_in' => 'format tidak didukung'
        ]
      ]
    ])) {
      return redirect()->to('/user/'.$id)->withInput();
    }


    $nama=$nama;
    $img = $this->request->getFile('img');

    if (!$img->getError() == 4) {
      //jika menggunakan nama asli file(ci otomatis rename
      //penomoran apabila ada yang sama)
      //bebas mo pindah dlu atau set nama dlu
      // $img->move('storage/img');
      // $nama = $img->getName();
  
      //use random name
      //posisi harus sama
      $nama = $img->getRandomName();
      $img->move('storage/img', $nama);
    }

    //BUDAYAKAN SEBELUM SAVE CEK MODEL DULU
    //SUDAH DITAMBAH BELOM FILENYA
    $this->users->save([
      'id' => $id,
      'name' => $this->request->getVar('name'),
      'address' => $this->request->getVar('address'),
      'photo' => $nama
    ]);

    session()->setFlashdata('flash', 'berhasil');
    
    return redirect()->to('/');
  }

  public function destroy($id, $gambar = '')
  {
    $this->users->delete($id);

    if($gambar != ''){
      unlink("storage/img/".$gambar);
    }

    return redirect()->to('/');
  }
}
