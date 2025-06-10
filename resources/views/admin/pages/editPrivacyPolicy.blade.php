@extends('admin.layout.layout')
@php
        $title='Politique de confidentialité';
        $subTitle = 'Politique de confidentialité';
        $script = '<script src="' . asset('assets/js/editor.highlighted.min.js') . '"></script>
           <script src="' . asset('assets/js/editor.quill.js') . '"></script>
           <script src="' . asset('assets/js/editor.katex.min.js') . '"></script>
           <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Initialisation de Quill
                const quill = new Quill("#editor", {
                    modules: {
                        syntax: true,
                        toolbar: "#toolbar-container",
                    },
                    placeholder: "Compose an epic...",
                    theme: "snow",
                });

                // À la soumission du formulaire, injecte le contenu HTML dans le champ caché
                const form = document.querySelector("form");
                if (form) {
                    form.addEventListener("submit", function(e) {
                        const editorContent = quill.root.innerHTML;
                        document.querySelector("#editor-content").value = editorContent;
                    });
                }

                // Auto hide des alertes après 5 secondes
                setTimeout(function() {
                    var alerts = document.querySelectorAll(".alert");
                    alerts.forEach(function(alert) {
                        var bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    });
                }, 5000);
            });
           </script>';
@endphp

@section('content')

    <div class="card basic-data-table radius-12 overflow-hidden">
        <form action="{{ route('updatePrivacyPolicy', $page->id) }}" method="POST" onsubmit="document.querySelector('#editor-content').value = document.querySelector('#editor .ql-editor').innerHTML;">
            @csrf
            @method('PUT')
            <input type="hidden" name="content" id="editor-content">
            <div class="card-body p-0">

            <!-- Editor Toolbar Start -->
            <div id="toolbar-container">
                <span class="ql-formats">
                    <select class="ql-font"></select>
                    <select class="ql-size"></select>
                </span>
                <span class="ql-formats">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-underline"></button>
                    <button class="ql-strike"></button>
                </span>
                <span class="ql-formats">
                    <select class="ql-color"></select>
                    <select class="ql-background"></select>
                </span>
                <span class="ql-formats">
                    <button class="ql-script" value="sub"></button>
                    <button class="ql-script" value="super"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-header" value="1"></button>
                    <button class="ql-header" value="2"></button>
                    <button class="ql-blockquote"></button>
                    <button class="ql-code-block"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                    <button class="ql-indent" value="-1"></button>
                    <button class="ql-indent" value="+1"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-direction" value="rtl"></button>
                    <select class="ql-align"></select>
                </span>
                <span class="ql-formats">
                    <button class="ql-link"></button>
                    <button class="ql-image"></button>
                    <button class="ql-video"></button>
                    <button class="ql-formula"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-clean"></button>
                </span>
            </div>
            <!-- Editor Toolbar Start -->
            <!-- Editor start -->
            <div id="editor">
            
                {!! $page->content !!}

       
            </div>
            @if ($errors->any())
            <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-5 fw-semibold text-lg radius-12 d-flex align-items-center justify-content-between" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- Edit End -->

            <input type="hidden" name="id" value="{{ $page->id }}">
            <input type="hidden" name="slug" value="{{ $page->slug }}">
            <input type="hidden" name="title" value="{{ $page->title }}">
        </div>

        <div class="card-footer p-24 bg-base border border-bottom-0 border-end-0 border-start-0">
            <div class="d-flex align-items-center justify-content-center gap-3">
                <a href="javascript:history.back()" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-50 py-11 radius-8">
                    Retour
                </a>
                <a href="{{ route('privacyPolicy') }}" target="_blank" class="btn btn-secondary border border-secondary-600 text-md px-56 py-12 radius-8">
                    Aperçu
                </a>
                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-28 py-12 radius-8">
                    Enregistrer
                </button>
            </div>
        </div>
    </form>
</div>
    
@endsection

