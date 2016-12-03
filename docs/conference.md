Conference's method 'cancelReservationForOrder' will throw Exception if order doesn't exists.
When the Reservation is cancelled it should be removed from the list and its seats should be released.
If there are Waiting Reservations those released seats should be first available for them 
in second order added to Available Seats Collection. If the release seats quantity is equal to ....
