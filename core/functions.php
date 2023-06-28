<?php

function dd($data, $showType = false): void
{
    echo "<pre style='border: 1px solid black; border-radius: 10px; background-color: black; color: white; font-size: 20px; line-height: 1.5rem; margin: 20px; padding: 10px'>";

    if ($showType) {
        var_dump($data);
    } else {
        print_r($data);
    }

    echo "</pre>";
    die();
}



function alert(string $message, string $color = "success"): string
{
    return "<div class='alert alert-$color' role='alert'> $message </div>";
}

function url(string $path = null): string
{
    $url = isset($_SERVER["HTTPS"]) ? "https" : "http";
    $url .= "://";
    $url .= $_SERVER["HTTP_HOST"];
    if (isset($path)) {
        $url .= "/";
        $url .= "$path";
    }
    return $url;
}

function view(string $viewName, array $data = null): void
{
    if (!is_null($data)) {
        foreach ($data as $key => $value) {
            ${$key} = $value;
        }
    }
    require_once ViewDir . "/$viewName.view.php";
}

function controller(string $controllerName): void
{
    $controllerArray = explode("@", $controllerName);
    require_once ControllerDir . "/$controllerArray[0].controller.php";
    call_user_func($controllerArray[1]);
}

function route(string $path, array $queries = null): string
{
    $url = url($path);
    if (!is_null($queries)) {
        $url .= "?" . http_build_query($queries);
    }
    return $url;
}

function redirect(string $url, string $message = null, string $color = "success", string $key = "status"): void
{
    if (!is_null($message)) setSession($message, $color);
    header("location:" . $url);
}

function redirectBack(string $message = null): void
{
    redirect($_SERVER["HTTP_REFERER"], $message);
}

function datetimeFormat(string $timestamp, string $format = "j F Y "): string
{
    return date($format, strtotime($timestamp));
}

function checkRequestMethod(string $methodName): bool
{
    $result = false;
    $methodName = strtoupper($methodName);
    $serverRequestMethod = $_SERVER["REQUEST_METHOD"];
    if ($methodName === "POST" && $serverRequestMethod === "POST") {
        $result = true;
    } elseif ($methodName === "PUT" && ($serverRequestMethod === "PUT" || ($serverRequestMethod === "POST" && !empty($_POST["_method"]) && strtoupper($_POST["_method"]) === "PUT"))) {
        $result = true;
    } elseif ($methodName === "DELETE" && ($serverRequestMethod === "DELETE" || ($serverRequestMethod === "POST" && !empty($_POST["_method"]) && strtoupper($_POST["_method"]) === "DELETE"))) {
        $result = true;
    }
    return $result;
}

// validation function start 

function setError(string $key, string $message): void
{
    $_SESSION["error"][$key] = $message;
}

function hasError(string $key): bool
{
    if (!empty($_SESSION["error"][$key])) return true;
    return false;
}

function showError(string $key): string
{
    $message = $_SESSION["error"][$key];
    unset($_SESSION["error"][$key]);
    return $message;
}

function old(string $key): string | null
{
    if (isset($_SESSION["old"][$key])) {
        $data = $_SESSION["old"][$key];
        unset($_SESSION["old"][$key]);
        return $data;
    }
    return null;
}

function validationStart(): void
{
    unset($_SESSION["old"]);
    unset($_SESSION["error"]);
    $_SESSION["old"] = $_POST;
}

function validationEnd(bool $isApi = false): void
{
    if (hasSession("error")) {
        if ($isApi) {
            responseJson([
                "status" => false,
                "errors" => showSession("error")
            ]);
        } else {
            redirectBack();
        }
        die();
    } else {
        unset($_SESSION["old"]);
    }
}
// validation function end 

// session function start

function hasSession(string $key = "status"): bool
{
    if (!empty($_SESSION[$key])) {
        return true;
    }
    return false;
}

function setSession(string $message, string $color = "success", string $key = "status"): void
{
    $_SESSION[$key] = [
        "message" => $message,
        "color" => $color
    ];
}

