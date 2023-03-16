<form method = "POST" action = "/customers/{{$customer->id}}">
    @method('PUT')
    @csrf

    Edytuj klienta <input type = "number" name = "user_id" id ="user_id" value = "{{$customer->user_id}}" HIDDEN>

    <br><br>

    <input type = "submit" value = "Zaktuaizuj klienta">
</form>