@extends('adminlte::page')

@section('title', 'Детали продукта')

@section('content_header')
    <h1>Детали продукта</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">{{ $product->name }}</h3>

        <div>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Редактировать
            </a>

            <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th style="width: 200px">ID</th>
                <td>{{ $product->id }}</td>
            </tr>

            <tr>
                <th>Название</th>
                <td>{{ $product->name }}</td>
            </tr>

            <tr>
                <th>Цена</th>
                <td>{{ number_format($product->price, 2) }}</td>
            </tr>

            <tr>
                <th>Создан</th>
                <td>{{ $product->created_at }}</td>
            </tr>

            <tr>
                <th>Обновлён</th>
                <td>{{ $product->updated_at }}</td>
            </tr>
        </table>

        <hr>

        <h4>Описание</h4>
        <div class="p-3 bg-light border" style="min-height: 150px">
            {!! $product->description !!}
        </div>

    </div>
</div>

@stop