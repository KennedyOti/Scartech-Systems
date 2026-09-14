<x-app-layout title="Add project">
    <x-portal::page-header title="Add project" :back="route('portal.projects.index')" back-label="All projects" />

    <form method="POST" action="{{ route('portal.projects.store') }}" enctype="multipart/form-data" x-data="enquiryForm" @submit="submit">
        @csrf

        @include('portal.projects.partials.form')

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-200 pt-6">
            <x-button :href="route('portal.projects.index')" variant="secondary">Cancel</x-button>
            <x-button type="submit" icon="plus" ::disabled="sending">Add project</x-button>
        </div>
    </form>
</x-app-layout>
