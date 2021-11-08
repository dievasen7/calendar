
<?php
/*

  Да се създаде работещ календар. За целта трябва да бъдат изпълнени следните условия:

  1. При избран месец от падащото меню и попълнена година в полето - да се визуализира календар за въпросните месец и година
  2. Ако не е избран месец или година, да се използват текущите (пример: ноември, 2021)
  3. Месецът и годината, за които е показан календар да са попълнени в падащото меню и полето за година
  3. При натискане на бутон "Today" да се показва календар за текущите месец и година
  5. В първия ред на календара да има:
  1. Стрелка на ляво, която да показва предишния месец при кликване
  2. Текст с името на месеца и годината, за които са показани дните
  3. Стрелка в дясно, която да показва следващия месец при кликване
  6. Таблицата да показва дни от предишния и/или следващия месец до запълване на седмиците (пример: Ако месеца започва в сряда, да се покажат последните два дни от предишния месец за вторник и понеделник)
  7. Показаните дни в таблицата трябва да са черни и удебелени за текущия месец, и сиви за предишен или следващ месец (css клас "fw-bold" за текущия месец и "text-black-50" за останалите)

 */
// Масива $months съдържа всички месеци, като слагаме ключ 1 за Януари, за да избегнем ключ 0:
$months = [
1 => 'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July ',
    'August',
    'September',
    'October',
    'November',
    'December',
];
// Променливи съдържащи стойности за месец и година, 
// ако $_GET е празен взимаме стойности за сегашния месец и година с ф-ция date():
$currentMonth = (int) ($_GET['m'] ?? date('m'));
$currentYear = (int) ($_GET['y'] ?? date('Y'));
// Записва стойност за днешния ден:
$today = (int) (date("d")); // Current day
// Взимаме броя на дните в дадения месец:
$days = (int) (date('t', mktime(0, 0, 0, $currentMonth, 1, $currentYear)));
// Виждаме кой ден от седмица е 1во число на дадения месец:
$start = (int) (date('N', mktime(0, 0, 0, $currentMonth, 1, $currentYear)));
// Взимаме последния ден от настоящия месец:
$finish = (int) (date('N', mktime(0, 0, 0, $currentMonth, $days, $currentYear)));
// Броя на дните в предходния месец които ще покажем в календара:
$laststart = $start - 1;
// Брой дни на предходния месец в календара:
$lastmonth = date("t", mktime(0, 0, 0, $currentMonth - 1, 1, $currentYear));
// Променливи на броячи започващи от 1, за текущия и следващия месец:
$counter = 1;
$nextMonthCounter = 1;
//Променлива за запис на class на клетките на календара:
$class = 'fw-bold';
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <title>Calendar</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Calendar</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                    <form method="get" action="calendar.php" class="row g-3">
                        <div class="col-md-6 col-lg-6">
                            <label class="form-label" for="month">Select month</label>
                            <select name="m" class="form-control" id="month">
                                <!--Генерираме списък на всички месеци, като обходим масива $months-->
                                <?php foreach ($months as $k => $mont) { ?>
                                    <option  
                                    <?php if ($k === $currentMonth) { ?>
                                            selected
                                        <?php } ?>
                                        value="<?= $k; ?>"><?= $mont; ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label class="form-label" for="year">Year:</label>
                            <input type="text" name="y" class="form-control" value="<?= $currentYear; ?>">
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <button type="submit" class="btn btn-primary">Show</button>
                            <a href="?m=11&y=2021" class="btn btn-secondary">Today</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-5 offset-md-3 col-lg-6 offset-lg-3">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>
                                    <?php if ($currentMonth > 1) { ?> <!-- Проверка дали месеца в календара дали е Януари-->
                                        <!--Линк към предходния месец като извадим 1 от сегашния-->
                                        <a href="?m=<?= $currentMonth - 1; ?>&y=<?= $currentYear; ?>" title="Previous month">&larr;</a>
                                        <?php
                                    } else {
                                        ?>
                                        <!--Ако месеца е Януари ни прехвърля към Декември-->
                                        <a href="?m=12&y=<?= $currentYear - 1; ?>" title="Previous month">&larr;</a>
                                    <?php } ?>
                                </th>
                                <!--Извежда името на месеца и годината,за които ще извеждаме календар-->
                                <th colspan="5" class="text-center"><?= $months[$currentMonth] . ', ' . $currentYear; ?></th>
                                <th>
                                    <?php if ($currentMonth < count($months)) { ?><!-- Проверка дали месеца в календара е Декември-->
                                        <!--Линк към следващия месец като добавяме 1 към сегашния-->
                                        <a href="?m=<?= $currentMonth + 1; ?>&y=<?= $currentYear; ?>" title="Next month">&rarr;</a>
                                    <?php } else {
                                        ?>
                                        <!--Ако месеца е Декември ни прехвърля към Януари-->
                                        <a href="?m=1&y=<?= $currentYear + 1; ?>" title="Next month">&rarr;</a>
                                    <?php } ?>
                                </th>
                            </tr>
                            <tr>                               
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                                <th>Sun</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Проверяваме да ли броя на седмиците е 6 или 5,
                            // ако 1-вия ден се пада събота или неделя седмиците ще са 6
                            // ако не те ще са 5:
                            if ($start > 5) {
                                $rows = 6;
                            } else {
                                $rows = 5;
                            }
                            // Въртим цикъл за създаване на седмиците като редове
                            for ($i = 1; $i <= $rows; $i++) {
                                echo '<tr>';
                                // Завъртаме отново цикъл for за изреждане на дните
                                // както за настояшия месец така и за предходния и следващия
                                for ($x = 1; $x <= 7; $x++) {
                                    // Правим проверка дали имаме дни за показване от предния месец
                                    if (($counter - $start) < 0) {
                                        // от броя дни в предния месец изваждаме броя за показване,
                                        // като добавяме +1 на всяко завъртане на цикъла
                                        $date = (($lastmonth - $laststart) + $counter);
                                        $class = 'text-black-50'; // клас за изветляване
                                        // проверяваме и за седващия цесец колко дни остават за запълване на календара
                                    } else if (($counter - $start) >= $days) {
                                        $date = ($nextMonthCounter); // запова от 1
                                        $nextMonthCounter++; // увеличава с един ден до запъване
                                        $class = 'text-black-50'; // клас за изветляване
                                    } else {
                                        // Намираме днешния ден и оцветяваме в синьо
                                        $date = ($counter - $start + 1);
                                        // Проверяваме дали годината, месеца и деня са настоящите в момента
                                        if ($currentMonth === (int) (date('m')) && $currentYear === (int) (date('Y')) && $today === $counter - $start + 1) {
                                            $class = 'table-primary'; // клас за цвят синьо
                                        }
                                    }
                                    echo '<td class="' . $class . '">' . $date . '</td>';
                                    // Инкрементираме до запълване на всички дни на сегашния месеца
                                    $counter++;
                                    // клас за одобеляване надните от сегашния месец
                                    $class = 'fw-bold';
                                }
                            }
                            echo '</tr>';
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>