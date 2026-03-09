<?php
namespace Models;
class Category extends Model implements CrudInterface
{
    private $table = "categories";
    // CREATE: Tambah kategori baru
    public function create($data)
    {
        $nama = $this->conn->real_escape_string($data['nama_kategori']);
        $query = "INSERT INTO {$this->table} (nama_kategori) 
                  VALUES ('$nama')";
        return $this->conn->query($query);
    }
    // READ: Ambil semua kategori (menggunakan do-while)
    public function read()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY nama_kategori ASC";
        $result = $this->conn->query($query);
        $categories = [];
        // Menggunakan do-while: jalankan minimal 1 kali selama ada data
        if ($result->num_rows > 0) {
            do {
                $row = $result->fetch_assoc();
                if ($row)
                    $categories[] = $row;
            } while ($row);
        }
        return $categories;
    }
    // UPDATE: Edit nama kategori
    public function update($id, $data)
    {
        $nama = $this->conn->real_escape_string($data['nama_kategori']);
        $id = (int)$id;
        $query = "UPDATE {$this->table} 
                  SET nama_kategori='$nama' 
                  WHERE id=$id";
        return $this->conn->query($query);
    }
    // DELETE: Hapus kategori
    public function delete($id)
    {
        $id = (int)$id;
        $query = "DELETE FROM {$this->table} WHERE id=$id";
        return $this->conn->query($query);
    }
    // GET BY ID: Ambil satu kategori
    public function getById($id)
    {
        $id = (int)$id;
        $query = "SELECT * FROM {$this->table} WHERE id=$id";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }
    // COUNT: Hitung total kategori
    public function countAll()
    {
        $query = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->conn->query($query);
        return $result->fetch_assoc()['total'];
    }
}