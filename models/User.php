<?php
namespace Models;
class User extends Model {
    private $table = "users";
    // LOGIN: cek username & password
    public function login($username, $password){
        $username = $this->conn->real_escape_string($username);
        $password = $this->conn->real_escape_string($password);
        $query = "SELECT * FROM {$this->table} 
                  WHERE username='$username' AND password='$password'";
        
        $result = $this->conn->query($query);
        if($result->num_rows > 0){
            return $result->fetch_assoc(); // kembalikan data user
        }
        return false; // login gagal
    }
    // REGISTER: daftarkan user baru (role default: pelanggan)
    public function register($data){
        $username = $this->conn->real_escape_string($data['username']);
        $password = $this->conn->real_escape_string($data['password']);
        $query = "INSERT INTO {$this->table} (username, password, role) 
                  VALUES ('$username', '$password', 'pelanggan')";
        return $this->conn->query($query);
    }
    // Hitung total user
    public function countAll(){
        $query = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->conn->query($query);
        return $result->fetch_assoc()['total'];
    }
}