<?php
require_once "vendor/autoload.php";
$token="1488371428:AAHrJMob_9A233w1up3hzZGfqjGLh5ek9us";
try
{
    $bot = new \TelegramBot\Api\Client($token);
    $bot->command('ping', function ($message) use ($bot) {
        $bot->sendMessage($message->getChat()->getId(), 'pong!');
    });
    $bot->command('start', function ($message) use ($bot) {
        $answer = "Howdy!\n\n/start\n\n";
        $answer = 
            $answer
            ."Сыграем в игру: stone-scissors-paper?\n" 
            ."/stone - your stone\n"
            ."/scissors - your scissors\n"
            ."/paper - your paper\n
            -----------------------\n
            /weather_Kharkiv - get to know about weather\n";
        $bot->sendMessage($message->getChat()->getId(), $answer);
    });
    //Handle text messages
    $bot->on(function (\TelegramBot\Api\Types\Update $update) use ($bot) {
        $message = $update->getMessage();
        $id = $message->getChat()->getId();
        $text_message=$message->getText();
        $answer = "";
        if ($text_message == "/paper")
        {
            $answer = "Scissors! I won!!!\n /start";
            $bot->sendMessage($message->getChat()->getId(), $answer);
        }
        elseif ($text_message == "/stone")
        {
            $answer = "Paper! I won!!!\n /start";
            $bot->sendMessage($message->getChat()->getId(), $answer);
        }
        elseif ($text_message == "/scissors")
        {
            $answer = "Stone! I won!!!\n /start";
            $bot->sendMessage($message->getChat()->getId(), $answer);
        }
        elseif ($text_message == "/weather_Kharkiv")
        {
            $weather = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=Kharkiv&units=metric&appid=5aab9c957eb60485990cf8d256f2fe5c");
            $weather=json_decode($weather);
            $answer="";
            $temp_now=$weather->main->temp;
            $humidity = $weather->main->humidity;
            $pressure = $weather->main->sea_level;
            $wind = $weather->wind->speed;
            $description = $weather->weather[0]->description;
            // Перевод значений на русский язык.
                // switch($description)
                // {
                //     case "clear sky":
                //         $description = "Ясно";
                //     break;
                //     case "few clouds":
                //         $description = "Малооблачно";
                //     break;
                //     case "broken clouds":
                //         $description = "Облачность";
                //     break;
                //     case "light rain":
                //         $description = "Небольшой дождь";
                //     break;
                //     case "sky is clear":
                //         $description = "Ясно";
                //     break;
                //     case "moderate rain":
                //         $description = "Дождливо";
                //     break;
                //     case "scattered clouds":
                //         $description = "Облачно с прояснениями";
                //     break;
                //     case "heavy intensity rain":
                //         $description = "Сильный дождь";
                //     break;
                //     case "snow":
                //         $description = "Снег";
                //     break;
                //     case "overcast clouds":
                //         $description = "Пасмурно";
                //     break;
                // }
                $answer = "Info about weather: $description.\n".               
                "Temperature: $temp_now.\n".            
                "Humidity, %: $humidity.\n".
                "Pressure, mm: $pressure.\n".
                "Wind speed, m/s: $wind.\n";
            $bot->sendMessage($message->getChat()->getId(), $answer);
        }
        elseif ($text_message == "/exchange")
        {
            $weather = file_get_contents("https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5");
            $weather=json_decode($weather);
            $answer="";
            $temp_now=$weather->main->temp;
            $humidity = $weather->main->humidity;
            $pressure = $weather->main->sea_level;
            $wind = $weather->wind->speed;
            $description = $weather->weather[0]->description;
        }
        //ДЗ: топ 10 самых популярных фильмов 
        elseif ($text_message == "/popularMovies")
        {
            $movies = file_get_contents("https://api.themoviedb.org/3/movie/popular?api_key=ef2fded3f2e5fcd64720fd211bec4ad0&language=en-US");
            $movies=json_decode($movies);
            //взяла из объекта, который пришёл по запросу, массив результатов
            $movies=$movies->results;
            $answer="Here are 10 the most popular films today:\n";
            for($i=1; $i<=10; $i++)
            {
              $answer."Movie title: ".$movies[$i]->original_title."\n"
              ."Language of movie: ".$movies[$i]->original_language."\n"
              ."Overview: ".$movies[$i]->overview."\n"
              ."Release date: ".$movies[$i]->release_date."\n"
              ."Popularity: ".$movies[$i]->popularity;
            }
        }
    }, function () {
        return true;
    });
    // $bot->command('stone', function ($message) use ($bot) {
    //     $bot->sendMessage($message->getChat()->getId(), 'Paper! I won!!!');
    // });
    // $bot->command('scissors', function ($message) use ($bot) {
    //     $bot->sendMessage($message->getChat()->getId(), 'Stone! I won!!!');
    // });
    // $bot->command('paper', function ($message) use ($bot) {
    //     $bot->sendMessage($message->getChat()->getId(), 'Scissors! I won!!!');
    // });
    ///https://api.telegram.org/botТОКЕН_БОТА/setWebhook?url=ВАШ_URL

    ///https://api.telegram.org/bot1488371428:AAHrJMob_9A233w1up3hzZGfqjGLh5ek9us/setWebhook?url=https://web04pr02.azurewebsites.net/
    
    //key for weather:
    //5aab9c957eb60485990cf8d256f2fe5c
    //api.openweathermap.org/data/2.5/weather?q={city name}&appid={API key}
    //https://api.openweathermap.org/data/2.5/weather?q=Kharkiv&units=metric&appid=5aab9c957eb60485990cf8d256f2fe5c
    
    
    //ДЗ Информация о фильме
    //https://api.themoviedb.org/3/movie/{movie_id}?api_key={api_key}&callback=test
    //https://api.themoviedb.org/3/movie/550?api_key=ef2fded3f2e5fcd64720fd211bec4ad0
    //Информация о популярных фильмах
    //https://api.themoviedb.org/3/movie/popular?api_key=ef2fded3f2e5fcd64720fd211bec4ad0&language=en-US
    $bot->run();
}
catch(\TelegramBot\Api\Exception $e)
{
 file_put_contents("error.txt", $e->getMassage());
}
?>
