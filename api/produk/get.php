<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Method: GET");
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../../data/produk.php";

$request = $_SERVER['REQUEST_METHOD'];

$db = new Database();
$conn = $db->connection();

$produk = new produk($conn);
$produk->id = isset($_GET["id"]) ? $_GET["id"] : die();

$produk->get();

$response = [];

if ($request == "GET") {
    if ($produk->id != null) {
        $data = array("id" => $produk->id, "gambar" => $produk->gambar, "nama" => $produk->nama, "deskripsi" => $produk->deskripsi,);
        $response = array("status" => array("message" => "Success", "code" => http_response_code(200)), "data" => $data);
    } else {
        http_response_code(404);
        $response = array("status" => array("message" => "Data Not Found", "code" => http_response_code()));
    }
} else {
    http_response_code(405);
    $response = array("status" => array("message" => "Method Not Allowed", "code" => http_response_code()));
}

echo json_encode($response);
