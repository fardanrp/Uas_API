<?php
class produk
{
    public $id;
    public $nama;
    public $deskripsi;
    public $gambar;

    private $conn;
    private $table = "tabel_produk";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    function fetch()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function get()
    {
        $query = "SELECT * FROM " . $this->table . " p WHERE p.id=? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $produk = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $produk["id"];
        $this->nama = $produk["nama"];
        $this->deskripsi = $produk["deskripsi"];
        $this->gambar = $produk["gambar"];
    }

    function add()
    {
        $query = "INSERT INTO
                " . $this->table . "
            SET
               id=:id, nama=:nama, deskripsi=:deskripsi, gambar=:gambar";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('nama', $this->nama);
        $stmt->bindParam('deskripsi', $this->deskripsi);
        $stmt->bindParam('gambar', $this->gambar);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function update()
    {
        $query = "UPDATE
                " . $this->table . "
            SET
                nama = :nama,
                deskripsi = :deskripsi,
                gambar = :gambar
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('nama', $this->nama);
        $stmt->bindParam('deskripsi', $this->deskripsi);
        $stmt->bindParam('gambar', $this->gambar);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
