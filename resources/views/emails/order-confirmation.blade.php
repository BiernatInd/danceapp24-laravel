<p>Thank you for making a reservation on our DanceApp24 website!</p>

<p>Reservation details: </p>
<p>Reservation number: {{ $orderData['order_number'] }}</p>
<p>Class hours: {{ $orderData['class_hours'] }}</p>
<p>Class type: {{ $orderData['class_type'] }}</p>
<p>Markings: {{ $orderData['designation'] }}</p>
<p>Room number: {{ $orderData['room_number'] }}</p>
<p>Instructor: {{ $orderData['instructor'] }}</p>
<p>Reservation start date: {{ $orderData['reservation_start_date'] }}</p>
<p>Reservation end date: {{ $orderData['reservation_end_date'] }}</p>
<p>Total price: {{ $orderData['price'] }}</p>
<p>Name: {{ $orderData['name'] }}</p>
<p>Surname: {{ $orderData['surname'] }}</p>
<p>E-mail: {{ $orderData['email'] }}</p>
<p>Phone: {{ $orderData['phone'] }}</p>
@if(!empty($orderData['user_name']))
    <p>User name: {{ $orderData['user_name'] }}</p>
@endif


<p>Check your reservation status:</p>
<a href="https://danceconnect24.com/status/{{ explode('/', $orderData['order_number'])[0] }}">
https://danceconnect24.com/status/{{ explode('/', $orderData['order_number'])[0] }}
</a>