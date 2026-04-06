<?php
// Конфигурация
define('BOT_TOKEN', '8607364179:AAGcw64Yr9JM7kIC86NzgzS8oMLomEepac8'); // Замените на токен вашего бота
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');
define('EXTERNAL_API_URL', 'http://vsk.exeptional.ru/api/helper/');

// Получаем обновления от Telegram
function getUpdates($offset = 0) {
    $url = API_URL . 'getUpdates?offset=' . $offset . '&timeout=30';
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Отправляем сообщение пользователю
function sendMessage($chatId, $message) {
    $url = API_URL . 'sendMessage';
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// Отправляем "печатает..." индикатор
function sendChatAction($chatId, $action = 'typing') {
    $url = API_URL . 'sendChatAction';
    $data = [
        'chat_id' => $chatId,
        'action' => $action
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// Запрос к внешнему API
function queryExternalApi($searchString) {
    // URL-кодируем строку запроса
    $encodedString = urlencode($searchString);
    $url = EXTERNAL_API_URL . '?searchString=' . $encodedString;

    // Выполняем запрос
    $response = file_get_contents($url);

    if ($response === false) {
        return [
            'status' => 'error',
            'error' => 'Не удалось连接到 внешнему API'
        ];
    }

    return json_decode($response, true);
}

function cleanTextForTelegram($text) {

    //меняем "</p><p>" на "\n\n"
    $text = str_replace('</p><p>', "\n\n", $text);

    //меняем "<br>" на "\n\n"
    $text = str_replace('<br>', "\n\n", $text);

    //меняем "</br>" на "\n\n"
    $text = str_replace('</br>', "\n\n", $text);

    //меняем "<p>" на ""
    $text = str_replace('<p>', "", $text);

    //меняем "<font color="#ffffff">text</font>" на "text"
    $text = preg_replace('/<font\b[^>]*>([\s\S]*?)<\/font>/i', '$1', $text);

    //меняем <span style="background-color: rgb(0, 0, 0);">text</span>  на "text"
    $text = preg_replace('/<span[^>]*>(.*?)<\/span>/i', '$1', $text);

    // Оставляем только href для ссылок
    $text = preg_replace('/<(a\s+[^>]*href="[^"]*")[^>]*>/i', '<$1>', $text);

    // Убираем пустые теги
    $text = preg_replace('/<([a-z]+)><\/\1>/i', '', $text);

    return trim($text);
}


// Форматируем ответ для пользователя
function formatResponse($data) {
    if ($data['status'] === 'error') {
        return isset($data['error']) ? $data['error'] : 'Произошла ошибка';
    }

    if ($data['status'] === 'ok') {
        if (count($data['content']) == 1) {
            $record = $data['content'][0];
            $result = "📝 <b>" . htmlspecialchars($record['subject']) . "</b>\n\n";
            $result .= cleanTextForTelegram(htmlspecialchars($record['text']));

            // Добавляем дополнительную информацию, если нужно
            if (!empty($record['keywords'])) {
                $result .= "\n\n🔑 <i>Ключевые слова: " . htmlspecialchars($record['keywords']) . "</i>";
            }

        } else {
            $result = '';
            foreach ($data['content'] as $record) {

                $textLen = 300;

                $result .= "📝 <b>" . htmlspecialchars($record['subject']) . "</b>\n\n";

                $text = cleanTextForTelegram(htmlspecialchars($record['text']));
                $xt=iconv_strlen($text, 'UTF-8');
                $tx=iconv_substr($text, 0, $textLen, 'UTF-8');
                $tx=nl2br($tx);
                if($xt>$textLen){$txx="......";} else {$txx="";}
                $result .= $tx.$txx;

                // Добавляем дополнительную информацию, если нужно
                if (!empty($record['keywords'])) {
                    $result .= "\n\n🔑 <i>Ключевые слова: " . htmlspecialchars($record['keywords']) . "</i>";
                }

                $result .= "\n\n";

                $result .= '<a href="http://vsk.exeptional.ru/helper/?id='.$record['id'].'">Полный текст</a>';

                $result .= "\n\n";
            }

        }




        return $result;
    }

    return 'Неизвестный формат ответа';
}

// Обрабатываем входящее сообщение
function processMessage($message) {
    $chatId = $message['chat']['id'];
    $text = trim($message['text']);

    // Игнорируем пустые сообщения
    if (empty($text)) {
        return;
    }

    // Показываем индикатор "печатает..."
    sendChatAction($chatId);

    // Проверяем, что пользователь написал фразу, а не команду
    if (strpos($text, '/') === 0) {
        sendMessage($chatId, "Пожалуйста, отправьте текстовый запрос. Команды не поддерживаются.");
        return;
    }

    // Запрашиваем внешнее API
    $response = queryExternalApi($text);

    if ($response === null) {
        sendMessage($chatId, "❌ Ошибка: Не удалось обработать ответ от сервера");
        return;
    }

    // Форматируем и отправляем ответ
    $formattedResponse = formatResponse($response);
    sendMessage($chatId, $formattedResponse);
}

// Основной цикл бота
function runBot() {
    $lastUpdateId = 0;

    while (true) {
        $updates = getUpdates($lastUpdateId + 1);

        if (isset($updates['result']) && !empty($updates['result'])) {
            foreach ($updates['result'] as $update) {
                $lastUpdateId = $update['update_id'];

                // Проверяем наличие сообщения
                if (isset($update['message'])) {
                    processMessage($update['message']);
                }
            }
        }

        // Небольшая задержка, чтобы не перегружать сервер
        sleep(1);
    }
}

// Запускаем бота
runBot();
?>