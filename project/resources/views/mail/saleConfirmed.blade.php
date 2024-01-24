<!DOCTYPE html>
<html lang="pt-Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="flex flex-col w-full text-center items-center gap-6 m-6">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="object-cover cover h-[100px]">
    <p class="text-lg">Olá, <strong>{{ $sale->customer_name }}</strong></p>
    <p class="text-4xl text-green-500">Sua compra foi confirmada!</p>
    <div>
        <p>Seu voucher</p>
        <p class="text-4xl font-bold">{{ $sale->voucher }}</p>
    </div>
    <div>
        <p>Empresa</p>
        <p class="text-xl font-bold">{{ $sale->company->name }}</p>
    </div>
    <div>
        <p>Vendedor</p>
        <p class="text-xl font-bold">{{ $sale->seller->name }}</p>
    </div>
    <div>
        <p>Eventos</p>
        <div class="flex flex-col items-center">

            @foreach($sale->events as $event)
                <div class="border-b-2 border-solid w-fit lg:min-w-[500px] flex flex-col gap-2 py-2">
                    <div class="flex justify-between gap-12">
                        <p>Passeio</p>
                        <p class="font-bold">{{ $event->tour->name }}</p>
                    </div>
                    <div class="flex justify-between gap-4">
                        <p>Partida</p>
                        <p class="font-bold">{{ \Carbon\Carbon::parse($event->departure_date_time)->format('d/m/y H:i') }}</p>
                    </div>
                    <div class="text-left">
                        <p>Passageiros:</p>
                        <div>
                            @foreach(json_decode($event->pivot->passengers) as $key => $passenger)
                                <p>{{ $key + 1  }} - {{ $passenger->name }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>

