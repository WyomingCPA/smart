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

            <div class="form-group">
                <label>Название</label>
                <input type="text" name="name" value="{{ $product->name }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Цена</label>
                <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Описание</label>
                <textarea id="description" name="description" class="form-control">
                {{ $product->description }}
                </textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Обновить
            </button>
        </form>

    </div>
</div>
@stop
@section('css')
<style>
    .ck-editor__editable {
        min-height: 350px !important; /* ставь сколько нужно */
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
</script>
@endsection