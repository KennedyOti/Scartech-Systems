<x-app-layout title="Add product">
    <x-portal::page-header title="Add product" :back="route('portal.products.index')" back-label="All products" />

    <form method="POST" action="{{ route('portal.products.store') }}" enctype="multipart/form-data" x-data="enquiryForm" @submit="submit">
        @csrf

        @include('portal.products.partials.form')

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-200 pt-6">
            <x-button :href="route('portal.products.index')" variant="secondary">Cancel</x-button>
            <x-button type="submit" icon="plus" ::disabled="sending">Add product</x-button>
        </div>
    </form>
</x-app-layout>
