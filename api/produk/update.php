<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: X-Requested-With');
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../../data/produk.php";

$request = $_SERVER['REQUEST_METHOD'];

$db = new Database();
$conn = $db->connection();

$produk = new produk($conn);

$data = json_decode(file_get_contents("php://input"));

$produk->id = $data->id;

$response = [];

if ($request == 'PUT') {
    if (
        !empty($data->id) &&
        !empty($data->gambar) &&
        !empty($data->nama) &&
        !empty($data->deskripsi)
    ) {
        $produk->id = $data->id;
        $produk->gambar = $data->gambar;
        $produk->nama = $data->nama;
        $produk->deskripsi = $data->deskripsi;

        $data = array(
            'id' => $produk->id,
            'gambar' => $produk->gambar,
            'nama' => $produk->nama,
            'deskripsi' => $produk->deskripsi,
        );

        if ($produk->update()) {
            $response = array(
                'status' =>  array(
                    'messsage' => 'Success', 'code' => (http_response_code(200))
                ), 'data' => $data
            );
        } else {
            http_response_code(400);
            $response = array(
                'messsage' => 'Update Failed',
                'code' => http_response_code()
            );
        }
    } else {
        http_response_code(400);
        $response = array(
            'data' => $data,
            'status' =>  array(
                'messsage' => 'Update Failed - Wrong Parameter', 'code' => http_response_code()
            )
        );
    }
} else {
    http_response_code(405);
    $response = array(
        'status' =>  array(
            'messsage' => 'Method Not Allowed', 'code' => http_response_code()
        )
    );
}

echo json_encode($response);
