<? if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;

class CDemoSqr extends CBitrixComponent
{
	public function executeComponent()
	{
		// местоположение скрипта
		$self = $_SERVER['PHP_SELF'];
		if (file_exists($_SERVER["DOCUMENT_ROOT"].'/bitrix/tools/data_base.txt')) {
			$read_file = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/bitrix/tools/data_base.txt');
			$file_data = explode(';', $read_file);
			foreach($file_data as $data){
				$pars = explode('=', $data);
				$pars_time = explode('time', $pars[0]);
			
				if(!empty($pars_time[1])){
					$result[$pars_time[0]][]['time'] = $pars_time[1];
				}
				$result[$pars_time[0]][]['text'] = $pars[1];
			}
		}
		// проверяем, если в переменная month была установлена в URL-адресе,
		//либо используем PHP функцию date(), чтобы установить текущий месяц.
		if(isset($_GET['month'])) 
			$month = $_GET['month'];
		elseif(isset($_GET['viewmonth'])) 
			$month = $_GET['viewmonth'];
		else 
			$month = date('m');

		// Теперь мы проверим, если переменная года устанавливается в URL,
		//либо использовать PHP функцию date(),
		//чтобы установить текущий год, если текущий год не установлен в URL-адресе.
		if(isset($_GET['year'])) 
			$year = $_GET['year'];
		elseif(isset($_GET['viewyear'])) 
			$year = $_GET['viewyear'];
		else 
			$year = date('Y');

		if($month == '12') 
			$next_year = $year + 1;
		else 
			$next_year = $year;
			
			
		$Month_r = array(
			"1"  => Loc::getMessage('MONTH_1'), //"январь",
			"2"  => Loc::getMessage('MONTH_2'), //"февраль",
			"3"  => Loc::getMessage('MONTH_3'), //"март",
			"4"  => Loc::getMessage('MONTH_4'), //"апрель",
			"5"  => Loc::getMessage('MONTH_5'), //"май",
			"6"  => Loc::getMessage('MONTH_6'), //"июнь",
			"7"  => Loc::getMessage('MONTH_7'), //"июль",
			"8"  => Loc::getMessage('MONTH_8'), //"август",
			"9"  => Loc::getMessage('MONTH_9'), //"сентябрь",
			"10" => Loc::getMessage('MONTH_10'), //"октябрь",
			"11" => Loc::getMessage('MONTH_11'), //"ноябрь",
			"12" => Loc::getMessage('MONTH_12'), //"декабрь"
		); 

		$first_of_month = mktime(0, 0, 0, $month, 1, $year);

		// Массив имен всех дней в неделю
		$day_headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

		$maxdays = date('t', $first_of_month);
		$date_info = getdate($first_of_month);
		$month = $date_info['mon'];
		$year = $date_info['year'];

		// Если текущий месяц это январь,
		//и мы пролистываем календарь задом наперед число,
		//обозначающее год, должно уменьшаться на один. 
		if($month == '1') 
			$last_year = $year-1;
		else 
			$last_year = $year;

		// Вычитаем один день с первого дня месяца,
		//чтобы получить в конец прошлого месяца
		$timestamp_last_month = $first_of_month - (24*60*60);
		$last_month = date("m", $timestamp_last_month);

		// Проверяем, что если месяц декабрь,
		//на следующий месяц равен 1, а не 13
		if($month == '12') 
			$next_month = '1';
		else 
			$next_month = $month+1;
			
		$calendar = "
		<div class=\"block-on-center\">
		<table width='450px' height='350px' style='border: 2px solid black'>
			<tr style='background: #5C8EB3; text-align: center;'>
				<td colspan='7' class='navi'>
					<a style='margin-right: 50px; color: #ffffff;' href='$self?month=".$last_month."&year=".$last_year."'>&lt;&lt;</a>
				".$Month_r[$month]." ".$year."
					<a style='margin-left: 50px; color: #ffffff;' href='$self?month=".$next_month."&year=".$next_year."'>&gt;&gt;</a>
				</td>
			</tr>
			<tr>
				<td class='datehead'>Пн</td>
				<td class='datehead'>Вт</td>
				<td class='datehead'>Ср</td>
				<td class='datehead'>Чт</td>
				<td class='datehead'>Пт</td>
				<td class='datehead'>Сб</td>
				<td class='datehead'>Вс</td>
			</tr>
			<tr>"; 

		// очищаем имя класса css
		$class = "";

		$weekday = $date_info['wday'];

		// Приводим к числа к формату 1 - понедельник, ..., 6 - суббота
		$weekday = $weekday-1; 
		if($weekday == -1) $weekday=6;

		// станавливаем текущий день как единица 1
		$day = 1;

		// выводим ширину календаря
		if($weekday > 0) 
			$calendar .= "<td colspan='$weekday'> </td>";
			
		while($day <= $maxdays)
		{
			// если суббота, выводим новую колонку.
			if($weekday == 7) {
				$calendar .= "</tr><tr>";
				$weekday = 0;
			}
			$note = "";
			$linkDate = mktime(0, 0, 0, $month, $day, $year);
			$select_day = $year.'-0'.$month.'-'.$day;
			
			// проверяем, если распечатанная дата является сегодняшней датой.
			//если так, используем другой класс css, чтобы выделить её 
			if((($day < 10 and "0$day" == date('d')) or ($day >= 10 and "$day" == date('d'))) and (($month < 10 and "0$month" == date('m')) or ($month >= 10 and "$month" == date('m'))) and $year == date('Y')){
				$class = "cal caltoday";
				
			//в противном случае, печатаем только ссылку на вкладку
			}else {
				$d = date('m/d/Y', $linkDate);

				$class = "cal";
			}
			if(isset($result[$select_day])){
				foreach($result[$select_day] as $results){
					$note .= '<p class="'.$results['time'].'" style="text-align:left">'.$results['time'].'</p><p>'.$results['text'].'</p>';
				}
			}
			
			//помечаем выходные дни красным
			if($weekday == 5 || $weekday == 6) $red='style="color: red" ';
			else $red=''; 	 
			
			$calendar .= "
				<td class='{$class}'><span id='{$select_day}' ".$red.">{$day}</span>".$note.
				"</td>";

		
			$day++;
			$weekday++;	
		}

		if($weekday != 7) 
			$calendar .= "<td colspan='" . (7 - $weekday) . "'> </td>";

			$calendar .= "</tr></table>
							<a class='popup-open' href='#'>". Loc::getMessage('BTN_NOTE') ."</a>
							<div class='popup-fade'>
								<div class='popup'>
									<a class='popup-close cl-btn-7' href='#'></a>
									<form method='post' id ='note-form'>
										<p><b>". Loc::getMessage('SELECT_DATA') .":</b></p>
										<p class='center'><input type='date' name='calendar' value='". date('Y-m-d')."'></p>
										<p><b>". Loc::getMessage('SELECT_TIME') .":</b></p>
										<p class='center'><input type='time' name='time' value='". date('H:i')."'></p>
										<p><b>". Loc::getMessage('DESCRIPTION') .":</b></p>
										<p class='center'><textarea rows='10' cols='45' name='text' placeholder='". Loc::getMessage('TEXT_DESC') ."'></textarea></p>
										<p class='center'><input type='submit' name='btn-form' value='". Loc::getMessage('BTN_SEND') ."'></p>
									</form>
								</div>		
							</div>
							</div>";

		$this->arResult = $calendar;
		$this->includeComponentTemplate();
		return $this->arResult;
	}
}