<form action="/account/save" method="POST">
    @csrf
    <input type="file" id="avatar" name="avatar">
    <input class="form-button" value="Сохранить" type="submit">
</form>
