<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/app.css'])
    @vite(['resources/css/invoice-bold.css'])
    @vite(['resources/css/invoice-clear.css'])

</head>
<body class="relative invoice-body">
    @if (!empty($config['is_paid']) && $config['is_paid'] == true)
        <div class="absolute top-0 right-0 px-12 py-2 text-lg font-bold text-white bg-green-500">PAID</div>
    @endif
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="invoice-company">
                @if(!empty($config['logo']))<img class="invoice-logo" src="{{ $config['logo'] }}" alt="Company Logo">@endif
            </div>
            <div class="invoice-title-section">
                @if(!empty($config['title']))<h1 class="invoice-title">{{ $config['title'] }}</h1>@endif

                @if (!empty($config['from']))
                    <div class="invoice-from">
                        {{-- <h3 class="invoice-section-title">From:</h3> --}}
                        @if(!empty($config['from']['address_line_1']))<p class="invoice-from-address-line-1">{{ $config['from']['address_line_1'] }}</p>@endif
                        @if(!empty($config['from']['address_line_2']))<p class="invoice-from-address-line-2">{{ $config['from']['address_line_2'] }}</p>@endif
                        @if(!empty($config['from']['address_line_3']))<p class="invoice-from-address-line-3">{{ $config['from']['address_line_3'] }}</p>@endif
                        @if(!empty($config['from']['phone']))<p class="invoice-from-phone">{{ $config['from']['phone'] }}</p>@endif
                        @if(!empty($config['from']['email']))<p class="invoice-from-email">{{ $config['from']['email'] }}</p>@endif
                    </div>
                @endif
            </div>
        </div>

        <div class="invoice-main">
            <div class="invoice-details">
                @if (!empty($config['to']))
                    <div class="invoice-to">
                        <h3 class="invoice-section-title">Bill To:</h3>
                        @if(!empty($config['to']['name']))<p class="invoice-to-name">{{ $config['to']['name'] }}</p>@endif
                        @if(!empty($config['to']['address_line_1']))<p class="invoice-to-address-line-1">{{ $config['to']['address_line_1'] }}</p>@endif
                        @if(!empty($config['to']['address_line_2']))<p class="invoice-to-address-line-2">{{ $config['to']['address_line_2'] }}</p>@endif
                        @if(!empty($config['to']['address_line_3']))<p class="invoice-to-address-line-3">{{ $config['to']['address_line_3'] }}</p>@endif
                        @if(!empty($config['to']['phone']))<p class="invoice-to-phone">{{ $config['to']['phone'] }}</p>@endif
                        @if(!empty($config['to']['email']))<p class="invoice-to-email">{{ $config['to']['email'] }}</p>@endif
                    </div>
                @endif
                <div class="invoice-info">
                    @if(!empty($config['invoice_number']))<p class="invoice-number">Invoice #: {{ $config['invoice_number'] }}</p>@endif
                    @if(!empty($config['date']))<p class="invoice-date">Date: {{ $config['date'] }}</p>@endif
                </div>
            </div>

            @if(!empty($config['description']))<p class="invoice-description">{!! $config['description'] !!}</p>@endif

            <table class="invoice-table">
                <thead class="invoice-thead">
                    <tr>
                        @foreach($columns as $column)
                            <th class="invoice-th invoice-{{ $column }}">{{ ucfirst($column) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            @foreach($columns as $column)
                                <td class="invoice-td invoice-{{ $column }}">{{ $item[$column] ?? '' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>




            <div class="invoice-total">Total: £{{ $total ?? '' }}</div>

            @if(!empty($config['payment_terms']))<p class="invoice-payment-terms">{!! $config['payment_terms'] !!}</p>@endif
            @if(!empty($config['payment_details']))<p class="invoice-payment-details">{!! $config['payment_details'] !!}</p>@endif
        </div>
        @if(!empty($config['footer']))<div class="invoice-footer">{{ $config['footer'] }}</div>@endif

    </div>
</body>
</html>
