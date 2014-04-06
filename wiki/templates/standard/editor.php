<form name="edit_form" action="/index.php" method="post">
	<textarea rows="20" cols="60" name="contents"><?=$config['contents']?></textarea>
	<input type="hidden" name="file" value="<?=$config['file']?>" />
	<input type="hidden" name="todo" value="save" />
	<button class="edit" onclick="document.edit_form.submit();">Save changes</button>
</form>