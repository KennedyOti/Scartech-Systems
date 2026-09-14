<x-app-layout :title="'Edit '.$project->title">
    <x-portal::page-header :title="'Edit project'" :description="$project->title" :back="route('portal.projects.show', $project)" back-label="Back to project" />

    <form method="POST" action="{{ route('portal.projects.update', $project) }}" enctype="multipart/form-data" x-data="enquiryForm" @submit="submit">
        @csrf
        @method('PUT')

        @include('portal.projects.partials.form')

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-200 pt-6">
            <x-button :href="route('portal.projects.show', $project)" variant="secondary">Cancel</x-button>
            <x-button type="submit" ::disabled="sending">Save changes</x-button>
        </div>
    </form>
</x-app-layout>
