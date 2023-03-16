<h1>Id klienta: {{$customer->id}}</h1>
<h2>Przypisany użytkownik: {{$customer->user_id}} </h2>
<form method = "POST" action = "/customers/{{$customer->id}}">
    @csrf
    @method("DELETE")
    <input type = "submit" value = "Usuń klienta">
</form>