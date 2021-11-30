<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Page Title</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="Styles/calendar_style.css">
	
	<body>
		<div id="months">
			<ul class="calendar_header">
				<li><button type="button" id="previous_month">Previous</button></li>
				<li><h1 id="monthName">Month</h1></li>
				<li><button type="button" id="next_month">Next</button></li>
				<li>
					<form method="post">
						<input type="number" id="recipe_day" placeholder="day">
						<input type="text" id="recipe_link" placeholder="link">
						<input type="hidden" id="month_year">
						<input type="submit" value="Add to Calendar">
					</form>
				</form>
				</li>
			</ul>
		</div>
		
		<script>
			function addRecipe() {
			
				var day = parseInt(document.getElementById("recipe_day").value);
				var link = document.getElementById("recipe_link").value;
				
				var possibleDays = document.getElementsByClassName("day");
				
				for (let i = 0; i < possibleDays.length; i++) {
					if (parseInt(possibleDays[i].innerHTML) == day) {
						if (possibleDays[i].innerHTML.length > 2) {
							possibleDays[i].innerHTML = day + " <a href=\"" + link + "\">Name</a>";
						}
						else {
							possibleDays[i].innerHTML += " <a href=\"" + link + "\">Name</a>";
						}
					}
				}
			}
		</script>
		
		<?php
		?>
		
		<table>
			<tr>
				<th>Sunday</th>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thursday</th>
				<th>Friday</th>
				<th>Saturday</th>
			</tr>
			<tr>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
			</tr>
			<tr>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
			</tr>
			<tr>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
			</tr>
			<tr>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
			</tr>
			<tr>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
			</tr>
			<tr>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
				<td class="day"></td>
			</tr>
		
		</table>
	</body>
	
	<script type="text/javascript">
		day = new Date();
		
		var year = day.getFullYear();
		var month = day.getMonth();
		
		day = new Date(year, month);
		
		writeMonthHeader(day);
		writeCalendarDays();
		
		function writeMonthHeader(day) {
				const monthNames = ["January", "February", "March", "April", "May", "June",
			"July", "August", "September", "October", "November", "December"];
				document.getElementById("monthName").innerHTML = monthNames[month] + " " + year;
				document.getElementById("month_year").value = monthNames[month] + " " + year;
		}
		
		function writeCalendarDays() {
			var pos = 1;
			var start = false;
			var offset = 0;
			
			const daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
			
			var possibleDays = document.getElementsByClassName("day");
			
			for (let i = 0; i < possibleDays.length; i++) {
				if (i == day.getDay()) {
					
					offset = i - (i - 1);
					possibleDays[i].innerHTML = offset++;
					pos++;
					start = true;
				}
				else if (start && pos <= daysInMonth[month]) {
					possibleDays[i].innerHTML = offset++;
					pos++;
				}
				else {
					possibleDays[i].innerHTML = "";
				}
			}
			
		}
		
		document.getElementById("next_month").onclick = function() {
			if (month == 11){
				month = 0;
				year += 1;
			}
			else {
				month += 1;
			}
			
			day = new Date(year, month);
			writeMonthHeader(day);
			writeCalendarDays();
		}
		
		document.getElementById("previous_month").onclick = function() {
			if (month == 0) {
				month = 11;
				year -= 1;
			}
			else {
				month -= 1;
			}
			
			day = new Date(year, month);
			writeMonthHeader(day);
			writeCalendarDays();
		
		
		}
	</script>
</html>