<?php

use App\Class\Route;
use App\Class\Vite;
use App\Models\User;
use eftec\bladeone\BladeOne;

function view($view, $data = [], $return = false): string
{
    try {
        $views = __DIR__.DS.DSUP.DSUP.'resources'.DS.'views'.DS;
        $cache = __DIR__.DS.DSUP.DSUP.'cache';

        $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

        if ($return) {
            return $blade->run($view, $data);
        } else {
            echo $blade->run($view, $data);

            return '';
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function abort($error = '404'): void
{
    switch ($error) {
        case '400':
            view('errors.400');
            break;
        case '401':
            view('errors.401');
            break;
        case '402':
            view('errors.402');
            break;
        case '403':
            view('errors.403');
            break;
        case '404':
            view('errors.404');
            break;
        case '500':
            view('errors.500');
            break;
        default:
            echo $error;
            break;
    }
}

function env($key): ?string
{
    $file = fopen(__DIR__.DS.DSUP.DSUP.'.env', 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if (empty($line) || $line[0] == '#') {
                continue;
            }
            [$k, $v] = explode('=', $line, 2);
            $k = trim($k);
            $v = trim($v);
            if ($k == $key) {
                fclose($file);

                return $v;
            }
        }
        fclose($file);
    }

    return null;
}

function css($address): string
{
    return Vite::css($address);
}

function js($address): string
{
    return Vite::js($address);
}

function dd($data, $die = true): void
{
    function formatData($data, $level = 0): string
    {
        $html = '';
        if (is_array($data) || is_object($data)) {
            $html .= '<div dir="ltr">';
            $html .= "<span class='dd-toggle' style='color: #FF8400; cursor: pointer;' onclick='toggleContent(this)'>[+]</span> ";
            $html .= "<span style='color: #B0BEC5;'>";
            $html .= (is_array($data) ? 'Array' : 'Object').' ('.count((array) $data).')';
            $html .= '</span>';
            $html .= "<div class='dd-content' style='display: none;'>";
            foreach ($data as $key => $value) {
                $html .= "<div><span style='color: #FF8400;'>{$key}</span> => ".formatData($value, $level + 1).'</div>';
            }
            $html .= '</div></div>';
        } elseif (is_bool($data)) {
            $html .= "<span style='color: #4CAF50;'>".($data ? 'true' : 'false').'</span>';
        } elseif (is_null($data)) {
            $html .= "<span style='color: #D32F2F;'>null</span>";
        } else {
            $html .= "<span style='color: #00c3e6;'>".htmlspecialchars((string) $data, ENT_QUOTES, 'UTF-8').'</span>';
        }

        return $html;
    }

    $formattedData = formatData($data);

    $template = "
        <style>
            .dd-container {
                padding: 15px 10px;
                background-color: #18171b;
                color: #b1b1b1;
                font-family: 'Consolas', 'Monaco', monospace;
                font-size: 14px;
                border-radius: 10px;
                margin-bottom: 20px;
                box-shadow: 0 3px 15px -5px black;
                word-wrap: break-word;
            }
            .dd-toggle {
                cursor: pointer;
                color: #FF8400;
                margin-right: 5px;
            }
            .dd-content {
                margin-left: 25px;
            }
            .dd-content>div {
                display: flex;
                gap: 3px;
                margin-top: 2px;
            }
            
        </style>
        <div class='dd-container'>
            {$formattedData}
        </div>
        <script>
            function toggleContent(element) {
                const content = element.parentElement.querySelector('.dd-content');
                if (content.style.display === 'none') {
                    content.style.display = 'block';
                    element.textContent = '[-]';
                } else {
                    content.style.display = 'none';
                    element.textContent = '[+]';
                }
            }
        </script>
    ";

    echo $template;

    if ($die) {
        exit();
    }
}

function asset($path): string
{
    $baseUrl = env('APP_URL');
    if (! str_starts_with($path, '/')) {
        $path = '/'.$path;
    }

    return $baseUrl.$path;
}

function in_route(): string
{
    if (str_ends_with(env('APP_URL').Flight::request()->url, '/')) {
        return substr(env('APP_URL').Flight::request()->url, 0, strlen(env('APP_URL').Flight::request()->url) - 1);
    } else {
        return env('APP_URL').Flight::request()->url;
    }
}

function route($key): string
{
    return Route::get($key);
}

function user(): mixed
{
    $token = $_COOKIE['token'];
    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM tokens WHERE `token` = :token');
    $stmt->execute([':token' => $token]);
    $token_result = $stmt->fetchAll();
    $token_result = end($token_result)['user_id'];

    return User::find(intval($token_result));
}

function api_user(): mixed
{
    $token = getallheaders()['Authorization'];
    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM tokens WHERE `token` = :token');
    $stmt->execute([':token' => $token]);
    $token_result = $stmt->fetchAll();
    $token_result = end($token_result)['user_id'];

    return User::find(intval($token_result));
}

/**
 * @throws \Random\RandomException
 */
function uuid(): string
{
    $b = random_bytes(16);
    $b[6] = chr(ord($b[6]) & 0x0F | 0x40);
    $b[8] = chr(ord($b[8]) & 0x3F | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($b), 4));
}

function chunck_data($table): array
{
    $chunkSize = 50;
    $lastId = 0;
    $allData = [];
    $conn = Flight::db();

    while (true) {
        $stmt = $conn->prepare("SELECT * FROM $table WHERE id > :lastId ORDER BY id ASC LIMIT :chunkSize");
        $stmt->bindValue(':lastId', $lastId, PDO::PARAM_INT);
        $stmt->bindValue(':chunkSize', $chunkSize, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0) {
            break;
        }

        foreach ($result as $row) {
            $allData[] = $row;
            $lastId = $row['id'];
        }
    }

    return $allData;
}
