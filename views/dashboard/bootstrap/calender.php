<!-- <?php
echo busiIcon($this->member->item('company_idx'));
echo busiNm($this->member->item('company_idx'));

$user_info = $this->member->item('mem_id');
?> -->



<style>

	body {
		background-color: #F1F1F1;
	}

	header, .navbar, footer { /* 각종메뉴 숨김처리 */
		display:none !important;
	}

</style>


<div class="asmo_dashboard">
	
	<div class="asmo_dashboard_sub" id="asmo_dashboard_calendar">
		<div class="dash_sub_head">
			<h2><?=busiNm($this->member->item('company_idx'))?> 일정</h2>

      <button id="schedule_enroll_btn">일정등록</button>
		</div>

		
		<div id="calendar-container">
      <div id="month-year-container">
          <button id="prev-btn">Previous</button>
          <span id="current-month"></span>
          <button id="next-btn">Next</button>
      </div>
      <table id="calendar">
        <thead>
          <tr>
            <th>SUN</th>
            <th>MON</th>
            <th>TUE</th>
            <th>WED</th>
            <th>THU</th>
            <th>FRI</th>
            <th>SAT</th>
          </tr>
        </thead>
        <tbody id="calendar-tbody">
        </tbody>
      </table>
    </div>


		
	</div>
</div>

<!-- 일정 정보 팝업 -->
<div class="popup_layer_bg" id="calendar_info_popup">
	<div class="schedule_info_popup">
		<div class="schedule_info_popup_box">
			<div class="schedule_info_popup_title">
				<strong>창립기념일</strong>
			</div>
			<div class="schedule_info_popup_cont">
				<div class="schedule_info_popup_cont_info">
					<div class="schedule_date_box">
            <div class="dateTime_box">
              <span class="startDate_result">2024-01-23 (화)</span>
              <span class="startTime_result">오전 11: 00</span>
            </div>
            <span>~</span>
            <div class="dateTime_box">
              <span class="endDate_result">2024-01-23 (화)</span>
              <span class="endTime_result">오후 12: 00</span>
            </div>
						<div class="allDay_checkbox">
              <p>종일</p>
            </div>
					</div>
				</div>
				<div class="schedule_info_popup_cont_memo">
					<span>(주)팀메타의 창립기념일입니다.</span>
				</div>
			</div>

      <!-- 기업관리자일 때 -->
      <div class="schedule_info_popup_btn">
        <button class="schedule_edit">수정</button>
        <button class="schedule_remove">삭제</button>
      </div>

		</div>

		<button id="calendar_info_popup_close">닫기</button>
	</div>
</div>

<!-- 일정 등록 팝업 -->
<div class="popup_layer_bg" id="calendar_enroll_popup">
	<div class="schedule_info_popup">
		<form class="schedule_info_popup_box">
			<div class="schedule_info_popup_title">
        <label for="schedule_title">일정 제목</label>
        <input placeholder="일정 제목을 입력하세요" type="text" id="schedule_title" name="schedule_title">
			</div>
			<div class="schedule_info_popup_cont">
				<div class="schedule_info_popup_cont_info">
					<div class="schedule_date_box">
            <div class="dateTime_box">
              <label for="startDate">시작 날짜:</label>
              <input type="date" id="startDate" name="startDate">
              <label for="startTime">시작 시간:</label>
              <input type="time" id="startTime" name="startTime">
            </div>
            <span>~</span>
            <div class="dateTime_box">
              <label for="endDate">종료 날짜:</label>
              <input type="date" id="endDate" name="endDate">
              <label for="endTime">종료 시간:</label>
              <input type="time" id="endTime" name="endTime">
            </div>
						<div class="allDay_checkbox">
              <input type="checkbox" id="allDay" name="allDay">
              <label for="allDay">종일</label>
            </div>
					</div>
				</div>
				<div class="schedule_textarea">
					<textarea placeholder='일정 내용을 입력하세요' name="schedule_cont" id="schedule_cont" cols="30" rows="10"></textarea>
				</div>
			</div>

      <div class="schedule_info_popup_btn">
        <button type="submit" class="schedule_save">저장</button>
      </div>

    </form>

		<button id="calendar_enroll_popup_close">닫기</button>
	</div>
</div>

<!-- 일정 수정 팝업 -->
<div class="popup_layer_bg" id="calendar_edit_popup">
  <div class="schedule_info_popup">
    <form class="schedule_info_popup_box">
      <div class="schedule_info_popup_title">
        <label for="schedule_title">일정 제목</label>
        <input placeholder="일정 제목을 입력하세요" type="text" id="schedule_title" name="schedule_title">
      </div>
      <div class="schedule_info_popup_cont">
        <div class="schedule_info_popup_cont_info">
          <div class="schedule_date_box">
            <div class="dateTime_box">
              <label for="startDate">시작 날짜:</label>
              <input type="date" id="startDate" name="startDate">
              <label for="startTime">시작 시간:</label>
              <input type="time" id="startTime" name="startTime">
            </div>
            <span>~</span>
            <div class="dateTime_box">
              <label for="endDate">종료 날짜:</label>
              <input type="date" id="endDate" name="endDate">
              <label for="endTime">종료 시간:</label>
              <input type="time" id="endTime" name="endTime">
            </div>
            <div class="allDay_checkbox">
              <input type="checkbox" id="allDay" name="allDay">
              <label for="allDay">종일</label>
            </div>
          </div>
        </div>
        <div class="schedule_textarea">
          <textarea placeholder='일정 내용을 입력하세요' name="schedule_cont" id="schedule_cont" cols="30" rows="10"></textarea>
        </div>
      </div>

      <div class="schedule_info_popup_btn">
        <button type="submit" class="schedule_save">저장</button>
      </div>

    </form>

    <button id="calendar_edit_popup_close">닫기</button>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function() {
		$('#dashboard').addClass('selected');
	});

  // 팝업창 스크립트
	$('#calendar-tbody td').on('click', function() {
		$('#calendar_info_popup').css('display', 'block');
	});

	$('#calendar_info_popup_close').on('click', function() {
		$('#calendar_info_popup').css('display', 'none');
	});

  $('#schedule_enroll_btn').on('click', function() {
    $('#calendar_enroll_popup').css('display', 'block');
  });

  $('#calendar_enroll_popup_close').on('click', function() {
    $('#calendar_enroll_popup').css('display', 'none');
  });

  $('.schedule_edit').on('click', function() {
    $('#calendar_info_popup').css('display', 'none');
    $('#calendar_edit_popup').css('display', 'block');
  });

  $('#calendar_edit_popup_close').on('click', function() {
    $('#calendar_edit_popup').css('display', 'none');
  });

  


