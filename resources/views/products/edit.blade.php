@extends('adminlte::page')

@section('title', 'Редактировать продукт')

@section('content_header')
<h1>Редактировать продукт</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            {{-- Название --}}
            <div class="form-group">
                <label>Название</label>
                <input type="text" name="name"
                    value="{{ $product->name }}"
                    class="form-control">
            </div>

            {{-- Цена --}}
            <div class="form-group">
                <label>Цена</label>
                <input type="number"
                    step="0.01"
                    name="price"
                    value="{{ $product->price }}"
                    class="form-control">
            </div>

            {{-- Описание --}}
            <div class="form-group">
                <label>Описание</label>
                <textarea id="description"
                    name="description"
                    class="form-control">{{ $product->description }}</textarea>
            </div>

            {{-- Теги --}}
            <div class="form-group mt-4">
                <label><strong>Теги</strong></label>

                <div class="row mt-2">
                    @foreach($tags as $tag)
                    <div class="col-md-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input"
                                type="checkbox"
                                name="tags[]"
                                value="{{ $tag->id }}"
                                id="tag{{ $tag->id }}"
                                {{ $product->tags->contains($tag->id) ? 'checked' : '' }}>

                            <label class="form-check-label"
                                for="tag{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group mt-4">
                <label><strong>Добавить новый тег</strong></label>
                <div class="input-group mb-3">
                    <input type="text" id="newTag" class="form-control" placeholder="Введите название тега">
                    <button type="button" id="addTagBtn" class="btn btn-success">Добавить</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">
                <i class="fas fa-save"></i> Обновить
            </button>

        </form>

    </div>
</div>

@stop
@section('css')
<style>
    .ck-editor__editable {
        min-height: 350px !important;
        /* ставь сколько нужно */
    }
</style>
@endsection
@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const addTagBtn = document.getElementById('addTagBtn');
        const newTagInput = document.getElementById('newTag');
        const tagsRow = document.querySelector('.row.mt-2'); // контейнер чекбоксов

        addTagBtn.addEventListener('click', function() {
            const tagName = newTagInput.value.trim();
            if (tagName === '') return;

            // Создаём уникальный id
            const tagId = 'new_' + Math.floor(Math.random() * 1000000);

            // Создаём новый чекбокс
            const col = document.createElement('div');
            col.className = 'col-md-3 mb-2';
            col.innerHTML = `
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="tags_new[]" value="${tagName}" id="${tagId}" checked>
                <label class="form-check-label" for="${tagId}">${tagName}</label>
            </div>
        `;
            tagsRow.appendChild(col);

            // очищаем input
            newTagInput.value = '';
        });
    });
</script>

@endsection