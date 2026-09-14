<div {{ $attributes->class('overflow-x-auto') }}>
    <table class="w-full min-w-[520px] table-auto border-collapse text-left text-[0.9375rem]">
        <caption class="sr-only">Scartech Systems offices and phone numbers</caption>
        <thead>
            <tr class="border-b border-slate-300">
                <th scope="col" class="py-3 pr-6 text-sm font-semibold text-slate-900">Country</th>
                <th scope="col" class="py-3 pr-6 text-sm font-semibold text-slate-900">Office</th>
                <th scope="col" class="py-3 text-sm font-semibold text-slate-900">Phone</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($company['offices'] as $office)
                <tr class="border-b border-slate-200 align-top">
                    <th scope="row" class="py-4 pr-6 font-semibold text-slate-900">{{ $office['country'] }}</th>
                    <td class="py-4 pr-6 text-slate-700">
                        {{ $office['city'] }}
                        <span class="block text-sm text-slate-500">{{ $office['label'] }}</span>
                    </td>
                    <td class="py-4">
                        <ul class="space-y-1">
                            @foreach ($office['phones'] as $phone)
                                <li><a href="{{ Str::telHref($phone) }}" class="whitespace-nowrap text-brand-600 underline-offset-4 hover:text-brand-700 hover:underline">{{ $phone }}</a></li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            @foreach ($company['expansion'] as $country)
                <tr class="border-b border-slate-200">
                    <th scope="row" class="py-4 pr-6 font-semibold text-slate-500">{{ $country }}</th>
                    <td class="py-4 pr-6 text-slate-500" colspan="2">Opening soon</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