document.addEventListener("DOMContentLoaded", function() {
    let calendar = new Calendar();
    calendar.setCalendar(2024, 1, 'calendar');

    document.getElementById('prev-btn').addEventListener('click', function() {
      calendar.prevMonth();
    });

    document.getElementById('next-btn').addEventListener('click', function() {
      calendar.nextMonth();
    });
  });

  class Calendar {
    constructor() {
      this.currentYear = new Date().getFullYear();
      this.currentMonth = new Date().getMonth();
      this.monthNames = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
    }

    setCalendar(year, month, target) {
      this.currentYear = year;
      this.currentMonth = month;

      let targetFirstDay = this.getFirstDay(year, month);
      let targetLastDay = this.getLastDay(year, month);

      let targetFirstDay_date = targetFirstDay.getDate();
      let targetLastDay_date = targetLastDay.getDate();

      let targetFirstDay_day = targetFirstDay.getDay();

      let today = new Date();

      let text = '<tr>';

      // Add days from previous month
      let prevMonthDays = this.getPrevMonthDays(targetFirstDay);
      for (let i = 0; i < prevMonthDays.length; i++) {
          let dayClass = (new Date(year, month - 1, prevMonthDays[i]).getDay() === 6) ? 'asmo_sat' : (new Date(year, month - 1, prevMonthDays[i]).getDay() === 0) ? 'asmo_sun' : '';
          text += '<td class="other-month"><div class="asmo_date ' + dayClass + '">' + prevMonthDays[i] + '</div></td>';
      }

      // Add days from current month
      while (targetFirstDay_date <= targetLastDay_date) {
          let todayClass = (today.getDate() == targetFirstDay_date && today.getMonth() == month && today.getFullYear() == year) ? ' class="today" ' : '';
          let dayClass = (targetFirstDay.getDay() === 6) ? 'asmo_sat' : (targetFirstDay.getDay() === 0) ? 'asmo_sun' : '';
          text += '<td' + todayClass + '><div class="asmo_date ' + dayClass + '">' + targetFirstDay_date + '</div></td>';

          if ((new Date(targetFirstDay.getFullYear(), targetFirstDay.getMonth(), targetFirstDay_date)).getDay() % 7 == 6)
              text += '</tr><tr>';

          targetFirstDay_date++;
          targetFirstDay.setDate(targetFirstDay_date); // Update targetFirstDay to the next day
      }

      // Add days from next month
      let nextMonthDays = this.getNextMonthDays(new Date(year, month, targetLastDay_date));
      for (let i = 0; i < nextMonthDays.length; i++) {
          let dayClass = (new Date(year, month + 1, nextMonthDays[i]).getDay() === 6) ? 'asmo_sat' : (new Date(year, month + 1, nextMonthDays[i]).getDay() === 0) ? 'asmo_sun' : '';
          text += '<td class="other-month"><div class="asmo_date ' + dayClass + '">' + nextMonthDays[i] + '</div></td>';
      }

      text += '</tr>';


      document.getElementById(target + '-tbody').innerHTML = text;
      document.getElementById('current-month').innerText = this.currentYear+ ". " + this.monthNames[this.currentMonth] ;
    }

    getFirstDay(year, month) {
      return new Date(year, month, 1);
    }

    getLastDay(year, month) {
      return new Date(year, month + 1, 0);
    }

    getPrevMonthDays(firstDay) {
      let prevMonthLastDay = new Date(firstDay.getFullYear(), firstDay.getMonth(), 0).getDate();
      let prevMonthDays = [];
      for (let i = firstDay.getDay() - 1; i >= 0; i--) {
        prevMonthDays.push(prevMonthLastDay - i);
      }
      return prevMonthDays;
    }

    getNextMonthDays(lastDay) {
      let nextMonthDays = [];
      for (let i = lastDay.getDay() + 1; i < 7; i++) {
        nextMonthDays.push(i - lastDay.getDay());
      }
      return nextMonthDays;
    }

    prevMonth() {
      if (this.currentMonth === 0) {
        this.currentYear--;
        this.currentMonth = 11;
      } else {
        this.currentMonth--;
      }
      this.setCalendar(this.currentYear, this.currentMonth, 'calendar');
    }

    nextMonth() {
      if (this.currentMonth === 11) {
        this.currentYear++;
        this.currentMonth = 0;
      } else {
        this.currentMonth++;
      }
      this.setCalendar(this.currentYear, this.currentMonth, 'calendar');
    }
  }


</script>