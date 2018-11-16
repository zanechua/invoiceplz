<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" style="font-family: sans-serif; overflow-x: hidden;">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <style>
            .keep-together {
                page-break-inside: avoid;
            }

            .break-before {
                page-break-before: always;
            }

            .break-after {
                page-break-after: always;
            }

            .quote {
                font-size: 1.1em;
                line-height: 1.5em;
            }

            .quote table {
                width: 100%;
                line-height: inherit;
                text-align: left;
                border: 0;
            }

            .quote table table {
                border: 0;
            }

            .quote table tr {
                border: 0;
            }

            .quote table td {
                padding: 5px;
                vertical-align: top;
            }

            .quote table tr.company-information td:nth-child(2) {
                text-align: center;
            }

            .quote table tr.information td:nth-child(2) {
                text-align: center;
            }

            .quote table th {
                color: #8c8c8c;
                padding: 10px 5px;
            }

            .quote table th:nth-child(3) {
                text-align: right;
            }

            .quote table tr td:nth-child(3) {
                text-align: right;
            }

            .quote table tr.top table td {
                padding-bottom: 20px;
            }

            .quote table tr table td span {
                color: #8c8c8c;
                display: block;
            }

            .quote table tr.information table table {
                float: left;
            }

            .quote table tr.information table table tbody {
                float: right;
            }

            .quote table tr.information table table td {
                padding: 0;
            }

            .quote table tr.information table td {
                padding-bottom: 20px;
            }

            .quote table tr.company-logo td {
                text-align: center;
            }

            .quote table tr.details td {
                padding: 20px 5px;
            }

            .quote table tr.details td p {
                margin: 0;
                color: #8c8c8c;
            }

            .quote .bottom-line {
                border-bottom: 1px solid #e0e0e0;
            }

            .quote .left-line {
                border-left: 2px solid #e0e0e0;
            }

            .quote .summary, .quote .amount, .quote .quantity {
                color: #8c8c8c;
            }

            .quote .total-value {
                color: #4da6a6;
            }

            .quote-bold {
                color: #8c8c8c;
                font-weight: bold;
            }

            .quote-text-larger {
                font-size: 1.3em;
            }
        </style>
    </head>
    <body style="margin: 0; font-family: 'Roboto', Arial, sans-serif;font-size: 13px;">
        <div class="quote">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <img src="{{ \App\Library\Poowf\Unicorn::getStorageFile($quote->company->logo, [210,110]) }}" width="210" height="110">
                                </td>
                                <td></td>
                                <td>
                                    <span class="quote-id quote-bold quote-text-larger">Quote #{{ $quote->nice_quote_id }}</span>
                                    <span class="quote-date">Quote Date: {{ $quote->date->format('d F, Y') }}</span>
                                    <span class="quote-duedate">Quote Expires: {{ $quote->duedate->format('d F, Y') }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="information">
                    <td>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="250">
                                    <span class="name quote-bold quote-text-larger">Prepared For: </span>
                                    <span>{{ $quote->client->companyname }}</span>
                                    <span>@if($quote->client->block){{ $quote->client->block }} @endif {{ $quote->client->street ?? 'No Street' }}</span>
                                    @if($quote->client->unitnumber)<span>#{{ $quote->client->unitnumber }}</span>@endif
                                    <span>{{ $quote->client->country_code ?? 'No Country' }} {{ $quote->client->postalcode ?? 'No Postal Code' }}</span>
                                </td>
                                <td width="250">
                                    <img src="{{ asset('/assets/img/lefttoright.png') }}" width="80" height="80" />
                                </td>
                                <td width="250">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td><span class="name quote-bold quote-text-larger">{{ $quote->company->name ?? 'No Company Name' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="quote-bold">{{ $quote->company->crn ?? 'No Company Registration Number' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><span>{{ $quote->company->owner->full_name ?? 'No Company Owner Name' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($quote->company->address)
                                                    <span>@if($quote->company->address->block){{ $quote->company->address->block }} @endif {{ $quote->company->address->street ?? 'No Street' }}</span>
                                                    @if($quote->company->address->unitnumber)<span>#{{ $quote->company->address->unitnumber }}</span>@endif
                                                    <span>{{ $quote->company->address->postalcode ?? 'No Postal Code' }}</span>
                                                @else
                                                    <span>{{ $quote->company->owner->email ?? 'No Company Owner Email' }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="details">
                    <td>
                        <table cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; background-color: transparent;">
                            <tbody>
                                <tr class="bottom-line">
                                    <th width="800">
                                        Description
                                    </th>
                                    <th width="160">
                                        Quantity
                                    </th>
                                    <th width="200">
                                        Amount
                                    </th>
                                </tr>
                                @foreach($quote->items as $key => $item)
                                    <tr class="bottom-line">
                                        <td class="description" width="800">
                                            <span class="quote-bold">{{ $item->name }}</span>
                                            <p>{!! $item->description !!}</p>
                                        </td>
                                        <td class="quantity" width="160">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="amount" width="200">
                                            ${{ $item->moneyformatprice() }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td width="800"></td>
                                    <td class="summary bottom-line" width="160">
                                        Subtotal
                                    </td>
                                    <td class="amount bottom-line" width="200">
                                        ${{ $quote->calculatesubtotal() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="800"></td>
                                    <td class="summary bottom-line" width="160">
                                        Tax ({{ $quote->company->settings->tax ?? 0 }}%)
                                    </td>
                                    <td class="amount bottom-line" width="200">
                                        ${{ $quote->calculatetax() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="800"></td>
                                    <td class="summary bottom-line total quote-bold" width="160">
                                        Total
                                    </td>
                                    <td class="amount bottom-line quote-text-larger total-value" width="200">
                                        ${{ $quote->calculatetotal() }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr class="company-logo">
                    <td>
                        <img src="{{ \App\Library\Poowf\Unicorn::getStorageFile($quote->company->smlogo, [100,100]) }}" alt="{{ $quote->company->name ?? 'No Company Name' }}" width="100" height="100">
                    </td>
                </tr>

                <tr class="company-information">
                    <td>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="250"><span>{{ $quote->company->name ?? 'No Company Name' }}</span></td>
                                <td width="250" class="left-line"><span>{{ $quote->company->phone ?? 'No Phone Number' }}</span></td>
                                <td width="250" class="left-line"><span>{{ $quote->company->email ?? 'No Email' }}</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div class="quote break-before">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td><span>Terms & Conditions</span></td>
                    </tr>
                    <tr>
                        <td>{!! $quote->company->settings->quote_conditions !!}</td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>