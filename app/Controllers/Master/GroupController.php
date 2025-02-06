<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use Myth\Auth\Models\GroupModel;

class GroupController extends BaseController
{
    public function __construct()
    {
        $this->group = new GroupModel();
    }

    /* Fungsi untuk menampilkan data role user pada halaman utama*/
    public function index()
    {
        $data = [
            'title' => 'Data Role | Sistem Terintegrasi D3 TI',
            'group' => $this->group->findAll()
        ];

        return view('master/group/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Data Tambah Role | Sistem Terintegrasi D3 TI',
        ];

        return view('master/group/tambah', $data);
    }

    public function create()
    {
        $this->group->insert([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        session()->setFlashdata('success', 'Data role berhasil ditambahkan');
        return redirect()->to('group')->with('status_icon', 'success')->with('status_text', 'Data role Berhasil ditambah');
    }

    public function edit($id = null)
    {
        
        $data = [
            'title' => 'Data Edit Role | Sistem Terintegrasi D3 TI',
            'group' => $this->group->find($id),
        ];

        return view('master/group/edit', $data);
    }

    public function update($id = null)
    {
        $this->group->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        session()->setFlashdata('success', 'Data role berhasil diedit');
        return redirect()->to('group')->with('status_icon', 'success')->with('status_text', 'Data role Berhasil diedit');
    }

    public function delete($id)
    {
        $this->group->delete($id);
        session()->setFlashdata('success', 'Data role berhasil dihapus');
        return redirect()->to('group')->with('status_icon', 'success')->with('status_text', 'Data role Berhasil dihapus');
    }
}