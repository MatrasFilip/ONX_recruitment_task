<form method = "POST" action = "/customers">
    @csrf

    Dodaj klienta <input type = "number" name = "user_id" id ="user_id" value = "{{$user->id}}" HIDDEN>

    <br><br> 

    <input type = "submit" value = "Dodaj nowego klienta">
</form>