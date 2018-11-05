<form method="post" action="/playlist">
    {{ csrf_field() }}
    <input type="text" name="name">
    {{ $errors->first('name') }}
    <input type="submit" value="enregistrer">
</form>