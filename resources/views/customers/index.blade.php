@foreach($customers as $customer)
    <h1>Id klienta: {{$customer->id}}</h1>
    
    <h2>Przypisany użytkownik: {{$customer->user_id}}<h2>
    <hr>
@endforeach