<?php
$attributes = array('class' => 'form-horizontal', 'name' => 'frmExcel', 'id' => 'frmExcel', 'onsubmit' => 'return submitContents(this)'); 
echo form_open_multipart(current_full_url(), $attributes); 
?>
<table class="table">
	<colgroup>
		<col width="10%">
		<col width="10%">
		<col width="10%">
		<col width="10%">
	</colgroup>
	<tbody>
		<tr>
			<th>엑셀 업로드</th>
			<td><input type="file" name="userfile"></td>
			<td><input type="submit" value="등록"></td>
			<td><a href="/uploads/membersample/sample.xlsx" download>업로드용 샘플 파일 다운로드</a></td>
		</tr>
	</tbody>
</table>
<?php echo form_close(); ?>
<a href="/admin/cinfo/members" class="btn btn-sm btn-default">목록으로</a>
<script type="text/javascript">
function submitContents(f) {
	var title = '';
	var content = '';
	$.ajax({
		url: cb_url + '/postact/filter_spam_keyword',
		type: 'POST',
		data: {
			title: f.post_title.value,
			content: f.post_content.value,
			csrf_test_name : cb_csrf_hash
		},
		dataType: 'json',
		async: false,
		cache: false,
		success: function(data) {
			$('#frmExcel').submit();
		}
	});
}
</script>