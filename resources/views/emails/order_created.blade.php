@component('mail::message')
# Order Created Successfully

Hello {{ $order->user->name }},

Your order #{{ $order->id }} has been created successfully.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/orders/'.$order->id])
View Order
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
