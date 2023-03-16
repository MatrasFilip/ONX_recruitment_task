<form method = "POST" action = "/customers">
    @csrf

    <label for = "user_id">Podaj użytkownika: </label><input type = "number" name = "user_id" id ="user_id">
    {{--tymczasowe id do testów
    W przyszłości pobierane od zalogowanego użytkownika--}}

    @error('user_id')
        <div style="color: red;">{{ $message }}</div>
    @enderror

    <br><br>

    <input type = "submit" value = "Dodaj nowego klienta">
</form>