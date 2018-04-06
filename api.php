<?php
header('Content-Type: application/json');
require_once "_init.php";

$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : '';
$places = new Place();
$return = [
    'status' => 'ok',
    'data'   => []
];

switch ($method) {
    case 'add':
        $places->add(json_decode($_REQUEST['place'], true));
        break;
    case 'setPlaces':
        foreach ($_POST['places'] as $place) {
            $places->add($place);
        }
        break;

    case 'getAll':
        $return['data'] = $places->getAll();
        break;
    default:
        $return['status'] = 'error';
        break;
}

echo json_encode($return);
