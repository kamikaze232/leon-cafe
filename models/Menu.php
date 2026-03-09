<?php
namespace Models;
class Menu extends Model implements CrudInterface
{
    private $table = "menu";
    // READ: Ambil semua menu + nama kategori-nya (JOIN)
    public function read()
    {
        $query = "SELECT menu.*, categories.nama_kategori 
                  FROM {$this->table} 
                  LEFT JOIN categories ON menu.kategori_id = categories.id
                  ORDER BY menu.id DESC";
        $result = $this->conn->query($query);
        $menus = [];
        while ($row = $result->fetch_assoc()) {
            $menus[] = $row;
        }
        return $menus;
    }
    // GET BY ID: Ambil satu menu
    public function getById($id)
    {
        $id = (int)$id;
        $query = "SELECT menu.*, categories.nama_kategori 
                  FROM {$this->table} 
                  LEFT JOIN categories ON menu.kategori_id = categories.id
                  WHERE menu.id=$id";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }
    // GET BY CATEGORY: Filter menu berdasarkan kategori
    public function getByCategory($kategori_id)
    {
        $kategori_id = (int)$kategori_id;
        $query = "SELECT menu.*, categories.nama_kategori 
                  FROM {$this->table} 
                  LEFT JOIN categories ON menu.kategori_id = categories.id
                  WHERE menu.kategori_id = $kategori_id
                  ORDER BY menu.id DESC";
        $result = $this->conn->query($query);
        $menus = [];
        while ($row = $result->fetch_assoc()) {
            $menus[] = $row;
        }
        return $menus;
    }
    // CREATE: Tambah menu baru (sekarang ada kategori_id)
    public function create($data)
    {
        $nama = $this->conn->real_escape_string($data['nama_menu']);
        $deskripsi = $this->conn->real_escape_string($data['deskripsi']);
        $harga = (int)$data['harga'];
        $gambar = $this->conn->real_escape_string($data['gambar']);
        $kategori_id = (int)$data['kategori_id'];
        $query = "INSERT INTO {$this->table} 
                  (kategori_id, nama_menu, deskripsi, harga, gambar) 
                  VALUES ($kategori_id, '$nama', '$deskripsi', $harga, '$gambar')";
        return $this->conn->query($query);
    }
    // UPDATE: Edit menu (sekarang ada kategori_id)
    public function update($id, $data)
    {
        $nama = $this->conn->real_escape_string($data['nama_menu']);
        $deskripsi = $this->conn->real_escape_string($data['deskripsi']);
        $harga = (int)$data['harga'];
        $kategori_id = (int)$data['kategori_id'];
        $id = (int)$id;
        $query = "UPDATE {$this->table} 
                  SET kategori_id=$kategori_id, 
                      nama_menu='$nama', 
                      deskripsi='$deskripsi', 
                      harga=$harga 
                  WHERE id=$id";
        // Jika ada gambar baru, update juga
        if (!empty($data['gambar'])) {
            $gambar = $this->conn->real_escape_string($data['gambar']);
            $query = "UPDATE {$this->table} 
                      SET kategori_id=$kategori_id, 
                          nama_menu='$nama', 
                          deskripsi='$deskripsi', 
                          harga=$harga,
                          gambar='$gambar' 
                      WHERE id=$id";
        }
        return $this->conn->query($query);
    }
    // DELETE: Hapus menu
    public function delete($id)
    {
        $id = (int)$id;
        $query = "DELETE FROM {$this->table} WHERE id=$id";
        return $this->conn->query($query);
    }
    // COUNT: Hitung total menu
    public function countAll()
    {
        $query = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->conn->query($query);
        return $result->fetch_assoc()['total'];
    }
}