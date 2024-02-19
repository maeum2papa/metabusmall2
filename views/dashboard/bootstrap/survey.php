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
	
	<div class="asmo_dashboard_sub" id="asmo_dashboard_survey">
		<div class="dash_sub_head">
			<h2><?=busiNm($this->member->item('company_idx'))?> 서베이</h2>
		</div>

		<div class="dash_sub_body">
			<table>
				<tr>
					<th>NO</th>
					<th>제목</th>
					<th>응답기간</th>
					<th>참여</th>
				</tr>

				<tr>
					<td>16</td>
					<td>2024 직원 만족도 조사</td>
					<td>2024-01-01 ~ 2024-01-31</td>
					<td><a href="">참여하기</a></td>
				</tr>

				<tr>
					<td>15</td>
					<td>2024 직원 만족도 조사</td>
					<td>2024-01-01 ~ 2024-01-31</td>
					<td><a href="" class="complete">참여완료</a></td>
				</tr>

				<tr>
					<td>12</td>
					<td>2024 직원 만족도 조사</td>
					<td>2024-01-01 ~ 2024-01-31</td>
					<td><a href="">참여하기</a></td>
				</tr>

				<tr>
					<td>9</td>
					<td>2024 직원 만족도 조사</td>
					<td>2024-01-01 ~ 2024-01-31</td>
					<td><a href="">참여하기</a></td>
				</tr>

				<tr>
					<td>8</td>
					<td>2024 직원 만족도 조사</td>
					<td>2024-01-01 ~ 2024-01-31</td>
					<td><a href="">참여하기</a></td>
				</tr>
			</table>

			<!-- 페이지네이션이 들어가야합니다! -->
		</div>

		
	</div>
</div>



<script type="text/javascript">
	$(document).ready(function() {
		$('#dashboard').addClass('selected');
	});
</script>