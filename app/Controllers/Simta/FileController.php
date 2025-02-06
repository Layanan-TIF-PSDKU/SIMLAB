<?php

namespace App\Controllers\Simta;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class FileController extends BaseController
{
    use ResponseTrait;

    public function uploadproposalwal()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/ujianproposal/proposalawal/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function uploadtranskripnilai()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/ujianproposal/transkrip_nilai/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function revisiproposalwal()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/ujianproposal/revisi_proposal/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function uploadproposalsemhas()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/seminarhasil/proposal/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function uploadberitaacara()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/seminarhasil/berita_acara/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function uploadpersetujuandosen()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/seminarhasil/persetujuan_dosen/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function revisiproposalsemhas()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/seminarhasil/revisi_proposal/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function uploadproposalakhir()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/ujianta/proposalakhir/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }
    public function uploadberitaacarakmm()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/ujianta/berita_acarakmm/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }
    public function uploadkrs()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/ujianta/krs/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }
    public function uploadtranskripnilaita()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/ujianta/transkrip_nilai/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }
    public function uploadrekomendasidosen()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/ujianta/rekomendasi_dospem/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function revisiproposalakhir()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/ujianta/revisi_proposal/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }
    public function laporanlengkap()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/persyaratanlulus/laporan_lengkap/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function halamanpengesahan()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/persyaratanlulus/halaman_pengesahan/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function halamanpersetujuan()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/persyaratanlulus/halaman_persetujuan/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }
    public function manualbook()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/persyaratanlulus/manual_book/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }
    public function ktp()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('simta_assets/persyaratanlulus/ktp/', $newName);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'file_name' => $newName,
            ]);
        } else {
            return $this->failValidationError($file->getErrorString());
        }
    }

    public function download($fileName)
    {
        $file = 'simta_assets/proposalawal/' . $fileName;

        if (is_file($file)) {
            return $this->response->download($file, null);
        } else {
            return $this->failNotFound('File not found');
        }
    }
}