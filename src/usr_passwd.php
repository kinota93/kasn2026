<form action="?do=pwd_save" method="post" class="form-horizontal">
  <input type="hidden" name="uid" value="<?=$secure_uid?>">
  <div class="form-group">
    <label for="oldpass" class="control-label col-sm-2">現パスワード:</label>
    <div class="col-sm-10">
      <input type="password" name="oldpass" id="oldpass" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label for="newpass1" class="control-label col-sm-2">新パスワード:</label>
    <div class="col-sm-10">
      <input type="password" name="newpass1" id="newpass1" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label for="newpass2" class="control-label col-sm-2">パスワード再入力:</label>
    <div class="col-sm-10">
      <input type="password" name="newpass2" id="newpass2" class="form-control">
    </div>
  </div>
  <input type="submit" value="登録" class="btn btn-primary col-sm-offset-2">
</form>