function showSession(string $key): string | array
{
    $message = $_SESSION[$key];
    unset($_SESSION[$key]);
    return $message;
}

function showSessionMessage(string $key = "status"): string
{
    $message = $_SESSION[$key]["message"];
    return $message;
}

function showSessionColor(string $key = "status"): string
{
    $color = $_SESSION[$key]["color"];
    unset($_SESSION[$key]);
    return $color;
}

// session function end

function filter(string $str, bool $strip = false): string
{
    if ($strip) {
        $str = strip_tags($str);
    }
    $str = trim($str);
    $str = htmlentities($str, ENT_QUOTES);
    return $str;
}

// database functions start
function runQuery(string $sql, bool $closeConnection = true): object | bool
{
    try {
        $query = mysqli_query($GLOBALS["conn"], $sql);
        if ($closeConnection) mysqli_close($GLOBALS["conn"]);
        return $query;
    } catch (Exception $e) {
        dd($e);
    }
}

function all(string $sql, bool $closeConnection = true): array
{
    $query = runQuery($sql, $closeConnection);
    $lists = [];
    while ($list = mysqli_fetch_assoc($query)) {
        $lists[] = $list;
    }
    return $lists;
}

function first(string $sql, bool $closeConnection = true): array
{
    $query = runQuery($sql, $closeConnection);
    $list = mysqli_fetch_assoc($query);
    return $list;
}

function createTable(string $tableName, ...$columns): void
{
    $sql = "DROP TABLE IF EXISTS $tableName";
    runQuery($sql, false) && logger($tableName . " is deleted successful.", 33);

    $sql = "CREATE TABLE $tableName (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  " . join(",", $columns) . ",
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
";
    runQuery($sql, false) && logger($tableName . " table is created successful");
}

// database functions end

// pagination function start
function paginate(string $sql, int $limit = 10): array
{
    $totalRows = first(str_replace("*", "COUNT(id) as total", $sql), false)["total"];
    $totalPages = ceil($totalRows / $limit);

    $currentPage = !empty($_GET["page"]) ? $_GET["page"] : 1;
    $offset = ($currentPage - 1) * $limit;

    $sql .= " LIMIT $offset,$limit";

    $links = [];
    for ($i = 1; $i <= $totalPages; $i++) {
        $queries = $_GET;
        $queries["page"] = $i;
        $links[] = [
            "url" => url() . $GLOBALS["path"] . "?" . http_build_query($queries),
            "is_active" => $currentPage == $i ? "active" : '',
            "page_number" => $i,
        ];
    }

    $lists = [
        "total" => $totalRows,
        "limit" => $limit,
        "total_page" => $totalPages,
        "current_page" => $currentPage,
        "data" => all($sql, false),
        "links" => $links
    ];
    return $lists;
}

function paginator($lists)
{
    $html = '<div class="d-flex justify-content-between align-items-center my-5">
    <p class="fw-bold">
      Total: ' . $lists["total"] . '
    </p>
    <nav aria-label="Search result pages">
      <ul class="pagination justify-content-end">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>';
    foreach ($lists["links"] as $link) {
        $html .= '<li class="page-item">
          <a class="page-link ' . $link["is_active"] . '" href="' . $link["url"] . '">
            ' . $link["page_number"] . '
          </a>
        </li>';
    }
    $html .= '<li class="page-item">
          <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>';
    return $html;
}
// pagination function end


// more color => https://i.stack.imgur.com/HFSl1.png
function logger(string $message, int $colorCode = 32): void
{
    $start = "\e[{$colorCode}m";
    $end = "\e[0m";
    echo " [LOG]: $start $message $end \n";
}

function responseJson(mixed $data, int $status = 200): string
{
    header("Content-type:Application/json");
    http_response_code($status);
    if (is_array($data)) {
        return print(json_encode($data));
    }
    return print(json_encode(["message" => $data]));
}
