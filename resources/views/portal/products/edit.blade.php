<x-app-layout :title="'Edit '.$product->name">
    <x-portal::page-header title="Edit product" :description="$product->name" :back="route('portal.products.show', $product)" back-label="Back to product" />

    <form method="POST" action="{{ route('portal.products.update', $product) }}" enctype="multipart/form-data" x-data="enquiryForm" @submit="submit">
        @csrf
        @method('PUT')

        @include('portal.products.partials.form')

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-200 pt-6">
            <x-button :href="route('portal.products.show', $product)" variant="secondary">Cancel</x-button>
            <x-button type="submit" ::disabled="sending">Save changes</x-button>
        </div>
    </form>
</x-app-layout>
