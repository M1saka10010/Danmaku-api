<?php
include 'config.php';
include 'db.php';
if (!isset($_POST['type'])) {
    $data = array('code' => 400, 'message' => 'Missing value of type');
    $json = json_encode($data);
    exit($json);
}
switch ($_POST['type']) {
    case "pushDanmaku":
        if (!isset($_POST['author']) || !isset($_POST['color']) || !isset($_POST['id']) || !isset($_POST['text']) || !isset($_POST['time']) || !isset($_POST['token']) || !isset($_POST['type']) || empty($_POST['author']) || empty($_POST['color']) || empty($_POST['id']) || empty($_POST['text']) || empty($_POST['time']) || empty($_POST['token'])) {
            $data = array('code' => 400, 'message' => 'Missing value(s)');
            $json = json_encode($data);
            exit($json);
        } else if (strlen($_POST['text']) > 100) {
            $data = array('code' => 403, 'message' => 'Text too long.');
            $json = json_encode($data);
            exit($json);
        } else {
            add_danmaku($_POST['author'], $_POST['color'], $_POST['id'], $_POST['text'], $_POST['time'], $_POST['token'], $_POST['type']);
            $data = array('code' => 0, 'message' => 'Push successfully');
            $json = json_encode($data);
            exit($json);
        }
        break;
    case "getDanmakus":
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            $data = array('code' => 400, 'message' => 'Missing value(s)');
            $json = json_encode($data);
            exit($json);
        } else {
            $result = search_danmaku($_POST['id']);
            if ($result) {
                $list = array();
                for ($i = 0; $i < count($result); $i++) {
                    $list[$i] = array($result[$i]['time'], $result[$i]['type'], $result[$i]['color'], $result[$i]['author'], $result[$i]['text']);
                }
                $data = array('code' => 0, 'data' => $list);
            } else {
                $data = array('code' => 404, 'message' => 'ID not found');
            }
            $json = json_encode($data);
            exit($json);
        }
        break;
    default:
        $data = array('code' => 400, 'message' => 'Wrong value of type');
        $json = json_encode($data);
        exit($json);
        break;
}
